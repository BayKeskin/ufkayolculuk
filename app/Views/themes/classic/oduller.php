<?= $this->extend('themes/classic/layouts/main') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm border-0 mb-5">
    <div class="card-header border-bottom py-4">
        <h2 class="card-title fw-bold text-gray-900 m-0">Yarışma Ödülleri</h2>
    </div>
    <div class="card-body p-6">
        <div class="alert alert-primary d-flex align-items-center p-4 mb-5 rounded-3">
            <i class="ki-duotone ki-shield-tick fs-2hx text-primary me-3"></i>
            <div class="d-flex flex-column">
                <h5 class="mb-1 text-primary fw-bold">Büyük Ödül Havuzu</h5>
                <span class="fs-7">Türkiye Geneli ve İl/İlçe bazlı birbirinden değerli ödüller dereceye giren yarışmacılarımızı bekliyor!</span>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border p-4 text-center rounded-3 bg-light shadow-xs h-100">
                    <div class="fs-1 mb-2">🥇</div>
                    <h4 class="fw-bold text-gray-900">1.lik Ödülü</h4>
                    <p class="text-primary fw-bold fs-3 mb-2">Umre / Para Ödülü</p>
                    <span class="text-muted fs-8">Türkiye Geneli Derece</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border p-4 text-center rounded-3 bg-light shadow-xs h-100">
                    <div class="fs-1 mb-2">🥈</div>
                    <h4 class="fw-bold text-gray-900">2.lik Ödülü</h4>
                    <p class="text-primary fw-bold fs-3 mb-2">Dizüstü Bilgisayar</p>
                    <span class="text-muted fs-8">Türkiye Geneli Derece</span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border p-4 text-center rounded-3 bg-light shadow-xs h-100">
                    <div class="fs-1 mb-2">🥉</div>
                    <h4 class="fw-bold text-gray-900">3.lük Ödülü</h4>
                    <p class="text-primary fw-bold fs-3 mb-2">Akıllı Tablet</p>
                    <span class="text-muted fs-8">Türkiye Geneli Derece</span>
                </div>
            </div>
        </div>

        <div class="mt-5 p-4 rounded-3 border bg-white">
            <h5 class="fw-bold mb-3">Detaylı Bilgi ve Şartname</h5>
            <p class="text-muted fs-7 mb-0">
                Tüm ödül detayları, il ödülleri ve ödül dağıtım koşulları için <a href="<?= base_url('sayfa/yarisma-sartnamesi') ?>" class="fw-bold text-primary">Yarışma Şartnamesini</a> inceleyebilirsiniz.
            </p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
