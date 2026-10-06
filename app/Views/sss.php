<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

  <!-- ==========================================
       SAYFA BAŞLIĞI & BREADCRUMB
       ========================================== -->
  <section class="page-header-section py-5 bg-light position-relative overflow-hidden">
    <div class="container position-relative z-1">
      <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb mb-0 fs-7">
          <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none text-muted">Anasayfa</a></li>
          <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">Sıkça Sorulan Sorular</li>
        </ol>
      </nav>

      <div class="row align-items-center justify-content-between g-4">
        <div class="col-lg-7">
          <span class="badge bg-warning bg-opacity-25 text-dark px-3 py-2 fs-7 fw-bold rounded-pill mb-2">
            ❓ Merak Edilenler & Resmi Rehber
          </span>
          <h1 class="display-5 fw-bold font-heading mb-2 text-dark">Sıkça Sorulan Sorular</h1>
          <p class="text-muted fs-6 mb-3">
            Ufka Yolculuk yarışma takvimi, kayıt şartları, sınav kuralları, kitaplar ve ödüllere dair merak ettiğiniz tüm soruların resmi cevapları.
          </p>
          <div class="d-flex flex-wrap gap-2">
            <span class="badge bg-white text-secondary border px-3 py-2 rounded-pill fs-7 shadow-xs">
              📊 Toplam <strong><?= esc($faqs['total'] ?? 18) ?> Soru</strong>
            </span>
            <span class="badge bg-white text-secondary border px-3 py-2 rounded-pill fs-7 shadow-xs">
              📂 <strong>5 Kategori</strong>
            </span>
            <span class="badge bg-white text-secondary border px-3 py-2 rounded-pill fs-7 shadow-xs">
              🤖 <strong>7/24 AI Destek</strong>
            </span>
          </div>
        </div>

        <div class="col-lg-4 text-lg-end d-none d-lg-block">
          <img src="<?= base_url('assets/images/icon6.png') ?>" alt="Ufyo SSS Rehberi" class="img-fluid" width="130" height="130" style="filter: drop-shadow(0 10px 20px rgba(0,0,0,0.08));">
        </div>
      </div>
    </div>
  </section>

  <!-- ==========================================
       SSS ANA İÇERİK & FİLTRELEME ALANI
       ========================================== -->
  <section class="py-5" id="sssPageContent">
    <div class="container">

      <!-- Arama ve Kategori Filtresi Kartı -->
      <div class="row justify-content-center mb-4">
        <div class="col-lg-10 col-xl-9">
          
          <!-- Canlı Arama Inputu -->
          <div class="faq-search-wrapper mb-3">
            <div class="input-group shadow-xs rounded-pill overflow-hidden bg-white border">
              <span class="input-group-text bg-white border-0 ps-4 text-muted">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
              </span>
              <input type="text" id="faqSearchInput" class="form-control border-0 py-3 ps-2 pe-3 fs-6" placeholder="Sorularda ara... (örn: Umre, sınav tarihi, kitap temini, süre)" autocomplete="off">
              <button class="btn btn-link text-muted pe-4 text-decoration-none d-none" id="faqSearchClear" type="button" title="Temizle">
                ✕
              </button>
            </div>
          </div>

          <!-- Kategori Filtre Butonları -->
          <div class="faq-categories-wrapper d-flex flex-wrap align-items-center justify-content-center gap-2" id="faqCategoryFilterGroup">
            <button type="button" class="btn faq-filter-pill active" data-category="all">
              <span>✨ Tümü</span>
              <span class="badge bg-dark bg-opacity-10 text-dark rounded-pill ms-1"><?= esc($faqs['counts']['all'] ?? count($faqs['items'] ?? [])) ?></span>
            </button>
            <?php foreach (($faqs['categories'] ?? []) as $cKey => $cMeta): ?>
              <button type="button" class="btn faq-filter-pill" data-category="<?= esc($cKey) ?>">
                <span><?= esc($cMeta['icon']) ?> <?= esc($cMeta['name']) ?></span>
                <span class="badge bg-dark bg-opacity-10 text-dark rounded-pill ms-1"><?= esc($faqs['counts'][$cKey] ?? 0) ?></span>
              </button>
            <?php endforeach; ?>
          </div>

        </div>
      </div>

      <!-- Akordeon Sorular Listesi -->
      <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
          
          <div class="accordion custom-faq-accordion" id="faqAccordion">
            <?php if (!empty($faqs['items'])): ?>
              <?php foreach ($faqs['items'] as $index => $item): 
                $collapseId = 'faqCollapse' . $item['id'];
                $headingId  = 'faqHeading' . $item['id'];
                $isOpen     = ($index === 0);
              ?>
                <div class="accordion-item faq-item-card mb-3 border-0 shadow-xs rounded-3 overflow-hidden" 
                     data-faq-category="<?= esc($item['category_key']) ?>"
                     data-faq-title="<?= esc(mb_strtolower($item['title'])) ?>"
                     data-faq-body="<?= esc(mb_strtolower($item['body_clean'])) ?>">
                  <h2 class="accordion-header" id="<?= $headingId ?>">
                    <button class="accordion-button fw-bold <?= $isOpen ? '' : 'collapsed' ?>" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#<?= $collapseId ?>" 
                            aria-expanded="<?= $isOpen ? 'true' : 'false' ?>" 
                            aria-controls="<?= $collapseId ?>">
                      <span class="faq-cat-badge me-2"><?= esc($item['category_icon']) ?></span>
                      <span class="faq-question-text"><?= esc($item['title']) ?></span>
                    </button>
                  </h2>
                  <div id="<?= $collapseId ?>" 
                       class="accordion-collapse collapse <?= $isOpen ? 'show' : '' ?>" 
                       aria-labelledby="<?= $headingId ?>" 
                       data-bs-parent="#faqAccordion">
                    <div class="accordion-body text-secondary lh-lg faq-answer-content">
                      <?= $item['body'] ?>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="alert alert-info py-4 text-center rounded-3">
                <p class="mb-0">Sıkça sorulan sorular yüklenemedi veya henüz yayınlanmadı.</p>
              </div>
            <?php endif; ?>
          </div>

          <!-- Arama Sonucu Bulunamadı Uyarısı -->
          <div id="faqNoResults" class="alert alert-info py-4 text-center d-none rounded-3 shadow-xs">
            <div class="fs-1 mb-2">🔍</div>
            <h5 class="fw-bold mb-1">Aramanıza Uygun Soru Bulunamadı</h5>
            <p class="text-muted fs-7 mb-3">Farklı anahtar kelimelerle arama yapabilir veya sorunuzu doğrudan Ufyo AI asistanımıza yöneltebilirsiniz.</p>
            <button type="button" class="btn btn-sm btn-primary rounded-pill px-4" id="faqAskUfyoBtn">
              🤖 Ufyo'ya Sor
            </button>
          </div>

          <!-- Alt Destek Kartı -->
          <div class="faq-support-card mt-5 p-4 rounded-4 bg-light border d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 shadow-xs">
            <div class="d-flex align-items-center gap-3">
              <div class="support-card-icon rounded-circle bg-warning bg-opacity-25 d-flex align-items-center justify-content-center text-warning fs-3 flex-shrink-0" style="width: 54px; height: 54px;">
                💡
              </div>
              <div>
                <h5 class="fw-bold mb-1">Farklı bir sorunuz veya desteğe mi ihtiyacınız var?</h5>
                <p class="text-muted fs-7 mb-0">Ufyo AI Asistanımız 7/24 yarışma hakkındaki tüm sorularınızı anında yanıtlar veya temsilciliklerimize ulaşabilirsiniz.</p>
              </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap flex-shrink-0">
              <button type="button" class="btn btn-warning fw-bold px-4 py-2 rounded-pill shadow-xs" id="faqOpenAiChatBtn">
                🤖 Ufyo'ya Sor
              </button>
              <a href="<?= base_url('iletisim') ?>" class="btn btn-outline-dark fw-semibold px-4 py-2 rounded-pill">
                📍 Temsilcilikler & İletişim
              </a>
            </div>
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
          <p class="mb-0">Yarışma takvimi, kayıt şartları, kitaplar veya ödüller hakkında merak ettiğiniz her şeyi bana sorabilirsiniz.</p>
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
            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
          </svg>
        </button>
      </form>
    </div>
  </div>

<?= $this->endSection() ?>
