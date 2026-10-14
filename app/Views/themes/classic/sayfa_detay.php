<?= $this->extend('themes/classic/layouts/main') ?>

<?= $this->section('content') ?>
<?php
$pageTitle = $page['title'] ?? ($content['title'] ?? ($title ?? 'Sayfa Detayı'));
$body = $page['content'] ?? ($content['body'] ?? ($content['content'] ?? ''));
$pageImage = $page['image'] ?? ($content['image'] ?? '');
$createTime = $page['created_at'] ?? ($content['create_time'] ?? '');
?>
<div class="toolbar pb-lg-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap p-0">
        <div class="page-title d-flex flex-column">
            <h1 class="d-flex text-white fw-bold" style="font-size:27px;background-color: #23bad2;padding: 10px;border-radius: 10px;opacity: 0.8;"><?= esc($pageTitle); ?></h1>
        </div>
    </div>
</div>
<div class="content flex-row-fluid" id="kt_content">
    <div id="scrollAlert" class="alert alert-info mt-3 d-none" role="alert">
    👉 İçeriği sağa kaydırabilirsiniz.
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body" id="scrollCheck" style="font-size:18px;overflow:scroll">
            <?php if(!empty($createTime)){ ?>
            <div class="col-12 float-end text-end fs-6 text-muted mb-4">Oluşturma Zamanı: <?= date("d.m.Y H:i", strtotime($createTime)); ?></div>
            <?php } ?>
            
            <?php
            if(!empty($pageImage)){
                $cImgUrl = (strpos($pageImage, 'http') === 0) ? $pageImage : (file_exists(FCPATH . ltrim($pageImage, '/')) ? base_url(ltrim($pageImage, '/')) : 'https://ufkayolculuk.com/' . ltrim($pageImage, '/'));
                echo "<img src='".esc($cImgUrl)."' style='width:35%; float:left; margin:0 30px 20px 0; border-radius: 8px;' alt='".esc($pageTitle)."'>";
            }
            ?>
            <div class="page-html-content">
                <?= $body; ?>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
      const el = document.getElementById("scrollCheck");
      const alertBox = document.getElementById("scrollAlert");
      if (el && alertBox && el.scrollWidth > el.clientWidth) {
        alertBox.classList.remove("d-none");
      }
    });
</script>
<?= $this->endSection() ?>
