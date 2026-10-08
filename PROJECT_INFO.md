# Ufka Yolculuk Web Platformu — Proje Hafızası ve Teknik Kılavuz (PROJECT_INFO)

Bu dosya, projenin mimarisini, sunucu yapılandırmasını, hayata geçirilmiş özellikleri ve gelecekteki backend geliştirme yol haritasını eksiksiz hatırlamak amacıyla hazırlanmıştır.

---

## 1. Proje Genel Bakışı
- **Proje Adı**: Ufka Yolculuk Bilgi ve Kültür Yarışması Web Platformu
- **Canlı Geliştirme Adresi**: `http://localufkayolculuk.com/`
- **Geliştirme Ortamı**: WampServer 64
- **Web Sunucusu**: Apache 2.4.62 (Win64)
- **PHP Sürümü**: PHP 8.2.26
- **Framework**: **CodeIgniter 4 (v4.7.4)**
- **Veritabanı Motoru**: MySQL 8.x / MariaDB
- **Frontend Mimarisi**: Bootstrap 5.3 + Özel CSS (Vanilla) + Vanilla JS (ES6+)

---

## 2. Sunucu & VirtualHost Yapılandırması

WampServer Apache sanal sunucusunda proje kök dizini aşağıdaki gibi tanımlıdır:
```apache
<VirtualHost *:80>
    ServerName localufkayolculuk.com
    DocumentRoot "c:/wamp64/www/ufkayolculuk"
    <Directory "c:/wamp64/www/ufkayolculuk/">
        Options +Indexes +Includes +FollowSymLinks +MultiViews
        AllowOverride All
        Require local
    </Directory>
</VirtualHost>
```

### Şeffaf Dizin Yönlendirmesi (.htaccess)
Wamp'ın `DocumentRoot` ayarı doğrudan projenin ana klasörünü (`c:/wamp64/www/ufkayolculuk`) işaret ettiği için, kök dizindeki `.htaccess` dosyası ile:
1. `http://localufkayolculuk.com/frontend/` istekleri doğrudan ham HTML/CSS/JS arşivine yönlendirilir.
2. Diğer tüm dinamik sayfa ve statik varlık istekleri şeffaf olarak `public/` klasörüne iletilir.
3. Böylece tarayıcıda `/public` ön eki görünmez ve temiz URL yapısı korunur.

---

## 3. Dizin ve Dosya Mimarisi

```
c:/wamp64/www/ufkayolculuk/
├── .env                       # CodeIgniter 4 ortam ayarları (development, baseURL: http://localufkayolculuk.com/)
├── .htaccess                  # Kök yönlendirme kuralları (public & frontend ayrımı)
├── PROJECT_INFO.md            # [BU DOSYA] Proje hafızası ve teknik kılavuz
├── composer.json              # Bağımlılık yöneticisi
├── spark                      # CodeIgniter 4 CLI aracı
│
├── frontend/                  # SAF HTML/CSS/JS ARŞİVİ (Kullanıcının yaptığı son güncellemeler dahil)
│   ├── index.html             # Proje sunum ve vitrin portalı
│   ├── home.html              # Anasayfa ham şablonu
│   ├── duyurular.html         # Duyurular sayfası ham şablonu
│   ├── oduller.html           # Ödüller sayfası ham şablonu
│   ├── iletisim.html          # İletişim & ilçe temsilcilikleri ham şablonu
│   ├── sayfa-detay.html       # Sayfa/Haber detay ham şablonu
│   └── assets/                # Orijinal CSS, JS, görsel ve ikon varlıkları
│
├── app/                       # CodeIgniter 4 MVC Uygulama Katmanı
│   ├── Config/
│   │   ├── App.php            # baseURL: http://localufkayolculuk.com/, indexPage: ''
│   │   └── Routes.php         # Dinamik rotalar
│   ├── Controllers/
│   │   ├── Home.php           # Anasayfa denetleyicisi
│   │   ├── Duyurular.php      # Duyurular denetleyicisi
│   │   ├── Oduller.php        # Ödüller denetleyicisi
│   │   ├── Iletisim.php       # İletişim formu ve temsilcilikler (index & gonder)
│   │   └── Sayfa.php          # Kurumsal detay sayfaları
│   └── Views/
│       ├── layouts/
│       │   └── main.php       # Master Layout (HTML kabuğu, fontlar, CSS/JS, modallar)
│       ├── partials/
│       │   ├── header.php     # Ortak üst menü ve dinamik aktif sayfa algılama
│       │   ├── footer.php     # Ortak alt bilgi, market butonları ve sosyal medya
│       │   └── modals.php     # Giriş yap, kitap detay, oyun ve medya modalları
│       ├── home.php           # Anasayfa görünümü
│       ├── duyurular.php      # Duyurular görünümü
│       ├── oduller.php        # Ödüller görünümü
│       ├── iletisim.php       # İletişim görünümü
│       └── sayfa_detay.php    # Sayfa detay görünümü
│
├── public/                    # Web Sunucusu Kökü (Public Assets)
│   ├── .htaccess              # CodeIgniter 4 URL yeniden yazım kuralları
│   ├── index.php              # CI4 ön uç denetleyicisi (Front Controller)
│   └── assets/
│       ├── css/style.css      # Ana stil dosyası (100KB+ zengin tasarım tokenları)
│       ├── js/main.js         # Ana etkileşim ve mantık motoru (82KB+)
│       └── images/            # 3D kitaplar, rozetler, bayraklar ve SVG ikon kütüphanesi
│
├── writable/                  # Oturum, log ve önbellek dizini
└── vendor/                    # Composer bağımlılıkları (CI4 çekirdeği)
```

---

## 4. Kayıtlı Rotalar (Routes)

| Metot | URL Yolu | Denetleyici / Eylem | Açıklama |
| :--- | :--- | :--- | :--- |
| `GET/HEAD` | `/` | `Home::index` | Anasayfa (Hero, Slider, Tarihler Carousel, Kitaplar, SSS vb.) |
| `GET/HEAD` | `/duyurular` | `Duyurular::index` | Duyurular ve Haberler Portalı |
| `GET/HEAD` | `/oduller` | `Oduller::index` | Türkiye Geneli, İl, İlçe ve Okul Başarı Ödülleri |
| `GET/HEAD` | `/iletisim` | `Iletisim::index` | İletişim Formu, 81 İl ve İlçe Temsilcilikleri |
| `POST` | `/iletisim/gonder` | `Iletisim::gonder` | İletişim formu veri doğrulama ve AJAX işleyicisi |
| `GET/HEAD` | `/sayfa-detay` | `Sayfa::detay` | Hakkımızda, Misyon & Vizyon kurumsal detay şablonu |
| `GET/HEAD` | `/sayfa/(:segment)` | `Sayfa::detay/$1` | Dinamik slug parametreli kurumsal sayfa rotası |
| `DIRECT` | `/frontend/` | Apache Static | Saf HTML/CSS/JS frontend arşivi |

---

## 5. Hayata Geçirilen Dinamik İş Mantıkları & Özellikler

### 1. Önemli Tarihler Carousel & Canlı Geri Sayım (API `getExams` Entegrasyonu)
- **Konum**: `app/Controllers/Home.php`, `app/Services/UfkaApiService.php`, `app/Views/home.php` & `public/assets/js/main.js` (`initDatesAndCountdown`)
- **İşlev**: API'nin `getExams` uç noktasından çekilen gerçek online sınav tarih ve saatleri (Ortaokul Sınavı, İlkokul Sınavı, Yetişkin Sınavı, İlahiyat Sınavı) ile sınav kurallarında ilan edilen Cevap Anahtarı ve Sonuç İlanı tarihleri dinamik olarak derlenir. Carousel okları veya sayfalama noktalarıyla her slayta geçildiğinde, sağ paneldeki geri sayım sayacı anlık olarak ilgili sınavın hedef tarih ve saatine senkronize olur. "Yarışma Takvimini İncele" butonu API'deki yüksek çözünürlüklü resmi takvim görselinin bulunduğu `/sayfa/takvimi` sayfasına yönlendirir.

### 2. İletişim Sayfası & Dinamik Temsilcilik Bulucu
- **Konum**: `app/Views/iletisim.php` & `public/assets/js/main.js` (`initRepFinder`)
- **İşlev**: 81 il ve tüm ilçeleri kapsayan dinamik veri yapısı. İl ve ilçe seçildiğinde temsilci adı, yetkili kulüp ve telefon anında değişir. Hızlı arama (`tel:`) ve WhatsApp (`wa.me`) butonları seçilen temsilciye bağlanır.

### 3. İletişim Formu Sınırlandırmaları & Canlı Sayaç
- **Konum**: `app/Views/iletisim.php`, `public/assets/css/style.css`, `public/assets/js/main.js`
- **İşlev**: Mesaj `textarea` alanı `resize: none !important;` ile kilitlendi. Maksimum 500 karakter sınırı (`maxlength="500"`) ve sağ alt köşede `0 / 500` anlık sayaç eklendi.

### 4. Konya İlçe & Okul Başarı Ödülleri
- **Konum**: `app/Views/oduller.php` & `public/assets/js/main.js` (`formatAwards`)
- **İşlev**: Konya'nın en büyük 10 ilçesinde (Selçuklu, Meram, Karatay, Ereğli, Akşehir, Beyşehir, Seydişehir, Çumra, Cihanbeyli, Ilgın) **1. dereceden 10. dereceye kadar** tüm ödüller ayrı derece rozetleriyle listelenir. Eski `|` ayraçları altın madalya/yıldız SVG rozet ikonları (`.award-sep-icon`) ile değiştirilmiştir.

### 5. Header Dropdown Seperatörlerinin Kaldırılması
- **Konum**: `app/Views/partials/header.php`
- **İşlev**: Üst menü açılır pencerelerindeki yatay `<hr class="dropdown-divider">` çizgileri kaldırılarak modern ve ferah bir tasarım elde edilmiştir.

### 6. Anasayfa Duyurular & WhatsApp Kanal CTA Dengelemesi
- **Konum**: `app/Views/home.php`
- **İşlev**: Önemli Tarihler kartı ile yanındaki Duyurular listesinin alt boşluğu giderilmiş; 4. güncel duyuru ve alt kısma şık bir WhatsApp Duyuru Kanalı eylem çubuğu (`btn-schedule-integrated`) eklenerek pikselsel yükseklik eşitliği sağlanmıştır.

### 7. Post Detay Paylaşım Butonları & WhatsApp Entegrasyonu
- **Konum**: `app/Views/sayfa_detay.php` & `public/assets/js/main.js` (`window.shareArticle`)
- **İşlev**: Açık metin butonlar yerine WhatsApp, Telegram, X, Facebook, LinkedIn ve Bağlantıyı Kopyala için dairesel ikon butonlar yerleştirilmiştir. Paylaşım tıklandığında dinamik olarak sayfa başlığı ve aktif sayfa linki (`window.location.href`) mesaja eklenir. Sağ taraftaki "Sorularınız mı Var?" alanında yeşil WhatsApp ikonları ve destek hattı aktiftir.

---

## 6. Veritabanı Bilgileri & Back-End Yol Haritası

### Aktif Veritabanı Bağlantısı:
- **Veritabanı Adı**: `ufka_yolculuk`
- **Kullanıcı Adı**: `root`
- **Şifre**: *(boş)*
- **Sunucu / Host**: `localhost:3306`
- **Sürücü**: `MySQLi`
- **Bağlantı Durumu**: ✅ Aktif ve Doğrulandı (`.env` üzerinde tanımlandı, CI4 bağlantı testi başarılı)

### Sonraki Adımlar:
1. **Veritabanı Tabloları & Migration'lar**:
   - `contact_messages` (İletişim formundan gelen mesajlar: ad, telefon, e-posta, konu, mesaj, ip, tarih)
   - `announcements` (Duyurular & haberler: başlık, özet, içerik, görsel, kategori, tarih, durum)
   - `representatives` (İl ve ilçe temsilcilikleri: il, ilçe, yetkili_adi, kulup_adi, telefon, sira)
   - `awards` (Yarışma ödülleri: kategori, derece, odul_adi, miktar/aciklama)
2. **Model Katmanı (CI4 Models)**:
   - `ContactMessageModel`, `AnnouncementModel`, `RepresentativeModel`, `AwardModel`.
3. **İletişim Formunun Veritabanına Kaydedilmesi**:
   - `Iletisim::gonder` eyleminin gelen formu doğrudan `contact_messages` tablosuna kaydetmesi.
4. **Admin Yönetim Paneli**:
   - Duyuru ekleme/düzenleme, ilçe temsilcilerini güncelleme ve gelen mesajları listeleme.

---

## 7. Merkezi REST API Entegrasyonu (`ufkayolculuk.com/rest`)

Ufka Yolculuk merkezi veritabanı ile çift yönlü çalışan resmi REST API sistemi projeye entegre edilmiştir.

### API Kimlik ve Bağlantı Bilgileri:
- **Kılavuz / Dökümantasyon**: `https://ufkayolculuk.com/rest`
- **Base REST URL**: `https://ufkayolculuk.com/rest/get/`
- **Kullanıcı Adı**: `uy_Rest-Worker`
- **Şifre**: `UfkA_Yol-1448`
- **Uploads / Medya URL**: `https://yonetim.ufkayolculuk.com/`
- **Kimlik Doğrulama Türü**: HTTP Basic Auth
- **Geliştirilen Servis Sınıfı**: `app/Services/UfkaApiService.php`
- **Konfigürasyon Sınıfı**: `app/Config/UfkaApi.php`
- **CLI Test Komutu**: `php spark api:test` (Tüm uç noktaları test eder)

### Kullanılabilir Uç Noktalar ve Metotlar:
| Uç Nokta (Endpoint) | Servis Metodu | Açıklama |
| :--- | :--- | :--- |
| `getWebContents` | `$api->getWebContents()` | Tüm web içerikleri, duyurular, haberler, yarışma şartnamesi ve rehberler |
| `getWebContents` (Filtreli) | `$api->getAnnouncements($limit)` | Yalnızca `annoucement` tipindeki güncel duyuru ve haberleri çeker |
| `getBookCategories` | `$api->getBookCategories()` | İlkokul, ortaokul, lise, yetişkin kategorileri ve kategorilere bağlı kitaplar |
| `getBooks` | `$api->getBooks()` | Tüm aktif kitapların kapakları, ses dosyaları (MP3) ve PDF dosya yolları |
| `getBook/{id}` | `$api->getBook($id)` | Tekil kitap detayları ve sayfa sayfa resim URL listesi |
| `getAwards` / `getAwards/{city_id}` | `$api->getAwards($cityId)` | Türkiye geneli ve 81 il bazında tanımlı nakit ve Umre ödülleri |
| `getExams` | `$api->getExams()` | Çevrim içi deneme ve online sınav listesi |
| `getMenu/{header\|footer}` | `$api->getMenu($type)` | Header ve footer navigasyon menü ağaçları |
| `getUfkaYolculukUser` | `$api->verifyUser($phone, $birthdate)` | Yarışmacı telefon ve doğum tarihiyle kullanıcı doğrulama/sorgulama |
| Medya Dönüştürücü | `$api->getMediaUrl($relativePath)` | Göreli resim/dosya yollarını tam yönetim URL'sine (`yonetim.ufkayolculuk.com/...`) dönüştürür |

### Akıllı Önbellekleme (Cache):
Sistemin aşırı istek yapmasını önlemek ve sayfaların anında açılmasını sağlamak için API yanıtları `cacheTTL = 600` (10 dakika) boyunca CodeIgniter 4 dahili önbelleğinde tutulur. İstenirse `$useCache = false` parametresiyle doğrudan canlı veri çekilebilir.

---

## 8. Duyurular ve Haberler API Entegrasyonu (Tamamlandı)

Ufka Yolculuk platformundaki tüm duyuru ve haber akışı REST API (`getWebContents`) üzerinden dinamik hale getirilmiştir:

### 1. Duyurular Listeleme Sayfası (`/duyurular`)
- **Controller**: `app/Controllers/Duyurular.php`
- **View**: `app/Views/duyurular.php`
- **Özellikler**:
  - API'den gelen duyurular ID'ye göre sıralı (en yeni en başta) listelenir.
  - Dinamik sayaç rozetleri: *Tümü (X)*, *📢 Duyurular (Y)*, *📰 Haberler (Z)*, *🌟 Etkinlikler (T)*.
  - Canlı kategori filtreleme hapları (Pills) ve anlık başlık/özet arama çubuğu (Vanilla JS).
  - Görsel desteği: API'den gelen `image` veya `primary_category.image` yolları `https://yonetim.ufkayolculuk.com/` ile bağlanır, yoksa yerel yedek görsel kullanılır.
  - Kartlardaki "Detayları Oku" butonu doğrudan `/sayfa/{slug}` veya `/sayfa/{id}` adresine yönlendirir.

### 2. Anasayfa Duyurular Kartı (`/`)
- **Controller**: `app/Controllers/Home.php`
- **View**: `app/Views/home.php`
- **Özellikler**:
  - Önemli Tarihler takvim kartıyla pikselsel görsel dengeyi korumak amacıyla API'den en güncel **2 duyuru** çekilir (`$api->getAnnouncements(2)`).
  - Tarih, başlık, küçük resim ve detay yönlendirme oku içerir.
  - Kartın altında WhatsApp Duyuru Kanalı butonu yer alır.
  - Tüm duyurular için sağ üstteki "Tüm Duyurular" linki `/duyurular` sayfasına yönlendirir.

### 3. Dinamik Duyuru ve İçerik Detay Sayfası (`/sayfa/(:segment)`)
- **Controller**: `app/Controllers/Sayfa.php`
- **View**: `app/Views/sayfa_detay.php`
- **Özellikler**:
  - Gelen `slug` veya `id` parametresine göre API'den ilgili içerik `getWebContent($slugOrId)` metoduyla çekilir.
  - Başlık, yayın tarihi, kategori etiketi Hero banner üzerinde gösterilir.
  - Breadcrumb: `Ana Sayfa / Duyurular & Haberler / {Başlık}`.
  - Varsa öne çıkan görsel ve lead özet metni; ardından API'den gelen zengin HTML gövdesi (`body`) responsive olarak sunulur.
  - Gövde içerisindeki göreceli resim yolları (`src="uploads/..."`) otomatik olarak mutlak yönetim URL'sine dönüştürülür.
  - **Dinamik Paylaşım Butonları**: WhatsApp, Twitter/X, Facebook, Telegram ve Bağlantıyı Kopyala butonları sayfa başlığı ve canlı `current_url()` linkini paylaşır.
  - **Sağ Yan Panel (Sidebar)**: En güncel 5 duyuruyu küçük resimleriyle gösteren "Son Duyurular" kartı, kurumsal alt sayfalar menüsü ve yeşil WhatsApp ikonlu "Sorularınız mı Var?" destek alanı yer alır.
  - **Geriye Dönük Uyumluluk**: Parametresiz `/sayfa-detay` veya `/sayfa/hakkimizda` çağrıldığında varsayılan zengin "Hakkımızda & Misyonumuz" kurumsal sayfası yüklenir.

---

## 9. Kategoriler ve Yarışma Kitapları API Entegrasyonu (Tamamlandı)

Yarışma kategorileri ve yarışma kitapları REST API (`getBookCategories`, `getBooks`, `getBook`) üzerinden dinamik hale getirilmiştir:

### 1. Servis ve Veri Katmanı
- **Metot**: `UfkaApiService::getCompetitionCategories()`
- **Eşleştirilen 4 Ana Kategori ve Kitaplar**:
  - **İlkokul Kategorisi** (ID: 6) ➔ *Kuşların Çağrısı* (Kitap ID: 8)
    - Tema: Yeşil (`theme-green`), Sınıf: `1 - 4. Sınıf`, Yaş: `6 - 10 Yaş`
    - Kapak: `https://yonetim.ufkayolculuk.com/uploads/2025-12/ilkokul_...webp`
    - Seslendirme: `https://yonetim.ufkayolculuk.com/uploads/2025-10/ilkokul-kuslarin-cagrisi.mp3`
  - **Ortaokul Kategorisi** (ID: 7) ➔ *Tevhid Muhafızları* (Kitap ID: 11)
    - Tema: Kehribar/Amber (`theme-amber`), Sınıf: `5 - 8. Sınıf`, Yaş: `10 - 14 Yaş`
    - Kapak: `https://yonetim.ufkayolculuk.com/uploads/2025-12/ortaokul_...webp`
    - Seslendirme: `https://yonetim.ufkayolculuk.com/uploads/2025-10/tevhid-muhafizlari.mp3`
  - **Lise Kategorisi** (ID: 8) ➔ *Gördüğüme görmediğime* (Kitap ID: 12)
    - Tema: Mavi (`theme-blue`), Sınıf: `9 - 12. Sınıf`, Yaş: `14 - 18 Yaş`
    - Kapak: `https://yonetim.ufkayolculuk.com/uploads/2025-12/lise_...webp`
    - Seslendirme: `https://yonetim.ufkayolculuk.com/uploads/2025-10/lise-gordugume-gormedigime.mp3`
  - **Yetişkin Kategorisi** (ID: 9) ➔ *Nasıl İnanmalı?* (Kitap ID: 13)
    - Tema: Mor (`theme-purple`), Kapsam: `18+ Yaş & Üniversite / Tüm Yetişkinler`
    - Kapak: `https://yonetim.ufkayolculuk.com/uploads/2025-12/yetiskin_...webp`
    - Seslendirme: `https://yonetim.ufkayolculuk.com/uploads/2025-09/Nasil-inanmali-seslikitap_v2.mp3`

### 2. Anasayfa 3D Kitap Vitrini (`#kategoriler`)
- API'den gelen 4 kitap ve kategori döngü ile render edilir.
- Canlı kategori filtre sekmeleri (`Tümü`, `İlkokul`, `Ortaokul`, `Lise`, `Yetişkin`) kusursuz çalışır.
- Kart görselleri API'deki orijinal kapaklar üzerinden yüklenir; yüklenememe durumuna karşın akıllı yedek görsel mekanizması (`onerror fallback`) devrededir.
- 3D hover animasyonları ve "Kitabı İncele" aksiyon butonları korunmuştur.

### 3. Kitap Detay Modalı (`#bookPreviewModal`) & Canlı Ses Oynatıcısı
- "Kitabı İncele" butonuna tıklandığında açılan modal `window.UFKA_BOOK_DATA` üzerinden anlık olarak beslenir.
- Kitabın tam adı, kademe ve yaş bilgileri, API'den gelen pedagojik açıklama metni görüntülenir.
- **Canlı HTML5 Mini Ses Çaları**: API'deki gerçek `sound_file` MP3 ses dosyası dinamik olarak oynatılır. Oynat/Durdur (`▶ / ❚❚`), geçen süre/toplam süre ve tıklanabilir interaktif ses ilerleme çubuğu mevcuttur. Modal kapatıldığında ses otomatik olarak durdurulur.

---

## 10. API Entegrasyon Yol Haritası (Roadmap v2.0)

Güncellenen API mimarisine, yeni uç noktalara ve güvenlik kurallarına göre revize edilen yol haritası:
- 📄 **Detaylı Dosya:** [API_ENTEGRASYON_YOL_HARITASI.md](file:///c:/wamp64/www/ufkayolculuk/API_ENTEGRASYON_YOL_HARITASI.md)
- **Yeni Faz Planı (Roadmap v2.0):**
  1. **Faz 1:** Önemli Tarihler & Canlı Geri Sayım (`getImportantDates` - Statik tarihleri kaldırıp resmi API'ye geçiş)
  2. **Faz 2:** Medya & Podcast Vitrini (`getMediaContents` - Statik mock'ları kaldırıp resmi API'ye geçiş)
  3. **Faz 3:** İçerik Çekme Optimizasyonu (`getWebContents?type=annoucement|sss` sunucu taraflı filtreleme)
  4. **Faz 4:** Hero Banner Slider Entegrasyonu (`getSliders` dinamik slider + yerel fallback)
  5. **Faz 5:** Bearer Token Güvenlik Mimarisi (`token` & `refresh` - 2 saatlik access_token yönetimi)
  6. **Faz 6:** Çoklu Dil & Menü Ağacı (`getMenu?lang=tr|en` & `getWebMenus`)
  7. **Faz 7:** Canlı Mini Soru & Deneme Simülatörü (`getQuestions/{category_id}` - zorunlu kategori kuralıyla)

---

## 11. Ödüller Sistemi API Entegrasyonu (Tamamlandı)

Yarışma ödülleri sistemi (`/oduller`) REST API (`getAwards`) üzerinden tam dinamik hale getirilmiştir:
- **Controller**: `app/Controllers/Oduller.php`
- **Model / Servis**: `app/Services/UfkaApiService.php`
- **View**: `app/Views/oduller.php`
- **JS / Etkileşim**: `public/assets/js/main.js` (`initAwardsPage`)
- **Özellikler**:
  1. **Türkiye Geneli Merkezi Ödüller**:
     - İlkokul, Ortaokul, Lise, Yetişkin, İlahiyat ve Takım Liderleri sekmeleri API verisiyle dinamik listelenir.
     - 1., 2. ve 3. podyum derecelerinde Umre ve nakit ödülleri (35.000₺, 30.000₺, 25.000₺) gösterilir.
     - 4. - 100. sıralama aralıkları otomatik olarak 15.000₺, 12.000₺, 10.000₺ ve 5.000₺ blokları halinde gruplanır.
  2. **81 İl ve Yurtdışı Dinamik Seçimi**:
     - Dropdown içinde 81 il alfabetik Türkçe sıralama ile listelenir.
  3. **İl & İlçe & Kategori Bazlı Yerel Ödüller**:
     - İl değiştirildiğinde sayfa yenilenmeden podyum, mansiyon ödülü ve ilçe başarı grupları anlık güncellenir.
     - Yerel ödüller kartında kategori sekmelerine (İlkokul, Ortaokul, Lise, Yetişkin vb.) tıklandığında o kategorinin ilçe sponsor ve başarı ödülleri anlık filtrelenir.
  4. **Performans & Dayanıklılık**:
     - Tüm 81 ilin verisi sunucu tarafında önceden derlenerek sayfaya `window.UFKA_CITY_AWARDS` olarak enjekte edilir; eksik veya özel durumlar için `/oduller/get-city-awards/(:segment)` AJAX endpoint'i hazır bekler.

---

## 12. Sıkça Sorulan Sorular (SSS) API Entegrasyonu (Tamamlandı)

Ufka Yolculuk SSS sistemi REST API (`getWebContents` type=`sss`) üzerinden tam dinamik hale getirilmiştir:
- **Model / Servis**: `app/Services/UfkaApiService.php` (`getFaqList()`)
- **Controller**: `app/Controllers/Home.php` & `app/Controllers/Oduller.php`
- **View**: `app/Views/home.php` (`#sss`) & `app/Views/oduller.php` (`#awardsFaqAccordion`)
- **JS / Etkileşim**: `public/assets/js/main.js` (`initFaqSection`)
- **Özellikler**:
  1. **18 Gerçek Soru ve Cevap**: API'deki tüm SSS içerikleri çekilerek kategori ve soru başlığına göre sınıflandırılır.
  2. **Kategori Filtreleme**: *Tümü (18), Yarışma & Katılım (7), Ödüller (3), Yarışma Kitapları (2), Sınav Kuralları (5), Takım Lideri (1)* sekmeleriyle anlık filtreleme.
  3. **Canlı Arama**: Başlık ve cevap metinlerinde anlık arama (arama temizleme butonu ve boş sonuç uyarısı ile).
  4. **Entegre AI Desteği**: Sorusu listede olmayan kullanıcılar için tek tıkla Ufyo AI asistanını açma butonu.
  5. **Header Menü Entegrasyonu**: Header'daki "Sıkça Sorulan Sorular" bağlantısı doğrudan `#sss` bölümüne yumuşak geçiş yapar.

---

## 13. Canlı API Dokümantasyonu & Senkronizasyon Kuralı (.agents/rules/api_sync_rules.md)

- **Resmi ve Kapsamlı Dokümantasyon Dosyası:** [UFKA_YOLCULUK_REST_API_DOKUMANTASYONU.md](file:///c:/wamp64/www/ufkayolculuk/UFKA_YOLCULUK_REST_API_DOKUMANTASYONU.md) (26 uç nokta, WAF kuralları, Rate Limit 120/dk, Bearer token ve cURL örnekleri).
- **Otomatik API Senkronizasyon Kuralı:** [.agents/rules/api_sync_rules.md](file:///c:/wamp64/www/ufkayolculuk/.agents/rules/api_sync_rules.md)
  - Kullanıcı *"api güncellendi"*, *"api değişiklikleri"* dediğinde Antigravity otomatik olarak `https://ufkayolculuk.com/rest` adresine `uy_Rest-Worker` / `UfkA_Yol-1448` ile bağlanır.
  - Canlı dokümanı yerel dokümantasyonla karşılaştırıp farkları (yeni uç noktalar, parametre zorunlulukları, WAF/Rate limit değişimleri) analiz eder ve kullanıcıya fark raporu sunar.

