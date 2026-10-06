<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
       HERO BANNER & BREADCRUMB (Koyu Arka Plan)
       ========================================== -->
  <section class="awards-hero-banner" style="background-color: #0F3460 !important; background: linear-gradient(135deg, #0A192F 0%, #0F3460 50%, #16213E 100%) !important;">
    <div class="container">
      <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0" style="font-size: 0.875rem;">
          <li class="breadcrumb-item"><a href="<?= base_url('/') ?>" class="text-white-50 text-decoration-none">Ana Sayfa</a></li>
          <li class="breadcrumb-item text-warning fw-bold active" aria-current="page">Ödüller</li>
        </ol>
      </nav>
      <div class="row align-items-center">
        <div class="col-lg-8">
          <h1 class="display-6 fw-bold text-white mb-2 font-heading">
            🏆 Yarışma Ödülleri
          </h1>
          <p class="text-white-50 fs-6 mb-0">
            Türkiye Geneli ödüller sabit görünür. İl, ilçe ve okul ödülleri seçim yapıldığında listelenir.
          </p>
        </div>
        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
          <span class="badge bg-warning text-dark px-3 py-2 fs-7 fw-bold rounded-pill shadow-sm">
            🌟 Toplam 5.000.000₺+ Ödül Havuzu
          </span>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================
       ÖDÜL İSTATİSTİK KARTLARI
       ========================================== -->
  <section class="py-4 bg-light border-bottom">
    <div class="container">
      <div class="row g-3">
        <div class="col-md-4">
          <div class="award-stat-card shadow-xs">
            <div class="award-stat-icon bg-warning bg-opacity-10 text-warning">
              🕋
            </div>
            <div class="award-stat-val">100+ Umre</div>
            <p class="award-stat-label">Türkiye Geneli Dereceye Giren Öğrenciler ve Liderler</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="award-stat-card shadow-xs">
            <div class="award-stat-icon bg-primary bg-opacity-10 text-primary">
              💰
            </div>
            <div class="award-stat-val">5.000.000₺+</div>
            <p class="award-stat-label">Nakit ve Eğitim Teşvik Bursları Toplamı</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="award-stat-card shadow-xs">
            <div class="award-stat-icon bg-success bg-opacity-10 text-success">
              ⭐
            </div>
            <div class="award-stat-val">81 İl & İlçeler</div>
            <p class="award-stat-label">Her İl ve İlçede Yerel Kulüp ve Temsilcilik Ödülleri</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================
       ÖDÜLLER ANA İÇERİK (GENİŞ BLOKLAR DÜZENİ)
       ========================================== -->
  <section class="py-5">
    <div class="container">

      <!-- ==========================================
           1. BLOK: TÜRKİYE GENELİ ÖDÜLLER (TAM GENİŞLİK)
           ========================================== -->
      <div class="awards-block-card shadow-sm">
        <div class="awards-block-header">
          <div>
            <h2 class="awards-block-title">
              <span>🇹🇷</span> Türkiye Geneli Ödüller
            </h2>
            <p class="awards-block-subtitle">
              Ödülleri görmek istediğiniz kategori sekmesine tıklayınız.
            </p>
          </div>
          <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 fs-7 fw-bold rounded-pill">
            Merkezi Sınav Dereceleri
          </span>
        </div>

        <div class="awards-block-body">
          <!-- 8 Kategori Sekmesi (API Verisi ile Dinamik) -->
          <ul class="nav award-pills-nav" id="nationalAwardsTabs" role="tablist">
            <?php $first = true; foreach ($nationalAwards as $catKey => $cat): ?>
              <li class="nav-item" role="presentation">
                <button class="nav-link <?= $first ? 'active' : '' ?>" id="<?= esc($cat['tab_id']) ?>-tab" data-bs-toggle="pill" data-bs-target="#<?= esc($cat['tab_id']) ?>" type="button" role="tab" aria-selected="<?= $first ? 'true' : 'false' ?>">
                  <?= esc($cat['badge']) ?>
                </button>
              </li>
            <?php $first = false; endforeach; ?>
          </ul>

          <!-- Tab İçerikleri (Podyum Dereceleri & 4-100 Izgarası) -->
          <div class="tab-content" id="nationalAwardsTabContent">
            <?php $first = true; foreach ($nationalAwards as $catKey => $cat): 
                $podium = $cat['podium'];
                $tiles  = $cat['tiles'];
            ?>
              <div class="tab-pane fade <?= $first ? 'show active' : '' ?>" id="<?= esc($cat['tab_id']) ?>" role="tabpanel">
                <!-- Podyum Dereceleri (1., 2., 3.) -->
                <div class="award-podium-row">
                  <!-- 1. Altın -->
                  <div class="award-podium-col">
                    <div class="podium-card gold">
                      <div class="podium-medal-badge bg-warning bg-opacity-25 text-warning">🥇</div>
                      <div class="podium-rank-label text-warning"><?= esc($podium['gold']['rank_title']) ?></div>
                      <div class="podium-prize-val"><?= esc($podium['gold']['prize_val']) ?></div>
                      <p class="podium-prize-desc"><?= esc($podium['gold']['desc']) ?></p>
                    </div>
                  </div>
                  <!-- 2. Gümüş -->
                  <div class="award-podium-col">
                    <div class="podium-card silver">
                      <div class="podium-medal-badge bg-secondary bg-opacity-25 text-secondary">🥈</div>
                      <div class="podium-rank-label text-secondary"><?= esc($podium['silver']['rank_title']) ?></div>
                      <div class="podium-prize-val"><?= esc($podium['silver']['prize_val']) ?></div>
                      <p class="podium-prize-desc"><?= esc($podium['silver']['desc']) ?></p>
                    </div>
                  </div>
                  <!-- 3. Bronz -->
                  <div class="award-podium-col">
                    <div class="podium-card bronze">
                      <div class="podium-medal-badge bg-warning bg-opacity-25" style="color:#D97706;">🥉</div>
                      <div class="podium-rank-label" style="color:#D97706;"><?= esc($podium['bronze']['rank_title']) ?></div>
                      <div class="podium-prize-val"><?= esc($podium['bronze']['prize_val']) ?></div>
                      <p class="podium-prize-desc"><?= esc($podium['bronze']['desc']) ?></p>
                    </div>
                  </div>
                </div>

                <!-- 4. ve Sonrası Sıralama Izgarası (Ferah 4 Sütunlu Fayans Düzeni) -->
                <?php if (!empty($tiles)): ?>
                  <div class="award-tiles-row">
                    <?php foreach ($tiles as $tile): ?>
                      <div class="award-tile-col">
                        <div class="award-rank-tile">
                          <span class="award-rank-tag"><?= esc($tile['tag']) ?></span>
                          <span class="award-rank-money"><?= esc($tile['amount']) ?></span>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
              </div>
            <?php $first = false; endforeach; ?>
          </div>
        </div>
      </div>

      <!-- ==========================================
           2. BLOK: YEREL & İL ÖDÜLLERİ (TAM GENİŞLİK)
           ========================================== -->
      <div class="awards-block-card shadow-sm">
        <div class="awards-block-header">
          <div>
            <h2 class="awards-block-title">
              <span>📍</span> Yerel Ödüller (<span id="localSelectedCityName" class="text-primary"><?= esc($selectedCity) ?></span>)
            </h2>
            <p class="awards-block-subtitle">
              81 İl Temsilcilikleri, Gençlik Kulüpleri ve İlçe Sponsorluk Başarı Ödülleri
            </p>
          </div>
          
          <!-- İl Seçimi Dropdown (81 İl API Listesi ile Dinamik) -->
          <div class="d-flex align-items-center gap-2">
            <label for="awardCitySelect" class="fw-bold fs-7 text-dark text-nowrap d-none d-sm-inline">İl Değiştir:</label>
            <select name="awardCitySelect" id="awardCitySelect" class="form-select award-city-select shadow-xs" aria-label="İl Seçiniz">
              <?php foreach ($cities as $city): ?>
                <option value="<?= esc($city) ?>" <?= ($city === $selectedCity) ? 'selected' : '' ?>><?= esc($city) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="awards-block-body">
          <!-- Kategori Sekmeleri -->
          <ul class="nav award-pills-nav" id="localAwardsTabs" role="tablist">
            <li class="nav-item"><button class="nav-link active" data-category="ilkokul" type="button">🌱 İlkokul</button></li>
            <li class="nav-item"><button class="nav-link" data-category="ortaokul" type="button">📖 Ortaokul</button></li>
            <li class="nav-item"><button class="nav-link" data-category="lise" type="button">📖 Lise</button></li>
            <li class="nav-item"><button class="nav-link" data-category="yetiskin" type="button">🎓 Yetişkin</button></li>
            <li class="nav-item"><button class="nav-link" data-category="ilahiyat" type="button">🕌 İlahiyat</button></li>
            <li class="nav-item"><button class="nav-link" data-category="takim_lideri" type="button">⭐ Takım Lideri</button></li>
          </ul>

          <!-- Dinamik Yerel İçerik Alanı (JS Tarafından Canlı Güncellenir, İlk Yükleme PHP ile Hazır) -->
          <div id="localAwardsDynamicContent">
            <!-- Podyum Dereceleri (1., 2., 3.) -->
            <div class="award-podium-row mb-3">
              <div class="award-podium-col">
                <div class="podium-card gold">
                  <div class="podium-medal-badge bg-warning bg-opacity-25 text-warning">🥇</div>
                  <div class="podium-rank-label text-warning">1. İl Birincisi</div>
                  <div class="podium-prize-val"><?= esc($selectedCityAwards['lead'] ?? 'Yarım Altın / 15.000₺ Değerinde Ödül') ?></div>
                  <p class="podium-prize-desc">Büyük İl Başarı Ödülü</p>
                </div>
              </div>
              <div class="award-podium-col">
                <div class="podium-card silver">
                  <div class="podium-medal-badge bg-secondary bg-opacity-25 text-secondary">🥈</div>
                  <div class="podium-rank-label text-secondary">2. İl İkincisi</div>
                  <div class="podium-prize-val"><?= esc($selectedCityAwards['second'] ?? 'Çeyrek Altın / 10.000₺ Değerinde Ödül') ?></div>
                  <p class="podium-prize-desc">İl Derecesi Ödülü</p>
                </div>
              </div>
              <div class="award-podium-col">
                <div class="podium-card bronze">
                  <div class="podium-medal-badge bg-warning bg-opacity-25" style="color:#D97706;">🥉</div>
                  <div class="podium-rank-label" style="color:#D97706;">3. İl Üçüncüsü</div>
                  <div class="podium-prize-val"><?= esc($selectedCityAwards['third'] ?? 'Gram Altın / 5.000₺ Değerinde Ödül') ?></div>
                  <p class="podium-prize-desc">İl Derecesi Ödülü</p>
                </div>
              </div>
            </div>

            <!-- 4. - 10. Sıralama ve Mansiyon Ödülü -->
            <div class="p-3 bg-light rounded-3 border mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
              <div class="d-flex align-items-center gap-2">
                <span class="badge bg-primary px-3 py-2 fs-7 fw-bold">4. - 10. Sıralama</span>
                <span class="fw-bold text-dark fs-6"><?= esc($selectedCityAwards['honorable'] ?? '2.500₺ Başarı Teşvik Desteği (4. - 10.)') ?></span>
              </div>
              <span class="text-muted fs-7">Mansiyon & Başarı Teşvik Desteği</span>
            </div>

            <!-- İlçe Başarı Ödülleri -->
            <?php if (!empty($selectedCityAwards['districts'])): ?>
              <div class="district-awards-container">
                <h5 class="district-awards-title">
                  <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                  </svg>
                  <span><?= esc($selectedCity) ?> İlçe & Okul Başarı Ödülleri</span>
                </h5>
                <div class="row g-3">
                  <?php foreach ($selectedCityAwards['districts'] as $d): ?>
                    <div class="col-md-6">
                      <div class="district-item-card shadow-xs">
                        <div class="fw-bold text-dark fs-6 mb-1"><?= esc($d['name']) ?></div>
                        <div class="text-primary fw-semibold fs-7"><?= esc($d['awards']) ?></div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif; ?>

            <!-- Bilgilendirme Notu -->
            <div class="award-notes-banner mt-3">
              <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="flex-shrink-0 mt-0.5">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <div>
                <h6 class="fw-bold mb-1">Resmi İl Ödül Töreni Bilgilendirmesi</h6>
                <p class="mb-0 fs-7"><?= esc($selectedCityAwards['notes'] ?? ($selectedCity . ' il ödülleri resmi törende takdim edilecektir.')) ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ==========================================
       ÖDÜL SSS BÖLÜMÜ
       ========================================== -->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="text-center max-w-700 mx-auto mb-4">
        <h3 class="fw-bold font-heading">Ödüller Hakkında Sıkça Sorulan Sorular</h3>
        <p class="text-muted fs-6">Yarışma ödülleri, teslim süreçleri ve Umre takdimi ile ilgili merak edilenler</p>
      </div>

      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="accordion custom-accordion" id="awardsFaqAccordion">
            <?php if (!empty($awardFaqs)): ?>
              <?php foreach ($awardFaqs as $idx => $faq): 
                $collapseId = 'awardFaqCol' . $faq['id'];
                $headingId  = 'awardFaqHead' . $faq['id'];
                $isOpen     = ($idx === 0);
              ?>
                <div class="accordion-item mb-3 border-0 shadow-xs rounded-3 overflow-hidden">
                  <h2 class="accordion-header" id="<?= $headingId ?>">
                    <button class="accordion-button fw-bold <?= $isOpen ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>" aria-expanded="<?= $isOpen ? 'true' : 'false' ?>" aria-controls="<?= $collapseId ?>">
                      🏆 <?= esc($faq['title']) ?>
                    </button>
                  </h2>
                  <div id="<?= $collapseId ?>" class="accordion-collapse collapse <?= $isOpen ? 'show' : '' ?>" aria-labelledby="<?= $headingId ?>" data-bs-parent="#awardsFaqAccordion">
                    <div class="accordion-body text-muted">
                      <?= $faq['body'] ?>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="accordion-item mb-3 border-0 shadow-xs rounded-3 overflow-hidden">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    🕋 Umre ödülü yerine nakit karşılığı alınabilir mi?
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#awardsFaqAccordion">
                  <div class="accordion-body text-muted">
                    Yarışma şartnamesine göre Umre ödülü hak kazanan yarışmacıya doğrudan tur ve konaklama paketi olarak sunulur. Yarışmacının mücbir bir mazereti olması durumunda şartnamede belirtilen eşdeğer nakdi ödül uygulanabilir.
                  </div>
                </div>
              </div>

              <div class="accordion-item mb-3 border-0 shadow-xs rounded-3 overflow-hidden">
                <h2 class="accordion-header" id="headingTwo">
                  <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    🏆 Hem Türkiye geneli hem de İl ödülü aynı anda kazanılabilir mi?
                  </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#awardsFaqAccordion">
                  <div class="accordion-body text-muted">
                    Evet! Bir yarışmacı hem Türkiye geneli dereceye girerek merkezi büyük ödüllerden birini alabilir, hem de kendi ilinde birinci olarak yerel kulüp ve sponsor ödülünü almaya hak kazanır.
                  </div>
                </div>
              </div>

              <div class="accordion-item mb-3 border-0 shadow-xs rounded-3 overflow-hidden">
                <h2 class="accordion-header" id="headingThree">
                  <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    📍 İl ve ilçe ödülleri ne zaman ve nasıl teslim edilir?
                  </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#awardsFaqAccordion">
                  <div class="accordion-body text-muted">
                    Sınav sonuçları açıklandıktan sonra her ildeki Ufka Yolculuk paydaş kulübü ve il temsilciliği tarafından görkemli bir Ödül Takdim Töreni düzenlenir ve ödüller kazananlara bizzat takdim edilir.
                  </div>
                </div>
              </div>
            <?php endif; ?>
          </div>
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
          <p class="mb-0">Ödül kategorileri, derece şartları, kitaplar veya sınav takvimi hakkında merak ettiğiniz tüm soruları yanıtlayabilirim.</p>
        </div>
      </div>

      <div class="ufyo-quick-chips" id="ufyoQuickChips">
        <span class="chips-title">Örnek Sorular:</span>
        <div class="d-flex flex-wrap gap-1 mt-1">
          <button type="button" class="ufyo-chip-btn" data-question="Yarışmada hangi ödüller verilecek?">🏆 Ödüller Nelerdir?</button>
          <button type="button" class="ufyo-chip-btn" data-question="Sınav tarihi ve yarışma takvimi ne zaman?">📅 Sınav Ne Zaman?</button>
          <button type="button" class="ufyo-chip-btn" data-question="Kategorime ait yarışma kitabını nasıl temin ederim?">📚 Kitap Temini</button>
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

<?= $this->section('scripts') ?>
<script>
  window.UFKA_CITY_AWARDS = <?= json_encode($cityAwardsMap ?? [], JSON_UNESCAPED_UNICODE) ?>;
  window.UFKA_INITIAL_CITY = <?= json_encode($selectedCity ?? 'Konya', JSON_UNESCAPED_UNICODE) ?>;
</script>
<?= $this->endSection() ?>
