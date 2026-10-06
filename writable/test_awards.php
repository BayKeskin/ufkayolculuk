<?php
define('FCPATH', __DIR__ . '/../public/');
chdir(FCPATH);
require FCPATH . '../app/Config/Paths.php';
$paths = new \Config\Paths();
require $paths->systemDirectory . '/Boot.php';
\CodeIgniter\Boot::bootTest($paths);

$api = new \App\Services\UfkaApiService();
$awards = $api->getAwards(null, false);

echo "TOPLAM ODUL: " . count($awards) . PHP_EOL;

$countries = [];
$cities = [];

foreach ($awards as $aw) {
    if (($aw['type'] ?? '') === 'country') {
        $countries[] = $aw;
    } else {
        $cName = $aw['city_name'] ?? 'Bilinmeyen';
        $cities[$cName][] = $aw;
    }
}

echo "=== TURKIYE GENELI ODULLER (" . count($countries) . ") ===" . PHP_EOL;
foreach ($countries as $c) {
    echo "Kategori: " . ($c['category_name'] ?? '') . PHP_EOL;
    echo "  Oduller: " . json_encode($c['awards'], JSON_UNESCAPED_UNICODE) . PHP_EOL;
}

echo "=== IL BAZLI ORNEK (KONYA) ===" . PHP_EOL;
if (isset($cities['Konya'])) {
    foreach ($cities['Konya'] as $item) {
        echo "Kategori: " . ($item['category_name'] ?? '') . " | Oduller: " . json_encode($item['awards'], JSON_UNESCAPED_UNICODE) . PHP_EOL;
    }
} else {
    echo "Konya ana listede yok, ilk 3 il:" . PHP_EOL;
    $slice = array_slice($cities, 0, 3, true);
    foreach ($slice as $name => $items) {
        echo "IL: " . $name . " (" . count($items) . " kayit)" . PHP_EOL;
    }
}

echo "=== GETCITIES TEST ===" . PHP_EOL;
$cityList = $api->request('getCities', [], 'POST', false);
echo "Il sayisi: " . count($cityList) . PHP_EOL;
if (!empty($cityList)) {
    echo "Ilk 5: " . json_encode(array_slice($cityList, 0, 5), JSON_UNESCAPED_UNICODE) . PHP_EOL;
}
