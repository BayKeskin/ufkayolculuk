<?php

namespace App\Controllers;

use App\Services\UfkaApiService;

class Sayfa extends BaseController
{
    protected UfkaApiService $api;

    public function __construct()
    {
        $this->api = new UfkaApiService();
    }

    public function detay(string $slug = 'hakkimizda'): string
    {
        $content = null;
        $title = 'Hakkımızda & Misyonumuz - Ufka Yolculuk';
        $metaDescription = 'Ufka Yolculuk Bilgi ve Kültür Yarışması hakkında bilgiler, misyon, vizyon ve değerlerimiz.';
        $pageType = 'corporate'; // 'corporate' veya 'announcement'

        // En son 5 duyuruyu yan panel için çek
        $recentAnnouncements = $this->api->getAnnouncements(5);

        // Sabit kurumsal/hukuki navigasyon menüsü
        $corporatePages = [
            'hakkimizda'               => ['title' => 'Hakkımızda', 'url' => base_url('sayfa-detay'), 'icon' => '🏢'],
            'misyon-vizyon'            => ['title' => 'Misyon & Vizyon', 'url' => base_url('sayfa/misyon-vizyon'), 'icon' => '🎯'],
            'biz-kimiz'                => ['title' => 'Biz Kimiz?', 'url' => base_url('sayfa/biz-kimiz'), 'icon' => '👥'],
            'sartname'                 => ['title' => 'Yarışma Şartnamesi', 'url' => base_url('sayfa/sartname'), 'icon' => '📜'],
            'resmi-onaylar'            => ['title' => 'Resmi Onaylar (MEB)', 'url' => base_url('sayfa/resmi-onaylar'), 'icon' => '🏛️'],
            'uy-kvkk-aydinlatma-metni' => ['title' => 'KVKK Aydınlatma Metni', 'url' => base_url('sayfa/uy-kvkk-aydinlatma-metni'), 'icon' => '🔒'],
            'uy-mahremiyet-politikasi' => ['title' => 'Mahremiyet Politikası', 'url' => base_url('sayfa/uy-mahremiyet-politikasi'), 'icon' => '🛡️'],
            'UY-Veli-izin-Belgesi'     => ['title' => 'Veli İzin Belgesi', 'url' => base_url('sayfa/UY-Veli-izin-Belgesi'), 'icon' => '📝'],
        ];

        if ($slug !== 'hakkimizda') {
            $content = $this->api->getWebContent($slug);
            if ($content) {
                $rawTitle = $content['title'] ?? 'Sayfa Detayı';
                $title = $rawTitle . ' - Ufka Yolculuk';
                
                // Sayfa tipi tespiti (Duyuru mu kurumsal mı?)
                $rawType = strtolower($content['type'] ?? '');
                if (in_array($rawType, ['annoucement', 'announcement', 'news', 'duyuru', 'haber'])) {
                    $pageType = 'announcement';
                } else {
                    $pageType = 'corporate';
                }

                // Meta Açıklaması
                $cleanDesc = !empty($content['description']) ? $content['description'] : strip_tags($content['body'] ?? '');
                $cleanDesc = html_entity_decode($cleanDesc, ENT_QUOTES, 'UTF-8');
                $cleanDesc = preg_replace('/\s+/', ' ', trim($cleanDesc));
                if (!empty($cleanDesc)) {
                    $metaDescription = mb_strlen($cleanDesc) > 160 ? mb_substr($cleanDesc, 0, 157) . '...' : $cleanDesc;
                }

                // Gövde içindeki göreceli görsel ve belge URL'lerini mutlak URL'ye çevir (src ve href)
                if (!empty($content['body'])) {
                    $content['body'] = preg_replace(
                        '/(src|href)=["\'](?!https?:\/\/|\/\/)(?:\/?)(uploads\/[^"\']+)["\']/i',
                        '$1="https://yonetim.ufkayolculuk.com/$2"',
                        $content['body']
                    );
                }
            } else {
                // İçerik bulunamadığında genel bilgi sayfası başlığı
                $title = 'İçerik Bulunamadı - Ufka Yolculuk';
            }
        }

        $data = [
            'title'               => $title,
            'meta_description'    => $metaDescription,
            'activePage'          => 'sayfa-detay',
            'slug'                => $slug,
            'content'             => $content,
            'pageType'            => $pageType,
            'corporatePages'      => $corporatePages,
            'recentAnnouncements' => $recentAnnouncements,
            'api'                 => $this->api,
        ];

        return view('sayfa_detay', $data);
    }
}
