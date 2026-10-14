<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title ?? 'Ufka Yolculuk REST API Test Laboratuvarı') ?></title>
  
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= base_url('assets/images/favicon.png') ?>">
  
  <!-- Bootstrap 5.3 & FontAwesome 6 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Google Fonts: Inter & JetBrains Mono -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    :root {
      --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      --font-mono: 'JetBrains Mono', Consolas, Monaco, monospace;
      --bg-dark: #0f172a;
      --bg-card: #1e293b;
      --bg-light: #f8fafc;
      --border-dark: #334155;
      --accent-primary: #3b82f6;
      --accent-success: #10b981;
      --accent-warning: #f59e0b;
      --accent-danger: #ef4444;
      --accent-purple: #8b5cf6;
    }

    body {
      font-family: var(--font-sans);
      background-color: #0b1120;
      color: #f1f5f9;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    /* Top Navbar */
    .api-header {
      background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
      border-bottom: 1px solid var(--border-dark);
      padding: 0.85rem 1.5rem;
    }

    .brand-badge {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      color: #000;
      font-weight: 800;
      font-size: 0.72rem;
      padding: 0.25rem 0.55rem;
      border-radius: 6px;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }

    /* Main Container & Layout */
    .app-workspace {
      display: flex;
      flex: 1;
      height: calc(100vh - 66px);
      overflow: hidden;
    }

    /* Left Sidebar: Endpoints List */
    .endpoints-sidebar {
      width: 380px;
      min-width: 340px;
      max-width: 420px;
      background-color: #0f172a;
      border-right: 1px solid var(--border-dark);
      display: flex;
      flex-direction: column;
      height: 100%;
    }

    .sidebar-search-box {
      padding: 1rem;
      border-bottom: 1px solid var(--border-dark);
      background-color: rgba(15, 23, 42, 0.8);
    }

    .search-input-dark {
      background-color: #1e293b;
      border: 1px solid var(--border-dark);
      color: #fff;
      font-size: 0.88rem;
      border-radius: 8px;
      padding: 0.55rem 0.85rem;
    }
    .search-input-dark:focus {
      background-color: #1e293b;
      border-color: var(--accent-primary);
      color: #fff;
      box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.25);
    }

    .endpoints-scroll {
      flex: 1;
      overflow-y: auto;
      padding: 0.75rem;
    }

    .endpoint-group-title {
      font-size: 0.75rem;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      color: #94a3b8;
      padding: 0.65rem 0.5rem 0.35rem 0.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .endpoint-item-btn {
      width: 100%;
      text-align: left;
      background: transparent;
      border: 1px solid transparent;
      color: #cbd5e1;
      padding: 0.55rem 0.75rem;
      border-radius: 8px;
      display: flex;
      align-items: center;
      gap: 0.65rem;
      margin-bottom: 0.25rem;
      font-size: 0.85rem;
      transition: all 0.15s ease-in-out;
      cursor: pointer;
    }

    .endpoint-item-btn:hover {
      background-color: #1e293b;
      color: #fff;
    }

    .endpoint-item-btn.active {
      background: linear-gradient(90deg, rgba(59, 130, 246, 0.18) 0%, rgba(30, 41, 59, 0.9) 100%);
      border-color: rgba(59, 130, 246, 0.4);
      color: #60a5fa;
      font-weight: 600;
    }

    .method-badge {
      font-family: var(--font-mono);
      font-size: 0.68rem;
      font-weight: 700;
      padding: 0.18rem 0.45rem;
      border-radius: 4px;
      min-width: 44px;
      text-align: center;
    }
    .method-get {
      background-color: rgba(16, 185, 129, 0.18);
      color: #34d399;
      border: 1px solid rgba(16, 185, 129, 0.3);
    }
    .method-post {
      background-color: rgba(245, 158, 11, 0.18);
      color: #fbbf24;
      border: 1px solid rgba(245, 158, 11, 0.3);
    }

    .endpoint-title-text {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      flex: 1;
    }

    /* Right Workstation: Workbench & Console */
    .api-workbench {
      flex: 1;
      display: flex;
      flex-direction: column;
      height: 100%;
      overflow-y: auto;
      background-color: #0b1120;
    }

    /* Request Bar */
    .request-bar-card {
      background-color: #1e293b;
      border-bottom: 1px solid var(--border-dark);
      padding: 1.1rem 1.5rem;
    }

    .request-input-group {
      background-color: #0f172a;
      border: 1px solid var(--border-dark);
      border-radius: 10px;
      padding: 0.35rem 0.6rem;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .request-url-input {
      background: transparent;
      border: none;
      color: #f8fafc;
      font-family: var(--font-mono);
      font-size: 0.92rem;
      width: 100%;
      outline: none;
    }

    .btn-send-request {
      background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
      color: #fff;
      font-weight: 600;
      font-size: 0.88rem;
      padding: 0.55rem 1.25rem;
      border-radius: 8px;
      border: none;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
      transition: all 0.2s ease;
      white-space: nowrap;
    }
    .btn-send-request:hover {
      background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
      transform: translateY(-1px);
    }
    .btn-send-request:active {
      transform: translateY(0);
    }

    /* Parameters & Config Section */
    .config-accordion {
      padding: 1rem 1.5rem;
      background-color: #141f33;
      border-bottom: 1px solid var(--border-dark);
    }

    .param-row {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 0.65rem;
    }
    .param-label {
      width: 170px;
      font-family: var(--font-mono);
      font-size: 0.82rem;
      color: #94a3b8;
    }
    .param-input-dark {
      flex: 1;
      background-color: #0f172a;
      border: 1px solid var(--border-dark);
      color: #fff;
      font-family: var(--font-mono);
      font-size: 0.85rem;
      padding: 0.4rem 0.75rem;
      border-radius: 6px;
    }

    /* Response Console */
    .response-console {
      flex: 1;
      padding: 1.5rem;
      display: flex;
      flex-direction: column;
    }

    .meta-metrics-bar {
      display: flex;
      align-items: center;
      gap: 0.85rem;
      flex-wrap: wrap;
      margin-bottom: 1rem;
    }

    .metric-pill {
      background-color: #1e293b;
      border: 1px solid var(--border-dark);
      padding: 0.35rem 0.75rem;
      border-radius: 6px;
      font-size: 0.8rem;
      display: flex;
      align-items: center;
      gap: 0.45rem;
      color: #cbd5e1;
    }
    .metric-pill strong {
      color: #fff;
      font-family: var(--font-mono);
    }

    .status-badge-ok {
      background-color: rgba(16, 185, 129, 0.2);
      color: #10b981;
      border-color: rgba(16, 185, 129, 0.4);
    }
    .status-badge-err {
      background-color: rgba(239, 68, 68, 0.2);
      color: #ef4444;
      border-color: rgba(239, 68, 68, 0.4);
    }

    /* JSON Display Area */
    .json-viewer-container {
      flex: 1;
      min-height: 380px;
      background-color: #050914;
      border: 1px solid var(--border-dark);
      border-radius: 10px;
      position: relative;
      overflow: hidden;
      display: flex;
      flex-direction: column;
    }

    .json-viewer-toolbar {
      background-color: #0f172a;
      border-bottom: 1px solid var(--border-dark);
      padding: 0.5rem 1rem;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .json-code-content {
      flex: 1;
      padding: 1rem;
      margin: 0;
      overflow: auto;
      font-family: var(--font-mono);
      font-size: 0.85rem;
      line-height: 1.55;
      color: #e2e8f0;
      white-space: pre;
    }

    /* JSON Syntax Highlighting */
    .json-key { color: #60a5fa; font-weight: 600; }
    .json-string { color: #34d399; }
    .json-number { color: #fbbf24; }
    .json-boolean { color: #f472b6; font-weight: 700; }
    .json-null { color: #94a3b8; font-style: italic; }

    /* Visual Book / Card Preview Mode */
    .visual-preview-deck {
      margin-top: 1.25rem;
      background-color: #1e293b;
      border: 1px solid var(--border-dark);
      border-radius: 10px;
      padding: 1.25rem;
    }

    /* Batch Modal Styles */
    .batch-item-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0.55rem 0.85rem;
      border-bottom: 1px solid var(--border-dark);
      font-size: 0.85rem;
    }
    .batch-item-row:last-child {
      border-bottom: none;
    }

    /* Toast Notification */
    .toast-copy-notify {
      position: fixed;
      bottom: 2rem;
      right: 2rem;
      background-color: var(--accent-success);
      color: #fff;
      padding: 0.65rem 1.25rem;
      border-radius: 8px;
      font-weight: 600;
      box-shadow: 0 8px 24px rgba(0,0,0,0.4);
      display: none;
      z-index: 9999;
    }
  </style>
</head>
<body>

  <!-- 1. Üst Navigasyon & Kontrol Çubuğu -->
  <header class="api-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <div class="d-flex align-items-center gap-3">
      <a href="<?= base_url('/') ?>" class="text-decoration-none d-flex align-items-center gap-2">
        <span class="fs-4">🚀</span>
        <div>
          <h1 class="h6 fw-bold text-white mb-0">Ufka Yolculuk API Test Laboratuvarı</h1>
          <span class="text-muted" style="font-size: 0.75rem;">Canlı REST API Uç Noktaları & Yanıt Denetleyici</span>
        </div>
      </a>
      <span class="brand-badge ms-2">v2.0 Canlı</span>
    </div>

    <!-- Hızlı Aksiyonlar -->
    <div class="d-flex align-items-center gap-2">
      <button class="btn btn-sm btn-outline-info d-flex align-items-center gap-2 px-3 rounded-3" id="btnRunBatchModal">
        <i class="fa-solid fa-heart-pulse"></i>
        <span>Tüm Uçları Test Et (Health Check)</span>
      </button>

      <a href="https://ufkayolculuk.com/rest/docs" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-2 px-3 rounded-3">
        <i class="fa-solid fa-book"></i>
        <span>Resmi API Kılavuzu</span>
      </a>

      <a href="<?= base_url('/') ?>" class="btn btn-sm btn-dark border-secondary px-3 rounded-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Siteye Dön
      </a>
    </div>
  </header>

  <!-- 2. Çalışma Alanı: Sol Menü + Sağ Konsol -->
  <main class="app-workspace">

    <!-- Sol Sütun: Uç Noktaları Arama & Listeleme -->
    <aside class="endpoints-sidebar">
      <div class="sidebar-search-box">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="small fw-semibold text-muted">API Uç Noktaları</span>
          <span class="badge bg-secondary" id="endpointCountBadge"><?= count($endpoints) ?> Servis</span>
        </div>
        <div class="position-relative">
          <i class="fa-solid fa-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted" style="font-size: 0.8rem;"></i>
          <input type="text" id="endpointSearchInput" class="form-control search-input-dark ps-5" placeholder="Servis veya uç nokta ara... (örn: books, awards)">
        </div>
      </div>

      <div class="endpoints-scroll" id="endpointsListContainer">
        <?php 
          $groupedEndpoints = [];
          foreach ($endpoints as $k => $ep) {
              $groupedEndpoints[$ep['group']][] = array_merge($ep, ['key' => $k]);
          }
          foreach ($groupedEndpoints as $groupName => $groupItems):
              $firstItem = $groupItems[0] ?? [];
              $groupIcon = $firstItem['group_icon'] ?? 'fa-solid fa-folder text-muted';
        ?>
          <div class="endpoint-group-block mb-3">
            <div class="endpoint-group-title">
              <i class="<?= esc($groupIcon) ?>"></i>
              <span><?= esc($groupName) ?></span>
              <span class="badge bg-dark border border-secondary ms-auto text-secondary" style="font-size: 0.65rem;"><?= count($groupItems) ?></span>
            </div>
            
            <?php foreach ($groupItems as $item): 
                $methodClass = strtolower($item['method']) === 'post' ? 'method-post' : 'method-get';
            ?>
              <button type="button" 
                      class="endpoint-item-btn" 
                      data-endpoint-key="<?= esc($item['key']) ?>"
                      data-method="<?= esc($item['method']) ?>"
                      data-endpoint="<?= esc($item['endpoint']) ?>"
                      data-name="<?= esc($item['name']) ?>"
                      data-desc="<?= esc($item['desc']) ?>"
                      data-params='<?= json_encode($item['params'] ?? [], JSON_HEX_APOS | JSON_HEX_QUOT) ?>'>
                <span class="method-badge <?= $methodClass ?>"><?= esc($item['method']) ?></span>
                <span class="endpoint-title-text" title="<?= esc($item['name']) ?>"><?= esc($item['name']) ?></span>
              </button>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </aside>

    <!-- Sağ Sütun: İstek Oluşturucu, Parametreler & JSON Yanıt Konsolu -->
    <section class="api-workbench">
      
      <!-- 1. Üst İstek Çubuğu -->
      <div class="request-bar-card">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <div class="d-flex align-items-center gap-2">
            <h2 class="h6 fw-bold text-white mb-0" id="currentEndpointTitle">Servis Seçiniz</h2>
            <span class="badge bg-secondary" id="currentMethodBadge">GET</span>
          </div>
          <div class="d-flex align-items-center gap-3">
            <div class="form-check form-switch mb-0">
              <input class="form-check-input" type="checkbox" id="useCacheToggle" style="cursor: pointer;">
              <label class="form-check-label small text-muted" for="useCacheToggle" style="cursor: pointer;">Önbellek (Cache) Kullan</label>
            </div>
          </div>
        </div>

        <p class="small text-muted mb-3" id="currentEndpointDesc">Sol taraftaki API uç noktalarından birini seçerek canlı veriyi getirebilirsiniz.</p>

        <!-- URL ve Gönder Butonu -->
        <div class="d-flex align-items-center gap-2 flex-wrap">
          <div class="request-input-group flex-1" style="min-width: 300px; flex: 1;">
            <span class="text-muted fw-semibold small" style="white-space: nowrap;">BASE_URL/</span>
            <input type="text" id="activeUrlInput" class="request-url-input" value="getBooks" placeholder="getBooks veya getBook/{id}">
          </div>

          <button type="button" class="btn-send-request" id="btnExecuteRequest">
            <i class="fa-solid fa-play"></i>
            <span>İsteği Gönder (Send)</span>
          </button>
        </div>
      </div>

      <!-- 2. Dinamik Parametreler Çekmecesi -->
      <div class="config-accordion" id="paramsSection" style="display: none;">
        <div class="d-flex align-items-center justify-content-between mb-2">
          <span class="small fw-bold text-uppercase text-muted" style="letter-spacing: 0.5px;">
            <i class="fa-solid fa-sliders me-1 text-primary"></i> İstek Parametreleri (Query / Body Params)
          </span>
          <span class="badge bg-dark border border-secondary text-muted" id="paramsCountBadge">0 Parametre</span>
        </div>
        <div id="paramsFormContainer">
          <!-- Dinamik JS Form Inputları buraya gelir -->
        </div>
      </div>

      <!-- 3. Yanıt Konsolu & JSON Çıktısı -->
      <div class="response-console">
        
        <!-- Metrikler ve Durum Rozetleri -->
        <div class="meta-metrics-bar">
          <div class="metric-pill" id="statusPill">
            <i class="fa-solid fa-circle-dot"></i>
            <span>Durum:</span>
            <strong id="statusCodeVal">---</strong>
          </div>

          <div class="metric-pill">
            <i class="fa-solid fa-bolt text-warning"></i>
            <span>Süre:</span>
            <strong id="latencyVal">0 ms</strong>
          </div>

          <div class="metric-pill">
            <i class="fa-solid fa-database text-info"></i>
            <span>Kayıt Sayısı:</span>
            <strong id="itemCountVal">0</strong>
          </div>

          <div class="metric-pill">
            <i class="fa-solid fa-file-code text-purple"></i>
            <span>Boyut:</span>
            <strong id="dataSizeVal">0 KB</strong>
          </div>

          <div class="metric-pill">
            <i class="fa-solid fa-cloud text-secondary"></i>
            <span>Kaynak:</span>
            <strong id="sourceVal">Canlı API</strong>
          </div>

          <!-- Aksiyonlar: Kopyala, Formatla -->
          <div class="ms-auto d-flex align-items-center gap-2">
            <button type="button" class="btn btn-sm btn-dark border-secondary text-white" id="btnCopyJson" title="JSON'u Kopyala">
              <i class="fa-regular fa-copy me-1"></i> Panoya Kopyala
            </button>
            <button type="button" class="btn btn-sm btn-dark border-secondary text-white" id="btnCollapseJson" title="Görünümü Daralt/Genişlet">
              <i class="fa-solid fa-arrows-split-up-and-left me-1"></i> Format
            </button>
          </div>
        </div>

        <!-- JSON Görüntüleme Kutusu -->
        <div class="json-viewer-container">
          <div class="json-viewer-toolbar">
            <div class="d-flex align-items-center gap-2">
              <span class="badge bg-dark border border-secondary text-light font-monospace" style="font-size: 0.72rem;">application/json</span>
              <span class="small text-muted" id="responseTimestamp">İstek bekleniyor...</span>
            </div>
            <div class="small text-muted font-monospace" id="responseStatusMsg">Hazır</div>
          </div>

          <pre class="json-code-content" id="jsonViewerDisplay">// Uç nokta seçip "İsteği Gönder" butonuna basınız.
// Canlı API yanıtı JSON formatında, renklendirilmiş olarak burada görünecektir.</pre>
        </div>

        <!-- 4. Canlı Görsel Önizleme (Kitaplar, Duyurular veya Takvim İçin) -->
        <div class="visual-preview-deck mt-3" id="visualPreviewArea" style="display: none;">
          <h3 class="h6 fw-bold text-white mb-3 d-flex align-items-center gap-2">
            <i class="fa-solid fa-eye text-primary"></i>
            <span>Görsel Veri Önizlemesi</span>
          </h3>
          <div class="row g-3" id="visualCardDeckContainer">
            <!-- Dinamik Kartlar buraya basılır -->
          </div>
        </div>

      </div>

    </section>

  </main>

  <!-- 3. Toplu Sağlık Taraması (Batch Check) Modal -->
  <div class="modal fade" id="batchHealthModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content bg-dark border-secondary text-white">
        <div class="modal-header border-secondary">
          <h5 class="modal-title d-flex align-items-center gap-2">
            <i class="fa-solid fa-heart-pulse text-danger"></i>
            <span>Toplu API Sağlık Taraması (Health Check)</span>
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Kapat"></button>
        </div>
        <div class="modal-body p-4">
          <p class="small text-muted mb-3">
            Tüm kritik Ufka Yolculuk servislerine ardışık canlı istekler gönderilir; yanıt süreleri ve veri bütünlüğü denetlenir.
          </p>

          <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-black border border-secondary mb-3">
            <div>
              <div class="small text-muted">Test Edilen Uçlar</div>
              <h4 class="h5 fw-bold text-white mb-0" id="batchTotalCount">---</h4>
            </div>
            <div>
              <div class="small text-muted">Başarılı</div>
              <h4 class="h5 fw-bold text-success mb-0" id="batchSuccessCount">---</h4>
            </div>
            <div>
              <div class="small text-muted">Hatalı</div>
              <h4 class="h5 fw-bold text-danger mb-0" id="batchFailedCount">---</h4>
            </div>
            <div>
              <div class="small text-muted">Ortalama Gecikme</div>
              <h4 class="h5 fw-bold text-warning mb-0" id="batchAvgLatency">---</h4>
            </div>
          </div>

          <div class="list-group list-group-flush border border-secondary rounded-3 overflow-hidden" id="batchResultsList">
            <div class="text-center py-4 text-muted">
              <i class="fa-solid fa-spinner fa-spin fs-3 mb-2 d-block"></i>
              Test başlatılıyor, lütfen bekleyiniz...
            </div>
          </div>
        </div>
        <div class="modal-footer border-secondary">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
          <button type="button" class="btn btn-primary" id="btnRestartBatchTest">Yeniden Test Et</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Bildirimi -->
  <div class="toast-copy-notify" id="copyToastNotification">
    <i class="fa-solid fa-circle-check me-2"></i> JSON panoya kopyalandı!
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- API Test Laboratuvarı JS Motoru -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const BASE_AJAX_EXECUTE = '<?= base_url('api-test/execute') ?>';
      const BASE_AJAX_BATCH   = '<?= base_url('api-test/batch') ?>';

      // Elemanlar
      const searchInput      = document.getElementById('endpointSearchInput');
      const endpointsContainer = document.getElementById('endpointsListContainer');
      const endpointButtons  = document.querySelectorAll('.endpoint-item-btn');
      
      const currentTitle     = document.getElementById('currentEndpointTitle');
      const currentMethod    = document.getElementById('currentMethodBadge');
      const currentDesc      = document.getElementById('currentEndpointDesc');
      const activeUrlInput   = document.getElementById('activeUrlInput');
      const btnSend          = document.getElementById('btnExecuteRequest');
      const useCacheToggle   = document.getElementById('useCacheToggle');

      const paramsSection    = document.getElementById('paramsSection');
      const paramsContainer  = document.getElementById('paramsFormContainer');
      const paramsCountBadge = document.getElementById('paramsCountBadge');

      const statusCodeVal    = document.getElementById('statusCodeVal');
      const statusPill       = document.getElementById('statusPill');
      const latencyVal       = document.getElementById('latencyVal');
      const itemCountVal     = document.getElementById('itemCountVal');
      const dataSizeVal      = document.getElementById('dataSizeVal');
      const sourceVal        = document.getElementById('sourceVal');
      const jsonViewer       = document.getElementById('jsonViewerDisplay');
      const responseStatus   = document.getElementById('responseStatusMsg');
      const responseTimeLbl  = document.getElementById('responseTimestamp');

      const btnCopyJson      = document.getElementById('btnCopyJson');
      const copyToast        = document.getElementById('copyToastNotification');
      const visualPreview    = document.getElementById('visualPreviewArea');
      const visualCardsDeck  = document.getElementById('visualCardDeckContainer');

      let currentActiveKey   = null;
      let lastRawJsonResponse = null;

      // 1. Arama Filtresi (Client-Side)
      searchInput.addEventListener('input', (e) => {
        const query = e.target.value.toLowerCase().trim();
        endpointButtons.forEach(btn => {
          const name = btn.getAttribute('data-name').toLowerCase();
          const ep = btn.getAttribute('data-endpoint').toLowerCase();
          const match = name.includes(query) || ep.includes(query);
          btn.style.display = match ? 'flex' : 'none';
        });

        // Boş kalan grupları gizle
        document.querySelectorAll('.endpoint-group-block').forEach(group => {
          const visibleButtons = group.querySelectorAll('.endpoint-item-btn:not([style*="display: none"])');
          group.style.display = visibleButtons.length > 0 ? 'block' : 'none';
        });
      });

      // 2. Bir Uç Noktaya Tıklandığında Seç ve Parametreleri Yükle
      endpointButtons.forEach(btn => {
        btn.addEventListener('click', () => {
          endpointButtons.forEach(b => b.classList.remove('active'));
          btn.classList.add('active');

          const key    = btn.getAttribute('data-endpoint-key');
          const method = btn.getAttribute('data-method');
          const endpoint = btn.getAttribute('data-endpoint');
          const name   = btn.getAttribute('data-name');
          const desc   = btn.getAttribute('data-desc');
          const params = JSON.parse(btn.getAttribute('data-params') || '{}');

          currentActiveKey = key;
          currentTitle.textContent = name;
          currentMethod.textContent = method;
          currentMethod.className = `badge ${method === 'POST' ? 'bg-warning text-dark' : 'bg-success'}`;
          currentDesc.textContent = desc;
          activeUrlInput.value = endpoint;

          // Parametre Formunu Oluştur
          buildParamsForm(params);

          // İsteği otomatik gönder (Kullanıcı deneyimi için hızlı canlı önizleme)
          executeActiveRequest();
        });
      });

      // Parametre Formu Üretici
      function buildParamsForm(params) {
        paramsContainer.innerHTML = '';
        const paramKeys = Object.keys(params);

        if (paramKeys.length === 0) {
          paramsSection.style.display = 'none';
          paramsCountBadge.textContent = '0 Parametre';
          return;
        }

        paramsSection.style.display = 'block';
        paramsCountBadge.textContent = `${paramKeys.length} Parametre`;

        paramKeys.forEach(pKey => {
          const pConf = params[pKey];
          const row = document.createElement('div');
          row.className = 'param-row';
          row.innerHTML = `
            <div class="param-label">
              <span>${pKey}</span>
              ${pConf.desc ? `<div class="text-muted" style="font-size: 0.7rem;">${pConf.desc}</div>` : ''}
            </div>
            <input type="${pConf.type || 'text'}" 
                   class="param-input-dark dynamic-param-input" 
                   data-param-key="${pKey}" 
                   value="${pConf.default || ''}" 
                   placeholder="${pConf.desc || pKey}">
          `;
          paramsContainer.appendChild(row);
        });

        // Parametre inputlarında enter basıldığında isteği gönder
        paramsContainer.querySelectorAll('.dynamic-param-input').forEach(input => {
          input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
              e.preventDefault();
              executeActiveRequest();
            }
          });
        });
      }

      // 3. Canlı İstek Gönderme Fonksiyonu
      function executeActiveRequest() {
        const customUrl = activeUrlInput.value.trim();
        if (!customUrl) return;

        // Parametreleri topla
        const collectedParams = {};
        document.querySelectorAll('.dynamic-param-input').forEach(inp => {
          const pk = inp.getAttribute('data-param-key');
          collectedParams[pk] = inp.value;
        });

        // UI Yükleniyor Durumu
        btnSend.disabled = true;
        btnSend.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> <span>Çekiliyor...</span>';
        responseStatus.textContent = 'Canlı API çağrısı yapılıyor...';
        jsonViewer.textContent = '// İstek gönderildi, sunucu yanıtı bekleniyor...';

        const payload = new FormData();
        payload.append('endpoint_key', currentActiveKey || '');
        payload.append('custom_url', customUrl);
        payload.append('params', JSON.stringify(collectedParams));
        payload.append('use_cache', useCacheToggle.checked ? '1' : '0');

        fetch(BASE_AJAX_EXECUTE, {
          method: 'POST',
          body: payload,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
        .then(res => res.json())
        .then(data => {
          btnSend.disabled = false;
          btnSend.innerHTML = '<i class="fa-solid fa-play"></i> <span>İsteği Gönder (Send)</span>';

          lastRawJsonResponse = data.data;

          // Metrikleri Güncelle
          statusCodeVal.textContent = data.status_code || 0;
          if (data.status_code >= 200 && data.status_code < 300) {
            statusPill.className = 'metric-pill status-badge-ok';
            responseStatus.innerHTML = `<span class="text-success"><i class="fa-solid fa-check"></i> ${data.message || '200 OK'}</span>`;
          } else {
            statusPill.className = 'metric-pill status-badge-err';
            responseStatus.innerHTML = `<span class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i> ${data.message || 'Hata'}</span>`;
          }

          latencyVal.textContent = `${data.latency_ms} ms`;
          itemCountVal.textContent = data.item_count || 0;
          dataSizeVal.textContent = `${data.data_size_kb} KB`;
          sourceVal.textContent = data.from_cache ? 'Önbellek (Cache)' : 'Canlı API';
          responseTimeLbl.textContent = new Date().toLocaleTimeString();

          // Renkli JSON Bas
          if (data.data) {
            jsonViewer.innerHTML = syntaxHighlightJson(data.data);
          } else {
            jsonViewer.textContent = data.raw_body || '// Boş yanıt (204 No Content)';
          }

          // Görsel Kart Önizleme (Kitaplar veya Duyurular için)
          renderVisualCards(currentActiveKey, data.data);
        })
        .catch(err => {
          btnSend.disabled = false;
          btnSend.innerHTML = '<i class="fa-solid fa-play"></i> <span>İsteği Gönder (Send)</span>';
          statusCodeVal.textContent = 'HATA';
          statusPill.className = 'metric-pill status-badge-err';
          responseStatus.textContent = 'İstemci Hatası';
          jsonViewer.textContent = '// İstek gönderilirken hata oluştu: ' + err.message;
        });
      }

      // Butonla İstek Gönder
      btnSend.addEventListener('click', executeActiveRequest);
      activeUrlInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
          e.preventDefault();
          executeActiveRequest();
        }
      });

      // 4. JSON Renklendirme Yardımcısı (Syntax Highlighter)
      function syntaxHighlightJson(json) {
        if (typeof json !== 'string') {
          json = JSON.stringify(json, null, 2);
        }
        json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
          let cls = 'json-number';
          if (/^"/.test(match)) {
            if (/:$/.test(match)) {
              cls = 'json-key';
            } else {
              cls = 'json-string';
            }
          } else if (/true|false/.test(match)) {
            cls = 'json-boolean';
          } else if (/null/.test(match)) {
            cls = 'json-null';
          }
          return '<span class="' + cls + '">' + match + '</span>';
        });
      }

      // 5. Görsel Kart Üretici (Zengin Önizleme)
      function renderVisualCards(key, data) {
        if (!data || !Array.isArray(data) || data.length === 0) {
          visualPreview.style.display = 'none';
          return;
        }

        visualCardsDeck.innerHTML = '';
        let cardsRendered = 0;

        if (key === 'getBooks' || key === 'getBook') {
          visualPreview.style.display = 'block';
          const items = Array.isArray(data) ? data : [data];
          items.slice(0, 6).forEach(b => {
            const col = document.createElement('div');
            col.className = 'col-md-4 col-sm-6';
            col.innerHTML = `
              <div class="card bg-black border-secondary h-100 p-3 text-white">
                <div class="d-flex gap-3 align-items-center">
                  <img src="https://yonetim.ufkayolculuk.com/${b.image || ''}" alt="${b.name || ''}" class="rounded" style="width: 55px; height: 75px; object-fit: cover;" onerror="this.src='<?= base_url('assets/images/placeholder-book.png') ?>'">
                  <div>
                    <span class="badge bg-primary mb-1">${b.level || b.category_name || 'Yarışma Kitabı'}</span>
                    <h5 class="fs-6 fw-bold mb-1">${b.name || b.title || ''}</h5>
                    <div class="small text-muted">${b.author || 'Ufka Yolculuk Yayınları'}</div>
                    <div class="small text-warning mt-1"><i class="fa-solid fa-file-lines me-1"></i>${b.total_page || 0} Sayfa</div>
                  </div>
                </div>
              </div>
            `;
            visualCardsDeck.appendChild(col);
            cardsRendered++;
          });
        } else if (key === 'getAnnouncements' || key === 'getNews') {
          visualPreview.style.display = 'block';
          data.slice(0, 4).forEach(n => {
            const col = document.createElement('div');
            col.className = 'col-md-6';
            col.innerHTML = `
              <div class="card bg-black border-secondary h-100 p-3 text-white">
                <div class="small text-muted mb-1"><i class="fa-regular fa-calendar me-1"></i>${n.publish_time || 'Güncel'}</div>
                <h5 class="fs-6 fw-bold text-primary mb-1">${n.title || ''}</h5>
                <p class="small text-muted mb-0" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                  ${n.description || (n.body ? n.body.replace(/<[^>]*>/g, '') : '')}
                </p>
              </div>
            `;
            visualCardsDeck.appendChild(col);
            cardsRendered++;
          });
        } else if (key === 'getImportantDates') {
          visualPreview.style.display = 'block';
          data.slice(0, 4).forEach(d => {
            const col = document.createElement('div');
            col.className = 'col-md-6';
            col.innerHTML = `
              <div class="card bg-black border-secondary h-100 p-3 text-white d-flex flex-row justify-content-between align-items-center">
                <div>
                  <h5 class="fs-6 fw-bold text-warning mb-1">${d.title || ''}</h5>
                  <div class="small text-muted">${d.desc || d.description || ''}</div>
                </div>
                <span class="badge bg-dark border border-warning text-warning p-2 font-monospace">${d.date || d.start_date || ''}</span>
              </div>
            `;
            visualCardsDeck.appendChild(col);
            cardsRendered++;
          });
        }

        if (cardsRendered === 0) {
          visualPreview.style.display = 'none';
        }
      }

      // 6. JSON Panoya Kopyalama
      btnCopyJson.addEventListener('click', () => {
        if (!lastRawJsonResponse) return;
        const text = JSON.stringify(lastRawJsonResponse, null, 2);
        navigator.clipboard.writeText(text).then(() => {
          copyToast.style.display = 'block';
          setTimeout(() => {
            copyToast.style.display = 'none';
          }, 2500);
        });
      });

      // 7. Toplu Sağlık Taraması (Batch Modal)
      const batchModal = new bootstrap.Modal(document.getElementById('batchHealthModal'));
      const btnBatchModal = document.getElementById('btnRunBatchModal');
      const btnRestartBatch = document.getElementById('btnRestartBatchTest');
      const batchResultsList = document.getElementById('batchResultsList');

      function runBatchHealthCheck() {
        batchResultsList.innerHTML = `
          <div class="text-center py-4 text-muted">
            <i class="fa-solid fa-spinner fa-spin fs-3 mb-2 d-block text-primary"></i>
            Canlı API sağlık taraması yürütülüyor, lütfen bekleyiniz...
          </div>
        `;

        fetch(BASE_AJAX_BATCH, {
          method: 'POST',
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(res => {
          document.getElementById('batchTotalCount').textContent = res.total_tested;
          document.getElementById('batchSuccessCount').textContent = res.successful;
          document.getElementById('batchFailedCount').textContent = res.failed;
          document.getElementById('batchAvgLatency').textContent = `${res.average_latency} ms`;

          batchResultsList.innerHTML = '';
          Object.keys(res.results).forEach(k => {
            const item = res.results[k];
            const row = document.createElement('div');
            row.className = 'batch-item-row';
            row.innerHTML = `
              <div class="d-flex align-items-center gap-2">
                <i class="fa-solid ${item.success ? 'fa-circle-check text-success' : 'fa-circle-xmark text-danger'}"></i>
                <span class="badge ${item.method === 'POST' ? 'bg-warning text-dark' : 'bg-success'} font-monospace" style="font-size: 0.65rem;">${item.method}</span>
                <span class="fw-semibold text-white font-monospace">${item.endpoint}</span>
              </div>
              <div class="d-flex align-items-center gap-3">
                <span class="badge ${item.status_code === 200 ? 'bg-success' : 'bg-danger'}">${item.status_code}</span>
                <span class="text-muted font-monospace small">${item.latency_ms} ms</span>
                <span class="badge bg-dark border border-secondary text-info">${item.item_count} Kayıt</span>
              </div>
            `;
            batchResultsList.appendChild(row);
          });
        })
        .catch(err => {
          batchResultsList.innerHTML = `<div class="p-3 text-danger">Hata: ${err.message}</div>`;
        });
      }

      btnBatchModal.addEventListener('click', () => {
        batchModal.show();
        runBatchHealthCheck();
      });
      btnRestartBatch.addEventListener('click', runBatchHealthCheck);

      // Başlangıçta ilk servisi (getBooks) otomatik seç
      if (endpointButtons.length > 0) {
        endpointButtons[3].click(); // getBooks
      }
    });
  </script>
</body>
</html>
