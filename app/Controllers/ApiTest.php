<?php

namespace App\Controllers;

use App\Services\UfkaApiService;
use Config\UfkaApi;
use CodeIgniter\HTTP\ResponseInterface;

class ApiTest extends BaseController
{
    protected ?UfkaApiService $apiService = null;
    protected UfkaApi $config;

    public function __construct()
    {
        $this->apiService = new UfkaApiService();
        $this->config = config('UfkaApi');
    }

    /**
     * API Test & Explorer Arayüzünü Görüntüler
     */
    public function index(): string
    {
        $endpoints = $this->getEndpointCatalog();

        $data = [
            'title'       => 'Ufka Yolculuk REST API Test & Canlı Veri Laboratuvarı',
            'baseURL'     => $this->config->baseURL,
            'uploadsURL'  => $this->config->uploadsURL,
            'username'    => $this->config->username,
            'endpoints'   => $endpoints,
            'totalCount'  => count($endpoints),
        ];

        return view('api_test', $data);
    }

    /**
     * Seçilen API Uç Noktasına Canlı İstek Gönderir ve Sonucu Döndürür
     */
    public function execute(): ResponseInterface
    {
        $endpointKey = $this->request->getPost('endpoint_key');
        $paramsRaw   = $this->request->getPost('params');
        $useCache    = (bool)$this->request->getPost('use_cache');
        $customUrl   = $this->request->getPost('custom_url');

        $catalog = $this->getEndpointCatalog();
        $endpointMeta = $catalog[$endpointKey] ?? null;

        $params = [];
        if (!empty($paramsRaw) && is_string($paramsRaw)) {
            $decoded = json_decode($paramsRaw, true);
            $params = is_array($decoded) ? $decoded : [];
        } elseif (is_array($paramsRaw)) {
            $params = $paramsRaw;
        }

        $method = strtoupper($endpointMeta['method'] ?? 'GET');
        $endpointPath = $endpointMeta['endpoint'] ?? $customUrl;

        // URL değişkenlerini parametrelerden doldur (örn: getBook/{id})
        foreach ($params as $k => $v) {
            if (str_contains($endpointPath, '{' . $k . '}')) {
                $endpointPath = str_replace('{' . $k . '}', urlencode((string)$v), $endpointPath);
                unset($params[$k]);
            }
        }
        // Opsiyonel kalan {} değişkenleri temizle
        $endpointPath = preg_replace('/\{[a-zA-Z0-9_]+\}/', '', $endpointPath);
        $endpointPath = rtrim($endpointPath, '/');

        // Canlı İstek Yap ve Zamanı Ölç
        $startTime = microtime(true);
        $result = $this->performLiveRequest($endpointPath, $method, $params, $useCache);
        $durationMs = round((microtime(true) - $startTime) * 1000, 2);

        $result['latency_ms']   = $durationMs;
        $result['endpoint_key'] = $endpointKey;
        $result['endpoint']     = $endpointPath;
        $result['method']       = $method;

        return $this->response->setJSON($result);
    }

    /**
     * Çekirdek API Uç Noktalarını Toplu Olarak Test Eder (Sağlık Taraması)
     */
    public function batch(): ResponseInterface
    {
        $coreEndpoints = [
            'token'                 => ['method' => 'POST', 'endpoint' => 'token', 'params' => ['token_name' => 'Batch-Tester']],
            'getBooks'              => ['method' => 'GET',  'endpoint' => 'getBooks', 'params' => []],
            'getBook'               => ['method' => 'GET',  'endpoint' => 'getBook/8', 'params' => []],
            'getBookCategories'     => ['method' => 'GET',  'endpoint' => 'getBookCategories', 'params' => []],
            'getCompetitionCategories' => ['method' => 'GET', 'endpoint' => 'getCompetitionCategories', 'params' => []],
            'getExams'              => ['method' => 'GET',  'endpoint' => 'getExams', 'params' => []],
            'getImportantDates'     => ['method' => 'GET',  'endpoint' => 'getImportantDates', 'params' => []],
            'getWebContents'        => ['method' => 'GET',  'endpoint' => 'getWebContents', 'params' => ['limit' => 5]],
            'getAnnouncements'      => ['method' => 'GET',  'endpoint' => 'getAnnouncements', 'params' => ['limit' => 3]],
            'getAwards'             => ['method' => 'GET',  'endpoint' => 'getAwards', 'params' => []],
            'getCities'             => ['method' => 'GET',  'endpoint' => 'getCities', 'params' => []],
            'getRepresentatives'    => ['method' => 'GET',  'endpoint' => 'getRepresentatives', 'params' => []],
            'getSliders'            => ['method' => 'GET',  'endpoint' => 'getSliders', 'params' => ['limit' => 3]],
            'getMediaContents'      => ['method' => 'GET',  'endpoint' => 'getMediaContents', 'params' => []],
        ];

        $results = [];
        $totalLatency = 0;
        $successCount = 0;

        foreach ($coreEndpoints as $key => $conf) {
            $st = microtime(true);
            $res = $this->performLiveRequest($conf['endpoint'], $conf['method'], $conf['params'], false);
            $lat = round((microtime(true) - $st) * 1000, 2);
            $totalLatency += $lat;

            $isOk = ($res['status_code'] >= 200 && $res['status_code'] < 300) && !empty($res['data']);
            if ($isOk) {
                $successCount++;
            }

            $results[$key] = [
                'endpoint'    => $conf['endpoint'],
                'method'      => $conf['method'],
                'status_code' => $res['status_code'],
                'latency_ms'  => $lat,
                'item_count'  => $res['item_count'] ?? 0,
                'data_size'   => $res['data_size_kb'] ?? 0,
                'success'     => $isOk,
                'message'     => $res['message'] ?? 'OK',
            ];
        }

        return $this->response->setJSON([
            'total_tested'     => count($coreEndpoints),
            'successful'       => $successCount,
            'failed'           => count($coreEndpoints) - $successCount,
            'average_latency'  => round($totalLatency / max(1, count($coreEndpoints)), 2),
            'results'          => $results,
        ]);
    }

    /**
     * Canlı cURL / HTTP Çağrısı Yapar (Token Yönetimi Dahil)
     */
    protected function performLiveRequest(string $endpoint, string $method, array $params, bool $useCache): array
    {
        $cacheKey = 'api_test_' . md5($endpoint . '_' . $method . '_' . serialize($params));
        if ($useCache) {
            $cached = cache($cacheKey);
            if (!empty($cached)) {
                $cached['from_cache'] = true;
                return $cached;
            }
        }

        $fullUrl = rtrim($this->config->baseURL, '/') . '/' . ltrim($endpoint, '/');
        $token = $this->apiService->getAccessToken();

        $headers = [
            'Accept: application/json',
        ];

        // Token endpoint'i hariç Bearer token ekle
        if (!str_contains($endpoint, 'token') && !empty($token)) {
            $headers[] = 'Authorization: Bearer ' . $token;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_HEADER, true);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            // Eğer token çağrısı ise kullanıcı adı ve şifreyi otomatik tamamla
            if ($endpoint === 'token') {
                $params = array_merge([
                    'username'   => $this->config->username,
                    'password'   => $this->config->password,
                    'token_name' => 'Api-Test-Panel',
                ], $params);
            }
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        } else {
            if (!empty($params)) {
                $fullUrl .= (str_contains($fullUrl, '?') ? '&' : '?') . http_build_query($params);
            }
        }

        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            return [
                'success'      => false,
                'status_code'  => 0,
                'url'          => $fullUrl,
                'headers'      => [],
                'raw_body'     => '',
                'data'         => null,
                'item_count'   => 0,
                'data_size_kb' => 0,
                'from_cache'   => false,
                'message'      => 'cURL Bağlantı Hatası: ' . $err,
            ];
        }

        $headerText = substr($response, 0, $headerSize);
        $bodyText   = substr($response, $headerSize);

        $parsedHeaders = [];
        foreach (explode("\r\n", $headerText) as $hLine) {
            if (str_contains($hLine, ':')) {
                [$hk, $hv] = explode(':', $hLine, 2);
                $parsedHeaders[trim($hk)] = trim($hv);
            }
        }

        $jsonData = json_decode($bodyText, true);
        $itemCount = 0;
        if (is_array($jsonData)) {
            $itemCount = isset($jsonData[0]) ? count($jsonData) : count(array_keys($jsonData));
        }

        $out = [
            'success'      => ($httpCode >= 200 && $httpCode < 300),
            'status_code'  => $httpCode,
            'url'          => $fullUrl,
            'headers'      => $parsedHeaders,
            'raw_body'     => $bodyText,
            'data'         => $jsonData,
            'item_count'   => $itemCount,
            'data_size_kb' => round(strlen($bodyText) / 1024, 2),
            'from_cache'   => false,
            'message'      => ($httpCode >= 200 && $httpCode < 300) ? 'İstek Başarılı' : 'Sunucu Hatası / Yanıt Geçersiz',
        ];

        if ($useCache && $out['success']) {
            cache()->save($cacheKey, $out, 300);
        }

        return $out;
    }

    /**
     * Tüm API Uç Noktalarının Detaylı Kataloğu
     */
    protected function getEndpointCatalog(): array
    {
        return [
            // 1. Kimlik Doğrulama & Token
            'token' => [
                'group'       => 'Kimlik Doğrulama & Token',
                'group_icon'  => 'fa-solid fa-key text-warning',
                'name'        => 'Bearer Token Al',
                'method'      => 'POST',
                'endpoint'    => 'token',
                'desc'        => 'API erişimi için 2 saat geçerli Bearer Access Token ve 14 günlük Refresh Token üretir.',
                'params'      => [
                    'username'   => ['type' => 'text', 'default' => $this->config->username, 'desc' => 'API Kullanıcı Adı'],
                    'password'   => ['type' => 'password', 'default' => $this->config->password, 'desc' => 'API Şifresi'],
                    'token_name' => ['type' => 'text', 'default' => 'Api-Test-Console', 'desc' => 'İstemci Adı'],
                ],
            ],
            'refresh' => [
                'group'       => 'Kimlik Doğrulama & Token',
                'group_icon'  => 'fa-solid fa-key text-warning',
                'name'        => 'Token Yenile (Refresh)',
                'method'      => 'POST',
                'endpoint'    => 'refresh',
                'desc'        => 'Süresi dolan tokenı şifresiz yeniler.',
                'params'      => [
                    'refresh_token' => ['type' => 'text', 'default' => '', 'desc' => 'Önceki alınan refresh_token'],
                ],
            ],
            'revoke' => [
                'group'       => 'Kimlik Doğrulama & Token',
                'group_icon'  => 'fa-solid fa-key text-warning',
                'name'        => 'Token İptal Et (Revoke)',
                'method'      => 'POST',
                'endpoint'    => 'revoke',
                'desc'        => 'Aktif tokenı anında geçersiz kılar.',
                'params'      => [
                    'token' => ['type' => 'text', 'default' => '', 'desc' => 'İptal edilecek token'],
                ],
            ],

            // 2. Kitaplar & Kategoriler
            'getBooks' => [
                'group'       => 'Kitaplar ve Kategoriler',
                'group_icon'  => 'fa-solid fa-book-open text-primary',
                'name'        => 'Yarışma Kitapları Listesi',
                'method'      => 'GET',
                'endpoint'    => 'getBooks',
                'desc'        => 'Yarışmaya dahil olan tüm kitapları, kapak görselleri, yazar, özet ve sayfa sayılarıyla listeler.',
                'params'      => [],
            ],
            'getBook' => [
                'group'       => 'Kitaplar ve Kategoriler',
                'group_icon'  => 'fa-solid fa-book-open text-primary',
                'name'        => 'Tekil Kitap Detayı',
                'method'      => 'GET',
                'endpoint'    => 'getBook/{id}',
                'desc'        => 'ID numarası belirtilen kitabın tüm detaylarını, bölümlerini ve sesli dinleme linklerini getirir.',
                'params'      => [
                    'id' => ['type' => 'number', 'default' => '8', 'desc' => 'Kitap ID (8: Kuşların Çağrısı, 11, 12, 13 vb.)'],
                ],
            ],
            'getBookCategories' => [
                'group'       => 'Kitaplar ve Kategoriler',
                'group_icon'  => 'fa-solid fa-book-open text-primary',
                'name'        => 'Kitap Kategorileri',
                'method'      => 'GET',
                'endpoint'    => 'getBookCategories',
                'desc'        => 'Kitaplara tanımlı kategori ağacını döner.',
                'params'      => [],
            ],
            'getCompetitionCategories' => [
                'group'       => 'Kitaplar ve Kategoriler',
                'group_icon'  => 'fa-solid fa-book-open text-primary',
                'name'        => 'Yarışma Kademe Kategorileri',
                'method'      => 'GET',
                'endpoint'    => 'getCompetitionCategories',
                'desc'        => 'İlkokul, Ortaokul, Lise ve Yetişkin kategorilerini yarışma eşleşmeleriyle döner.',
                'params'      => [],
            ],

            // 3. Sınavlar ve Sorular
            'getExams' => [
                'group'       => 'Sınavlar ve Önemli Tarihler',
                'group_icon'  => 'fa-solid fa-graduation-cap text-success',
                'name'        => 'Aktif Sınavlar Listesi',
                'method'      => 'GET',
                'endpoint'    => 'getExams',
                'desc'        => 'Web sitesinde ve sistemde yayında olan aktif sınavları listeler.',
                'params'      => [],
            ],
            'getImportantDates' => [
                'group'       => 'Sınavlar ve Önemli Tarihler',
                'group_icon'  => 'fa-solid fa-graduation-cap text-success',
                'name'        => 'Önemli Yarışma Tarihleri',
                'method'      => 'GET',
                'endpoint'    => 'getImportantDates',
                'desc'        => 'Ana sayfadaki sayaç ve takvim verilerini çeker (Kayıt bitiş, 1. Aşama, 2. Aşama sınav tarihleri).',
                'params'      => [],
            ],
            'getQuestions' => [
                'group'       => 'Sınavlar ve Önemli Tarihler',
                'group_icon'  => 'fa-solid fa-graduation-cap text-success',
                'name'        => 'Kategori Bazlı Sınav Soruları',
                'method'      => 'GET',
                'endpoint'    => 'getQuestions/{category_id}',
                'desc'        => 'Belirtilen kademeye ait soru bankası / online deneme sınavı sorularını getirir.',
                'params'      => [
                    'category_id' => ['type' => 'number', 'default' => '6', 'desc' => 'Kategori ID (örn: 6 Ortaokul)'],
                    'type'        => ['type' => 'text',   'default' => 'mini-deneme', 'desc' => 'Sınav Tipi'],
                ],
            ],

            // 4. Web İçerikleri & Duyurular
            'getWebContents' => [
                'group'       => 'Web İçerikleri, Duyurular ve SSS',
                'group_icon'  => 'fa-solid fa-newspaper text-info',
                'name'        => 'Tüm Web İçerikleri (CMS)',
                'method'      => 'GET',
                'endpoint'    => 'getWebContents',
                'desc'        => 'Duyurular, haberler, kurumsal metinler ve şartnameleri içeren ana CMS verisi.',
                'params'      => [
                    'type'  => ['type' => 'text',   'default' => '', 'desc' => 'İçerik Tipi (annoucement, news, sss, vb.)'],
                    'limit' => ['type' => 'number', 'default' => '10', 'desc' => 'Limit (Örn: 10)'],
                ],
            ],
            'getWebContent' => [
                'group'       => 'Web İçerikleri, Duyurular ve SSS',
                'group_icon'  => 'fa-solid fa-newspaper text-info',
                'name'        => 'Tekil İçerik / Sayfa Detayı',
                'method'      => 'GET',
                'endpoint'    => 'getWebContent/{slug}',
                'desc'        => 'Slug veya ID bazlı sayfa detayını (Gövde HTML, başlık, resim) döner.',
                'params'      => [
                    'slug' => ['type' => 'text', 'default' => 'biz-kimiz', 'desc' => 'Sayfa Slugı (biz-kimiz, misyon-vizyon, sartname vb.)'],
                ],
            ],
            'getAnnouncements' => [
                'group'       => 'Web İçerikleri, Duyurular ve SSS',
                'group_icon'  => 'fa-solid fa-newspaper text-info',
                'name'        => 'Güncel Duyurular',
                'method'      => 'GET',
                'endpoint'    => 'getAnnouncements',
                'desc'        => 'Sadece resmi duyuruları tarihe göre sıralı olarak döner.',
                'params'      => [
                    'limit' => ['type' => 'number', 'default' => '5', 'desc' => 'Kaç adet duyuru getirilsin?'],
                ],
            ],
            'getNews' => [
                'group'       => 'Web İçerikleri, Duyurular ve SSS',
                'group_icon'  => 'fa-solid fa-newspaper text-info',
                'name'        => 'Basın ve Haberler',
                'method'      => 'GET',
                'endpoint'    => 'getNews',
                'desc'        => 'Haber bültenlerini ve basın yansımalarını döner.',
                'params'      => [
                    'limit' => ['type' => 'number', 'default' => '5', 'desc' => 'Kaç adet haber getirilsin?'],
                ],
            ],
            'getFaqs' => [
                'group'       => 'Web İçerikleri, Duyurular ve SSS',
                'group_icon'  => 'fa-solid fa-newspaper text-info',
                'name'        => 'Sıkça Sorulan Sorular (SSS)',
                'method'      => 'GET',
                'endpoint'    => 'getFaqs',
                'desc'        => 'Yarışmacıların en çok sorduğu sorular ve cevapları.',
                'params'      => [],
            ],

            // 5. Ödüller & İller
            'getAwards' => [
                'group'       => 'Ödüller ve Şehirler',
                'group_icon'  => 'fa-solid fa-trophy text-warning',
                'name'        => 'Türkiye Geneli Ödüller',
                'method'      => 'GET',
                'endpoint'    => 'getAwards',
                'desc'        => 'Ulusal düzeyde 4 kategori için verilen merkezi başarı ödülleri.',
                'params'      => [],
            ],
            'getAwardsCity' => [
                'group'       => 'Ödüller ve Şehirler',
                'group_icon'  => 'fa-solid fa-trophy text-warning',
                'name'        => 'İl Bazlı Yerel Ödüller',
                'method'      => 'GET',
                'endpoint'    => 'getAwards/{city_id}',
                'desc'        => 'Seçilen ilin (örn: 34 İstanbul, 42 Konya) yerel sivil toplum ödülleri.',
                'params'      => [
                    'city_id' => ['type' => 'number', 'default' => '42', 'desc' => 'Plaka Kodu (34: İstanbul, 42: Konya, 6: Ankara)'],
                ],
            ],
            'getCities' => [
                'group'       => 'Ödüller ve Şehirler',
                'group_icon'  => 'fa-solid fa-trophy text-warning',
                'name'        => '81 İl Listesi',
                'method'      => 'GET',
                'endpoint'    => 'getCities',
                'desc'        => 'Türkiye genelindeki 81 ilin resmi id ve isim listesi.',
                'params'      => [],
            ],
            'getAwardCities' => [
                'group'       => 'Ödüller ve Şehirler',
                'group_icon'  => 'fa-solid fa-trophy text-warning',
                'name'        => 'Ödül Açıklanan İller',
                'method'      => 'GET',
                'endpoint'    => 'getAwardCities',
                'desc'        => 'Kendi il ödüllerini sisteme girmiş ve yayınlamış iller listesi.',
                'params'      => [],
            ],

            // 6. Temsilcilikler ve Okullar
            'getRepresentatives' => [
                'group'       => 'Temsilcilikler ve Okul Kayıtları',
                'group_icon'  => 'fa-solid fa-map-location-dot text-danger',
                'name'        => '81 İl Temsilcileri Listesi',
                'method'      => 'GET',
                'endpoint'    => 'getRepresentatives',
                'desc'        => '81 ilin sorumlu dernek, kulüp, temsilci adı ve telefon iletişim bilgileri.',
                'params'      => [],
            ],
            'getCounties' => [
                'group'       => 'Temsilcilikler ve Okul Kayıtları',
                'group_icon'  => 'fa-solid fa-map-location-dot text-danger',
                'name'        => 'İlçe Listesi',
                'method'      => 'GET',
                'endpoint'    => 'getCounties/{city_id}',
                'desc'        => 'Seçilen ilin tüm ilçelerini döner (Kayıt sihirbazı kademesi).',
                'params'      => [
                    'city_id' => ['type' => 'number', 'default' => '42', 'desc' => 'İl ID (Plaka kodu)'],
                ],
            ],
            'getSchools' => [
                'group'       => 'Temsilcilikler ve Okul Kayıtları',
                'group_icon'  => 'fa-solid fa-map-location-dot text-danger',
                'name'        => 'İlçe Bazlı Okul Listesi',
                'method'      => 'GET',
                'endpoint'    => 'getSchools/{county_id}',
                'desc'        => 'Seçilen ilçedeki MEB onaylı okulları listeler.',
                'params'      => [
                    'county_id' => ['type' => 'number', 'default' => '450', 'desc' => 'İlçe ID'],
                ],
            ],

            // 7. Medya, Menüler & Tema
            'getSliders' => [
                'group'       => 'Medya, Menüler ve Tema Ayarları',
                'group_icon'  => 'fa-solid fa-palette text-purple',
                'name'        => 'Ana Sayfa Banner Slaytları',
                'method'      => 'GET',
                'endpoint'    => 'getSliders',
                'desc'        => 'Masaüstü ve mobil responsive banner slaytları ve yönlendirme butonları.',
                'params'      => [
                    'limit' => ['type' => 'number', 'default' => '5', 'desc' => 'Slayt Limiti'],
                ],
            ],
            'getWebMenus' => [
                'group'       => 'Medya, Menüler ve Tema Ayarları',
                'group_icon'  => 'fa-solid fa-palette text-purple',
                'name'        => 'Tüm Web Menü Ağaçları',
                'method'      => 'GET',
                'endpoint'    => 'getWebMenus',
                'desc'        => 'Header, Footer ve Kurumsal menü öğelerinin hiyerarşik JSON yapısı.',
                'params'      => [
                    'with_items' => ['type' => 'number', 'default' => '1', 'desc' => 'Alt öğeler dahil edilsin mi? (1/0)'],
                ],
            ],
            'getMenu' => [
                'group'       => 'Medya, Menüler ve Tema Ayarları',
                'group_icon'  => 'fa-solid fa-palette text-purple',
                'name'        => 'Tekil Menü (Header/Footer)',
                'method'      => 'GET',
                'endpoint'    => 'getMenu/{identifier}',
                'desc'        => 'Slug veya ID bazlı menüyü dil desteğiyle getirir.',
                'params'      => [
                    'identifier' => ['type' => 'text', 'default' => 'header', 'desc' => 'Menü Tanımlayıcı (header / footer)'],
                    'lang'       => ['type' => 'text', 'default' => 'tr',     'desc' => 'Dil Kodu (tr / en / de)'],
                ],
            ],
            'getMediaContents' => [
                'group'       => 'Medya, Menüler ve Tema Ayarları',
                'group_icon'  => 'fa-solid fa-palette text-purple',
                'name'        => 'Video ve Podcast Kayıtları',
                'method'      => 'GET',
                'endpoint'    => 'getMediaContents',
                'desc'        => 'YouTube videoları, tanıtım filmleri ve sesli podcast kayıtları.',
                'params'      => [],
            ],
            'getThemeConfig' => [
                'group'       => 'Medya, Menüler ve Tema Ayarları',
                'group_icon'  => 'fa-solid fa-palette text-purple',
                'name'        => 'Aktif Tema ve Stil Ayarları',
                'method'      => 'GET',
                'endpoint'    => 'getThemeConfig',
                'desc'        => 'Renk paletleri, fontlar ve logo varlıklarını içeren tema konfigürasyonu.',
                'params'      => [],
            ],

            // 8. Kullanıcı ve Profil İşlemleri
            'verifyUser' => [
                'group'       => 'Kullanıcı ve Profil İşlemleri',
                'group_icon'  => 'fa-solid fa-user-check text-secondary',
                'name'        => 'Yarışmacı Doğrulama (Login Öncesi)',
                'method'      => 'POST',
                'endpoint'    => 'verifyUser',
                'desc'        => 'Telefon numarası ve doğum tarihi ile yarışmacı hesabı varlık kontrolü.',
                'params'      => [
                    'phone'      => ['type' => 'text', 'default' => '5551234567', 'desc' => 'Telefon No (10 Hane)'],
                    'birth_date' => ['type' => 'text', 'default' => '2008-05-15', 'desc' => 'Doğum Tarihi (YYYY-AA-GG)'],
                ],
            ],
            'getUserData' => [
                'group'       => 'Kullanıcı ve Profil İşlemleri',
                'group_icon'  => 'fa-solid fa-user-check text-secondary',
                'name'        => 'Kullanıcı Profil Bilgileri',
                'method'      => 'GET',
                'endpoint'    => 'getUserData',
                'desc'        => 'Yarışmacının temel profil ve kayıt durumu bilgileri.',
                'params'      => [
                    'user_id' => ['type' => 'number', 'default' => '101', 'desc' => 'Yarışmacı ID'],
                ],
            ],
            'getUserResults' => [
                'group'       => 'Kullanıcı ve Profil İşlemleri',
                'group_icon'  => 'fa-solid fa-user-check text-secondary',
                'name'        => 'Kullanıcı Sınav Sonuçları',
                'method'      => 'GET',
                'endpoint'    => 'getUserResults',
                'desc'        => 'Yarışmacının katıldığı sınavların puan, doğru/yanlış ve derece verileri.',
                'params'      => [
                    'user_id' => ['type' => 'number', 'default' => '101', 'desc' => 'Yarışmacı ID'],
                ],
            ],
            'getUserCertificates' => [
                'group'       => 'Kullanıcı ve Profil İşlemleri',
                'group_icon'  => 'fa-solid fa-user-check text-secondary',
                'name'        => 'Kullanıcı Sertifikaları',
                'method'      => 'GET',
                'endpoint'    => 'getUserCertificates',
                'desc'        => 'Kullanıcıya atanmış katılım ve başarı sertifikaları.',
                'params'      => [
                    'user_id' => ['type' => 'number', 'default' => '101', 'desc' => 'Yarışmacı ID'],
                ],
            ],
            'getLeaderStats' => [
                'group'       => 'Kullanıcı ve Profil İşlemleri',
                'group_icon'  => 'fa-solid fa-user-check text-secondary',
                'name'        => 'Takım Lideri İstatistikleri',
                'method'      => 'GET',
                'endpoint'    => 'getLeaderStats',
                'desc'        => 'Takım liderinin danışan sayısı, toplam puanı ve sıralaması.',
                'params'      => [
                    'user_id' => ['type' => 'number', 'default' => '101', 'desc' => 'Yarışmacı ID'],
                ],
            ],
        ];
    }
}
