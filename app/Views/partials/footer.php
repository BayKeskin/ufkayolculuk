  <!-- ==========================================
       FOOTER (Mobil Uygulama Marketleri & Sosyal Medya)
       ========================================== -->
  <footer class="site-footer">
    <div class="container">
      <!-- Üst Kurumsal & Hukuki Hızlı Linkler -->
      <div class="row align-items-center justify-content-between pb-3 mb-3 border-bottom gy-2" style="border-color: var(--border-light) !important;">
        <div class="col-md-auto">
          <ul class="list-inline mb-0 footer-legal-links small">
            <li class="list-inline-item me-3"><a href="<?= base_url('kayit-ol') ?>" class="text-decoration-none text-muted hover-underline">Online Kayıt</a></li>
            <li class="list-inline-item me-3"><a href="<?= base_url('sayfa/sartname') ?>" class="text-decoration-none text-muted hover-underline">Yarışma Şartnamesi</a></li>
            <li class="list-inline-item me-3"><a href="<?= base_url('sayfa/uy-kvkk-aydinlatma-metni') ?>" class="text-decoration-none text-muted hover-underline">KVKK Aydınlatma Metni</a></li>
            <li class="list-inline-item me-3"><a href="<?= base_url('sayfa/uy-mahremiyet-politikasi') ?>" class="text-decoration-none text-muted hover-underline">Mahremiyet Politikası</a></li>
            <li class="list-inline-item me-3"><a href="<?= base_url('sayfa/UY-Veli-izin-Belgesi') ?>" class="text-decoration-none text-muted hover-underline">Veli İzin Belgesi</a></li>
            <li class="list-inline-item me-3"><a href="<?= base_url('sayfa/resmi-onaylar') ?>" class="text-decoration-none text-muted hover-underline">Resmi Onaylar (MEB)</a></li>
            <li class="list-inline-item"><a href="<?= base_url('sss') ?>" class="text-decoration-none text-muted hover-underline">SSS</a></li>
          </ul>
        </div>
        <div class="col-md-auto d-none d-md-block">
          <span class="badge bg-light text-secondary border px-3 py-1 rounded-pill" style="font-size: 0.75rem;">Server Yaşam Vakfı Bünyesinde</span>
        </div>
      </div>

      <div class="d-flex flex-column flex-lg-row align-items-center justify-content-between gap-3">
        <!-- Sol Logo & Telif -->
        <div class="d-flex align-items-center gap-3">
          <img src="<?= base_url('assets/images/logo.png') ?>" alt="Ufka Yolculuk Logo" width="140" height="35" class="footer-logo-img">
          <span class="small text-muted border-start ps-3" style="border-color: var(--border-light) !important;">
            &copy; <?= date('Y') ?> Ufka Yolculuk. Tüm hakları saklıdır.
          </span>
        </div>

        <!-- Sağ Alan: Mobil Uygulama Marketleri + Sosyal Medya İkonları -->
        <div class="d-flex flex-wrap align-items-center justify-content-center gap-3">
          <!-- Mobil Uygulama Market Butonları (Apple App Store & Google Play) -->
          <div class="d-flex align-items-center gap-2">
            <!-- App Store -->
            <a href="https://apps.apple.com" target="_blank" rel="noopener noreferrer" class="app-market-badge-link"
              aria-label="App Store'dan İndirin">
              <img src="<?= base_url('assets/images/badge-app-store.svg') ?>" alt="App Store'dan İndirin" width="135" height="40"
                class="app-market-badge-img">
            </a>

            <!-- Google Play -->
            <a href="https://play.google.com" target="_blank" rel="noopener noreferrer" class="app-market-badge-link"
              aria-label="Google Play'den Edinin">
              <img src="<?= base_url('assets/images/badge-google-play.svg') ?>" alt="Google Play'den Edinin" width="135" height="40"
                class="app-market-badge-img">
            </a>
          </div>

          <!-- Dikey Ayırıcı -->
          <div class="d-none d-sm-block border-start h-50 my-auto"
            style="border-color: var(--border-light) !important; height: 24px;"></div>

          <!-- Sosyal Medya İkonları -->
          <div class="d-flex align-items-center gap-2">
            <!-- Facebook -->
            <a href="https://facebook.com/ufkayolculuk" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="Facebook">
              <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
              </svg>
            </a>

            <!-- Twitter / X -->
            <a href="https://x.com/ufkayolculuk" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="Twitter / X">
              <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
              </svg>
            </a>

            <!-- Instagram -->
            <a href="https://instagram.com/ufkayolculuk" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="Instagram">
              <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
              </svg>
            </a>

            <!-- YouTube -->
            <a href="https://youtube.com/ufkayolculuk" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="YouTube">
              <svg width="15" height="15" fill="currentColor" viewBox="0 0 24 24">
                <path
                  d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </footer>
