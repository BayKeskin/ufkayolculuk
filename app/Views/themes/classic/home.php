<?= $this->extend('themes/classic/layouts/main') ?>

<?= $this->section('content') ?>
<style>
.ribbon.live {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #28a745;
    color: #fff;
    padding: 5px 40px;
    font-size: 13px;
    font-weight: bold;
    box-shadow: 0 3px 6px rgba(0,0,0,0.2);
    border-radius: 5px;
    animation: blink 1s infinite;
}
@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0; }
}
.card-hover-scale {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.card-hover-scale:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
</style>

<div class="row g-5 g-xl-8">
    <div class="col-xl-8 order-2 order-md-1">
        
        <!-- Üst Hızlı Erişim Kartları -->
        <div class="row gx-5 gx-xl-8 mb-4">
            <div class="col-md-4 mb-4">
                <a href="<?= base_url('oduller') ?>" class="card card-xxl-stretch card-hover-scale text-decoration-none shadow-sm" style="border:0px;background-color:#0fa1ba">
                    <div class="card-body d-flex flex-column justify-content-between p-6">
                        <i class="ki-duotone ki-element-11 text-white fs-2hx mb-3">
                            <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span>
                        </i>
                        <div class="d-flex flex-column">
                            <div class="text-white fw-bold fs-2 mb-1">Ödüller</div>
                            <div class="text-white text-opacity-75 fw-semibold fs-7">Tüm ödülleri keşfedin</div>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-md-4 mb-4">
                <a href="<?= base_url('oduller') ?>" class="card card-xxl-stretch card-hover-scale text-decoration-none shadow-sm" style="border:0px;background-color:#20b2aa">
                    <div class="card-body d-flex flex-column justify-content-between p-6">
                        <i class="ki-duotone ki-book-open text-white fs-2hx mb-3">
                            <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span>
                        </i>
                        <div class="d-flex flex-column">
                            <div class="text-white fw-bold fs-2 mb-1">Yarışma Kitapları</div>
                            <div class="text-white text-opacity-75 fw-semibold fs-7">Kategorinize uygun kitapları inceleyin</div>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-md-4 mb-4">
                <a href="https://minideneme.ufkayolculuk.com" target="_blank" class="card card-xxl-stretch card-hover-scale position-relative text-decoration-none shadow-sm" style="border:0px;background-color:cadetblue">
                    <div class="ribbon live">TIKLA GİR</div>
                    <div class="card-body d-flex flex-column justify-content-between p-6">
                        <i class="ki-duotone ki-medal-star text-white fs-2hx mb-3">
                            <span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span>
                        </i>
                        <div class="d-flex flex-column pe-8">
                            <div class="text-white fw-bold fs-2 mb-1">Mini Deneme</div>
                            <div class="text-white text-opacity-75 fw-semibold fs-7">7/24 kendinizi test edin</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Duyurular & Takvim Alanı -->
        <div class="row gx-5 gx-xl-8 mb-5 mb-xl-8">
            <div class="col-xl-6 mb-5 mb-xl-0">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header position-relative py-0 border-bottom">
                        <ul class="nav nav-stretch nav-pills nav-pills-custom d-flex mt-3" role="tablist">
                            <li class="nav-item p-0 ms-0 me-6">
                                <a class="nav-link btn btn-color-muted px-0 active" data-bs-toggle="pill" href="#tab_duyurular">
                                    <span class="nav-text fw-bold fs-5 mb-3">Duyurular</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-5">
                        <div class="tab-content" id="mainPageTabs">
                            <div class="tab-pane fade show active" id="tab_duyurular">
                                <div class="d-flex flex-column gap-3">
                                    <?php if (!empty($announcements)): ?>
                                        <?php foreach (array_slice($announcements, 0, 4) as $item): 
                                            $slug = $item['slug'] ?? ($item['id'] ?? '#');
                                            $link = base_url('sayfa/' . $slug);
                                            $date = !empty($item['created_at']) ? date('d.m.Y', strtotime($item['created_at'])) : date('d.m.Y');
                                            $initial = mb_substr($item['title'] ?? 'U', 0, 1, 'UTF-8');
                                        ?>
                                            <div class="d-flex align-items-center justify-content-between p-3 rounded-2 bg-light-primary bg-opacity-50">
                                                <div class="d-flex align-items-center me-3">
                                                    <div class="symbol symbol-40px me-3">
                                                        <div class="symbol-label fs-5 fw-bold bg-primary text-white rounded-circle" style="width:38px;height:38px;display:flex;align-items:center;justify-content:center">
                                                            <?= esc($initial) ?>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <a href="<?= esc($link) ?>" class="text-gray-900 text-hover-primary fw-bold fs-6 d-block text-truncate" style="max-width: 260px;">
                                                            <?= esc($item['title'] ?? 'Duyuru') ?>
                                                        </a>
                                                        <span class="text-muted fs-8 fw-semibold"><?= esc($date) ?></span>
                                                    </div>
                                                </div>
                                                <a href="<?= esc($link) ?>" class="btn btn-sm btn-icon btn-light-primary" title="Detay">
                                                    <i class="fas fa-chevron-right fs-8"></i>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="text-muted text-center py-5">Güncel duyuru bulunmamaktadır.</div>
                                    <?php endif; ?>
                                </div>
                                <div class="text-end mt-4">
                                    <a href="<?= base_url('duyurular') ?>" class="btn btn-sm btn-light-primary fw-bold">Tüm Duyurular</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Takvim (Önemli Tarihler) -->
            <div class="col-xl-6">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header align-items-center border-bottom py-3">
                        <h3 class="card-title m-0">
                            <span class="fw-bold text-gray-900 fs-5">Takvim & Önemli Tarihler</span>
                        </h3>
                    </div>
                    <div class="card-body pt-4">
                        <div class="timeline-label">
                            <?php if (!empty($importantDates)): ?>
                                <?php foreach (array_slice($importantDates, 0, 6) as $idx => $dateItem): 
                                    $badgeColor = ($idx % 2 === 0) ? 'text-primary' : 'text-success';
                                    $dateStr = $dateItem['date_formatted'] ?? ($dateItem['date'] ?? '');
                                    $titleStr = $dateItem['title'] ?? ($dateItem['name'] ?? '');
                                ?>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="badge bg-light-primary text-primary fw-bold fs-8 px-2 py-1 me-3" style="min-width: 80px; text-align: center;">
                                            <?= esc($dateStr) ?>
                                        </div>
                                        <div class="text-gray-800 fw-semibold fs-7 flex-grow-1">
                                            <?= esc($titleStr) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="badge bg-light-warning text-warning fw-bold fs-8 px-2 py-1 me-3">29 Eylül</div>
                                    <div class="text-gray-800 fs-7">Yarışma Kayıtlarının Başlangıcı</div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="badge bg-light-primary text-primary fw-bold fs-8 px-2 py-1 me-3">8 Şubat</div>
                                    <div class="text-gray-800 fs-7">Online Deneme Sınavı</div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="badge bg-light-danger text-danger fw-bold fs-8 px-2 py-1 me-3">6 Mart</div>
                                    <div class="text-gray-800 fs-7">Yarışma Kayıtlarının Bitişi</div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="badge bg-light-success text-success fw-bold fs-8 px-2 py-1 me-3">14-15 Mart</div>
                                    <div class="text-gray-800 fs-7 fw-bold">Yarışma Sınavları</div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kitaplar Vitrini -->
        <?php if (!empty($categories)): ?>
            <div class="card shadow-sm border-0 mb-5">
                <div class="card-header align-items-center border-bottom py-3">
                    <h3 class="card-title m-0">
                        <span class="fw-bold text-gray-900 fs-5">Yarışma Kategorileri ve Kitapları</span>
                    </h3>
                </div>
                <div class="card-body p-5">
                    <div class="row g-4">
                        <?php foreach ($categories as $slug => $cat): 
                            $book = $cat['book'] ?? [];
                            $img = $book['image_url'] ?? ($cat['fallback_image'] ?? '');
                            $title = $book['name'] ?? ($cat['title'] ?? '');
                        ?>
                            <div class="col-6 col-md-3 text-center">
                                <div class="p-2 rounded-3 bg-light h-100 d-flex flex-column justify-content-between">
                                    <?php if (!empty($img)): ?>
                                        <img src="<?= esc($img) ?>" alt="<?= esc($title) ?>" class="img-fluid rounded mb-2 shadow-sm" style="max-height: 160px; object-fit: contain; margin: 0 auto;">
                                    <?php endif; ?>
                                    <div class="fw-bold fs-7 text-gray-800 mt-2"><?= esc($cat['title'] ?? '') ?></div>
                                    <div class="text-muted fs-8"><?= esc($cat['grade'] ?? '') ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- Sağ Kolon: Geri Sayım & Slider -->
    <div class="col-xl-4 order-1 order-md-2">
        
        <!-- Sayaç / Bilgi Kutusu -->
        <div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(135deg, #6b56a1 0%, #4e3c79 100%);">
            <div class="card-body p-5 text-white">
                <div class="d-flex align-items-center mb-3">
                    <i class="ki-duotone ki-calendar-tick fs-2x text-warning me-2"></i>
                    <h4 class="text-white fw-bold m-0 fs-5">13. Ufka Yolculuk</h4>
                </div>
                <p class="fs-7 text-white text-opacity-75 mb-3">
                    "İlk Sözleşmeni Hatırla!" temasıyla düzenlenen Türkiye'nin en geniş katılımlı kitap okuma yarışması.
                </p>
                <div class="d-flex justify-content-between text-center gap-2" id="classic-counter">
                    <div class="bg-white bg-opacity-20 rounded p-2 flex-grow-1">
                        <span class="fs-3 fw-bold d-block" id="count-d">14</span>
                        <span class="fs-8 text-white-50">Gün</span>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded p-2 flex-grow-1">
                        <span class="fs-3 fw-bold d-block" id="count-h">08</span>
                        <span class="fs-8 text-white-50">Saat</span>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded p-2 flex-grow-1">
                        <span class="fs-3 fw-bold d-block" id="count-m">45</span>
                        <span class="fs-8 text-white-50">Dakika</span>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded p-2 flex-grow-1">
                        <span class="fs-3 fw-bold d-block" id="count-s">20</span>
                        <span class="fs-8 text-white-50">Saniye</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slider Carousel -->
        <?php if (!empty($sliders)): ?>
            <div class="card shadow-sm border-0 overflow-hidden mb-4">
                <div id="classicHeroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                    <div class="carousel-inner">
                        <?php foreach ($sliders as $idx => $slider): 
                            $active = ($idx === 0) ? 'active' : '';
                            $imgPath = $slider['image_url'] ?? ($slider['path'] ?? '');
                            $link = $slider['link'] ?? '#';
                        ?>
                            <div class="carousel-item <?= $active ?>">
                                <a href="<?= esc($link) ?>">
                                    <img src="<?= esc($imgPath) ?>" class="d-block w-100" alt="Slider <?= $idx + 1 ?>">
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($sliders) > 1): ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#classicHeroCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Önceki</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#classicHeroCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Sonraki</span>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Hızlı Kayıt Butonu -->
        <div class="card shadow-sm border-0 mb-4 bg-light-primary text-center p-5">
            <h5 class="fw-bold text-primary mb-2">Hemen Başvur!</h5>
            <p class="fs-7 text-muted mb-4">Yarışmaya kaydolun, ödülleri kazanma şansını yakalayın.</p>
            <a href="<?= base_url('kayit') ?>" class="btn btn-primary fw-bold py-3">Ücretsiz Kayıt Ol</a>
        </div>

    </div>
</div>

<script>
// Canlı sayaç geri sayım simülasyonu
document.addEventListener("DOMContentLoaded", function () {
    let d = 14, h = 8, m = 45, s = 20;
    setInterval(function () {
        s--;
        if (s < 0) { s = 59; m--; }
        if (m < 0) { m = 59; h--; }
        if (h < 0) { h = 23; d--; }
        if (d < 0) { d = 0; h = 0; m = 0; s = 0; }
        const elD = document.getElementById("count-d");
        const elH = document.getElementById("count-h");
        const elM = document.getElementById("count-m");
        const elS = document.getElementById("count-s");
        if (elD) elD.innerText = d;
        if (elH) elH.innerText = (h < 10 ? '0' : '') + h;
        if (elM) elM.innerText = (m < 10 ? '0' : '') + m;
        if (elS) elS.innerText = (s < 10 ? '0' : '') + s;
    }, 1000);
});
</script>
<?= $this->endSection() ?>
