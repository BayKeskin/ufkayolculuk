<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
  .leader-portal-wrap {
    background-color: #f0f4f9;
    min-height: calc(100vh - 200px);
    padding: 2.5rem 0 4rem;
  }
  .leader-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    border: 1px solid rgba(226, 232, 240, 0.8);
    margin-bottom: 1.5rem;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="leader-portal-wrap">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
      <div>
        <h1 class="portal-user-name mb-1" style="font-size: 2.2rem; font-weight: 800; color: #1e3a62;">Takım Lideri Portalı</h1>
        <p class="text-muted mb-0">Öğrencilerinize rehberlik edin, yarışma yolculuğunda onlara öncülük edin.</p>
      </div>
      <div>
        <a href="<?= base_url('sinavlarim') ?>" class="btn btn-outline-secondary rounded-pill px-3 py-2 small fw-semibold">
          ← Sınavlarıma Dön
        </a>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-12 col-md-4">
        <div class="leader-card text-center">
          <div class="display-5 mb-2">⭐</div>
          <h3 class="fw-bold fs-5 text-dark">Liderlik Statüsü</h3>
          <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold fs-6 mt-2">● AKTİF</span>
          <div class="mt-3 text-muted small">Kategori: <strong><?= esc($user['leader_category'] ?? 'DİĞER') ?></strong></div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="leader-card text-center">
          <div class="display-5 mb-2">👥</div>
          <h3 class="fw-bold fs-5 text-dark">Kayıtlı Takım Üyesi</h3>
          <div class="display-6 fw-bold text-primary mt-2">0</div>
          <div class="mt-2 text-muted small">Rehberlik ettiğiniz toplam yarışmacı sayısı.</div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="leader-card text-center">
          <div class="display-5 mb-2">🎯</div>
          <h3 class="fw-bold fs-5 text-dark">Liderlik Puanı</h3>
          <div class="display-6 fw-bold text-success mt-2"><?= esc($user['leader_score'] ?? '0.00') ?></div>
          <div class="mt-2 text-muted small">Öğrencilerinizin başarısına göre biriken puanınız.</div>
        </div>
      </div>
    </div>

    <div class="leader-card mt-3">
      <h3 class="fw-bold fs-5 text-dark mb-3">Takım Lideri Kodu & Davet</h3>
      <p class="text-muted small">Öğrencileriniz kayıt olurken sizin liderlik kodunuzu girdiğinde otomatik olarak takımınıza dahil olur.</p>
      <div class="d-flex align-items-center gap-3">
        <input type="text" class="form-control form-control-lg fw-bold text-primary text-center" style="max-width: 250px; letter-spacing: 2px;" value="<?= esc($user['invite_code'] ?? 'UYCOPBLLH1YDO') ?>" readonly>
        <a href="<?= base_url('vesile-olduklarim') ?>" class="btn btn-warning rounded-pill px-4 py-2 fw-bold">
          Davet Bağlantısını Paylaş
        </a>
      </div>
    </div>

  </div>
</div>
<?= $this->endSection() ?>
