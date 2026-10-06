  <!-- ==========================================
       GİRİŞ YAP MODALI (Telefon & Doğum Tarihi)
       ========================================== -->
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content custom-login-modal shadow-lg">

        <!-- Modal Başlık -->
        <div class="modal-header border-0 pb-0 pt-4 px-4 align-items-center">
          <div class="d-flex align-items-center gap-2">
            <div class="modal-icon-badge">
              <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>
            <div>
              <h5 class="modal-title fw-bold text-dark mb-0" id="loginModalLabel">Yarışmacı Girişi</h5>
              <small class="text-muted">Ufka Yolculuk Yarışmacı Paneli</small>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
        </div>

        <!-- Modal Gövde -->
        <div class="modal-body p-4">
          <!-- Giriş Durum Bildirim Kutusu -->
          <div id="loginAlertBox" class="mb-3 d-none"></div>

          <form id="loginForm" action="<?= base_url('auth/login') ?>" method="POST" novalidate>
            <?= csrf_field() ?>

            <!-- 1. Telefon Numarası -->
            <div class="mb-3">
              <label for="loginPhone" class="form-label fw-bold text-dark small mb-1">
                Telefon Numarası <span class="text-danger">*</span>
              </label>
              <div class="input-group-custom">
                <span class="input-icon-prefix">
                  <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                  </svg>
                </span>
                <input type="tel" name="phone" class="form-control form-control-custom" id="loginPhone"
                  placeholder="0 (5XX) XXX XX XX" maxlength="17" required autocomplete="tel">
              </div>
              <div class="form-text small text-muted">Kayıt olurken belirttiğiniz cep telefonu numarası.</div>
            </div>

            <!-- 2. Doğum Tarihi -->
            <div class="mb-3">
              <label for="loginBirthDate" class="form-label fw-bold text-dark small mb-1">
                Doğum Tarihi <span class="text-danger">*</span>
              </label>
              <div class="input-group-custom">
                <span class="input-icon-prefix">
                  <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke-width="2" />
                    <line x1="16" y1="2" x2="16" y2="6" stroke-width="2" stroke-linecap="round" />
                    <line x1="8" y1="2" x2="8" y2="6" stroke-width="2" stroke-linecap="round" />
                    <line x1="3" y1="10" x2="21" y2="10" stroke-width="2" />
                  </svg>
                </span>
                <input type="date" name="birthdate" class="form-control form-control-custom" id="loginBirthDate" required>
              </div>
              <div class="form-text small text-muted">Güvenlik doğrulaması için doğum tarihinizi seçiniz.</div>
            </div>

            <!-- Bilgilendirme Kutusu -->
            <div class="login-info-box mb-4">
              <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"
                class="flex-shrink-0 text-primary mt-0.5">
                <path fill-rule="evenodd"
                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                  clip-rule="evenodd" />
              </svg>
              <span>Giriş bilgileriniz yarışma veri tabanımız ile güvenli şekilde eşleştirilmektedir.</span>
            </div>

            <!-- Giriş Butonu -->
            <button type="submit" class="btn-yellow w-100 justify-content-center py-2 fs-6 fw-bold" id="btnLoginSubmit">
              <span>Giriş Yap</span>
              <span>→</span>
            </button>
          </form>
        </div>

        <!-- Modal Alt Bilgi -->
        <div class="modal-footer border-0 pt-0 pb-4 px-4 justify-content-center flex-column gap-2 text-center">
          <div class="small text-muted">
            Henüz kayıt olmadınız mı? 
            <a href="#registerModal" data-bs-toggle="modal" data-bs-target="#registerModal" class="fw-bold text-dark text-decoration-underline">
              Hemen Ücretsiz Kayıt Ol
            </a>
          </div>
          <div class="small text-muted">
            Sorun mu yaşıyorsunuz? <a href="<?= base_url('iletisim') ?>" class="text-primary text-decoration-underline"
              data-bs-dismiss="modal">Destek Al</a>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- ==========================================
       YARIŞMACI KAYIT MODALI (#registerModal)
       ========================================== -->
  <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content custom-login-modal shadow-lg">

        <!-- Modal Başlık -->
        <div class="modal-header border-0 pb-0 pt-4 px-4 align-items-center">
          <div class="d-flex align-items-center gap-2">
            <div class="modal-icon-badge bg-warning-subtle text-warning">
              <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
              </svg>
            </div>
            <div>
              <h5 class="modal-title fw-bold text-dark mb-0" id="registerModalLabel">Yarışmacı Kaydı</h5>
              <small class="text-muted">14. Ufka Yolculuk Bilgi ve Kültür Yarışması</small>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
        </div>

        <!-- Modal Gövde -->
        <div class="modal-body p-4">
          <!-- Kayıt Durum Bildirim Kutusu -->
          <div id="registerAlertBox" class="mb-3 d-none"></div>

          <!-- Ücretsiz Katılım Rozeti -->
          <div class="alert alert-light border border-warning-subtle d-flex align-items-center gap-2 py-2 px-3 small mb-4 rounded-3 text-dark">
            <span class="fs-5">✨</span>
            <div>Ufka Yolculuk yarışmasına katılım tamamen <strong>ücretsizdir</strong>. Formu doldurarak hemen yarışmacı olabilir, kitapları okumaya başlayabilirsiniz.</div>
          </div>

          <form id="registerForm" action="<?= base_url('auth/register') ?>" method="POST" novalidate>
            <?= csrf_field() ?>

            <div class="row g-3">
              <!-- 1. Ad Soyad -->
              <div class="col-md-6">
                <label for="regName" class="form-label fw-bold text-dark small mb-1">
                  Adınız ve Soyadınız <span class="text-danger">*</span>
                </label>
                <div class="input-group-custom">
                  <span class="input-icon-prefix">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                  </span>
                  <input type="text" name="name" class="form-control form-control-custom" id="regName"
                    placeholder="Örn: Ahmet Yılmaz" required autocomplete="name">
                </div>
              </div>

              <!-- 2. Cep Telefonu -->
              <div class="col-md-6">
                <label for="regPhone" class="form-label fw-bold text-dark small mb-1">
                  Cep Telefonu <span class="text-danger">*</span>
                </label>
                <div class="input-group-custom">
                  <span class="input-icon-prefix">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                  </span>
                  <input type="tel" name="phone" class="form-control form-control-custom" id="regPhone"
                    placeholder="0 (5XX) XXX XX XX" maxlength="17" required autocomplete="tel">
                </div>
              </div>

              <!-- 3. Doğum Tarihi -->
              <div class="col-md-6">
                <label for="regBirthDate" class="form-label fw-bold text-dark small mb-1">
                  Doğum Tarihi <span class="text-danger">*</span>
                </label>
                <div class="input-group-custom">
                  <span class="input-icon-prefix">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <rect x="3" y="4" width="18" height="18" rx="2" ry="2" stroke-width="2" />
                      <line x1="16" y1="2" x2="16" y2="6" stroke-width="2" stroke-linecap="round" />
                      <line x1="8" y1="2" x2="8" y2="6" stroke-width="2" stroke-linecap="round" />
                      <line x1="3" y1="10" x2="21" y2="10" stroke-width="2" />
                    </svg>
                  </span>
                  <input type="date" name="birthdate" class="form-control form-control-custom" id="regBirthDate" required>
                </div>
              </div>

              <!-- 4. Yarışma Kategorisi -->
              <div class="col-md-6">
                <label for="regCategory" class="form-label fw-bold text-dark small mb-1">
                  Yarışma Kategorisi <span class="text-danger">*</span>
                </label>
                <select name="category" id="regCategory" class="form-select form-control-custom" required>
                  <option value="">-- Kategori Seçiniz --</option>
                  <option value="İlkokul">🌱 İlkokul (1, 2, 3, 4. Sınıf)</option>
                  <option value="Ortaokul">🌿 Ortaokul (5, 6, 7, 8. Sınıf)</option>
                  <option value="Lise">🌳 Lise (9, 10, 11, 12. Sınıf)</option>
                  <option value="Yetişkin">🎓 Yetişkin (18 Yaş ve Üzeri)</option>
                </select>
              </div>

              <!-- 5. Bulunduğu İl -->
              <div class="col-md-6">
                <label for="regCity" class="form-label fw-bold text-dark small mb-1">
                  Bulunduğunuz İl <span class="text-danger">*</span>
                </label>
                <select name="city" id="regCity" class="form-select form-control-custom" required>
                  <option value="">-- İl Seçiniz --</option>
                  <?php 
                    $turkishCities = [
                      'Adana', 'Adıyaman', 'Afyonkarahisar', 'Ağrı', 'Aksaray', 'Amasya', 'Ankara', 'Antalya', 'Ardahan', 'Artvin',
                      'Aydın', 'Balıkesir', 'Bartın', 'Batman', 'Bayburt', 'Bilecik', 'Bingöl', 'Bitlis', 'Bolu', 'Burdur',
                      'Bursa', 'Çanakkale', 'Çankırı', 'Çorum', 'Denizli', 'Diyarbakır', 'Düzce', 'Edirne', 'Elazığ', 'Erzincan',
                      'Erzurum', 'Eskişehir', 'Gaziantep', 'Giresun', 'Gümüşhane', 'Hakkâri', 'Hatay', 'Iğdır', 'Isparta', 'İstanbul',
                      'İzmir', 'Kahramanmaraş', 'Karabük', 'Karaman', 'Kars', 'Kastamonu', 'Kayseri', 'Kilis', 'Kırıkkale', 'Kırklareli',
                      'Kırşehir', 'Kocaeli', 'Konya', 'Kütahya', 'Malatya', 'Manisa', 'Mardin', 'Mersin', 'Muğla', 'Muş',
                      'Nevşehir', 'Niğde', 'Ordu', 'Osmaniye', 'Rize', 'Sakarya', 'Samsun', 'Şanlıurfa', 'Siirt', 'Sinop',
                      'Şırnak', 'Sivas', 'Tekirdağ', 'Tokat', 'Trabzon', 'Tunceli', 'Uşak', 'Van', 'Yalova', 'Yozgat', 'Zonguldak'
                    ];
                    foreach ($turkishCities as $c):
                  ?>
                    <option value="<?= esc($c) ?>"><?= esc($c) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- 6. İlçe / Okul (Opsiyonel) -->
              <div class="col-md-6">
                <label for="regDistrict" class="form-label fw-bold text-dark small mb-1">
                  İlçe / Okul Adı <span class="text-muted">(İsteğe Bağlı)</span>
                </label>
                <input type="text" name="district" class="form-control form-control-custom" id="regDistrict"
                  placeholder="Örn: Kadıköy / Atatürk İ.Ö.O.">
              </div>

              <!-- 7. Şartname & KVKK Onayı -->
              <div class="col-12 mt-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="terms" id="registerTerms" value="1" required>
                  <label class="form-check-label small text-muted" for="registerTerms">
                    <a href="<?= base_url('sayfa/sartname') ?>" target="_blank" class="text-primary text-decoration-underline fw-semibold">Yarışma Şartnamesi</a>'ni ve 
                    <a href="<?= base_url('sayfa/uy-kvkk-aydinlatma-metni') ?>" target="_blank" class="text-primary text-decoration-underline fw-semibold">KVKK Aydınlatma Metni</a>'ni okudum, kabul ediyorum.
                  </label>
                </div>
              </div>

              <!-- Kayıt Tamamlama Butonu -->
              <div class="col-12 mt-3">
                <button type="submit" class="btn-yellow w-100 justify-content-center py-2 fs-6 fw-bold shadow-sm" id="btnRegisterSubmit">
                  <span>Kaydı Tamamla</span>
                  <span>→</span>
                </button>
              </div>
            </div>
          </form>
        </div>

        <!-- Modal Alt Bilgi -->
        <div class="modal-footer border-0 pt-0 pb-4 px-4 justify-content-center flex-column gap-2 text-center">
          <div class="small text-muted">
            Zaten bir yarışmacı kaydınız var mı? 
            <a href="#loginModal" data-bs-toggle="modal" data-bs-target="#loginModal" class="fw-bold text-dark text-decoration-underline">
              Giriş Yap
            </a>
          </div>
          <div class="small text-muted">
            Mobil uygulamamızla da kayıt olabilirsiniz: 
            <a href="https://apps.apple.com" target="_blank" rel="noopener" class="text-primary text-decoration-underline">App Store</a> · 
            <a href="https://play.google.com" target="_blank" rel="noopener" class="text-primary text-decoration-underline">Google Play</a>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- ==========================================
       MODAL: KİTAP DETAYLARI & HARİCİ DİNLEME/OKUMA PORTALI
       ========================================== -->
  <div class="modal fade" id="bookPreviewModal" tabindex="-1" aria-labelledby="bookPreviewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content border-0 shadow-2xl rounded-4 overflow-hidden custom-book-detail-modal">

        <!-- Modal Başlık Çubuğu -->
        <div class="modal-header border-0 pb-0 pt-4 px-4 px-lg-5 align-items-center">
          <div class="d-flex align-items-center gap-2">
            <span class="badge px-3 py-2 fw-bold fs-6 rounded-pill" id="previewModalCatBadge">🌱 İlkokul
              Kategorisi</span>
            <span class="badge bg-light text-secondary border px-3 py-2 fw-semibold rounded-pill"
              id="previewModalGradeBadge">1 - 4. Sınıf</span>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
        </div>

        <!-- Modal Gövde -->
        <div class="modal-body p-4 p-lg-5">
          <div class="row g-4 align-items-center">

            <!-- Sol Sütun: 3D Kitap Görseli & Temel Özellikler -->
            <div class="col-lg-4 text-center">
              <div class="modal-book-cover-stage mx-auto mb-3">
                <img src="<?= base_url('assets/images/book-ilkokul-3d.webp') ?>" alt="Kitap Kapağı" id="modalBookCoverImg"
                  class="img-fluid rounded-3 shadow-lg" width="230">
              </div>

              <div class="modal-book-spec-grid p-3 rounded-3 bg-light border text-start">
                <div class="d-flex justify-content-between py-1 border-bottom border-light-subtle small">
                  <span class="text-muted">🏢 Yayınevi:</span>
                  <strong class="text-dark" id="modalBookPublisher">Ufka Yolculuk Yayınları</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom border-light-subtle small">
                  <span class="text-muted">📄 Sayfa Sayısı:</span>
                  <strong class="text-dark" id="modalBookPages">144 Sayfa</strong>
                </div>
                <div class="d-flex justify-content-between py-1 border-bottom border-light-subtle small">
                  <span class="text-muted">🎯 Sınav Soru Sayısı:</span>
                  <strong class="text-dark" id="modalBookQuestions">40 Soru (Çoktan Seçmeli)</strong>
                </div>
                <div class="d-flex justify-content-between py-1 small">
                  <span class="text-muted">👥 Hedef Yaş Grubu:</span>
                  <strong class="text-dark" id="modalBookAge">6 - 10 Yaş</strong>
                </div>
              </div>
            </div>

            <!-- Sağ Sütun: Detaylı Bilgiler, Açıklama ve Subdomain Butonları -->
            <div class="col-lg-8">
              <div class="ps-lg-3">
                <h3 class="fw-bolder text-dark mb-1 fs-3" id="bookPreviewModalLabel">Dünyanın Her Köşesinden Maceralar
                </h3>
                <p class="text-muted fw-semibold mb-3" id="previewModalSubtitle">Eğlenceli Bilgiler, Erdemler ve
                  Hikayeler</p>

                <!-- Kitap Tanıtım Açıklaması -->
                <div class="modal-book-description-box p-3 rounded-3 bg-light-subtle border mb-4">
                  <h6 class="fw-bold text-dark mb-2">📖 Kitap Hakkında</h6>
                  <p class="text-secondary small mb-0 lh-lg" id="modalBookFullSummary">
                    Bu eser, çocukların ahlaki ve insani değerleri eğlenceli kurgular eşliğinde keşfetmelerini sağlar.
                    Dürüstlük, yardımlaşma, sabır ve sevgi gibi temel kavramlar pedagojik standartlara uygun hikayelerle
                    aktarılmaktadır.
                  </p>
                </div>

                <!-- Harici Subdomain Yönlendirme Butonları -->
                <div class="subdomain-action-banner-group mb-4">
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="fw-bold text-dark small text-uppercase letter-spacing-1">🌐 Çevrim İçi Okuma ve Dinleme Portalları</span>
                  </div>

                  <div class="row g-2">
                    <!-- 1. Oku Subdomain Butonu -->
                    <div class="col-md-6">
                      <a href="https://kutuphane.ufkayolculuk.com/kitap/ilkokul" target="_blank"
                        rel="noopener noreferrer" class="btn-subdomain-action btn-subdomain-read w-100"
                        id="btnSubdomainRead">
                        <div class="d-flex align-items-center gap-2">
                          <span class="action-icon">📖</span>
                          <div class="text-start">
                            <span class="action-title d-block">E-Kitap Olarak Oku</span>
                            <small class="action-sub d-block">kutuphane.ufkayolculuk.com</small>
                          </div>
                        </div>
                        <span class="external-link-arrow">↗</span>
                      </a>
                    </div>

                    <!-- 2. Dinle Subdomain Butonu -->
                    <div class="col-md-6">
                      <a href="https://sesli.ufkayolculuk.com/dinle/ilkokul" target="_blank" rel="noopener noreferrer"
                        class="btn-subdomain-action btn-subdomain-listen w-100" id="btnSubdomainListen">
                        <div class="d-flex align-items-center gap-2">
                          <span class="action-icon">🎧</span>
                          <div class="text-start">
                            <span class="action-title d-block">Sesli Kitap Dinle</span>
                            <small class="action-sub d-block">sesli.ufkayolculuk.com</small>
                          </div>
                        </div>
                        <span class="external-link-arrow">↗</span>
                      </a>
                    </div>
                  </div>
                </div>

                <!-- Dahili Mini Ses Oynatıcısı & Örnek Önizleme -->
                <div class="p-3 rounded-3 bg-white border shadow-xs" id="audioPlayerModule">
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="fw-bold text-dark small d-flex align-items-center gap-1">
                      <span>🎧 Mini Sesli Önizleme:</span>
                      <span id="audioTrackTitle" class="text-primary">1. Bölüm Seslendirmesi</span>
                    </span>
                    <span class="badge bg-success-subtle text-success small">Canlı Kayıt</span>
                  </div>

                  <div class="d-flex align-items-center gap-3">
                    <button type="button" class="btn-audio-play-trigger" id="audioTogglePlayBtn"
                      aria-label="Oynat/Durdur">
                      ▶
                    </button>
                    <div class="flex-grow-1">
                      <div class="progress" style="height: 6px; cursor: pointer;">
                        <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated"
                          role="progressbar" style="width: 35%"></div>
                      </div>
                      <div class="d-flex justify-content-between small text-muted mt-1" style="font-size: 0.75rem;">
                        <span id="audioTimeCurrent">01:15</span>
                        <span id="audioTimeTotal">03:40</span>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>

        <!-- Modal Alt Çubuğu -->
        <div class="modal-footer border-0 pt-0 pb-4 px-4 px-lg-5 d-flex justify-content-between align-items-center">
          <div class="text-muted small">
            Yarışma hazırlık kılavuzları ve test modüllerine yarışmacı panelinden de ulaşabilirsiniz.
          </div>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-light px-4 fw-semibold" data-bs-dismiss="modal">Kapat</button>
            <button type="button" class="btn-yellow px-4 py-2 fw-bold border-0" data-bs-toggle="modal" data-bs-target="#registerModal">Ücretsiz Kayıt Ol</button>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- ==========================================
       MODAL: OYUN & MİNİ ETKİNLİK BAŞLATICI
       ========================================== -->
  <div class="modal fade" id="gameModal" tabindex="-1" aria-labelledby="gameModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
        <div class="modal-header border-0 pb-0 pt-4 px-4 align-items-start">
          <div class="d-flex align-items-center gap-3">
            <div class="avatar-preview-circle" id="gameModalIcon">
              🎮
            </div>
            <div>
              <span class="badge bg-primary text-white fw-bold px-2 py-1 mb-1" id="gameModalBadge">Mini Oyun</span>
              <h4 class="modal-title fw-bold text-dark mb-0" id="gameModalLabel">Oyun Başlığı</h4>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
        </div>
        <div class="modal-body p-4">
          <p class="text-secondary mb-3" id="gameModalDesc">
            Yarışma kitaplarındaki kavramları ve olayları eğlenerek pekiştirin.
          </p>
          <div class="p-3 bg-light rounded-3 border mb-3">
            <div class="d-flex align-items-center justify-content-between small text-muted mb-2">
              <span>🎯 Görev Ödülü: <strong class="text-dark">+50 XP</strong></span>
              <span>⏱️ Süre: <strong class="text-dark">Sınırsız</strong></span>
            </div>
            <div class="d-flex align-items-center justify-content-between small text-muted">
              <span>👥 Katılımcı: <strong class="text-dark">Bireysel / Online</strong></span>
              <span>🏆 Sıralama: <strong class="text-dark">Aktif</strong></span>
            </div>
          </div>
          <div class="alert alert-warning d-flex align-items-center gap-2 py-2 px-3 small mb-0 rounded-3">
            <span>💡</span>
            <span>Skorların liderlik tablosuna işlenmesi için giriş yapmanız önerilir.</span>
          </div>
        </div>
        <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex justify-content-between align-items-center">
          <button type="button" class="btn btn-light px-3 fw-semibold" data-bs-dismiss="modal">Kapat</button>
          <a href="#loginModal" data-bs-toggle="modal" class="btn-yellow px-4 py-2 fw-bold">Oyunu Başlat 🎮</a>
        </div>
      </div>
    </div>
  </div>

  <!-- ==========================================
       MODAL: PODCAST & VIDEO MEDYA OYNATICI
       ========================================== -->
  <div class="modal fade" id="mediaPlayerModal" tabindex="-1" aria-labelledby="mediaPlayerModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow-2xl rounded-4 overflow-hidden custom-media-modal">
        <!-- Modal Başlık -->
        <div class="modal-header border-0 pb-0 pt-4 px-4 align-items-center">
          <div class="d-flex align-items-center gap-2">
            <span class="badge px-3 py-2 fw-bold fs-6 rounded-pill" id="mediaPlayerTagBadge">PODCAST</span>
            <span class="badge bg-light text-secondary border px-3 py-2 fw-semibold rounded-pill"
              id="mediaPlayerDurationBadge">⏱️ 24:35</span>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
        </div>

        <!-- Modal Gövde -->
        <div class="modal-body p-4">
          <!-- Video Oynatıcı Çerçevesi (16:9) -->
          <div
            class="media-modal-player-wrapper mb-3 rounded-3 overflow-hidden bg-black position-relative ratio ratio-16x9">
            <video id="mediaPlayerVideo" class="w-100 h-100 d-none" controls playsinline></video>
            <iframe id="mediaPlayerIframe" src="" title="Ufka Yolculuk Medya Oynatıcı"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
              allowfullscreen class="w-100 h-100 border-0"></iframe>
          </div>

          <h3 class="fw-bold text-dark fs-4 mb-2" id="mediaPlayerModalLabel">Medya Başlığı</h3>
          <p class="text-secondary small mb-0 lh-base" id="mediaPlayerModalDesc">
            Ufka Yolculuk rehber içerikleri, sohbetler ve ilham verici yayınlar.
          </p>
        </div>

        <!-- Modal Alt Çubuğu -->
        <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex justify-content-between align-items-center">
          <div class="text-muted small">
            🎧 Diğer tüm podcast ve video serilerine medya sayfamızdan ulaşabilirsiniz.
          </div>
          <button type="button" class="btn btn-secondary px-4 fw-semibold rounded-pill"
            data-bs-dismiss="modal">Kapat</button>
        </div>
      </div>
    </div>
  </div>
