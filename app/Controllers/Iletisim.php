<?php

namespace App\Controllers;

use App\Services\UfkaApiService;
use CodeIgniter\HTTP\ResponseInterface;

class Iletisim extends BaseController
{
    protected UfkaApiService $api;

    public function __construct()
    {
        $this->api = new UfkaApiService();
    }

    public function index(): string
    {
        $cities = $this->api->getAwardCities();
        $selectedCity = $this->request->getGet('il') ?? 'Konya';

        // URL'den gelen il adını listedekiyle eşle
        foreach ($cities as $c) {
            if (mb_strtolower($c) === mb_strtolower($selectedCity)) {
                $selectedCity = $c;
                break;
            }
        }

        $data = [
            'title'            => 'İletişim & İl Temsilcilikleri - Ufka Yolculuk',
            'meta_description' => 'Ufka Yolculuk Bilgi ve Kültür Yarışması iletişim bilgileri, 81 il ve ilçe temsilcilikleri sorgulama ve mesaj gönderme formu.',
            'activePage'       => 'iletisim',
            'cities'           => $cities,
            'selectedCity'     => $selectedCity,
        ];

        return view('iletisim', $data);
    }

    /**
     * İletişim formu mesaj gönderimi backend işleyicisi (AJAX & Form POST)
     */
    public function gonder(): ResponseInterface
    {
        if ($this->request->isAJAX()) {
            $rules = [
                'name'    => 'required|min_length[3]|max_length[100]',
                'phone'   => 'required|min_length[10]|max_length[20]',
                'email'   => 'permit_empty|valid_email|max_length[120]',
                'subject' => 'permit_empty|max_length[150]',
                'message' => 'required|min_length[5]|max_length[500]',
            ];

            if (!$this->validate($rules)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Lütfen form alanlarını kurallara uygun şekilde doldurunuz.',
                    'errors'  => $this->validator->getErrors(),
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Mesajınız başarıyla iletildi. En kısa sürede sizinle iletişime geçilecektir.',
            ]);
        }

        return redirect()->to(base_url('iletisim'));
    }
}
