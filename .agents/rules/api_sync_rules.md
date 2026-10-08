# API Senkronizasyon ve Canlı Güncelleme Kuralı (API Sync Rules)

Bu kural; kullanıcı **"api güncellendi"**, **"api değişikliklerini kontrol et"**, **"yeni api uçları var mı"** veya benzeri bir bildirimde bulunduğunda Antigravity tarafından **otomatik olarak** uygulanmalıdır.

---

## 🎯 Tetikleyici (Triggers)
Kullanıcıdan gelen şu ve benzeri mesajlar bu kuralı doğrudan tetikler:
- *"api güncellendi"*
- *"apide değişiklik var, kontrol et"*
- *"yeni uç noktalar eklendi mi?"*
- *"api dökümanını senkronize et"*

---

## 🛠️ Uygulanacak Otomatik İşlem Protokolü

### 1. Canlı Dokümantasyon Portalı Girişi
* **Portal Adresi:** `https://ufkayolculuk.com/rest`
* **Giriş Uç Noktası:** `https://ufkayolculuk.com/rest/login` (CSRF token ve ajax=1 parametresi ile)
* **Kullanıcı Adı:** `uy_Rest-Worker`
* **Şifre:** `UfkA_Yol-1448`
* **Dokümantasyon Sayfası:** `https://ufkayolculuk.com/rest/docs`
* **Temel REST URL:** `https://ufkayolculuk.com/rest/get/`

### 2. Canlı Katalog & Servis Analizi
* Sayfaya giriş yapıldıktan sonra tüm servis kartları (`.endpoint-card`), WAF güvenlik kuralları, hız sınırları (Rate Limit) ve Bearer Token politikaları taranır.
* Tüm uç noktaların HTTP metotları (`GET`, `POST`), parametre zorunlulukları (`req`, `opt`) ve JSON yanıt şablonları çekilir.

### 3. Mevcut Dokümantasyon ile Karşılaştırma (Diff Analizi)
Yerel [UFKA_YOLCULUK_REST_API_DOKUMANTASYONU.md](file:///c:/wamp64/www/ufkayolculuk/UFKA_YOLCULUK_REST_API_DOKUMANTASYONU.md) dosyası referans alınarak şu 4 ana kategoride farklar belirlenir:
1. **Yeni Eklenen Uç Noktalar (New Endpoints):** Yeni açılan servisler ve işlevleri.
2. **Kaldırılan / Deprecate Edilen Uç Noktalar:** Kullanımdan kalkan servisler.
3. **Parametre ve Davranış Değişiklikleri (Breaking Changes):** Zorunlu hale gelen parametreler (örn: `category_id`), sunucu taraflı yeni filtreler (`type`, `slug` vb.).
4. **Güvenlik & Hız Sınırı Değişiklikleri:** WAF kuralları, Rate Limit (120 req/dk) veya Bearer token geçerlilik sürelerindeki değişimler.

### 4. Dokümantasyonun Güncellenmesi
* Tespit edilen tüm değişiklikler [UFKA_YOLCULUK_REST_API_DOKUMANTASYONU.md](file:///c:/wamp64/www/ufkayolculuk/UFKA_YOLCULUK_REST_API_DOKUMANTASYONU.md) dosyasına işlenir.
* Sürüm numarası ve güncelleme tarihi güncellenir.
* 3. Bölümdeki *Changelog / Diff Matrisi* yeni farklarla zenginleştirilir.

### 5. Proje Kodlarına Yansıtma Değerlendirmesi
* Değişikliklerin projedeki merkezi servis katmanına (`app/Services/UfkaApiService.php`), denetleyicilere (`app/Controllers/`) veya arayüzlere (`app/Views/`) etkisi analiz edilir.
* Kullanıcıya net bir **Fark Raporu (Diff Report)** sunulur ve onayına istinaden kod güncelleme planı çıkarılır.
