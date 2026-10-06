# Ufka Yolculuk — REST API Entegrasyon Yol Haritası ve Teknik Analiz

> **Belge Sürümü:** 1.0  
> **Son Güncelleme:** 28 Eylül 2026  
> **Hazırlayan:** Antigravity AI & Ufka Yolculuk Geliştirme Ekibi  
> **Hedef Platform:** CodeIgniter 4 (PHP 8.2) & WAMP Sanal Sunucu (`http://localufkayolculuk.com/`)

---

## 1. Yönetici Özeti ve Mevcut Durum Analizi

Ufka Yolculuk platformu için geliştirilen merkezi servis katmanı (`App\Services\UfkaApiService`), resmi REST API uç noktaları (`https://ufkayolculuk.com/rest/get/`) ve yönetim medya sunucusu (`https://yonetim.ufkayolculuk.com/`) ile tam uyumlu çalışmaktadır.

### 🟢 Tamamlanan Entegrasyonlar
1. **Duyurular & Haberler Modülü (`/duyurular`):**
   - API `getWebContents` üzerinden tüm güncel duyurular dinamik çekiliyor.
   - Gerçek zamanlı kategori filtreleri (*Tümü, Duyurular, Haberler, Etkinlikler*) ve canlı arama çubuğu devrede.
2. **Anasayfa Güncel Duyurular Kartı (`/`):**
   - Tasarım estetiğini ve takvim kartı dengesini korumak için en güncel 2 duyuru çekiliyor.
3. **Dinamik Duyuru & İçerik Detay Sayfası (`/sayfa/:slug`):**
   - Tüm haber, duyuru ve kurumsal makaleler API'den çekiliyor.
   - Sosyal medya paylaşım butonları, yan panel son duyuruları ve WhatsApp destek bağlantısı aktif.
4. **Önemli Tarihler & Canlı Geri Sayım Sayacı (`#takvim`):**
   - `getExams` uç noktasından sınav başlangıç, son giriş ve sonuç ilan tarihleri API'den çekiliyor.
5. **Kategoriler & Yarışma Kitapları Vitrini (`#kategoriler`):**
   - `getBookCategories`, `getBooks` ve `getBook` uç noktaları 4 ana kategoriyle (İlkokul, Ortaokul, Lise, Yetişkin) eşleştirildi.
   - Orijinal kitap kapakları, pedagojik özetler ve **canlı HTML5 MP3 ses oynatıcısı** (`sound_file`) bağlandı.

---

## 2. API Uç Noktaları (Endpoints) ve Yetenek Envanteri

Yapılan canlı sistem testleri (`php spark api:test`) ve kimlik doğrulamalı API kılavuzu analizi sonucunda **19 farklı uç noktanın** sunduğu veri haritası aşağıdaki gibidir:

| # | Uç Nokta (Endpoint) | HTTP Metodu | Sağladığı Veri ve İçerik | Sitedeki Karşılığı / Kullanım Alanı |
|---|---|---|---|---|
| **1** | `getAwards` / `getAwards/{city_id}` | POST / GET | 736 adet Türkiye geneli ve 81 il bazında ödül (Umre, nakit ödüller, derece bazlı) | Ödüller Sayfası (`/oduller`) & Anasayfa Ödül Vitrini (`#oduller`) |
| **2** | `getCities` | POST / GET | Türkiye'nin 81 ilinin plaka ID ve alfabetik isim listesi | Ödüller & İletişim sayfasındaki il seçim dropdown'ları |
| **3** | `getWebContents` | POST / GET | 111 aktif içerik: Duyuru (18), Haber (5), SSS (18), Kurumsal/Rehber (70) | `/duyurular`, `/sayfa/:slug`, Anasayfa `#sss` akordeonu |
| **4** | `getWebCategories` / `webCategories` | POST / GET | Web içerik hiyerarşisi ve kategori ağacı | Duyuru/içerik etiketleme ve filtreleme sistemleri |
| **5** | `getBookCategories` | POST / GET | 12 kategori tanımı ve kategorilere bağlı kitap listeleri | `#kategoriler` vitrini ve modal detayları |
| **6** | `getBooks` | POST / GET | 4 aktif yarışma kitabı (İsim, kapak, ses dosyası, XML, PDF yolları) | Kitap vitrini ve sesli dinleme kütüphanesi |
| **7** | `getBook/{id}` | POST / GET | Tekil kitap verisi ve 240+ sayfa resim URL listesi | E-Kitap online okuma modalı / portalı |
| **8** | `getExams` | POST / GET | Çevrim içi sınavlar, başlama, bitiş ve son giriş saatleri | `#takvim` tarih kartları ve canlı geri sayım |
| **9** | `getUfkaYolculukUser` | POST | Telefon (`mobile`) ve doğum tarihi (`birthdate`) ile yarışmacı sorgulama | Giriş Yap Modalı (`#loginModal`) ve yarışmacı doğrulama |
| **10**| `getUserData/{user_id}` | POST / GET | Kullanıcının okuma geçmişi ve profil verileri | Yarışmacı paneli / giriş sonrası kullanıcı durumu |
| **11**| `getProfileMenu` | POST / GET | Kullanıcı profil navigasyon menü linkleri | Yarışmacı giriş yaptıktan sonraki profil menüsü |
| **12**| `getMenu/{header\|footer}` | POST / GET | Header ve footer navigasyon menü ağacı | `header.php` ve `footer.php` dinamik menüleri |
| **13**| `getQuestions/{category_id}` | POST / GET | 49 adet çoktan seçmeli deneme sorusu (Soru gövdesi + A, B, C, D seçenekleri) | Anasayfa "Online Soru Çöz" ve Mini Deneme Testi |
| **14**| `createQuestionForm` | POST | `user_id` ve `exam_id` ile yeni sınav oturumu başlatma | Çevrim içi deneme sınavı oturumu oluşturma |
| **15**| `postAnswer` | POST | Soruya verilen cevabı kaydetme (`question_id`, `answer`) | Deneme sınavı anlık cevap kaydı |
| **16**| `saveUserPage` | POST | Okunan son kitap sayfasını kaydetme | E-Kitap okuyucu ilerleme takibi |
| **17**| `getPage/{id}` | POST / GET | ID bazlı kurumsal sayfa gövdesi | Mobil/web kurumsal bilgi sayfaları |
| **18**| `getExamCategories` | POST / GET | Sınav kademe kategorileri | Sınav filtreleme modülleri |
| **19**| Medya Dönüştürücü | PHP Yardımcı | `uploads/...` yollarını `https://yonetim.ufkayolculuk.com/` adresine bağlar | Tüm görsel, PDF ve MP3 ses dosyaları |

---

## 3. Web Sitesinde API'den Çekilebilecek Alanlar Matrisi

Web sitemizdeki tüm sayfalar ve bileşenler incelendiğinde API'den beslenebilecek alanlar şunlardır:

```
┌────────────────────────────────────────────────────────────────────────┐
│                   WEB SİTESİ API ENTEGRASYON HARİTASI                  │
└────────────────────────────────────────────────────────────────────────┘
                                    │
    ┌───────────────────────────────┼───────────────────────────────┐
    ▼                               ▼                               ▼
[ 1. ÖDÜLLER MODÜLÜ ]      [ 2. SIKÇA SORULAN SORULAR ]    [ 3. KURUMSAL SAYFALAR ]
- Türkiye Geneli Ödüller    - 18 Adet SSS Kaydı             - Yarışma Şartnamesi
- 81 İl Bazlı Ödüller       - Kategori Akordeonları         - Takvim & Yönerge
- getAwards + getCities     - getWebContents (type=sss)     - KVKK, Aydınlatma Metinleri
                                                            - Biz Kimiz & Misyon-Vizyon
    ┌───────────────────────────────┼───────────────────────────────┐
    ▼                               ▼                               ▼
[ 4. YARIŞMACI GİRİŞİ ]    [ 5. MENÜLER & NAVİGASYON ]     [ 6. İLETİŞİM & TEMSİLCİLİK ]
- Telefon + Doğum Tarihi    - Header Menü                   - 81 İl Dropdown Seçimi
- getUfkaYolculukUser       - Footer Menü                   - Temsilcilik Haritası
- Canlı Profil Durumu       - getMenu/{header|footer}       - Form Gönderimi (Session)
                                                            
    ┌───────────────────────────────┴───────────────────────────────┐
    ▼                                                               ▼
[ 7. VİDEO & MEDYA VİTRİNİ ]                       [ 8. ONLİNE SORU ÇÖZ & DENEME ]
- Medya Oynatıcı Modalı                             - 49 Adet Test Sorusu
- getWebContents (video-icerik-*)                   - getQuestions/{category_id}
- YouTube / Canlı İframe                            - İnteraktif Soru Çözüm Modalı
```

### Bölüm Bazlı Detaylar:
1. **Ödüller Sayfası (`/oduller`) & Anasayfa Ödül Vitrini (`#oduller`):**
   - Şu an statik HTML olan ödüller, API'deki 736 ödül kaydı ve 81 il ile dinamik hale gelecektir.
   - İl dropdown'ından bir il (örn. *İstanbul*, *Ankara*, *Konya*) seçildiğinde hem o ilin ödülleri hem Türkiye geneli ödülleri AJAX ile anında listelenecektir.
2. **Sıkça Sorulan Sorular (`#sss`):**
   - API'de `type = 'sss'` olan **18 adet resmi soru-cevap** mevcuttur (*Örn: "Danışman kategorisi", "Sınav giriş şartları" vb.*).
   - Anasayfadaki statik akordeon döngüye bağlanıp API'den gelecektir.
3. **Kurumsal & Hukuki Sayfalar (`/sayfa/:slug`):**
   - API'de 70 adet hazır kurumsal içerik bulunmaktadır:
     - `/sayfa/sartname` (Yarışma Şartnamesi)
     - `/sayfa/uy-kvkk-aydinlatma-metni` (KVKK Aydınlatma Metni)
     - `/sayfa/uy-mahremiyet-politikasi` (Gizlilik & Mahremiyet)
     - `/sayfa/UY-Veli-izin-Belgesi` (Veli İzin Belgesi)
     - `/sayfa/biz-kimiz` (Biz Kimiz?)
     - `/sayfa/misyon-vizyon` (Misyon ve Vizyon)
     - `/sayfa/resmi-onaylar` (Milli Eğitim Bakanlığı Resmi Onayları)
     - `/sayfa/takvimi` (Yarışma Takvimi Görseli)
4. **Yarışmacı Giriş Modalı (`#loginModal`):**
   - Giriş modalındaki Telefon No ve Doğum Tarihi alanları API'deki `getUfkaYolculukUser` uç noktasına AJAX ile bağlanacaktır.
   - Doğrulanan kullanıcının adı, soyadı ve kategorisi Header alanında *"Hoş geldin, Ahmet Yılmaz (Ortaokul)"* şeklinde oturumda gösterilecektir.
5. **İl Temsilcilikleri ve İletişim (`/iletisim`):**
   - `getCities` ile 81 il dinamik yüklenecek, il seçildiğinde o ilin iletişim ve koordinasyon bilgileri sunulacaktır.
6. **Dinamik Header & Footer Menüleri (`getMenu`):**
   - Üst menü ve alt footer linkleri yönetim panelinden değiştirildiğinde sitede otomatik güncellenecektir.
7. **Online Soru Çöz & Deneme Testi (`getQuestions`):**
   - API'deki 49 soru ile anasayfadaki "Deneme Sınavına Katıl" butonuna tıklandığında soru-cevap interaktif modalı açılabilecektir.

---

## 4. Sorunsuz Tamamlama Sıralaması (Adım Adım Yol Haritası)

Projeyi sıfır riskle, mevcut çalışan hiçbir tasarımı bozmadan ve en yüksek kullanıcı değerini en erken sağlayacak şekilde **6 Aşamalı (Fazlı)** sıralama ile kodlamamız önerilir:

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                      KODLAMA SIRALAMASI VE FAZ PLANI                        │
└─────────────────────────────────────────────────────────────────────────────┘
  FAZ 1 ──► Ödüller Sistemi (Anasayfa #oduller & /oduller Sayfası) [TAMAMLANDI]
    │       - getAwards ve getCities entegrasyonu
    │       - 81 İl AJAX dropdown filtresi
    ▼
  FAZ 2 ──► Sıkça Sorulan Sorular (/sss Bağımsız Sayfası) [TAMAMLANDI]
    │       - Tasarım gereği anasayfadan kaldırıldı, ayrı sayfa (/sss) yapıldı
    │       - getWebContents (type=sss) ile 18 soru dinamik, canlı arama ve 5 kategori filtreleme eklendi
    ▼
  FAZ 3 ──► Kurumsal, Hukuki & Kılavuz Sayfalar (/sayfa/:slug) [TAMAMLANDI]
    │       - Şartname, KVKK, Veli İzni, Biz Kimiz, Resmi Onaylar, Mahremiyet
    │       - getWebContent ile case-insensitive ve alias desteği
    │       - Dinamik Kurumsal sidebar, breadcrumb ve footer hızlı linkleri eklendi
    ▼
  FAZ 4 ──► İletişim Sayfası & 81 İl Temsilcilikleri (/iletisim) [TAMAMLANDI]
    │       - getAwardCities ile 81 il dinamik dropdown'ı ve URL query (?il=...) desteği
    │       - İl ve ilçe temsilcilikleri, kulüp ve direkt iletişim kutusu
    │       - İletişim formu AJAX POST (/iletisim/gonder) doğrulaması ve şık bildirimler
    ▼
  FAZ 5 ──► Yarışmacı Giriş Sistemi (loginModal -> getUfkaYolculukUser) [TAMAMLANDI]
    │       - Telefon + Doğum Tarihi AJAX doğrulaması
    │       - CI4 Session ile oturum açma & Header kullanıcı rozeti
    ▼
  FAZ 6 ──► Dinamik Menüler & Medya/Video Entegrasyonu (getMenu & Medya) [TAMAMLANDI]
    │       - Header/Footer menü ağacı (getMenu) ve kusursuz sayfa rota eşleştirmeleri
    │       - API video içerikleri (video-icerik-*) için modal oynatıcı (HTML5 .mp4 + iframe)
    ▼
  FAZ 7 ──► (İsteğe Bağlı Ek Modül) Canlı Mini Deneme Testi (getQuestions)
            - Kategoriye göre 10-15 soruluk anlık pratik test çözümü
```

---

### FAZ 1: Ödüller Sistemi (Anasayfa & `/oduller` Sayfası) - ✅ TAMAMLANDI
- **Durum:** ✅ Tamamlandı ve Canlı Doğrulandı
- **Kullanılan Uç Noktalar:** `getAwards`, `getAwards/{city_id}`, `getCities`
- **Uygulanan Geliştirmeler:**
  1. `UfkaApiService` servisine `getNationalAwardsFormatted()`, `getAwardCities()`, `getCityAwardsMap()` ve `getCityAwardsFormatted($cityName)` metotları eklendi.
  2. `app/Controllers/Oduller.php` üzerinden Türkiye geneli merkezi ödüller ve 81 ilin alfabetik listesi görünüme aktarıldı.
  3. `oduller/get-city-awards/(:segment)` rotası ve AJAX JSON endpoint'i tanımlandı.
  4. `app/Views/oduller.php` sayfasında Türkiye geneli ödül sekmeleri ve 81 il seçim dropdown'ı dinamik hale getirildi; ilk yükleme SEO ve performans için server-side render edildi.
  5. `public/assets/js/main.js` içindeki `initAwardsPage()` fonksiyonu API verisi, kategori filtreleme (İlkokul, Ortaokul, Lise, Yetişkin, İlahiyat, Takım Lideri) ve AJAX yedekleme ile donatıldı.
  6. İl ve kategori değiştirildiğinde podyum (🥇, 🥈, 🥉), 4.-10. mansiyon rozeti, ilçe/kulüp başarı grupları ve resmi tören notu anlık olarak kesintisiz güncellenmektedir.

---

### FAZ 2: Sıkça Sorulan Sorular (Anasayfa `#sss` Akordeonu & `/oduller` SSS) - ✅ TAMAMLANDI
- **Durum:** ✅ Tamamlandı ve Canlı Doğrulandı
- **Kullanılan Uç Noktalar:** `getWebContents(type: 'sss')`
- **Uygulanan Geliştirmeler:**
  1. `UfkaApiService` içine `getFaqList()` metodu eklendi. API'deki 18 gerçek SSS sorusunu ve cevaplarını çeker; *Yarışma & Katılım, Ödüller, Yarışma Kitapları, Sınav Kuralları, Takım Lideri* kategorilerine ayırır ve sayaçlarını derler.
  2. `Home.php` controller'ında `$faqs` verisi görünüme aktarıldı.
  3. `app/Views/home.php` üzerinde `#sss` id'li modern, responsive ve Bootstrap uyumlu SSS bölümü kodlandı.
  4. Gerçek zamanlı arama çubuğu (arama yapıldığında anında filtreleme ve ✕ temizleme butonu) ile kategori filtreleme hapları entegre edildi.
  5. Header navigasyon menüsündeki *"Yarışma Hakkında → Sıkça Sorulan Sorular (SSS)"* linki doğrudan bu bölüme yumuşak kayma (`scroll-margin-top: 80px`) ile bağlandı.
  6. `app/Controllers/Oduller.php` ve `app/Views/oduller.php` sayfalarındaki statik SSS soruları da API'deki resmi ödül SSS verileriyle senkronize edildi.

---

### FAZ 3: Kurumsal, Hukuki & Kılavuz Sayfalar (`/sayfa/:slug`)
- **Öncelik:** 🟠 Yüksek (SEO, güvenilirlik ve kurumsal kimlik)
- **Kullanılacak Uç Noktalar:** `getWebContents`, `getPage/{id}`
- **Yapılacaklar:**
  1. `Sayfa.php` controller'ında slug eşleşmesi zaten hazır durumda.
  2. Sitedeki kritik linklerin API slug'larıyla senkronize edilmesi:
     - Şartname linki: `/sayfa/sartname`
     - KVKK linki: `/sayfa/uy-kvkk-aydinlatma-metni`
     - Gizlilik Politikası: `/sayfa/uy-mahremiyet-politikasi`
     - Veli İzin Belgesi: `/sayfa/UY-Veli-izin-Belgesi`
     - Biz Kimiz?: `/sayfa/biz-kimiz`
     - Misyon ve Vizyon: `/sayfa/misyon-vizyon`
     - Resmi Onaylar: `/sayfa/resmi-onaylar`
  3. Footer ve alt linklerin bu rotalarla eşleştirilmesi.

---

### FAZ 4: İletişim Sayfası & 81 İl Temsilcilikleri (`/iletisim`) - ✅ TAMAMLANDI
- **Durum:** ✅ Tamamlandı ve Canlı Doğrulandı
- **Kullanılan Uç Noktalar:** `getAwardCities`, iletişim formu AJAX doğrulama
- **Yapılanlar:**
  1. İletişim sayfasındaki il seçim dropdown'ı dinamik 81 il ile dolduruldu (`?il=...` URL parametresi desteğiyle).
  2. İl seçildiğinde temsilcilik e-posta, telefon ve adres kutuları anında dinamikleştirildi.
  3. İletişim formu AJAX POST (`/iletisim/gonder`) doğrulaması ve şık Bootstrap alert geri bildirimleri entegre edildi.

---

### FAZ 5: Yarışmacı Giriş Sistemi (`#loginModal` ➔ `getUfkaYolculukUser`) - ✅ TAMAMLANDI
- **Durum:** ✅ Tamamlandı ve Canlı Doğrulandı
- **Kullanılan Uç Noktalar:** `getUfkaYolculukUser`, `verifyUser`
- **Yapılanlar:**
  1. `UfkaApiService` içine `verifyUser($phone, $birthDate)` metodu eklendi (telefon normalizasyonu ve API entegrasyonu).
  2. `app/Controllers/Auth.php` oluşturuldu (`login`, `logout`, `status` uç noktaları).
  3. Modal formundaki telefon (`0 (5XX) XXX XX XX` maskelemeli) ve doğum tarihi alanları AJAX ile doğrulandı.
  4. Giriş başarılı olduğunda oturum (`session`) açılarak Header'da yarışmacı profili ve çıkış butonu gösterildi.
  5. Doğrulama ve yarışmacı kontrol testleri başarıyla tamamlandı.

---

### FAZ 6: Dinamik Menüler & Video Medya Vitrini - ✅ TAMAMLANDI
- **Durum:** ✅ Tamamlandı ve Canlı Doğrulandı
- **Kullanılan Uç Noktalar:** `getMenu/header`, `getMenu/footer`, `getWebContents`
- **Yapılanlar:**
  1. `getMenu` çağrıları ve sağlam fallback menü yapısı ile Header & Footer navigasyonu tam senkronize edildi.
  2. `UfkaApiService::getMediaContents()` yazılarak API'deki video kayıtları (`Usturlab Medeniyetin İşaret Taşları`, `Dünyaya Doğan Güneş`, `Akıncı Belgeseli`) ve podcast içerikleri dinamik olarak çekildi.
  3. Anasayfadaki `#medya` bölümü dinamikleştirildi.
  4. `#mediaPlayerModal` ve `main.js:initMediaModal()` hem direkt HTML5 `.mp4` video oynatımını hem de harici iframe oynatımını kusursuz destekleyecek şekilde güncellendi.

---

### FAZ 7: (Opsiyonel / İleri Seviye) Canlı Mini Deneme Testi
- **Öncelik:** ⚪ İsteğe Bağlı
- **Kullanılacak Uç Noktalar:** `getQuestions/{category_id}`, `createQuestionForm`, `postAnswer`
- **Yapılacaklar:**
  1. Kullanıcı anasayfadaki "Deneme Sınavına Katıl" butonuna bastığında kategori seçimi (İlkokul, Ortaokul vb.).
  2. API'den gelen 10 soruluk interaktif bir mini test modalının açılması.
  3. Şıkları işaretleyip testi tamamlayınca doğru/yanlış analizinin ekranda gösterilmesi.

---

## 5. Güvenlik, Performans ve Mimari Prensipleri

1. **Akıllı Önbellekleme (Smart Cache):**
   - API yanıtları `cacheTTL = 600` saniye (10 dakika) boyunca CodeIgniter cache'inde saklanır.
   - Sık değişmeyen il listesi (`getCities`) 24 saat, ödüller ve içerikler 10 dakika önbelleklenir.
2. **Kırılmaz Arayüz Garantisi (Graceful Fallback):**
   - Uzak API sunucusunda bakım, ağ kesintisi veya gecikme olursa arayüz asla hata vermez (`try-catch` ve yerel fallback veriler devrededir).
3. **Pikselsel Tasarım Korunumu:**
   - Mevcut CSS mimarisi (`style.css`), 3D kartlar, modern cam efektleri (glassmorphism) ve kurumsal renk paleti birebir korunur.
4. **Veri Bütünlüğü:**
   - Tarihler, ödül miktarları ve kitap isimleri API'deki orijinal değerler üzerinden gösterilir; yapay müdahale yapılmaz.
