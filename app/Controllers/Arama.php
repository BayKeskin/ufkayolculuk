<?php

namespace App\Controllers;

use App\Services\UfkaApiService;
use CodeIgniter\HTTP\ResponseInterface;

class Arama extends BaseController
{
    protected UfkaApiService $api;

    public function __construct()
    {
        $this->api = new UfkaApiService();
    }

    /**
     * Otomatik Tamamlama & Hızlı Arama AJAX Endpoint
     * GET /arama/autocomplete?q=...
     */
    public function autocomplete(): ResponseInterface
    {
        $query = trim((string)$this->request->getGet('q'));

        // SSS listesini al
        $faqData = $this->api->getFaqList();
        $faqs = $faqData['items'] ?? [];

        // Standart hızlı öneriler (Görselde görünen sık sorulan sorular)
        $defaultFaqs = [
            [
                'title' => 'Ödülleri',
                'url'   => base_url('oduller'),
                'type'  => 'sss',
            ],
            [
                'title' => 'Bu sene düzenlenecek olan yarışmanın konusu nedir?',
                'url'   => base_url('sss#yarisma'),
                'type'  => 'sss',
            ],
            [
                'title' => 'E-kitaplara nasıl ulaşabilirim?',
                'url'   => base_url('/#kategoriler'),
                'type'  => 'sss',
            ],
            [
                'title' => 'Yarışmada kitaptaki dipnotlardan sorumlu muyuz ?',
                'url'   => base_url('sss#sinav'),
                'type'  => 'sss',
            ],
            [
                'title' => 'Sınav kuralları nelerdir?',
                'url'   => base_url('sayfa/sartname'),
                'type'  => 'sss',
            ],
        ];

        // Eğer arama sorgusu boşsa varsayılan önerileri döner
        if (mb_strlen($query) < 1) {
            return $this->response->setJSON([
                'success' => true,
                'results' => $defaultFaqs,
                'is_default' => true,
            ]);
        }

        $results = [];
        $normQuery = $this->normText($query);

        // 1. SSS başlıklarında arama
        foreach ($faqs as $item) {
            $t = $item['title'] ?? '';
            $b = $item['body_clean'] ?? '';
            if (str_contains($this->normText($t), $normQuery) || str_contains($this->normText($b), $normQuery)) {
                $results[] = [
                    'title' => $t,
                    'url'   => base_url('sss#' . ($item['slug'] ?? 'faq-' . $item['id'])),
                    'type'  => 'sss',
                    'badge' => $item['category_name'] ?? 'Sıkça Sorulan Soru',
                ];
            }
            if (count($results) >= 8) break;
        }

        // 2. Eğer az sonuç varsa sayfalar ve genel linklerde arama
        $siteLinks = [
            ['title' => 'Yarışma Şartnamesi', 'url' => base_url('sayfa/sartname'), 'type' => 'sayfa', 'badge' => 'Kurumsal'],
            ['title' => 'Türkiye Geneli ve İl Ödülleri', 'url' => base_url('oduller'), 'type' => 'sayfa', 'badge' => 'Ödüller'],
            ['title' => 'Yarışma Kitapları ve Sesli Dinleme', 'url' => base_url('/#kategoriler'), 'type' => 'sayfa', 'badge' => 'Kitaplar'],
            ['title' => 'Sınavlarım ve Derecelerim', 'url' => base_url('sinavlarim'), 'type' => 'sayfa', 'badge' => 'Profil'],
            ['title' => 'Sertifikalarım ve Katılım Belgelerim', 'url' => base_url('sertifikalarim'), 'type' => 'sayfa', 'badge' => 'Profil'],
            ['title' => 'Arkadaşını Davet Et (Vesile Olduklarım)', 'url' => base_url('vesile-olduklarim'), 'type' => 'sayfa', 'badge' => 'Davet'],
            ['title' => 'Takım Lideri Başvurusu', 'url' => base_url('takim-lideri'), 'type' => 'sayfa', 'badge' => 'Liderlik'],
            ['title' => 'Duyurular ve Yarışma Takvimi', 'url' => base_url('duyurular'), 'type' => 'sayfa', 'badge' => 'Duyurular'],
            ['title' => 'İletişim ve Danışma', 'url' => base_url('iletisim'), 'type' => 'sayfa', 'badge' => 'İletişim'],
        ];

        foreach ($siteLinks as $link) {
            if (str_contains($this->normText($link['title']), $normQuery)) {
                $results[] = $link;
            }
            if (count($results) >= 10) break;
        }

        return $this->response->setJSON([
            'success' => true,
            'query'   => $query,
            'results' => $results,
            'is_default' => false,
        ]);
    }

    private function normText(string $str): string
    {
        $search  = ['İ', 'I', 'ı', 'ğ', 'Ğ', 'ü', 'Ü', 'ş', 'Ş', 'ö', 'Ö', 'ç', 'Ç'];
        $replace = ['i', 'i', 'i', 'g', 'g', 'u', 'u', 's', 's', 'o', 'o', 'c', 'c'];
        return mb_strtolower(str_replace($search, $replace, $str));
    }
}
