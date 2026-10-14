<?= $this->extend('themes/classic/layouts/main') ?>

<?= $this->section('content') ?>
<style>
.ribbon {
  position: absolute;
  top: 10px;
  right: 10px;
  background: #ff4757;
  color: #fff;
  padding: 5px 70px;
  font-size: 14px;
  font-weight: bold;
  box-shadow: 0 3px 6px rgba(0,0,0,0.2);
  border-radius: 5px;
}
.ribbon.live {
    position: absolute;
    top: 10px;
    right: 10px;
    background: #28a745; /* Yeşil */
    color: #fff;
    padding: 5px 70px;
    font-size: 14px;
    font-weight: bold;
    box-shadow: 0 3px 6px rgba(0,0,0,0.2);
    border-radius: 5px;
    animation: blink 1s infinite; /* Yanıp sönme efekti */
}

/* Yanıp sönme animasyonu */
@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0; }
}
</style>

<div class="row g-5 g-xl-8">
    <div class="col-xl-8 order-2 order-md-1">
        <div class="row gx-5 gx-xl-8 mb-2">
            <div class="col-xxl-3 mb-5">
                <a href="<?=base_url('oduller');?>" class="card card-xxl-stretch" style="border:0px;background-color:#0fa1ba">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <i class="ki-duotone ki-element-11 text-white fs-2hx ms-n1 flex-grow-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                        <div class="d-flex flex-column">
                            <div class="text-white fw-bold fs-1 mb-0 mt-3">Ödüller</div>
                            <div class="text-white fw-semibold fs-6">Tüm Ödüller için Tıklayınız</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xxl-3 mb-5">
                <a href="<?=base_url('kitaplar');?>" class="card card-xxl-stretch" style="border:0px;background-color:#0fa1ba">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <i class="ki-duotone ki-element-11 text-white fs-2hx ms-n1 flex-grow-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                        <div class="d-flex flex-column">
                            <div class="text-white fw-bold fs-1 mb-0 mt-3">Kitaplar</div>
                            <div class="text-white fw-semibold fs-6">Seçtiğiniz Kitabı Online Okuyun</div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xxl-6 mb-5 mb-xl-0">
                <?php 
                $dlink = "https://minideneme.ufkayolculuk.com";
                ?>
                <a href="<?=$dlink;?>" target="_blank" class="card card-xxl-stretch position-relative" style="border:0px;background-color:cadetblue">
                    <div class="ribbon live">TIKLA GİR</div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <i class="ki-duotone ki-element-11 text-white fs-2hx ms-n1 flex-grow-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                        <div class="d-flex flex-column">
                            <div class="text-white fw-bold fs-1 mb-0 mt-3">Mini Deneme Sınavları</div>
                            <div class="text-white fw-semibold fs-6">5 Soruluk mini deneme sınavları ile kendizi 7/24 test edebilirsiniz.</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="row gx-5 gx-xl-8 mb-5 mb-xl-8">
            <div class="col-xl-6">
                <div class="card h-xl-100">
                    <div class="card-header position-relative py-0 border-bottom-2">
                        <ul class="nav nav-stretch nav-pills nav-pills-custom d-flex mt-3">
                            <li class="nav-item p-0 ms-0 me-8">
                                <a class="nav-link btn btn-color-muted px-0 show active" data-bs-toggle="tab" href="#kt_table_widget_7_tab_content_1">
                                    <span class="nav-text fw-semibold fs-4 mb-3">Duyurular</span>
                                    <span class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                                </a>
                            </li>
                            <li class="nav-item p-0 ms-0 me-8">
                                <a class="nav-link btn btn-color-muted px-0" data-bs-toggle="tab" href="#kt_table_widget_7_tab_content_2">
                                    <span class="nav-text fw-semibold fs-4 mb-3">Haberler</span>
                                    <span class="bullet-custom position-absolute z-index-2 w-100 h-2px top-100 bottom-n100 bg-primary rounded"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content mb-2" id="mainPageTabs">
                            <div class="tab-pane fade show active" id="kt_table_widget_7_tab_content_1">
                                <div class="row">
                                    <?php 
                                    $annList = !empty($annoucements) ? $annoucements : (!empty($announcements) ? $announcements : []);
                                    foreach($annList as $content){ 
                                        $cTitle = is_object($content) ? ($content->title ?? '') : ($content['title'] ?? '');
                                        $cSlug  = is_object($content) ? ($content->slug ?? '') : ($content['slug'] ?? '');
                                        $cDate  = is_object($content) ? ($content->create_time ?? ($content->created_at ?? date('Y-m-d H:i'))) : ($content['created_at'] ?? ($content['create_time'] ?? date('Y-m-d H:i')));
                                        $letter = strtoupper(mb_substr($cTitle, 0, 1, 'UTF-8'));
                                    ?>
                                        <div class="d-flex flex-stack">
                                            <div class="symbol symbol-40px me-4">
                                                <div class="symbol-label fs-2 fw-semibold bg-danger text-inverse-danger"><?= esc($letter) ?></div>
                                            </div>
                                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                                <div class="flex-grow-1 me-2">
                                                    <a href="<?= base_url('bilgi/' . ltrim($cSlug, '/')); ?>" class="text-gray-800 text-hover-primary fs-6 fw-bold"><?= esc($cTitle); ?></a>
                                                    <span class="text-muted fw-semibold d-block fs-7"><?= date("d.m.Y - H:i", strtotime($cDate)); ?></span>
                                                </div>
                                                <a href="<?= base_url('bilgi/' . ltrim($cSlug, '/')); ?>" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                    <i class="ki-duotone ki-arrow-right fs-2"><span class="path1"></span><span class="path2"></span></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="separator separator-dashed my-4"></div>
                                    <?php } ?>
                                </div>
                                <div class="float-end">
                                    <a href="<?=base_url('duyurular');?>" class="btn btn-sm btn-light" >Tümünü Gör</a>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="kt_table_widget_7_tab_content_2">
                                <div class="row">
                                    <?php 
                                    $newsList = !empty($news) ? $news : [];
                                    foreach($newsList as $content){
                                        $cTitle = is_object($content) ? ($content->title ?? '') : ($content['title'] ?? '');
                                        $cSlug  = is_object($content) ? ($content->slug ?? '') : ($content['slug'] ?? '');
                                        $cDate  = is_object($content) ? ($content->create_time ?? ($content->created_at ?? date('Y-m-d H:i'))) : ($content['created_at'] ?? ($content['create_time'] ?? date('Y-m-d H:i')));
                                        $letter = strtoupper(mb_substr($cTitle, 0, 1, 'UTF-8'));
                                    ?>
                                        <div class="d-flex flex-stack">
                                            <div class="symbol symbol-40px me-4">
                                                <div class="symbol-label fs-2 fw-semibold bg-danger text-inverse-danger"><?= esc($letter) ?></div>
                                            </div>
                                            <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                                                <div class="flex-grow-1 me-2">
                                                    <a href="<?= base_url('bilgi/' . ltrim($cSlug, '/')); ?>" class="text-gray-800 text-hover-primary fs-6 fw-bold"><?= esc($cTitle); ?></a>
                                                    <span class="text-muted fw-semibold d-block fs-7"><?= date("d.m.Y - H:i", strtotime($cDate)); ?></span>
                                                </div>
                                                <a href="<?= base_url('bilgi/' . ltrim($cSlug, '/')); ?>" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary w-30px h-30px">
                                                    <i class="ki-duotone ki-arrow-right fs-2"><span class="path1"></span><span class="path2"></span></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="separator separator-dashed my-4"></div>
                                    <?php } ?>
                                </div>
                                <div class="float-end">
                                    <a href="<?=base_url('haberler');?>" class="btn btn-sm btn-light" >Tümünü Gör</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 mt-8 mt-md-0">
                <div class="card card-xl-stretch">
                    <div class="card-header align-items-center border-0 mt-4">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="fw-bold mb-2 text-gray-900">Takvim</span>
                            <span class="text-muted fw-semibold fs-7">Önemli Tarihler</span>
                        </h3>
                        <div class="card-toolbar">
                            <a href="<?=base_url('sayfa/takvimi');?>" class="btn btn-sm btn-light">Detaylı Takvim</a>
                        </div>
                    </div>
                    <div class="card-body pt-5">
                        <div class="timeline-label">
                            <div class="timeline-item">
                                <div class="timeline-label text-gray-800 fs-6">29 Eylül</div>
                                <div class="timeline-badge">
                                    <i class="fa fa-genderless text-warning fs-1"></i>
                                </div>
                                <div class="text-gray-800 ps-3">Ödüllü Sınav için Kayıtların Başlangıcı</div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-label text-gray-800 fs-6">8 Şubat</div>
                                <div class="timeline-badge">
                                    <i class="fa fa-genderless text-warning fs-1"></i>
                                </div>
                                <div class="timeline-content d-flex">
                                    <span class="text-gray-800 ps-3">Deneme Sınavı</span>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-label text-gray-800 fs-6">6 Mart</div>
                                <div class="timeline-badge">
                                    <i class="fa fa-genderless text-warning fs-1"></i>
                                </div>
                                <div class="timeline-content text-gray-800 ps-3">Yarışma Kayıtlarının Bitişi</div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-label fw-bold text-gray-800 fs-6">14 Mart</div>
                                <div class="timeline-badge">
                                    <i class="fa fa-genderless text-danger fs-1"></i>
                                </div>
                                <div class="timeline-content d-flex">
                                    <span class="fw-bold text-gray-800 ps-3"><a href='#'>Lise</a> ve <a href='#'>Ortaokul</a> Sınavı</span>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-label fw-bold text-gray-800 fs-6">15 Mart</div>
                                <div class="timeline-badge">
                                    <i class="fa fa-genderless text-danger fs-1"></i>
                                </div>
                                <div class="timeline-content fw-bold text-gray-800 ps-3"><a href='#'>İlkokul</a>, <a href='#'>Yetişkin ve İlahiyat</a> Sınavı</div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-label text-gray-800 fs-6">15 Mart</div>
                                <div class="timeline-badge">
                                    <i class="fa fa-genderless text-warning fs-1"></i>
                                </div>
                                <div class="timeline-content text-gray-800 ps-3">Cevap Anahtarlarının Yayınlanması</div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-label text-gray-800 fs-6">28 Mart</div>
                                <div class="timeline-badge">
                                    <i class="fa fa-genderless text-warning fs-1"></i>
                                </div>
                                <div class="timeline-content text-gray-800 ps-3">Sonuçların Açıklanması</div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-label text-gray-800 fs-6">4 Nisan</div>
                                <div class="timeline-badge">
                                    <i class="fa fa-genderless text-warning fs-1"></i>
                                </div>
                                <div class="timeline-content text-gray-800 ps-3">Çekilişler</div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-label text-gray-800 fs-6">1-30 Nisan</div>
                                <div class="timeline-badge">
                                    <i class="fa fa-genderless text-success fs-1"></i>
                                </div>
                                <div class="timeline-content text-gray-800 ps-3">Ödül Törenleri</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="justify-content-center mt-5">
                <div id="carousel-source" class="d-none">
                    <a href="<?=base_url('kitaplar');?>">
                        <img src="<?=base_url('uploads/2025-10/ilkokul-2_68dceddcd82c8.webp');?>" alt="Kuşların Çağrısı Kitap Kapağı">
                    </a>
                    <a href="<?=base_url('kitaplar');?>">
                        <img src="<?=base_url('uploads/2025-10/ortaokul-2_68dceddd82b03.webp');?>" alt="Tevhid Muhafızları Kitap Kapağı">
                    </a>
                    <a href="<?=base_url('kitaplar');?>">
                        <img src="<?=base_url('uploads/2025-10/lise-2_68dceddd3a035.webp');?>" alt="Gördüğüme Görmediğime Kitap Kapağı">
                    </a>
                    <a href="<?=base_url('kitaplar');?>">
                        <img src="<?=base_url('uploads/2025-10/yetiskin-2_68dcedddcf390.webp');?>" alt="Nasıl İnanmalı Kitap Kapağı">
                    </a>
                </div>

                <div id="customCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                <div class="carousel-inner">
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#customCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                    <span class="visually-hidden">Önceki</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#customCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                    <span class="visually-hidden">Sonraki</span>
                </button>
                </div>

                <!-- Script: responsive olarak 1 veya 4'lü slide oluşturur -->
                <script>
                document.addEventListener('DOMContentLoaded', function () {
                const carouselEl = document.getElementById('customCarousel');
                if (!carouselEl) return;
                const sourceAnchors = Array.from(document.querySelectorAll('#carousel-source a'));
                const inner = carouselEl.querySelector('.carousel-inner');

                function buildCarousel() {
                    try {
                    const existing = bootstrap.Carousel.getInstance(carouselEl);
                    if (existing) existing.dispose();
                    } catch (e) { }

                    inner.innerHTML = '';
                    const isDesktop = window.innerWidth >= 768;

                    if (isDesktop) {
                        for (let i = 0; i < sourceAnchors.length; i += 4) {
                            const item = document.createElement('div');
                            item.className = 'carousel-item' + (i === 0 ? ' active' : '');

                            const row = document.createElement('div');
                            row.className = 'row';

                            for (let j = 0; j < 4; j++) {
                                const col = document.createElement('div');
                                col.className = 'col-6 col-md-3';

                                if (i + j < sourceAnchors.length) {
                                    const a = sourceAnchors[i + j].cloneNode(true);
                                    const img = a.querySelector('img');
                                    img.classList.add('d-block', 'w-100', 'rounded');
                                    col.appendChild(a);
                                }
                                row.appendChild(col);
                            }

                            item.appendChild(row);
                            inner.appendChild(item);
                        }
                    }
                    else {
                    sourceAnchors.forEach(function(a, idx) {
                        const item = document.createElement('div');
                        item.className = 'carousel-item' + (idx === 0 ? ' active' : '');

                        const row = document.createElement('div');
                        row.className = 'row';

                        const col = document.createElement('div');
                        col.className = 'col-12';

                        const aClone = a.cloneNode(true);
                        const img = aClone.querySelector('img');
                        img.classList.add('d-block','w-100','rounded');

                        col.appendChild(aClone);
                        row.appendChild(col);
                        item.appendChild(row);
                        inner.appendChild(item);
                    });
                    }

                    try {
                    new bootstrap.Carousel(carouselEl, {
                        interval: parseInt(carouselEl.dataset.bsInterval) || 4000,
                        ride: 'carousel'
                    });
                    } catch (e) {
                    console.warn('Bootstrap carousel başlatılamadı:', e);
                    }
                }

                buildCarousel();

                let resizeTimer;
                window.addEventListener('resize', function () {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(function () {
                    buildCarousel();
                    }, 150);
                });
                });
                </script>

            </div>

        </div>
    </div>
    <div class="col-xl-4 order-1">
    <?php if(isset($counter['day']) && $counter['day']>=0){ ?>
        <div class="card bgi-no-repeat bgi-size-contain mb-5 mb-xl-8 order-md-1 order-2" style="background-color: #6b56a1; background-position: right; border:0px">
            <div class="card-body justify-content-between">
                <i class="ki-duotone ki-element-11 text-white fs-2hx ms-n1 flex-grow-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                </i>
                <div class="row">
                    <div class="col-12">
                        <h2 class="text-white fw-bold mb-5 float-start mt-3"><?= !empty($options['counter_text']) ? esc($options['counter_text']) : '13. Ufka Yolculuk'; ?></h2>
                    </div>
                    <div class="col-3">
                        <h3 class="text-white mt-2" style="background-color:#776aaa;padding:14px 4px;text-align:center;border-radius:10px" id="counter-day"><b style="font-size:26px"><?=$counter['day'];?></b><br><span style="font-size:12px">Gün</span></h3>
                    </div>
                    <div class="col-3">
                        <h3 class="text-white mt-2" style="background-color:#776aaa;padding:14px 4px;text-align:center;border-radius:10px" id="counter-hour"><b style="font-size:26px"><?=$counter['hour'];?></b><br><span style="font-size:12px">Saat</span></h3>
                    </div>
                    <div class="col-3">
                        <h3 class="text-white mt-2" style="background-color:#776aaa;padding:14px 4px;text-align:center;border-radius:10px" id="counter-minute"><b style="font-size:26px"><?=$counter['minute'];?></b><br><span style="font-size:12px">Dakika</span></h3>
                    </div>
                    <div class="col-3">
                        <h3 class="text-white mt-2" style="background-color:#776aaa;padding:14px 4px;text-align:center;border-radius:10px" id="counter-second"><b style="font-size:26px"><?=$counter['second'];?></b><br><span style="font-size:12px">Saniye</span></h3>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="card mb-xl-3 order-md-2 order-1" style="overflow:hidden;border:0px">
            <!--begin::Body-->
            <div class="card-body d-flex flex-column p-0">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-indicators">
                    <?php 
                    $sliderList = !empty($sliders) ? $sliders : [];
                    $i=0; foreach($sliderList as $slider){
                        $isActive = $i==0 ? 'class="active" aria-current="true"' : '';
                        echo '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="'.$i.'" '.$isActive.' aria-label="Slide '.($i+1).'"></button>';
                    $i++; }?>
                </div>
                <div class="carousel-inner">
                    <?php $i=0; foreach($sliderList as $slider){
                        $isActive = $i==0 ? 'active' : '';
                        $sLink = is_object($slider) ? ($slider->values->link ?? ($slider->link ?? '')) : ($slider['link'] ?? ($slider['button_1_url'] ?? ''));
                        $sImg  = is_object($slider) ? ($slider->path . $slider->name) : ($slider['image_url'] ?? ($slider['image'] ?? ''));
                        $sImgUrl = (strpos($sImg, 'http') === 0) ? $sImg : base_url(ltrim($sImg, '/'));
                        
                        if(!empty($sLink)){
                            echo "<a href='".esc($sLink)."'>";
                        }
                        echo '<div class="carousel-item '.$isActive.'"><img src="'.esc($sImgUrl).'" class="d-block w-100" alt="Slider '.$i.'"></div>';
                        if(!empty($sLink)){
                            echo "</a>";
                        }
                    $i++; }?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Önceki</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Sonraki</span>
                </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="notifyModal" style="margin-top:50px" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body p-3">
            <?php if(isset($options['popup_image']) && !empty($options['popup_image'])){ ?>
            <a href="<?=isset($options['popup_url'])?$options['popup_url']:'#';?>">
                <img src="<?=base_url($options['popup_image']);?>" style="width:100%" alt="Popup Görseli">
            </a>
            <?php } ?>
        </div>
    </div>
  </div>
</div>

<script>
    <?php if(isset($options['popup_image']) && !empty($options['popup_image'])){ ?>
    document.addEventListener("DOMContentLoaded", function () {
        if (!localStorage.getItem("popup<?=date('Y-m-d');?>")) {
            var myModal = new bootstrap.Modal(document.getElementById("notifyModal"), {});
            myModal.show();
            localStorage.setItem("popup<?=date('Y-m-d');?>", "true");
        }
    });
    <?php } ?>
    window.setInterval(function(){
        let dayA=$('#counter-day').find('b:first');
        let hourA=$('#counter-hour').find('b:first');
        let minuteA=$('#counter-minute').find('b:first');
        let secondA=$('#counter-second').find('b:first');
        let second=parseInt(secondA.text());
        let minute=parseInt(minuteA.text());
        let hour=parseInt(hourA.text());
        let day=parseInt(dayA.text());
        if(second==0){
            second=60;
            minute-=1;
            minuteA.text(minute);
        }
        if(minute<0){
            minute=59;
            minuteA.text(minute);
            hour-=1;
            hourA.text(hour);
        }
        if(hour<0){
            hour=23;
            hourA.text(hour);
            day-=1;
            dayA.text(day);
        }
        secondA.text(second-1);
    }, 1000);
</script>
<?= $this->endSection() ?>
