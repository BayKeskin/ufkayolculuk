<?= $this->extend('themes/classic/layouts/main') ?>

<?= $this->section('content') ?>
<?php
$title = $page['title'] ?? 'Sayfa Detayı';
$content = $page['content'] ?? ($page['body'] ?? '');
$date = !empty($page['created_at']) ? date('d.m.Y', strtotime($page['created_at'])) : '';
?>
<div class="card shadow-sm border-0 mb-5">
    <div class="card-header border-bottom py-4 d-flex justify-content-between align-items-center">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 fs-8">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>">Ana Sayfa</a></li>
                    <li class="breadcrumb-item active"><?= esc($title) ?></li>
                </ol>
            </nav>
            <h1 class="fw-bold text-gray-900 fs-3 m-0"><?= esc($title) ?></h1>
        </div>
        <?php if (!empty($date)): ?>
            <span class="badge badge-light-secondary fs-8"><?= esc($date) ?></span>
        <?php endif; ?>
    </div>
    <div class="card-body p-6 fs-6 text-gray-800 line-height-lg">
        <?= $content ?>
    </div>
    <div class="card-footer border-top py-3 text-end">
        <a href="javascript:history.back()" class="btn btn-sm btn-light">← Geri Dön</a>
    </div>
</div>
<?= $this->endSection() ?>
