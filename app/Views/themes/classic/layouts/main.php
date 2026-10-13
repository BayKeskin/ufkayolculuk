<?php
/**
 * Klasik Tema (Metronic M2) Ana Düzeni (Layout) - CodeIgniter 4 Uyumlu
 */
$api = $api ?? new \App\Services\UfkaApiService();
$themeConfig = $themeConfig ?? $api->getThemeConfig();
$visuals = $themeConfig['visual_settings'] ?? [];

$pageTitle = $title ?? 'Ufka Yolculuk - Bilgi ve Kültür Yarışması';
$pageDesc = $meta_description ?? 'Ufka Yolculuk Bilgi ve Kültür Yarışması resmi web sitesi.';
$pageKeywords = 'ufka yolculuk,bilgi yarismasi,inanc,odullu yarisma';

// Menü verisi yoksa API'den çek
if (empty($menu)) {
    try {
        $menu = $api->getMenu('header');
    } catch (\Throwable $e) {
        $menu = [];
    }
}

// Logo belirleme
$headerLogoUrl = !empty($visuals['logo']) ? $visuals['logo'] : base_url('assets/images/logo.png');

// Oturum kullanıcısı
$sessionUser = session()->get('user') ?? null;
$isLoggedIn = !empty($sessionUser) || (session()->get('is_logged_in') == true);
$userName = $sessionUser['name'] ?? (session()->get('name') ?? 'Kullanıcı');
$userSurname = $sessionUser['surname'] ?? (session()->get('surname') ?? '');
$userTypeName = $sessionUser['type_name'] ?? (session()->get('type_name') ?? 'Yarışmacı');
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <title><?= esc($pageTitle) ?> - Ufka Yolculuk</title>
    <meta charset="utf-8" />
    <meta name="description" content="<?= esc($pageDesc) ?>" />
    <meta name="keywords" content="<?= esc($pageKeywords) ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="tr_TR" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= esc($pageTitle) ?>" />
    <meta property="og:url" content="<?= current_url() ?>" />
    <meta property="og:site_name" content="Ufka Yolculuk" />
    
    <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo.png') ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    
    <!-- Metronic M2 CSS Varlıkları -->
    <link href="<?= base_url('assets/m2/plugins/global/plugins.bundle.css?v=3') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url('assets/m2/css/style.bundle.css?v=23') ?>" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="<?= base_url('assets/css/toastr.css') ?>">
    
    <style>
        [data-bs-theme="light"] body:not(.app-blank) {
            background-color: <?= !empty($visuals['background_color']) ? esc($visuals['background_color']) : '#dde6e8' ?>;
        }
        [data-bs-theme="dark"] body:not(.app-blank) {
            background-image: url(<?= base_url('assets/m2/media/patterns/header-bg-dark.jpg') ?>);
        }
        #rightFixedText{
            writing-mode: sideways-lr;text-orientation: sideways;font-size: 25px;font-weight: bold;margin: 0pc;width: 100%;margin-top: 20px;padding: 5px;letter-spacing: 8px;
        }
        #rightFixedButton{
            position:fixed;right:0px;top:300px;width:40px;height:220px;background-color:gold;border-top-left-radius: 10px;border-bottom-left-radius: 10px;z-index:999;
        }
        #mainPageTabs .flex-grow-1{
            max-width:252px;
        }
        @media (max-width: 768px) {
            #rightFixedText {
                font-size: 18px;
                letter-spacing: 4px;
            }
            #rightFixedButton{
                height:150px;
                width:30px;
            }
            #mainPageTabs .flex-grow-1{
                max-width:185px;
            }
        }
        .blink-red{
            color: #ff0000 !important;
            font-weight: 700;
            animation: blinkRed 1s infinite;
        }
        @keyframes blinkRed {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.15; }
        }
        .menuspvars{
            width:275px;
        }
        .header-logo img {
            max-height: 48px;
            width: auto;
        }
    </style>
    
    <!-- jQuery & Bootstrap (Metronic uyumlu) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>" type="text/javascript"></script>

    <?= $this->renderSection('styles') ?>
</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
    <script>
        var defaultThemeMode = "light"; 
        var themeMode = defaultThemeMode;
        if (document.documentElement && document.documentElement.hasAttribute("data-bs-theme-mode")) { 
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); 
        } else if (localStorage.getItem("data-bs-theme") !== null) { 
            themeMode = localStorage.getItem("data-bs-theme"); 
        }
        if (themeMode === "system") { 
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; 
        } 
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    </script>

    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                
                <!-- Header Başlangıcı -->
                <div id="kt_header" class="header align-items-stretch mb-5 mb-lg-10" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
                    <div class="container-xxl d-flex align-items-center" style="max-width:1400px">
                        
                        <!-- Mobil Menü Butonu -->
                        <div class="d-flex topbar align-items-center d-lg-none ms-n2 me-3" title="Menüyü Göster">
                            <button class="btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle" type="button" data-bs-toggle="collapse" data-bs-target="#kt_header_menu_collapse">
                                <i class="ki-duotone ki-abstract-14 fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </button>
                        </div>
                        
                        <!-- Header Logo -->
                        <div class="header-logo me-5 me-md-10 flex-grow-1 flex-lg-grow-0">
                            <a href="<?= base_url() ?>">
                                <img alt="Ufka Yolculuk Logo" src="<?= esc($headerLogoUrl) ?>" class="logo-default" height="50" style="max-height:50px"/>
                            </a>
                        </div>
                        
                        <!-- Menü & Navigasyon -->
                        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
                            <div class="d-flex align-items-stretch" id="kt_header_nav">
                                <div class="header-menu align-items-stretch" id="kt_header_menu_collapse">
                                    <div class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-title-gray-800 menu-state-primary menu-arrow-gray-500 fw-semibold my-5 my-lg-0 align-items-stretch px-2 px-lg-0" id="#kt_header_menu" data-kt-menu="true">
                                        
                                        <div class="menu-item me-0 me-lg-2">
                                            <a href="<?= base_url() ?>" class="menu-link py-3">
                                                <span class="menu-title">Ana Sayfa</span>
                                            </a>
                                        </div>

                                        <div class="menu-item me-0 me-lg-2">
                                            <a href="<?= base_url('oduller') ?>" class="menu-link py-3">
                                                <span class="menu-title">Ödüller</span>
                                            </a>
                                        </div>

                                        <div class="menu-item me-0 me-lg-2">
                                            <a href="<?= base_url('duyurular') ?>" class="menu-link py-3">
                                                <span class="menu-title">Duyurular</span>
                                            </a>
                                        </div>

                                        <div class="menu-item me-0 me-lg-2">
                                            <a href="<?= base_url('sss') ?>" class="menu-link py-3">
                                                <span class="menu-title">Sıkça Sorulanlar</span>
                                            </a>
                                        </div>

                                        <div class="menu-item me-0 me-lg-2">
                                            <a href="<?= base_url('iletisim') ?>" class="menu-link py-3">
                                                <span class="menu-title">İletişim</span>
                                            </a>
                                        </div>

                                        <div class="menu-item me-0 me-lg-2">
                                            <a href="https://minideneme.ufkayolculuk.com" target="_blank" class="menu-link py-3">
                                                <span class="menu-title blink-red" style="color:#f39c12 !important">MİNİ DENEME</span>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            
                            <!-- Kullanıcı & Arama Sağ Alan -->
                            <div class="topbar d-flex align-items-stretch flex-shrink-0">
                                
                                <!-- Kullanıcı Menüsü -->
                                <div class="d-flex align-items-center me-lg-n2 ms-1 ms-lg-3 dropdown" id="kt_header_user_menu_toggle">
                                    <button class="btn btn-icon btn-active-light-primary btn-custom dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Kullanıcı İşlemleri">
                                        <img class="rounded" style="width:30px;height:30px" src="<?= base_url('assets/images/logo.png') ?>" alt="Profil" />
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end menuspvars menu menu-sub menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 shadow">
                                        <?php if ($isLoggedIn): ?>
                                            <div class="menu-item px-3">
                                                <div class="menu-content d-flex align-items-center px-3">
                                                    <div class="symbol symbol-40px me-3">
                                                        <img alt="User" src="<?= base_url('assets/images/logo.png') ?>" />
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <div class="fw-bold d-flex align-items-center fs-6"><?= esc($userName . ' ' . $userSurname) ?></div>
                                                        <span class="badge badge-light-success fw-bold fs-8"><?= esc($userTypeName) ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="dropdown-divider my-2"></div>
                                            <div class="menu-item px-4">
                                                <a href="<?= base_url('kullanici/sinavlarim') ?>" class="dropdown-item py-2">Sınavlarım</a>
                                            </div>
                                            <div class="menu-item px-4">
                                                <a href="<?= base_url('kullanici/sertifikalarim') ?>" class="dropdown-item py-2">Sertifikalarım</a>
                                            </div>
                                            <div class="menu-item px-4">
                                                <a href="<?= base_url('kullanici/takim-lideri') ?>" class="dropdown-item py-2">Takım Lideri</a>
                                            </div>
                                            <div class="dropdown-divider my-2"></div>
                                            <div class="menu-item px-4">
                                                <a href="<?= base_url('auth/logout') ?>" class="dropdown-item py-2 text-danger">Çıkış Yap</a>
                                            </div>
                                        <?php else: ?>
                                            <div class="menu-item px-4">
                                                <a href="<?= base_url('kayit') ?>" class="dropdown-item py-2 fw-bold text-primary">Kayıt Ol</a>
                                            </div>
                                            <div class="menu-item px-4">
                                                <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#loginModal" class="dropdown-item py-2">Giriş Yap</a>
                                            </div>
                                            <div class="menu-item px-4">
                                                <a href="<?= base_url('kullanici/takim-lideri') ?>" class="dropdown-item py-2">Takım Lideri</a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Header Bitişi -->
                
                <!-- Ana İçerik Konteyneri -->
                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl" style="max-width:1400px">
                    <div class="content flex-row-fluid" id="kt_content">
                        <?= $this->renderSection('content') ?>
                    </div>
                </div>
                
                <!-- Footer Başlangıcı -->
                <div class="footer py-4 d-flex flex-lg-column mt-8" id="kt_footer" style="background:#fff;border-top:1px solid #e1e7ec">
                    <div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between" style="max-width:1400px">
                        <div class="text-gray-900 mb-3 mb-md-0">
                            <span class="text-muted fw-semibold me-1"><?= date('Y') ?> &copy;</span>
                            <a href="<?= base_url() ?>" class="text-gray-800 text-hover-primary fw-bold">Ufka Yolculuk</a>
                            <span class="text-muted ms-2 fs-7">- Bilgi ve Kültür Yarışması</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <a href="https://www.instagram.com/ufkayolculukcom" target="_blank" class="btn btn-icon btn-sm btn-light-danger" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://www.facebook.com/ufkayolculukcom" target="_blank" class="btn btn-icon btn-sm btn-light-primary" title="Facebook">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="https://x.com/ufkayolculukcom" target="_blank" class="btn btn-icon btn-sm btn-light-dark" title="X (Twitter)">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://youtube.com/@ufkayolculukcom" target="_blank" class="btn btn-icon btn-sm btn-light-danger" title="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Footer Bitişi -->

            </div>
        </div>
    </div>

    <!-- Giriş Modalı -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="loginModalLabel">Kullanıcı Girişi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="loginForm" method="post" action="<?= base_url('auth/login') ?>">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">Telefon Numarası</label>
                            <input type="tel" class="form-control form-control-solid" id="phone" name="phone" placeholder="5051234567" required>
                        </div>
                        <div class="mb-4">
                            <label for="dob" class="form-label fw-semibold">Doğum Tarihi</label>
                            <input type="text" class="form-control form-control-solid" id="dob" name="birth_date" placeholder="GG.AA.YYYY" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-3">Giriş Yap</button>
                    </form>
                    <div class="text-center mt-3">
                        <span class="text-muted">Hesabınız yok mu?</span>
                        <a href="<?= base_url('kayit') ?>" class="fw-bold ms-1">Hemen Kayıt Ol</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->renderSection('scripts') ?>
</body>
</html>
