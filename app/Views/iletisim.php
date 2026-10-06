<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
  <!-- ==========================================
       BREADCRUMB & HERO BANNER
       ========================================== -->
  <section class="page-hero-banner">
    <div class="container">
      <!-- Breadcrumb -->
      <nav class="breadcrumb-custom" aria-label="Sayfa Yolu">
        <a href="<?= base_url('/') ?>">Ana Sayfa</a>
        <span class="separator">/</span>
        <span class="current">İletişim</span>
      </nav>

      <!-- Başlık ve Açıklama -->
      <h1 class="page-hero-title">İletişim & İl Temsilcilikleri</h1>
      <p class="page-hero-lead">
        Yarışma başvuruları, kitap temini veya bulunduğunuz ildeki temsilciliklerimizle irtibata geçmek için bize kolayca ulaşabilirsiniz.
      </p>

      <!-- Meta Bilgileri -->
      <div class="page-hero-meta">
        <div class="page-hero-meta-item">
          <span>📞</span>
          <span>Çağrı Merkezi: 0850 888 00 88</span>
        </div>
        <div class="page-hero-meta-item">
          <span>📍</span>
          <span>81 İl Temsilciliği Aktif</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================
       İLETİŞİM ANA BÖLÜMÜ
       ========================================== -->
  <section class="contact-section">
    <div class="container">

      <!-- 1. Hızlı İletişim Bilgi Kartları (4 Kolon) -->
      <div class="contact-info-grid">
        
        <!-- Telefon -->
        <a href="tel:08508880088" class="contact-info-card">
          <div class="contact-icon-wrapper">📞</div>
          <div>
            <div class="contact-card-title">Çağrı Merkezi</div>
            <div class="contact-card-value">0850 888 00 88</div>
            <p class="contact-card-sub">Hafta içi 09:00 - 18:00</p>
          </div>
        </a>

        <!-- WhatsApp -->
        <a href="https://wa.me/908508880088" target="_blank" rel="noopener" class="contact-info-card">
          <div class="contact-icon-wrapper">💬</div>
          <div>
            <div class="contact-card-title">WhatsApp Destek</div>
            <div class="contact-card-value">0850 888 00 88</div>
            <p class="contact-card-sub">Canlı mesajlaşma hattı</p>
          </div>
        </a>

        <!-- E-Posta -->
        <a href="mailto:bilgi@ufkayolculuk.com" class="contact-info-card">
          <div class="contact-icon-wrapper">✉️</div>
          <div>
            <div class="contact-card-title">E-Posta Adresi</div>
            <div class="contact-card-value">bilgi@ufkayolculuk.com</div>
            <p class="contact-card-sub">Ortalama 24 saatte yanıt</p>
          </div>
        </a>

        <!-- Genel Merkez -->
        <div class="contact-info-card">
          <div class="contact-icon-wrapper">🏢</div>
          <div>
            <div class="contact-card-title">Genel Merkez</div>
            <div class="contact-card-value">Server Yaşam Vakfı</div>
            <p class="contact-card-sub">Üsküdar, İstanbul / Türkiye</p>
          </div>
        </div>

      </div>

      <!-- 2. İletişim Formu ve İl Temsilcilikleri Seçimi (2 Kolon) -->
      <div class="row g-4">
        
        <!-- SOL KOLON: İletişim Formu -->
        <div class="col-lg-6">
          <div class="contact-form-card">
            <h2 class="form-header-title">Bize Mesaj Gönderin</h2>
            <p class="text-muted small mb-4">
              Görüş, öneri veya sorularınızı aşağıdaki form aracılığıyla bize iletebilirsiniz. Ekibimiz en kısa sürede dönüş sağlayacaktır.
            </p>

            <!-- AJAX Geri Bildirim Kutusu -->
            <div id="contactAlertBox" class="mb-3 d-none"></div>

            <form id="contactForm" action="<?= base_url('iletisim/gonder') ?>" method="POST" novalidate>
              <?= csrf_field() ?>
              <div class="row g-3">
                
                <!-- Ad Soyad -->
                <div class="col-md-6">
                  <label for="contactName" class="form-label fw-bold text-dark small mb-1">
                    Adınız Soyadınız <span class="text-danger">*</span>
                  </label>
                  <input type="text" name="name" class="form-control form-control-custom ps-3" id="contactName" placeholder="Adınız Soyadınız" required>
                </div>

                <!-- E-Posta -->
                <div class="col-md-6">
                  <label for="contactEmail" class="form-label fw-bold text-dark small mb-1">
                    E-Posta Adresiniz <span class="text-danger">*</span>
                  </label>
                  <input type="email" name="email" class="form-control form-control-custom ps-3" id="contactEmail" placeholder="ornek@domain.com" required>
                </div>

                <!-- Telefon -->
                <div class="col-md-6">
                  <label for="contactPhone" class="form-label fw-bold text-dark small mb-1">
                    Telefon Numaranız <span class="text-danger">*</span>
                  </label>
                  <input type="tel" name="phone" class="form-control form-control-custom ps-3" id="contactPhone" placeholder="0 (5XX) XXX XX XX" required>
                </div>

                <!-- Konu -->
                <div class="col-md-6">
                  <label for="contactSubject" class="form-label fw-bold text-dark small mb-1">
                    Mesaj Konusu <span class="text-danger">*</span>
                  </label>
                  <select name="subject" class="form-select form-control-custom ps-3" id="contactSubject" required>
                    <option value="" selected disabled>Konu seçiniz...</option>
                    <option value="kayit">Sınav ve Kayıt Süreçleri</option>
                    <option value="kitap">Yarışma Kitapları ve Temin</option>
                    <option value="lider">Takım Liderliği & Danışmanlık</option>
                    <option value="odul">Ödüller ve Dereceler</option>
                    <option value="diger">Diğer / Genel Soru</option>
                  </select>
                </div>

                <!-- Mesaj -->
                <div class="col-12">
                  <label for="contactMessage" class="form-label fw-bold text-dark small mb-1">
                    Mesajınız <span class="text-danger">*</span>
                  </label>
                  <textarea name="message" class="form-control form-control-custom ps-3" id="contactMessage" rows="4" placeholder="Mesajınızı buraya yazınız..." required></textarea>
                </div>

                <!-- Gönder Butonu -->
                <div class="col-12 mt-4">
                  <button type="submit" class="btn-yellow w-100 justify-content-center py-2 fs-6 fw-bold" id="btnContactSubmit">
                    <span>Mesajı Gönder</span>
                    <span>→</span>
                  </button>
                </div>

              </div>
            </form>
          </div>
        </div>

        <!-- SAĞ KOLON: İl Temsilcilikleri Dinamik Seçim Alanı -->
        <div class="col-lg-6">
          <div class="rep-selector-card">
            
            <div class="d-flex align-items-center gap-2 mb-2">
              <span class="fs-4">📍</span>
              <h2 class="form-header-title mb-0">İl Temsilciliklerimiz</h2>
            </div>
            
            <p class="text-muted small mb-3">
              Yarışma hakkında yüz yüze bilgi almak, kitap temin etmek veya yerel etkinliklere katılmak için bulunduğunuz ili seçiniz:
            </p>

            <!-- İl ve İlçe Seçim Grubu -->
            <div class="row g-2 mb-3">
              <div class="col-sm-6">
                <label for="citySelect" class="form-label fw-bold text-dark small mb-1">
                  1. İl Seçiniz:
                </label>
                <select class="form-select rep-select-box" id="citySelect" aria-label="İl Seçiniz">
                  <?php foreach (($cities ?? []) as $city): ?>
                    <option value="<?= esc($city) ?>" <?= ($selectedCity ?? 'Konya') === $city ? 'selected' : '' ?>>
                      <?= esc($city) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-sm-6">
                <label for="districtSelect" class="form-label fw-bold text-dark small mb-1">
                  2. İlçe Seçiniz:
                </label>
                <select class="form-select rep-select-box" id="districtSelect" aria-label="İlçe Seçiniz">
                  <option value="__ALL__" selected>Tüm İl (İl Temsilciliği)</option>
                </select>
              </div>
            </div>

            <!-- Popüler / Hızlı İlçe Butonları -->
            <div class="district-quick-chips mb-2" id="districtQuickChips"></div>

            <!-- DİNAMİK TEMSİLCİ BİLGİ KUTUSU (İstenen Format) -->
            <div class="rep-result-box" id="repResultBox">
              <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-1">
                <span class="badge bg-primary text-white" id="repCityBadge">KONYA İL TEMSİLCİLİĞİ</span>
                <span class="badge bg-light text-secondary border small" id="repLevelBadge">Yetkili İl Temsilcisi</span>
              </div>
              
              <!-- İstenen Format: Kişi Adı, Kulüp Adı, Telefon -->
              <h3 class="rep-person-name" id="repPersonName">Osman ERDEM</h3>
              <p class="rep-club-name" id="repClubName">Şehristan Gençlik Spor ve İzcilik Kulübü</p>
              
              <div class="rep-phone-line">
                <span>Telefon:</span>
                <span id="repPhoneText">0535 595 40 60</span>
              </div>

              <!-- Hızlı Arama & WhatsApp Butonları -->
              <div class="rep-action-buttons">
                <a href="tel:05355954060" class="rep-action-btn call" id="repCallBtn">
                  <span>📞</span> <span>Hemen Ara</span>
                </a>
                <a href="https://wa.me/905355954060" target="_blank" rel="noopener" class="rep-action-btn whatsapp" id="repWaBtn">
                  <span>💬</span> <span>WhatsApp İle Yaz</span>
                </a>
              </div>
            </div>

            <div class="mt-auto pt-3 text-center">
              <small class="text-muted">
                İlinizde temsilcilik bulamadıysanız genel merkezimizle doğrudan irtibata geçebilirsiniz.
              </small>
            </div>

          </div>
        </div>

      </div>

      <!-- 3. Sosyal Medya İletişim Barı -->
      <div class="contact-social-bar">
        <div>
          <h3 class="fs-6 fw-bold text-dark mb-1">Sosyal Medyada Ufka Yolculuk</h3>
          <p class="small text-muted mb-0">Yarışma paylaşımları, duyurular ve canlı yayınlar için bizi takip edin:</p>
        </div>

        <div class="social-pills-group">
          <a href="https://wa.me/908508880088" target="_blank" rel="noopener" class="social-pill-link whatsapp">
            <span>💬 WhatsApp</span>
          </a>
          <a href="https://instagram.com" target="_blank" rel="noopener" class="social-pill-link instagram">
            <span>📸 Instagram</span>
          </a>
          <a href="https://twitter.com" target="_blank" rel="noopener" class="social-pill-link twitter">
            <span>𝕏 Twitter</span>
          </a>
          <a href="https://youtube.com" target="_blank" rel="noopener" class="social-pill-link youtube">
            <span>▶️ YouTube</span>
          </a>
          <a href="https://facebook.com" target="_blank" rel="noopener" class="social-pill-link facebook">
            <span>Facebook</span>
          </a>
        </div>
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
          <p class="mb-0">Temsilcilikler, iletişim kanalları, kitaplar veya sınav takvimi hakkında aklınıza takılan soruları yanıtlayabilirim.</p>
        </div>
      </div>

      <div class="ufyo-quick-chips" id="ufyoQuickChips">
        <span class="chips-title">Örnek Sorular:</span>
        <div class="d-flex flex-wrap gap-1 mt-1">
          <button type="button" class="ufyo-chip-btn" data-question="Sınav tarihi ve yarışma takvimi ne zaman?">📅 Sınav Ne Zaman?</button>
          <button type="button" class="ufyo-chip-btn" data-question="Kategorime ait yarışma kitabını nasıl temin ederim?">📚 Kitap Temini</button>
          <button type="button" class="ufyo-chip-btn" data-question="Yarışmada hangi ödüller verilecek?">🏆 Ödüller Nelerdir?</button>
          <button type="button" class="ufyo-chip-btn" data-question="Oyunlar ve Online Soru Çöz sistemine nasıl ulaşırım?">🎯 Oyun & Soru Portalı</button>
        </div>
      </div>
    </div>

    <div class="ufyo-chat-footer">
      <form id="ufyoChatForm" class="d-flex align-items-center gap-2 m-0">
        <input type="text" class="ufyo-input" id="ufyoInput" placeholder="Ufyo'ya bir soru sorun..." autocomplete="off" required>
        <button type="submit" class="btn-ufyo-send" id="ufyoSendBtn" aria-label="Mesaj Gönder">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
          </svg>
        </button>
      </form>
    </div>
  </div>

<?= $this->endSection() ?>
