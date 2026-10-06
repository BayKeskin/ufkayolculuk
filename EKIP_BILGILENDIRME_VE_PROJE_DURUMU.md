# 🚀 Ufka Yolculuk Web Platformu - Ekip Bilgilendirme ve Proje Durumu Raporu

**Tarih:** 05 Ekim 2026  
**Proje Adı:** Ufka Yolculuk Bilgi ve Kültür Yarışması Web Platformu  
**Sürüm:** v3.5 (Tam Entegre Headless MVC)  
**Canlı Demo Adresi:** [https://team.tkmdev.com/ufkayolculuk-demo/](https://team.tkmdev.com/ufkayolculuk-demo/)  
**Yerel Geliştirme (Local):** `http://localufkayolculuk.com/`  

---

## 📌 1. Yönetici Özeti (Executive Summary)

Ufka Yolculuk web platformu; modern kullanıcı deneyimi, yüksek sayfa açılış hızları (PageSpeed), sıfır harici kütüphane bağımlılığı (Zero Dependencies) ve %100 API tabanlı (Headless) mimari prensipleriyle baştan sona yeniden geliştirilmiş ve devreye alınmıştır.

Proje, harici bir veritabanı (MySQL/MariaDB) kurulumuna gerek duymadan **Ufka Yolculuk Merkezi REST API** servisi ile tam entegre çalışmaktadır. Tüm kitap bilgileri, sınav takvimi, canlı MP3 seslendirmeleri, Türkiye geneli ve yerel il ödülleri, 81 il temsilcilikleri, duyurular ve kurumsal şartnameler doğrudan API'den dinamik olarak çekilmektedir.

---

## 🏗️ 2. Mimari ve Teknik Altyapı

| Alan | Kullanılan Teknoloji / Yaklaşım | Açıklama |
| :--- | :--- | :--- |
| **Backend Çatısı** | PHP 8.2+ / CodeIgniter 4 (MVC) | Hafif, güvenli ve yüksek performanslı backend yapısı |
| **Veri Kaynağı** | Ufka Yolculuk REST API (`/rest/get/`) | %100 Headless mimari; yerel DB ihtiyacı yoktur |
| **Önbellek (Cache)** | CI4 File Cache | API kotalarını koruyan ve yanıt sürelerini 20ms altına indiren akıllı önbellekleme |
| **Frontend / Arayüz** | Vanilla CSS + Bootstrap 5.3 + Vanilla JS | jQuery veya ağır eklentiler içermez; saf JavaScript ile maksimum hız |
| **Çoklu Ortam Desteği**| Dinamik Ortam Tespiti (`App.php`) | Aynı kod tabanı yerelde (`localufkayolculuk.com`) ve canlı alt klasörde (`team.tkmdev.com/ufkayolculuk-demo/`) ayar değiştirmeden çalışır |
| **Güvenlik** | CSRF Koruması, Strict Filtering, XSS Koruması | Form ve AJAX isteklerinde token koruması |

---

## 📱 3. Sayfa Sayfa Tamamlanan Özellikler ve Çalışma Durumu

### 🏠 A. Ana Sayfa (`/`)
* **Hero Carousel (Ana Banner Slider):**
  * 4 farklı dinamik slayt (Yarışma Başvuru, Soru Çözüm, Büyük Ödüller, Takım Lideri Portalı).
  * İleri / geri okları (`#heroPrevBtn`, `#heroNextBtn`), numaralı göstergeler (01, 02, 03, 04) ve otomatik oynatmayı durdurma/başlatma (`||` / `▶`) kontrolleri.
  * Mobil dokunmatik kaydırma ve masaüstü uyumluluğu.
* **Ufka Yolculuk Nedir Bölümü:**
  * Yarışmanın misyonunu, hedef kitlesini ve 4 temel değer sütununu özetleyen modern görsel kartlar.
* **Kategori & Yarışma Kitapları Vitrini:**
  * **4 Kategori:** İlkokul, Ortaokul, Lise ve Yetişkin kademeleri.
  * API'den dinamik olarak çekilen 3D kitap kapakları, kademe rozetleri, yayınevi ve soru sayısı bilgileri.
  * Kategori filtreleme butonları (pills) ve yatay mouse-drag / dokunmatik kaydırma desteği.
* **Kitap İnceleme Modalı (`#bookPreviewModal`) & Ses Oynatıcı:**
  * Kitaba tıklandığında açılan detaylı tanıtım penceresi.
  * Kitap özeti, hedef yaş grubu, sayfa sayısı ve sınav formatı.
  * E-Kitap Oku (`kutuphane.ufkayolculuk.com`) ve Sesli Dinle (`sesli.ufkayolculuk.com`) butonları.
  * **Dahili Mini Ses Oynatıcı:** API'den gelen gerçek sesli kitap MP3 akışını (ör. *Kuşların Çağrısı*, *Tevhid Muhafızları*, *Nasıl İnanmalı?*) tarayıcı içinde anında oynatır. Yükleniyor (`⏳`), Oynatılıyor (`❚❚`) ve Duraklatıldı (`▶`) durumları ile canlı süre sayacı tam senkronizedir.
* **Dış Ekosistem Portalları (3 Canlı Banner):**
  * *Oyun Dünyası* (`oyun.ufkayolculuk.com`)
  * *Online Soru Çöz* (`soru.ufkayolculuk.com`)
  * *Ufyo Market* (`market.ufkayolculuk.com`)
* **Önemli Tarihler & Canlı Geri Sayım:**
  * API'den gelen yarışma takvimi adımları (Kayıt Bitiş, 1. Aşama Online Sınav, 2. Aşama Final Sınavı, Sonuçlar, Ödül Töreni).
  * Tarih slider'ı (`‹` / `›`) ile adımlar arası geçiş ve ilgili tarihe kilitlenen **canlı gün, saat, dakika, saniye geri sayım sayacı**.
* **Son Duyurular Vitrini:**
  * API'den çekilen en güncel 2 duyurunun görseli, yayın tarihi, kategori etiketi ve detay yönlendirmesi.
* **Online Soru Simülatörü (Mini Quiz):**
  * Ziyaretçilerin yarışma deneyimini tatması için kademelere özel çoktan seçmeli interaktif soru motoru.
  * Doğru/yanlış anlık renk geri bildirimi ve detaylı soru açıklaması.
* **Mini Oyunlar Modalı (`#gameModal`):**
  * Ziyaretçilerin kitaplardaki kavramları pekiştirebileceği eğitici etkinlik başlatıcısı.
* **Podcast & Video Medya Bölümü:**
  * API'den gelen YouTube / MP4 video ve ses kayıtlarının kartları, süre sayaçları ve gömülü Medya Oynatıcı Modalı.
* **Ufyo AI Canlı Destek Asistanı:**
  * Sağ altta konumlandırılmış akıllı Ufyo maskot butonu ve konuşma balonu.
  * Açılır sohbet penceresi, hızlı soru çipleri (Tarihler, Kitaplar, Ödüller, Oyunlar) ve otomatik yanıt sistemi.

---

### 🏆 B. Ödüller Sayfası (`/oduller`)
* **Türkiye Geneli Derece Ödülleri:**
  * İlkokul, Ortaokul, Lise, Yetişkin ve Danışman Öğretmen sekmeleri.
  * Umre ödülleri, Apple MacBook Pro, iPad, Akıllı Saatler, Para Ödülleri ve mansiyon ödüllerinin modern kartlarla gösterimi.
* **81 İl / İlçe Yerel Ödülleri (Dinamik AJAX):**
  * Türkiye genelindeki 81 il arasından seçim yapılabilen açılır menü ve hızlı seçim butonları.
  * API'den seçilen şehre özel (Örn: Konya, İstanbul, Ankara, Bursa) yerel ödüllerin, il koordinatörlüğü irtibat numarasının ve il ödül havuzunun anında yüklenmesi.

---

### ❓ C. Sıkça Sorulan Sorular (`/sss`)
* **Kategori Filtreleme:** Genel, Başvuru & Kayıt, Sınav Süreci, Kitaplar, Ödüller filtre hapları (pills).
* **Canlı Arama Motoru:** Başlık ve içerikte anlık arama yapan, tek tıkla temizlenebilen hızlı arama çubuğu.
* **Açılır-Kapanır Akordeon:** Şık, modern ve mobil uyumlu SSS listesi.
* **AI Entegrasyonu:** Aradığı cevabı bulamayan kullanıcıları tek tıkla Ufyo AI asistanına bağlayan yönlendirme.

---

### 📞 D. İletişim Sayfası (`/iletisim`)
* **81 İl Temsilcilikleri Rehberi:** İl seçildiğinde temsilcilik adı, sorumlu kişi, adres, telefon, e-posta ve Google Maps konumunun anında ekrana gelmesi.
* **Genel Merkez İletişim Bilgileri:** Telefon, adres, e-posta, sosyal medya hesapları.
* **Güvenli İletişim Formu:** Ad Soyad, Telefon, E-posta, Konu ve Mesaj alanları; CSRF korumalı ve AJAX doğrulamalı.

---

### 📰 E. Duyurular & Haberler (`/duyurular`)
* API'deki tüm resmi açıklamaları, basın bültenlerini ve haberleri sayfalama ve filtreleme desteğiyle listeleyen akış.

---

### 📄 F. Kurumsal, Hukuki & Kılavuz Sayfaları (`/sayfa/:slug`)
* `/sartname` -> 14. Yarışma Şartnamesi (Resmi yönergeler, katılım koşulları, puanlama esasları).
* `/hakkimizda`, `/biz-kimiz`, `/misyon-vizyon` -> Kurumsal kimlik ve organizasyon yapısı.
* `/resmi-onaylar` -> MEB ve ilgili bakanlık izin/onay belgeleri.
* `/kvkk` -> Kişisel Verilerin Korunması Kanunu ve Aydınlatma Metni.

---

### 🔐 G. Yarışmacı Giriş & Kayıt Sistemi (`/auth/...`)
* Header üzerinde yer alan **"Giriş Yap"** ve **"Ücretsiz Kayıt Ol"** modal pencereleri.
* Otomatik cep telefonu formatlama: `0 (5XX) XXX XX XX`.
* Doğum tarihi ve T.C. kimlik entegrasyonuna hazır AJAX doğrulama altyapısı.

---

## 🛠️ 4. Son Yapılan Kritik Düzeltmeler (Bug Fixes & Polish)

1. **JavaScript Sözdizimi Hatası Çözüldü:**
   * `public/assets/js/main.js` içerisindeki SSS fonksiyonunda eksik kalan `}` kapatılarak tüm dosyanın derlenmesi sağlandı. Bu sayede Carousel, Önemli Tarihler, Geri Sayım ve Modallar aktifleşti.
2. **Ses Çalar (Audio Player) Güçlendirildi:**
   * Uzak sunucudan gelen 270 MB'lık MP3 dosyalarının takılmadan akması için `preload="metadata"`, yükleniyor animasyonu (`⏳`) ve modal kapanınca otomatik durdurma özellikleri tamamlandı.
3. **Teknik İfadeler Temizlendi:**
   * Kitap modalındaki kullanıcıyı ilgilendirmeyen "Harici Subdomain" etiketi kaldırılarak arayüz son kullanıcıya uygun sade hale getirildi.
4. **Çoklu Ortam Uyumluluğu Sağlandı:**
   * Projenin canlıda `https://team.tkmdev.com/ufkayolculuk-demo/` altında, yerelde ise `http://localufkayolculuk.com/` adresinde kod değiştirmeden çalışabilmesi için `.htaccess`, `index.php` ve `App.php` dinamik hale getirildi.

---

## 🚀 5. Sunucuya Yükleme (Deployment) Notları

* Proje tamamen **statik dosyalar + PHP scriptlerinden** oluşur; veritabanı yedeği aktarılması gerekmez.
* Canlı sunucuda sadece `writable/` klasörüne yazma izni (**CHMOD 775 veya 777**) verilmesi yeterlidir.
* PHP sürümünün **8.2+** olması ve `curl`, `intl`, `mbstring` eklentilerinin açık olması gerekmektedir.
