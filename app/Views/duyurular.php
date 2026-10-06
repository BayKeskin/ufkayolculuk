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
        <span class="current">Duyurular ve Haberler</span>
      </nav>

      <!-- Başlık ve Açıklama -->
      <h1 class="page-hero-title">Duyurular & Haberler</h1>
      <p class="text-white-50 fs-6 mb-0 mt-2">
        Ufka Yolculuk yarışma süreci, sınav kuralları, sonuçlar ve tüm güncel gelişmeler.
      </p>
    </div>
  </section>

  <!-- ==========================================
       DUYURU & HABER LİSTELEME BÖLÜMÜ
       ========================================== -->
  <section class="news-listing-section py-5">
    <div class="container">

      <!-- Filtreleme ve Arama Çubuğu -->
      <div class="listing-filter-bar mb-4">
        <!-- Kategori Filtre Butonları -->
        <div class="filter-pills-group" id="filterPills">
          <button type="button" class="filter-tab-btn active" data-filter="all">
            Tümü (<?= $counts['total'] ?? 0 ?>)
          </button>
          <button type="button" class="filter-tab-btn" data-filter="duyuru">
            📢 Duyurular (<?= $counts['duyuru'] ?? 0 ?>)
          </button>
          <button type="button" class="filter-tab-btn" data-filter="haber">
            📰 Haberler (<?= $counts['haber'] ?? 0 ?>)
          </button>
          <?php if (($counts['etkinlik'] ?? 0) > 0): ?>
          <button type="button" class="filter-tab-btn" data-filter="etkinlik">
            🌟 Etkinlikler (<?= $counts['etkinlik'] ?? 0 ?>)
          </button>
          <?php endif; ?>
        </div>

        <!-- Arama Kutusu -->
        <div class="listing-search-input">
          <span class="listing-search-icon">🔍</span>
          <input type="text" class="form-control" id="newsSearchInput" placeholder="Duyuru veya haber ara...">
        </div>
      </div>

      <!-- Galeri Kartları Grid Düzeni (3 Kolon) -->
      <div class="news-grid" id="newsGridContainer">

        <?php if (!empty($announcements)): ?>
          <?php foreach ($announcements as $announcement): 
              $title    = $announcement['title'] ?? 'Duyuru';
              $slug     = $announcement['slug'] ?? '';
              $type     = strtolower($announcement['type'] ?? 'duyuru');
              $catTitle = $announcement['category_title'] ?? $announcement['primary_category']['title'] ?? 'Ufka Yolculuk';
              
              // Kategori Filtre Değeri
              if ($type === 'news' || str_contains($type, 'haber')) {
                  $filterCat   = 'haber';
                  $badgeClass  = 'haber';
                  $badgeText   = 'HABER';
              } elseif ($type === 'event' || str_contains($type, 'etkinlik')) {
                  $filterCat   = 'etkinlik';
                  $badgeClass  = 'etkinlik';
                  $badgeText   = 'ETKİNLİK';
              } else {
                  $filterCat   = 'duyuru';
                  $badgeClass  = '';
                  $badgeText   = 'DUYURU';
              }

              // Görsel Seçimi: Kendi resmi -> Kategori resmi -> Varsayılan yedek
              $rawImage = $announcement['image'] ?? $announcement['primary_category']['image'] ?? null;
              if ($rawImage) {
                  $imageUrl = $api->getMediaUrl($rawImage);
              } else {
                  $imageUrl = base_url('assets/images/duyuru-1.webp');
              }

              // Özet Metni
              $body = $announcement['body'] ?? '';
              $desc = $announcement['description'] ?? '';
              $cleanText = !empty($desc) ? $desc : strip_tags($body);
              $cleanText = html_entity_decode($cleanText, ENT_QUOTES, 'UTF-8');
              $cleanText = preg_replace('/\s+/', ' ', trim($cleanText));
              $excerpt   = mb_strlen($cleanText) > 130 ? mb_substr($cleanText, 0, 130) . '...' : $cleanText;
              if (empty($excerpt)) {
                  $excerpt = 'Ufka Yolculuk güncel duyuru ve bilgilendirme detayları için tıklayınız.';
              }

              // Tarih
              $dateStr = !empty($announcement['publish_time']) ? date('d.m.Y', strtotime($announcement['publish_time'])) : 'Güncel';
              
              // Detay linki
              $detailUrl = base_url('sayfa/' . ($slug ?: $announcement['id']));
          ?>
          <article class="news-card" data-category="<?= esc($filterCat) ?>" data-title="<?= esc(mb_strtolower($title, 'UTF-8')) ?>" data-excerpt="<?= esc(mb_strtolower($excerpt, 'UTF-8')) ?>">
            <div class="news-card-img-wrapper">
              <img src="<?= esc($imageUrl) ?>" alt="<?= esc($title) ?>" class="news-card-img" onerror="this.src='<?= base_url('assets/images/duyuru-1.webp') ?>'">
              <span class="news-badge <?= $badgeClass ?>"><?= $badgeText ?></span>
            </div>
            <div class="news-card-body">
              <div class="news-meta">
                <span>📅 <?= esc($dateStr) ?></span>
                <span>•</span>
                <span>🏷️ <?= esc($catTitle) ?></span>
              </div>
              <h3 class="news-title"><?= esc($title) ?></h3>
              <p class="news-excerpt">
                <?= esc($excerpt) ?>
              </p>
              <div class="news-card-footer">
                <a href="<?= esc($detailUrl) ?>" class="news-read-more">
                  <span>Detayları Oku</span>
                  <span>→</span>
                </a>
              </div>
            </div>
          </article>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-12 text-center py-5">
            <div class="p-4 bg-light rounded-4 border">
              <p class="text-muted fs-5 mb-0">Henüz yayınlanmış duyuru bulunamadı.</p>
            </div>
          </div>
        <?php endif; ?>

      </div>

      <!-- Sonuç Bulunamadı Mesajı (Arama/Filtreleme esnasında) -->
      <div id="noResultsMsg" class="text-center py-5 d-none">
        <div class="p-4 bg-light rounded-4 border max-w-md mx-auto">
          <span class="fs-1 d-block mb-2">🔍</span>
          <h5 class="fw-bold text-dark">Aramanıza Uygun Duyuru Bulunamadı</h5>
          <p class="text-muted small mb-0">Lütfen farklı bir anahtar kelime ile tekrar deneyiniz.</p>
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
    <img src="<?= base_url('assets/images/icon6.png') ?>" alt="AI Destek Robotu" class="bot-mascot-img" width="76" height="76">
  </aside>

  <!-- Ufyo AI Canlı Sohbet Penceresi -->
  <div class="ufyo-chat-panel" id="ufyoChatPanel" role="dialog" aria-labelledby="ufyoChatTitle" aria-hidden="true">
    <div class="ufyo-chat-header">
      <div class="d-flex align-items-center gap-2">
        <div class="ufyo-avatar-ring">
          <img src="<?= base_url('assets/images/icon6.png') ?>" alt="Ufyo" width="34" height="34">
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
          <img src="<?= base_url('assets/images/icon6.png') ?>" alt="Ufyo">
        </div>
        <div class="chat-msg-content">
          <p class="mb-1">Merhaba! Ben Ufka Yolculuk yapay zeka rehberiniz <strong>Ufyo</strong> 🤖</p>
          <p class="mb-0">Duyurular, sınav takvimi, kitaplar veya ödüller hakkında merak ettiğiniz her şeyi bana sorabilirsiniz.</p>
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

<?= $this->section('scripts') ?>
<script>
  // Canlı Filtreleme ve Arama Mekanizması
  document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('newsSearchInput');
    const filterButtons = document.querySelectorAll('#filterPills .filter-tab-btn');
    const cards = document.querySelectorAll('#newsGridContainer .news-card');
    const noResultsMsg = document.getElementById('noResultsMsg');

    let activeFilter = 'all';

    function applyFilterAndSearch() {
      const query = (searchInput ? searchInput.value.toLowerCase().trim() : '');
      let visibleCount = 0;

      cards.forEach(card => {
        const category = card.getAttribute('data-category') || '';
        const title = card.getAttribute('data-title') || '';
        const excerpt = card.getAttribute('data-excerpt') || '';

        const matchesFilter = (activeFilter === 'all' || category === activeFilter);
        const matchesQuery = (!query || title.includes(query) || excerpt.includes(query));

        if (matchesFilter && matchesQuery) {
          card.style.display = '';
          visibleCount++;
        } else {
          card.style.display = 'none';
        }
      });

      if (noResultsMsg) {
        if (visibleCount === 0 && cards.length > 0) {
          noResultsMsg.classList.remove('d-none');
        } else {
          noResultsMsg.classList.add('d-none');
        }
      }
    }

    filterButtons.forEach(btn => {
      btn.addEventListener('click', function () {
        filterButtons.forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        activeFilter = this.getAttribute('data-filter') || 'all';
        applyFilterAndSearch();
      });
    });

    if (searchInput) {
      searchInput.addEventListener('input', applyFilterAndSearch);
    }
  });
</script>
<?= $this->endSection() ?>
