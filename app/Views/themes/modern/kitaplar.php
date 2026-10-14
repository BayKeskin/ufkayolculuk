<?= $this->extend('themes/modern/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container py-5">
    <div class="row mb-5">
        <div class="col-12 text-center">
            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill fw-semibold mb-2">📚 Yarışma Kitapları</span>
            <h1 class="display-5 fw-bold mb-3"><?= esc($categoryTitle ?? 'Ufka Yolculuk 13'); ?> Dijital Kitapları</h1>
            <p class="lead text-muted mx-auto" style="max-width: 650px;">
                Tüm kitaplarımızı ücretsiz olarak online okuyabilir veya bölgenizdeki temin noktalarından basılı olarak satın alabilirsiniz.
            </p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4" style="background: linear-gradient(135deg, #0fa1ba 0%, #0d8a9e 100%);">
                <div class="card-body text-white d-flex flex-column justify-content-between">
                    <div>
                        <div class="fs-1 mb-3">📍</div>
                        <h3 class="fw-bold mb-2 text-white">Kitap Temin Noktaları</h3>
                        <p class="text-white-50 mb-4">Basılı kitap satın alabileceğiniz il ve ilçenizdeki resmi temin adresleri listesi.</p>
                    </div>
                    <div>
                        <a href="<?= base_url('sayfa/temin-noktalari'); ?>" class="btn btn-light rounded-pill px-4 fw-semibold text-primary">Noktaları Gör &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100 border-0 shadow-sm rounded-4 p-4" style="background: linear-gradient(135deg, #6c5ce7 0%, #5843d8 100%);">
                <div class="card-body text-white d-flex flex-column justify-content-between">
                    <div>
                        <div class="fs-1 mb-3">🛒</div>
                        <h3 class="fw-bold mb-2 text-white">Online Kitap Siparişi</h3>
                        <p class="text-white-50 mb-4">Server Yayınları üzerinden adresinize teslim basılı kitap siparişi verin.</p>
                    </div>
                    <div>
                        <a href="https://serveryayinlari.com/ufka-yolculuk-1" target="_blank" class="btn btn-light rounded-pill px-4 fw-semibold text-primary">Hemen Sipariş Ver &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <?php foreach($books as $book){ 
            $bSlug = is_object($book) ? ($book->slug ?? '') : ($book['slug'] ?? '');
            $bName = is_object($book) ? ($book->name ?? '') : ($book['name'] ?? ($book['title'] ?? ''));
            $bCat  = is_object($book) ? ($book->category ?? '') : ($book['category'] ?? '');
            $bImg  = is_object($book) ? ($book->image ?? '') : ($book['image_url'] ?? ($book['image'] ?? ''));
            $readUrl = !empty($bSlug) ? base_url('kitap-oku/' . $bSlug) : '#';
            $imgUrl = (strpos($bImg, 'http') === 0) ? $bImg : base_url(ltrim($bImg, '/'));
        ?>
        <div class="col-sm-6 col-lg-3">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="position-relative overflow-hidden" style="height: 340px; background-color: #f8f9fa;">
                    <img src="<?= esc($imgUrl); ?>" alt="<?= esc($bName); ?>" class="w-100 h-100 object-fit-cover">
                    <span class="badge bg-success position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill shadow-sm">Ücretsiz</span>
                </div>
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div>
                        <span class="badge bg-primary-subtle text-primary rounded-pill mb-2"><?= esc($bCat); ?></span>
                        <h5 class="fw-bold mb-1"><?= esc($bName); ?></h5>
                    </div>
                    <div class="mt-3">
                        <a href="<?= $readUrl; ?>" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold">Okumaya Başla</a>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
<?= $this->endSection() ?>
