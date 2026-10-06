<?php

namespace App\Controllers;

use App\Services\UfkaApiService;

class Duyurular extends BaseController
{
    protected UfkaApiService $api;

    public function __construct()
    {
        $this->api = new UfkaApiService();
    }

    public function index(): string
    {
        $announcements = $this->api->getAnnouncements();

        // Kategori istatistikleri
        $duyuruCount  = 0;
        $haberCount   = 0;
        $etkinlikCount = 0;

        foreach ($announcements as $item) {
            $type = strtolower($item['type'] ?? '');
            if ($type === 'news' || str_contains($type, 'haber')) {
                $haberCount++;
            } elseif ($type === 'event' || str_contains($type, 'etkinlik')) {
                $etkinlikCount++;
            } else {
                $duyuruCount++;
            }
        }

        $data = [
            'title'            => 'Duyurular ve Haberler - Ufka Yolculuk',
            'meta_description' => 'Ufka Yolculuk Bilgi ve Kültür Yarışması güncel duyuruları, haberleri ve resmi açıklamaları.',
            'activePage'       => 'duyurular',
            'announcements'    => $announcements,
            'counts'           => [
                'total'    => count($announcements),
                'duyuru'   => $duyuruCount,
                'haber'    => $haberCount,
                'etkinlik' => $etkinlikCount,
            ],
            'api'              => $this->api,
        ];

        return view('duyurular', $data);
    }
}
