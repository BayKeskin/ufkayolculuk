<?php
/**
 * Klasik Tema (Metronic M2) Master Layout - Canlı Sistem Birebir Kopyası (CI4 Uyumlu)
 */
$pageTitle = $title ?? ($page_title ?? 'Ufka Yolculuk');
$pageDesc = $meta_description ?? ($description ?? 'İlk Sözleşmeni Hatırla!');
$pageKeywords = $keywords ?? 'ufka yolculuk,bilgi yarışması,inanç,ödüllü yarışma';

// Options verisi
$options = $options ?? [];
if (empty($options) && isset($themeConfig['visual_settings'])) {
    $options = $themeConfig['visual_settings'];
}

// Logo URL
$rawLogo = !empty($options['logo']) ? $options['logo'] : (!empty($options['site_logo']) ? $options['site_logo'] : '');
if (empty($rawLogo)) {
    $rawLogo = 'uploads/2025-09/uy_logo_68c445a334647_68d8ee9f98eb8.webp';
}
$headerLogoUrl = (strpos($rawLogo, 'http') === 0) ? $rawLogo : base_url(ltrim($rawLogo, '/'));

// Menü verisi
$menu = $menu ?? [];
if (empty($menu)) {
    try {
        $apiService = new \App\Services\UfkaApiService();
        $menu = $apiService->getMenu('header');
    } catch (\Throwable $e) {
        $menu = [];
    }
}

// SSS arama listesi
$search_sss = $search_sss ?? [];
if (empty($search_sss)) {
    try {
        $apiService = $apiService ?? new \App\Services\UfkaApiService();
        $search_sss = $apiService->getFaqList();
    } catch (\Throwable $e) {
        $search_sss = [];
    }
}

// Oturum Kullanıcısı
$sessionUser = session()->get('user') ?? null;
$isLoggedIn = !empty($sessionUser) || (session()->get('is_logged_in') == true) || (session()->get('id') > 0);
$userName = $sessionUser['name'] ?? (session()->get('name') ?? '');
$userSurname = $sessionUser['surname'] ?? (session()->get('surname') ?? '');
$userTypeName = $sessionUser['type_name'] ?? (session()->get('type_name') ?? 'Yarışmacı');
?>
<!DOCTYPE html>
<html lang="tr">
	<!--begin::Head-->
	<head>
		<title><?= esc($pageTitle) ?> - Ufka Yolculuk</title>
		<meta charset="utf-8" />
		<meta name="description" content="<?= esc($pageDesc) ?>" />
		<meta name="keywords" content="<?= esc($pageKeywords) ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="tr_TR" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="<?= esc($pageTitle) ?>" />
		<meta property="og:url" content="<?= current_url() ?>" />
		<meta property="og:site_name" content="<?= esc($pageTitle) ?>" />
		<link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('apple-touch-icon.png') ?>">
		<link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('favicon-32x32.png') ?>">
		<link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('favicon-16x16.png') ?>">
		<link rel="manifest" href="<?= base_url('site.webmanifest') ?>">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<link href="<?= base_url('assets/m2/plugins/global/plugins.bundle.css?v=3') ?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/m2/css/style.bundle.css?v=23') ?>" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="<?= base_url('assets/css/toastr.css') ?>">
        <style>
            [data-bs-theme="light"] body:not(.app-blank) {
				background-color: <?= !empty($options['background_color']) ? esc($options['background_color']) : '#dde6e8' ?>;
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
					font-size: 18px;   /* Daha küçük ekran için */
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
        </style>
		<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
		<script src="<?= base_url('assets/js/bootstrap.5.2.2.min.js') ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/js/toastr.min.js') ?>" type="text/javascript"></script>
		<?= $this->renderSection('styles') ?>
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }</script>
		
		<!-- Mini Deneme Sabit Butonu -->
		<div id="rightFixedButton"><a href="https://minideneme.ufkayolculuk.com" target="_blank" style="color:black"><p id="rightFixedText" class="blink-red">MİNİ DENEME</p></a></div>
		
		<div class="d-flex flex-column flex-root">
			<div class="page d-flex flex-row flex-column-fluid">
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<div id="kt_header" class="header align-items-stretch mb-5 mb-lg-10" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<div class="container-xxl d-flex align-items-center" style="max-width:1400px">
							<div class="d-flex topbar align-items-center d-lg-none ms-n2 me-3" title="Show aside menu">
								<div class="btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
									<i class="ki-duotone ki-abstract-14 fs-1">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
								</div>
							</div>
							<div class="header-logo me-5 me-md-10 flex-grow-1 flex-lg-grow-0">
								<a href="<?= base_url(); ?>">
									<img alt="Logo" src="<?= esc($headerLogoUrl) ?>" class="logo-default" height="50" style="max-height:50px"/>
									<img alt="Logo" src="<?= esc($headerLogoUrl) ?>" class="logo-sticky" height="50" />
								</a>
							</div>
							<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
							<div class="d-flex align-items-stretch" id="kt_header_nav">
							
								<div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
									<div class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-title-gray-800 menu-state-primary menu-arrow-gray-500 fw-semibold my-5 my-lg-0 align-items-stretch px-2 px-lg-0" id="#kt_header_menu" data-kt-menu="true">
										<?php 
										$i = 0; 
										$uriObj = service('uri');
										$totalSegs = $uriObj->getTotalSegments();
										$currentSegment1 = $totalSegs >= 1 ? $uriObj->getSegment(1) : '';
										$currentSegment2 = $totalSegs >= 2 ? $uriObj->getSegment(2) : '';
										foreach ($menu as $item) {
											$itemTitle = is_object($item) ? $item->title : ($item['title'] ?? '');
											$itemLink  = is_object($item) ? ($item->link ?? '') : ($item['link'] ?? ($item['url'] ?? ''));
											$itemChilds = is_object($item) ? ($item->childs ?? ($item->children ?? [])) : ($item['childs'] ?? ($item['children'] ?? []));
											$active = (!empty($currentSegment1) && strstr($itemLink, str_replace("#", "", $currentSegment1))) ? 'here show' : '';		
											
											if ($i == 0) {
										?>
										<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item <?= $active; ?> menu-here-bg menu-lg-down-accordion me-0 me-lg-2">
											<span class="menu-link py-3">
												<span class="menu-title"><?= esc($itemTitle); ?></span>
												<span class="menu-arrow d-lg-none"></span>
											</span>
											<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown p-0 w-100 w-lg-600px">
												<div class="menu-state-bg menu-extended overflow-hidden overflow-lg-visible" data-kt-menu-dismiss="true">
													<div class="row">
														<div class="col-lg-12 mb-3 mb-lg-0 py-3 px-3 py-lg-6 px-lg-6">
															<div class="row">
															<?php foreach ($itemChilds as $child) {
																if (!$child) continue;
																$cType = is_object($child) ? ($child->type ?? '') : ($child['type'] ?? '');
																$cIcon = is_object($child) ? ($child->icon ?? '') : ($child['icon'] ?? '');
																$cLink = is_object($child) ? ($child->link ?? '') : ($child['link'] ?? ($child['url'] ?? ''));
																$cTitle = is_object($child) ? ($child->title ?? '') : ($child['title'] ?? '');
																$cDesc = is_object($child) ? ($child->description ?? '') : ($child['description'] ?? '');
																
																if ($cType == "custom" && !empty($cIcon)) {
																	$cActive = (!empty($currentSegment2) && strstr($cLink, str_replace("#", "", $currentSegment2))) ? 'active' : '';	
																?>
																<div class="col-lg-6 mb-3">
																	<div class="menu-item p-0 m-0">
																		<a href="<?= (strpos($cLink, 'http') === 0) ? esc($cLink) : base_url(ltrim($cLink, '/')); ?>" class="menu-link <?= $cActive; ?>">
																			<span class="menu-custom-icon d-flex flex-center flex-shrink-0 rounded w-40px h-40px me-3">
																				<i class="<?= esc($cIcon); ?>">
																				<span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
																			</span>
																			<span class="d-flex flex-column">
																				<span class="fs-6 fw-bold text-gray-800"><?= esc($cTitle); ?></span>
																				<?php if (!empty($cDesc)): ?>
																					<span class="fs-7 fw-semibold text-muted"><?= esc($cDesc); ?></span>
																				<?php endif; ?>
																			</span>
																		</a>
																	</div>
																</div>
																<?php } 
															} ?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<?php } else { ?>
											<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
												<?php if (empty($itemChilds)) { ?>
												<a href="<?= (strpos($itemLink, 'http') === 0) ? esc($itemLink) : base_url(ltrim($itemLink, '/')); ?>">
												<?php } ?>
												<span class="menu-link py-3">
													<span class="menu-title"><?= esc($itemTitle); ?></span>
													<span class="menu-arrow d-lg-none"></span>
												</span>
												<?php if (empty($itemChilds)) { ?>
												</a>
												<?php } ?>
												<?php if (!empty($itemChilds)) { ?>
												<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
													<?php foreach ($itemChilds as $child) {
														if (!$child) continue;
														$cTitle = is_object($child) ? ($child->title ?? '') : ($child['title'] ?? '');
														$cLink = is_object($child) ? ($child->link ?? ($child->slug ?? '')) : ($child['link'] ?? ($child['slug'] ?? ''));
														$cDesc = is_object($child) ? ($child->description ?? '') : ($child['description'] ?? '');
														$cChilds = is_object($child) ? ($child->childs ?? ($child->children ?? [])) : ($child['childs'] ?? ($child['children'] ?? []));
														
														if (!empty($cChilds)) { ?>
														<div data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-placement="right-start" class="menu-item menu-lg-down-accordion">
															<span class="menu-link py-3">
																<span class="menu-icon">
																	<i class="ki-duotone ki-rocket fs-2">
																		<span class="path1"></span>
																		<span class="path2"></span>
																	</i>
																</span>
																<span class="menu-title"><?= esc($cTitle); ?></span>
																<span class="menu-arrow"></span>
															</span>
															<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-active-bg px-lg-2 py-lg-4 w-lg-275px">
															<?php foreach ($cChilds as $child2) {
																if (!$child2) continue;
																$c2Title = is_object($child2) ? ($child2->title ?? '') : ($child2['title'] ?? '');
																$c2Link  = is_object($child2) ? ($child2->slug ?? ($child2->link ?? '')) : ($child2['slug'] ?? ($child2['link'] ?? ''));
															?>
																<div class="menu-item">
																	<a class="menu-link py-3" href="<?= (strpos($c2Link, 'http') === 0) ? esc($c2Link) : base_url(ltrim($c2Link, '/')); ?>">
																		<span class="menu-bullet">
																			<span class="bullet bullet-dot"></span>
																		</span>
																		<span class="menu-title"><?= esc($c2Title); ?></span>
																	</a>
																</div>
																<?php } ?>
															</div>
														</div>
														<?php } else { ?>
														<div class="menu-item">
															<a class="menu-link py-3" href="<?= (strpos($cLink, 'http') === 0) ? esc($cLink) : base_url(ltrim($cLink, '/')); ?>" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right" title="<?= esc($cDesc); ?>">
																<span class="menu-title"><?= esc($cTitle); ?></span>
															</a>
														</div>
													<?php } 
													} ?>
												</div>
												<?php } ?>
											</div>
										<?php }
										$i++; 
										} ?>
										<div data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
											<a href="<?= base_url('ufka-yolculuk-oyunlar'); ?>">
											<span class="menu-link py-3">
												<span class="menu-title blink-red" style="color:orange !important">OYUNLAR</span>
											</span>
											</a>
										</div>
									</div>
								</div>
							
							</div>
							<div class="topbar d-flex align-items-stretch flex-shrink-0">
								<div class="d-flex align-items-stretch ms-1 ms-lg-3">
									<div id="kt_header_search" class="header-search d-flex align-items-stretch" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-menu-trigger="auto" data-kt-menu-overflow="false" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">
										<div class="d-flex align-items-center" data-kt-search-element="toggle" id="kt_header_search_toggle">
											<div class="btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px" data-bs-toggle="tooltip" title="Arama Yap">
												<i class="ki-duotone ki-magnifier fs-1">
													<span class="path1"></span>
													<span class="path2"></span>
												</i>
											</div>
										</div>
										<div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown p-7 w-325px w-md-375px">
											<div data-kt-search-element="wrapper">
												<form data-kt-search-element="form" id="searchForm" class="w-100 position-relative mb-3" autocomplete="off">
													<i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-0">
														<span class="path1"></span>
														<span class="path2"></span>
													</i>
													<input type="text" class="search-input form-control form-control-flush ps-10" id="search" name="search" value="" placeholder="Aramak istediğiniz kelimeyi yazın" data-kt-search-element="input" />
												</form>
												<script>
												$('#searchForm').on("submit",function(e){
													e.preventDefault();
												});
												$('#search').on("keyup",function(){
													var val = $(this).val();
													if (val.length < 2) return;
													$.get("<?= base_url('arama/ajax'); ?>?q=" + encodeURIComponent(val), function(data){
														$('#searchArea').text("");
														if (data && data.results) {
															$.each(data.results, function( index, value ) {
																$('#searchArea').append('<div class="d-flex align-items-center mb-5"><div class="symbol symbol-40px me-4"><span class="symbol-label bg-light"><i class="ki-duotone ki-question fs-2 text-primary"><span class="path1"></span><span class="path2"></span></i></span></div><div class="d-flex flex-column"><a href="<?= base_url(); ?>/'+value.slug+'" class="fs-6 text-gray-800 text-hover-primary fw-semibold">'+value.title+'</a></div></div>');
															});
														}
													});
												});
												</script>
												<div class="separator border-gray-200 mb-6"></div>
												<div class="mb-5" data-kt-search-element="main">
													<div class="d-flex flex-stack fw-semibold mb-4">
														<span class="text-muted fs-6 me-2">Sık Sorulan Sorular:</span>
													</div>
													<div class="scroll-y mh-200px mh-lg-325px" id="searchArea">
														<?php foreach ($search_sss as $question) { 
															$qTitle = is_object($question) ? ($question->title ?? '') : ($question['title'] ?? '');
															$qSlug = is_object($question) ? ($question->slug ?? '') : ($question['slug'] ?? '');
														?>
														<div class="d-flex align-items-center mb-5">
															<div class="symbol symbol-40px me-4">
																<span class="symbol-label bg-light">
																	<i class="ki-duotone ki-question fs-2 text-primary">
																		<span class="path1"></span>
																		<span class="path2"></span>
																	</i>
																</span>
															</div>
															<div class="d-flex flex-column">
																<a href="<?= base_url(ltrim($qSlug, '/')); ?>" class="fs-6 text-gray-800 text-hover-primary fw-semibold"><?= esc($qTitle); ?></a>
															</div>
														</div>
														<?php } ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="d-flex align-items-center me-lg-n2 ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
									<div class="btn btn-icon btn-active-light-primary btn-custom" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-bs-toggle="tooltip" title="Kullanıcı İşlemleri">
										<img class="rounded" style="width:30px" src="<?= base_url('assets/img/unknown_person.jpg'); ?>" alt="" />
									</div>
									<div class="menuspvars menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6" data-kt-menu="true">
										<?php if ($isLoggedIn) { ?>
										<div class="menu-item px-3">
											<div class="menu-content d-flex align-items-center px-3">
												<div class="symbol symbol-50px me-5">
													<img alt="Logo" src="<?= base_url('assets/img/unknown_person.jpg'); ?>" />
												</div>
												<div class="d-flex flex-column">
													<div class="fw-bold d-flex align-items-center fs-5"><?= esc($userName . ' ' . $userSurname); ?>
													<span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2"><?= esc($userTypeName); ?></span></div>
													<a href="<?= base_url('sertifikalarim'); ?>" class="btn btn-light-primary btn-sm mt-2 py-1">Sertifikalarım</a>
												</div>
											</div>
										</div>
										<div class="separator my-2"></div>
										<div class="menu-item px-5">
											<a href="<?= base_url('sertifikalarim'); ?>" class="menu-link px-5">Sertifikalarım</a>
										</div>
										<div class="menu-item px-5">
											<a href="<?= base_url('sonuclarim'); ?>" class="menu-link px-5">Sınavlarım</a>
										</div>
										<div class="menu-item px-5 my-1">
											<a href="<?= base_url('lider-olmak-istiyorum'); ?>" class="menu-link px-5">Takım Lideri</a>
										</div>
										<div class="menu-item px-5 my-1">
											<a href="<?= base_url('vesile-olduklarim'); ?>" class="menu-link px-5">Davet Et</a>
										</div>
										<div class="separator my-2"></div>
										<div class="menu-item px-5">
											<a href="<?= base_url('auth/logout'); ?>" class="menu-link px-5">Çıkış Yap</a>
										</div>
										<?php } else { ?>
										<div class="menu-item px-5">
											<a href="javascript:;" data-bs-toggle="modal" data-bs-target="#loginModal" class="menu-link px-5">Giriş Yap</a>
										</div>
										<div class="menu-item px-5 my-1">
											<a href="<?= base_url('lider-olmak-istiyorum'); ?>" class="menu-link px-5">Takım Lideri</a>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
							</div>
						</div>
					</div>
					
					<!-- Content Container -->
					<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl" style="max-width:1400px">
						<div class="content flex-row-fluid" id="kt_content">
							<?= $this->renderSection('content') ?>
						</div>
					</div>
					
					<!-- Footer -->
					<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
						<div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
							<div class="text-gray-900">
								<span class="text-muted fw-semibold me-1"><?= date('Y'); ?>&copy;</span>
								<a href="https://ufkayolculuk.com" class="text-gray-800 text-hover-primary">Ufka Yolculuk</a>
							</div>
							<div class="card-body text-end">
								<a href="https://www.instagram.com/ufkayolculukcom?igsh=MXVkMWRvdTdpazB4aQ%3D%3D&utm_source=qr" alt="Instagram Linki" class="mx-1 mx-xl-4">
									<img src="<?= base_url('assets/m2/media/svg/brand-logos/instagram-2-1.svg'); ?>" class="my-2" style="height:30px" alt="Instagram hesabımız">  
								</a>
								<a href="https://www.facebook.com/share/19cTVeFcrM/?mibextid=wwXIfr" class="mx-1 mx-xl-4" alt="Facebook linki">
									<img src="<?= base_url('assets/m2/media/svg/brand-logos/facebook-4.svg'); ?>" class="my-2" style="height:30px" alt="Facebook hesabımız">  
								</a>
								<a href="https://x.com/ufkayolculukcom?s=21" class="mx-1 mx-xl-4" alt="x (Twitter) linki">
									<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="35" height="35" viewBox="0 0 50 50">
									<path d="M 11 4 C 7.134 4 4 7.134 4 11 L 4 39 C 4 42.866 7.134 46 11 46 L 39 46 C 42.866 46 46 42.866 46 39 L 46 11 C 46 7.134 42.866 4 39 4 L 11 4 z M 13.085938 13 L 21.023438 13 L 26.660156 21.009766 L 33.5 13 L 36 13 L 27.789062 22.613281 L 37.914062 37 L 29.978516 37 L 23.4375 27.707031 L 15.5 37 L 13 37 L 22.308594 26.103516 L 13.085938 13 z M 16.914062 15 L 31.021484 35 L 34.085938 35 L 19.978516 15 L 16.914062 15 z"></path>
									</svg>
								</a> 
								<a href="https://t.me/ufkayolculukk" class="mx-1 mx-xl-4">
									<img src="<?= base_url('assets/m2/media/svg/brand-logos/telegram.svg'); ?>" class="my-2" style="height:30px" alt="Telegram linki">  
								</a>
								<a href="https://whatsapp.com/channel/0029VaDlLtEKwqSPSP3Ryg0z" class="mx-1 mx-xl-4" alt="Whatsapp linki">
									<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="40" height="40" viewBox="0 0 48 48">
									<path fill="#fff" d="M4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98c-0.001,0,0,0,0,0h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303z"></path><path fill="#fff" d="M4.868,43.803c-0.132,0-0.26-0.052-0.355-0.148c-0.125-0.127-0.174-0.312-0.127-0.483l2.639-9.636c-1.636-2.906-2.499-6.206-2.497-9.556C4.532,13.238,13.273,4.5,24.014,4.5c5.21,0.002,10.105,2.031,13.784,5.713c3.679,3.683,5.704,8.577,5.702,13.781c-0.004,10.741-8.746,19.48-19.486,19.48c-3.189-0.001-6.344-0.788-9.144-2.277l-9.875,2.589C4.953,43.798,4.911,43.803,4.868,43.803z"></path><path fill="#cfd8dc" d="M24.014,5c5.079,0.002,9.845,1.979,13.43,5.566c3.584,3.588,5.558,8.356,5.556,13.428c-0.004,10.465-8.522,18.98-18.986,18.98h-0.008c-3.177-0.001-6.3-0.798-9.073-2.311L4.868,43.303l2.694-9.835C5.9,30.59,5.026,27.324,5.027,23.979C5.032,13.514,13.548,5,24.014,5 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974C24.014,42.974,24.014,42.974,24.014,42.974 M24.014,4C24.014,4,24.014,4,24.014,4C12.998,4,4.032,12.962,4.027,23.979c-0.001,3.367,0.849,6.685,2.461,9.622l-2.585,9.439c-0.094,0.345,0.002,0.713,0.254,0.967c0.19,0.192,0.447,0.297,0.711,0.297c0.085,0,0.17-0.011,0.254-0.033l9.687-2.54c2.828,1.468,5.998,2.243,9.197,2.244c11.024,0,19.99-8.963,19.995-19.98c0.002-5.339-2.075-10.359-5.848-14.135C34.378,6.083,29.357,4.002,24.014,4L24.014,4z"></path><path fill="#40c351" d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z"></path><path fill="#fff" fill-rule="evenodd" d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z" clip-rule="evenodd"></path>
									</svg>
								</a>
								<a href="https://sosyal.teknofest.app/@ufkayolculukcom" class="mx-1 mx-xl-4">
									<img src="<?= base_url('uploads/2025-09/nsosyal_68da8156b25be.webp'); ?>" style="border-radius:5px;height:30px" class="my-2" alt="Ufka Yolculuk - Next Sosyal Hesabı">
								</a>
								<a href="https://youtube.com/@ufkayolculukcom?si=TKDDLACQ9UpWLT4v" class="mx-1 mx-xl-4">
									<img src="<?= base_url('assets/m2/media/svg/brand-logos/youtube-3.svg'); ?>" class="my-2" style="height:30px" alt="Youtube Hesabımız">  
								</a>
								<a href="https://bip.ai/join/ufkayolculuk" class="mx-1 mx-xl-4">
									<img src="<?= base_url('uploads/2025-12/bip_logo_6941af68de8c4.svg'); ?>" class="my-2" style="height:30px" alt="Bip Hesabımız">
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Login Modal -->
		<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content rounded-3 shadow">
		      <div class="modal-header">
		        <h5 class="modal-title" id="loginModalLabel">Kullanıcı Girişi</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
		      </div>
		      <div class="modal-body">
		        <form id="loginForm" method="post" action="<?= base_url('auth/login'); ?>">
				<?= csrf_field() ?>
		          <div class="mb-3">
		            <label for="phone" class="form-label">Telefon Numarası (Yurtdışı telefonlarda ülke kodu eklemeden yazınız)</label>
		            <input type="number" class="form-control" id="phone" name="phone" placeholder="5051232323" required>
		          </div>
		          <div class="mb-3">
		            <label for="dob" class="form-label">Doğum Tarihi</label>
		            <input type="text" class="form-control" id="dob" name="birth_date" placeholder="gg.aa.yyyy" required>
		          </div>
		          <button type="submit" class="btn btn-success w-100">Giriş Yap</button>
		        </form>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Certificate Modal -->
		<div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="certModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
		    <div class="modal-content rounded-3 shadow">
		      <div class="modal-header">
		        <h5 class="modal-title" id="certModalLabel">Kayıt Sertifikası</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Kapat"></button>
		      </div>
		      <div class="modal-body" id="certificateArea"><img id='certificateImg' style='width:100%' src=''></div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary btn-sm me-1" data-bs-dismiss="modal">Kapat</button>
		          <button id="btnDownload" class="btn btn-success me-1 btn-sm">
		            <i class="bi bi-download"></i> İndir
		          </button>
		          <button id="btnInstagram" class="btn btn-danger btn-sm">
		            <i class="bi bi-share"></i> Paylaş
		          </button>
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Scroll to Top -->
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<i class="ki-duotone ki-arrow-up">
				<span class="path1"></span>
				<span class="path2"></span>
			</i>
		</div>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script src="<?= base_url('assets/m2/js/scripts.bundle.js?v=23'); ?>"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/inputmask.min.js"></script>

		<script>
		  Inputmask({"mask": "99.99.9999"}).mask("#dob");

		  document.getElementById("loginForm").addEventListener("submit", function(e) {
		      let dob = document.getElementById("dob").value;
		      if (dob.length !== 10) {
		          e.preventDefault();
		          alert("Lütfen geçerli formatta giriniz.");
		      }
		  });

		  const shareImage = async (imgUrl) => {
		  try {
		    const response = await fetch(imgUrl);
		    const blob = await response.blob();
		    const file = new File([blob], 'sertifika.jpg', { type: blob.type });

		    if (navigator.canShare && navigator.canShare({ files: [file] })) {
		      await navigator.share({
		        title: 'Sertifikam',
		        text: 'Sertifikamı aldım!',
		        files: [file],
		      });
		    } else {
		      alert('Tarayıcınız doğrudan resim paylaşımını desteklemiyor. Resmi indir butonu ile cihazınıza indirdikten sonra sosyal medya hesabınızda paylaşabilirsiniz');
		    }
		  } catch (err) {
		    console.error('Paylaşım hatası:', err);
		  }
		};

		$('#btnWhatsApp, #btnInstagram').off('click').on('click', function() {
		  const imgSrc = $('#certificateImg').attr('src');
		  shareImage(imgSrc);
		});
		</script>

		<?= $this->renderSection('scripts') ?>
	</body>
</html>
