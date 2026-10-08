# 📚 Ufka Yolculuk REST API — Resmi ve Kapsamlı Teknik Dokümantasyon

> **Belge Sürümü:** 2.0 (Resmi API Kataloğu & Revizyon Kılavuzu)  
> **Kaynak Dokümantasyon Portalı:** `https://ufkayolculuk.com/rest/docs`  
> **Son İnceleme & Derleme Tarihi:** 08 Ekim 2026  
> **Aktif Proje Kapsamı:** `project_ufkayolculuk`  
> **Base REST API URL:** `https://ufkayolculuk.com/rest/get/`  
> **Medya & Yönetim Sunucusu:** `https://yonetim.ufkayolculuk.com/`  
> **Yetkili API Kullanıcısı:** `uy_Rest-Worker`  

---

## 📌 1. Giriş ve Mimari Genel Bakış

Ufka Yolculuk Bilgi ve Kültür Yarışması REST API platformu; sınav yönetiminden yarışmacı profillerine, e-kitap okuma takibinden canlı test oturumlarına, 81 il yerel ödüllerinden zengin medya ve podcast yayınlarına kadar tüm ekosistemi tek merkezden yöneten **Headless (RESTful)** bir mimaridir.

Tüm servisler JSON formatında çıktı üretir ve `application/json; charset=utf-8` başlığı ile döner. Veri güvenliği, sunucu kaynaklarının korunması ve servis sürekliliği için mimari katmanında sıkı güvenlik duvarları ve hız sınırları uygulanmaktadır.

---

## 🛡️ 2. Güvenlik, WAF ve Hız Sınırları (Security & Rate Limits)

API uç noktaları DDoS, kaba kuvvet (brute-force) ve web enjeksiyonlarına karşı aktif **WAF (Web Application Firewall)** ve kayan pencere (**Sliding-Window**) hız sınırlama motoru ile korunmaktadır:

| Güvenlik Kuralı | Teknik Açıklama & Kriter | Engelleme & HTTP Davranışı |
| :--- | :--- | :--- |
| **Hız Sınırı (Rate Limit)** | Her istemci IP adresi için dakikada maksimum **120 istek** hakkı tanımlıdır. | Aşılması durumunda `HTTP 429 Too Many Requests` döner. `X-RateLimit-Limit`, `X-RateLimit-Remaining` ve `Retry-After` başlıkları iletilir. |
| **Brute-Force Koruması** | 10 dakika içinde 5 kez üst üste hatalı kimlik bilgisi gönderen IP adresleri **15 dakika boyunca kilitlenir**. | `HTTP 429` döner ve yanıtta kilidin açılacağı kalan saniye bildirilir. |
| **WAF Filtreleme** | SQL Injection, XSS, Path Traversal, Null-Byte ve güvenlik tarayıcıları (`sqlmap`, `nikto` vb.) imza düzeyinde filtrelenir. | İstek anında düşürülerek `HTTP 403 Forbidden` yanıtı verilir. |
| **Veri Kodlaması** | Tüm yanıtlar standart **UTF-8 JSON** formatındadır. | `Content-Type: application/json; charset=utf-8` |

### Standart Hata Yanıt Formatı (JSON)
```json
{
  "status": false,
  "code": 429,
  "message": "Hız sınırı aşıldı. Lütfen 45 saniye sonra tekrar deneyiniz.",
  "retry_after": 45
}
```

---

## ⚠️ 3. Kritik Değişiklikler ve Revizyon Notları (Changelog & Diff Matrisi)

07-08 Ekim 2026 itibarıyla API'de yapılan değişikliklerin özet karşılaştırması:

| Uç Nokta / Alan | Önceki Durum / Eski Davranış | Yeni Durum / Yeni Davranış | Seviye & Etki |
| :--- | :--- | :--- | :--- |
| **Kimlik Doğrulama** | Her istekte HTTP Basic Auth veya şifre gönderiliyordu. | **Bearer Token standardı geldi** (`POST /rest/get/token`). Basic Auth **DEPRECATED** (kullanımdan kaldırılıyor) ilan edildi. | 🔴 **Kritik Güvenlik (CWE-522)** |
| **`getImportantDates`** | API'de yoktu; `getExams` üzerinden türetilip koda statik tarihler gömülüyordu. | **YENİ SERVİS:** `web_dates` tablosundan dinamik tarihler, ISO sayaç hedefleri ve `{tarih_key}` prefix'leri döner. | 🟢 **Yeni Uç Nokta** |
| **`getMediaContents`** | API'de yoktu; `getWebContents` taranıp kodda statik podcast mock'ları tutuluyordu. | **YENİ SERVİS:** `web_medias` tablosundan aktif YouTube ve video/podcast kayıtlarını süreleriyle döner. | 🟢 **Yeni Uç Nokta** |
| **`getSliders`** | API'de yoktu; ana sayfa hero slaytları statik HTML idi. | **YENİ SERVİS:** `web_sliders` tablosundan mobil & masaüstü slider listesini limit parametresiyle döner. | 🟢 **Yeni Uç Nokta** |
| **`getWebMenus`** | API'de yoktu; menüler kodda sabitti. | **YENİ SERVİS:** `web_menus` tablosundaki tüm aktif menüleri ve `with_items=1` ile hiyerarşik ağaçları döner. | 🟢 **Yeni Uç Nokta** |
| **`getQuestions`** | Parametresiz çağrılabiliyordu. | **ZORUNLU PARAMETRE:** `category_id` artık **zorunludur** (`/getQuestions/{category_id}`). Parametresiz çağrı boş döner. | 🟡 **Kırıcı Değişiklik (Breaking)** |
| **`getWebContents`** | 111 içerik toplu çekilip istemcide filtreleniyordu. | **SUNUCU FİLTRESİ:** `type` (`annoucement`, `news`, `sss`), `category_id` ve `slug` parametreleri sunucu tarafında işlenir. | ⚡ **Performans Optimizasyonu** |
| **`getAwards`** | İl filtreleme opsiyonları netleşmemişti. | **RESMİ PARAMETRELER:** `city_id` ve `type` (`country` / `city`) parametreleri resmileştirildi. | ⚡ **Veri İyileştirmesi** |
| **`getMenu`** | Sadece header/footer alıyordu. | **ÇOKLU DİL DESTEĞİ:** Menü ID'si veya slug ile çağrılabilir; `lang` (`tr`, `en`) parametresiyle çevrilmiş başlıklar döner. | ⚡ **Yeni Özellik** |
| **`getExams`** | Tüm sınav kayıtları gelebiliyordu. | **YAYIN KURALI:** Sadece `isPublished = 1` VE `iswebsitepublished = 1` olan aktif sınavlar filtrelenerek listelenir. | ⚡ **Filtre İyileştirmesi** |

---

## 🔑 4. Kimlik Doğrulama & Token Mimarisi (Bearer Auth Rehberi)

### 4.1. Token Yaşam Döngüsü
1. **Access Token:** 2 saat (7200 saniye) geçerlidir. Her API isteğinde `Authorization: Bearer <access_token>` başlığı ile gönderilir.
2. **Refresh Token:** 14 gün geçerlidir, tek kullanımlıktır. Access token süresi dolduğunda şifre göndermeden `POST /rest/get/refresh` servisiyle yeni bir token çifti almak için kullanılır.
3. **Revoke (İptal):** Oturum kapatıldığında veya token sızdığında `POST /rest/get/revoke` servisiyle token veritabanında geçersiz kılınır.

### 4.2. cURL ile Bearer Token Örnek Akışı
```bash
# 1. Adım: Token Al
curl -X POST "https://ufkayolculuk.com/rest/get/token" \
     -d "username=uy_Rest-Worker&password=UfkA_Yol-1448&token_name=Web-Client"

# Yanıt: {"access_token": "uy_act_...", "refresh_token": "uy_ref_..."}

# 2. Adım: Servisleri Bearer Başlığı ile Çağır
curl -X GET "https://ufkayolculuk.com/rest/get/getBooks" \
     -H "Authorization: Bearer uy_act_6b42c41f6783c3e2cf42a8207034f5dbe0a1724ae79453ea8af3ef8f63b68c68"
```

---

## 📂 5. Tam API Uç Noktaları Kataloğu (26 Servis)

### 📁 Kimlik Doğrulama & Token Yönetimi

#### 1. `POST` /rest/get/token
- **Başlık / Tanım:** token
- **URL:** `https://ufkayolculuk.com/rest/get/token`
- **Kısa Özet:** Sabit şifre yerine güvenli, süreli (2 saat) Bearer Token ve 14 günlük Refresh Token üretir.
- **Detaylı Açıklama:** API servislerini çağırmadan önce bu uç noktadan access_token alınız. Alınan token tüm servislere Authorization: Bearer başlığı ile iletilir.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `username` | `string` | **Opsiyonel** | API Kullanıcı Adı |
| `password` | `string` | **Opsiyonel** | API Şifresi |
| `token_name` | `string` | **Opsiyonel** | İstemci / Entegrasyon Adı (Örn: Mobil Entegratör) |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/token" -d "username=USER" -d "password=PASS"
```

**Örnek JSON Yanıtı:**
```json
{
    "status": true,
    "token_type": "Bearer",
    "access_token": "uy_act_8f7b3c2e1d0a...",
    "expires_in": 7200,
    "expires_at": "2026-10-07 14:00:00",
    "refresh_token": "uy_ref_9e8d7c6b5a4...",
    "refresh_expires_in": 1209600
}
```

---

#### 2. `POST` /rest/get/refresh
- **Başlık / Tanım:** refresh
- **URL:** `https://ufkayolculuk.com/rest/get/refresh`
- **Kısa Özet:** Süresi dolan Access Token'ı şifre göndermeden tek kullanımlık Refresh Token ile yeniler.
- **Detaylı Açıklama:** Eski refresh token tek kullanımlık olarak geçersiz kılınır ve yeni bir token çifti döner.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `refresh_token` | `string` | **Opsiyonel** | Önceki token isteğinde alınan refresh_token |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/refresh" -d "refresh_token=uy_ref_..."
```

**Örnek JSON Yanıtı:**
```json
{
    "status": true,
    "token_type": "Bearer",
    "access_token": "uy_act_new123...",
    "expires_in": 7200,
    "refresh_token": "uy_ref_new456..."
}
```

---

#### 3. `POST` /rest/get/revoke
- **Başlık / Tanım:** revoke
- **URL:** `https://ufkayolculuk.com/rest/get/revoke`
- **Kısa Özet:** Mevcut token'ı anında iptal ederek yetkisiz erişimi engeller.
- **Detaylı Açıklama:** Token çalınması veya oturum kapatılması durumunda token anında veritabanında geçersiz kılınır.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `token` | `string` | **Opsiyonel** | İptal edilecek token (veya Authorization Bearer başlığı) |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/revoke" -H "Authorization: Bearer uy_act_..."
```

**Örnek JSON Yanıtı:**
```json
{
    "status": true,
    "message": "Token başarıyla iptal edildi (revoked)."
}
```

---

### 📁 Sınavlar ve Yarışma Yönetimi

#### 4. `POST | GET` /rest/get/getExams
- **Başlık / Tanım:** getExams
- **URL:** `https://ufkayolculuk.com/rest/get/getExams`
- **Kısa Özet:** Sadece hem yayında (isPublished) hem de web sitesinde yayında (iswebsitepublished) olan aktif sınavları listeler.
- **Detaylı Açıklama:** Ufka Yolculuk yarışma ve deneme sınavlarını çeker. Gizli olan veya yayında olmayan sınavlar filtrelenir.

**İstek Parametreleri:** Parametre gerektirmez (boş GET / POST).

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getExams" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
[
    {
        "id": "78",
        "title": "11. Ufka Yolculuk Deneme Sınavı",
        "duration": "50",
        "rest_time_duration": "10",
        "publish_time": "2026-04-10 10:00:00",
        "end_time": "2026-04-10 20:00:00",
        "is_published": "1",
        "is_website_published": "1",
        "question_number": "40"
    }
]
```

---

### 📁 Soru Havuzu ve Sınav Kategorileri

#### 5. `POST | GET` /rest/get/getQuestions
- **Başlık / Tanım:** getQuestions
- **URL:** `https://ufkayolculuk.com/rest/get/getQuestions`
- **Kısa Özet:** Yayınlanmış soruları belirtilen kategoriye göre filtreleyerek çeker. category_id zorunludur.
- **Detaylı Açıklama:** Öğrencilerin çözmesi için hazırlanan soru havuzunu döner. Tüm soruların toplu çekilmesini engellemek için category_id zorunludur.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `category_id` | `int (Zorunlu)` | **Zorunlu** | Ufka Yolculuk yarışma kategorisi ID (Örn: 1, 2, 3) |
| `type` | `string (Varsayılan: mini-deneme)` | **Opsiyonel** | Soru tipi: mini-deneme, final vb. |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getQuestions/3" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
[
    {
        "id": "101",
        "body": "Soru metni burada yer alır...",
        "a": "Cevap A",
        "b": "Cevap B",
        "c": "Cevap C",
        "d": "Cevap D",
        "categories": [
            {
                "id": "3",
                "name": "Ortaokul Kategorisi"
            }
        ]
    }
]
```

---

#### 6. `POST | GET` /rest/get/getExamCategories
- **Başlık / Tanım:** getExamCategories
- **URL:** `https://ufkayolculuk.com/rest/get/getExamCategories`
- **Kısa Özet:** Aktif olan sınav kategorilerini sıralı olarak döner (İlkokul, Ortaokul, Lise, Yetişkin vb.).
- **Detaylı Açıklama:** Yarışmacının dahil olduğu yaş/okul kategorisini belirlemek ve sınav listesini filtrelemek için kullanılır.

**İstek Parametreleri:** Parametre gerektirmez (boş GET / POST).

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getExamCategories" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
[
    {
        "id": "1",
        "name": "İlkokul Kategorisi",
        "order_id": "1",
        "is_published": "1"
    },
    {
        "id": "2",
        "name": "Ortaokul Kategorisi",
        "order_id": "2",
        "is_published": "1"
    },
    {
        "id": "3",
        "name": "Lise Kategorisi",
        "order_id": "3",
        "is_published": "1"
    }
]
```

---

### 📁 Web İçerikleri, Medya, Slider ve Menü Yönetimi

#### 7. `GET / POST` /rest/get/getWebContents
- **Başlık / Tanım:** getWebContents
- **URL:** `https://ufkayolculuk.com/rest/get/getWebContents`
- **Kısa Özet:** Web sitesindeki aktif içerikleri, duyuruları, haberleri ve bağlı kategorilerini toplu olarak döner.
- **Detaylı Açıklama:** web_contents tablosundan sadece kullanılabilir alanları (id, order_id, type, title, slug, description, subtitles, body, publish_time, redirect_url) ve içeriklerin ait olduğu kategorileri döner.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `type` | `string (Opsiyonel)` | **Opsiyonel** | İçerik türü: content, announcement vb. |
| `category_id` | `int (Opsiyonel)` | **Opsiyonel** | Web kategori ID filtrelemesi |
| `slug` | `string (Opsiyonel)` | **Opsiyonel** | Tekil içerik için slug |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getWebContents" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
[
    {
        "id": "55",
        "type": "content",
        "title": "Genel Bilgiler",
        "slug": "hakkimizda",
        "description": "Yarışma hakkında...",
        "body": "İçerik HTML metni...",
        "categories": [
            {
                "id": "1",
                "title": "Kurumsal",
                "slug": "kurumsal"
            }
        ]
    }
]
```

---

#### 8. `GET / POST` /rest/get/getAwards
- **Başlık / Tanım:** getAwards
- **URL:** `https://ufkayolculuk.com/rest/get/getAwards`
- **Kısa Özet:** Türkiye geneli ve il bazlı yarışma ödüllerini kategori ve derece detaylarıyla döner. İle göre filtrelenebilir.
- **Detaylı Açıklama:** uy_awards tablosundan ödül bilgilerini, il adını, kategori adını ve ödül listesini (JSON ayrıştırılmış temiz dizi) döner. city_id parametresi ile belirli bir ilin ve genel ödüllerin filtrelenmesini sağlar.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `city_id` | `int (Opsiyonel)` | **Opsiyonel** | Plaka kodu veya il ID (örn: 34 İstanbul, 6 Ankara). Belirtilirse o il ve Türkiye ödülleri döner. |
| `type` | `string (country / city)` | **Opsiyonel** | Ödül kapsamı türü |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getAwards/34" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
[
    {
        "id": "8",
        "type": "country",
        "city_name": null,
        "category_name": "İlkokul",
        "awards": [
            {
                "award": "Umre",
                "type": "other"
            },
            {
                "award": "15.000",
                "type": "money"
            }
        ]
    }
]
```

---

#### 9. `GET / POST` /rest/get/getWebCategories
- **Başlık / Tanım:** getWebCategories
- **URL:** `https://ufkayolculuk.com/rest/get/getWebCategories`
- **Kısa Özet:** Web sitesindeki aktif kategorileri, alt kategorileri ve içerik sayılarıyla döner.
- **Detaylı Açıklama:** web_categories tablosundaki kategorileri listeler. parent_id ile alt kategoriler filtrelenebilir veya tree=1 ile ağaç yapısında alınabilir.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `parent_id` | `int / string (Opsiyonel)` | **Opsiyonel** | Üst kategori ID veya "root" (sadece ana kategoriler) |
| `slug` | `string (Opsiyonel)` | **Opsiyonel** | Kategori slug filtresi |
| `tree` | `int (1 veya 0)` | **Opsiyonel** | 1 gönderilirse alt kategoriler iç içe sub_categories dizisi olarak döner |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getWebCategories" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
[
    {
        "id": "49",
        "parent_id": null,
        "title": "Ufka Yolculuk",
        "slug": "ufka-yolculuk",
        "content_count": 7,
        "sub_categories": []
    }
]
```

---

#### 10. `POST | GET` /rest/get/webCategories
- **Başlık / Tanım:** webCategories
- **URL:** `https://ufkayolculuk.com/rest/get/webCategories`
- **Kısa Özet:** getWebCategories servisiyle aynı işlevi görür.
- **Detaylı Açıklama:** webCategories adıyla kategori listesini döner.

**İstek Parametreleri:** Parametre gerektirmez (boş GET / POST).

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/webCategories" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
[
    {
        "id": "49",
        "title": "Ufka Yolculuk",
        "slug": "ufka-yolculuk"
    }
]
```

---

#### 11. `GET / POST` /rest/get/getSliders
- **Başlık / Tanım:** getSliders
- **URL:** `https://ufkayolculuk.com/rest/get/getSliders`
- **Kısa Özet:** Web sitesindeki aktif ana sayfa hero sliderlarını (masaüstü & mobil görseller, opsiyonel rozet, başlık, butonlar) döner.
- **Detaylı Açıklama:** web_sliders tablosundaki aktif sliderları sıralamaya göre listeler. Tüm alanlar opsiyonel olup görsel veya metin/buton içerikleriyle tam ve mobil uyumlu döner.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `limit` | `int (Opsiyonel)` | **Opsiyonel** | Dönecek maksimum slider sayısı (URI veya POST/GET limit parametresi) |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getSliders" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
[
    {
        "id": "1",
        "title": "Gelişmiş Online Sınav",
        "title_highlight": "Sistemiyle Tanışın",
        "badge_text": "DİJİTAL SINAV PORTALI",
        "badge_color": "badge-cyan",
        "subtext": "Dilediğin cihazdan kolayca katıl, anında performans analizini gör ve Türkiye geneli sıralamada zirveye tırman.",
        "image": "uploads/sliders/hero-desktop.jpg",
        "image_url": "https://ufkayolculuk.com/uploads/sliders/hero-desktop.jpg",
        "mobile_image": "uploads/sliders/hero-mobile.jpg",
        "mobile_image_url": "https://ufkayolculuk.com/uploads/sliders/hero-mobile.jpg",
        "slider_link": "",
        "target_blank": 0,
        "order_no": 1,
        "has_overlay_content": true,
        "badge": {
            "text": "DİJİTAL SINAV PORTALI",
            "color": "badge-cyan",
            "dot_color": "cyan"
        },
        "title_data": {
            "main": "Gelişmiş Online Sınav",
            "highlight": "Sistemiyle Tanışın",
            "html": "Gelişmiş Online Sınav Sistemiyle Tanışın"
        },
        "action_buttons": [
            {
                "text": "Deneme Sınavına Katıl",
                "url": "#soru-coz",
                "target": "_self",
                "style": "btn-hero-primary"
            },
            {
                "text": "Sınav Kılavuzu",
                "url": "https://team.tkmdev.com/ufkayolculuk-demo/sayfa-detay",
                "target": "_blank",
                "style": "btn-hero-glass"
            }
        ]
    }
]
```

---

#### 12. `GET / POST` /rest/get/getMediaContents
- **Başlık / Tanım:** getMediaContents
- **URL:** `https://ufkayolculuk.com/rest/get/getMediaContents`
- **Kısa Özet:** Web sitesindeki aktif podcast ve video içeriklerini listeler.
- **Detaylı Açıklama:** web_medias tablosundaki aktif medya kayıtlarını döner. YouTube iframe embed veya doğrudan .mp4 video linklerini, süre rozetlerini, başlık, açıklama ve kapak görsellerini içerir.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `limit` | `int (Opsiyonel)` | **Opsiyonel** | Dönecek maksimum medya sayısı |
| `media_type` | `string (video | podcast)` | **Opsiyonel** | Medya türüne göre filtreleme |
| `featured` | `int (1 veya 0)` | **Opsiyonel** | 1 ise sadece öne çıkanları listeler |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getMediaContents" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
[
    {
        "id": "1",
        "title": "Kendini Keşfetmenin Yolculuğu",
        "media_type": "podcast",
        "tag": "PODCAST",
        "tag_class": "podcast",
        "media_url": "https://www.youtube.com/embed/ysz5S6PUM-U?autoplay=1",
        "url": "https://www.youtube.com/embed/ysz5S6PUM-U?autoplay=1",
        "is_direct": 0,
        "duration": "24:35",
        "image": "assets/images/media-1.svg",
        "thumbnail": "https://ufkayolculuk.com/assets/images/media-1.svg",
        "description": "İnsanın kendi iç dünyasını, ahlaki erdemlerini ve potansiyelini keşfetmesini konu alan özel podcast serisi.",
        "order_no": 1,
        "is_featured": 1
    }
]
```

---

#### 13. `GET / POST` /rest/get/getImportantDates
- **Başlık / Tanım:** getImportantDates
- **URL:** `https://ufkayolculuk.com/rest/get/getImportantDates`
- **Kısa Özet:** Web sitesindeki aktif önemli tarihleri, geri sayım hedeflerini ve prefix değişkenlerini döner.
- **Detaylı Açıklama:** web_dates tablosundaki aktif tarihleri sıralamaya göre listeler. Tarih formatı, ISO hedef tarihi, geri sayım etiketleri ve {tarih_key} prefixlerini içerir.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `limit` | `int (Opsiyonel)` | **Opsiyonel** | Dönecek maksimum tarih sayısı |
| `countdown` | `int (1 veya 0)` | **Opsiyonel** | 1 ise sadece geri sayım sayacında gösterilecek olanları listeler |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getImportantDates" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
[
    {
        "id": "1",
        "key": "ortaokul_sinav",
        "prefix": "{tarih_ortaokul_sinav}",
        "title": "Ortaokul Sınavı",
        "sub_title": "Online Sınav (Saat 15:00)",
        "badge": "Online Sınav",
        "icon_type": "exam",
        "date_formatted": "14 Mart 2026",
        "time_formatted": "15:00",
        "target_iso": "2026-03-14T15:00:00",
        "countdown_label": "Ortaokul Sınavına Kalan Süre",
        "order_no": 1,
        "is_countdown": 1,
        "is_active": 1,
        "diff_days": 5
    }
]
```

---

#### 14. `GET / POST` /rest/get/getWebMenus
- **Başlık / Tanım:** getWebMenus
- **URL:** `https://ufkayolculuk.com/rest/get/getWebMenus`
- **Kısa Özet:** Yönetim panelinden (web_menus) oluşturulan tüm aktif web menülerinin listesini döner.
- **Detaylı Açıklama:** web_menus tablosundaki aktif menüleri id, title, slug ve eleman sayılarıyla listeler. with_items=1 parametresi ile tüm menüler ağaç yapısıyla birlikte alınabilir.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `with_items` | `int (1 veya 0)` | **Opsiyonel** | 1 gönderilirse menülerin tüm alt öğeleri hiyerarşik ağaç olarak eklenir |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getWebMenus" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
[
    {
        "id": 8,
        "title": "Ana Menü (Web sitesi üst kısım)",
        "slug": "ana-menu-web-sitesi-ust-kisim",
        "item_count": 27
    }
]
```

---

#### 15. `GET / POST` /rest/get/getMenu
- **Başlık / Tanım:** getMenu
- **URL:** `https://ufkayolculuk.com/rest/get/getMenu`
- **Kısa Özet:** Yönetim panelinden (web_menus) otomatik yönetilen menü ağacını döner.
- **Detaylı Açıklama:** Belirtilen menü ID (örn: 8), menü slug'ı veya header/footer takma adı ile hiyerarşik menü yapısını döner. Parametre verilmezse panelde tanımlı ana menüyü getirir.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `identifier` | `string / int (URI veya POST/GET)` | **Opsiyonel** | Menü ID (örn: 8), slug veya "header"/"footer" |
| `lang` | `string (Opsiyonel)` | **Opsiyonel** | Dil kodu (örn: en, tr) - Çevrilmiş başlıkları getirir |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getMenu/8" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
{
    "status": true,
    "code": 200,
    "items": [
        {
            "id": "category_49",
            "title": "Ufka Yolculuk",
            "link": "https://ufkayolculuk.com/ufka-yolculuk/",
            "type": "category",
            "childs": [
                {
                    "id": "yp7wx",
                    "title": "Duyurular",
                    "link": "https://ufkayolculuk.com/duyurular",
                    "type": "custom",
                    "icon": "ki-duotone ki-calendar text-info fs-1"
                }
            ]
        }
    ],
    "headerMenu": [],
    "footerMenu": []
}
```

---

### 📁 Soru Cevaplama ve Sınav Oturumu Servisleri

#### 16. `POST` /rest/get/createQuestionForm
- **Başlık / Tanım:** createQuestionForm
- **URL:** `https://ufkayolculuk.com/rest/get/createQuestionForm`
- **Kısa Özet:** Kullanıcı ve sınav ID değerleriyle yeni bir question_forms oturum kaydı oluşturur.
- **Detaylı Açıklama:** Kullanıcı bir sınava başlarken çağrılır ve yeni oturum ID numarasını döner.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `user_id` | `int (POST)` | **Zorunlu** | Kullanıcı ID |
| `exam_id` | `int (POST)` | **Zorunlu** | Sınav ID |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/createQuestionForm" -u "USER:PASS" -d "user_id=45&exam_id=78"
```

**Örnek JSON Yanıtı:**
```json
{
    "status": true,
    "id": 14206,
    "uniq_id": "65f12a3b4c5d6"
}
```

---

#### 17. `POST` /rest/get/postAnswer
- **Başlık / Tanım:** postAnswer
- **URL:** `https://ufkayolculuk.com/rest/get/postAnswer`
- **Kısa Özet:** Kullanıcının tek bir soruya verdiği yanıtı sunucuya kaydeder.
- **Detaylı Açıklama:** Her soru geçişinde verilen cevabı question_answers tablosuna anlık yazar.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `user_id` | `int (POST)` | **Zorunlu** | Kullanıcı ID |
| `form_id` | `int (POST)` | **Zorunlu** | Sınav form ID |
| `question_id` | `int (POST)` | **Zorunlu** | Soru ID |
| `answer` | `string (A/B/C/D/E)` | **Zorunlu** | Verilen şık |
| `is_correct` | `int` | **Opsiyonel** | 1 veya 0 |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/postAnswer" -u "USER:PASS" -d "user_id=45&form_id=14206&question_id=101&answer=B"
```

**Örnek JSON Yanıtı:**
```json
{
    "status": true,
    "id": 9812,
    "message": "Cevap başarıyla kaydedildi"
}
```

---

### 📁 Yarışma Kitapları ve E-Kitap Okuma Takibi

#### 18. `POST | GET` /rest/get/getBookCategories
- **Başlık / Tanım:** getBookCategories
- **URL:** `https://ufkayolculuk.com/rest/get/getBookCategories`
- **Kısa Özet:** Yarışma kitaplarının kategorilerini ve her kategorideki kitap listesini döner.
- **Detaylı Açıklama:** İlkokul, ortaokul, lise ve yetişkin kategorilerine ayrılmış yarışma kitaplarını ve kapak görsellerini getirir.

**İstek Parametreleri:** Parametre gerektirmez (boş GET / POST).

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getBookCategories" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
[
    {
        "id": "1",
        "title": "İlkokul Kitapları",
        "books": [
            {
                "id": "14",
                "name": "Dürüstlük Yolculuğu",
                "image": "uploads/books/durustluk.jpg"
            }
        ]
    }
]
```

---

#### 19. `POST | GET` /rest/get/getBooks
- **Başlık / Tanım:** getBooks
- **URL:** `https://ufkayolculuk.com/rest/get/getBooks`
- **Kısa Özet:** Tüm kitapları, mobil kapak görselleri, ses dosyaları, PDF linkleri ve sayfa dosya boyutlarıyla döner.
- **Detaylı Açıklama:** Kitap okuma uygulaması için gerekli tüm kitap listesi ve sayfaların toplam indirme boyutu (total_image_size) hesaplanarak döner.

**İstek Parametreleri:** Parametre gerektirmez (boş GET / POST).

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getBooks" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
[
    {
        "id": "14",
        "name": "Dürüstlük Yolculuğu",
        "image": "uploads/books/durustluk.jpg",
        "pdf_file": "uploads/pdf/durustluk.pdf",
        "sound_file": "uploads/audio/durustluk.mp3",
        "total_image_size": 14859200
    }
]
```

---

#### 20. `POST | GET` /rest/get/getBook
- **Başlık / Tanım:** getBook
- **URL:** `https://ufkayolculuk.com/rest/get/getBook`
- **Kısa Özet:** Belirtilen kitabın tüm sayfalarının resim linklerini ve sayfa boyutlarını liste olarak döner.
- **Detaylı Açıklama:** Mobil okuyucunun sayfaları çevirebilmesi ve önbelleğe alabilmesi için sayfa sayfa tam URL listesini üretir.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `id` | `int (URI veya POST)` | **Zorunlu** | Kitap ID |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getBook/14" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
{
    "id": "14",
    "name": "Dürüstlük Yolculuğu",
    "pages": [
        {
            "id": "1",
            "image": "https://ufkayolculuk.com/uploads/books/14/page1.jpg",
            "image_size": 124500
        },
        {
            "id": "2",
            "image": "https://ufkayolculuk.com/uploads/books/14/page2.jpg",
            "image_size": 119800
        }
    ],
    "total_image_size": 244300
}
```

---

#### 21. `POST | GET` /rest/get/saveUserPage
- **Başlık / Tanım:** saveUserPage
- **URL:** `https://ufkayolculuk.com/rest/get/saveUserPage`
- **Kısa Özet:** Öğrencinin kitap okurken kaldığı son sayfayı sunucuya senkronize eder.
- **Detaylı Açıklama:** Sayfa çevrildikçe tetiklenerek kullanıcının cihazlar arasında okuma durumunu korur.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `user_id` | `int` | **Zorunlu** | Kullanıcı ID |
| `book_id` | `int` | **Zorunlu** | Kitap ID |
| `page` | `int` | **Zorunlu** | Kaldığı sayfa numarası |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/saveUserPage/45/14/23" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
{
    "status": true,
    "page": 23
}
```

---

### 📁 Yarışmacı Kullanıcı, Profil ve Giriş Servisleri

#### 22. `POST` /rest/get/getUfkaYolculukUser
- **Başlık / Tanım:** getUfkaYolculukUser
- **URL:** `https://ufkayolculuk.com/rest/get/getUfkaYolculukUser`
- **Kısa Özet:** Telefon numarası ve doğum tarihi ile kayıtlı yarışmacı profilini sorgular.
- **Detaylı Açıklama:** Mobil uygulama ve online sınav girişinde yarışmacıyı doğrulamak için kullanılır.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `mobile` | `string (POST)` | **Zorunlu** | 10 haneli telefon numarası (örn: 5551234567) |
| `birthdate` | `string (POST)` | **Zorunlu** | Doğum tarihi (örn: 2008-05-15 veya 15.05.2008) |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getUfkaYolculukUser" -u "USER:PASS" -d "mobile=5551234567&birthdate=2008-05-15"
```

**Örnek JSON Yanıtı:**
```json
{
    "id": "45",
    "name": "Ahmet",
    "surname": "Yılmaz",
    "mobile": "5551234567",
    "birth_date": "2008-05-15",
    "uy_category_id": "3",
    "uy_contest_id": "29"
}
```

---

#### 23. `POST | GET` /rest/get/getUserData
- **Başlık / Tanım:** getUserData
- **URL:** `https://ufkayolculuk.com/rest/get/getUserData`
- **Kısa Özet:** Kullanıcının okuduğu kitap sayfalarını ve sepet/aktivite geçmişini döner.
- **Detaylı Açıklama:** Kullanıcı profilinde okuma ilerlemesini ve geçmişini göstermek için kullanılır.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `user_id` | `int` | **Zorunlu** | Kullanıcı ID |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getUserData/45" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
{
    "book_pages": [
        {
            "id": "301",
            "type": "book",
            "product_id": "14",
            "related_id": "23"
        }
    ]
}
```

---

#### 24. `POST | GET` /rest/get/getProfileMenu
- **Başlık / Tanım:** getProfileMenu
- **URL:** `https://ufkayolculuk.com/rest/get/getProfileMenu`
- **Kısa Özet:** Kullanıcının giriş durumuna göre özelleştirilmiş profil menü bağlantılarını ve SVG ikonlarını döner.
- **Detaylı Açıklama:** Kaydımı Düzenle, Davet Et Kazan, Takım Lideri gibi menü seçeneklerini kullanıcı yetkisine göre döner.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `user_id` | `int (Opsiyonel)` | **Opsiyonel** | Giriş yapan kullanıcı ID |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getProfileMenu/45" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
[
    {
        "title": "Kaydımı Düzenle",
        "url": "https://ufkayolculuk.com/kayit-ol/0/1"
    },
    {
        "title": "Davet Et, Kazan",
        "url": "https://ufkayolculuk.com/vesile-olduklarim"
    },
    {
        "title": "Takım Lideri",
        "url": "https://ufkayolculuk.com/lider-olmak-istiyorum"
    }
]
```

---

### 📁 Genel Kurumsal ve Coğrafi Servisler

#### 25. `POST | GET` /rest/get/getPage
- **Başlık / Tanım:** getPage
- **URL:** `https://ufkayolculuk.com/rest/get/getPage`
- **Kısa Özet:** Yarışma şartnamesi, kuralları veya duyuru sayfalarının başlık ve gövde metnini döner.
- **Detaylı Açıklama:** web_contents tablosunda tanımlı kurumsal sayfaları mobil uygulamada göstermek için kullanılır.

**İstek Parametreleri:**
| Parametre | Tür | Zorunluluk | Açıklama |
| :--- | :--- | :--- | :--- |
| `id` | `int` | **Zorunlu** | Sayfa / İçerik ID |

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getPage/12" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
{
    "page": [
        {
            "id": "12",
            "title": "Yarışma Şartnamesi",
            "body": "Ufka Yolculuk yarışma şartları..."
        }
    ]
}
```

---

#### 26. `POST | GET` /rest/get/getCities
- **Başlık / Tanım:** getCities
- **URL:** `https://ufkayolculuk.com/rest/get/getCities`
- **Kısa Özet:** Kayıt ve okul seçiminde kullanılan 81 ilin alfabetik listesini döner.
- **Detaylı Açıklama:** Plaka ID ve il isimlerini içeren liste.

**İstek Parametreleri:** Parametre gerektirmez (boş GET / POST).

**Örnek cURL İsteği:**
```bash
curl -X POST "https://ufkayolculuk.com/rest/get/getCities" -u "USER:PASS"
```

**Örnek JSON Yanıtı:**
```json
[
    {
        "id": "34",
        "name": "İstanbul"
    },
    {
        "id": "6",
        "name": "Ankara"
    }
]
```

---

## 🖼️ 6. Medya, Resim ve Dosya Yolları Standardı

API yanıtlarında dönen `image`, `sound_file`, `pdf_file` gibi alanlar göreceli yol (`uploads/...`) şeklinde iletilebilir.
Bu yollar doğrudan istemciye verilmeden önce yönetim sunucusu ile birleştirilmelidir:

* **Yönetim Sunucusu Ön Eki:** `https://yonetim.ufkayolculuk.com/`
* **Dönüştürme Kuralı:**
  * Gelen yol `http://` veya `https://` ile başlıyorsa: **Doğrudan kullanılır**.
  * Gelen yol `uploads/...` veya `assets/...` ile başlıyorsa: `https://yonetim.ufkayolculuk.com/` + `ltrim(, '/')` şeklinde mutlak URL'ye çevrilir.

---

## 🌐 7. HTTP Durum Kodları Referansı

| Kod | Durum | Anlamı ve Çözüm |
| :--- | :--- | :--- |
| `200 OK` | Başarılı | İstek başarıyla karşılandı ve veri döndürüldü. |
| `400 Bad Request` | Geçersiz İstek | Eksik zorunlu parametre (ör. `getQuestions` için `category_id` yoksa). |
| `401 Unauthorized` | Yetkisiz | Geçersiz kullanıcı adı/şifre veya süresi dolmuş Bearer token. |
| `403 Forbidden` | Yasaklandı | WAF tarafından zararlı içerik veya yetkisiz erişim engellendi. |
| `404 Not Found` | Bulunamadı | İstenen sayfa, içerik veya kitap ID'si sistemde mevcut değil. |
| `429 Too Many Requests` | Hız Sınırı Aşıldı | Sliding window (120 req/dk) aşıldı veya brute-force kilidi devrede. |
| `500 Server Error` | Sunucu Hatası | Merkezi veritabanı veya uygulama katmanında beklenmeyen hata. |
