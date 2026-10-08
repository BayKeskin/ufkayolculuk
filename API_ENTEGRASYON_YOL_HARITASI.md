# 🗺️ Ufka Yolculuk REST API — Yeni Entegrasyon Yol Haritası (Roadmap v2.0)

> **Belge Sürümü:** 2.0 (Güncellenmiş API Mimarisi & Revizyon Yol Haritası)  
> **Son Güncelleme:** 08 Ekim 2026  
> **Referans Dokümantasyon:** [UFKA_YOLCULUK_REST_API_DOKUMANTASYONU.md](file:///c:/wamp64/www/ufkayolculuk/UFKA_YOLCULUK_REST_API_DOKUMANTASYONU.md)  
> **Platform:** CodeIgniter 4 (PHP 8.2) + WAMP & Canlı Demo (`team.tkmdev.com/ufkayolculuk-demo/`)  
> **Hedef:** %100 Headless, Sıfır Statik Kodlama, Yüksek Performans, WAF & Rate Limit Uyumlu Mimari  

---

## 📌 1. Yönetici Özeti ve Yol Haritası Değişim Gerekçesi

Projemizin ilk aşamasında hazırlanan yol haritası, API'deki eksik uç noktalar nedeniyle bazı modüllerde geçici çözümler (örneğin önemli tarihleri `getExams` üzerinden elle biçimlendirme, podcast içeriklerini kodda statik mock olarak tutma) içermekteydi.

**07-08 Ekim 2026** tarihinde devreye alınan resmi API güncellemesiyle:
1. **Yeni Resmi Uç Noktalar Geldi:** `getImportantDates`, `getMediaContents`, `getSliders`, `getWebMenus`, `token`, `refresh`, `revoke`.
2. **Kırıcı Parametre Kuralları Eklendi:** `getQuestions` için `category_id` artık **zorunlu** hale geldi.
3. **Sunucu Taraflı Filtreler Açıldı:** `getWebContents` artık `type`, `category_id` ve `slug` parametreleriyle doğrudan veritabanı seviyesinde filtrelenebiliyor.
4. **Güvenlik Standardı Yükseltildi:** Basic Auth kullanımdan kaldırılma (deprecated) sürecine girdi; Bearer Token mimarisi standartlaştırıldı.

Bu yeni yol haritası; projemizi bu güncel yeteneklerle modernize etmek, kod tabanındaki tüm statik/geçici kurguları temizlemek ve sistemi tam dinamik hale getirmek için hazırlanmıştır.

---

## 📊 2. Mevcut Durum ve Entegrasyon Durum Matrisi

```
┌────────────────────────────────────────────────────────────────────────────────────────┐
│                        UFKA YOLCULUK SİSTEM DURUMU VE ENTEGRASYON MATRİSİ              │
└────────────────────────────────────────────────────────────────────────────────────────┘
                                            │
    ┌───────────────────────────────────────┼───────────────────────────────────────┐
    ▼                                       ▼                                       ▼
[ 1. TAMAMLANMIŞ & STABİL ]           [ 2. BAŞARIYLA GEÇİŞİ YAPILANLAR ]      [ 3. AKTİFLEŞTİRİLEN YENİ YETENEKLER ]
✅ Ödüller Modülü (/oduller)          ✅ Önemli Tarihler (#takvim)           ✅ Hero Slider Vitrini (getSliders + Fallback)
✅ Duyurular & Haberler (/duyurular)    (getImportantDates dinamik)           ✅ Bearer Token Mimarisi (token & refresh)
✅ Kurumsal Detaylar (/sayfa/:slug)   ✅ Medya & Podcast (#medya)             ✅ Çoklu Dil Menü Ağacı (getMenu & getWebMenus)
✅ İletişim & 81 İl (/iletisim)        (getMediaContents dinamik)             ✅ Soru Havuzu Parametresi (getQuestions/id)
✅ Yarışmacı Girişi (#loginModal)     ✅ Sunucu Filtresi (getWebContents)
✅ Kitaplar Vitrini (#kategoriler)      (type=annoucement/news/sss)
```

---

## 🚀 3. Yeni Yol Haritası ve Faz Planı (Aşama Aşama Uygulama)

Geliştirmeler 7 odaklı faza ayrılmıştır. Her faz birbirinden bağımsız test edilebilir ve canlı ortamı asla bozmayacak şekilde tasarlanmıştır:

```
FAZ 1 ──► Önemli Tarihler & Sayaç Senkronizasyonu (getImportantDates) [YÜKSEK ÖNCELİK]
  │       - Kodda gömülü cevap anahtarı ve sonuç ilanlarını temizleme
  │       - Resmi web_dates verisi, sayaç ISO hedefleri ve prefix desteği
  ▼
FAZ 2 ──► Medya & Podcast Vitrini Entegrasyonu (getMediaContents) [YÜKSEK ÖNCELİK]
  │       - Kodda statik duran 2 podcast kaydını kaldırma
  │       - Resmi web_medias tablosundan dinamik video ve podcast beslemesi
  ▼
FAZ 3 ──► İçerik Çekme Optimizasyonu (getWebContents?type=...) [PERFORMANS]
  │       - 111 içerik yerine sadece hedeflenen veriyi çekme (annoucement, news, sss)
  │       - Ağ trafiğini ve önbellek boyutunu %70 hafifletme
  ▼
FAZ 4 ──► Hero Banner Slider Entegrasyonu (getSliders) [GÖRSEL ESNEKLİK]
  │       - web_sliders tablosundaki aktif slaytları anasayfaya bağlama
  │       - Panelde slayt yoksa mevcut şık HTML slaytları gösteren akıllı fallback
  ▼
FAZ 5 ──► Bearer Token Güvenlik Mimarisi (token & refresh) [GÜVENLİK STANDARDI]
  │       - UfkaApiService'e 2 saatlik Bearer Token yönetimi ekleme
  │       - Olası token hatasında Basic Auth'a yumuşak düşüş (fallback)
  ▼
FAZ 6 ──► Çoklu Dil & Gelişmiş Menü Ağacı (getMenu & getWebMenus) [FONKSİYONEL]
  │       - getMenu?lang=tr / lang=en desteği
  │       - Panelden yönetilen hiyerarşik menü ağacını senkronize etme
  ▼
FAZ 7 ──► Canlı Mini Soru & Deneme Simülatörü (getQuestions/{category_id}) [İNTERAKTİF]
  │       - category_id zorunluluğuna tam uyumlu 49 soruluk pratik test motoru
  │       - Doğru/yanlış anlık geri bildirim ve sonuç karnesi
```

---

### 🟢 FAZ 1: Önemli Tarihler & Canlı Geri Sayım (Refactor & API Geçişi)
* **Öncelik:** 🔴 Acil / Yüksek
* **Etkilenen Dosyalar:**
  * `app/Services/UfkaApiService.php` (`getImportantDates`)
  * `app/Controllers/Home.php`
  * `app/Views/home.php`
  * `public/assets/js/main.js` (`initDatesAndCountdown`)
* **Mevcut Durum / Sorun:**
  * Sınav tarihleri `getExams` içinden formatlanıyor; "Cevap Anahtarı" (15 Mart) ve "Sonuç İlanı" (28 Mart) tarihleri PHP koduna elle gömülmüştü.
* **Yeni API Kabiliyeti:**
  * `https://ufkayolculuk.com/rest/get/getImportantDates` servisi `web_dates` tablosundaki tüm aktif tarihleri hazır alanlarla dönüyor:
    * `key`: `ortaokul_sinav`, `ilkokul_sinav`, `lise_sinav`
    * `title`, `sub_title`, `badge`, `icon_type`
    * `date_formatted` (*"14 Mart 2026"*), `time_formatted` (*"15:00"*)
    * `target_iso` (*"2026-03-14T15:00:00"*)
    * `countdown_label` (*"Ortaokul Sınavına Kalan Süre"*)
    * `prefix` (*"{tarih_ortaokul_sinav}"*)
* **Uygulama Adımları:**
  1. `UfkaApiService::getImportantDates()` metodunu doğrudan API'nin yeni `getImportantDates` servisine bağlamak.
  2. Statik eklenen dizi elemanlarını kaldırıp veriyi %100 API'den almak.
  3. API yanıtı boş veya hata verirse mevcut çalışan yapıyı fallback olarak korumak.
  4. Anasayfadaki slider ve geri sayım sayacının yeni API alanlarıyla (`target_iso`, `countdown_label`) kusursuz senkronize olduğunu doğrulamak.

---

### 🟢 FAZ 2: Medya & Podcast Vitrini (Refactor & API Geçişi)
* **Öncelik:** 🔴 Acil / Yüksek
* **Etkilenen Dosyalar:**
  * `app/Services/UfkaApiService.php` (`getMediaContents`)
  * `app/Controllers/Home.php`
  * `app/Views/home.php`
  * `public/assets/js/main.js` (`initMediaModal`)
* **Mevcut Durum / Sorun:**
  * Video içerikleri `getWebContents` taranarak çekiliyor; `podcast-1` ve `podcast-2` kayıtları ise kod içinde statik dizi olarak tanımlanmıştı.
* **Yeni API Kabiliyeti:**
  * `https://ufkayolculuk.com/rest/get/getMediaContents` servisi `web_medias` tablosundaki aktif video ve podcast'leri hazır dönüyor:
    * `media_type`: `video` | `podcast`
    * `media_url`: YouTube iframe veya doğrudan video URL
    * `duration`: Süre (*"24:35"* veya *"Video"*)
    * `thumbnail_url` / `image_url`
    * `description`, `is_featured`
* **Uygulama Adımları:**
  1. `UfkaApiService::getMediaContents()` metodunu doğrudan yeni resmi `getMediaContents` uç noktasına bağlamak.
  2. Kod içindeki statik podcast dizisini temizlemek.
  3. `thumbnail_url` ve `media_url` alanlarının hem YouTube iframe hem doğrudan video oynatıcı modalıyla (`#mediaPlayerModal`) tam uyumlu çalıştığını doğrulamak.

---

### 🟡 FAZ 3: Sunucu Taraflı İçerik Filtreleme Optimizasyonu
* **Öncelik:** 🟡 Orta / Performans
* **Etkilenen Dosyalar:**
  * `app/Services/UfkaApiService.php` (`getAnnouncements`, `getFaqList`, `getWebContent`)
  * `app/Controllers/Duyurular.php`, `app/Controllers/Sss.php`, `app/Controllers/Sayfa.php`
* **Mevcut Durum / Sorun:**
  * 111 web içeriğinin tamamı her istekte tek parça çekilip PHP tarafında `foreach` döngüsüyle duyuru veya SSS diye ayrıştırılıyordu.
* **Yeni API Kabiliyeti:**
  * `getWebContents` artık filtre parametreleri kabul ediyor:
    * Duyurular için: `getWebContents?type=annoucement`
    * Haberler için: `getWebContents?type=news`
    * SSS için: `getWebContents?type=sss`
    * Tekil içerik için: `getWebContents?slug=sartname`
* **Uygulama Adımları:**
  1. `getAnnouncements()` metodunu `getWebContents?type=annoucement` ile hafifletmek.
  2. `getFaqList()` metodunu `getWebContents?type=sss` ile hızlandırmak.
  3. `getWebContent($slug)` aramasında doğrudan `getWebContents?slug=$slug` sorgusu atıp ağ trafiğini optimize etmek.

---

### 🟡 FAZ 4: Hero Banner Slider Entegrasyonu (Yeni Yetenek)
* **Öncelik:** 🟡 Orta
* **Etkilenen Dosyalar:**
  * `app/Services/UfkaApiService.php` (`getSliders`)
  * `app/Controllers/Home.php`
  * `app/Views/home.php` (`#heroSlider`)
* **Yeni API Kabiliyeti:**
  * `https://ufkayolculuk.com/rest/get/getSliders` servisi `web_sliders` tablosundaki aktif slaytları dönüyor:
    * `title`, `title_highlight`, `badge_text`, `button_1_text`, `button_1_url`, `image`, `mobile_image`.
* **Uygulama Adımları:**
  1. `UfkaApiService` içine `getSliders($limit = 5)` metodunu eklemek.
  2. Anasayfa Hero Carousel alanını, API'den slider gelmesi durumunda dinamik dönecek; API boş dönerse (`[]`) mevcut çalışan 4 şık slaytı gösterecek şekilde akıllı fallback ile yapılandırmak.

---

### 🔵 FAZ 5: Bearer Token Güvenlik Mimarisi Geçişi
* **Öncelik:** 🔵 Güvenlik Standardı
* **Etkilenen Dosyalar:**
  * `app/Config/UfkaApi.php`
  * `app/Services/UfkaApiService.php` (`request`, `getAccessToken`)
* **Gerekçe:**
  * Dokümantasyonda HTTP Basic Auth'un güvenlik riski (CWE-522) nedeniyle kullanımdan kalkacağı bildirilmiştir.
* **Uygulama Adımları:**
  1. `UfkaApiService` içine `getAccessToken()` yardımcı metodu eklemek.
  2. Alınan `access_token` değerini 110 dakika (ömrü 120 dakika) CI4 cache'inde saklamak.
  3. İsteklerde `Authorization: Bearer <access_token>` başlığını göndermek.
  4. Token süresi dolarsa `POST /rest/get/refresh` veya otomatik yeniden token alma mantığını kurmak.
  5. Herhangi bir ağ veya token hatasında sistemin kesilmemesi için Basic Auth fallback'ini hazır tutmak.

---

### 🔵 FAZ 6: Çoklu Dil & Gelişmiş Menü Ağacı Entegrasyonu
* **Öncelik:** 🔵 Fonksiyonel
* **Etkilenen Dosyalar:**
  * `app/Services/UfkaApiService.php` (`getMenu`, `getWebMenus`)
  * `app/Views/partials/header.php`, `app/Views/partials/footer.php`
* **Yeni API Kabiliyeti:**
  * `getWebMenus` ile paneldeki tüm menü ağaçları (`with_items=1`).
  * `getMenu` ile `lang=tr` veya `lang=en` parametreli menü listeleme.
* **Uygulama Adımları:**
  1. `UfkaApiService::getMenu($identifier, $lang = 'tr')` metoduna dil parametresi eklemek.
  2. Header ve footer navigasyonunda menü elemanlarını dinamik hiyerarşiyle eşleştirmek.

---

### ⚪ FAZ 7: Canlı Mini Soru & Deneme Simülatörü (Kırıcı Parametre Uyumlu)
* **Öncelik:** ⚪ İsteğe Bağlı / İnteraktif
* **Etkilenen Dosyalar:**
  * `app/Services/UfkaApiService.php` (`getQuestions`)
  * `app/Controllers/Home.php`
  * `app/Views/home.php` & Modal
* **Kritik API Kuralı:**
  * `category_id` artık **ZORUNLUDUR**. (Örn: `getQuestions/6` 49 soru dönüyor).
* **Uygulama Adımları:**
  1. `UfkaApiService::getQuestions($categoryId = 6, $type = 'mini-deneme')` metodunu zorunlu kategori ID kuralına göre güncellemek.
  2. Anasayfadaki soru simülatöründe öğrencinin seçtiği kademeye göre (İlkokul, Ortaokul vb.) ilgili kategori ID'sinden soru getirmek.

---

## 📅 4. Uygulama ve Teslimat Takvimi

| Faz | Kapsam | Durum | Test & Entegrasyon Sonucu |
| :--- | :--- | :---: | :--- |
| **Faz 1** | Önemli Tarihler & Canlı Geri Sayım (`getImportantDates`) | ✅ **TAMAMLANDI** | Canlı API'den 8 tarih çekildi, geri sayım ISO senkronize edildi. |
| **Faz 2** | Medya & Podcast Vitrini (`getMediaContents`) | ✅ **TAMAMLANDI** | Canlı API'den 4 video/podcast çekildi, oynatıcı modala bağlandı. |
| **Faz 3** | İçerik Filtreleme Optimizasyonu (`getWebContents?type=`) | ✅ **TAMAMLANDI** | Duyurular (18), Haberler (5), SSS (18) ve tekil slug filtreleri devrede. |
| **Faz 4** | Hero Banner Slider Entegrasyonu (`getSliders`) | ✅ **TAMAMLANDI** | `getSliders` Home controller'a bağlandı; boşsa 4 fallback slayt devrede. |
| **Faz 5** | Bearer Token Mimarisi (`token` & `refresh`) | ✅ **TAMAMLANDI** | 2 saatlik Bearer token önbellek, 401 otomatik yenileme, Basic Auth fallback aktif. |
| **Faz 6** | Çoklu Dil Menü Ağacı (`getMenu?lang=`) | ✅ **TAMAMLANDI** | Hiyerarşik `headerMenu` ve `items` ağaç ayrıştırıcısı hazırlandı. |
| **Faz 7** | Soru Havuzu Parametresi (`getQuestions/{id}`) | ✅ **TAMAMLANDI** | Zorunlu `category_id` kuralı uygulandı; 49 soru test edildi. *(Sınav/kitap okuma motoru ayrı projede olacak)* |

---

## 🔒 5. Güvenlik, Performans ve Mimari Prensipleri

1. **Graceful Fallback (Kırılmaz Arayüz):**
   * Uzak API sunucusunda bir bakım veya kesinti olduğunda arayüz asla patlamaz; her zaman yerel önbellek veya güvenli varsayılan içerik devreye girer.
2. **Akıllı Önbellek (Smart Caching):**
   * API hız sınırına (120 req/dk) takılmamak ve sayfa yüklenme sürelerini 20ms altında tutmak için CI4 dahili önbelleği (`cacheTTL = 600sn`) korunur.
3. **Pikselsel Tasarım Garantisi:**
   * Yapılacak hiçbir backend veya API güncellemesi mevcut Bootstrap 5.3 + Vanilla CSS tasarım bütünlüğünü bozmaz.
4. **WAF & Rate Limit Uyumlu İstekler:**
   * İstekler gereksiz döngülere sokulmaz, paralel toplu istekler yerine önbellekli tekil sorgular kullanılır.
