<?php

namespace App\Controllers;

use App\Services\UfkaApiService;

class Sss extends BaseController
{
    protected UfkaApiService $api;

    public function __construct()
    {
        $this->api = new UfkaApiService();
    }

    public function index(): string
    {
        $faqs = $this->api->getFaqList();

        $data = [
            'title'            => 'Sıkça Sorulan Sorular (SSS) - Ufka Yolculuk',
            'meta_description' => 'Ufka Yolculuk yarışması hakkında en çok merak edilen sorular, yarışma şartları, sınav kuralları, kitaplar ve ödüllere dair tüm resmi cevaplar.',
            'activePage'       => 'sss',
            'faqs'             => $faqs,
        ];

        return view('sss', $data);
    }
}
