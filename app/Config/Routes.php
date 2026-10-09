<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->match(['GET', 'HEAD'], '/', 'Home::index');

// Duyurular
$routes->match(['GET', 'HEAD'], 'duyurular', 'Duyurular::index');

// Ödüller
$routes->match(['GET', 'HEAD'], 'oduller', 'Oduller::index');
$routes->match(['GET', 'POST'], 'oduller/get-city-awards/(:segment)', 'Oduller::cityAwardsAjax/$1');

// Sıkça Sorulan Sorular (SSS)
$routes->match(['GET', 'HEAD'], 'sss', 'Sss::index');
$routes->match(['GET', 'HEAD'], 'sikca-sorulan-sorular', 'Sss::index');

// İletişim
$routes->match(['GET', 'HEAD'], 'iletisim', 'Iletisim::index');
$routes->post('iletisim/gonder', 'Iletisim::gonder');

// Sayfa Detay & Kurumsal / Hukuki Rotalar
$routes->match(['GET', 'HEAD'], 'sayfa-detay', 'Sayfa::detay');
$routes->match(['GET', 'HEAD'], 'sayfa/(:segment)', 'Sayfa::detay/$1');
$routes->match(['GET', 'HEAD'], 'hakkimizda', 'Sayfa::detay/hakkimizda');
$routes->match(['GET', 'HEAD'], 'biz-kimiz', 'Sayfa::detay/biz-kimiz');
$routes->match(['GET', 'HEAD'], 'misyon-vizyon', 'Sayfa::detay/misyon-vizyon');
$routes->match(['GET', 'HEAD'], 'sartname', 'Sayfa::detay/sartname');
$routes->match(['GET', 'HEAD'], 'resmi-onaylar', 'Sayfa::detay/resmi-onaylar');
$routes->match(['GET', 'HEAD'], 'kvkk', 'Sayfa::detay/uy-kvkk-aydinlatma-metni');

// Yarışmacı Giriş & Çıkış Sistemi (Auth)
$routes->post('auth/login', 'Auth::login');
$routes->post('auth/register', 'Auth::register');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('auth/status', 'Auth::status');

// 4 Adımlı Yeni Kayıt Sistemi Rotaları
$routes->match(['GET', 'HEAD'], 'kayit-ol', 'Kayit::index');
$routes->post('kayit/check-pre-register', 'Kayit::checkPreRegister');
$routes->get('kayit/get-counties/(:num)', 'Kayit::getCounties/$1');
$routes->get('kayit/get-schools/(:num)/(:num)', 'Kayit::getSchools/$1/$2');
$routes->post('kayit/check-leader', 'Kayit::checkLeader');
$routes->post('kayit/ajax-register', 'Kayit::ajaxRegister');
$routes->get('kayit/register-done/(:segment)', 'Kayit::registerDone/$1');

// Yarışmacı Portalı Rotaları (Sınavlarım, Sertifikalarım, Davet Et, Takım Lideri)
$routes->match(['GET', 'HEAD'], 'sinavlarim', 'Kullanici::sinavlarim');
$routes->match(['GET', 'HEAD'], 'sonuclarim', 'Kullanici::sinavlarim');
$routes->match(['GET', 'HEAD'], 'sertifikalarim', 'Kullanici::sertifikalarim');
$routes->match(['GET', 'HEAD'], 'vesile-olduklarim', 'Kullanici::davet');
$routes->match(['GET', 'HEAD'], 'davet-et', 'Kullanici::davet');
$routes->match(['GET', 'HEAD'], 'hosgeldin/(:segment)', 'Kullanici::davet');
$routes->match(['GET', 'HEAD'], 'takim-lideri', 'Kullanici::takimLideri');
$routes->match(['GET', 'HEAD'], 'lider-olmak-istiyorum', 'Kullanici::takimLideri');

// Hızlı Arama & Otomatik Tamamlama
$routes->get('arama/autocomplete', 'Arama::autocomplete');

