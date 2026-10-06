<?php

namespace App\Controllers;

use App\Services\UfkaApiService;

class Home extends BaseController
{
    protected UfkaApiService $api;

    public function __construct()
    {
        $this->api = new UfkaApiService();
    }

    public function index(): string
    {
        // En son 2 güncel duyuruyu API'den çek (tasarım dengesi için 2 adet ile sınırlandı)
        $announcements  = $this->api->getAnnouncements(2);
        $importantDates = $this->api->getImportantDates();
        $categories     = $this->api->getCompetitionCategories();

        // Modala ve JS'e aktarılacak kitap verileri
        $bookDataMap = [];
        foreach ($categories as $slug => $cat) {
            $book = $cat['book'] ?? [];
            $bookDataMap[$slug] = [
                'cover'     => $book['image_url'] ?? $cat['fallback_image'],
                'title'     => $book['name'] ?? $cat['title'],
                'cat'       => ($cat['icon'] ?? '⭐') . ' ' . $cat['title'],
                'grade'     => $cat['grade'] ?? '',
                'sub'       => $cat['sub'] ?? '',
                'publisher' => $cat['publisher'] ?? 'Ufka Yolculuk Yayınları',
                'pages'     => $cat['pages'] ?? '200+ Sayfa',
                'questions' => $cat['questions'] ?? '50 Soru',
                'age'       => $cat['age'] ?? '',
                'summary'   => !empty($book['desc_clean']) ? $book['desc_clean'] : $cat['sub'],
                'summaryHtml'=> $book['desc_html'] ?? '',
                'readUrl'   => $cat['read_url'] ?? '#',
                'listenUrl' => !empty($book['sound_url']) ? $book['sound_url'] : ($cat['listen_url'] ?? '#'),
                'audio'     => ($book['name'] ?? $cat['title']) . ' - Sesli Kitap',
                'audioSrc'  => $book['sound_url'] ?? '',
            ];
        }

        $mediaList      = $this->api->getMediaContents();

        $data = [
            'title'            => 'Ufka Yolculuk - Bilgi ve Kültür Yarışması',
            'meta_description' => 'Ufka Yolculuk Bilgi ve Kültür Yarışması resmi web sitesi. Kitap oku, soruları çöz, puan topla ve birbirinden değerli ödüller kazan!',
            'activePage'       => 'home',
            'announcements'    => $announcements,
            'importantDates'   => $importantDates,
            'categories'       => $categories,
            'bookDataMap'      => $bookDataMap,
            'mediaList'        => $mediaList,
            'api'              => $this->api,
        ];

        return view('home', $data);
    }
}
