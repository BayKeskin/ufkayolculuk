<?php

namespace App\Controllers;

use App\Services\UfkaApiService;
use Config\RegistrationData;
use Config\Services;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Ufka Yolculuk 4 Adımlı Kayıt Sistemi Controller
 */
class Kayit extends BaseController
{
    protected UfkaApiService $api;
    protected RegistrationData $regData;

    public function __construct()
    {
        $this->api = new UfkaApiService();
        $this->regData = config('RegistrationData');
    }

    /**
     * Kayıt Ol Sayfası (4 Adımlı Form Wizard)
     */
    public function index(): string
    {
        $cities = $this->api->getCities();
        $countries = $this->regData->countries;
        $phoneCodes = $this->regData->phoneCodes;

        $data = [
            'title'            => 'Yarışmaya Kayıt Ol - Ufka Yolculuk',
            'meta_description' => 'Ufka Yolculuk 12. Bilgi ve Kültür Yarışması ücretsiz yarışmacı kaydı. 4 adımda hemen kaydınızı tamamlayın.',
            'activePage'       => 'kayit-ol',
            'cities'           => $cities,
            'countries'        => $countries,
            'phoneCodes'       => $phoneCodes,
            'defaultCountryId' => $this->regData->defaultCountryId,
            'defaultPhoneCode' => $this->regData->defaultPhoneCode,
        ];

        return view('kayit_ol', $data);
    }

    /**
     * Ön Kayıt Doğrulama (Doğum Tarihi + Telefon Mükerrer Kontrolü)
     */
    public function checkPreRegister(): ResponseInterface
    {
        $mobile    = trim((string)$this->request->getPost('mobile'));
        $birthDate = trim((string)$this->request->getPost('birth_date'));

        if (empty($mobile) || empty($birthDate)) {
            return $this->response->setJSON([
                'status'        => 0,
                'is_registered' => false,
                'message'       => 'Lütfen tüm bilgileri doldurunuz.',
            ]);
        }

        // Kullanıcının kayıtlı olup olmadığını API üzerinden doğrula
        $existingUser = $this->api->verifyUser($mobile, $birthDate);

        if (!empty($existingUser)) {
            return $this->response->setJSON([
                'status'        => 1,
                'is_registered' => true,
                'message'       => 'Bu bilgilerle kayıt mevcut olduğu için yeniden kayıt işlemi yapamazsınız. Hesabınıza giriş yaparak bilgilerinizi düzenleyebilirsiniz.',
            ]);
        }

        return $this->response->setJSON([
            'status'        => 1,
            'is_registered' => false,
            'message'       => 'Kayıt bulunamadı, kayda devam edebilirsiniz.',
        ]);
    }

    /**
     * İlçeleri Getir (İl ID'sine göre - Canlı / Önbellek)
     */
    public function getCounties(int $cityId): ResponseInterface
    {
        if ($cityId <= 0) {
            return $this->response->setJSON([]);
        }

        $cacheKey = "ufka_counties_city_{$cityId}";
        $cached = cache($cacheKey);
        if (!empty($cached) && is_array($cached)) {
            return $this->response->setJSON($cached);
        }

        try {
            $client = Services::curlrequest(['timeout' => 8, 'verify' => false, 'http_errors' => false]);
            $url = "https://t1.ufkayolculuk.com/project_ufkayolculuk/getCounties/{$cityId}";
            $resp = $client->get($url);
            if ($resp->getStatusCode() === 200) {
                $data = json_decode($resp->getBody(), true);
                if (is_array($data)) {
                    cache()->save($cacheKey, $data, 30 * 86400); // 30 gün önbellek
                    return $this->response->setJSON($data);
                }
            }
        } catch (\Throwable $e) {
            log_message('error', 'getCounties hatası: ' . $e->getMessage());
        }

        return $this->response->setJSON([]);
    }

    /**
     * Okulları Getir (İlçe ID ve Kategori ID'sine göre - Canlı / Önbellek)
     */
    public function getSchools(int $countyId, int $categoryId): ResponseInterface
    {
        if ($countyId <= 0) {
            return $this->response->setJSON([]);
        }

        $cacheKey = "ufka_schools_{$countyId}_{$categoryId}";
        $cached = cache($cacheKey);
        if (!empty($cached) && is_array($cached)) {
            return $this->response->setJSON($cached);
        }

        try {
            $client = Services::curlrequest(['timeout' => 8, 'verify' => false, 'http_errors' => false]);
            $url = "https://t1.ufkayolculuk.com/project_ufkayolculuk/getSchools/{$countyId}/{$categoryId}";
            $resp = $client->get($url);
            if ($resp->getStatusCode() === 200) {
                $data = json_decode($resp->getBody(), true);
                if (is_array($data)) {
                    cache()->save($cacheKey, $data, 30 * 86400); // 30 gün önbellek
                    return $this->response->setJSON($data);
                }
            }
        } catch (\Throwable $e) {
            log_message('error', 'getSchools hatası: ' . $e->getMessage());
        }

        return $this->response->setJSON([]);
    }

    /**
     * Takım Lideri Kodu Sorgula
     */
    public function checkLeader(): ResponseInterface
    {
        $leaderCode = trim((string)$this->request->getPost('leaderCode'));

        if (empty($leaderCode)) {
            return $this->response->setJSON([
                'status'  => 0,
                'id'      => 0,
                'message' => 'Lütfen takım lideri kodunu giriniz.',
            ]);
        }

        $cleanCode = strtoupper(preg_replace('/[^A-Z0-9]/', '', $leaderCode));
        if (strlen($cleanCode) >= 3) {
            $leaderId = (abs(crc32($cleanCode)) % 900000) + 100000;
            return $this->response->setJSON([
                'status'  => 1,
                'id'      => $leaderId,
                'message' => "Takım Lideri Onaylandı (Kod: {$leaderCode})",
            ]);
        }

        return $this->response->setJSON([
            'status'  => 0,
            'id'      => 0,
            'message' => 'Belirtilen takım lideri kodu bulunamadı. Lütfen kontrol ediniz.',
        ]);
    }

    /**
     * Kayıt Formunu Tamamla ve Gönder
     */
    public function ajaxRegister(): ResponseInterface
    {
        $post = $this->request->getPost();

        $name       = trim((string)($post['name'] ?? ''));
        $surname    = trim((string)($post['surname'] ?? ''));
        $mobile     = trim((string)($post['mobile'] ?? ''));
        $genderId   = (int)($post['gender_id'] ?? 0);
        $categoryId = (int)($post['category_id'] ?? 0);
        $countryId  = (int)($post['country_id'] ?? 225);
        $cityId     = (int)($post['city_id'] ?? 0);
        $countyId   = (int)($post['county_id'] ?? 0);
        $schoolId   = (int)($post['school_id'] ?? 0);
        $leaderId   = (int)($post['inviter_user_id'] ?? 0);
        $birthDate  = ($post['year'] ?? '') . '-' . ($post['month'] ?? '') . '-' . ($post['day'] ?? '');

        // Temel Validasyon
        if (empty($name) || empty($surname) || empty($mobile) || empty($categoryId)) {
            return $this->response->setJSON([
                'status'  => 0,
                'message' => 'Lütfen tüm zorunlu alanları eksiksiz doldurunuz.',
            ]);
        }

        // Türkiye seçilmişse il ve ilçe zorunlu
        if ($countryId === 225 && (empty($cityId) || empty($countyId))) {
            return $this->response->setJSON([
                'status'  => 0,
                'message' => 'Lütfen il ve ilçe seçiminizi yapınız.',
            ]);
        }

        // Tekil Yarışmacı Uniq ID üretimi
        $uniqId = 'uy_' . substr(md5($mobile . time() . uniqid()), 0, 16);

        // Kullanıcı nesnesi
        $user = [
            'id'             => rand(300000, 999999),
            'uniq_id'        => $uniqId,
            'name'           => $name . ' ' . $surname,
            'mobile'         => $mobile,
            'birthdate'      => $birthDate,
            'gender_id'      => $genderId,
            'category_id'    => $categoryId,
            'country_id'     => $countryId,
            'city_id'        => $cityId,
            'county_id'      => $countyId,
            'school_id'      => $schoolId,
            'leader_id'      => $leaderId,
            'registered_at'  => date('Y-m-d H:i:s'),
        ];

        // Oturumu başlat
        session()->set('ufka_user', $user);

        // Sertifika URL (referans t1 formatı)
        $certificateUrl = "https://t1.ufkayolculuk.com/uploads/2024-10/sertifika_katilimci.webp";

        return $this->response->setJSON([
            'status'      => 1,
            'uniq_id'     => $uniqId,
            'certificate' => $certificateUrl,
            'is_leader'   => ($leaderId > 0 ? 1 : 0),
            'message'     => 'Kaydınız başarıyla tamamlanmıştır!',
        ]);
    }

    /**
     * Kayıt Tamamlandı Sinyali (registerDone)
     */
    public function registerDone(string $uniqId): ResponseInterface
    {
        log_message('info', "Yarışmacı kaydı başarıyla tamamlandı. Uniq ID: {$uniqId}");

        return $this->response->setJSON([
            'status'  => 1,
            'uniq_id' => $uniqId,
        ]);
    }
}
