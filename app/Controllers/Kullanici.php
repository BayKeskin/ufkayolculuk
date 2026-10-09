<?php

namespace App\Controllers;

use App\Services\UfkaApiService;

class Kullanici extends BaseController
{
    protected UfkaApiService $api;

    public function __construct()
    {
        $this->api = new UfkaApiService();
    }

    /**
     * Aktif kullanıcıyı getirir, yoksa önizleme/demo profili döner
     */
    protected function getActiveUser(): array
    {
        $sessionUser = session()->get('ufka_user');

        if (!empty($sessionUser)) {
            $inviteCode = 'UY' . strtoupper(substr(md5((string)($sessionUser['id'] ?? $sessionUser['name'] ?? 'user')), 0, 10));
            return array_merge([
                'id'             => 101,
                'name'           => 'Yarışmacı',
                'category_title' => 'Yetişkin Kategorisi',
                'grade'          => '',
                'city'           => 'İstanbul',
                'school'         => '',
                'invite_code'    => $inviteCode,
                'general_score'  => '3.27',
                'turkey_rank'    => '48296',
                'city_rank'      => '460',
                'leader_category'=> 'DİĞER Kategorisi',
                'leader_score'   => '0.0000000',
                'is_demo'        => false,
            ], $sessionUser, [
                'invite_code'    => $sessionUser['invite_code'] ?? $inviteCode,
                'general_score'  => $sessionUser['general_score'] ?? '3.27',
                'turkey_rank'    => $sessionUser['turkey_rank'] ?? '48296',
                'city_rank'      => $sessionUser['city_rank'] ?? '460',
                'leader_category'=> $sessionUser['leader_category'] ?? 'DİĞER Kategorisi',
                'leader_score'   => $sessionUser['leader_score'] ?? '0.0000000',
            ]);
        }

        // Demo / Önizleme kullanıcısı (Resimdeki ibrahim._. tekmen örneği)
        return [
            'id'              => 48296,
            'name'            => 'ibrahim._. tekmen',
            'category_title'  => 'Yetişkin Kategorisi',
            'grade'           => 'Yetişkin',
            'city'            => 'İstanbul',
            'school'          => 'İstanbul Üniversitesi',
            'invite_code'     => 'UYCOPBLLH1YDO',
            'general_score'   => '3.27',
            'turkey_rank'     => '48296',
            'city_rank'       => '460',
            'leader_category' => 'DİĞER Kategorisi',
            'leader_score'    => '0.0000000',
            'is_demo'         => true,
        ];
    }

    /**
     * Sınavlarım & Sonuçlarım Sayfası (/sinavlarim, /sonuclarim)
     */
    public function sinavlarim()
    {
        $user = $this->getActiveUser();
        $exams = $this->api->getExams();

        // Kullanıcının katıldığı sınav örnek kayıtları
        $userExams = [
            [
                'id'            => 1,
                'name'          => '14. Ufka Yolculuk Online Deneme Sınavı',
                'date'          => '22 Mart 2026',
                'status'        => 'Tamamlandı',
                'correct'       => 32,
                'wrong'         => 6,
                'empty'         => 2,
                'score'         => '3.27',
                'turkey_rank'   => '48.296 / 185.420',
                'city_rank'     => '460 / 14.280',
                'has_cert'      => true,
            ]
        ];

        return view('kullanici/sinavlarim', [
            'title'       => 'Sınavlarım ve Sonuçlarım - Ufka Yolculuk',
            'activePage'  => 'sinavlarim',
            'user'        => $user,
            'userExams'   => $userExams,
            'availableExams' => $exams,
        ]);
    }

    /**
     * Davet Et / Vesile Olduklarım Sayfası (/vesile-olduklarim, /davet-et)
     */
    public function davet()
    {
        $user = $this->getActiveUser();
        $inviteLink = base_url('hosgeldin/' . $user['invite_code']);

        // Davet edilen yarışmacılar listesi (Varsayılan boş tablo - ekran görüntüsündeki gibi)
        $invitedList = [];

        return view('kullanici/davet', [
            'title'        => 'Davet Et & Vesile Olduklarım - Ufka Yolculuk',
            'activePage'   => 'davet',
            'user'         => $user,
            'inviteLink'   => $inviteLink,
            'invitedList'  => $invitedList,
        ]);
    }

    /**
     * Sertifikalarım Sayfası (/sertifikalarim)
     */
    public function sertifikalarim()
    {
        $user = $this->getActiveUser();

        $certificates = [
            [
                'id'          => 'cert_katilim_14',
                'title'       => '14. Ufka Yolculuk Katılım Belgesi',
                'category'    => $user['category_title'],
                'date'        => '2026',
                'badge'       => 'Resmi Katılım Belgesi',
                'color'       => 'primary',
                'code'        => 'UY-KB-' . strtoupper(substr(md5($user['name'] . 'katilim'), 0, 8)),
                'desc'        => 'Bilgi ve erdem dolu yarışmamıza katılımınızdan ötürü tebrik ederiz.',
            ],
            [
                'id'          => 'cert_basari_14',
                'title'       => '14. Ufka Yolculuk Başarı Sertifikası',
                'category'    => $user['category_title'],
                'date'        => '2026',
                'badge'       => 'Yarışma Derecesi',
                'color'       => 'success',
                'code'        => 'UY-BS-' . strtoupper(substr(md5($user['name'] . 'basari'), 0, 8)),
                'desc'        => "Türkiye geneli {$user['turkey_rank']}. sıra ve İl geneli {$user['city_rank']}. derece başarısı.",
            ],
            [
                'id'          => 'cert_lider_14',
                'title'       => 'Takım Lideri Teşekkür Belgesi',
                'category'    => $user['leader_category'],
                'date'        => '2026',
                'badge'       => 'Gönüllü Liderlik',
                'color'       => 'warning',
                'code'        => 'UY-TL-' . strtoupper(substr(md5($user['name'] . 'lider'), 0, 8)),
                'desc'        => 'Geleceğin erdemli nesillerinin yetişmesine sunduğunuz değerli katkılar için teşekkür ederiz.',
            ],
        ];

        return view('kullanici/sertifikalarim', [
            'title'        => 'Sertifikalarım & Belgelerim - Ufka Yolculuk',
            'activePage'   => 'sertifikalarim',
            'user'         => $user,
            'certificates' => $certificates,
        ]);
    }

    /**
     * Takım Lideri Sayfası (/takim-lideri)
     */
    public function takimLideri()
    {
        $user = $this->getActiveUser();

        return view('kullanici/takim_lideri', [
            'title'      => 'Takım Lideri Portalı - Ufka Yolculuk',
            'activePage' => 'takim-lideri',
            'user'       => $user,
        ]);
    }
}
