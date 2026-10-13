<?= $this->extend('themes/classic/layouts/main') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm border-0 mb-5">
    <div class="card-header border-bottom py-4">
        <h2 class="card-title fw-bold text-gray-900 m-0">İletişim</h2>
    </div>
    <div class="card-body p-6">
        <div class="row g-5">
            <div class="col-lg-6">
                <h4 class="fw-bold mb-4">Bizimle İletişime Geçin</h4>
                <div class="d-flex align-items-center mb-4">
                    <div class="btn btn-icon btn-light-primary me-4">
                        <i class="fas fa-map-marker-alt fs-4"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-6">Adres</div>
                        <div class="text-muted fs-7">Ufka Yolculuk Genel Merkezi, İstanbul / Türkiye</div>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-4">
                    <div class="btn btn-icon btn-light-success me-4">
                        <i class="fas fa-envelope fs-4"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-6">E-Posta</div>
                        <div class="text-muted fs-7">bilgi@ufkayolculuk.com</div>
                    </div>
                </div>
                <div class="d-flex align-items-center mb-4">
                    <div class="btn btn-icon btn-light-warning me-4">
                        <i class="fas fa-phone fs-4"></i>
                    </div>
                    <div>
                        <div class="fw-bold fs-6">Destek Hattı</div>
                        <div class="text-muted fs-7">444 0 835 (UY)</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h4 class="fw-bold mb-4">Mesaj Gönderin</h4>
                <form method="post" action="<?= base_url('iletisim/gonder') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Adınız Soyadınız</label>
                        <input type="text" name="name" class="form-control form-control-solid" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">E-Posta Adresiniz</label>
                        <input type="email" name="email" class="form-control form-control-solid" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Konu</label>
                        <input type="text" name="subject" class="form-control form-control-solid" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Mesajınız</label>
                        <textarea name="message" rows="4" class="form-control form-control-solid" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary fw-bold px-6">Mesajı İlet</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
