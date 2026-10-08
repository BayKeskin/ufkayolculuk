# Ufka Yolculuk - Kayıt Sistemi Entegrasyon Yol Haritası
> **Referans Sayfa:** `https://t1.ufkayolculuk.com/kayit-ol`  
> **Hedef:** Mevcut basit modal kayıt yapısını, 4 adımlı (Wizard), Select2 destekli, kaskad AJAX doğrulamalı ve modern tasarımlı yeni kayıt sistemine dönüştürmek.

---

## 📌 Genel İlerleme Durumu

- [x] **Aşama 1:** Mimari, Rota ve Controller Hazırlığı (`/kayit-ol`)
- [x] **Aşama 2:** Backend Proxy & API Entegrasyon Servisleri (`KayitController`)
- [x] **Aşama 3:** Arayüz (View) ve 4 Adımlı Wizard Şablonunun Oluşturulması
- [x] **Aşama 4:** Frontend JavaScript Mantığı, Validasyonlar ve Kaskad Seçimler
- [x] **Aşama 5:** Başarı Ekranı, Sertifika İndirme ve Sınav Entegrasyonu (Adım 4)
- [x] **Aşama 6:** Tasarım, Mobil Uyumluluk, Testler ve Canlı Doğrulama

---

## 📝 Aşamalar ve Detaylı Kontrol Listesi

### Aşama 1: Mimari, Rota ve Controller Hazırlığı
- [x] `app/Config/Routes.php` dosyasına yeni rotaların eklenmesi:
  - `GET /kayit-ol` -> `Kayit::index`
  - `POST /kayit/check-pre-register` -> `Kayit::checkPreRegister`
  - `GET /kayit/get-counties/(:num)` -> `Kayit::getCounties/$1`
  - `GET /kayit/get-schools/(:num)/(:num)` -> `Kayit::getSchools/$1/$2`
  - `POST /kayit/check-leader` -> `Kayit::checkLeader`
  - `POST /kayit/ajax-register` -> `Kayit::ajaxRegister`
  - `GET /kayit/register-done/(:segment)` -> `Kayit::registerDone/$1`
- [x] `app/Controllers/Kayit.php` controller dosyasının oluşturulması.
- [x] Header, Footer ve ana sayfadaki tüm "Kayıt Ol" buton bağlantılarının `/kayit-ol` sayfasına yönlendirilmesi.

---

### Aşama 2: Backend Proxy & API Entegrasyon Servisleri
- [x] `UfkaApiService` veya `Kayit` controller içerisinde API uçlarının tanımlanması:
  - [x] **Ön Kayıt Kontrolü (`checkPreRegister`):** Doğum tarihi + telefon ile mükerrerlik sorgusu.
  - [x] **Ülke Listesi Hazırlığı:** Türkiye (ID: 225) varsayılan ve 251 dünya ülkesi ve telefon kodları (`RegistrationData`).
  - [x] **İl / İlçe / Okul Servisleri:** 
    - İller listesi (`getCities`)
    - İlçeler listesi (`getCounties/{cityId}`) (Önbellekli canlı servis)
    - Okullar listesi (`getSchools/{countyId}/{categoryId}`) (Önbellekli canlı servis)
  - [x] **Takım Lideri Sorgulama (`checkLeader`):** Kod kontrolü, lider ad-soyad teyidi ve ID eşleşmesi.
  - [x] **Kayıt Tamamlama (`ajaxRegister`):** Form verilerinin API'ye iletilmesi, `uniq_id` ve sertifika URL'sinin alınması.
  - [x] **Kayıt Tamamlandı Bildirimi (`registerDone/{uniq_id}`):** Kayıt sonrası arka plan çağrısı.

---

### Aşama 3: Arayüz (View) ve 4 Adımlı Wizard Şablonunun Oluşturulması
- [x] `app/Views/kayit_ol.php` görünüm dosyasının oluşturulması.
- [x] Layout entegrasyonu (Header, Breadcrumb, Container, Footer).
- [x] Wizard ilerleme çubuğu (Progress Step Bar - 1, 2, 3, 4).
- [x] **Bölüm 1 (Kullanıcı Bilgileri):**
  - Doğum Tarihi: Gün, Ay, Yıl select kutuları.
  - Telefon: Ülke Kodu select (+90 varsayılan) ve Cep Telefonu inputu.
  - İleri butonu (`rgs-next-btn`).
- [x] **Bölüm 2 (Katılım Bilgileri):**
  - Ülke seçimi (Select2).
  - Ad, Soyad, Cinsiyet (Erkek / Kız).
  - Kategori seçimi (İlkokul, Ortaokul, Lise, Yetişkin, İlahiyat).
  - İlahiyat onay switch'i (`#rgs-student-approval`).
  - İl, İlçe ve Okul seçim alanları (Select2 destekli).
  - Takım lideri kodu giriş inputu, Sorgula ve Sil butonları.
  - Geri ve İleri butonları.
- [x] **Bölüm 3 (Gözden Geçir & Onay):**
  - Dinamik özet bilgi kartı (Ad Soyad, Doğum Tarihi, Telefon, Cinsiyet, Kategori, İl/İlçe, Okul).
  - KVKK Aydınlatma Metni switch toggle ve PDF bağlantısı.
  - Geri ve "Kaydı Tamamla" butonları.
- [x] **Bölüm 4 (Kayıt Tamamlandı / Başarı Ekranı):**
  - Başarı kutusu & tebrik mesajı.
  - Sınav Tarihleri Bilgilendirme Kartı.
  - Doğrudan Deneme Sınavı Butonu (`minideneme.ufkayolculuk.com`).
  - 4 Adet Aksiyon Kartı (Kitap Oku, Online Soru Çöz, Arkadaşlarını Davet Et, Takım Lideri Ol).
  - Kayıt Başarı Sertifikası Modalı & "Sertifikamı İndir" aksiyonu.

---

### Aşama 4: Frontend JavaScript Mantığı ve Validasyonlar
- [x] Select2 ve telefon maskeleme kütüphanelerinin sayfaya dahil edilmesi.
- [x] **Adım 1 JS Mantığı:**
  - Telefon format validasyonu (+90 için 10 hane, `5XXXXXXXXX`).
  - Doğum tarihinden yaş hesaplama ve kategori ön seçimi.
  - İleri tıklandığında `checkPreRegister` AJAX kontrolü; mükerrer kayıtsa engelleme ve bilgilendirme.
- [x] **Adım 2 JS Mantığı:**
  - Ülke değişimi: Türkiye dışı seçilirse İl/İlçe/Okul alanlarının gizlenmesi ve `required` kaldırılması.
  - Kategori 50 (İlahiyat) seçilirse switch alanının açılması/kapanması.
  - İl değiştiğinde `getCounties` ile İlçelerin dinamik dolması.
  - İlçe veya Kategori değiştiğinde `getSchools` ile Okulların dinamik dolması.
  - Takım Lideri Kodu: `checkLeader` AJAX sorgusu, başarı durumunda yeşil onay ve lider ID atanması, silme butonu.
- [x] **Adım 3 JS Mantığı:**
  - `fillReviewSection()` fonksiyonu ile özet kartının anlık doldurulması.
  - Yaş - Kategori uyuşmazlık kontrolü ve kırmızı uyarı gösterimi.
  - KVKK onay kontrolü.
  - Form Submit: `ajaxRegister` çağrısı, buton kilitleme (`disabled`), hata yönetimi.

---

### Aşama 5: Başarı Ekranı ve Entegrasyon
- [x] Adım 4'e geçiş animasyonu ve form alanlarının gizlenmesi.
- [x] Dönen `certificate` URL'si ile sertifika modalının açılması ve `sertifikam.webp` olarak indirilmesi.
- [x] Dönen `uniq_id` ile `minideneme.ufkayolculuk.com` sınav linkinin oluşturulması.
- [x] Arka planda `registerDone/{uniq_id}` servisinin tetiklenmesi.
- [x] Liderlik durumuna göre "Takım Lideri Ol" kartının koşullu gösterimi.

---

### Aşama 6: Tasarım, Mobil Uyumluluk ve Testler
- [x] Projenin ana tasarım dili (Bootstrap 5.3 + Özel Vanilla CSS tokens) ile `.rgs-*` stillerinin tam uyumu.
- [x] Mobil ve tablet ekranlarda form elemanlarının kusursuz görünmesi.
- [x] Tüm form adımlarının uçtan uca test edilmesi:
  - Hatalı telefon numarası testi
  - Mükerrer kayıtlı kullanıcı testi
  - Yabancı ülke seçimi testi
  - Kategori ve okul zorunluluk testi
  - Geçersiz/geçerli takım lideri testi
  - Başarılı kayıt akışı ve sertifika testi
- [x] Kullanıcı onayı ve canlıya alma.
