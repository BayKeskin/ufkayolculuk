# 🚀 GitHub Actions ile Otomatik FTP Deploy (CI/CD) Rehberi

Bu rehber, herhangi bir projede (PHP, Laravel, CodeIgniter, WordPress veya React/Vue) `main` branch'ine her kod gönderildiğinde (`git push`), projenin **otomatik olarak FTP sunucusuna canlıya alınmasını** sağlayan modern CI/CD sistemini anlatır.

---

## 📌 1. Sistem Nasıl Çalışır? (Merkezi Bulut Mimarisi)

Bu sistem **kesinlikle sizin bilgisayarınıza veya localhost'unuza bağlı değildir.**

```text
[Geliştirici A] ──┐
[Geliştirici B] ──┼──> [GitHub (main)] ──> [GitHub Actions Bulutu] ──> [FTP Sunucusu]
[Siz (Local)]   ──┘    (Merkezi Depo)     (Sanal Ubuntu Sunucu)     (Canlı Web Sitesi)
```

1. Siz veya ekibinizden herhangi biri kodu `main` branch'ine gönderir (`git push` veya Pull Request onayı).
2. GitHub, değişikliği algılayıp kendi bulutunda **geçici bir sanal sunucu (Ubuntu)** açar.
3. Bu sunucu en güncel kodları çeker, değişen dosyaları tespit eder.
4. FTP üzerinden canlı sunucunuza bağlanıp **yalnızca değişen dosyaları** saniyeler içinde yükler.
5. Sizin veya ekip arkadaşlarınızın bilgisayarı kapalı olsa dahi dağıtım hatasız gerçekleşir.

---

## 🔑 2. Adım Adım Kurulum Kılavuzu

### 1. Adım: FTP Bilgilerinin Hazırlanması
Sunucunuzdan (cPanel, Plesk, Hostinger, DirectAdmin vb.) şu 4 bilgiye ihtiyacınız vardır:
* **Host / Sunucu IP:** (Örn: `91.108.101.21` veya `ftp.siteadi.com`)
* **FTP Kullanıcı Adı:** (Örn: `u1234567.proje`)
* **FTP Şifresi:** (Örn: `GizliSifre123+`)
* **Port:** Genellikle `21` (SFTP ise `22`)

> [!IMPORTANT]
> **Dizin Güvenliği Kuralı:**  
> * Eğer FTP kullanıcınız **doğrudan projenin klasörünü** görüyorsa `server-dir: /` yapın.
> * Eğer FTP kullanıcınız **`public_html` kökünü** görüyor ve içinde başka siteler de varsa, `server-dir: proje-klasoru-adi/` olarak kilitleyin. Bu sayede diğer sitelere **asla dokunulmaz**.

---

### 2. Adım: GitHub Secrets (Şifrelerin) Eklenmesi
FTP şifreleri **kesinlikle kodların içine açık yazılmaz.** GitHub'ın şifrelenmiş kasa sistemine eklenir:

1. GitHub'da deponuza gidin: `https://github.com/KULLANICI_ADI/DEPO_ADI`
2. Üst menüden **Settings** sekmesine tıklayın.
3. Sol menüden **Secrets and variables** > **Actions** seçeneğine tıklayın.
4. **New repository secret** butonuna basarak şu 4 gizli değişkeni ekleyin:
   * `FTP_SERVER` -> FTP sunucu adresi veya IP
   * `FTP_USERNAME` -> FTP kullanıcı adı
   * `FTP_PASSWORD` -> FTP şifresi
   * `FTP_PORT` -> `21`

---

### 3. Adım: Workflow Dosyasının Oluşturulması
Projenizin kök dizininde `.github/workflows/deploy.yml` dosyasını oluşturun.

> [!TIP]
> GitHub web arayüzünden eklemek için:  
> Depo ana sayfasında **Add file** > **Create new file** deyin. Dosya adına `.github/workflows/deploy.yml` yazıp içeriği yapıştırın ve **Commit changes** diyerek kaydedin.

---

## 📄 3. Hazır İş Akışı Şablonları

### Şablon A: Standart PHP / CodeIgniter / Framework Projeleri
*(Bu projede başarıyla devreye aldığımız şablon)*

```yaml
name: Canlıya Otomatik Dağıtım (FTP Deploy)

on:
  push:
    branches:
      - main # Hangi dala push yapılınca çalışsın

jobs:
  web-deploy:
    name: FTP ile Canlıya Dağıt
    runs-on: ubuntu-latest
    steps:
      - name: Depoyu Klonla
        uses: actions/checkout@v4
        with:
          fetch-depth: 2 # Sadece son commit'te değişen dosyaları aktarır (çok hızlıdır)

      - name: FTP Senkronizasyonu
        uses: SamKirkland/FTP-Deploy-Action@v4.3.5
        with:
          server: ${{ secrets.FTP_SERVER }}
          username: ${{ secrets.FTP_USERNAME }}
          password: ${{ secrets.FTP_PASSWORD }}
          port: ${{ secrets.FTP_PORT || 21 }}
          protocol: ftp
          
          # FTP kullanıcısının indiği dizine göre hedef dizin:
          server-dir: /
          
          # Canlı sunucuda ezilmemesi veya yüklenmemesi gereken dosyalar:
          exclude: |
            **/.git*
            **/.git*/**
            **/.agents/**
            .env
            writable/cache/**
            writable/logs/**
            writable/session/**
            tests/**
            phpunit.dist.xml
            *.md
```

---

### Şablon B: React / Vue / Vite Projeleri (Build Edip Yükleme)
Node.js projelerinde GitHub sunucusu önce `npm run build` yapar, ardından derlenmiş `dist/` klasörünü FTP'ye atar:

```yaml
name: Build ve Otomatik Dağıtım

on:
  push:
    branches:
      - main

jobs:
  build-and-deploy:
    name: Projeyi Derle ve FTP'ye At
    runs-on: ubuntu-latest
    steps:
      - name: Depoyu Klonla
        uses: actions/checkout@v4

      - name: Node.js Kurulumu
        uses: actions/setup-node@v4
        with:
          node-version: 20

      - name: Paketleri Yükle ve Derle
        run: |
          npm ci
          npm run build

      - name: Derlenmiş 'dist' Klasörünü FTP'ye Aktar
        uses: SamKirkland/FTP-Deploy-Action@v4.3.5
        with:
          server: ${{ secrets.FTP_SERVER }}
          username: ${{ secrets.FTP_USERNAME }}
          password: ${{ secrets.FTP_PASSWORD }}
          port: 21
          local-dir: dist/ # Sadece build edilen çıktıyı gönder
          server-dir: /
```

---

## 🛡️ 4. Kritik Kurallar & İpuçları

1. **`.env` Dosyasını Asla Ezmeyin:**  
   Her projenin canlı sunucudaki veritabanı şifresi veya API anahtarları yereldekinden farklıdır. `exclude:` bloğuna `.env` eklemeyi asla unutmayın.
2. **Önbellek ve Log Klasörlerini Hariç Tutun:**  
   CodeIgniter için `writable/`, Laravel için `storage/` altındaki log ve cache dosyalarını `exclude` listesine ekleyin. Aksi takdirde canlıdaki kullanıcı oturumları veya loglar bozulabilir.
3. **`fetch-depth: 2` Gücü:**  
   Bu parametre sayesinde her seferinde gigabaytlarca dosyayı tekrar tekrar FTP'ye yüklemez; yalnızca son commit ile değişen 2-3 dosya tespit edilir ve işlem **5–15 saniye** içinde biter.
4. **FTP Şifreleri Değiştiğinde:**  
   Tek yapmanız gereken GitHub deposundaki **Settings > Secrets and variables > Actions** kısmından ilgili secret'ı güncellemektir; kodlara dokunmanız gerekmez.

---

## 📊 5. Dağıtımı Takip Etme ve Canlı Durum

* Her `git push` sonrasında deponuzdaki **Actions** sekmesine tıklayarak dağıtımı izleyebilirsiniz:
  * 🟡 **Sarı Halka (`In progress`):** Dosyalar aktarılıyor.
  * 🟢 **Yeşil Onay (`Success`):** Başarıyla sunucuya yüklendi.
  * 🔴 **Kırmızı Çarpı (`Failure`):** FTP bağlantısı veya izin hatası oluştu (üzerine tıklayıp logu görebilirsiniz).

Bu rehberi arşivinize ekleyerek tüm PHP, HTML veya JavaScript projelerinizde sıfır maliyetle profesyonel CI/CD dağıtım hattı kurabilirsiniz.
