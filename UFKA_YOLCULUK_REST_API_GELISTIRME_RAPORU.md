# Ufka Yolculuk REST API Geliştirme & İyileştirme Raporu
**Doküman Türü:** Backend API Gereksinim & Teknik Spesifikasyon Raporu  
**Hedef Servis:** Ufka Yolculuk Merkezi REST API (`https://ufkayolculuk.com/rest/get/`)  
**Tarih:** Ekim 2026  
**Durum:** Hazır / Onay Bekliyor  

---

## 1. Yönetici Özeti (Executive Summary)

Ufka Yolculuk web arayüzünde kullanıcı portalı (**Sınavlarım & Sonuçlarım**, **Davet Et / Vesile Olduklarım**, **Takım Lideri Portalı** ve **Sertifikalarım**) sayfaları kullanıcı deneyimine sunulmuştur. 

Mevcut REST API (`https://ufkayolculuk.com/rest/get/`) üzerinde yapılan entegrasyon testleri sonucunda:
- `getUserResults/{userId}` ve `getUserData/{userId}` gibi temel uç noktaların başarıyla çalıştığı ve sınav puanları/derecelerini sağladığı görülmüştür.
- Ancak **Davet Edilenler Listesi (Vesile Olduklarım)**, **Takım Lideri Puanı/Danışan İstatistikleri** ve **Sertifika PDF/Doğrulama Verileri** noktalarında API tarafında eksiklikler bulunmaktadır.

Bu rapor; backend API ekibinin söz konusu eksiklikleri hızlıca giderebilmesi için gereken **yeni uç noktaları (endpoints)**, **parametreleri**, **JSON şemalarını** ve **SQL sorgu önerilerini** eksiksiz olarak sunmaktadır.

---

## 2. API'deki Mevcut Durum vs. Eksik Kalan Alanlar

| Modül / Ekran | Mevcut API Durumu | Eksik Kalan Alan | Gereken API Çözümü |
|---|---|---|---|
| **Davet Et / Vesile Olduklarım** | `getUserData` içinde kullanıcının kendi `inviter_code` değeri dönüyor. | Bu kodla kayıt olan yarışmacıların listesi (Ad, Soyad, Okul, Kategori, Tarih) **dönmüyor**. | Yeni uç nokta: `getInvitedUsers/{userId}` |
| **Takım Lideri Portalı** | `is_consultant` (1/0) ve `consultant_type` ("DİĞER") dönüyor. | Danışanlardan kazanılan **toplam liderlik puanı** ve **takım üye sayısı** dönmüyor. | `getUserData` genişletmesi veya `getLeaderStats/{userId}` |
| **Sınavlarım & Sonuçlarım** | `getUserResults` genel puan ve dereceleri dönüyor. | Sınav henüz açıklanmadığında `null` dönüyor; sonuç durum bilgisi (`status: pending`) yok. | `user_summary.status` ve `publish_date` eklenmesi |
| **Sertifikalarım** | `getCertificates/{userId}` boş dizi dönebiliyor. | Doğrulama kodu, PDF indirme URL'si ve başarı sertifikası rozet verisi eksik. | `certificates[]` şemasına PDF URL & doğrulama alanları |
| **API Güvenliği** | Hızlı isteklerde `429 Enumeration Lockout` veriyor. | Meşru frontend sunucusu da kullanıcılar adına sorgu attığında geçici bloklanabiliyor. | Webhook / Bearer Token için Whitelist tanımlanması |

---

## 3. Yeni Eklenecek Uç Noktalar ve Teknik Spesifikasyonlar

### Uç Nokta 1: `getInvitedUsers/{userId}` (Vesile Olduklarım Listesi)
> **Öncelik:** YÜKSEK (Kritik)  
> **Amaç:** Yarışmacının kendi davet linkiyle (`inviter_code`) veya referansıyla sisteme kaydolmuş kişileri listelemek.

- **URL:** `GET /rest/get/getInvitedUsers/{user_id}` (veya `POST /rest/getInvitedUsers`)
- **Yetkilendirme:** Bearer Token veya HTTP Basic Auth
- **URL / Query Parametreleri:**
  - `user_id` *(int, Zorunlu)*: Davet eden yarışmacının ID'si.
  - `limit` *(int, Opsiyonel, Varsayılan: 25)*: Sayfa başına kayıt.
  - `offset` *(int, Opsiyonel, Varsayılan: 0)*: Sayfalama başlangıcı.
  - `category_id` *(int, Opsiyonel)*: Kategori filtresi.

#### Örnek SQL Sorgusu (Backend İçi):
```sql
SELECT 
    u.id,
    u.name,
    u.surname,
    c.title AS category_title,
    s.name AS school_name,
    ct.name AS city_name,
    co.name AS county_name,
    u.create_time AS registration_date
FROM users u
LEFT JOIN uy_categories c ON u.uy_category_id = c.id
LEFT JOIN schools s ON u.school_id = s.id
LEFT JOIN cities ct ON u.city_id = ct.id
LEFT JOIN counties co ON u.county_id = co.id
WHERE u.inviter_user_id = :user_id 
   OR u.inviter_code = (SELECT inviter_code FROM users WHERE id = :user_id LIMIT 1)
ORDER BY u.create_time DESC
LIMIT :limit OFFSET :offset;
```

#### Beklenen JSON Yanıtı (HTTP 200):
```json
{
  "status": true,
  "code": 200,
  "user_id": 48296,
  "invite_code": "UYCOPBLLH1YDO",
  "total_count": 3,
  "invited_users": [
    {
      "id": 10521,
      "full_name": "Ahmet Yılmaz",
      "category": "Ortaokul Kategorisi",
      "school": "Atatürk Ortaokulu",
      "city": "İstanbul",
      "registration_date": "2026-03-14 15:30:00"
    },
    {
      "id": 10522,
      "full_name": "Zeynep Kaya",
      "category": "Lise Kategorisi",
      "school": "Kadıköy Anadolu Lisesi",
      "city": "İstanbul",
      "registration_date": "2026-03-15 10:12:00"
    }
  ]
}
```

---

### Uç Nokta 2: `getLeaderStats/{userId}` (Takım Lideri Puanı ve Üyeleri)
> **Öncelik:** YÜKSEK  
> **Amaç:** Danışman/Takım Lideri olan kullanıcının takım istatistiklerini ve liderlik puanını hesaplayıp dönmek.

- **URL:** `GET /rest/get/getLeaderStats/{user_id}` (veya mevcut `getUserData/{userId}` içerisine ek alan olarak)
- **Yetkilendirme:** Bearer Token veya HTTP Basic Auth

#### Beklenen JSON Yanıtı (HTTP 200):
```json
{
  "status": true,
  "code": 200,
  "user_id": 48296,
  "leader_info": {
    "is_leader": true,
    "consultant_code": "UYCOPBLLH1YDO",
    "consultant_type": "DİĞER",
    "leader_score": "142.5000000",
    "leader_rank_turkey": 145,
    "leader_rank_city": 18,
    "total_students": 24,
    "active_exam_students": 19,
    "average_team_score": 78.45
  },
  "students_sample": [
    {
      "user_id": 10521,
      "name": "Ahmet Y.",
      "category": "Ortaokul",
      "score": 85.50
    }
  ]
}
```

---

### Uç Nokta 3: `getUserResults/{userId}` İyileştirmesi (Sınav Durum ve Açıklanma Bilgisi)
> **Öncelik:** ORTA  
> **Amaç:** Sınav tamamlanmış fakat henüz sonuçlar açıklanmamışsa `null` yerine açıklayıcı durum bildirmek.

#### Önerilen Güncelleme (`user_summary` İçine):
```json
{
  "status": true,
  "code": 200,
  "user_id": 48296,
  "user_summary": {
    "result_status": "announced", 
    "status_message": "Sınav sonuçları açıklandı.",
    "overall_score": 3.27,
    "global_rank": 48296,
    "city_rank": 460,
    "county_rank": 42,
    "school_rank": 3,
    "total_participants_global": 185420,
    "total_participants_city": 14280
  },
  "total_exams": 1,
  "exams": [
    {
      "form_id": 409222,
      "exam_id": 78,
      "title": "14. Ufka Yolculuk Online Deneme Sınavı",
      "correct_answers": 32,
      "wrong_answers": 6,
      "empty_answers": 2,
      "result_point": 3.27,
      "category_global_rank": 48296,
      "category_city_rank": 460,
      "certificate_url": "https://yonetim.ufkayolculuk.com/certificates/pdf/409222.pdf"
    }
  ]
}
```

---

### Uç Nokta 4: `getCertificates/{userId}` İyileştirmesi (Resmi Doğrulama & İndirme)
> **Öncelik:** ORTA  
> **Amaç:** Üretilen resmi katılım/başarı belgelerinin PDF linklerini ve barkod doğrulama kodlarını sunmak.

#### Beklenen JSON Yapısı:
```json
{
  "status": true,
  "code": 200,
  "user_id": 48296,
  "total": 2,
  "certificates": [
    {
      "id": 101,
      "type": "participation",
      "title": "14. Ufka Yolculuk Resmi Katılım Belgesi",
      "year": 2026,
      "category_name": "Yetişkin Kategorisi",
      "verification_code": "UY-KB-9A8B7C6D",
      "verify_url": "https://ufkayolculuk.com/dogrula/UY-KB-9A8B7C6D",
      "pdf_url": "https://yonetim.ufkayolculuk.com/uploads/certificates/2026/UY-KB-9A8B7C6D.pdf"
    },
    {
      "id": 102,
      "type": "achievement",
      "title": "14. Ufka Yolculuk Başarı Sertifikası (İl Derecesi)",
      "year": 2026,
      "category_name": "Yetişkin Kategorisi",
      "verification_code": "UY-BS-1E2F3A4B",
      "verify_url": "https://ufkayolculuk.com/dogrula/UY-BS-1E2F3A4B",
      "pdf_url": "https://yonetim.ufkayolculuk.com/uploads/certificates/2026/UY-BS-1E2F3A4B.pdf"
    }
  ]
}
```

---

## 4. Güvenlik ve Rate Limit İyileştirmesi (Enumeration Lockout)

Mevcut API'de art arda istek atıldığında:
`{"status":false,"code":429,"error":"Enumeration Lockout","message":"Kullanıcı hesabı tarama şüphesi nedeniyle erişiminiz geçici olarak engellendi. (30 saniye)"}`
hatası dönmektedir.

**Geliştirme Önerisi:**
- API istemcisi olan web uygulaması resmi sunucu IP'si (`91.108.101.21`) veya `Bearer uy_act_...` token'ı ile geldiğinde bu sınırlamanın kaldırılması veya eşik değerinin artırılması gerekmektedir.
- Böylece sisteme aynı anda giriş yapan yüzlerce yarışmacının portal verileri tıkanmadan anlık çekilebilecektir.

---

## 5. Web Sitesi Tarafında Yapılan Hazırlık

Web sitesi tarafında (`UfkaApiService` ve `Kullanici.php`) tüm bu servisleri karşılayacak mimari kodlanmıştır:
1. `getUserResults/{userId}` servisi hemen bağlanmış olup gerçek sınav puanları ve dereceleri canlı çekilmektedir.
2. `getUserData/{userId}` servisinden gerçek `inviter_code` ve `consultant_type` bilgileri dinamik bağlanmıştır.
3. Backend ekibi yukarıda belirtilen `getInvitedUsers/{userId}` ve `getLeaderStats/{userId}` servislerini açtığı anda, web sitemiz tek bir satır kod değiştirmeye gerek kalmaksızın otomatik olarak canlı verileri dolduracaktır.

---
*Rapor Sonu - Ufka Yolculuk Web Geliştirme Ekibi*
