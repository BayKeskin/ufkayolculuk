  <!-- ==========================================
       HEADER & NAVBAR (Revize Edilmiş Kurumsal Navigasyon)
       ========================================== -->
  <header class="site-header">
    <div class="container">
      <nav class="navbar navbar-expand-xl navbar-light" aria-label="Ana Gezinme Çubuğu">
        <!-- Logo -->
        <a class="navbar-brand me-3 me-xl-4" href="<?= base_url('/') ?>" aria-label="Ufka Yolculuk Ana Sayfa">
          <img src="<?= base_url('assets/images/logo.png') ?>" alt="Ufka Yolculuk Logo" width="160" height="40">
        </a>

        <!-- Mobil Menü Toggle -->
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
          data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Menüyü Göster/Gizle">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
          <!-- Menü Öğeleri -->
          <?php
            $currentPage = $activePage ?? '';
            $currentSlug = $slug ?? '';

            $isHomeActive = ($currentPage === 'home');
            $isHakkimizdaActive = in_array($currentPage, ['hakkinda', 'biz-kimiz', 'misyon-vizyon', 'gecmis-yillar']) 
              || ($currentPage === 'sayfa-detay' && in_array($currentSlug, ['hakkimizda', 'biz-kimiz', 'misyon-vizyon', 'gecmis-yillar']))
              || ($currentPage === 'duyurular');

            $isYarismaActive = in_array($currentPage, ['oduller', 'yarisma']) 
              || ($currentPage === 'sayfa-detay' && in_array($currentSlug, ['yarisma-konusu', 'kategoriler', 'kitaplar', 'kitap-temin-noktalari', 'takvim']));

            $isBilgiMerkeziActive = in_array($currentPage, ['sss', 'bilgi-merkezi']) 
              || ($currentPage === 'sayfa-detay' && in_array($currentSlug, ['sartname', 'sinav-kurallari', 'materyaller', 'resmi-onaylar']));

            $isIletisimActive = ($currentPage === 'iletisim');
          ?>

          <ul class="navbar-nav me-auto ms-xl-2 mb-2 mb-xl-0">
            <!-- 1. Ana Sayfa (Logonun Hemen Yanında Doğrudan Menü Bağlantısı) -->
            <li class="nav-item">
              <a class="nav-link <?= $isHomeActive ? 'active' : '' ?>" href="<?= base_url('/') ?>">
                Ana Sayfa
              </a>
            </li>

            <!-- 2. Hakkımızda (Açılır Menü) -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle <?= $isHakkimizdaActive ? 'active' : '' ?>" href="#" id="hakkimizdaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span>Hakkımızda</span>
                <svg class="dropdown-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
              </a>
              <ul class="dropdown-menu shadow-sm" aria-labelledby="hakkimizdaDropdown">
                <li><a class="dropdown-item <?= ($currentSlug === 'biz-kimiz') ? 'active' : '' ?>" href="<?= base_url('sayfa/biz-kimiz') ?>">Biz Kimiz</a></li>
                <li><a class="dropdown-item <?= ($currentSlug === 'misyon-vizyon') ? 'active' : '' ?>" href="<?= base_url('sayfa/misyon-vizyon') ?>">Misyon - Vizyon</a></li>
                <li><a class="dropdown-item <?= ($currentSlug === 'gecmis-yillar') ? 'active' : '' ?>" href="<?= base_url('sayfa/gecmis-yillar') ?>">Geçmiş Yıllar</a></li>
                <li><a class="dropdown-item <?= ($currentPage === 'duyurular') ? 'active' : '' ?>" href="<?= base_url('duyurular') ?>">Haberler - Duyurular</a></li>
              </ul>
            </li>

            <!-- 3. Yarışma (Açılır Menü) -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle <?= $isYarismaActive ? 'active' : '' ?>" href="#" id="yarismaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span>Yarışma</span>
                <svg class="dropdown-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
              </a>
              <ul class="dropdown-menu shadow-sm" aria-labelledby="yarismaDropdown">
                <li><a class="dropdown-item" href="<?= base_url('/#nedir') ?>">Konusu</a></li>
                <li><a class="dropdown-item" href="<?= base_url('/#kategoriler') ?>">Kategoriler</a></li>
                <li><a class="dropdown-item" href="<?= base_url('/#kategoriler') ?>">Kitaplar</a></li>
                <li><a class="dropdown-item <?= ($currentSlug === 'kitap-temin-noktalari') ? 'active' : '' ?>" href="<?= base_url('sayfa/kitap-temin-noktalari') ?>">Kitap Temin Noktaları</a></li>
                <li><a class="dropdown-item" href="<?= base_url('/#takvim') ?>">Takvim</a></li>
                <li><a class="dropdown-item <?= ($currentPage === 'oduller') ? 'active' : '' ?>" href="<?= base_url('oduller') ?>">Ödüller</a></li>
              </ul>
            </li>

            <!-- 4. Bilgi Merkezi (Açılır Menü) -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle <?= $isBilgiMerkeziActive ? 'active' : '' ?>" href="#" id="bilgiMerkeziDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span>Bilgi Merkezi</span>
                <svg class="dropdown-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
              </a>
              <ul class="dropdown-menu shadow-sm" aria-labelledby="bilgiMerkeziDropdown">
                <li><a class="dropdown-item <?= ($currentPage === 'sss') ? 'active' : '' ?>" href="<?= base_url('sss') ?>">SSS</a></li>
                <li><a class="dropdown-item <?= ($currentSlug === 'sartname') ? 'active' : '' ?>" href="<?= base_url('sayfa/sartname') ?>">Yarışma Şartnamesi</a></li>
                <li><a class="dropdown-item <?= ($currentSlug === 'sinav-kurallari') ? 'active' : '' ?>" href="<?= base_url('sayfa/sinav-kurallari') ?>">Sınav Kuralları</a></li>
                <li><a class="dropdown-item <?= ($currentSlug === 'materyaller') ? 'active' : '' ?>" href="<?= base_url('sayfa/materyaller') ?>">Materyaller</a></li>
              </ul>
            </li>

            <!-- 5. İletişim (Açılır Menü) -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle <?= $isIletisimActive ? 'active' : '' ?>" href="#" id="iletisimDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <span>İletişim</span>
                <svg class="dropdown-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <polyline points="6 9 12 15 18 9"></polyline>
                </svg>
              </a>
              <ul class="dropdown-menu shadow-sm" aria-labelledby="iletisimDropdown">
                <li><a class="dropdown-item" href="<?= base_url('iletisim#temsilciler') ?>">İl Temsilcileri</a></li>
                <li>
                  <a class="dropdown-item d-flex flex-column py-2" href="<?= base_url('iletisim') ?>">
                    <span class="fw-bold text-dark">Destek ve Çözüm Merkezi</span>
                    <span class="small text-muted" style="font-size: 0.78rem;">📞 444 83 17 &nbsp;•&nbsp; ✉️ bilgi@ufkayolculuk.com</span>
                  </a>
                </li>
              </ul>
            </li>
          </ul>

          <!-- Sağ Eylemler: Dil butonu kaldırıldı, Arama (Q) + Giriş Yap (solda) + Kayıt Ol (sağda) -->
          <div class="header-actions d-flex align-items-center gap-2 mt-3 mt-xl-0">
            <!-- ==========================================
                 HIZLI ARAMA / OTOMATİK TAMAMLAMA (Q İkonu)
                 ========================================== -->
            <div class="dropdown">
              <button class="header-search-btn" type="button" id="headerSearchDropdownBtn" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" title="Sitede Arama Yap" aria-label="Sitede Ara">
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
                  <input type="text" class="search-input-header" id="globalSearchInput" placeholder="Aramak istediğiniz kelimeyi yazın..." autocomplete="off">
                </div>

                <div class="search-sub-title" id="searchCategoryHeader">Sık Sorulan Sorular:</div>

                <!-- Öneri / Arama Sonuç Listesi -->
                <div class="search-results-list" id="searchResultsContainer">
                  <a href="<?= base_url('oduller') ?>" class="search-faq-item">
                    <span class="search-faq-icon-bubble">?</span>
                    <span>Ödüller Nelerdir?</span>
                  </a>
                  <a href="<?= base_url('sss#yarisma') ?>" class="search-faq-item">
                    <span class="search-faq-icon-bubble">?</span>
                    <span>Bu sene düzenlenecek olan yarışmanın konusu nedir?</span>
                  </a>
                  <a href="<?= base_url('/#kategoriler') ?>" class="search-faq-item">
                    <span class="search-faq-icon-bubble">?</span>
                    <span>E-kitaplara nasıl ulaşabilirim?</span>
                  </a>
                  <a href="<?= base_url('sayfa/sinav-kurallari') ?>" class="search-faq-item">
                    <span class="search-faq-icon-bubble">?</span>
                    <span>Sınav kuralları nelerdir?</span>
                  </a>
                  <a href="<?= base_url('sayfa/kitap-temin-noktalari') ?>" class="search-faq-item">
                    <span class="search-faq-icon-bubble">?</span>
                    <span>Kitapları nereden temin edebilirim?</span>
                  </a>
                </div>
              </div>
            </div>

            <!-- ==========================================
                 KULLANICI PROFİL MENÜSÜ VEYA GİRİŞ / KAYIT BUTONLARI
                 ========================================== -->
            <?php $authUser = session()->get('ufka_user'); ?>

            <?php if (!empty($authUser)): ?>
              <!-- GİRİŞ YAPMIŞ KULLANICI: Yalnızca Profil Açılır Menüsü -->
              <?php 
                $displayName = !empty($authUser['name']) ? $authUser['name'] : 'Yarışmacı';
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
                      <span class="user-badge-yarisma"><?= esc($displayCategory) ?></span>
                    </div>
                  </div>

                  <!-- Hızlı Sertifikalarım Butonu (Mavi Hap) -->
                  <a href="<?= base_url('sertifikalarim') ?>" class="btn-profile-cert-quick">
                    Sertifikalarım
                  </a>

                  <!-- Menü Linkleri -->
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

                    <a href="<?= base_url('auth/logout') ?>" class="profile-menu-link text-danger">
                      <span>🚪</span>
                      <span>Çıkış Yap</span>
                    </a>
                  </div>
                </div>
              </div>
            <?php else: ?>
              <!-- GİRİŞ YAPMAMIŞ KULLANICI: Giriş Yap (Solda) & Kayıt Ol (Sağda, Dikkat Çekici Sarı Vurgu) -->
              <button type="button" class="btn-outline-minimal btn-header-login" data-bs-toggle="modal" data-bs-target="#loginModal" aria-label="Giriş Yap">
                <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span>Giriş Yap</span>
              </button>

              <a href="<?= base_url('kayit-ol') ?>" class="btn-yellow btn-header-register text-decoration-none" aria-label="Kayıt Ol">
                <span>Kayıt Ol</span>
              </a>
            <?php endif; ?>
          </div>
        </div>
      </nav>
    </div>
  </header>
