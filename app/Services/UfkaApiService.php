<?php

namespace App\Services;

use Config\Services;
use Config\UfkaApi;

/**
 * Ufka Yolculuk Merkezi REST API Servisi
 * API Kılavuzu: https://ufkayolculuk.com/rest
 */
class UfkaApiService
{
    protected UfkaApi $config;

    public function __construct(?UfkaApi $config = null)
    {
        $this->config = $config ?? config('UfkaApi');
    }

    /**
     * API Bearer Access Token alır (2 saatlik ömür, yerel önbellek, refresh ve Basic Auth fallback)
     */
    public function getAccessToken(bool $forceRefresh = false): ?string
    {
        $cacheKey = 'ufka_api_bearer_access_token';
        if (!$forceRefresh) {
            $cachedToken = cache($cacheKey);
            if (!empty($cachedToken)) {
                return $cachedToken;
            }
        }

        // Önce varsa refresh_token ile yenilemeyi dene
        $refreshToken = cache('ufka_api_bearer_refresh_token');
        if ($forceRefresh && !empty($refreshToken)) {
            try {
                $client = Services::curlrequest(['timeout' => 10, 'verify' => false, 'http_errors' => false]);
                $url = rtrim($this->config->baseURL, '/') . '/refresh';
                $resp = $client->post($url, [
                    'form_params' => ['refresh_token' => $refreshToken],
                    'verify' => false,
                ]);
                if ($resp->getStatusCode() === 200) {
                    $json = json_decode($resp->getBody(), true);
                    if (!empty($json['access_token'])) {
                        $ttl = $this->config->tokenTTL ?? 6600;
                        cache()->save($cacheKey, $json['access_token'], $ttl);
                        if (!empty($json['refresh_token'])) {
                            cache()->save('ufka_api_bearer_refresh_token', $json['refresh_token'], 14 * 86400);
                        }
                        return $json['access_token'];
                    }
                }
            } catch (\Throwable $e) {
                log_message('error', 'UfkaApiService token refresh exception: ' . $e->getMessage());
            }
        }

        // POST /token ile yeni token çifti al
        try {
            $client = Services::curlrequest(['timeout' => 10, 'verify' => false, 'http_errors' => false]);
            $url = rtrim($this->config->baseURL, '/') . '/token';
            $resp = $client->post($url, [
                'form_params' => [
                    'username'   => $this->config->username,
                    'password'   => $this->config->password,
                    'token_name' => 'Web-Client',
                ],
                'verify' => false,
            ]);

            if ($resp->getStatusCode() === 200) {
                $json = json_decode($resp->getBody(), true);
                if (!empty($json['access_token'])) {
                    $ttl = $this->config->tokenTTL ?? 6600;
                    cache()->save($cacheKey, $json['access_token'], $ttl);
                    if (!empty($json['refresh_token'])) {
                        cache()->save('ufka_api_bearer_refresh_token', $json['refresh_token'], 14 * 86400);
                    }
                    return $json['access_token'];
                }
            }
        } catch (\Throwable $e) {
            log_message('error', 'UfkaApiService getAccessToken exception: ' . $e->getMessage());
        }

        return null;
    }

    /**
     * REST API uç noktasına HTTP isteği gönderir (Bearer Token & Basic Auth Fallback)
     *
     * @param string $endpoint   Örn: 'getWebContents', 'getAwards/34'
     * @param array  $postData   Form POST verileri
     * @param string $method     'POST' veya 'GET'
     * @param bool   $useCache   Önbellek kullanılsın mı?
     * @return array|null        JSON yanıtı ayrıştırılmış dizi veya null
     */
    public function request(string $endpoint, array $postData = [], string $method = 'POST', bool $useCache = true): ?array
    {
        $endpoint = ltrim($endpoint, '/');
        $cacheKey = 'ufka_api_' . md5($endpoint . '_' . json_encode($postData) . '_' . $method);

        if ($useCache) {
            $cached = cache($cacheKey);
            if ($cached !== null) {
                return $cached;
            }
        }

        $url = rtrim($this->config->baseURL, '/') . '/' . $endpoint;

        try {
            $client = Services::curlrequest([
                'timeout'     => 15,
                'http_errors' => false,
                'verify'      => false, // Yerel geliştirme ortamında SSL sertifika kontrolü
            ]);

            $headers = [
                'Accept'     => 'application/json',
                'User-Agent' => 'UfkaYolculuk-CI4-Client/2.0',
            ];

            // Bearer Token'ı al ve başlığa ekle
            $bearerToken = null;
            if (!in_array($endpoint, ['token', 'refresh', 'revoke'])) {
                $bearerToken = $this->getAccessToken();
            }
            if (!empty($bearerToken)) {
                $headers['Authorization'] = 'Bearer ' . $bearerToken;
            }

            $options = [
                'auth'    => [$this->config->username, $this->config->password], // Basic Auth fallback koruması
                'headers' => $headers,
                'verify'  => false,
            ];

            if ($method === 'POST') {
                $options['form_params'] = $postData;
                $response = $client->post($url, $options);
            } else {
                $options['query'] = $postData;
                $response = $client->get($url, $options);
            }

            $statusCode = $response->getStatusCode();

            // 401 Unauthorized dönerse token'ı tazeleyip bir kez daha dene
            if ($statusCode === 401 && !empty($bearerToken)) {
                $newToken = $this->getAccessToken(true);
                if (!empty($newToken)) {
                    $options['headers']['Authorization'] = 'Bearer ' . $newToken;
                    $response = ($method === 'POST') ? $client->post($url, $options) : $client->get($url, $options);
                    $statusCode = $response->getStatusCode();
                }
            }

            $body = $response->getBody();

            if ($statusCode >= 200 && $statusCode < 300) {
                $data = json_decode($body, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    if ($useCache && !empty($data)) {
                        cache()->save($cacheKey, $data, $this->config->cacheTTL);
                    }
                    return $data;
                }
            }

            log_message('error', "UfkaApiService error: HTTP {$statusCode} on {$url} - {$body}");
            return null;
        } catch (\Throwable $e) {
            log_message('error', "UfkaApiService exception: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Tüm Web İçeriklerini (Duyuru, Haber, Kılavuz vb.) veya filtreli içerikleri döner
     *
     * @param array|bool $filtersOrCache Filtre parametreleri dizisi veya önbellek bayrağı
     * @param bool       $useCache       Önbellek kullanılsın mı?
     */
    public function getWebContents($filtersOrCache = [], bool $useCache = true): array
    {
        $filters = [];
        if (is_bool($filtersOrCache)) {
            $useCache = $filtersOrCache;
        } elseif (is_array($filtersOrCache)) {
            $filters = $filtersOrCache;
        }

        $result = $this->request('getWebContents', $filters, 'POST', $useCache);
        return is_array($result) ? $result : [];
    }

    /**
     * Belirli bir içeriği slug veya ID'ye göre bulup döner (büyük/küçük harf duyarsız ve alias destekli)
     */
    public function getWebContent(string $slugOrId, bool $useCache = true): ?array
    {
        $rawTarget = trim($slugOrId);
        $targetLower = strtolower($rawTarget);

        // 1. Doğrudan sunucu taraflı tekil slug sorgusu
        $direct = $this->getWebContents(['slug' => $rawTarget], $useCache);
        if (!empty($direct) && is_array($direct)) {
            return reset($direct);
        }

        // Yaygın URL takma adları (alias) eşleştirmesi
        $aliases = [
            'sartname'                  => ['sartname', 'mobil-yarisma-sartnamesi', 'yarisma-sartnamesi'],
            'yarisma-sartnamesi'        => ['sartname', 'mobil-yarisma-sartnamesi'],
            'kvkk'                      => ['uy-kvkk-aydinlatma-metni', 'kvkk'],
            'uy-kvkk-aydinlatma-metni'  => ['uy-kvkk-aydinlatma-metni', 'kvkk'],
            'gizlilik'                  => ['uy-mahremiyet-politikasi', 'mahremiyetpolitikasi', 'mahremiyet-politikasi'],
            'mahremiyet'                => ['uy-mahremiyet-politikasi', 'mahremiyetpolitikasi'],
            'uy-mahremiyet-politikasi'  => ['uy-mahremiyet-politikasi', 'mahremiyetpolitikasi', 'mahremiyet'],
            'veli-izni'                 => ['uy-veli-izin-belgesi', 'veli-izin-belgesi', 'veli-izni'],
            'veli-izin-belgesi'         => ['uy-veli-izin-belgesi', 'veli-izin-belgesi'],
            'uy-veli-izin-belgesi'      => ['uy-veli-izin-belgesi', 'veli-izin-belgesi'],
            'acik-riza'                 => ['uy-acik-riza-beyani', 'acik-riza-beyani'],
            'uy-acik-riza-beyani'       => ['uy-acik-riza-beyani', 'acik-riza-beyani'],
            'resmi-onaylar'             => ['resmi-onaylar', 'meb-onaylari', 'onaylar'],
            'biz-kimiz'                 => ['biz-kimiz', 'bizkimiz'],
            'misyon-vizyon'             => ['misyon-vizyon', 'misyonumuz-vizyonumuz'],
            'takvim'                    => ['takvimi'],
        ];

        $searchSlugs = [$targetLower];
        if (isset($aliases[$targetLower])) {
            $searchSlugs = array_unique(array_merge($searchSlugs, $aliases[$targetLower]));
        }

        // Alias'lar için sunucu sorgusu
        foreach ($searchSlugs as $aliasSlug) {
            if ($aliasSlug !== $rawTarget) {
                $aliasItem = $this->getWebContents(['slug' => $aliasSlug], $useCache);
                if (!empty($aliasItem) && is_array($aliasItem)) {
                    return reset($aliasItem);
                }
            }
        }

        // Bulunamazsa tüm içerik havuzundan ID veya slug ara (fallback)
        $contents = $this->getWebContents([], $useCache);
        foreach ($contents as $item) {
            $itemId   = (string)($item['id'] ?? '');
            $itemSlug = strtolower(trim($item['slug'] ?? ''));

            if ($itemId === $rawTarget || in_array($itemSlug, $searchSlugs, true)) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Yarışmacı telefon ve doğum tarihi ile API'den kullanıcı doğrular
     */
    public function verifyUser(string $phone, string $birthDate): ?array
    {
        // Telefon numarasını temizle (sadece rakamlar, başında 90 veya 0 varsa sadeleştir)
        $cleanPhone = preg_replace('/[^\d]/', '', $phone);
        if (str_starts_with($cleanPhone, '90') && strlen($cleanPhone) === 12) {
            $cleanPhone = substr($cleanPhone, 2);
        }
        if (str_starts_with($cleanPhone, '0') && strlen($cleanPhone) === 11) {
            $cleanPhone = substr($cleanPhone, 1);
        }

        // Doğum tarihi formatı: YYYY-MM-DD
        $formattedDate = date('Y-m-d', strtotime($birthDate));

        // API isteği
        $response = $this->request('getUfkaYolculukUser', [
            'mobile'    => $cleanPhone,
            'birthdate' => $formattedDate,
        ], 'POST', false);

        if (!empty($response) && is_array($response)) {
            // Eğer yanıt içinde 'data' veya 'user' varsa çıkart
            $userData = $response['data'] ?? ($response['user'] ?? $response);
            if (is_array($userData) && (!empty($userData['id']) || !empty($userData['name']) || !empty($userData['first_name']))) {
                return [
                    'id'             => $userData['id'] ?? null,
                    'name'           => trim(($userData['name'] ?? '') ?: (($userData['first_name'] ?? '') . ' ' . ($userData['last_name'] ?? ''))),
                    'mobile'         => $cleanPhone,
                    'birthdate'      => $formattedDate,
                    'category_title' => $userData['category_title'] ?? ($userData['category'] ?? 'Yarışmacı'),
                    'grade'          => $userData['grade'] ?? '',
                    'city'           => $userData['city_name'] ?? ($userData['city'] ?? ''),
                    'school'         => $userData['school_name'] ?? ($userData['school'] ?? ''),
                    'raw'            => $userData,
                ];
            }
        }

        return null;
    }

    /**
     * Kullanıcı ID'sine göre profil, liderlik ve okuma verilerini döner
     */
    public function getUserData(int $userId): ?array
    {
        $result = $this->request("getUserData/{$userId}", [], 'POST', false);
        return is_array($result) ? $result : null;
    }

    /**
     * Kullanıcı ID'sine göre sınav sonuçlarını, genel puanı, Türkiye ve il derecelerini döner
     * API Uç Noktası: getUserResults/{userId}
     */
    public function getUserResults(int $userId, bool $useCache = false): ?array
    {
        $result = $this->request("getUserResults/{$userId}", [], 'POST', $useCache);
        if (is_array($result) && !empty($result['status'])) {
            return $result;
        }
        return null;
    }

    /**
     * Kullanıcı ID'sine göre hak kazanılan katılım ve başarı sertifikalarını döner
     * API Uç Noktası: getCertificates/{userId}
     */
    public function getUserCertificates(int $userId, bool $useCache = false): array
    {
        $result = $this->request("getCertificates/{$userId}", [], 'POST', $useCache);
        if (is_array($result) && !empty($result['certificates'])) {
            return $result['certificates'];
        }
        return [];
    }

    /**
     * Kullanıcı ID'sine göre dinamik profil menüsünü döner
     * API Uç Noktası: getProfileMenu/{userId}
     */
    public function getProfileMenu(?int $userId = null, bool $useCache = true): array
    {
        $endpoint = 'getProfileMenu' . ($userId ? "/{$userId}" : '');
        $result = $this->request($endpoint, [], 'POST', $useCache);
        return is_array($result) ? $result : [];
    }


    /**
     * Yalnızca Duyuruları ve Haberleri filtreleyerek en yeniye göre sıralı döner (Sunucu Filtreli)
     */
    public function getAnnouncements(int $limit = 0, bool $useCache = true): array
    {
        // 1. Sunucu taraflı filtre: type=annoucement ve type=news
        $announcements = $this->getWebContents(['type' => 'annoucement'], $useCache);
        $news = $this->getWebContents(['type' => 'news'], $useCache);
        $combined = array_merge($announcements, $news);

        // Fallback: Sunucu filtresi boş dönerse tüm içeriklerden filtrele
        if (empty($combined)) {
            $contents = $this->getWebContents([], $useCache);
            foreach ($contents as $item) {
                $type = strtolower($item['type'] ?? '');
                if (in_array($type, ['annoucement', 'announcement', 'news', 'duyuru', 'haber'])) {
                    $combined[] = $item;
                }
            }
        }

        // Benzersiz kayıt listesi oluştur
        $unique = [];
        foreach ($combined as $item) {
            $id = $item['id'] ?? uniqid();
            $unique[$id] = $item;
        }
        $result = array_values($unique);

        // En yeni duyurular başta gelsin (ID DESC)
        usort($result, function ($a, $b) {
            return ((int) ($b['id'] ?? 0)) <=> ((int) ($a['id'] ?? 0));
        });

        if ($limit > 0) {
            return array_slice($result, 0, $limit);
        }

        return $result;
    }

    /**
     * Sıkça Sorulan Soruları (type='sss') ve kategorilerini derler (Sunucu Filtreli)
     */
    public function getFaqList(bool $useCache = true): array
    {
        // 1. Sunucu taraflı doğrudan SSS kayıtlarını çek (18 kayıt)
        $allContents = $this->getWebContents(['type' => 'sss'], $useCache);
        if (empty($allContents)) {
            $allContents = $this->getWebContents([], $useCache);
        }
        $faqs = [];

        $categoryConfig = [
            'yarisma' => [
                'slug'  => 'yarisma',
                'name'  => 'Yarışma & Katılım',
                'icon'  => '🎯',
                'match' => ['yarisma', 'katilim', 'genel'],
            ],
            'oduller' => [
                'slug'  => 'oduller',
                'name'  => 'Ödüller',
                'icon'  => '🏆',
                'match' => ['odul', 'odulleri', 'umre'],
            ],
            'kitap' => [
                'slug'  => 'kitap',
                'name'  => 'Yarışma Kitapları',
                'icon'  => '📚',
                'match' => ['kitap', 'e-kitap', 'eser'],
            ],
            'sinav' => [
                'slug'  => 'sinav',
                'name'  => 'Sınav Kuralları',
                'icon'  => '📝',
                'match' => ['sinav', 'kural', 'online'],
            ],
            'takim' => [
                'slug'  => 'takim',
                'name'  => 'Takım Lideri',
                'icon'  => '⭐',
                'match' => ['takim', 'lider', 'danisman'],
            ],
        ];

        foreach ($allContents as $wc) {
            if (($wc['type'] ?? '') !== 'sss') {
                continue;
            }

            $id       = (int)($wc['id'] ?? 0);
            $title    = trim($wc['title'] ?? '');
            $body     = trim($wc['body'] ?? '');
            $slug     = trim($wc['slug'] ?? '');
            $rawCat   = trim($wc['primary_category']['title'] ?? ($wc['category_title'] ?? 'Genel'));
            $normCat  = $this->normalizeTurkish($rawCat);
            $normTitle= $this->normalizeTurkish($title);

            // Kategori eşleştirmesi
            $assignedGroup = 'yarisma';
            foreach ($categoryConfig as $catKey => $cfg) {
                foreach ($cfg['match'] as $m) {
                    if (str_contains($normCat, $m) || str_contains($normTitle, $m)) {
                        $assignedGroup = $catKey;
                        break 2;
                    }
                }
            }

            $faqs[] = [
                'id'            => $id,
                'title'         => $title,
                'body'          => $body,
                'body_clean'    => strip_tags($body),
                'slug'          => $slug,
                'category_key'  => $assignedGroup,
                'category_name' => $categoryConfig[$assignedGroup]['name'],
                'category_icon' => $categoryConfig[$assignedGroup]['icon'],
                'raw_category'  => $rawCat,
            ];
        }

        // Düzenli sıralama (ID ASC)
        usort($faqs, function ($a, $b) {
            return $a['id'] <=> $b['id'];
        });

        // Kategori bazlı sayaçlar
        $counts = ['all' => count($faqs)];
        foreach ($categoryConfig as $k => $c) {
            $counts[$k] = 0;
        }
        foreach ($faqs as $f) {
            $k = $f['category_key'];
            if (isset($counts[$k])) {
                $counts[$k]++;
            }
        }

        return [
            'items'      => $faqs,
            'categories' => $categoryConfig,
            'counts'     => $counts,
            'total'      => count($faqs),
        ];
    }

    /**
     * Türkiye geneli veya belirli bir ile ait ödülleri döner
     */
    /**
     * Türkiye geneli veya belirli bir ile ait ödülleri döner
     */
    public function getAwards(?int $cityId = null, bool $useCache = true): array
    {
        $endpoint = 'getAwards' . ($cityId ? "/{$cityId}" : '');
        $result = $this->request($endpoint, [], 'POST', $useCache);
        return is_array($result) ? $result : [];
    }

    /**
     * Türkiye Geneli ödüllerini kategorilerine göre podyum (1., 2., 3.) ve sıralama fayansları olarak derler
     */
    public function getNationalAwardsFormatted(bool $useCache = true): array
    {
        $allAwards = $this->getAwards(null, $useCache);
        $grouped = [];

        // Standart kategori anahtarları ve sekme eşleştirmeleri
        $catMeta = [
            'ilkokul'  => ['name' => 'İlkokul', 'tab_id' => 'nat-ilkokul', 'badge' => '🌱 İlkokul', 'icon' => '🌱'],
            'ortaokul' => ['name' => 'Ortaokul', 'tab_id' => 'nat-ortaokul', 'badge' => '📖 Ortaokul', 'icon' => '📖'],
            'lise'     => ['name' => 'Lise', 'tab_id' => 'nat-lise', 'badge' => '📖 Lise', 'icon' => '📖'],
            'yetiskin' => ['name' => 'Yetişkin', 'tab_id' => 'nat-yetiskin', 'badge' => '🎓 Yetişkin', 'icon' => '🎓'],
            'ilahiyat' => ['name' => 'İlahiyat', 'tab_id' => 'nat-ilahiyat', 'badge' => '🕌 İlahiyat', 'icon' => '🕌'],
            'meb'      => ['name' => 'Takım Lideri (MEB)', 'tab_id' => 'nat-meb', 'badge' => '⭐ Takım Lideri (MEB)', 'icon' => '⭐'],
            'stk'      => ['name' => 'Takım Lideri (STK)', 'tab_id' => 'nat-stk', 'badge' => '⭐ Takım Lideri (STK)', 'icon' => '⭐'],
            'bagimsiz' => ['name' => 'Takım Lideri (Bağımsız)', 'tab_id' => 'nat-bagimsiz', 'badge' => '⭐ Takım Lideri (Bağımsız)', 'icon' => '⭐'],
        ];

        // API'deki country ödüllerini filtrele
        $countryRecords = [];
        foreach ($allAwards as $aw) {
            if (($aw['type'] ?? '') === 'country') {
                $cName = trim($aw['category_name'] ?? '');
                $countryRecords[$cName][] = $aw;
            }
        }

        foreach ($catMeta as $key => $meta) {
            // Eşleşen API kaydını bul (Türkçe karakter duyarlı)
            $matchedRecord = null;
            $metaNorm = $this->normalizeTurkish($meta['name']);

            foreach ($countryRecords as $cName => $recList) {
                $cNorm = $this->normalizeTurkish($cName);
                if (str_contains($cNorm, $metaNorm) || str_contains($metaNorm, $cNorm)) {
                    $matchedRecord = $recList[0] ?? null;
                    break;
                }
            }

            $awardsList = $matchedRecord['awards'] ?? [];

            // Podyum derecelerini formatla
            $podium = [
                'gold'   => $this->formatPrizeValue($awardsList[0] ?? null, 1, $key),
                'silver' => $this->formatPrizeValue($awardsList[1] ?? null, 2, $key),
                'bronze' => $this->formatPrizeValue($awardsList[2] ?? null, 3, $key),
            ];

            // 4. ve sonraki dereceleri aralıklara grupla
            $remaining = array_slice($awardsList, 3);
            $tiles = $this->groupRankTiles($remaining, 4);

            $grouped[$key] = [
                'key'      => $key,
                'name'     => $meta['name'],
                'tab_id'   => $meta['tab_id'],
                'badge'    => $meta['badge'],
                'icon'     => $meta['icon'],
                'podium'   => $podium,
                'tiles'    => $tiles,
                'raw_count'=> count($awardsList),
            ];
        }

        return $grouped;
    }

    /**
     * Tekil ödül elemanını kullanıcı dostu metne ve para formatına dönüştürür
     */
    private function formatPrizeValue(?array $item, int $rank, string $catKey): array
    {
        $val = $item['award'] ?? '';
        $type = $item['type'] ?? 'money';

        $title = match ($rank) {
            1 => '1. Türkiye Birincisi',
            2 => '2. Türkiye İkincisi',
            3 => '3. Türkiye Üçüncüsü',
            default => "{$rank}. Derece",
        };

        if ($type === 'other' || mb_strtolower($val) === 'umre') {
            $prizeVal = '🕋 Umre Ödülü';
            $cashEquivalent = match ($rank) {
                1 => 'veya 35.000₺ Eşdeğer Nakit Karşılığı',
                2 => 'veya 30.000₺ Eşdeğer Nakit Karşılığı',
                3 => 'veya 25.000₺ Eşdeğer Nakit Karşılığı',
                default => 'Umre Seyahati Başarı Ödülü',
            };
        } else {
            // Sayısal ödül
            $numVal = preg_replace('/[^\d]/', '', $val);
            if (is_numeric($numVal) && (int)$numVal > 0) {
                $formattedNum = number_format((int)$numVal, 0, ',', '.') . '₺';
            } else {
                $formattedNum = $val . '₺';
            }

            if (in_array($catKey, ['yetiskin', 'ilahiyat', 'meb', 'stk', 'bagimsiz'], true) && $rank === 1) {
                $prizeVal = $formattedNum . ' + 🕋 Umre';
                $cashEquivalent = 'Büyük Başarı Paketi';
            } else {
                $prizeVal = $formattedNum;
                $cashEquivalent = 'Nakit Eğitim & Başarı Bursu';
            }
        }

        return [
            'rank_title' => $title,
            'prize_val'  => $prizeVal,
            'desc'       => $cashEquivalent,
            'rank'       => $rank,
        ];
    }

    /**
     * 4. ve sonraki sıralamaları mantıklı derece aralıklarına (tile) gruplar
     */
    private function groupRankTiles(array $items, int $startRank = 4): array
    {
        if (empty($items)) {
            // Varsayılan standart aralıklar
            return [
                ['tag' => '4. - 10.', 'amount' => '15.000₺'],
                ['tag' => '11. - 20.', 'amount' => '15.000₺'],
                ['tag' => '21. - 30.', 'amount' => '12.000₺'],
                ['tag' => '31. - 40.', 'amount' => '10.000₺'],
                ['tag' => '41. - 60.', 'amount' => '5.000₺'],
                ['tag' => '61. - 80.', 'amount' => '5.000₺'],
                ['tag' => '81. - 100.', 'amount' => '5.000₺'],
            ];
        }

        $tiles = [];
        $n = count($items);
        $i = 0;

        while ($i < $n) {
            $currentVal = $items[$i]['award'] ?? '';
            $start = $startRank + $i;
            $end = $start;

            while ($i + 1 < $n && ($items[$i + 1]['award'] ?? '') === $currentVal) {
                $i++;
                $end = $startRank + $i;
            }

            $numVal = preg_replace('/[^\d]/', '', $currentVal);
            $amtStr = (is_numeric($numVal) && (int)$numVal > 0) ? number_format((int)$numVal, 0, ',', '.') . '₺' : $currentVal;

            $tag = ($start === $end) ? "{$start}." : "{$start}. - {$end}.";
            $tiles[] = [
                'tag'    => $tag,
                'amount' => $amtStr,
            ];
            $i++;
        }

        return $tiles;
    }

    /**
     * Ufka Yolculuk Yarışma İlleri Listesi (id ve name içeren liste)
     */
    public function getCities(): array
    {
        return [
            ['id' => 1, 'name' => 'Adana'], ['id' => 2, 'name' => 'Adıyaman'], ['id' => 3, 'name' => 'Afyonkarahisar'],
            ['id' => 4, 'name' => 'Ağrı'], ['id' => 68, 'name' => 'Aksaray'], ['id' => 5, 'name' => 'Amasya'],
            ['id' => 6, 'name' => 'Ankara'], ['id' => 7, 'name' => 'Antalya'], ['id' => 75, 'name' => 'Ardahan'],
            ['id' => 8, 'name' => 'Artvin'], ['id' => 9, 'name' => 'Aydın'], ['id' => 10, 'name' => 'Balıkesir'],
            ['id' => 74, 'name' => 'Bartın'], ['id' => 72, 'name' => 'Batman'], ['id' => 69, 'name' => 'Bayburt'],
            ['id' => 11, 'name' => 'Bilecik'], ['id' => 12, 'name' => 'Bingöl'], ['id' => 13, 'name' => 'Bitlis'],
            ['id' => 14, 'name' => 'Bolu'], ['id' => 15, 'name' => 'Burdur'], ['id' => 16, 'name' => 'Bursa'],
            ['id' => 17, 'name' => 'Çanakkale'], ['id' => 18, 'name' => 'Çankırı'], ['id' => 19, 'name' => 'Çorum'],
            ['id' => 20, 'name' => 'Denizli'], ['id' => 21, 'name' => 'Diyarbakır'], ['id' => 81, 'name' => 'Düzce'],
            ['id' => 22, 'name' => 'Edirne'], ['id' => 23, 'name' => 'Elazığ'], ['id' => 24, 'name' => 'Erzincan'],
            ['id' => 25, 'name' => 'Erzurum'], ['id' => 26, 'name' => 'Eskişehir'], ['id' => 27, 'name' => 'Gaziantep'],
            ['id' => 28, 'name' => 'Giresun'], ['id' => 29, 'name' => 'Gümüşhane'], ['id' => 30, 'name' => 'Hakkari'],
            ['id' => 31, 'name' => 'Hatay'], ['id' => 76, 'name' => 'Iğdır'], ['id' => 32, 'name' => 'Isparta'],
            ['id' => 34, 'name' => 'İstanbul'], ['id' => 35, 'name' => 'İzmir'], ['id' => 46, 'name' => 'Kahramanmaraş'],
            ['id' => 78, 'name' => 'Karabük'], ['id' => 70, 'name' => 'Karaman'], ['id' => 36, 'name' => 'Kars'],
            ['id' => 37, 'name' => 'Kastamonu'], ['id' => 38, 'name' => 'Kayseri'], ['id' => 79, 'name' => 'Kilis'],
            ['id' => 71, 'name' => 'Kırıkkale'], ['id' => 39, 'name' => 'Kırklareli'], ['id' => 40, 'name' => 'Kırşehir'],
            ['id' => 41, 'name' => 'Kocaeli'], ['id' => 42, 'name' => 'Konya'], ['id' => 43, 'name' => 'Kütahya'],
            ['id' => 44, 'name' => 'Malatya'], ['id' => 45, 'name' => 'Manisa'], ['id' => 47, 'name' => 'Mardin'],
            ['id' => 33, 'name' => 'Mersin'], ['id' => 48, 'name' => 'Muğla'], ['id' => 49, 'name' => 'Muş'],
            ['id' => 50, 'name' => 'Nevşehir'], ['id' => 51, 'name' => 'Niğde'], ['id' => 52, 'name' => 'Ordu'],
            ['id' => 80, 'name' => 'Osmaniye'], ['id' => 53, 'name' => 'Rize'], ['id' => 54, 'name' => 'Sakarya'],
            ['id' => 55, 'name' => 'Samsun'], ['id' => 63, 'name' => 'Şanlıurfa'], ['id' => 56, 'name' => 'Siirt'],
            ['id' => 57, 'name' => 'Sinop'], ['id' => 73, 'name' => 'Şırnak'], ['id' => 58, 'name' => 'Sivas'],
            ['id' => 59, 'name' => 'Tekirdağ'], ['id' => 60, 'name' => 'Tokat'], ['id' => 61, 'name' => 'Trabzon'],
            ['id' => 62, 'name' => 'Tunceli'], ['id' => 64, 'name' => 'Uşak'], ['id' => 65, 'name' => 'Van'],
            ['id' => 77, 'name' => 'Yalova'], ['id' => 66, 'name' => 'Yozgat'], ['id' => 67, 'name' => 'Zonguldak'],
        ];
    }

    /**
     * 81 İl ve Yurtdışı Alfabetik Şehir Listesi
     */
    public function getAwardCities(bool $useCache = true): array
    {
        $allAwards = $this->getAwards(null, $useCache);
        $cityNames = [];

        foreach ($allAwards as $aw) {
            if (!empty($aw['city_name'])) {
                $name = trim($aw['city_name']);
                $cityNames[$name] = true;
            }
        }

        // Türkiye'nin 81 standart ili (eksik kalmaması için kontrol)
        $standardCities = [
            'Adana', 'Adıyaman', 'Afyonkarahisar', 'Ağrı', 'Aksaray', 'Amasya', 'Ankara', 'Antalya',
            'Ardahan', 'Artvin', 'Aydın', 'Balıkesir', 'Bartın', 'Batman', 'Bayburt', 'Bilecik',
            'Bingöl', 'Bitlis', 'Bolu', 'Burdur', 'Bursa', 'Çanakkale', 'Çankırı', 'Çorum',
            'Denizli', 'Diyarbakır', 'Düzce', 'Edirne', 'Elazığ', 'Erzincan', 'Erzurum', 'Eskişehir',
            'Gaziantep', 'Giresun', 'Gümüşhane', 'Hakkari', 'Hatay', 'Iğdır', 'Isparta', 'İstanbul',
            'İzmir', 'Kahramanmaraş', 'Karabük', 'Karaman', 'Kars', 'Kastamonu', 'Kayseri', 'Kilis',
            'Kırıkkale', 'Kırklareli', 'Kırşehir', 'Kocaeli', 'Konya', 'Kütahya', 'Malatya', 'Manisa',
            'Mardin', 'Mersin', 'Muğla', 'Muş', 'Nevşehir', 'Niğde', 'Ordu', 'Osmaniye',
            'Rize', 'Sakarya', 'Samsun', 'Şanlıurfa', 'Siirt', 'Sinop', 'Sivas', 'Şırnak',
            'Tekirdağ', 'Tokat', 'Trabzon', 'Tunceli', 'Uşak', 'Van', 'Yalova', 'Yozgat', 'Zonguldak',
            'Yurtdışı'
        ];

        foreach ($standardCities as $c) {
            $cityNames[$c] = true;
        }

        $result = array_keys($cityNames);
        usort($result, function ($a, $b) {
            if (class_exists('Collator')) {
                $coll = collator_create('tr_TR');
                if ($coll) {
                    return $coll->compare($a, $b);
                }
            }
            return strcmp($a, $b);
        });

        return $result;
    }

    /**
     * Tüm illerin ödül verilerini haritalandırarak döner (JS / AJAX için)
     */
    public function getCityAwardsMap(bool $useCache = true): array
    {
        $allAwards = $this->getAwards(null, $useCache);
        $map = [];

        foreach ($allAwards as $aw) {
            if (!empty($aw['city_name'])) {
                $city = trim($aw['city_name']);
                $map[$city][] = $aw;
            }
        }

        $formattedMap = [];
        $allCities = $this->getAwardCities($useCache);

        foreach ($allCities as $city) {
            $records = $map[$city] ?? [];
            $formattedMap[$city] = $this->buildSingleCityAwards($city, $records);
        }

        return $formattedMap;
    }

    /**
     * Tek bir il için podyum derecelerini, ilçe ödüllerini ve notlarını derler
     */
    public function getCityAwardsFormatted(string $cityName, bool $useCache = true): array
    {
        $map = $this->getCityAwardsMap($useCache);
        return $map[$cityName] ?? $this->buildSingleCityAwards($cityName, []);
    }

    /**
     * Tekil il ödül yapısını inşa eder (kategoriler bazında ve genel)
     */
    private function buildSingleCityAwards(string $cityName, array $records): array
    {
        $categoriesMap = [
            'ilkokul'      => ['title' => 'İlkokul', 'match' => ['ilkokul', '45']],
            'ortaokul'     => ['title' => 'Ortaokul', 'match' => ['ortaokul', '46']],
            'lise'         => ['title' => 'Lise', 'match' => ['lise', '47']],
            'yetiskin'     => ['title' => 'Yetişkin', 'match' => ['yetiskin', '48']],
            'ilahiyat'     => ['title' => 'İlahiyat', 'match' => ['ilahiyat', '49']],
            'takim_lideri' => ['title' => 'Takım Lideri', 'match' => ['takim', 'lider', 'meb', 'stk', 'bagimsiz']],
        ];

        // Kategorilere göre ana ve ilçe kayıtlarını topla
        $mainByCategory = [];
        $districtsByCategory = [];
        $allDistrictRecords = [];

        foreach ($records as $rec) {
            $catNorm = $this->normalizeTurkish($rec['category_name'] ?? '');
            $catId = (string)($rec['category_id'] ?? '');
            $awardsList = $rec['awards'] ?? [];
            $isMain = (($rec['type'] ?? '') === 'city' || count($awardsList) >= 8);

            // Hangi kategoriye ait olduğunu bul
            $matchedKey = null;
            foreach ($categoriesMap as $key => $info) {
                foreach ($info['match'] as $m) {
                    if (str_contains($catNorm, $m) || $catId === $m) {
                        $matchedKey = $key;
                        break 2;
                    }
                }
            }

            if ($matchedKey) {
                if ($isMain && !isset($mainByCategory[$matchedKey])) {
                    $mainByCategory[$matchedKey] = $awardsList;
                } else {
                    $districtsByCategory[$matchedKey][] = $rec;
                    $allDistrictRecords[] = $rec;
                }
            } else {
                $allDistrictRecords[] = $rec;
            }
        }

        // Genel / Varsayılan İl Ödülü (İlkokul, Ortaokul veya ilk bulunan)
        $primaryMain = $mainByCategory['ilkokul'] ?? (reset($mainByCategory) ?: []);
        $defaultLead   = $this->formatMoneyString($primaryMain[0]['award'] ?? null, 'Yarım Altın / 15.000₺ Değerinde Ödül');
        $defaultSecond = $this->formatMoneyString($primaryMain[1]['award'] ?? null, 'Çeyrek Altın / 10.000₺ Değerinde Ödül');
        $defaultThird  = $this->formatMoneyString($primaryMain[2]['award'] ?? null, 'Gram Altın / 5.000₺ Değerinde Ödül');
        $defaultHonorable = $this->formatMoneyString($primaryMain[3]['award'] ?? null, '2.500₺ Başarı Teşvik Desteği') . ' (4. - 10.)';

        // Varsayılan ilçe listesi
        $defaultDistricts = [];
        if (!empty($allDistrictRecords)) {
            $dIndex = 1;
            foreach (array_slice($allDistrictRecords, 0, 4) as $dRec) {
                $cat = $dRec['category_name'] ?? 'Genel';
                $dList = $dRec['awards'] ?? [];
                $d1 = $this->formatMoneyString($dList[0]['award'] ?? null, 'Çeyrek Altın');
                $d2 = $this->formatMoneyString($dList[1]['award'] ?? null, 'Gram Altın');
                $d3 = $this->formatMoneyString($dList[2]['award'] ?? null, '1.500₺ Çek');
                $dName = !empty($dRec['notes']) ? trim($dRec['notes']) : "{$cityName} {$cat} Başarı Grubu {$dIndex}";
                $defaultDistricts[] = [
                    'name'   => $dName,
                    'awards' => "1. {$d1} | 2. {$d2} | 3. {$d3}",
                ];
                $dIndex++;
            }
        } else {
            $defaultDistricts = [
                ['name' => 'Merkez İlçeler', 'awards' => '1. Çeyrek Altın | 2. Gram Altın | 3. 2.000₺ Hediye Çeki'],
                ['name' => 'Diğer Tüm İlçeler', 'awards' => '1. Gram Altın | 2. 1.500₺ Hediye Çeki | 3. 1.000₺ Kitap Seti'],
            ];
        }

        // Kategori bazlı paket hazırla
        $categoriesData = [];
        foreach ($categoriesMap as $catKey => $catInfo) {
            $catMain = $mainByCategory[$catKey] ?? $primaryMain;
            $catDistRecs = (!empty($districtsByCategory[$catKey])) ? $districtsByCategory[$catKey] : $allDistrictRecords;

            $cLead = $this->formatMoneyString($catMain[0]['award'] ?? null, $defaultLead);
            $cSecond = $this->formatMoneyString($catMain[1]['award'] ?? null, $defaultSecond);
            $cThird = $this->formatMoneyString($catMain[2]['award'] ?? null, $defaultThird);
            $cHonorable = $this->formatMoneyString($catMain[3]['award'] ?? null, '2.500₺ Başarı Teşvik Desteği') . ' (4. - 10.)';

            $cDistricts = [];
            if (!empty($catDistRecs)) {
                $dIdx = 1;
                foreach (array_slice($catDistRecs, 0, 4) as $dRec) {
                    $dList = $dRec['awards'] ?? [];
                    $d1 = $this->formatMoneyString($dList[0]['award'] ?? null, 'Çeyrek Altın');
                    $d2 = $this->formatMoneyString($dList[1]['award'] ?? null, 'Gram Altın');
                    $d3 = $this->formatMoneyString($dList[2]['award'] ?? null, '1.500₺ Çek');
                    $dName = !empty($dRec['notes']) ? trim($dRec['notes']) : "{$cityName} {$catInfo['title']} Başarı Grubu {$dIdx}";
                    $cDistricts[] = [
                        'name'   => $dName,
                        'awards' => "1. {$d1} | 2. {$d2} | 3. {$d3}",
                    ];
                    $dIdx++;
                }
            } else {
                $cDistricts = $defaultDistricts;
            }

            $categoriesData[$catKey] = [
                'title'     => $catInfo['title'],
                'lead'      => $cLead,
                'second'    => $cSecond,
                'third'     => $cThird,
                'honorable' => $cHonorable,
                'districts' => $cDistricts,
            ];
        }

        return [
            'city_name'    => $cityName,
            'lead'         => $defaultLead,
            'second'       => $defaultSecond,
            'third'        => $defaultThird,
            'honorable'    => $defaultHonorable,
            'districts'    => $defaultDistricts,
            'notes'        => "{$cityName} il ödülleri, Ufka Yolculuk İl Temsilciliği ve proje paydaşlarımız tarafından sınav sonrası düzenlenecek il ödül töreninde kazanan yarışmacılara takdim edilecektir.",
            'has_api_data' => !empty($records),
            'categories'   => $categoriesData,
        ];
    }

    /**
     * Türkçe karakterleri ASCII eşdeğerlerine normalize eder
     */
    public function normalizeTurkish(string $str): string
    {
        $str = str_replace(
            ['İ', 'I', 'ı', 'ğ', 'Ğ', 'ü', 'Ü', 'ş', 'Ş', 'ö', 'Ö', 'ç', 'Ç'],
            ['i', 'i', 'i', 'g', 'g', 'u', 'u', 's', 's', 'o', 'o', 'c', 'c'],
            $str
        );
        return strtolower(trim($str));
    }

    private function formatMoneyString(?string $val, string $fallback): string
    {
        if (empty($val)) return $fallback;
        $num = preg_replace('/[^\d]/', '', $val);
        if (is_numeric($num) && (int)$num > 0) {
            return number_format((int)$num, 0, ',', '.') . '₺';
        }
        return $val;
    }

    /**
     * Yarışma kitap kategorilerini ve kategorilerdeki kitapları döner
     */
    public function getBookCategories(bool $useCache = true): array
    {
        $result = $this->request('getBookCategories', [], 'POST', $useCache);
        return is_array($result) ? $result : [];
    }

    /**
     * Anasayfa ve kitap vitrini için aktif yarışma kategorilerini ve kitaplarını formatlayarak döner
     */
    public function getCompetitionCategories(bool $useCache = true): array
    {
        $rawCategories = $this->getBookCategories($useCache);
        $competitionList = [];

        // Standart kategori konfigürasyonları
        $catConfigs = [
            'ilkokul' => [
                'match_ids'      => [6],
                'match_keywords' => ['ilkokul'],
                'slug'           => 'ilkokul',
                'title'          => 'İlkokul Kategorisi',
                'theme'          => 'green',
                'badge'          => '⭐ İLKOKUL',
                'icon'           => '🌱',
                'grade'          => '1 - 4. Sınıf',
                'age'            => '6 - 10 Yaş (İlkokul Kademesi)',
                'sub'            => 'Eğlenceli Bilgiler, Erdemler ve Hikayeler',
                'publisher'      => 'Ufka Yolculuk Çocuk Yayınları',
                'questions'      => '40 Soru (Çoktan Seçmeli)',
                'fallback_image' => 'assets/images/book-ilkokul-3d.webp',
                'read_url'       => 'https://kutuphane.ufkayolculuk.com/kitap/ilkokul',
                'listen_url'     => 'https://sesli.ufkayolculuk.com/dinle/ilkokul',
            ],
            'ortaokul' => [
                'match_ids'      => [7],
                'match_keywords' => ['ortaokul'],
                'slug'           => 'ortaokul',
                'title'          => 'Ortaokul Kategorisi',
                'theme'          => 'amber',
                'badge'          => '⭐ ORTAOKUL',
                'icon'           => '🧭',
                'grade'          => '5 - 8. Sınıf',
                'age'            => '10 - 14 Yaş (Ortaokul Kademesi)',
                'sub'            => 'Macera, Keşif ve Bilim Yarışmaları',
                'publisher'      => 'Ufka Yolculuk Gençlik Yayınları',
                'questions'      => '50 Soru (Çoktan Seçmeli)',
                'fallback_image' => 'assets/images/book-ortaokul-3d.webp',
                'read_url'       => 'https://kutuphane.ufkayolculuk.com/kitap/ortaokul',
                'listen_url'     => 'https://sesli.ufkayolculuk.com/dinle/ortaokul',
            ],
            'lise' => [
                'match_ids'      => [8],
                'match_keywords' => ['lise'],
                'slug'           => 'lise',
                'title'          => 'Lise Kategorisi',
                'theme'          => 'blue',
                'badge'          => '⭐ LİSE',
                'icon'           => '🎓',
                'grade'          => '9 - 12. Sınıf',
                'age'            => '14 - 18 Yaş (Lise Kademesi)',
                'sub'            => 'Eleştirel Düşünce ve İrade Rehberi',
                'publisher'      => 'Ufka Yolculuk Akademi Yayınları',
                'questions'      => '50 Soru (Çoktan Seçmeli)',
                'fallback_image' => 'assets/images/book-lise-3d.webp',
                'read_url'       => 'https://kutuphane.ufkayolculuk.com/kitap/lise',
                'listen_url'     => 'https://sesli.ufkayolculuk.com/dinle/lise',
            ],
            'yetiskin' => [
                'match_ids'      => [9],
                'match_keywords' => ['yetişkin', 'yetiskin'],
                'slug'           => 'yetiskin',
                'title'          => 'Yetişkin Kategorisi',
                'theme'          => 'purple',
                'badge'          => '⭐ YETİŞKİN',
                'icon'           => '🏛️',
                'grade'          => '18+ Yaş & Üniversite',
                'age'            => '18+ Yaş & Tüm Yetişkinler',
                'sub'            => 'Literatür, Bilgelik ve Medeniyet Tasavvuru',
                'publisher'      => 'Ufka Yolculuk Prestij Eserler',
                'questions'      => '50 Soru (Çoktan Seçmeli)',
                'fallback_image' => 'assets/images/book-yetiskin-3d.webp',
                'read_url'       => 'https://kutuphane.ufkayolculuk.com/kitap/yetiskin',
                'listen_url'     => 'https://sesli.ufkayolculuk.com/dinle/yetiskin',
            ],
        ];

        foreach ($catConfigs as $key => $config) {
            $foundCat = null;
            foreach ($rawCategories as $cat) {
                $catId = (int)($cat['id'] ?? 0);
                $catTitle = mb_strtolower($cat['title'] ?? ($cat['name'] ?? ''));

                if (in_array($catId, $config['match_ids'], true)) {
                    $foundCat = $cat;
                    break;
                }

                foreach ($config['match_keywords'] as $kw) {
                    if (str_contains($catTitle, $kw) && !empty($cat['books'])) {
                        $foundCat = $cat;
                        break 2;
                    }
                }
            }

            // Kategoriye ait ilk aktif kitabı al
            $book = null;
            if ($foundCat && !empty($foundCat['books'])) {
                $book = $foundCat['books'][0];
            }

            $bookName = $book['name'] ?? ($book['title'] ?? 'Ufka Yolculuk Kitabı');
            $bookDescHtml = $book['description'] ?? '';
            $bookDescClean = trim(strip_tags(html_entity_decode($bookDescHtml, ENT_QUOTES, 'UTF-8')));
            $bookDescSummary = mb_substr($bookDescClean, 0, 240);
            if (mb_strlen($bookDescClean) > 240) {
                $bookDescSummary .= '...';
            }

            $rawImage = $book['image'] ?? null;
            $imageUrl = $rawImage ? $this->getMediaUrl($rawImage) : base_url($config['fallback_image']);

            $rawSound = $book['sound_file'] ?? null;
            $soundUrl = $rawSound ? $this->getMediaUrl($rawSound) : null;

            $competitionList[$key] = [
                'id'              => $foundCat['id'] ?? 0,
                'slug'            => $config['slug'],
                'title'           => $foundCat['title'] ?? ($foundCat['name'] ?? $config['title']),
                'theme'           => $config['theme'],
                'badge'           => $config['badge'],
                'icon'            => $config['icon'],
                'grade'           => $config['grade'],
                'age'             => $config['age'],
                'sub'             => $config['sub'],
                'publisher'       => $config['publisher'],
                'questions'       => $config['questions'],
                'fallback_image'  => base_url($config['fallback_image']),
                'read_url'        => $config['read_url'],
                'listen_url'      => $config['listen_url'],
                'book'            => [
                    'id'          => $book['id'] ?? null,
                    'name'        => $bookName,
                    'image'       => $rawImage,
                    'image_url'   => $imageUrl,
                    'sound_file'  => $rawSound,
                    'sound_url'   => $soundUrl,
                    'xml_file'    => $book['xml_file'] ?? null,
                    'desc_html'   => $bookDescHtml,
                    'desc_clean'  => $bookDescClean,
                    'desc_summary'=> $bookDescSummary,
                ]
            ];
        }

        return $competitionList;
    }

    /**
     * Tüm aktif kitap listesini ses dosyaları ve kapak resimleriyle döner
     */
    public function getBooks(bool $useCache = true): array
    {
        $result = $this->request('getBooks', [], 'POST', $useCache);
        return is_array($result) ? $result : [];
    }

    /**
     * Tek bir kitabın sayfa resimlerini ve detaylarını döner
     */
    public function getBook(int $bookId): ?array
    {
        return $this->request("getBook/{$bookId}", [], 'POST', true);
    }

    /**
     * Çevrim içi deneme sınavlarını döner
     */
    public function getExams(bool $useCache = true): array
    {
        $result = $this->request('getExams', [], 'POST', $useCache);
        return is_array($result) ? $result : [];
    }

    /**
     * API'deki resmi getImportantDates uç noktasından aktif yarışma tarihlerini ve geri sayım sayaçlarını döner
     */
    public function getImportantDates(bool $useCache = true): array
    {
        // 1. Yeni resmi API uç noktasını çağır (web_dates tablosundan)
        $apiDates = $this->request('getImportantDates', [], 'GET', $useCache);

        if (is_array($apiDates) && !empty($apiDates)) {
            $dates = [];
            foreach ($apiDates as $item) {
                $targetIso = $item['target_iso'] ?? '';
                if (empty($targetIso) && !empty($item['start_date'])) {
                    $targetIso = date('Y-m-d\TH:i:s', strtotime($item['start_date']));
                }

                $timeFormatted = $item['time_formatted'] ?? '';
                if (empty($timeFormatted) && !empty($item['start_date'])) {
                    $timeFormatted = date('H:i', strtotime($item['start_date']));
                }

                $dates[] = [
                    'id'              => (string)($item['id'] ?? ($item['key'] ?? uniqid())),
                    'key'             => (string)($item['key'] ?? ''),
                    'badge'           => $item['badge'] ?? 'Online Sınav',
                    'title'           => $item['title'] ?? '',
                    'sub_title'       => $item['sub_title'] ?? ('Online Sınav' . ($timeFormatted ? " (Saat {$timeFormatted})" : '')),
                    'date_formatted'  => $item['date_formatted'] ?? '',
                    'time_formatted'  => $timeFormatted,
                    'target_iso'      => $targetIso,
                    'countdown_label' => $item['countdown_label'] ?? (($item['title'] ?? 'Sınava') . ' Kalan Süre'),
                    'icon_type'       => $item['icon_type'] ?? 'exam',
                    'prefix'          => $item['prefix'] ?? '',
                    'is_countdown'    => $item['is_countdown'] ?? '1',
                    'is_past'         => !empty($item['is_past']),
                ];
            }

            if (!empty($dates)) {
                return $dates;
            }
        }

        // 2. Fallback: API'den veri dönmezse getExams üzerinden derle
        $exams = $this->getExams($useCache);
        $dates = [];

        $turkishMonths = [
            1 => 'Ocak', 2 => 'Şubat', 3 => 'Mart', 4 => 'Nisan',
            5 => 'Mayıs', 6 => 'Haziran', 7 => 'Temmuz', 8 => 'Ağustos',
            9 => 'Eylül', 10 => 'Ekim', 11 => 'Kasım', 12 => 'Aralık'
        ];

        usort($exams, function ($a, $b) {
            return strtotime($a['publish_time'] ?? '') <=> strtotime($b['publish_time'] ?? '');
        });

        foreach ($exams as $exam) {
            $rawTitle = $exam['title'] ?? 'Sınav';
            $cleanTitle = trim(str_ireplace(['UY13 -', 'UY13', 'Sınavı', 'Sınav'], '', $rawTitle));
            if (empty($cleanTitle)) {
                $cleanTitle = $rawTitle;
            }
            $publishTime = $exam['publish_time'] ?? null;

            if ($publishTime) {
                $ts = strtotime($publishTime);
                $day = date('d', $ts);
                $month = $turkishMonths[(int)date('m', $ts)] ?? date('F', $ts);
                $year = date('Y', $ts);
                $timeStr = date('H:i', $ts);

                $dates[] = [
                    'id'              => 'exam_' . ($exam['id'] ?? ''),
                    'key'             => 'exam_' . ($exam['id'] ?? ''),
                    'badge'           => 'Online Sınav',
                    'title'           => $cleanTitle . ' Sınavı',
                    'sub_title'       => 'Online Sınav (Saat ' . $timeStr . ')',
                    'date_formatted'  => "{$day} {$month} {$year}",
                    'time_formatted'  => $timeStr,
                    'target_iso'      => date('Y-m-d\TH:i:s', $ts),
                    'countdown_label' => $cleanTitle . ' Sınavına Kalan Süre',
                    'icon_type'       => 'exam',
                    'prefix'          => '',
                    'is_countdown'    => '1',
                    'is_past'         => $ts < time(),
                ];
            }
        }

        return $dates;
    }

    /**
     * Ana sayfa Hero Slider kayıtlarını döner
     */
    public function getSliders(int $limit = 5, bool $useCache = true): array
    {
        $result = $this->request('getSliders', ['limit' => $limit], 'GET', $useCache);
        return is_array($result) ? $result : [];
    }

    /**
     * Yönetim panelinden oluşturulan aktif web menülerini listeler
     */
    public function getWebMenus(bool $withItems = true, bool $useCache = true): array
    {
        $result = $this->request('getWebMenus', ['with_items' => $withItems ? 1 : 0], 'GET', $useCache);
        return is_array($result) ? $result : [];
    }

    /**
     * Header veya footer menü ağacını döner (Çoklu dil ve ID desteği ile)
     */
    public function getMenu(string $identifier = 'header', string $lang = 'tr', bool $useCache = true): array
    {
        $result = $this->request("getMenu/{$identifier}", ['lang' => $lang], 'GET', $useCache);
        if (is_array($result)) {
            $key = $identifier . 'Menu';
            if (isset($result[$key]) && is_array($result[$key])) {
                return $result[$key];
            }
            if (isset($result['items']) && is_array($result['items'])) {
                return $result['items'];
            }
            return $result;
        }
        return [];
    }

    /**
     * Medya, podcast ve video içeriklerini listeler (API'deki resmi getMediaContents uç noktası)
     */
    public function getMediaContents(bool $useCache = true): array
    {
        // 1. Yeni resmi API uç noktasını çağır (web_medias tablosundan)
        $apiMedia = $this->request('getMediaContents', [], 'GET', $useCache);

        if (is_array($apiMedia) && !empty($apiMedia)) {
            $mediaList = [];
            foreach ($apiMedia as $item) {
                $mediaUrl = $item['media_url'] ?? ($item['url'] ?? '');
                $isDirect = !empty($item['is_direct']) || str_ends_with(strtolower($mediaUrl), '.mp4');
                $thumb = $item['thumbnail_url'] ?? ($item['image_url'] ?? ($item['thumbnail'] ?? ''));
                if (empty($thumb) || !str_starts_with($thumb, 'http')) {
                    $thumb = $this->getMediaUrl($thumb ?: 'assets/images/media-2.svg');
                }

                $mediaList[] = [
                    'id'          => $item['id'] ?? uniqid(),
                    'title'       => $item['title'] ?? '',
                    'tag'         => strtoupper($item['tag'] ?? ($item['media_type'] ?? 'VIDEO')),
                    'tag_class'   => strtolower($item['tag_class'] ?? ($item['media_type'] ?? 'video')),
                    'url'         => $mediaUrl,
                    'is_direct'   => $isDirect,
                    'duration'    => $item['duration'] ?? 'Video',
                    'thumbnail'   => $thumb,
                    'description' => $item['description'] ?? ($item['desc'] ?? ''),
                    'is_featured' => !empty($item['is_featured']),
                ];
            }

            if (!empty($mediaList)) {
                return $mediaList;
            }
        }

        // 2. Fallback: API boşsa getWebContents üzerinden video ara
        $all = $this->getWebContents([], $useCache);
        $mediaList = [];

        foreach ($all as $item) {
            $slug  = $item['slug'] ?? '';
            $title = $item['title'] ?? '';
            $body  = $item['body'] ?? '';

            if (str_starts_with($slug, 'video-') || str_contains($slug, 'video') || str_contains($body, '.mp4')) {
                $videoUrl = '';
                if (preg_match('/src=["\'](https?:\/\/[^"\']+\.mp4)["\']/', $body, $m)) {
                    $videoUrl = $m[1];
                }

                if (!empty($videoUrl)) {
                    $cleanTitle = trim(preg_replace('/^Video İçerik:\s*/iu', '', $title));
                    $cleanDesc = trim(strip_tags($body));
                    if (empty($cleanDesc) || str_contains($cleanDesc, 'Tarayıcınız')) {
                        $cleanDesc = "{$cleanTitle} - Ufka Yolculuk özel video içeriği ve görsel rehber.";
                    }

                    $mediaList[] = [
                        'id'          => $item['id'] ?? uniqid(),
                        'title'       => $cleanTitle,
                        'tag'         => 'VIDEO',
                        'tag_class'   => 'video',
                        'url'         => $videoUrl,
                        'is_direct'   => true,
                        'duration'    => 'Video',
                        'thumbnail'   => base_url('assets/images/media-2.svg'),
                        'description' => $cleanDesc,
                        'is_featured' => false,
                    ];
                }
            }
        }

        return $mediaList;
    }

    /**
     * Belirtilen kategoriye ait yarışma sorularını döner (category_id zorunludur)
     */
    public function getQuestions(int $categoryId = 6, string $type = 'mini-deneme', bool $useCache = true): array
    {
        $result = $this->request("getQuestions/{$categoryId}", ['type' => $type], 'GET', $useCache);
        return is_array($result) ? $result : [];
    }

    /**
     * API'den dönen görsel veya dosya yolunun tam URL karşılığını üretir
     */
    public function getMediaUrl(?string $path): string
    {
        if (empty($path)) {
            return '';
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return rtrim($this->config->uploadsURL, '/') . '/' . ltrim($path, '/');
    }
}
