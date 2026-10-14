<?= $this->extend('themes/classic/layouts/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-xxl-6 mb-5">
        <a href="<?= base_url('temin-noktalari'); ?>" class="card card-xxl-stretch" style="border:0px;background-color:#0fa1ba">
            <div class="card-body d-flex flex-column justify-content-between">
                <i class="ki-duotone ki-element-11 text-white fs-2hx ms-n1 flex-grow-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                <div class="d-flex flex-column">
                    <div class="text-white fw-bold fs-1 mb-0 mt-3">Kitap Temin Noktaları</div>
                    <div class="text-white fw-semibold fs-6">Basılı kitap satın alabileceğiniz bölgenizdeki adresleri görmek için tıklayınız</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xxl-6 mb-5">
        <a href="https://serveryayinlari.com/ufka-yolculuk-1" target="_blank" class="card card-xxl-stretch" style="border:0px;background-color:#0fa1ba">
            <div class="card-body d-flex flex-column justify-content-between">
                <i class="ki-duotone ki-element-11 text-white fs-2hx ms-n1 flex-grow-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                <div class="d-flex flex-column">
                    <div class="text-white fw-bold fs-1 mb-0 mt-3">Online Kitap Siparişi</div>
                    <div class="text-white fw-semibold fs-6">Basılı kitabı online olarak sipariş vermek için tıklayınız</div>
                </div>
            </div>
        </a>
    </div>
</div>
<?php if(!empty($books)){ ?>
<div class="toolbar pb-lg-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap p-0">
        <div class="page-title d-flex flex-column">
            <h1 class="d-flex text-white fw-bold" style="font-size:27px;background-color: #23bad2;padding: 10px;border-radius: 10px;opacity: 0.8;"><?= esc($categoryTitle ?? 'Ufka Yolculuk 13'); ?> Dijital Kitapları</h1>
        </div>
    </div>
</div>
<div class="row g-3 mb-10">
    <?php foreach($books as $book){ 
        $bSlug = is_object($book) ? ($book->slug ?? '') : ($book['slug'] ?? '');
        $bName = is_object($book) ? ($book->name ?? '') : ($book['name'] ?? ($book['title'] ?? ''));
        $bImg  = is_object($book) ? ($book->image ?? '') : ($book['image_url'] ?? ($book['image'] ?? ''));
        $bLast = is_object($book) ? ($book->last_page ?? 0) : ($book['last_page'] ?? 0);
        $readUrl = !empty($bSlug) ? base_url('kitap-oku/' . $bSlug) : '#';
        $imgUrl = (strpos($bImg, 'http') === 0) ? $bImg : base_url(ltrim($bImg, '/'));
    ?>
    <div class="col-sm-6 col-xxl-3">
        <div class="card card-flush">
            <div class="card-body text-center pb-5">
                <a class="d-block overlay" href="<?= $readUrl; ?>">
                    <div class="overlay-wrapper bgi-no-repeat card-rounded mb-7" style="background-position: center;background-size: cover;height: 360px;background-image:url('<?= esc($imgUrl); ?>')"></div>
                    <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                        <i class="ki-duotone ki-eye fs-3x text-white">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </div>
                </a>
                <div class="d-flex align-items-end flex-stack mb-1">
                    <div class="text-start">
                        <span class="fw-bold text-gray-800 cursor-pointer text-hover-primary fs-4 d-block" style="min-height:50px"><?= esc($bName); ?></span>
                        <span class="text-gray-500 mt-1 fw-bold fs-6"><?= $bLast; ?> Sayfa Okudum</span>
                    </div>
                    <span class="text-end fw-bold fs-6 text-success">Ücretsiz</span>
                </div>
            </div>
            <div class="card-footer d-flex flex-stack pt-0">
                <a href="<?= $readUrl; ?>" class="btn btn-sm btn-primary flex-shrink-0 me-2 w-100">Okumaya Başla</a>
            </div>
        </div>
    </div>
    <?php } ?>
</div>
<?php } ?>
<?= $this->endSection() ?>
