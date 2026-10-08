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

            <?php $authUser = session()->get('ufka_user'); ?>
            <?php if (!empty($authUser)): ?>
              <!-- Giriş Yapmış Yarışmacı Profil Rozeti & Menüsü -->
              <div class="dropdown">
                <button class="btn btn-warning text-dark fw-bold rounded-pill px-3 py-1 d-flex align-items-center gap-2 dropdown-toggle shadow-xs" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="userMenuBtn">
                  <span>👤</span>
                  <span class="small"><?= esc(mb_substr($authUser['name'] ?? 'Yarışmacı', 0, 16)) ?></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userMenuBtn">
                  <li class="px-3 py-2 border-bottom">
                    <div class="fw-bold text-dark small"><?= esc($authUser['name'] ?? 'Yarışmacı') ?></div>
                    <div class="text-muted" style="font-size: 0.75rem;"><?= esc($authUser['category_title'] ?? $authUser['grade'] ?? 'Yarışmacı') ?></div>
                    <?php if (!empty($authUser['city'])): ?>
                      <div class="text-muted" style="font-size: 0.72rem;">📍 <?= esc($authUser['city']) ?></div>
                    <?php endif; ?>
                  </li>
                  <li>
                    <a class="dropdown-item py-2 small" href="<?= base_url('/#kitaplar') ?>">📚 Kitaplarım & Sınav</a>
                  </li>
                  <li>
                    <a class="dropdown-item py-2 small text-danger" href="<?= base_url('auth/logout') ?>">🚪 Güvenli Çıkış</a>
                  </li>
                </ul>
              </div>
            <?php else: ?>
              <!-- Kayıt Ol Butonu -->
              <a href="<?= base_url('kayit-ol') ?>" class="btn-yellow text-decoration-none">
                Kayıt Ol
              </a>

              <!-- Giriş Yap Butonu (Modal Açıcı) -->
              <button type="button" class="btn-outline-minimal" data-bs-toggle="modal" data-bs-target="#loginModal"
                aria-label="Giriş Yap">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Giriş Yap</span>
              </button>
            <?php endif; ?>
          </div>
        </div>
      </nav>
    </div>
  </header>
