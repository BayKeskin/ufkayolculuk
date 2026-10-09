  <!-- ==========================================
       HEADER & NAVBAR
       ========================================== -->
  <header class="site-header">
    <div class="container">
      <nav class="navbar navbar-expand-xl navbar-light" aria-label="Ana Gezinme Çubuğu">
        <!-- Logo -->
        <a class="navbar-brand me-4" href="<?= base_url('/') ?>" aria-label="Ufka Yolculuk Ana Sayfa">
          <img src="<?= base_url('assets/images/logo.png') ?>" alt="Ufka Yolculuk Logo" width="160" height="40">
        </a>

        <!-- Mobil Menü Toggle -->
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
          data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Menüyü Göster/Gizle">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
          <!-- Menü Öğeleri -->
          <ul class="navbar-nav me-auto ms-xl-4 mb-2 mb-xl-0">
            <li class="nav-item">
              <a class="nav-link <?= ($activePage ?? '') === 'home' ? 'active' : '' ?>" href="<?= base_url('/') ?>">Ana Sayfa</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url('/#nedir') ?>">Ufka Yolculuk Nedir?</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url('/#kategoriler') ?>">Kitaplar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= base_url('/#harici-portallar') ?>">Portallar & Oyun</a>
            </li>

            <!-- 1. Dropdown: Yarışma Hakkında -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle <?= in_array(($activePage ?? ''), ['hakkinda', 'oduller', 'sayfa-detay']) ? 'active' : '' ?>" href="#" id="hakkindaDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <span>Yarışma Hakkında</span>
                <svg class="dropdown-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
              </a>
              <ul class="dropdown-menu shadow-sm" aria-labelledby="hakkindaDropdown">
                <li><a class="dropdown-item <?= (($slug ?? '') === 'hakkimizda' || (($activePage ?? '') === 'sayfa-detay' && empty($slug))) ? 'active' : '' ?>" href="<?= base_url('sayfa-detay') ?>">Hakkımızda</a></li>
                <li><a class="dropdown-item <?= ($slug ?? '') === 'misyon-vizyon' ? 'active' : '' ?>" href="<?= base_url('sayfa/misyon-vizyon') ?>">Misyon & Vizyon</a></li>
                <li><a class="dropdown-item <?= ($slug ?? '') === 'biz-kimiz' ? 'active' : '' ?>" href="<?= base_url('sayfa/biz-kimiz') ?>">Biz Kimiz?</a></li>
                <li><a class="dropdown-item <?= ($slug ?? '') === 'sartname' ? 'active' : '' ?>" href="<?= base_url('sayfa/sartname') ?>">Yarışma Şartnamesi</a></li>
                <li><a class="dropdown-item <?= ($slug ?? '') === 'resmi-onaylar' ? 'active' : '' ?>" href="<?= base_url('sayfa/resmi-onaylar') ?>">Resmi Onaylar (MEB)</a></li>
                <li><a class="dropdown-item" href="<?= base_url('/#takvim') ?>">Yarışma Takvimi</a></li>
                <li><a class="dropdown-item <?= ($activePage ?? '') === 'oduller' ? 'active' : '' ?>" href="<?= base_url('oduller') ?>">Ödüller</a></li>
                <li><a class="dropdown-item <?= ($activePage ?? '') === 'sss' ? 'active' : '' ?>" href="<?= base_url('sss') ?>">Sıkça Sorulan Sorular (SSS)</a></li>
              </ul>
            </li>

            <li class="nav-item">
              <a class="nav-link <?= ($activePage ?? '') === 'duyurular' ? 'active' : '' ?>" href="<?= base_url('duyurular') ?>">Duyurular</a>
            </li>

            <li class="nav-item">
              <a class="nav-link <?= ($activePage ?? '') === 'iletisim' ? 'active' : '' ?>" href="<?= base_url('iletisim') ?>">İletişim</a>
            </li>
          </ul>

          <!-- Sağ Eylemler -->
          <div class="header-actions d-flex align-items-center gap-2 mt-3 mt-xl-0">
            <!-- Dil Seçici (SVG Bayraklı) -->
            <div class="dropdown">
              <button class="lang-dropdown dropdown-toggle d-flex align-items-center gap-1" type="button"
                data-bs-toggle="dropdown" aria-expanded="false" id="langDropdownBtn">
                <img src="<?= base_url('assets/images/flag-tr.svg') ?>" alt="Türkçe" width="20" height="14" class="rounded-1 shadow-xs">
                <span>Türkçe</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="langDropdownBtn">
                <li>
                  <a class="dropdown-item active d-flex align-items-center gap-2" href="#" data-lang="tr">
                    <img src="<?= base_url('assets/images/flag-tr.svg') ?>" alt="Türkçe" width="20" height="14" class="rounded-1">
                    <span>Türkçe</span>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2" href="#" data-lang="en">
                    <img src="<?= base_url('assets/images/flag-en.svg') ?>" alt="English" width="20" height="14" class="rounded-1">
                    <span>English</span>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2" href="#" data-lang="ar">
                    <img src="<?= base_url('assets/images/flag-ar.svg') ?>" alt="العربية" width="20" height="14" class="rounded-1">
                    <span>العربية</span>
                  </a>
                </li>
              </ul>
            </div>

            <!-- ==========================================
                 HIZLI ARAMA / OTOMATİK TAMAMLAMA (Görsel 2 Referanslı)
                 ========================================== -->
            <div class="dropdown">
              <button class="header-search-btn" type="button" id="headerSearchDropdownBtn" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" title="Arama Yap">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </button>
              <div class="dropdown-menu dropdown-menu-end search-dropdown-menu shadow-lg p-3" aria-labelledby="headerSearchDropdownBtn" id="headerSearchMenu">
                <div class="search-input-header-wrapper">
                  <span class="search-input-header-icon">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                  </span>
                  <input type="text" class="search-input-header" id="globalSearchInput" placeholder="Aramak istediğiniz kelimeyi yazın" autocomplete="off">
                </div>

                <div class="search-sub-title" id="searchCategoryHeader">Sık Sorulan Sorular:</div>

                <!-- Öneri / Arama Sonuç Listesi -->
                <div class="search-results-list" id="searchResultsContainer">
                  <a href="<?= base_url('oduller') ?>" class="search-faq-item">
                    <span class="search-faq-icon-bubble">?</span>
                    <span>Ödülleri</span>
                  </a>
                  <a href="<?= base_url('sss#yarisma') ?>" class="search-faq-item">
                    <span class="search-faq-icon-bubble">?</span>
                    <span>Bu sene düzenlenecek olan yarışmanın konusu nedir?</span>
                  </a>
                  <a href="<?= base_url('/#kategoriler') ?>" class="search-faq-item">
                    <span class="search-faq-icon-bubble">?</span>
                    <span>E-kitaplara nasıl ulaşabilirim?</span>
                  </a>
                  <a href="<?= base_url('sss#sinav') ?>" class="search-faq-item">
                    <span class="search-faq-icon-bubble">?</span>
                    <span>Yarışmada kitaptaki dipnotlardan sorumlu muyuz ?</span>
                  </a>
                  <a href="<?= base_url('sayfa/sartname') ?>" class="search-faq-item">
                    <span class="search-faq-icon-bubble">?</span>
                    <span>Sınav kuralları nelerdir?</span>
                  </a>
                </div>
              </div>
            </div>

            <!-- ==========================================
                 KULLANICI PROFİL MENÜSÜ (Görsel 1 Referanslı)
                 ========================================== -->
            <?php 
              $authUser = session()->get('ufka_user');
              $displayName = !empty($authUser['name']) ? $authUser['name'] : 'ibrahim._. tekmen';
              $displayCategory = !empty($authUser['category_title']) ? $authUser['category_title'] : 'Yarışmacı';
            ?>
            <div class="dropdown">
              <button class="header-user-btn" type="button" id="userProfileDropdownBtn" data-bs-toggle="dropdown" aria-expanded="false" title="Yarışmacı Paneli">
                <svg width="22" height="22" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
              </button>
              <div class="dropdown-menu dropdown-menu-end user-profile-menu-dropdown shadow-lg" aria-labelledby="userProfileDropdownBtn">
                <!-- Üst Kullanıcı Bilgisi -->
                <div class="d-flex align-items-center gap-3 pb-2">
                  <div class="profile-avatar-box">
                    <svg width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                  </div>
                  <div>
                    <div class="fw-bold text-dark text-truncate" style="max-width: 170px; font-size: 0.95rem;">
                      <?= esc($displayName) ?>
                    </div>
                    <span class="user-badge-yarisma">Yarışmacı</span>
                  </div>
                </div>

                <!-- Hızlı Sertifikalarım Butonu (Mavi Hap) -->
                <a href="<?= base_url('sertifikalarim') ?>" class="btn-profile-cert-quick">
                  Sertifikalarım
                </a>

                <!-- Menü Linkleri (Görsel 1 Birebir) -->
                <div class="pt-2">
                  <a href="<?= base_url('sertifikalarim') ?>" class="profile-menu-link">
                    <span>📜</span>
                    <span>Sertifikalarım</span>
                  </a>
                  <a href="<?= base_url('sinavlarim') ?>" class="profile-menu-link">
                    <span>📝</span>
                    <span>Sınavlarım</span>
                  </a>
                  <a href="<?= base_url('takim-lideri') ?>" class="profile-menu-link">
                    <span>👥</span>
                    <span>Takım Lideri</span>
                  </a>
                  <a href="<?= base_url('vesile-olduklarim') ?>" class="profile-menu-link">
                    <span>🔗</span>
                    <span>Davet Et</span>
                  </a>

                  <hr class="my-2 border-secondary-subtle">

                  <?php if (!empty($authUser)): ?>
                    <a href="<?= base_url('auth/logout') ?>" class="profile-menu-link text-danger">
                      <span>🚪</span>
                      <span>Çıkış Yap</span>
                    </a>
                  <?php else: ?>
                    <a href="#" class="profile-menu-link text-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
                      <span>🔑</span>
                      <span>Giriş Yap</span>
                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <?php if (empty($authUser)): ?>
              <!-- Kayıt Ol Butonu -->
              <a href="<?= base_url('kayit-ol') ?>" class="btn-yellow text-decoration-none d-none d-md-inline-flex">
                Kayıt Ol
              </a>
            <?php endif; ?>
          </div>
        </div>
      </nav>
    </div>
  </header>
