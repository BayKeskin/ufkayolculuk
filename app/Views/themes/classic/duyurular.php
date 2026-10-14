<?= $this->extend('themes/classic/layouts/main') ?>

<?= $this->section('content') ?>
<?php
$pageTitle = $title ?? 'Duyurular ve Haberler';
$postList = !empty($announcements) ? $announcements : (!empty($posts) ? $posts : []);
?>
<div class="toolbar pb-lg-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap p-0">
        <div class="page-title d-flex flex-column">
            <h1 class="d-flex text-white fw-bold" style="font-size:27px;background-color: #23bad2;padding: 10px;border-radius: 10px;opacity: 0.8;"><?= esc($pageTitle); ?></h1>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body p-lg-20">
        <div class="mb-17">
            <div class="row g-10">
                <?php foreach($postList as $post){ 
                    $pTitle = is_object($post) ? ($post->title ?? '') : ($post['title'] ?? '');
                    $pSlug  = is_object($post) ? ($post->slug ?? '') : ($post['slug'] ?? ($post['id'] ?? '#'));
                    $pDesc  = is_object($post) ? ($post->description ?? ($post->summary ?? '')) : ($post['summary'] ?? ($post['description'] ?? ''));
                    $pImg   = is_object($post) ? ($post->image ?? '') : ($post['image'] ?? ($post['thumbnail'] ?? ''));
                    
                    if (empty($pImg)) {
                        $pImg = 'uploads/2025-09/ufkayolculuk_68d95b85a51b6.webp';
                    }
                    $image = (strpos($pImg, 'http') === 0) ? $pImg : (file_exists(FCPATH . ltrim($pImg, '/')) ? base_url(ltrim($pImg, '/')) : 'https://ufkayolculuk.com/' . ltrim($pImg, '/'));
                ?>
                <div class="col-md-4">
                    <div class="card-xl-stretch me-md-6 mb-8">
                        <a class="d-block overlay" href="<?= base_url('sayfa/' . ltrim($pSlug, '/')); ?>">
                            <div class="overlay-wrapper bgi-no-repeat card-rounded" style="background-image:url('<?= esc($image); ?>');min-height: 175px;width: 100%;background-position: center;background-size: cover;"></div>
                            <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                <i class="ki-duotone ki-eye fs-2x text-white">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </div>
                        </a>
                        <div class="mt-5">
                            <a href="<?= base_url('sayfa/' . ltrim($pSlug, '/')); ?>" class="fs-4 text-gray-900 fw-bold text-hover-primary lh-base"><?= esc($pTitle); ?></a>
                            <?php if(!empty($pDesc)){
                                echo '<div class="fw-semibold fs-5 text-gray-600 mt-3">'.esc(strip_tags($pDesc)).'</div>';
                            } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
