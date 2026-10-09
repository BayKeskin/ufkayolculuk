<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
  .cert-portal-wrap {
    background-color: #f0f4f9;
    min-height: calc(100vh - 200px);
    padding: 2.5rem 0 4rem;
  }

  .cert-header-title {
    font-size: 2.2rem;
    font-weight: 800;
    color: #1e3a62;
    letter-spacing: -0.5px;
    margin-bottom: 0.5rem;
  }

  .cert-card {
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid rgba(226, 232, 240, 0.8);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
  }

  .cert-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  }

  .cert-preview-banner {
    height: 160px;
    background: linear-gradient(135deg, #1e3a62 0%, #2563eb 100%);
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    padding: 1.5rem;
    text-align: center;
  }

  .cert-preview-banner::after {
    content: '';
    position: absolute;
    inset: 10px;
    border: 2px dashed rgba(255, 255, 255, 0.35);
    border-radius: 12px;
    pointer-events: none;
  }

  .cert-badge-floating {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255, 255, 255, 0.95);
    color: #1e3a62;
    font-size: 0.75rem;
    font-weight: 800;
    padding: 0.35rem 0.75rem;
    border-radius: 50rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }

  .cert-card-body {
    padding: 1.75rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
  }

  .cert-title {
    font-size: 1.25rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 0.5rem;
  }

  .cert-meta {
    font-size: 0.85rem;
    color: #64748b;
    margin-bottom: 1.25rem;
  }

  .cert-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 1.5rem;
    flex-wrap: wrap;
  }

  /* Belge Modal Önizleme & Yazdırma */
  @media print {
    body * {
      visibility: hidden;
    }
    #printableCertificate, #printableCertificate * {
      visibility: visible;
    }
    #printableCertificate {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 20mm;
      box-shadow: none !important;
    }
  }

  .certificate-sheet {
    background: #fffdfa;
    border: 12px solid #1e3a62;
    outline: 4px solid #f59e0b;
    outline-offset: -8px;
    padding: 3rem 2.5rem;
    text-align: center;
    position: relative;
    border-radius: 8px;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="cert-portal-wrap">
  <div class="container">

    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
      <div>
        <h1 class="cert-header-title">Sertifikalarım & Başarı Belgelerim</h1>
        <p class="text-muted mb-0">Ufka Yolculuk yarışmalarında hak kazandığınız tüm resmi sertifikalar.</p>
      </div>
      <div>
        <a href="<?= base_url('sinavlarim') ?>" class="btn btn-outline-secondary rounded-pill px-3 py-2 small fw-semibold">
          ← Sınavlarıma Dön
        </a>
      </div>
    </div>

    <!-- Sertifikalar Kart Izgarası -->
    <div class="row g-4">
      <?php foreach ($certificates as $cert): ?>
        <div class="col-12 col-md-6 col-lg-4">
          <div class="cert-card">
            <div class="cert-preview-banner">
              <span class="cert-badge-floating"><?= esc($cert['badge']) ?></span>
              <div>
                <div class="fs-1 mb-1">🏅</div>
                <div class="fw-bold small opacity-75">UFKA YOLCULUK</div>
              </div>
            </div>

            <div class="cert-card-body">
              <div>
                <h2 class="cert-title"><?= esc($cert['title']) ?></h2>
                <div class="cert-meta">
                  <div><strong>Yarışmacı:</strong> <?= esc($user['name']) ?></div>
                  <div><strong>Kategori:</strong> <?= esc($cert['category']) ?></div>
                  <div><strong>Belge No:</strong> <code><?= esc($cert['code']) ?></code></div>
                </div>
                <p class="small text-muted mb-0"><?= esc($cert['desc']) ?></p>
              </div>

              <div class="cert-actions">
                <button type="button" class="btn btn-primary rounded-pill px-3 py-2 flex-grow-1 small fw-bold"
                  onclick="openCertPreview('<?= esc($cert['title']) ?>', '<?= esc($cert['category']) ?>', '<?= esc($cert['code']) ?>')">
                  👁️ Önizle
                </button>
                <button type="button" class="btn btn-outline-secondary rounded-pill px-3 py-2 small fw-bold"
                  onclick="window.print()">
                  🖨️ Yazdır
                </button>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</div>

<!-- Sertifika Önizleme Modalı -->
<div class="modal fade" id="certModal" tabindex="-1" aria-labelledby="certModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content shadow-lg border-0 rounded-4">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold" id="certModalLabel">Belge Önizleme</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
      </div>
      <div class="modal-body p-4">
        <div id="printableCertificate" class="certificate-sheet">
          <div class="mb-3">
            <img src="<?= base_url('assets/images/logo.png') ?>" alt="Ufka Yolculuk" width="180" class="mb-2">
            <h3 class="fw-bold text-dark text-uppercase mt-2" id="modalCertTitle">UFKA YOLCULUK BELGESİ</h3>
          </div>
          <p class="text-muted fs-6 mb-4">Bu belge, 14. Ufka Yolculuk Bilgi ve Kültür Yarışması kapsamında takdim edilmiştir.</p>
          <div class="my-4 py-3 border-top border-bottom">
            <div class="display-6 fw-bold text-primary mb-1"><?= esc($user['name']) ?></div>
            <div class="text-muted fw-semibold" id="modalCertCategory"><?= esc($user['category_title']) ?></div>
          </div>
          <div class="d-flex justify-content-between align-items-center mt-4 text-muted small px-3">
            <div>Tarih: <strong>2026</strong></div>
            <div>Belge Doğrulama Kodu: <strong id="modalCertCode">UY-KB-0000</strong></div>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 justify-content-center">
        <button type="button" class="btn btn-warning rounded-pill px-4 fw-bold" onclick="window.print()">
          🖨️ Yazdır / PDF Olarak Kaydet
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  function openCertPreview(title, category, code) {
    document.getElementById('modalCertTitle').textContent = title;
    document.getElementById('modalCertCategory').textContent = category;
    document.getElementById('modalCertCode').textContent = code;
    const modal = new bootstrap.Modal(document.getElementById('certModal'));
    modal.show();
  }
</script>
<?= $this->endSection() ?>
