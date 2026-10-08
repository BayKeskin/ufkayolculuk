<?php

namespace App\Commands;

use App\Services\UfkaApiService;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class ApiTest extends BaseCommand
{
    protected $group       = 'Ufka';
    protected $name        = 'api:test';
    protected $description = 'Ufka Yolculuk REST API bağlantısını ve uç noktalarını test eder.';

    public function run(array $params)
    {
        CLI::write("Ufka Yolculuk REST API Testi Başlatılıyor...", 'yellow');
        CLI::newLine();

        $service = new UfkaApiService();

        // 1. Duyurular Testi
        CLI::write("1. Duyurular Çekiliyor (getAnnouncements)...", 'cyan');
        $announcements = $service->getAnnouncements(3, false);
        if (!empty($announcements)) {
            CLI::write("   [BAŞARILI] " . count($announcements) . " duyuru alındı.", 'green');
            CLI::write("   Örnek Başlık: " . ($announcements[0]['title'] ?? 'Yok'));
        } else {
            CLI::write("   [UYARI] Duyuru listesi boş döndü.", 'yellow');
        }

        // WebContents tiplerini analiz et
        $allContents = $service->getWebContents(false);
        $types = [];
        $sssItems = [];
        foreach ($allContents as $wc) {
            if (($wc['type'] ?? '') === 'sss') {
                $sssItems[] = $wc;
            }
        }
        CLI::write("   [SSS Kayıt Sayısı (type=sss)]: " . count($sssItems), 'yellow');
        foreach ($sssItems as $idx => $si) {
            $catTitle = $si['primary_category']['title'] ?? ($si['category_title'] ?? 'Genel');
            CLI::write("     #{$idx} [ID: {$si['id']}] [Kat: {$catTitle}] {$si['title']}");
        }
        CLI::newLine();

        // 2. Kitap Kategorileri ve Kitaplar
        CLI::write("2. Kitap Kategorileri Çekiliyor (getBookCategories)...", 'cyan');
        $categories = $service->getBookCategories(false);
        if (!empty($categories)) {
            CLI::write("   [BAŞARILI] " . count($categories) . " kategori alındı.", 'green');
            foreach ($categories as $cat) {
                $bookCount = count($cat['books'] ?? []);
                CLI::write("   - [ID: {$cat['id']}] " . ($cat['title'] ?? 'Kategori') . " ({$bookCount} kitap)");
                if ($bookCount > 0) {
                    foreach ($cat['books'] as $b) {
                        CLI::write("     * Kitap keys: " . implode(', ', array_keys($b)));
                        CLI::write("     * Kitap JSON: " . json_encode($b, JSON_UNESCAPED_UNICODE));
                    }
                }
            }
            $singleBook = $service->getBook(8);
            CLI::write("   [TEKİL KİTAP getBook(8)]:", 'cyan');
            CLI::write("   keys: " . implode(', ', array_keys($singleBook ?? [])));
            if (!empty($singleBook)) {
                CLI::write("   pdf_file: " . ($singleBook['pdf_file'] ?? 'Yok'));
                CLI::write("   total_image_size: " . ($singleBook['total_image_size'] ?? 'Yok'));
                CLI::write("   pages count: " . count($singleBook['pages'] ?? []));
            }
            $compCats = $service->getCompetitionCategories(false);
            CLI::write("   [getCompetitionCategories()] Toplam: " . count($compCats), 'light_green');
            foreach ($compCats as $k => $cc) {
                CLI::write("     - [{$k}] {$cc['title']} -> Kitap: {$cc['book']['name']} (ID: {$cc['book']['id']})");
                CLI::write("       Kapak: {$cc['book']['image_url']}");
                CLI::write("       Ses: " . ($cc['book']['sound_url'] ?? 'Yok'));
            }
        } else {
            CLI::write("   [UYARI] Kategori listesi boş döndü.", 'yellow');
        }
        CLI::newLine();

        // 3. Ödüller
        CLI::write("3. Ödül Bilgileri Çekiliyor (getAwards)...", 'cyan');
        $awards = $service->getAwards(null, false);
        if (!empty($awards)) {
            CLI::write("   [BAŞARILI] " . count($awards) . " ödül kaydı alındı.", 'green');
            $countryAwards = [];
            $citiesInAwards = [];
            foreach ($awards as $aw) {
                if (($aw['type'] ?? '') === 'country') {
                    $countryAwards[] = $aw;
                } elseif (!empty($aw['city_name'])) {
                    $citiesInAwards[$aw['city_name']] = ($citiesInAwards[$aw['city_name']] ?? 0) + 1;
                }
            }
            CLI::write("   Türkiye Geneli (country) Ödül Sayısı: " . count($countryAwards), 'light_green');
            foreach ($countryAwards as $ca) {
                CLI::write("     * Kategori: " . ($ca['category_name'] ?? 'Bilinmeyen') . " | Ödüller: " . json_encode($ca['awards'] ?? [], JSON_UNESCAPED_UNICODE));
            }
            CLI::write("   İl Ödülü Bulunan Şehir Sayısı: " . count($citiesInAwards), 'yellow');
            CLI::write("   Örnek Şehirler: " . implode(', ', array_slice(array_keys($citiesInAwards), 0, 10)));
            
            // Konya (42) ve İstanbul (34) testleri
            $konyaAwards = $service->getAwards(42, false);
            CLI::write("   [getAwards/42 (Konya)] Kayıt Sayısı: " . count($konyaAwards), 'cyan');
            if (!empty($konyaAwards)) {
                CLI::write("     - Örnek Konya Kaydı: " . json_encode($konyaAwards[0], JSON_UNESCAPED_UNICODE));
                if (isset($konyaAwards[5])) {
                    CLI::write("     - Örnek İlçe/Kulüp Kaydı: " . json_encode($konyaAwards[5], JSON_UNESCAPED_UNICODE));
                }
            }

            // getAwards içindeki benzersiz şehirleri ve plaka ID'lerini çıkar
            $cityList = [];
            foreach ($awards as $aw) {
                if (!empty($aw['city_name'])) {
                    $cityName = trim($aw['city_name']);
                    $cityList[$cityName] = [
                        'name'    => $cityName,
                        'city_id' => $aw['city_id'] ?? null,
                    ];
                }
            }
            ksort($cityList, SORT_LOCALE_STRING);
            CLI::write("   [getAwards Şehir Havuzu] Toplam Benzersiz İl Sayısı: " . count($cityList), 'light_green');
            CLI::write("   İlk 10 İl: " . implode(', ', array_slice(array_keys($cityList), 0, 10)), 'yellow');
            
            // Konya ve İstanbul ödüllerini detaylı göster
            CLI::write("   --- KONYA ÖDÜLLERİ ÖRNEĞİ ---", 'cyan');
            foreach ($awards as $aw) {
                if (mb_stripos($aw['city_name'] ?? '', 'Konya') !== false) {
                    CLI::write("   ID: {$aw['id']} | Kat: " . ($aw['category_name'] ?? '-') . " | awards: " . json_encode($aw['awards'], JSON_UNESCAPED_UNICODE));
                }
            }
        }
        CLI::newLine();

        // 4. Medya URL
        CLI::write("4. Medya URL Dönüştürücü Testi...", 'cyan');
        $mediaUrl = $service->getMediaUrl('uploads/2025-10/kitap.webp');
        CLI::write("   Sonuç: " . $mediaUrl, 'green');
        CLI::newLine();

        // 5. Sınav Bilgileri Testi
        CLI::write("5. Sınav Bilgileri Çekiliyor (getExams)...", 'cyan');
        $exams = $service->getExams(false);
        if (!empty($exams)) {
            CLI::write("   [BAŞARILI] " . count($exams) . " sınav kaydı alındı.", 'green');
            foreach ($exams as $idx => $ex) {
                CLI::write("   #{$idx} ID: {$ex['id']} | Başlık: {$ex['title']} | Başlangıç: {$ex['publish_time']} | Son Giriş: {$ex['last_login_time']} | Bitiş: {$ex['end_time']}");
            }
        } else {
            CLI::write("   [BİLGİ] Sınav listesi boş döndü.", 'yellow');
        }
        CLI::newLine();

        // 5.1. Önemli Tarihler (getImportantDates)
        CLI::write("5.1. Önemli Tarihler Çekiliyor (getImportantDates)...", 'cyan');
        $impDates = $service->getImportantDates(false);
        if (!empty($impDates)) {
            CLI::write("   [BAŞARILI] " . count($impDates) . " önemli tarih alındı.", 'green');
            foreach ($impDates as $idat) {
                CLI::write("     * [{$idat['badge']}] {$idat['title']} -> {$idat['date_formatted']} {$idat['time_formatted']} (Hedef ISO: {$idat['target_iso']})");
            }
        } else {
            CLI::write("   [UYARI] Önemli tarihler boş döndü.", 'yellow');
        }
        CLI::newLine();

        // 5.2. Medya & Podcast (getMediaContents)
        CLI::write("5.2. Medya & Podcast İçerikleri Çekiliyor (getMediaContents)...", 'cyan');
        $mediaList = $service->getMediaContents(false);
        if (!empty($mediaList)) {
            CLI::write("   [BAŞARILI] " . count($mediaList) . " medya içeriği alındı.", 'green');
            foreach ($mediaList as $m) {
                CLI::write("     * [{$m['tag']}] {$m['title']} ({$m['duration']}) -> URL: {$m['url']}");
            }
        } else {
            CLI::write("   [UYARI] Medya listesi boş döndü.", 'yellow');
        }
        CLI::newLine();

        // 5.3. Hero Sliders (getSliders)
        CLI::write("5.3. Hero Slider Çekiliyor (getSliders)...", 'cyan');
        $sliders = $service->getSliders(5, false);
        CLI::write("   Sliders Sayısı: " . count($sliders), count($sliders) > 0 ? 'green' : 'yellow');
        CLI::newLine();

        // 6. Şehirler ve İl Haritası Testi (getAwardCities & getCityAwardsMap)
        CLI::write("6. İl Listesi ve Ödül Haritası Çekiliyor (getAwardCities)...", 'cyan');
        $awardCities = $service->getAwardCities(false);
        if (!empty($awardCities)) {
            CLI::write("   [BAŞARILI] " . count($awardCities) . " il listelendi. İlk 5: " . implode(', ', array_slice($awardCities, 0, 5)), 'green');
            $cityMap = $service->getCityAwardsMap(false);
            CLI::write("   [BAŞARILI] " . count($cityMap) . " il için ödül haritası derlendi.", 'green');
        } else {
            CLI::write("   [UYARI] Şehir listesi boş döndü.", 'yellow');
        }
        CLI::newLine();

        // 7. Menü Testi (getMenu)
        CLI::write("7. Menü Ağacı Çekiliyor (getMenu)...", 'cyan');
        $headerMenu = $service->getMenu('header', false);
        $footerMenu = $service->getMenu('footer', false);
        CLI::write("   Header Menü Elemanları: " . json_encode($headerMenu, JSON_UNESCAPED_UNICODE));
        CLI::write("   Footer Menü Elemanları: " . json_encode($footerMenu, JSON_UNESCAPED_UNICODE));
        CLI::newLine();

        // 8. Web İçerikleri & Kategorileri (getWebContents & getWebCategories)
        CLI::write("8. Tüm Web İçerikleri Çekiliyor (getWebContents)...", 'cyan');
        $allContents = $service->getWebContents(false);
        CLI::write("   Toplam İçerik Sayısı: " . count($allContents), 'green');
        $types = [];
        foreach ($allContents as $item) {
            $t = $item['type'] ?? 'tanımsız';
            $types[$t] = ($types[$t] ?? 0) + 1;
            CLI::write("   * [ID: {$item['id']}] Typ: {$t} | Slug: " . ($item['slug'] ?? '-') . " | Başlık: " . mb_substr($item['title'] ?? '', 0, 45));
        }
        CLI::write("   İçerik Türü Dağılımı: " . json_encode($types, JSON_UNESCAPED_UNICODE), 'yellow');
        CLI::newLine();

        // 9. Soru Havuzu Testi (getQuestions)
        CLI::write("9. Soru Havuzu Çekiliyor (getQuestions/6)...", 'cyan');
        $questions = $service->request('getQuestions/6', [], 'POST', false);
        if (!empty($questions) && is_array($questions)) {
            CLI::write("   [BAŞARILI] " . count($questions) . " soru alındı. Örnek: " . mb_substr($questions[0]['body'] ?? ($questions[0]['name'] ?? 'Soru'), 0, 60), 'green');
        } else {
            CLI::write("   [BİLGİ] Kategori 6 için soru listesi boş döndü. (Belki 1, 2 veya 3 denenmeli)", 'yellow');
            $questionsAlt = $service->request('getQuestions/1', [], 'POST', false);
            if (!empty($questionsAlt) && is_array($questionsAlt)) {
                CLI::write("   [BAŞARILI] Kategori 1 için " . count($questionsAlt) . " soru alındı.", 'green');
            }
        }
        CLI::newLine();

        // 10. Kullanıcı Giriş Sorgulama Testi (getUfkaYolculukUser)
        CLI::write("10. Kullanıcı Giriş Testi (getUfkaYolculukUser)...", 'cyan');
        $userTest = $service->request('getUfkaYolculukUser', [
            'mobile'    => '5321112233',
            'birthdate' => '2005-01-01'
        ], 'POST', false);
        CLI::write("   getUfkaYolculukUser Yanıtı: " . json_encode($userTest, JSON_UNESCAPED_UNICODE));
        CLI::newLine();

        // 11. Sayfa Görünümleri ve Web İstek Testi
        CLI::write("11. Sayfa Web Yanıtları Test Ediliyor (http://localufkayolculuk.com)...", 'cyan');
        $pagesToTest = [
            'Ana Sayfa'                      => '/',
            'Duyurular'                      => '/duyurular',
            'Ödüller'                        => '/oduller',
            'Sıkça Sorulan Sorular'          => '/sss',
            'İletişim & İl Temsilcilikleri' => '/iletisim',
            'Kurumsal (Hakkımızda)'          => '/sayfa/hakkimizda',
            'Kurumsal (Misyon & Vizyon)'     => '/sayfa/misyon-vizyon',
        ];

        foreach ($pagesToTest as $label => $uri) {
            $ch = curl_init('http://localufkayolculuk.com' . $uri);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 6);
            $start = microtime(true);
            $res = curl_exec($ch);
            $ms = round((microtime(true) - $start) * 1000);
            $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($http === 200) {
                CLI::write("   [BAŞARILI] {$label} -> HTTP 200 OK (" . strlen($res) . " bytes, {$ms}ms)", 'green');
            } else {
                CLI::write("   [UYARI] {$label} -> HTTP {$http}", 'yellow');
            }
        }
        CLI::newLine();

        CLI::write("Tüm API Testleri ve Sayfa Renderları Başarıyla Tamamlandı!", 'light_green');
    }
}
