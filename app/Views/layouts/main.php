<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?= esc($title ?? 'Ufka Yolculuk - Bilgi ve Kültür Yarışması') ?></title>
  <meta name="description"
    content="<?= esc($meta_description ?? 'Ufka Yolculuk Bilgi ve Kültür Yarışması resmi web sitesi. Kitap oku, soruları çöz, puan topla ve birbirinden değerli ödüller kazan!') ?>">
  <meta name="theme-color" content="#F5A623">

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo.png') ?>">

  <!-- Google Fonts: Plus Jakarta Sans & Inter & Outfit -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,700&family=Inter:wght@400;500;600;700;800&family=Outfit:wght@600;700;800;900&display=swap"
    rel="stylesheet">

  <!-- CSS Varlıkları -->
  <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css?v=3.1') ?>">

  <?= $this->renderSection('styles') ?>

  <!-- JS Varlıkları (Defer ile PageSpeed Uyumlu) -->
  <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>" defer></script>
  <script src="<?= base_url('assets/js/main.js?v=3.5') ?>" defer></script>
  <script>
    window.BASE_URL = '<?= rtrim(base_url(), '/') . '/' ?>';
  </script>
</head>

<body>

  <!-- Header & Navigation -->
  <?= $this->include('partials/header') ?>

  <!-- Ana İçerik -->
  <main id="main-content">
    <?= $this->renderSection('content') ?>
  </main>

  <!-- Footer -->
  <?= $this->include('partials/footer') ?>

  <!-- Modallar -->
  <?= $this->include('partials/modals') ?>

  <?= $this->renderSection('scripts') ?>

</body>

</html>
