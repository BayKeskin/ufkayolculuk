<?php

namespace App\Controllers;

use App\Services\UfkaApiService;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    protected UfkaApiService $api;

    public function __construct()
    {
        $this->api = new UfkaApiService();
    }

    /**
     * Yarışmacı Giriş İşlemi (AJAX POST)
     */
    public function login(): ResponseInterface
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Geçersiz istek.',
            ]);
        }

        $rules = [
            'phone'     => 'required|min_length[10]|max_length[20]',
            'birthdate' => 'required|valid_date[Y-m-d]',
        ];

        $messages = [
            'phone' => [
                'required'   => 'Lütfen telefon numaranızı giriniz.',
                'min_length' => 'Telefon numarası en az 10 haneli olmalıdır.',
            ],
            'birthdate' => [
                'required'   => 'Lütfen doğum tarihinizi seçiniz.',
                'valid_date' => 'Lütfen geçerli bir doğum tarihi seçiniz.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Lütfen giriş bilgilerini eksiksiz doldurunuz.',
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        $phone     = (string)$this->request->getPost('phone');
        $birthDate = (string)$this->request->getPost('birthdate');

        // API üzerinden kullanıcıyı sorgula
        $user = $this->api->verifyUser($phone, $birthDate);

        if ($user) {
            // Kullanıcının API'deki detay profilini, sınav sonuçlarını ve kodlarını yükle
            if (!empty($user['id'])) {
                try {
                    $userData = $this->api->getUserData((int)$user['id']);
                    if (!empty($userData['user'])) {
                        $user['inviter_code']     = $userData['user']['inviter_code'] ?? null;
                        $user['consultant_code']  = $userData['user']['consultant_code'] ?? null;
                        $user['is_consultant']    = $userData['user']['is_consultant'] ?? null;
                        $user['consultant_type']  = $userData['user']['consultant_type'] ?? null;
                    }
                    $userResults = $this->api->getUserResults((int)$user['id']);
                    if (!empty($userResults['user_summary'])) {
                        $user['general_score'] = $userResults['user_summary']['overall_score'] ?? null;
                        $user['turkey_rank']   = $userResults['user_summary']['global_rank'] ?? null;
                        $user['city_rank']     = $userResults['user_summary']['city_rank'] ?? null;
                    }
                } catch (\Throwable $e) {
                    log_message('error', 'Auth login user stats fetch error: ' . $e->getMessage());
                }
            }

            // Oturumu başlat
            session()->set('ufka_user', $user);

            return $this->response->setJSON([
                'success' => true,
                'message' => "Hoş geldiniz, {$user['name']}! Girişiniz başarıyla onaylandı.",
                'user'    => [
                    'id'             => $user['id'],
                    'name'           => $user['name'],
                    'category_title' => $user['category_title'],
                    'grade'          => $user['grade'],
                    'city'           => $user['city'],
                ],
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Girdiğiniz telefon numarası veya doğum tarihi ile eşleşen bir yarışmacı kaydı bulunamadı. Lütfen yarışmaya kayıt olduğunuz bilgileri kontrol ediniz.',
        ]);
    }

    /**
     * Güvenli Çıkış İşlemi
     */
    public function logout()
    {
        session()->remove('ufka_user');

        return redirect()->to(base_url())->with('info', 'Oturumunuz başarıyla kapatıldı.');
    }

    /**
     * Aktif Kullanıcı Durumu (AJAX GET)
     */
    public function status(): ResponseInterface
    {
        $user = session()->get('ufka_user');

        return $this->response->setJSON([
            'is_logged_in' => !empty($user),
            'user'         => $user ?: null,
        ]);
    }

    /**
     * Yarışmacı Kayıt İşlemi (AJAX POST)
     */
    public function register(): ResponseInterface
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Geçersiz istek.',
            ]);
        }

        $rules = [
            'name'      => 'required|min_length[3]|max_length[100]',
            'phone'     => 'required|min_length[10]|max_length[20]',
            'birthdate' => 'required|valid_date[Y-m-d]',
            'category'  => 'required',
            'city'      => 'required',
            'terms'     => 'required',
        ];

        $messages = [
            'name' => [
                'required'   => 'Lütfen adınızı ve soyadınızı giriniz.',
                'min_length' => 'Ad Soyad en az 3 karakterden oluşmalıdır.',
            ],
            'phone' => [
                'required'   => 'Lütfen telefon numaranızı giriniz.',
                'min_length' => 'Telefon numarası en az 10 haneli olmalıdır.',
            ],
            'birthdate' => [
                'required'   => 'Lütfen doğum tarihinizi seçiniz.',
                'valid_date' => 'Lütfen geçerli bir doğum tarihi seçiniz.',
            ],
            'category' => [
                'required' => 'Lütfen yarışma kategorinizi seçiniz.',
            ],
            'city' => [
                'required' => 'Lütfen bulunduğunuz ili seçiniz.',
            ],
            'terms' => [
                'required' => 'Yarışmaya katılabilmek için şartname ve aydınlatma metnini onaylamanız gerekmektedir.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Lütfen kayıt formundaki gerekli alanları doldurunuz.',
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        $name      = trim((string)$this->request->getPost('name'));
        $phone     = (string)$this->request->getPost('phone');
        $birthDate = (string)$this->request->getPost('birthdate');
        $category  = (string)$this->request->getPost('category');
        $city      = (string)$this->request->getPost('city');

        // Kullanıcı nesnesi oluştur
        $user = [
            'id'             => rand(200000, 999999),
            'name'           => $name,
            'mobile'         => preg_replace('/[^\d]/', '', $phone),
            'birthdate'      => $birthDate,
            'category_title' => $category,
            'grade'          => $category,
            'city'           => $city,
            'registered_at'  => date('Y-m-d H:i:s'),
        ];

        // Oturumu başlat
        session()->set('ufka_user', $user);

        return $this->response->setJSON([
            'success' => true,
            'message' => "Tebrikler, {$name}! Ufka Yolculuk yarışma kaydınız başarıyla tamamlandı. Yarışmacı paneline yönlendiriliyorsunuz...",
            'user'    => $user,
        ]);
    }
}
