<?= $this->extend('themes/classic/layouts/main') ?>

<?= $this->section('content') ?>
<div class="text-center mb-5">
    <h1 class="fw-bold display-5">🏆 Yarışma Ödülleri</h1>
    <p class="fs-5">Türkiye Geneli ödüller sabit görünür. İl, ilçe ve okul ödülleri seçim yapıldığında listelenir.</p>
</div>
<div class="row">
    <div class="col-12 col-md-6 mb-5">
        <div class="card card-flush mb-xxl-10 ">
            <div class="card-header pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-900">Türkiye Geneli Ödüller</span>
                    <span class="text-gray-500 pt-2 fw-semibold fs-6">Ödülleri görmek istediğiniz kategori sekmesine tıklayınız.</span>
                </h3>
            </div>
            <div class="card-body">
                <ul class="nav nav-pills nav-pills-custom mb-3" role="tablist">
                    <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                        <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden w-80px py-4 active" data-bs-toggle="pill" href="#kt_stats_widget_1_tab_1" aria-selected="false" role="tab" tabindex="-1">
                            <span class="nav-text text-gray-700 fw-bold fs-6 lh-1">İlkokul</span>
                            <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                        </a>
                    </li>
                    <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                        <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden w-80px py-4" data-bs-toggle="pill" href="#kt_stats_widget_1_tab_2" aria-selected="false" role="tab" tabindex="-1">
                            <span class="nav-text text-gray-700 fw-bold fs-6 lh-1">Ortaokul</span>
                            <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                        </a>
                    </li>
                    <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                        <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden w-80px py-4" data-bs-toggle="pill" href="#kt_stats_widget_1_tab_3" aria-selected="false" role="tab" tabindex="-1">
                            <span class="nav-text text-gray-600 fw-bold fs-6 lh-1">Lise</span>
                            <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                        </a>
                    </li>
                    <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                        <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden w-80px py-4" data-bs-toggle="pill" href="#kt_stats_widget_1_tab_4" aria-selected="true" role="tab">
                            <span class="nav-text text-gray-600 fw-bold fs-6 lh-1">Yetişkin</span>
                            <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                        </a>
                    </li>
                    <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                        <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden w-80px py-4" data-bs-toggle="pill" href="#kt_stats_widget_1_tab_5" aria-selected="true" role="tab">
                            <span class="nav-text text-gray-600 fw-bold fs-6 lh-1">İlahiyat</span>
                            <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                        </a>
                    </li>
                    <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                        <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden w-120px py-4" data-bs-toggle="pill" href="#kt_stats_widget_1_tab_6" aria-selected="false" role="tab" tabindex="-1">
                            <span class="nav-text text-gray-600 fw-bold fs-6 lh-1">Takım Lideri (MEB)</span>
                            <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                        </a>
                    </li>
                    <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                        <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden w-120px py-4" data-bs-toggle="pill" href="#kt_stats_widget_1_tab_7" aria-selected="true" role="tab">
                            <span class="nav-text text-gray-600 fw-bold fs-6 lh-1">Takım Lideri (STK)</span>
                            <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                        </a>
                    </li>
                    <li class="nav-item mb-3 me-3 me-lg-6" role="presentation">
                        <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden w-120px py-4" data-bs-toggle="pill" href="#kt_stats_widget_1_tab_8" aria-selected="true" role="tab">
                            <span class="nav-text text-gray-600 fw-bold fs-6 lh-1">Takım Lideri (Bağımsız)</span>
                            <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <?php
                    $tabMap = [
                        1 => 'ilkokul',
                        2 => 'ortaokul',
                        3 => 'lise',
                        4 => 'yetiskin',
                        5 => 'ilahiyat',
                        6 => 'meb',
                        7 => 'stk',
                        8 => 'bagimsiz',
                    ];
                    foreach ($tabMap as $tabNum => $catKey):
                        $isActive = ($tabNum === 1) ? 'active show' : '';
                        $catData = $nationalAwards[$catKey] ?? [];
                        $podium = $catData['podium'] ?? [];
                        $tiles = $catData['tiles'] ?? [];
                    ?>
                    <div class="tab-pane fade <?= $isActive ?>" id="kt_stats_widget_1_tab_<?= $tabNum ?>" role="tabpanel">
                        <div class="row">
                            <?php if (!empty($podium['gold']['prize'])): ?>
                                <div class="col-6 text-gray-800 fw-bold text-hover-primary mb-1 fs-6 p-1" style="border-bottom:1px dashed #99a1b7">
                                    <div class="row"><div class="col-3">1.</div><div class="col-9"><?= esc($podium['gold']['prize']) ?></div></div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($podium['silver']['prize'])): ?>
                                <div class="col-6 text-gray-800 fw-bold text-hover-primary mb-1 fs-6 p-1" style="border-bottom:1px dashed #99a1b7">
                                    <div class="row"><div class="col-3">2.</div><div class="col-9"><?= esc($podium['silver']['prize']) ?></div></div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($podium['bronze']['prize'])): ?>
                                <div class="col-6 text-gray-800 fw-bold text-hover-primary mb-1 fs-6 p-1" style="border-bottom:1px dashed #99a1b7">
                                    <div class="row"><div class="col-3">3.</div><div class="col-9"><?= esc($podium['bronze']['prize']) ?></div></div>
                                </div>
                            <?php endif; ?>
                            <?php foreach ($tiles as $tile): ?>
                                <div class="col-6 text-gray-800 fw-bold text-hover-primary mb-1 fs-6 p-1" style="border-bottom:1px dashed #99a1b7">
                                    <div class="row"><div class="col-3"><?= esc($tile['rank_label'] ?? '') ?></div><div class="col-9"><?= esc($tile['prize'] ?? '') ?></div></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card card-flush mb-xxl-10 ">
            <div class="card-header pt-5">
                <div class="row w-100">
                    <div class="col-6">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-gray-900">Yerel Ödüller</span>
                            <span class="text-gray-500 pt-2 fw-semibold fs-6">Ödülleri görmek istediğiniz ili seçiniz.</span>
                        </h3>
                    </div>
                    <div class="col-6">
                        <select name="city_id" id="city_id" class="form-select mt-2">
                            <option value="">İl Seçiniz</option>
                            <?php 
                            $cityList = $cities ?? [];
                            foreach ($cityList as $city) {
                                $cName = is_array($city) ? ($city['name'] ?? '') : (is_object($city) ? $city->name : $city);
                                $cId   = is_array($city) ? ($city['id'] ?? $cName) : (is_object($city) ? $city->id : $cName);
                                echo "<option value='".esc($cName)."'>".esc($cName)."</option>";
                            } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="city_contact_area">
                    <div class="alert alert-info" role="alert">
                        <h4 class="m-0">Lütfen Yukarıdaki Kutucuktan İl Seçimi Yapınız</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$('#city_id').change(function(){
    var cityName = $(this).val();
    if (!cityName) return;
    $.get("<?= base_url('oduller/cityAwardsAjax'); ?>/" + encodeURIComponent(cityName), function(data){
        var html = '<h4 class="mb-4 text-primary fw-bold">' + cityName + ' İli Başarı Ödülleri</h4>';
        if (data && data.podium) {
            html += '<div class="row g-3">';
            if (data.podium.gold) html += '<div class="col-12 p-2 border-bottom"><strong>1.lik:</strong> ' + data.podium.gold.prize + '</div>';
            if (data.podium.silver) html += '<div class="col-12 p-2 border-bottom"><strong>2.lik:</strong> ' + data.podium.silver.prize + '</div>';
            if (data.podium.bronze) html += '<div class="col-12 p-2 border-bottom"><strong>3.lük:</strong> ' + data.podium.bronze.prize + '</div>';
            html += '</div>';
        } else if (data && data.raw && data.raw.length > 0) {
            html += '<div class="row g-3">';
            $.each(data.raw, function(i, item){
                html += '<div class="col-12 p-2 border-bottom">' + (item.award || item.title) + '</div>';
            });
            html += '</div>';
        } else {
            html += '<div class="alert alert-warning">Bu il için yerel ödül kaydı henüz eklenmemiştir.</div>';
        }
        $('#city_contact_area').html(html);
    });
});
</script>
<?= $this->endSection() ?>
