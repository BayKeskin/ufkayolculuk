<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
  <!-- ==========================================
       HERO BÖLÜMÜ (Carousel / Slider - Profesyonel Görseller & Modern Tasarım)
       ========================================== -->
  <section class="hero-section" id="hero">
    <div class="container hero-slider-container">

      <!-- Yan Slider Okları (Dışta Konumlandırılmış - Büyük Oklar) -->
      <button class="btn-circle-nav d-none d-lg-flex" id="heroPrevBtn" aria-label="Önceki Slayt">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
          stroke-linecap="round" stroke-linejoin="round">
          <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
      </button>
      <button class="btn-circle-nav d-none d-lg-flex" id="heroNextBtn" aria-label="Sonraki Slayt">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
          stroke-linecap="round" stroke-linejoin="round">
          <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
      </button>

      <!-- Carousel Slaytları Kapsayıcısı -->
      <div class="hero-slides-wrapper" id="heroSlidesWrapper">

        <!-- Slayt 1 (Aktif Banner - 12. Yarışma) -->
        <div class="hero-slide active" data-slide-index="0">
          <div class="hero-banner-card">
            <img src="<?= base_url('assets/') ?>images/banner-1.webp" alt="Ufka Yolculuk 14. Bilgi ve Kültür Yarışması"
              class="hero-banner-img" width="1200" height="460">
            <div class="hero-banner-overlay">
              <div class="hero-content-wrap">
                <div class="hero-badge-pill">
                  <span class="badge-dot"></span>
                  <span>14. UFKA YOLCULUK YARIŞMASI</span>
                </div>
                <h1 class="hero-main-title">
                  Oku, Keşfet, Öğren <br>
                  <span class="text-highlight-gold">ve Geleceğini Kazan!</span>
                </h1>
                <p class="hero-subtext">
                  Türkiye'nin en kapsamlı online kitap okuma yarışmasında yerini al. Bilgini sına, binlerce değerli
                  ödülün ve eşsiz deneyimlerin sahibi ol.
                </p>
                <div class="hero-action-buttons">
                  <button type="button" class="btn-hero-primary border-0" data-bs-toggle="modal" data-bs-target="#registerModal">
                    <span>Ücretsiz Kayıt Ol</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2.5">
                      <polyline points="9 18 15 12 9 6" />
                    </svg>
                  </button>
                  <a href="#kategoriler" class="btn-hero-glass">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                      <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                    </svg>
                    <span>Yarışma Kitapları</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Slayt 2 Banner (Online Sınav Sistemi) -->
        <div class="hero-slide" data-slide-index="1">
          <div class="hero-banner-card">
            <img src="<?= base_url('assets/') ?>images/banner-2.webp" alt="Online Sınav Başvuruları ve Dijital Test Portalı"
              class="hero-banner-img" width="1200" height="460">
            <div class="hero-banner-overlay">
              <div class="hero-content-wrap">
                <div class="hero-badge-pill badge-cyan">
                  <span class="badge-dot cyan"></span>
                  <span>DİJİTAL SINAV PORTALI</span>
                </div>
                <h2 class="hero-main-title">
                  Gelişmiş Online Sınav <br>
                  <span class="text-highlight-cyan">Sistemiyle Tanışın</span>
                </h2>
                <p class="hero-subtext">
                  Dilediğin cihazdan kolayca katıl, anında performans analizini gör ve Türkiye geneli sıralamada zirveye
                  tırman.
                </p>
                <div class="hero-action-buttons">
                  <a href="#soru-coz" class="btn-hero-primary">
                    <span>Deneme Sınavına Katıl</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2.5">
                      <polyline points="9 18 15 12 9 6" />
                    </svg>
                  </a>
                  <a href="<?= base_url('sayfa-detay') ?>" class="btn-hero-glass">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <circle cx="12" cy="12" r="10" />
                      <line x1="12" y1="16" x2="12" y2="12" />
                      <line x1="12" y1="8" x2="12.01" y2="8" />
                    </svg>
                    <span>Sınav Kılavuzu</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Slayt 3 Banner (Büyük Ödüller) -->
        <div class="hero-slide" data-slide-index="2">
          <div class="hero-banner-card">
            <img src="<?= base_url('assets/') ?>images/banner-3.webp" alt="Büyük Ödüller, Tabletler, Dizüstü Bilgisayarlar ve Seyahatler"
              class="hero-banner-img" width="1200" height="460">
            <div class="hero-banner-overlay">
              <div class="hero-content-wrap">
                <div class="hero-badge-pill badge-gold">
                  <span class="badge-dot gold"></span>
                  <span>MİLYONLUK ÖDÜL HAVUZU</span>
                </div>
                <h2 class="hero-main-title">
                  Dereceye Girenleri <br>
                  <span class="text-highlight-gold">Büyük Ödüller Bekliyor!</span>
                </h2>
                <p class="hero-subtext">
                  MacBook Pro, iPad, Akıllı Saatler, Umre Seyahatleri ve binlerce sürpriz ödül bu yıl sahiplerini
                  buluyor.
                </p>
                <div class="hero-action-buttons">
                  <a href="<?= base_url('oduller') ?>" class="btn-hero-primary">
                    <span>Ödülleri İncele</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2.5">
                      <polyline points="9 18 15 12 9 6" />
                    </svg>
                  </a>
                  <a href="#takvim" class="btn-hero-glass">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                      <line x1="16" y1="2" x2="16" y2="6" />
                      <line x1="8" y1="2" x2="8" y2="6" />
                      <line x1="3" y1="10" x2="21" y2="10" />
                    </svg>
                    <span>Yarışma Takvimi</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Slayt 4 Banner (Takım Lideri Portalı) -->
        <div class="hero-slide" data-slide-index="3">
          <div class="hero-banner-card">
            <img src="<?= base_url('assets/') ?>images/banner-4.webp" alt="Takım Liderleri, Danışman Öğretmenler ve Eğitim Rehberi"
              class="hero-banner-img" width="1200" height="460">
            <div class="hero-banner-overlay">
              <div class="hero-content-wrap">
                <div class="hero-badge-pill badge-purple">
                  <span class="badge-dot purple"></span>
                  <span>EĞİTİMCİ & DANIŞMAN PORTALI</span>
                </div>
                <h2 class="hero-main-title">
                  Takımını Oluştur, <br>
                  <span class="text-highlight-gold">Geleceğe Rehberlik Et</span>
                </h2>
                <p class="hero-subtext">
                  Öğrencilerine ilham ver, yarışma sürecini tek panelden yönet ve takım liderlerine özel prestij
                  ödüllerini kazan.
                </p>
                <div class="hero-action-buttons">
                  <a href="#takim-portali" class="btn-hero-primary">
                    <span>Lider Portalı Girişi</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                      stroke-width="2.5">
                      <polyline points="9 18 15 12 9 6" />
                    </svg>
                  </a>
                  <a href="<?= base_url('sayfa-detay') ?>" class="btn-hero-glass">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                      <circle cx="9" cy="7" r="4" />
                      <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                      <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    <span>Danışman Kılavuzu</span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- Numaralı Slider Göstergesi & Kontrolleri -->
      <div class="slider-indicator" id="heroIndicator">
        <span class="num-item active" data-slide="0">01</span>
        <div class="indicator-track">
          <div class="indicator-fill" id="indicatorFill"></div>
        </div>
        <span class="num-item" data-slide="1">02</span>
        <span class="num-item" data-slide="2">03</span>
        <span class="num-item" data-slide="3">04</span>
        <span class="pause-btn" id="heroPauseBtn" title="Durdur / Oynat" aria-label="Durdur/Oynat">||</span>
      </div>

    </div>
  </section>
  <!-- ==========================================
       BÖLÜM 1: UFKA YOLCULUK NEDİR & YARIŞMAMIZ HAKKINDA (İlk Ziyaretçiler İçin)
       ========================================== -->
  <section class="about-journey-section position-relative" id="nedir">
    <div class="container">

      <!-- Karşılama ve Tanıtım Başlığı -->
      <div class="about-intro-header">
        <span class="about-badge-chip">
          <span>✨</span>
          <span>TÜRKİYE'NİN EN BÜYÜK KİTAP OKUMA YARIŞMASI</span>
        </span>
        <h2 class="about-main-title">
          Ufka Yolculuk Nedir? <span class="text-gradient-primary">Nasıl Bir Yolculuk?</span>
        </h2>
        <p class="about-lead-desc">
          Ufka Yolculuk; her yıl yüz binlerce öğrenci, genç ve yetişkini ahlak, bilgi ve düşünce ufkunu açan seçkin
          eserlerle buluşturan, doğru bilgiye ulaşmayı ve okuma alışkanlığını teşvik eden uluslararası bir kültür ve
          gelişim hareketidir.
        </p>
      </div>

      <!-- 4 Temel Değer ve Özellik Kartı -->
      <div class="row g-3 g-md-4">
        <!-- 1. Özellik: Doğru Bilgi & Rehber Eserler -->
        <div class="col-12 col-md-6 col-lg-3">
          <div class="mission-pillar-card">
            <div class="mission-icon-box icon-box-blue">
              <span>📖</span>
            </div>
            <div class="mission-card-body">
              <h3 class="mission-card-title">Seçkin Rehber Eserler</h3>
              <p class="mission-card-text">
                Pedagojik uzmanlar ve akademisyenler tarafından her yaş seviyesine özel titizlikle hazırlanan zengin
                içerikli kitaplar.
              </p>
            </div>
          </div>
        </div>

        <!-- 2. Özellik: 4 Farklı Kategori -->
        <div class="col-12 col-md-6 col-lg-3">
          <div class="mission-pillar-card">
            <div class="mission-icon-box icon-box-green">
              <span>👥</span>
            </div>
            <div class="mission-card-body">
              <h3 class="mission-card-title">Her Yaşa 4 Kategori</h3>
              <p class="mission-card-text">
                İlkokul, Ortaokul, Lise ve Yetişkin kategorileriyle 7'den 70'e tüm aile bireylerinin birlikte
                katılabileceği ortak bir heyecan.
              </p>
            </div>
          </div>
        </div>

        <!-- 3. Özellik: Online & Kolay Sınav -->
        <div class="col-12 col-md-6 col-lg-3">
          <div class="mission-pillar-card">
            <div class="mission-icon-box icon-box-amber">
              <span>💻</span>
            </div>
            <div class="mission-card-body">
              <h3 class="mission-card-title">Online & Erişilebilir Sınav</h3>
              <p class="mission-card-text">
                Türkiye'nin ve dünyanın dört bir yanından bilgisayar, tablet veya telefon üzerinden kolayca katılabilme
                imkanı.
              </p>
            </div>
          </div>
        </div>

        <!-- 4. Özellik: Büyük Ödüller & Takdir -->
        <div class="col-12 col-md-6 col-lg-3">
          <div class="mission-pillar-card">
            <div class="mission-icon-box icon-box-purple">
              <span>🏆</span>
            </div>
            <div class="mission-card-body">
              <h3 class="mission-card-title">Büyük Ödüller & Takdir</h3>
              <p class="mission-card-text">
                Umre seyahatleri, teknolojik ödüller, burslar, il ve ilçe derece ödülleri ile danışman öğretmenlere özel
                başarı hediyeleri.
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Rakamlarla Ufka Yolculuk İstatistik Şeridi -->
      <div class="about-stats-strip">
        <div class="row g-3 align-items-center">
          <div class="col-6 col-lg-3">
            <div class="stat-metric-item">
              <div class="stat-metric-num">13+ Dönem</div>
              <div class="stat-metric-label">Kesintisiz Yolculuk</div>
            </div>
          </div>
          <div class="col-6 col-lg-3">
            <div class="stat-metric-item">
              <div class="stat-metric-num">4.5 Milyon+</div>
              <div class="stat-metric-label">Kayıtlı Yarışmacı</div>
            </div>
          </div>
          <div class="col-6 col-lg-3">
            <div class="stat-metric-item">
              <div class="stat-metric-num">81 İl & Dünya</div>
              <div class="stat-metric-label">Geniş Katılım Ağı</div>
            </div>
          </div>
          <div class="col-6 col-lg-3">
            <div class="stat-metric-item">
              <div class="stat-metric-num">10.000+</div>
              <div class="stat-metric-label">Dağıtılan Başarı Ödülü</div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ==========================================
       BÖLÜM 2: 12. DÖNEM KATEGORİLER VE YARIŞMA KİTAPLARI (3D Vitrin & Sesli Dinle/Oku)
       ========================================== -->
  <section class="categories-section position-relative" id="kategoriler">
    <div class="container">

      <!-- Bölüm Başlık Alanı & Filtre Sekmeleri -->
      <div class="section-header-corporate mb-4">
        <div class="row align-items-end g-3">
          <div class="col-lg-7">
            <div class="sub-badge-corporate">
              <span class="sub-badge-icon">📚</span>
              <span>14. UFKA YOLCULUK ESERLERİ</span>
            </div>
            <h2 class="section-main-heading mb-2">
              Kategoriler ve <span class="text-gradient-primary">Yarışma Kitapları</span>
            </h2>
            <p class="section-lead-text mb-0">
              Her yaş ve kademe için pedagojik uzmanlarca özenle seçilen, ahlak, bilgi ve düşünce ufkunu açan rehber
              eserlerimizi keşfedin.
            </p>
          </div>
          <div class="col-lg-5 text-lg-end">
            <!-- Kategori Filtre Butonları (Desktop) -->
            <div class="book-category-filter-pills d-inline-flex align-items-center gap-1" id="bookFilterTabs">
              <button type="button" class="filter-pill active" data-filter="all">Tümü</button>
              <button type="button" class="filter-pill" data-filter="green">İlkokul</button>
              <button type="button" class="filter-pill" data-filter="amber">Ortaokul</button>
              <button type="button" class="filter-pill" data-filter="blue">Lise</button>
              <button type="button" class="filter-pill" data-filter="purple">Yetişkin</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Slider Gezinme Butonları -->
      <button class="btn-circle-nav position-absolute start-0 top-50 translate-middle-y d-none d-xl-flex z-3 ms-1"
        id="catPrevBtn" aria-label="Önceki Kategori">‹</button>
      <button class="btn-circle-nav position-absolute end-0 top-50 translate-middle-y d-none d-xl-flex z-3 me-1"
        id="catNextBtn" aria-label="Sonraki Kategori">›</button>

      <script>
        window.UFKA_BOOK_DATA = <?= json_encode($bookDataMap ?? [], JSON_UNESCAPED_UNICODE) ?>;
      </script>

      <!-- 4 Kategori Kartı Carousel Track (API Verisi ile Dinamik) -->
      <div class="row g-3 g-md-4 flex-nowrap overflow-auto categories-track pt-2 pb-3" id="categoriesTrack">
        <?php if (!empty($categories)): ?>
          <?php foreach ($categories as $slug => $cat): 
              $book = $cat['book'] ?? [];
              $bookName = esc($book['name'] ?? $cat['title']);
              $imgUrl = !empty($book['image_url']) ? esc($book['image_url']) : esc($cat['fallback_image']);
              $fallbackImg = esc($cat['fallback_image']);
          ?>
            <!-- <?= esc($cat['title']) ?> -->
            <div class="col-8 col-sm-6 col-lg-3 flex-shrink-0 category-card-col" data-cat="<?= esc($cat['theme']) ?>">
              <div class="book-showcase-card theme-<?= esc($cat['theme']) ?>">
                <div class="book-3d-stage">
                  <div class="book-mockup-3d-box">
                    <img src="<?= $imgUrl ?>"
                      alt="<?= esc($cat['title']) ?> - <?= $bookName ?>" class="book-cover-img" width="220"
                      height="295" loading="lazy"
                      onerror="this.onerror=null; this.src='<?= $fallbackImg ?>';">
                    <div class="book-floating-ribbon"><?= esc($cat['badge']) ?></div>

                    <div class="book-hover-actions">
                      <button type="button" class="btn-book-inspect-single" data-bs-toggle="modal"
                        data-bs-target="#bookPreviewModal" data-book="<?= esc($slug) ?>" title="<?= $bookName ?> Detaylarını İncele">
                        <span class="btn-icon">🔍</span>
                        <span>Kitabı İncele</span>
                      </button>
                    </div>
                  </div>
                  <div class="book-pedestal-shadow"></div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-12 text-center py-5">
            <p class="text-muted">Kategori bilgileri yükleniyor...</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- ==========================================
       BÖLÜM 3: DIŞ PORTALLAR & EKOSİSTEM (Oyunlar, Online Soru Çöz, Ufyo Market - 3 Canlı Banner)
       ========================================== -->
  <section class="subdomain-banners-section" id="harici-portallar">
    <div class="container">
      <div class="row g-4 align-items-center">

        <!-- 1. Görsel: Oyun Dünyası Subdomain Banner -->
        <div class="col-lg-4 col-md-6">
          <a href="https://oyun.ufkayolculuk.com" target="_blank" rel="noopener noreferrer"
            class="subdomain-banner-link" aria-label="Oyun Dünyası Portalına Git">
            <img src="<?= base_url('assets/') ?>images/banner-oyunlar.webp" alt="Ufka Yolculuk Oyun Dünyası"
              class="img-fluid rounded-4 w-100 subdomain-banner-img" width="600" height="338">
          </a>
        </div>

        <!-- 2. Görsel: Online Soru Çözüm Subdomain Banner -->
        <div class="col-lg-4 col-md-6">
          <a href="https://soru.ufkayolculuk.com" target="_blank" rel="noopener noreferrer"
            class="subdomain-banner-link" aria-label="Online Soru Çözüm Sistemine Git">
            <img src="<?= base_url('assets/') ?>images/banner-soru-coz.webp" alt="Ufka Yolculuk Online Soru Çözüm Sistemi"
              class="img-fluid rounded-4 w-100 subdomain-banner-img" width="600" height="338">
          </a>
        </div>

        <!-- 3. Görsel: Ufyo Market Subdomain Banner -->
        <div class="col-lg-4 col-md-12">
          <a href="https://market.ufkayolculuk.com" target="_blank" rel="noopener noreferrer"
            class="subdomain-banner-link" aria-label="Ufyo Market Mağazasına Git">
            <img src="<?= base_url('assets/') ?>images/banner-ufyo-market.webp" alt="Ufka Yolculuk Ufyo Market"
              class="img-fluid rounded-4 w-100 subdomain-banner-img" width="600" height="338">
          </a>
        </div>

      </div>
    </div>
  </section>

  <!-- ==========================================
       BÖLÜM 4: ÖNEMLİ TARİHLER (Takvim & Geri Sayım) & GÜNCEL DUYURULAR
       ========================================== -->
  <section class="dates-announcements-section" id="takvim">
    <div class="container">
      <div class="row g-4">
        <!-- Sol Kart: Önemli Tarihler -->
        <div class="col-lg-7">
          <div class="main-box-card">
            <!-- Başlık -->
            <div class="card-top-title">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="22" height="22" fill="none"
                class="me-1">
                <rect x="10" y="14" width="44" height="38" rx="8" fill="white" stroke="#F5A623" stroke-width="4"
                  stroke-linecap="round" stroke-linejoin="round" />
                <path d="M18 10v10M46 10v10M10 25h44" stroke="#F5A623" stroke-width="4" stroke-linecap="round"
                  stroke-linejoin="round" />
                <circle cx="24" cy="35" r="3" fill="#F5A623" />
                <circle cx="40" cy="35" r="3" fill="#F5A623" />
                <circle cx="24" cy="44" r="3" fill="#F5A623" />
                <circle cx="40" cy="44" r="3" fill="#F5A623" />
              </svg>
              <span>Önemli Tarihler</span>
            </div>

            <!-- İç Çerçeveli Kutu (Tarih Slider + Geri Sayım + Takvim Butonu Bitişik Çerçeve) -->
            <script>
              window.UFKA_IMPORTANT_DATES = <?= json_encode($importantDates ?? [], JSON_UNESCAPED_UNICODE) ?>;
            </script>
            <div class="dates-inner-box">
              <!-- Üst Kısım: 2 Sütunlu Bölüm (Sol: Slider, Sağ: Geri Sayım) -->
              <div class="dates-top-row">
                <!-- Sol: Tarih Slider Carousel -->
                <div class="dates-slider-col">
                  <div
                    class="dates-carousel-wrapper d-flex align-items-center justify-content-between w-100 position-relative">
                    <button type="button" id="prevDateBtn" class="date-arrow-btn" aria-label="Önceki Tarih">‹</button>

                    <!-- Carousel Mask / Viewport -->
                    <div class="date-carousel-viewport overflow-hidden mx-1 flex-grow-1">
                      <div class="date-carousel-track d-flex" id="dateCarouselTrack">
                        <?php if (!empty($importantDates)): ?>
                          <?php foreach ($importantDates as $index => $item): 
                              $iconType = $item['icon_type'] ?? 'exam';
                          ?>
                          <!-- Slide <?= ($index + 1) ?>: <?= esc($item['title']) ?> -->
                          <div class="date-slide flex-shrink-0 w-100 d-flex align-items-center justify-content-center gap-3">
                            <div class="avatar-circle-yellow">
                              <?php if ($iconType === 'exam'): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="44" height="44" fill="none">
                                  <circle cx="32" cy="32" r="28" fill="#fcc626" />
                                  <rect x="18" y="20" width="28" height="20" rx="3" stroke="#0B2B6F" stroke-width="3" fill="#ffffff" />
                                  <path d="M26 44h12M32 40v4" stroke="#0B2B6F" stroke-width="3" stroke-linecap="round" />
                                  <circle cx="32" cy="30" r="4" fill="#0B2B6F" />
                                </svg>
                              <?php elseif ($iconType === 'answers'): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="44" height="44" fill="none">
                                  <circle cx="32" cy="32" r="28" fill="#fcc626" />
                                  <path d="M20 44l5-16 16-16 6 6-16 16-11 10z" stroke="#0B2B6F" stroke-width="3" stroke-linejoin="round" fill="#ffffff" />
                                  <path d="M37 18l6 6" stroke="#0B2B6F" stroke-width="3" />
                                </svg>
                              <?php elseif ($iconType === 'results'): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="44" height="44" fill="none">
                                  <circle cx="32" cy="32" r="28" fill="#fcc626" />
                                  <path d="M20 28h8l12-8v24l-12-8h-8z" stroke="#0B2B6F" stroke-width="3" stroke-linejoin="round" fill="#ffffff" />
                                  <path d="M24 36v6" stroke="#0B2B6F" stroke-width="3" stroke-linecap="round" />
                                  <path d="M44 26c2 2 2 10 0 12" stroke="#0B2B6F" stroke-width="3" stroke-linecap="round" />
                                </svg>
                              <?php else: ?>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="44" height="44" fill="none">
                                  <circle cx="32" cy="32" r="28" fill="#fcc626" />
                                  <rect x="18" y="20" width="28" height="20" rx="3" stroke="#0B2B6F" stroke-width="3" fill="#ffffff" />
                                  <path d="M26 44h12M32 40v4" stroke="#0B2B6F" stroke-width="3" stroke-linecap="round" />
                                  <circle cx="32" cy="30" r="4" fill="#0B2B6F" />
                                </svg>
                              <?php endif; ?>
                            </div>
                            <div>
                              <small class="text-muted d-block fw-semibold"><?= esc($item['title']) ?></small>
                              <strong class="text-dark fs-6"><?= esc($item['date_formatted']) ?> <span class="badge bg-light text-dark border ms-1 fw-normal" style="font-size:0.75rem;">Saat <?= esc($item['time_formatted'] ?? '') ?></span></strong>
                            </div>
                          </div>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </div>
                    </div>

                    <button type="button" id="nextDateBtn" class="date-arrow-btn" aria-label="Sonraki Tarih">›</button>
                  </div>

                  <!-- Sayfalama Noktaları -->
                  <div class="date-dots d-flex justify-content-center gap-1 mt-2" id="dateDotsContainer">
                    <?php if (!empty($importantDates)): ?>
                      <?php foreach ($importantDates as $idx => $item): ?>
                        <span class="dot <?= $idx === 0 ? 'active' : '' ?> rounded-pill d-inline-block" data-index="<?= $idx ?>" aria-label="<?= ($idx + 1) ?>. Tarih"></span>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                </div>

                <!-- Sağ: Sınava Kalan Süre (Dinamik) -->
                <div class="dates-countdown-col">
                  <div class="countdown-title mb-2" id="countdownTitle"><?= esc($importantDates[0]['countdown_label'] ?? 'Sınava Kalan Süre') ?></div>
                  <div class="countdown-timer-grid">
                    <div class="timer-box-item">
                      <div class="timer-val" id="timerDays">00</div>
                      <div class="timer-label">GÜN</div>
                    </div>
                    <div class="timer-box-item">
                      <div class="timer-val" id="timerHours">00</div>
                      <div class="timer-label">SAAT</div>
                    </div>
                    <div class="timer-box-item">
                      <div class="timer-val" id="timerMinutes">00</div>
                      <div class="timer-label">DAKİKA</div>
                    </div>
                    <div class="timer-box-item">
                      <div class="timer-val" id="timerSeconds">00</div>
                      <div class="timer-label">SANİYE</div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Alt Kısım: Takvimi İncele Butonu (API Resmi Takvimine Bağlantı) -->
              <a href="<?= base_url('sayfa/takvimi') ?>" class="btn-schedule-integrated">
                <div class="d-flex align-items-center gap-2">
                  <span>Yarışma Takvimini İncele</span>
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="16" height="16" fill="none">
                    <rect x="10" y="14" width="44" height="38" rx="8" fill="white" stroke="#F5A623" stroke-width="4"
                      stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M18 10v10M46 10v10M10 25h44" stroke="#F5A623" stroke-width="4" stroke-linecap="round"
                      stroke-linejoin="round" />
                    <circle cx="24" cy="35" r="3" fill="#F5A623" />
                    <circle cx="40" cy="35" r="3" fill="#F5A623" />
                    <circle cx="24" cy="44" r="3" fill="#F5A623" />
                    <circle cx="40" cy="44" r="3" fill="#F5A623" />
                  </svg>
                </div>
                <span class="arrow-symbol">→</span>
              </a>
            </div>
          </div>
        </div>

        <!-- Sağ Kart: Duyurular -->
        <div class="col-lg-5">
          <div class="main-box-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <div class="card-top-title mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="22" height="22" fill="none"
                  class="me-1">
                  <path d="M12 28h10l14-12v32L22 36H12V28z" fill="#FDE68A" stroke="#F59E0B" stroke-width="3"
                    stroke-linecap="round" stroke-linejoin="round" />
                  <path d="M43 25c3 3 4 5 4 7s-1 4-4 7M49 20c5 5 7 8 7 12s-2 7-7 12" stroke="#F59E0B" stroke-width="3"
                    stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span>Duyurular</span>
              </div>
              <a href="<?= base_url('duyurular') ?>" class="see-all-link">
                <span>Tüm Duyurular</span>
                <svg width="13" height="13" viewBox="0 0 15 15" fill="currentColor">
                  <path
                    d="M8.29289 2.29289C8.68342 1.90237 9.31658 1.90237 9.70711 2.29289L14.2071 6.79289C14.5976 7.18342 14.5976 7.81658 14.2071 8.20711L9.70711 12.7071C9.31658 13.0976 8.68342 13.0976 8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L11 8.5H1.5C0.947715 8.5 0.5 8.05228 0.5 7.5C0.5 6.94772 0.947715 6.5 1.5 6.5H11L8.29289 3.70711C7.90237 3.31658 7.90237 2.68342 8.29289 2.29289Z" />
                </svg>
              </a>
            </div>

            <div class="announcement-list flex-grow-1">
              <?php if (!empty($announcements)): ?>
                <?php foreach ($announcements as $a): 
                    $title    = $a['title'] ?? 'Duyuru';
                    $slug     = $a['slug'] ?? '';
                    $rawImg   = $a['image'] ?? $a['primary_category']['image'] ?? null;
                    $thumbUrl = $rawImg ? $api->getMediaUrl($rawImg) : base_url('assets/images/duyuru-1.webp');
                    $dateStr  = !empty($a['publish_time']) ? date('d.m.Y', strtotime($a['publish_time'])) : 'Güncel';
                    $detailUrl = base_url('sayfa/' . ($slug ?: $a['id']));
                ?>
                <!-- Canlı Duyuru Öğesi -->
                <a href="<?= esc($detailUrl) ?>" class="announcement-item">
                  <div class="announcement-thumb-wrapper">
                    <img src="<?= esc($thumbUrl) ?>" alt="<?= esc($title) ?>" class="announcement-thumb-img" width="58"
                      height="58" onerror="this.src='<?= base_url('assets/images/duyuru-1.webp') ?>'">
                  </div>
                  <div class="announcement-content">
                    <h4 class="announcement-title"><?= esc($title) ?></h4>
                    <span class="announcement-date-sub">📅 <?= esc($dateStr) ?></span>
                  </div>
                  <span class="announcement-arrow">
                    <svg width="14" height="14" viewBox="0 0 15 15" fill="currentColor">
                      <path
                        d="M8.29289 2.29289C8.68342 1.90237 9.31658 1.90237 9.70711 2.29289L14.2071 6.79289C14.5976 7.18342 14.5976 7.81658 14.2071 8.20711L9.70711 12.7071C9.31658 13.0976 8.68342 13.0976 8.29289 12.7071C7.90237 12.3166 7.90237 11.6834 8.29289 11.2929L11 8.5H1.5C0.947715 8.5 0.5 8.05228 0.5 7.5C0.5 6.94772 0.947715 6.5 1.5 6.5H11L8.29289 3.70711C7.90237 3.31658 7.90237 2.68342 8.29289 2.29289Z" />
                    </svg>
                  </span>
                </a>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>

            <!-- Alt WhatsApp Duyuru Kanalı Eylem Çubuğu -->
            <a href="https://whatsapp.com/channel/ufkayolculuk" target="_blank" rel="noopener noreferrer" class="btn-schedule-integrated mt-2">
              <div class="d-flex align-items-center gap-2">
                <span>💬 Anlık Duyurular İçin WhatsApp Kanalımıza Katılın</span>
              </div>
              <span class="arrow-symbol">→</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ==========================================
       BÖLÜM 3: NASIL KATILIRIM, ÖDÜLLER, PUAN SIRALAMASI (3 Kart)
       ========================================== -->
  <section class="trio-section">
    <div class="container">
      <div class="row g-4">

        <!-- Kart 1: Nasıl Katılırım? -->
        <div class="col-lg-4">
          <div class="card-how-to">
            <div>
              <h3 class="h5 fw-bold text-dark mb-3">Nasıl Katılırım?</h3>
              <div class="row align-items-center">
                <div class="col-7">
                  <ul class="how-steps-list">
                    <li class="how-step-item">
                      <span class="step-num-badge">1</span>
                      <span>Kayıt Ol</span>
                    </li>
                    <li class="how-step-item">
                      <span class="step-num-badge">2</span>
                      <span>Kitabını Oku / Dinle</span>
                    </li>
                    <li class="how-step-item">
                      <span class="step-num-badge">3</span>
                      <span>Soruları Çöz</span>
                    </li>
                    <li class="how-step-item">
                      <span class="step-num-badge">4</span>
                      <span>Ödüller Kazan</span>
                    </li>
                  </ul>
                </div>
                <div class="col-5 text-center">
                  <img src="<?= base_url('assets/') ?>images/icon1.png" alt="3D Checklist" width="115" height="135" class="img-fluid">
                </div>
              </div>
            </div>

            <a href="#rehber" class="btn-outline-minimal bg-white w-fit mt-3">
              <span>Detaylı Bilgi</span>
              <span>→</span>
            </a>
          </div>
        </div>

        <!-- Kart 2: Ödüller Seni Bekliyor! -->
        <div class="col-lg-5">
          <div class="card-prizes">
            <div>
              <h3 class="h5 fw-bold text-dark mb-3 text-start">Ödüller Seni Bekliyor!</h3>

              <div class="row g-2">
                <!-- 1. Genel Ödüller -->
                <div class="col-4 prize-col-item">
                  <img src="<?= base_url('assets/') ?>images/icon3.png" alt="Genel Ödüller" class="prize-icon-img" width="58" height="58">
                  <div class="prize-col-title">Genel Ödüller</div>
                  <p class="prize-col-desc">Tüm katılımcıların yarışma sonunda kazanabileceği genel ödüller.</p>
                </div>

                <!-- 2. İl ve İlçe Ödülleri -->
                <div class="col-4 prize-col-item">
                  <img src="<?= base_url('assets/') ?>images/icon4.png" alt="İl ve İlçe Ödülleri" class="prize-icon-img" width="58"
                    height="58">
                  <div class="prize-col-title">İl ve İlçe Ödülleri</div>
                  <p class="prize-col-desc">Her il ve ilçede dereceye giren katılımcılara özel ödüller.</p>
                </div>

                <!-- 3. Takım Lideri Ödülleri -->
                <div class="col-4 prize-col-item">
                  <img src="<?= base_url('assets/') ?>images/icon5.png" alt="Takım Lideri Ödülleri" class="prize-icon-img" width="58"
                    height="58">
                  <div class="prize-col-title">Takım Lideri Ödülleri</div>
                  <p class="prize-col-desc">Danışman öğretmenlere ve destek veren okullara özel ödüller.</p>
                </div>
              </div>
            </div>

            <a href="<?= base_url('oduller') ?>" class="btn-yellow w-100 justify-content-center mt-3">
              <span>Tüm Ödülleri İncele</span>
              <span>→</span>
            </a>
          </div>
        </div>

        <!-- Kart 3: En Yüksek Puanlar (Liderlik Tablosu) -->
        <div class="col-lg-3">
          <div class="card-leaderboard">
            <div>
              <h3 class="h5 fw-bold text-dark mb-3">En Yüksek Puanlar</h3>

              <ul class="leaderboard-list">
                <li class="leaderboard-item">
                  <div>
                    <span class="rank-badge-num gold">1</span>
                    <span>Ali Yılmaz</span>
                  </div>
                  <div>
                    <span>3.250</span>
                    <span class="ms-1">🥇</span>
                  </div>
                </li>
                <li class="leaderboard-item">
                  <div>
                    <span class="rank-badge-num silver">2</span>
                    <span>Zeynep Kaya</span>
                  </div>
                  <div>
                    <span>3.120</span>
                    <span class="ms-1">🥈</span>
                  </div>
                </li>
                <li class="leaderboard-item">
                  <div>
                    <span class="rank-badge-num bronze">3</span>
                    <span>Mehmet Ak</span>
                  </div>
                  <div>
                    <span>2.980</span>
                    <span class="ms-1">🥉</span>
                  </div>
                </li>
                <li class="leaderboard-item">
                  <div>
                    <span class="rank-badge-num default">4</span>
                    <span>Ayşe Demir</span>
                  </div>
                  <div>
                    <span>2.750</span>
                  </div>
                </li>
                <li class="leaderboard-item">
                  <div>
                    <span class="rank-badge-num default">5</span>
                    <span>Yusuf Karaca</span>
                  </div>
                  <div>
                    <span>2.610</span>
                  </div>
                </li>
              </ul>
            </div>

            <a href="#siralamalar" class="btn-outline-minimal bg-white w-100 justify-content-center mt-2">
              <span>Tüm Sıralamayı Gör</span>
              <span>→</span>
            </a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ==========================================
       BÖLÜM 4: TAKIM LİDERİ PORTALI & GAMIFICATION (2 Kart)
       ========================================== -->
  <section class="portal-gamification-section" id="takim-portali">
    <div class="container">
      <div class="row g-4">

        <!-- Sol Kart: Takım Lideri Portalı (40% genişlik) -->
        <div class="col-lg-5">
          <div class="card-portal-team">
            <div class="row align-items-center">
              <div class="col-sm-7">
                <div class="d-flex align-items-center gap-2 mb-2">
                  <span class="text-primary fs-5">👥</span>
                  <h3 class="h5 fw-bold text-dark mb-0">Takım Lideri Portalı</h3>
                </div>
                <p class="portal-text-desc">
                  Ekibini yönet, yarışma süreçlerini takip et ve takım lideri kaynaklarına ulaş.
                </p>
                <a href="#takim-portali" class="btn-yellow">
                  <span>Portala Git</span>
                  <span>→</span>
                </a>
              </div>
              <div class="col-sm-5 text-center mt-3 mt-sm-0">
                <img src="<?= base_url('assets/') ?>images/icon2.png" alt="Takım Liderleri İllüstrasyonu" width="160" height="130"
                  class="img-fluid" style="margin-bottom: -15px;">
              </div>
            </div>
          </div>
        </div>

        <!-- Sağ Kart: Gamification & Kullanıcı Widget'ı (60% genişlik) -->
        <div class="col-lg-7">
          <div class="card-gamification">
            <div class="gamification-inner-layout">

              <!-- 1. Seviye Altıgen Rozeti (Dışta Seviye Yazısı) -->
              <div class="level-col">
                <div class="level-hexagon-shape">
                  <span class="level-num">12</span>
                </div>
                <span class="level-text-label">Seviye</span>
              </div>

              <!-- 2. Kitap Kurdu, Kullanıcı Adı ve Rozetler -->
              <div class="gamification-user-info">
                <div class="user-title">Kitap Kurdu</div>
                <div class="blurred-user-bar" title="Kullanıcı Adı"></div>
                <div class="user-divider-line"></div>
                <div class="badges-title">Rozetler</div>
                <div class="badges-row-relative">
                  <div class="badge-hex-slot">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="#94A3B8">
                      <path d="M12 2l2.4 7.2h7.6l-6 4.8 2.4 7.2-6.4-4.8-6.4 4.8 2.4-7.2-6-4.8h7.6z" />
                    </svg>
                  </div>
                  <div class="badge-hex-slot">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="#94A3B8">
                      <path
                        d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                    </svg>
                  </div>
                  <div class="badge-hex-slot">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="#94A3B8">
                      <circle cx="12" cy="12" r="6" />
                    </svg>
                  </div>
                  <div class="badge-hex-slot">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="#94A3B8">
                      <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z" />
                    </svg>
                  </div>
                  <div class="badge-hex-slot">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="#94A3B8">
                      <path
                        d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2z" />
                    </svg>
                  </div>

                  <!-- Ortadaki Büyük Beyaz Dairesel Kilit -->
                  <div class="center-floating-lock" title="Kilitli Rozetler">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="#0F172A">
                      <path
                        d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z" />
                    </svg>
                  </div>
                </div>
              </div>

              <!-- 3. Puan & XP Sütunu -->
              <div class="gamification-stats-col">
                <!-- Puan -->
                <div class="d-flex align-items-center gap-2 mb-2">
                  <div class="star-badge-gold">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="#F59E0B">
                      <polygon points="12,2 15,8 22,9 17,14 18,21 12,18 6,21 7,14 2,9 9,8" />
                    </svg>
                  </div>
                  <div>
                    <div class="stats-num">2.450</div>
                    <div class="stats-label">Puan</div>
                  </div>
                </div>

                <!-- XP -->
                <div class="d-flex align-items-center gap-2">
                  <div class="xp-badge-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="#94A3B8">
                      <polygon points="12,2 21,7 21,17 12,22 3,17 3,7" />
                    </svg>
                  </div>
                  <div>
                    <div class="xp-val-text">850 / 1200</div>
                    <div class="stats-label">XP</div>
                  </div>
                </div>
              </div>

              <!-- 4. Katılım & Buton Sütunu -->
              <div class="gamification-cta-col">
                <p class="cta-desc-text">
                  Puanları topla,<br>rozetleri kazanmak için<br>hemen katıl!
                </p>
                <a href="#katil" class="btn-yellow btn-join-now">
                  <span>Hemen Katıl</span>
                  <span>→</span>
                </a>
              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ==========================================
       BÖLÜM 5: PODCAST & VIDEO
       ========================================== -->
  <section class="podcast-video-section" id="medya">
    <div class="container">

      <!-- Başlık Çubuğu -->
      <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="h4 mb-0 fw-bold">Podcast & Video</h2>
        <a href="#tum-medya" class="see-all-link">
          <span>Tümünü Gör</span>
          <span>→</span>
        </a>
      </div>

      <!-- Medya Kartları Grid (API Video & Podcast) -->
      <div class="row g-3 g-md-4">
        <?php if (!empty($mediaList)): ?>
          <?php foreach ($mediaList as $med): ?>
            <div class="col-6 col-lg-3">
              <div class="media-card-custom" role="button" tabindex="0" data-bs-toggle="modal"
                data-bs-target="#mediaPlayerModal" 
                data-media-tag="<?= esc($med['tag']) ?>" 
                data-media-tag-class="<?= esc($med['tag_class']) ?>"
                data-media-title="<?= esc($med['title']) ?>" 
                data-media-duration="<?= esc($med['duration']) ?>"
                data-media-url="<?= esc($med['url']) ?>"
                data-is-direct="<?= !empty($med['is_direct']) ? 'true' : 'false' ?>"
                data-media-desc="<?= esc($med['description']) ?>">
                <img src="<?= esc($med['thumbnail']) ?>" alt="<?= esc($med['title']) ?>" class="bg-thumb-img" width="320" height="180">
                <span class="media-tag-badge <?= esc($med['tag_class']) ?>"><?= esc($med['tag']) ?></span>
                <div class="media-play-center">▶</div>
                <div class="media-bottom-info">
                  <h4 class="media-title-text text-truncate"><?= esc($med['title']) ?></h4>
                  <span class="media-duration-badge"><?= esc($med['duration']) ?></span>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- ==========================================
       FLOATING AI DESTEK ROBOTU
       ========================================== -->
  <aside class="floating-ai-widget" id="ufyoChatTrigger" aria-label="Ufyo AI Destek Asistanı">
    <div class="floating-ai-bubble" id="ufyoBubble">
      Sorularını<br>sorabilirsin!
    </div>
    <img src="<?= base_url('assets/') ?>images/icon6.png" alt="AI Destek Robotu" class="bot-mascot-img" width="76" height="76">
  </aside>

  <!-- Ufyo AI Canlı Sohbet Penceresi -->
  <div class="ufyo-chat-panel" id="ufyoChatPanel" role="dialog" aria-labelledby="ufyoChatTitle" aria-hidden="true">
    <div class="ufyo-chat-header">
      <div class="d-flex align-items-center gap-2">
        <div class="ufyo-avatar-ring">
          <img src="<?= base_url('assets/') ?>images/icon6.png" alt="Ufyo" width="34" height="34">
          <span class="ufyo-status-dot"></span>
        </div>
        <div>
          <h5 class="ufyo-title mb-0" id="ufyoChatTitle">Ufyo AI Asistan</h5>
          <span class="ufyo-subtitle">Yapay Zeka Destek Sistemi</span>
        </div>
      </div>
      <button type="button" class="btn-ufyo-minimize" id="ufyoMinimizeBtn" title="Kapat" aria-label="Kapat">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>

    <div class="ufyo-chat-body" id="ufyoChatBody">
      <div class="chat-msg bot-msg">
        <div class="chat-msg-avatar">
          <img src="<?= base_url('assets/') ?>images/icon6.png" alt="Ufyo">
        </div>
        <div class="chat-msg-content">
          <p class="mb-1">Merhaba! Ben Ufka Yolculuk yapay zeka rehberiniz <strong>Ufyo</strong> 🤖</p>
          <p class="mb-0">Yarışma takvimi, kayıt şartları, kitaplar veya ödüller hakkında merak ettiğiniz her şeyi bana
            sorabilirsiniz.</p>
        </div>
      </div>

      <div class="ufyo-quick-chips" id="ufyoQuickChips">
        <span class="chips-title">Örnek Sorular:</span>
        <div class="d-flex flex-wrap gap-1 mt-1">
          <button type="button" class="ufyo-chip-btn" data-question="Sınav tarihi ve yarışma takvimi ne zaman?">📅 Sınav
            Ne Zaman?</button>
          <button type="button" class="ufyo-chip-btn"
            data-question="Kategorime ait yarışma kitabını nasıl temin ederim?">📚 Kitap Temini</button>
          <button type="button" class="ufyo-chip-btn" data-question="Yarışmada hangi ödüller verilecek?">🏆 Ödüller
            Nelerdir?</button>
          <button type="button" class="ufyo-chip-btn"
            data-question="Oyunlar ve Online Soru Çöz sistemine nasıl ulaşırım?">🎯 Oyun & Soru Portalı</button>
        </div>
      </div>
    </div>

    <div class="ufyo-chat-footer">
      <form id="ufyoChatForm" class="d-flex align-items-center gap-2 m-0">
        <input type="text" class="ufyo-input" id="ufyoInput" placeholder="Ufyo'ya bir soru sorun..." autocomplete="off"
          required>
        <button type="submit" class="btn-ufyo-send" id="ufyoSendBtn" aria-label="Mesaj Gönder">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
          </svg>
        </button>
      </form>
    </div>
  </div>

<?= $this->endSection() ?>
