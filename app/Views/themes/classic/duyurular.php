<?= $this->extend('themes/classic/layouts/main') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm border-0 mb-5">
    <div class="card-header border-bottom py-4">
        <h2 class="card-title fw-bold text-gray-900 m-0">Duyurular & Haberler</h2>
        <div class="card-toolbar">
            <span class="badge badge-light-primary fw-bold">Toplam: <?= count($announcements ?? []) ?></span>
        </div>
    </div>
    <div class="card-body p-5">
        <?php if (!empty($announcements)): ?>
            <div class="d-flex flex-column gap-4">
                <?php foreach ($announcements as $item): 
                    $slug = $item['slug'] ?? ($item['id'] ?? '#');
                    $link = base_url('sayfa/' . $slug);
                    $date = !empty($item['created_at']) ? date('d.m.Y H:i', strtotime($item['created_at'])) : date('d.m.Y');
                    $title = $item['title'] ?? 'Duyuru';
                    $desc = !empty($item['summary']) ? $item['summary'] : strip_tags(mb_substr($item['content'] ?? '', 0, 160) . '...');
                ?>
                    <div class="p-4 rounded-3 border bg-white shadow-xs d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                        <div>
                            <span class="badge badge-light-info fw-semibold mb-2"><?= esc($date) ?></span>
                            <h4 class="fw-bold mb-1">
                                <a href="<?= esc($link) ?>" class="text-gray-900 text-hover-primary text-decoration-none"><?= esc($title) ?></a>
                            </h4>
                            <p class="text-muted fs-7 mb-0"><?= esc($desc) ?></p>
                        </div>
                        <a href="<?= esc($link) ?>" class="btn btn-sm btn-light-primary fw-bold text-nowrap">Devamını Oku</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5 text-muted">Henüz yayınlanmış duyuru bulunmamaktadır.</div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
