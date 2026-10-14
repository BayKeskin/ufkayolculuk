<?php

namespace App\Controllers;

use App\Services\UfkaApiService;

class Kitaplar extends BaseController
{
    protected UfkaApiService $api;

    public function __construct()
    {
        $this->api = new UfkaApiService();
    }

    public function index(?string $categorySlug = null): string
    {
        $books = [
            [
                'id'        => 1,
                'slug'      => 'kuslarin-cagrisi-2',
                'name'      => 'Kuşların Çağrısı',
                'category'  => 'İlkokul',
                'image'     => 'uploads/2025-12/ilkokul_68d9a114d5496_693e4df60bfe0.webp',
                'last_page' => 0,
            ],
            [
                'id'        => 2,
                'slug'      => 'tevhid-muhafizlari',
                'name'      => 'Tevhid Muhafızları',
                'category'  => 'Ortaokul',
                'image'     => 'uploads/2025-12/ortaokul_68d9a11bca841_693e4f59d850b.webp',
                'last_page' => 0,
            ],
            [
                'id'        => 3,
                'slug'      => 'gordugume-gormedigime',
                'name'      => 'Gördüğüme görmediğime',
                'category'  => 'Lise',
                'image'     => 'uploads/2025-12/lise_68d9a116d8120_693e4d7585337.webp',
                'last_page' => 0,
            ],
            [
                'id'        => 4,
                'slug'      => 'nasil-inanmali',
                'name'      => 'Nasıl İnanmalı',
                'category'  => 'Yetişkin',
                'image'     => 'uploads/2025-12/yetiskin_68d9a11dce0cc_693e4f8f38593.webp',
                'last_page' => 0,
            ],
        ];

        $data = [
            'title'            => 'Kitaplar - Ufka Yolculuk',
            'meta_description' => 'Ufka Yolculuk yarışma kitapları. Tüm kitaplarımızı ücretsiz online okuyabilirsiniz.',
            'keywords'         => 'kitap oku, ufka yolculuk kitapları, online kitap oku, yarışma kitapları',
            'activePage'       => 'kitaplar',
            'categoryTitle'    => 'Ufka Yolculuk 13',
            'books'            => $books,
            'api'              => $this->api,
        ];

        return view('kitaplar', $data);
    }
}
