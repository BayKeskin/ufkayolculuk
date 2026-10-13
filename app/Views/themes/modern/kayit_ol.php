<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
  /* =========================================================
     UFKA YOLCULUK 4 ADIMLI YARIŞMACI KAYIT SİHİRBAZI STİLLERİ
     ========================================================= */
  .rgs-container {
    max-width: 1000px;
    margin: 0 auto;
  }
  
  .rgs-form-container {
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.07);
    border: 1px solid rgba(0, 0, 0, 0.06);
    overflow: hidden;
  }
  
  .rgs-progress-container {
    padding: 35px 40px 25px;
    background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom: 1px solid #e2e8f0;
  }
  
  .rgs-progress-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    cursor: default;
  }
  
  .rgs-step-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background-color: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
    font-weight: 700;
    font-size: 1.15rem;
    color: #64748b;
    z-index: 2;
    transition: all 0.3s ease;
  }

  .rgs-step-icon i {
    color: #64748b;
    font-size: 1.25rem;
    transition: color 0.3s ease;
  }
  
  .rgs-progress-step.rgs-active .rgs-step-icon {
    background-color: var(--primary, #0d6efd);
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(13, 110, 253, 0.35);
  }

  .rgs-progress-step.rgs-active .rgs-step-icon i {
    color: #ffffff;
  }
  
  .rgs-progress-step.rgs-completed .rgs-step-icon {
    background-color: #10b981;
    color: #ffffff;
  }

  .rgs-progress-step.rgs-completed .rgs-step-icon i {
    color: #ffffff;
  }
  
  .rgs-step-label {
    font-size: 0.85rem;
    color: #64748b;
    text-align: center;
    font-weight: 500;
    transition: color 0.3s ease;
  }
  
  .rgs-progress-step.rgs-active .rgs-step-label {
    color: var(--primary, #0d6efd);
    font-weight: 700;
  }

  .rgs-progress-step.rgs-completed .rgs-step-label {
    color: #10b981;
    font-weight: 600;
  }
  
  .rgs-progress-connector {
    position: absolute;
    top: 24px;
    left: -50%;
    width: 100%;
    height: 3px;
    background-color: #e2e8f0;
    z-index: 1;
    transition: background-color 0.4s ease;
  }

  .rgs-progress-step.rgs-completed .rgs-progress-connector,
  .rgs-progress-step.rgs-active .rgs-progress-connector {
    background-color: #10b981;
  }
  
  .rgs-progress-step:first-child .rgs-progress-connector {
    display: none;
  }
  
  .rgs-form-section {
    padding: 40px;
    display: none;
  }
  
  .rgs-form-section.rgs-active {
    display: block;
    animation: rgs-fadeIn 0.4s ease;
  }
  
  @keyframes rgs-fadeIn {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
  }
  
  /* Form Elemanları ve Hizalama Standartları */
  .rgs-label {
    padding-top: 11px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0;
  }
  
  .rgs-form-control, .rgs-form-select {
    height: 48px;
    min-height: 48px;
    border-radius: 10px;
    padding: 10px 16px;
    border: 1.5px solid #cbd5e1;
    font-size: 0.95rem;
    line-height: 1.5;
    box-sizing: border-box;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
  }
  
  .rgs-form-control:focus, .rgs-form-select:focus {
    border-color: var(--primary, #0d6efd);
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
  }

  .rgs-form-control.is-invalid, .rgs-form-select.is-invalid {
    border-color: #ef4444;
  }

  .invalid-feedback {
    font-size: 0.825rem;
    font-weight: 500;
    margin-top: 4px;
  }
  
  .rgs-btn-primary {
    background: linear-gradient(135deg, #1e3a8a 0%, #0d6efd 100%);
    border: none;
    height: 48px;
    padding: 0 28px;
    border-radius: 10px;
    color: #ffffff;
    font-weight: 600;
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }
  
  .rgs-btn-primary:hover {
    background: linear-gradient(135deg, #172554 0%, #1d4ed8 100%);
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(13, 110, 253, 0.25);
  }
  
  .rgs-navigation-buttons {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 35px;
    padding-top: 25px;
    border-top: 1px solid #f1f5f9;
  }
  
  .rgs-review-container {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 10px 20px;
  }

  .rgs-review-item {
    padding: 14px 0;
    border-bottom: 1px solid #e2e8f0;
  }
  
  .rgs-review-item:last-child {
    border-bottom: none;
  }
  
  .rgs-review-label {
    font-weight: 700;
    color: #1e3a8a;
  }
  
  .rgs-success-card {
    text-align: center;
    padding: 50px 30px;
    border-radius: 16px;
    background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 100%);
    border: 1px solid #a7f3d0;
    margin-bottom: 30px;
  }
  
  .rgs-success-icon i {
    font-size: 4rem;
    color: #10b981;
    margin-bottom: 15px;
  }
  
  .rgs-action-card {
    text-align: center;
    padding: 24px 20px;
    border-radius: 14px;
    transition: all 0.3s ease;
    height: 100%;
    background: #ffffff;
    border: 1.5px solid #e2e8f0;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }
  
  .rgs-action-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
    border-color: #cbd5e1;
  }
  
  .rgs-action-icon i {
    font-size: 2.2rem;
    color: var(--primary, #0d6efd);
  }

  /* Select2 Özelleştirme & Genişlik Sabitleme */
  .select2-container {
    width: 100% !important;
    display: block;
  }
  .select2-container--default .select2-selection--single {
    height: 48px !important;
    min-height: 48px !important;
    padding: 10px 16px !important;
    border: 1.5px solid #cbd5e1 !important;
    border-radius: 10px !important;
    background-color: #fff !important;
    font-size: 0.95rem !important;
    line-height: 26px !important;
    display: flex !important;
    align-items: center !important;
    box-sizing: border-box !important;
    transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
  }
  .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 46px !important;
    top: 1px !important;
    right: 12px !important;
  }
  .select2-container--default .select2-selection--single .select2-selection__rendered {
    padding-left: 0 !important;
    padding-right: 24px !important;
    color: #1e293b !important;
    line-height: 26px !important;
    width: 100% !important;
  }
  .select2-container--default.select2-container--focus .select2-selection--single {
    border-color: var(--primary, #0d6efd) !important;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15) !important;
  }
  .select2-container--default .select2-selection--single.is-invalid,
  .select2-selection.is-invalid {
    border: 1.5px solid #ef4444 !important;
  }

  /* Takım Lideri Input Group */
  .rgs-input-group {
    display: flex;
    width: 100%;
  }
  .rgs-input-group .rgs-form-control {
    border-top-right-radius: 0 !important;
    border-bottom-right-radius: 0 !important;
    flex: 1 1 auto;
    width: 1%;
  }
  .rgs-input-group .btn {
    height: 48px;
    min-height: 48px;
    border-width: 1.5px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-top-left-radius: 0 !important;
    border-bottom-left-radius: 0 !important;
    margin-left: -1.5px;
    z-index: 2;
  }

  @media (max-width: 768px) {
    .rgs-progress-container {
      padding: 20px 15px 15px;
    }
    .rgs-form-section {
      padding: 25px 15px;
    }
    .rgs-step-icon {
      width: 40px;
      height: 40px;
      font-size: 0.95rem;
    }
    .rgs-step-label {
      font-size: 0.75rem;
    }
    .rgs-label {
      padding-top: 0;
      margin-bottom: 8px;
    }
  }
</style>

<!-- ==========================================
     HERO BANNER & BREADCRUMB
     ========================================== -->
<section class="page-hero-banner">
  <div class="container">
    <nav class="breadcrumb-custom" aria-label="Sayfa Yolu">
      <a href="<?= base_url('/') ?>">Ana Sayfa</a>
      <span class="separator">/</span>
      <span class="current">Yarışmacı Kaydı</span>
    </nav>

    <h1 class="page-hero-title">Yarışmaya Kayıt Ol</h1>
    <p class="text-white-50 fs-6 mb-0 mt-2">
      Ufka Yolculuk 12. Bilgi ve Kültür Yarışması'na ücretsiz kaydolun, büyük ödüllere ve yolculuğa ortak olun.
    </p>
  </div>
</section>

<!-- ==========================================
     KAYIT SİHİRBAZI BÖLÜMÜ
     ========================================== -->
<section class="py-5 bg-light-subtle">
  <div class="container py-2">
    <div class="rgs-container">
      <div class="rgs-form-container">
        
        <!-- İLERLEME ÇUBUĞU (STEP BAR) -->
        <div class="rgs-progress-container">
          <h2 class="text-center mb-4 fs-4 fw-bold text-dark">4 Adımda Kolay Kayıt</h2>
          <div class="row align-items-center">
            <div class="col-3 rgs-progress-step rgs-active" data-step="1">
              <div class="rgs-step-icon">
                <i class="bi bi-person"></i>
              </div>
              <div class="rgs-step-label">Kullanıcı Bilgileri</div>
              <div class="rgs-progress-connector"></div>
            </div>
            <div class="col-3 rgs-progress-step" data-step="2">
              <div class="rgs-step-icon">
                <i class="bi bi-geo-alt"></i>
              </div>
              <div class="rgs-step-label">Katılım Bilgileri</div>
              <div class="rgs-progress-connector"></div>
            </div>
            <div class="col-3 rgs-progress-step" data-step="3">
              <div class="rgs-step-icon">
                <i class="bi bi-eye"></i>
              </div>
              <div class="rgs-step-label">Gözden Geçir</div>
              <div class="rgs-progress-connector"></div>
            </div>
            <div class="col-3 rgs-progress-step" data-step="4">
              <div class="rgs-step-icon">
                <i class="bi bi-check-circle"></i>
              </div>
              <div class="rgs-step-label">Kayıt Tamamlandı</div>
              <div class="rgs-progress-connector"></div>
            </div>
          </div>
        </div>

        <!-- FORM BAŞLANGICI -->
        <form id="rgs_account_form" novalidate>
          <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf-token-field" />
          
          <!-- ====================================================
               ADIM 1: KULLANICI BİLGİLERİ (Ön Kontrol & Doğrulama)
               ==================================================== -->
          <div class="rgs-form-section rgs-active" id="rgs-section-1">
            <h4 class="mb-4 text-dark fw-bold d-flex align-items-center">
              <i class="bi bi-person-circle text-primary me-2 fs-3"></i> Kullanıcı Bilgileri
            </h4>
            
            <!-- Doğum Tarihi (Gün / Ay / Yıl) -->
            <!-- Doğum Tarihi (Gün / Ay / Yıl) -->
            <div class="row mb-4">
              <label class="col-lg-3 col-form-label rgs-label">
                Doğum Tarihi <span class="text-danger">*</span>
              </label>
              <div class="col-lg-9">
                <div class="row g-2 g-sm-3">
                  <div class="col-4">
                    <select name="day" class="form-select rgs-form-control" required>
                      <option value="">Gün</option>
                      <?php for ($d = 1; $d <= 31; $d++): ?>
                        <option value="<?= $d ?>"><?= $d ?></option>
                      <?php endfor; ?>
                    </select>
                    <div class="invalid-feedback">Gün seçiniz.</div>
                  </div>
                  <div class="col-4">
                    <select name="month" class="form-select rgs-form-control" required>
                      <option value="">Ay</option>
                      <?php 
                        $months = [
                          '01' => 'Ocak', '02' => 'Şubat', '03' => 'Mart', '04' => 'Nisan',
                          '05' => 'Mayıs', '06' => 'Haziran', '07' => 'Temmuz', '08' => 'Ağustos',
                          '09' => 'Eylül', '10' => 'Ekim', '11' => 'Kasım', '12' => 'Aralık'
                        ];
                        foreach ($months as $mCode => $mName):
                      ?>
                        <option value="<?= $mCode ?>"><?= $mName ?></option>
                      <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Ay seçiniz.</div>
                  </div>
                  <div class="col-4">
                    <select name="year" class="form-select rgs-form-control" required>
                      <option value="">Yıl</option>
                      <?php for ($y = 2020; $y >= 1920; $y--): ?>
                        <option value="<?= $y ?>"><?= $y ?></option>
                      <?php endfor; ?>
                    </select>
                    <div class="invalid-feedback">Yıl seçiniz.</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Cep Telefonu (Ülke Kodu + Numara) -->
            <div class="row mb-4">
              <label class="col-lg-3 col-form-label rgs-label">
                Cep Telefonu <span class="text-danger">*</span>
              </label>
              <div class="col-lg-9">
                <div class="row g-2 g-sm-3">
                  <div class="col-5 col-sm-4">
                    <select name="country_code" id="country_code" class="form-select rgs-form-control" required>
                      <?php foreach ($phoneCodes as $p): ?>
                        <option value="<?= esc($p['code'] ?? '') ?>" 
                                data-id="<?= esc($p['data_id'] ?? '') ?>"
                                <?= (($p['code'] ?? '') === '90' && ($p['data_id'] ?? '') === '225') ? 'selected' : '' ?>>
                          <?= esc($p['name'] ?? '') ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-7 col-sm-8">
                    <input type="tel" name="mobile" id="mobile" class="form-control rgs-form-control"
                           placeholder="5551234567" maxlength="15" required>
                    <div class="invalid-feedback">Lütfen geçerli bir telefon giriniz (Örn: 5551234567).</div>
                  </div>
                </div>
              </div>
            </div>

            <div class="rgs-navigation-buttons">
              <div></div>
              <button type="button" class="btn rgs-btn-primary rgs-next-btn" data-next="2">
                <span>Devam Et</span> <i class="bi bi-arrow-right ms-2"></i>
              </button>
            </div>
          </div>

          <!-- ====================================================
               ADIM 2: KATILIM BİLGİLERİ (Kişisel, Konum, Okul, Lider)
               ==================================================== -->
          <div class="rgs-form-section" id="rgs-section-2">
            <h4 class="mb-4 text-dark fw-bold d-flex align-items-center">
              <i class="bi bi-geo-alt-fill text-primary me-2 fs-3"></i> Katılım Bilgileri
            </h4>

            <!-- Ülke -->
            <div class="row mb-4">
              <label class="col-lg-3 col-form-label rgs-label">
                Ülke <span class="text-danger">*</span>
              </label>
              <div class="col-lg-9">
                <select name="country_id" id="country" class="form-select rgs-form-select" data-control="select2" required>
                  <?php foreach ($countries as $c): ?>
                    <option value="<?= esc($c['id'] ?? '') ?>" <?= ($c['id'] ?? 0) === 225 ? 'selected' : '' ?>>
                      <?= esc($c['name'] ?? '') ?>
                    </option>
                  <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Lütfen ülke seçiniz.</div>
              </div>
            </div>

            <!-- Ad Soyad -->
            <div class="row mb-4">
              <label class="col-lg-3 col-form-label rgs-label">
                İsim Bilgisi <span class="text-danger">*</span>
              </label>
              <div class="col-lg-9">
                <div class="row g-2 g-sm-3">
                  <div class="col-6">
                    <input type="text" name="name" class="form-control rgs-form-control" placeholder="Adınız" required>
                    <div class="invalid-feedback">Lütfen adınızı giriniz.</div>
                  </div>
                  <div class="col-6">
                    <input type="text" name="surname" class="form-control rgs-form-control" placeholder="Soyadınız" required>
                    <div class="invalid-feedback">Lütfen soyadınızı giriniz.</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Cinsiyet -->
            <div class="row mb-4">
              <label class="col-lg-3 col-form-label rgs-label">
                Cinsiyet <span class="text-danger">*</span>
              </label>
              <div class="col-lg-9">
                <select name="gender_id" class="form-select rgs-form-select" required>
                  <option value="">Lütfen Seçiniz</option>
                  <option value="1">Erkek</option>
                  <option value="2">Kız</option>
                </select>
                <div class="invalid-feedback">Lütfen cinsiyet seçiniz.</div>
              </div>
            </div>

            <!-- Kategori -->
            <div class="row mb-4">
              <label class="col-lg-3 col-form-label rgs-label">
                Kategori <span class="text-danger">*</span>
              </label>
              <div class="col-lg-9">
                <select name="category_id" data-control="select2" class="form-select rgs-form-select" required>
                  <option value="">Kategori Seçiniz</option>
                  <option value="45">İlkokul</option>
                  <option value="46">Ortaokul</option>
                  <option value="47">Lise</option>
                  <option value="48">Yetişkin</option>
                  <option value="50">İlahiyat</option>
                </select>
                <div class="invalid-feedback">Lütfen kategori seçiniz.</div>
              </div>
            </div>

            <!-- İlahiyat Özel Öğrenci Kontrol Switch'i -->
            <div class="row mb-4 d-none" id="studentControl">
              <label class="col-lg-3 col-form-label rgs-label">
                Öğrenci Kontrolü
              </label>
              <div class="col-lg-9">
                <div class="d-flex align-items-center gap-3 pt-lg-2">
                  <div class="form-check form-switch m-0">
                    <input class="form-check-input" type="checkbox" role="switch" id="rgs-student-approval" style="width: 2.8em; height: 1.4em; cursor: pointer;">
                  </div>
                  <label class="form-check-label fw-semibold text-dark mb-0" for="rgs-student-approval" style="cursor: pointer;">
                    Evet, aktif olarak ilahiyat öğrencisiyim.
                  </label>
                </div>
              </div>
            </div>

            <!-- İl ve İlçe (Türkiye için) -->
            <div class="row mb-4" id="city-county-area">
              <label class="col-lg-3 col-form-label rgs-label">
                İl - İlçe <span class="text-danger">*</span>
              </label>
              <div class="col-lg-9">
                <div class="row g-2 g-sm-3">
                  <div class="col-6">
                    <select name="city_id" data-control="select2" class="form-select rgs-form-select" required>
                      <option value="">İl Seçiniz</option>
                      <?php foreach ($cities as $city): ?>
                        <option value="<?= esc($city['id']) ?>"><?= esc($city['name']) ?></option>
                      <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Lütfen il seçiniz.</div>
                  </div>
                  <div class="col-6">
                    <select name="county_id" data-control="select2" class="form-select rgs-form-select" required>
                      <option value="">İlçe Seçiniz</option>
                    </select>
                    <div class="invalid-feedback">Lütfen ilçe seçiniz.</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Okul Seçimi (Öğrenci Kategorileri İçin) -->
            <div class="row mb-4" id="school_area">
              <label class="col-lg-3 col-form-label rgs-label" for="school_id">
                Okul Seçimi
              </label>
              <div class="col-lg-9">
                <select name="school_id" id="school_id" data-control="select2" class="form-select rgs-form-select">
                  <option value="">Okul Seçiniz</option>
                </select>
              </div>
            </div>

            <!-- Takım Lideri Kodu Sorgulama -->
            <div class="row mb-4">
              <label class="col-lg-3 col-form-label rgs-label">
                Takım Lideri Kodu
              </label>
              <div class="col-lg-9">
                <div class="rgs-input-group">
                  <input type="text" id="leaderCode" name="leaderCode" class="form-control rgs-form-control"
                         placeholder="Eğer takım lideriniz varsa kodunu giriniz (İsteğe bağlı)">
                  <button type="button" id="checkLeaderBtn" class="btn btn-outline-primary px-3">
                    <i class="bi bi-search me-1"></i> Sorgula
                  </button>
                  <button type="button" id="removeLeaderBtn" class="btn btn-outline-danger px-3" style="display: none;">
                    <i class="bi bi-x-circle me-1"></i> Sil
                  </button>
                </div>
                <input type="hidden" id="leaderId" name="inviter_user_id" value="0">
                <div id="leaderMessage" class="mt-2 small fw-bold"></div>
              </div>
            </div>

            <div class="rgs-navigation-buttons">
              <button type="button" class="btn btn-outline-secondary rgs-prev-btn px-4" data-prev="1">
                <i class="bi bi-arrow-left me-2"></i> Geri
              </button>
              <button type="button" class="btn rgs-btn-primary rgs-next-btn" data-next="3">
                <span>İleri</span> <i class="bi bi-arrow-right ms-2"></i>
              </button>
            </div>
          </div>

          <!-- ====================================================
               ADIM 3: GÖZDEN GEÇİR & ONAY (Özet Kartı & KVKK)
               ==================================================== -->
          <div class="rgs-form-section" id="rgs-section-3">
            <h4 class="mb-3 text-dark fw-bold d-flex align-items-center">
              <i class="bi bi-eye-fill text-primary me-2 fs-3"></i> Bilgileri Gözden Geçir & Onayla
            </h4>
            
            <div class="alert alert-info py-2 px-3 small mb-4 d-flex align-items-center">
              <i class="bi bi-info-circle-fill fs-5 me-2"></i>
              <span>Lütfen kayıt bilgilerinizi kontrol edin. Hatalı bir bilgi varsa "Geri Düzenle" butonuna tıklayabilirsiniz.</span>
            </div>

            <!-- Özet Tablosu -->
            <div class="rgs-review-container mb-4">
              <div class="rgs-review-item">
                <div class="row align-items-center">
                  <div class="col-5 col-sm-4 rgs-review-label">Doğum Tarihi:</div>
                  <div class="col-7 col-sm-8 text-dark fw-semibold" id="rgs-review-birth">-</div>
                </div>
              </div>
              <div class="rgs-review-item">
                <div class="row align-items-center">
                  <div class="col-5 col-sm-4 rgs-review-label">Ad Soyad:</div>
                  <div class="col-7 col-sm-8 text-dark fw-semibold" id="rgs-review-name">-</div>
                </div>
              </div>
              <div class="rgs-review-item">
                <div class="row align-items-center">
                  <div class="col-5 col-sm-4 rgs-review-label">Cinsiyet:</div>
                  <div class="col-7 col-sm-8 text-dark fw-semibold" id="rgs-review-gender">-</div>
                </div>
              </div>
              <div class="rgs-review-item">
                <div class="row align-items-center">
                  <div class="col-5 col-sm-4 rgs-review-label">Telefon:</div>
                  <div class="col-7 col-sm-8 text-dark fw-semibold" id="rgs-review-phone">-</div>
                </div>
              </div>
              <div class="rgs-review-item">
                <div class="row align-items-center">
                  <div class="col-5 col-sm-4 rgs-review-label">Kategori:</div>
                  <div class="col-7 col-sm-8 text-dark fw-semibold" id="rgs-review-category">-</div>
                </div>
              </div>
              <div class="rgs-review-item">
                <div class="row align-items-center">
                  <div class="col-5 col-sm-4 rgs-review-label">Ülke:</div>
                  <div class="col-7 col-sm-8 text-dark fw-semibold" id="rgs-review-country">-</div>
                </div>
              </div>
              <div class="rgs-review-item" id="rgs-review-location-wrapper">
                <div class="row align-items-center">
                  <div class="col-5 col-sm-4 rgs-review-label">İl - İlçe:</div>
                  <div class="col-7 col-sm-8 text-dark fw-semibold" id="rgs-review-location">-</div>
                </div>
              </div>
              <div class="rgs-review-item" id="rgs-review-school-wrapper">
                <div class="row align-items-center">
                  <div class="col-5 col-sm-4 rgs-review-label">Okul:</div>
                  <div class="col-7 col-sm-8 text-dark fw-semibold" id="rgs-review-school">-</div>
                </div>
              </div>
              <!-- KVKK Aydınlatma Metni Switch Onayı -->
              <div class="rgs-review-item bg-white rounded-3 p-3 mt-3 border">
                <div class="d-flex align-items-start gap-3">
                  <div class="form-check form-switch m-0 pt-1">
                    <input class="form-check-input" type="checkbox" role="switch" id="rgs-kvkk-approval" required style="width: 2.8em; height: 1.4em; cursor: pointer;">
                  </div>
                  <div class="flex-grow-1">
                    <label class="form-check-label text-dark fw-semibold" for="rgs-kvkk-approval" style="cursor: pointer;">
                      Kişisel verilerimin işlenmesine ilişkin 
                      <a href="<?= base_url('sayfa/uy-kvkk-aydinlatma-metni') ?>" target="_blank" class="text-primary text-decoration-underline">
                        KVKK Aydınlatma Metni
                      </a> ve Yarışma Şartnamesi'ni okudum, onaylıyorum. <span class="text-danger">*</span>
                    </label>
                    <div class="invalid-feedback">Devam etmek için şartname ve aydınlatma metnini onaylamalısınız.</div>
                  </div>
                </div>
              </div>
            </div>

            <div class="rgs-navigation-buttons">
              <button type="button" class="btn btn-outline-secondary rgs-prev-btn px-4" data-prev="2">
                <i class="bi bi-arrow-left me-2"></i> Geri Düzenle
              </button>
              <button type="submit" class="btn rgs-btn-primary submitButton">
                <span>Kaydı Tamamla</span> <i class="bi bi-check-circle ms-2"></i>
              </button>
            </div>
          </div>

          <!-- ====================================================
               ADIM 4: KAYIT TAMAMLANDI / BAŞARI EKRANI
               ==================================================== -->
          <div class="rgs-form-section" id="rgs-section-4">
            <!-- Başarı Kutusu -->
            <div class="rgs-success-card">
              <div class="rgs-success-icon">
                <i class="bi bi-check-circle-fill"></i>
              </div>
              <h3 class="fw-bold text-dark mb-2">Tebrikler! Kaydınız Başarıyla Tamamlandı!</h3>
              <p class="text-muted mb-4 fs-6">
                Ufka Yolculuk yarışmacı kaydınız sisteme aktarıldı. Sınav sürecinde başarılar dileriz!
              </p>
              <div>
                <button type="button" class="btn btn-success fw-bold px-4 py-2" data-bs-toggle="modal" data-bs-target="#certificateModal">
                  <i class="bi bi-award me-2"></i> Katılım Sertifikamı Görüntüle / İndir
                </button>
              </div>
            </div>

            <!-- SINAV TAKVİMİ KARTI -->
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 14px; background: #ffffff;">
              <div class="card-body p-4 text-center">
                <h4 class="fw-bold text-primary mb-3">
                  📅 Online Sınav Tarihleri: 7 - 8 Mart 2026
                </h4>
                <div class="row text-start g-3 my-2">
                  <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                      <span class="badge bg-primary me-2">İlkokul</span> <strong>8 Mart Pazar</strong> - 12:00
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                      <span class="badge bg-info text-dark me-2">Ortaokul</span> <strong>7 Mart Cumartesi</strong> - 15:00
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                      <span class="badge bg-warning text-dark me-2">Lise</span> <strong>7 Mart Cumartesi</strong> - 12:00
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 border">
                      <span class="badge bg-secondary me-2">Yetişkin & İlahiyat</span> <strong>8 Mart Pazar</strong> - 15:00
                    </div>
                  </div>
                </div>

                <div class="alert alert-warning mt-3 mb-4 fw-semibold small">
                  ⚠️ Umre ve büyük ödül çekilişlerine hak kazanabilmek için online sınava katılmanız gerekmektedir.
                </div>

                <a href="https://sinav.ufkayolculuk.com" target="_blank" class="btn btn-danger fw-bold px-4 py-2">
                  🚀 Sınav Portalı: sinav.ufkayolculuk.com (Sınav Tarihlerinde Aktif Olacaktır)
                </a>
              </div>
            </div>

            <!-- SONRAKİ ADIM AKSİYON KARTLARI -->
            <h4 class="text-center fw-bold text-dark mb-4 mt-5">Şimdi Ne Yapmak İstersiniz?</h4>
            <div class="row g-3">
              <!-- Kart 1: Kitap Oku -->
              <div class="col-md-3">
                <div class="rgs-action-card">
                  <div>
                    <div class="rgs-action-icon mb-3">
                      <i class="bi bi-book"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Kitap Oku</h5>
                    <p class="small text-muted mb-3">Yarışma kitaplarına ve içeriklerine hemen erişin.</p>
                  </div>
                  <a href="<?= base_url('/#kategoriler') ?>" class="btn btn-outline-primary btn-sm fw-bold w-100">
                    Kitapları İncele
                  </a>
                </div>
              </div>

              <!-- Kart 2: Online Soru Çöz -->
              <div class="col-md-3">
                <div class="rgs-action-card">
                  <div>
                    <div class="rgs-action-icon mb-3">
                      <i class="bi bi-pencil-square"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Online Deneme</h5>
                    <p class="small text-muted mb-3">Sınava hazırlanmak için mini deneme testini çözün.</p>
                  </div>
                  <a id="examLink" href="https://minideneme.ufkayolculuk.com" target="_blank" class="btn btn-primary btn-sm fw-bold w-100">
                    Testi Başlat
                  </a>
                </div>
              </div>

              <!-- Kart 3: Arkadaşını Davet Et -->
              <div class="col-md-3">
                <div class="rgs-action-card" style="background: linear-gradient(180deg, #fffbeb 0%, #ffffff 100%); border-color: #fde68a;">
                  <div>
                    <div class="rgs-action-icon mb-3">
                      <i class="bi bi-people text-warning"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Davet Et</h5>
                    <p class="small text-muted mb-3">Arkadaşlarınızı davet ederek yolculuğa ortak edin.</p>
                  </div>
                  <button type="button" class="btn btn-warning btn-sm fw-bold w-100 text-dark" onclick="navigator.clipboard.writeText(window.location.origin + '/kayit-ol'); alert('Kayıt bağlantısı kopyalandı! Arkadaşlarınızla paylaşabilirsiniz.');">
                    Linki Kopyala
                  </button>
                </div>
              </div>

              <!-- Kart 4: Takım Lideri Ol -->
              <div class="col-md-3" id="wantLeaderArea">
                <div class="rgs-action-card" style="background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%); border-color: #bbf7d0;">
                  <div>
                    <div class="rgs-action-icon mb-3">
                      <i class="bi bi-trophy text-success"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">Takım Lideri Ol</h5>
                    <p class="small text-muted mb-3">Kendi takımını kur, liderlik ödüllerini kazan.</p>
                  </div>
                  <a href="<?= base_url('sayfa/hakkimizda') ?>" class="btn btn-success btn-sm fw-bold w-100">
                    Detaylı Bilgi
                  </a>
                </div>
              </div>
            </div>

            <!-- Ana Sayfa Butonu -->
            <div class="text-center mt-5">
              <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary px-4 py-2">
                <i class="bi bi-house-door me-2"></i> Ana Sayfaya Dön
              </a>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</section>

<!-- ==========================================
     KAYIT SERTİFİKASI MODALI
     ========================================== -->
<div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="certificateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 shadow border-0">
      <div class="modal-header border-bottom py-3 px-4">
        <h5 class="modal-title fw-bold text-dark" id="certificateModalLabel">
          🏆 Yarışma Katılım Sertifikası
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
      </div>
      <div class="modal-body p-4 text-center" id="certificateArea">
        <img id="certificateImg" src="https://t1.ufkayolculuk.com/uploads/2024-10/sertifika_katilimci.webp" alt="Katılım Sertifikası" class="img-fluid rounded-3 shadow-sm border" style="max-height: 500px;">
      </div>
      <div class="modal-footer border-top py-3 px-4 justify-content-between">
        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Kapat</button>
        <div class="d-flex gap-2">
          <button type="button" id="btnDownload" class="btn btn-success px-4 fw-bold">
            <i class="bi bi-download me-1"></i> Sertifikamı İndir
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function () {
    // 1. Select2 Başlatma
    $('select[data-control="select2"]').select2({
        placeholder: "Seçiniz",
        allowClear: true,
        width: '100%'
    });

    // 2. Telefon Format Kontrolü (+90 için 10 hane, 5 ile başlayan)
    function validatePhone(phone) {
        const countryCode = $('#country_code').val();
        if (countryCode == "90") {
            return /^5\d{9}$/.test(phone);
        }
        return phone.length >= 6;
    }

    $('input[name="mobile"]').on('input', function() {
        // Sadece rakamları filtrele, harf girildiğinde zıplamayı önle
        this.value = this.value.replace(/\D/g, '').substring(0, 15);
        if (validatePhone(this.value.trim())) {
            $(this).removeClass('is-invalid');
        }
    });

    $('input[name="mobile"]').on('blur', function() {
        if (this.value.trim() !== '') {
            $(this).toggleClass('is-invalid', !validatePhone(this.value.trim()));
        }
    });

    // 3. Telefon Ülke Koduna Göre Ülke ve Placeholder Güncelleme
    $('#country_code').change(function() {
        var cc = $(this).val();
        var ccid = $(this).find('option:selected').data('id');
        if (ccid) {
            $('#country').val(ccid).trigger('change.select2').change();
        }
        if (cc == '90') {
            $('#mobile').attr("placeholder", "5551234567");
        } else {
            $('#mobile').attr("placeholder", "Telefon Numaranız");
        }
    });

    // 4. Doğum Tarihine Göre Otomatik Kategori Tahmini
    function updatePredictedCategory() {
        const day = $('select[name="day"]').val();
        const month = $('select[name="month"]').val();
        const year = $('select[name="year"]').val();
        if (!day || !month || !year) return;

        const birthDate = new Date(`${year}-${month}-${day}`);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        let defaultCategory = "48"; // Yetişkin
        if (age >= 6 && age <= 10) {
            defaultCategory = "45"; // İlkokul
        } else if (age >= 11 && age <= 13) {
            defaultCategory = "46"; // Ortaokul
        } else if (age >= 14 && age <= 17) {
            defaultCategory = "47"; // Lise
        }

        $('select[name="category_id"]').val(defaultCategory).trigger('change.select2').change();
    }
    $('select[name="day"], select[name="month"], select[name="year"]').on('change', updatePredictedCategory);

    // 5. Ülke Değişimine Göre İl/İlçe/Okul Alanı Yönetimi
    $('#country').change(function() {
        let country = $(this).val();
        const cityArea = $('#city-county-area');
        const schoolArea = $('#school_area');
        const city = $('select[name="city_id"]');
        const county = $('select[name="county_id"]');
        const school = $('select[name="school_id"]');

        if (country != "225") {
            cityArea.hide();
            schoolArea.hide();
            city.removeAttr('required').val('').trigger('change.select2');
            county.removeAttr('required').val('').trigger('change.select2');
            school.removeAttr('required').val('').trigger('change.select2');
        } else {
            cityArea.show();
            city.attr('required', true);
            county.attr('required', true);
            $('select[name="category_id"]').change();
        }
    });

    // 6. Kategori & İlahiyat & Okul Zorunluluğu
    $('select[name="category_id"]').change(function() {
        var val = $(this).val();
        var country = $('#country').val();
        
        if (val == "50") {
            $('#studentControl').removeClass("d-none");
        } else {
            $('#studentControl').addClass("d-none");
            $('#rgs-student-approval').prop('checked', false);
        }

        if (country == "225" && (val === "45" || val === "46" || val === "47" || $('#rgs-student-approval').is(':checked'))) {
            $('#school_area').show();
            $('select[name="school_id"]').attr('required', true);
        } else {
            $('#school_area').hide();
            $('select[name="school_id"]').removeAttr('required').val('').trigger('change.select2');
        }
    });

    $('#rgs-student-approval').change(function() {
        $('select[name="category_id"]').change();
    });

    // 7. İl Seçildiğinde İlçelerin Getirilmesi
    $('select[name="city_id"]').change(function() {
        const cityId = $(this).val();
        const countySelect = $('select[name="county_id"]');
        countySelect.html('<option value="">İlçe Seçiniz</option>');
        $('select[name="school_id"]').html('<option value="">Okul Seçiniz</option>').trigger('change.select2');

        if (cityId) {
            $.get("<?= base_url('kayit/get-counties') ?>/" + cityId, function(data) {
                $.each(data, function(index, value) {
                    countySelect.append(`<option value="${value.id}">${value.name}</option>`);
                });
                countySelect.trigger('change.select2');
            }, 'json');
        } else {
            countySelect.trigger('change.select2');
        }
    });

    // 8. İlçe veya Kategori Değiştiğinde Okulların Getirilmesi
    $('select[name="county_id"], select[name="category_id"]').change(function() {
        const countyId = $('select[name="county_id"]').val();
        const categoryId = $('select[name="category_id"]').val();
        const schoolSelect = $('select[name="school_id"]');
        schoolSelect.html('<option value="">Okul Seçiniz</option>');

        if (countyId && categoryId) {
            $.get("<?= base_url('kayit/get-schools') ?>/" + countyId + "/" + categoryId, function(data) {
                $.each(data, function(index, value) {
                    schoolSelect.append(`<option value="${value.id}">${value.name}</option>`);
                });
                schoolSelect.trigger('change.select2');
            }, 'json');
        } else {
            schoolSelect.trigger('change.select2');
        }
    });

    // 9. Takım Lideri Kodu Sorgulama & Silme
    $('#checkLeaderBtn').click(function() {
        const leaderCode = $("#leaderCode").val().trim();
        const messageBox = $("#leaderMessage");
        if (!leaderCode) {
            messageBox.text("Lütfen takım lideri kodunu giriniz.").css("color", "#ef4444");
            return;
        }
        messageBox.text("Sorgulanıyor...").css("color", "#64748b");

        $.post("<?= base_url('kayit/check-leader') ?>", { 
            leaderCode: leaderCode,
            "<?= csrf_token() ?>": $("#csrf-token-field").val()
        }, function(res) {
            if (res.status === 1) {
                $("#leaderId").val(res.id);
                messageBox.html(`<i class="bi bi-check-circle-fill me-1"></i> ${res.message}`).css("color", "#10b981");
                $("#removeLeaderBtn").show();
            } else {
                $("#leaderId").val(0);
                messageBox.html(`<i class="bi bi-x-circle-fill me-1"></i> ${res.message}`).css("color", "#ef4444");
                $("#removeLeaderBtn").hide();
            }
        }, 'json').fail(function() {
            messageBox.text("Lider sorgulanırken bir hata oluştu.").css("color", "#ef4444");
        });
    });

    $('#removeLeaderBtn').click(function() {
        $("#leaderCode").val("");
        $("#leaderId").val(0);
        $("#leaderMessage").text("").hide();
        $(this).hide();
    });

    // 10. İleri Butonları ve Adım Geçiş Validasyonları (checkPreRegister Dahil)
    $('.rgs-next-btn').click(function(e) {
        e.preventDefault();
        const currentSection = $(this).closest('.rgs-form-section');
        const nextSectionId = $(this).data('next');
        let isValid = true;

        if (nextSectionId == 2) {
            const mobile = $('input[name="mobile"]').val().trim();
            const day = $('select[name="day"]').val();
            const month = $('select[name="month"]').val();
            const year = $('select[name="year"]').val();

            if (!day || !month || !year || !mobile) {
                alert("Lütfen doğum tarihinizi ve telefon numaranızı eksiksiz giriniz.");
                return false;
            }

            if (!validatePhone(mobile)) {
                alert("Lütfen geçerli bir telefon numarası giriniz (Örn: 5551234567).");
                $('input[name="mobile"]').addClass('is-invalid');
                return false;
            }

            // checkPreRegister AJAX çağrısı (senkron)
            $.ajax({
                url: "<?= base_url('kayit/check-pre-register') ?>",
                type: "POST",
                data: {
                    mobile: mobile,
                    birth_date: `${year}-${month}-${day}`,
                    "<?= csrf_token() ?>": $("#csrf-token-field").val()
                },
                async: false,
                dataType: 'json',
                success: function(response) {
                    if (response.is_registered) {
                        alert(response.message || "Bu bilgilerle kayıt mevcut olduğu için yeniden kayıt işlemi yapamazsınız. Hesabınıza giriş yapabilirsiniz.");
                        isValid = false;
                    } else if (response.status == 0) {
                        alert(response.message || "Lütfen tüm bilgileri doldurunuz.");
                        isValid = false;
                    }
                },
                error: function() {
                    alert("Ön kayıt kontrolünde bir hata oluştu. Lütfen tekrar deneyin.");
                    isValid = false;
                }
            });
        }

        if (!isValid) return false;

        // Zorunlu alan kontrolü
        currentSection.find('input[required], select[required]').each(function() {
            const value = $(this).val();
            if ($(this).is('select') && !value) {
                $(this).addClass('is-invalid');
                $(this).next('.select2-container').find('.select2-selection').addClass('is-invalid');
                isValid = false;
            } else if (!value) {
                $(this).addClass('is-invalid');
                isValid = false;
            } else {
                $(this).removeClass('is-invalid');
                if ($(this).is('select')) {
                    $(this).next('.select2-container').find('.select2-selection').removeClass('is-invalid');
                }
            }
        });

        if (isValid) {
            if (nextSectionId == 3) fillReviewSection();

            $(`.rgs-progress-step[data-step="${nextSectionId}"]`)
                .addClass('rgs-active')
                .prevAll().addClass('rgs-completed').removeClass('rgs-active');

            currentSection.removeClass('rgs-active');
            $(`#rgs-section-${nextSectionId}`).addClass('rgs-active');

            // Select2 genişliklerinin zıplamasını engelle
            $('select[data-control="select2"]').each(function() {
                $(this).next('.select2-container').css('width', '100%');
            });

            window.scrollTo({ top: 300, behavior: 'smooth' });
        }
    });

    // 11. Geri Butonları
    $('.rgs-prev-btn').click(function() {
        const currentSection = $(this).closest('.rgs-form-section');
        const prevSectionId = $(this).data('prev');

        $(`.rgs-progress-step[data-step="${currentSection.attr('id').split('-')[2]}"]`).removeClass('rgs-active');
        $(`.rgs-progress-step[data-step="${prevSectionId}"]`).addClass('rgs-active').nextAll().removeClass('rgs-active rgs-completed');

        currentSection.removeClass('rgs-active');
        $(`#rgs-section-${prevSectionId}`).addClass('rgs-active');

        // Select2 genişliklerinin zıplamasını engelle
        $('select[data-control="select2"]').each(function() {
            $(this).next('.select2-container').css('width', '100%');
        });

        window.scrollTo({ top: 300, behavior: 'smooth' });
    });

    // 12. Özet Kartını Doldurma Fonksiyonu
    function fillReviewSection() {
        $('#rgs-review-name').text($('input[name="name"]').val() + ' ' + $('input[name="surname"]').val());
        $('#rgs-review-phone').text($('input[name="mobile"]').val());
        $('#rgs-review-gender').text($('select[name="gender_id"] option:selected').text());
        $('#rgs-review-category').text($('select[name="category_id"] option:selected').text());
        $('#rgs-review-country').text($('select[name="country_id"] option:selected').text());

        const day = $('select[name="day"]').val();
        const month = $('select[name="month"]').val();
        const year = $('select[name="year"]').val();
        $('#rgs-review-birth').text(`${day}.${month}.${year}`);

        if ($('select[name="city_id"]').val() != "") {
            const cityText = $('select[name="city_id"] option:selected').text();
            const countyText = $('select[name="county_id"] option:selected').text();
            $('#rgs-review-location').text(cityText + ' - ' + countyText);
            $('#rgs-review-location-wrapper').show();
        } else {
            $('#rgs-review-location-wrapper').hide();
        }

        if ($('select[name="school_id"]').val()) {
            $('#rgs-review-school').text($('select[name="school_id"] option:selected').text());
            $('#rgs-review-school-wrapper').show();
        } else {
            $('#rgs-review-school-wrapper').hide();
        }

        // Yaş & Kategori Uyum Kontrolü
        $('#category-warning').remove();
        if (day && month && year) {
            const birthDate = new Date(`${year}-${month}-${day}`);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) age--;

            const selectedCategory = $('select[name="category_id"]').val();
            let expectedCategories = [];
            if (age <= 10) expectedCategories = ["45"];
            else if (age >= 11 && age <= 13) expectedCategories = ["46"];
            else if (age >= 14 && age <= 17) expectedCategories = ["47"];
            else expectedCategories = ["48", "50"];

            if (!expectedCategories.includes(selectedCategory)) {
                $('#rgs-review-category').parent().append(
                    `<div id="category-warning" class="text-danger fw-bold mt-1 small">
                        ⚠️ Yaşınıza göre seçtiğiniz kategoriyi kontrol ediniz. Doğru ise kaydı tamamlayabilirsiniz.
                    </div>`
                );
            }
        }
    }

    // 13. Form Submit (ajaxRegister)
    $('#rgs_account_form').submit(function(e) {
        e.preventDefault();
        if (!$('#rgs-kvkk-approval').is(':checked')) {
            alert("Lütfen KVKK Aydınlatma Metni ve Yarışma Şartnamesi'ni onaylayınız.");
            $('#rgs-kvkk-approval').addClass('is-invalid');
            return false;
        }

        $('.submitButton').attr('disabled', true).html('Kaydediliyor... <span class="spinner-border spinner-border-sm ms-2"></span>');

        $.post("<?= base_url('kayit/ajax-register') ?>", $(this).serialize(), function(data) {
            if (data.status === 1) {
                $('.rgs-progress-step').removeClass('rgs-active').addClass('rgs-completed');
                $('.rgs-form-section').removeClass('rgs-active');
                $('#rgs-section-4').addClass('rgs-active');

                if (data.certificate) {
                    $('#certificateImg').attr("src", data.certificate);
                    $('#btnDownload').off('click').on('click', function() {
                        const link = document.createElement('a');
                        link.href = data.certificate;
                        link.download = 'sertifikam.webp';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    });
                }

                if (data.uniq_id) {
                    $('#examLink').attr('href', 'https://minideneme.ufkayolculuk.com/api/login.php?uniq_id=' + data.uniq_id);
                    $.get("<?= base_url('kayit/register-done') ?>/" + data.uniq_id);
                }

                if (data.is_leader == 1) {
                    $('#wantLeaderArea').hide();
                } else {
                    $('#wantLeaderArea').show();
                }

                window.scrollTo({ top: 200, behavior: 'smooth' });
            } else {
                alert(data.message || 'Kayıt sırasında bir hata oluştu.');
                $('.submitButton').attr('disabled', false).html('<span>Kaydı Tamamla</span> <i class="bi bi-check-circle ms-2"></i>');
            }
        }, 'json').fail(function() {
            alert('Sunucu ile iletişim kurulamadı. Lütfen internet bağlantınızı kontrol edip tekrar deneyiniz.');
            $('.submitButton').attr('disabled', false).html('<span>Kaydı Tamamla</span> <i class="bi bi-check-circle ms-2"></i>');
        });
    });
});
</script>
<?= $this->endSection() ?>
