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
            'biz-kimiz'                => ['title' => 'Biz Kimiz?', 'url' => base_url('sayfa/biz-kimiz'), 'icon' => '👥'],
            'misyon-vizyon'            => ['title' => 'Misyon & Vizyon', 'url' => base_url('sayfa/misyon-vizyon'), 'icon' => '🎯'],
            'gecmis-yillar'            => ['title' => 'Geçmiş Yıllar', 'url' => base_url('sayfa/gecmis-yillar'), 'icon' => '🏆'],
            'sartname'                 => ['title' => 'Yarışma Şartnamesi', 'url' => base_url('sayfa/sartname'), 'icon' => '📜'],
            'sinav-kurallari'          => ['title' => 'Sınav Kuralları', 'url' => base_url('sayfa/sinav-kurallari'), 'icon' => '📝'],
            'materyaller'              => ['title' => 'Materyaller', 'url' => base_url('sayfa/materyaller'), 'icon' => '📁'],
            'kitap-temin-noktalari'    => ['title' => 'Kitap Temin Noktaları', 'url' => base_url('sayfa/kitap-temin-noktalari'), 'icon' => '📍'],
            'resmi-onaylar'            => ['title' => 'Resmi Onaylar (MEB)', 'url' => base_url('sayfa/resmi-onaylar'), 'icon' => '🏛️'],
            'uy-kvkk-aydinlatma-metni' => ['title' => 'KVKK Aydınlatma Metni', 'url' => base_url('sayfa/uy-kvkk-aydinlatma-metni'), 'icon' => '🔒'],
            'uy-mahremiyet-politikasi' => ['title' => 'Mahremiyet Politikası', 'url' => base_url('sayfa/uy-mahremiyet-politikasi'), 'icon' => '🛡️'],
            'UY-Veli-izin-Belgesi'     => ['title' => 'Veli İzin Belgesi', 'url' => base_url('sayfa/UY-Veli-izin-Belgesi'), 'icon' => '📝'],
        ];

        if ($slug !== 'hakkimizda') {
            $content = $this->api->getWebContent($slug);
            if (!$content) {
                $content = $this->getStaticFallback($slug);
            }

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

    protected function getStaticFallback(string $slug): ?array
    {
        switch ($slug) {
            case 'biz-kimiz':
                return [
                    'title' => 'Biz Kimiz? - Ufka Yolculuk Hikayesi',
                    'type' => 'corporate',
                    'category_title' => 'Hakkımızda',
                    'description' => '13 yıldır yüz binlerce yol arkadaşımıza ulaştığımız Ufka Yolculuk Bilgi ve Kültür Yarışmaları hikayesi ve kuruluş felsefesi.',
                    'body' => '
                        <div class="mb-4">
                            <h3 class="fw-bold text-dark mb-3">Ufka Yolculuk Hikayesi</h3>
                            <p class="lead text-secondary">
                                Bilginin hızla çoğaldığı fakat gerçeği ayırt etmenin her zamankinden daha kıymetli hale geldiği bir çağda; yarının dünyasını iyi niyetle yaşayan, güzel ahlâkı kuşanan ve sağduyuyla doğru düşünen insanların şekillendireceğine inanıyoruz.
                            </p>
                            <p>
                                Bu bilinçle; sahih kaynaklardan beslenen, zihni berraklaştıran; okuyan, araştıran, sorgulayan ve öğrendiğini insani erdemlerle hayatına yansıtan bireylerin yetişmesine katkı sunuyoruz. Her yıl hayatın ve insanın özüne dair farklı bir meseleyi gündeme taşıyarak bilgiye ulaşmayı kolaylaştırıyoruz.
                            </p>
                            <p>
                                <strong>13 yıldır</strong> düzenlediğimiz Ufka Yolculuk Bilgi ve Kültür Yarışmaları ile bugüne dek yüz binlerce yol arkadaşımıza ulaştık. Bugün ise <strong>14. kez</strong> birlikte yola çıkmanın heyecanını yaşıyoruz.
                            </p>
                        </div>
                        <div class="row g-3 mt-4">
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3 text-center border">
                                    <div class="fs-2 mb-2">📚</div>
                                    <h6 class="fw-bold text-dark">Sahih Bilgi</h6>
                                    <p class="small text-muted mb-0">Güvenilir kaynaklardan derlenen seçkin eserlerle ahlaki ve fikri gelişim.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3 text-center border">
                                    <div class="fs-2 mb-2">💡</div>
                                    <h6 class="fw-bold text-dark">Sağduyulu Düşünce</h6>
                                    <p class="small text-muted mb-0">Teknoloji ve bilimi insanlık faydasına, vicdan ve ahlak terazisinde kullanma.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="p-3 bg-light rounded-3 text-center border">
                                    <div class="fs-2 mb-2">🌱</div>
                                    <h6 class="fw-bold text-dark">Geleceğe Yatırım</h6>
                                    <p class="small text-muted mb-0">İlkokuldan yetişkine 7\'den 70\'e toplumun her kesimine ulaşan okuma seferberliği.</p>
                                </div>
                            </div>
                        </div>'
                ];

            case 'misyon-vizyon':
                return [
                    'title' => 'Misyonumuz ve Vizyonumuz',
                    'type' => 'corporate',
                    'category_title' => 'Hakkımızda',
                    'description' => 'Ufka Yolculuk Bilgi ve Kültür Yarışmaları misyon ve vizyon hedefleri.',
                    'body' => '
                        <div class="mb-4">
                            <h3 class="fw-bold text-dark mb-3">🎯 Misyonumuz</h3>
                            <p class="lead text-secondary">Katılımcılarımızı sahih ve güvenilir eserlerle buluşturarak;</p>
                            <ul class="list-unstyled d-flex flex-column gap-2 mt-3">
                                <li class="p-3 bg-light rounded-2 border-start border-4 border-primary">
                                    <strong>📖 Okuma ve Düşünme Kültürü:</strong> Okuma, araştırma ve eleştirel düşünme alışkanlığını geliştirmek.
                                </li>
                                <li class="p-3 bg-light rounded-2 border-start border-4 border-warning">
                                    <strong>🤖 Bilinçli Teknoloji ve Yapay Zekâ:</strong> Teknoloji ve yapay zekânın sunduğu yenilikleri akıl, vicdan ve insani değerler ışığında bilinçli ve sorumlu bir şekilde kullanabilme yetisi kazandırmak.
                                </li>
                                <li class="p-3 bg-light rounded-2 border-start border-4 border-success">
                                    <strong>🌍 Toplumsal Fayda:</strong> Çağın sunduğu tüm imkânları; kendisine, ailesine, toplumuna, vatanına ve milletine faydaya dönüştürebilen şuurlu bireylerin yetişmesine destek olmaktır.
                                </li>
                            </ul>
                        </div>
                        <div class="mt-5">
                            <h3 class="fw-bold text-dark mb-3">🔭 Vizyonumuz</h3>
                            <div class="p-4 bg-light rounded-3 border">
                                <p class="lead text-dark mb-0 fst-italic">
                                    "Yarının dünyasını iyi niyet, güzel ahlâk ve sağduyulu düşünceyle şekillendiren; zihni berrak, insani erdemlerle donanmış, doğru bilgiyi erdemli davranışa dönüştüren nesillerin yetiştiği aydınlık bir gelecek inşa etmektir."
                                </p>
                            </div>
                        </div>'
                ];

            case 'gecmis-yillar':
                return [
                    'title' => 'Geçmiş Yıllar - Ufka Yolculuk Tarihçesi',
                    'type' => 'corporate',
                    'category_title' => 'Tarihçe & İstatistik',
                    'description' => '2013\'ten günümüze düzenlenen tüm Ufka Yolculuk yarışmaları, temaları, kitapları ve 6.6 milyonu aşkın yarışmacı katılımı.',
                    'body' => '
                        <div class="alert alert-warning d-flex align-items-center gap-3 p-3 rounded-3 mb-4">
                            <span class="fs-1">🏆</span>
                            <div>
                                <h5 class="fw-bold text-dark mb-1">Toplam 6.622.447 Yarışmacı Kaydı</h5>
                                <p class="small text-muted mb-0">Ufka Yolculuk, 14 yıllık serüveninde Türkiye\'nin ve dünyanın dört bir yanında milyonlarca okuyucuyu sahih bilgiyle buluşturdu.</p>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle border">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 15%;">Dönem</th>
                                        <th style="width: 25%;">Tema / Konu</th>
                                        <th style="width: 40%;">Yarışma Kitapları</th>
                                        <th style="width: 20%;" class="text-end">Kayıt Sayısı</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>13. Yarışma</strong> (2026)</td>
                                        <td><span class="badge bg-primary">İnanç & Tevhid</span></td>
                                        <td>Kuşların Çağrısı, Tevhid Muhafızları, Gördüğüme Görmediğime, Nasıl İnanmalı?</td>
                                        <td class="text-end fw-bold text-success">800.000+</td>
                                    </tr>
                                    <tr>
                                        <td><strong>12. Yarışma</strong> (2025)</td>
                                        <td><span class="badge bg-secondary">Hak & Adalet</span></td>
                                        <td>Maske Düştü, Zamansızlar Mektebi, Yolların Kanunu, İncinsen de İncitme</td>
                                        <td class="text-end fw-bold">595.601</td>
                                    </tr>
                                    <tr>
                                        <td><strong>11. Yarışma</strong> (2024)</td>
                                        <td><span class="badge bg-secondary">Ramazan & İbadet</span></td>
                                        <td>Eyvah! Ramazan Kayıp, Bir Başka Zaman Ramazan, 1\'e 1000 Yok mu İsteyen</td>
                                        <td class="text-end fw-bold">550.000</td>
                                    </tr>
                                    <tr>
                                        <td><strong>10. Yarışma</strong> (2022)</td>
                                        <td><span class="badge bg-secondary">Sağlıklı Düşünmek</span></td>
                                        <td>Elma Dersem Düşün, Eyvah! Ceviz Çatırdıyor, Düşün! Bir de Sağlıklı Düşün</td>
                                        <td class="text-end fw-bold">880.000</td>
                                    </tr>
                                    <tr>
                                        <td><strong>9. Yarışma</strong> (2021)</td>
                                        <td><span class="badge bg-secondary">Sağlıklı Yaşam</span></td>
                                        <td>İçimdeki Dostlar, Hastasızhane, Sağlıklı Beslen Sağlıklı Yaşa</td>
                                        <td class="text-end fw-bold">400.000</td>
                                    </tr>
                                    <tr>
                                        <td><strong>8. Yarışma</strong> (2020)</td>
                                        <td><span class="badge bg-secondary">Edep & Nezaket</span></td>
                                        <td>Rota Oluşturuluyor, Edep Mektebi, İletişim Nezaket ve Adap</td>
                                        <td class="text-end fw-bold">670.571</td>
                                    </tr>
                                    <tr>
                                        <td><strong>7. Yarışma</strong> (2019)</td>
                                        <td><span class="badge bg-secondary">Güzel Ahlak</span></td>
                                        <td>Güzel Ahlak Yolculuğu, Erdemler Kampı, İhyau Ulumi\'d-Din\'den Kesitler</td>
                                        <td class="text-end fw-bold">537.289</td>
                                    </tr>
                                    <tr>
                                        <td><strong>6. Yarışma</strong> (2018)</td>
                                        <td><span class="badge bg-secondary">Sünnet-i Seniyye</span></td>
                                        <td>Sırlı Anahtarların Peşinde, Kandela İkinci Uyanış, Sünnet Olmadan Ümmet Olmaz</td>
                                        <td class="text-end fw-bold">669.306</td>
                                    </tr>
                                    <tr>
                                        <td><strong>5. Yarışma</strong> (2017)</td>
                                        <td><span class="badge bg-secondary">Kur\'an-ı Kerim Meali</span></td>
                                        <td>Kur\'an-ı Kerim Meali (Feyzü\'l-Furkan)</td>
                                        <td class="text-end fw-bold">595.372</td>
                                    </tr>
                                    <tr>
                                        <td><strong>4. Yarışma</strong> (2016)</td>
                                        <td><span class="badge bg-secondary">Hadis-i Şerif</span></td>
                                        <td>Riyazü\'s-Salihin\'den 1001 Hadis Seçkisi</td>
                                        <td class="text-end fw-bold">369.712</td>
                                    </tr>
                                    <tr>
                                        <td><strong>3. Yarışma</strong> (2015)</td>
                                        <td><span class="badge bg-secondary">Siyer-i Nebi</span></td>
                                        <td>Kur\'an-ı Kerim\'e Göre Peygamberler ve Tevhid Mücadelesi</td>
                                        <td class="text-end fw-bold">265.397</td>
                                    </tr>
                                    <tr>
                                        <td><strong>2. Yarışma</strong> (2014)</td>
                                        <td><span class="badge bg-secondary">Kur\'an-ı Kerim Meali</span></td>
                                        <td>Kur\'an-ı Kerim ve Açıklamalı Meali</td>
                                        <td class="text-end fw-bold">174.451</td>
                                    </tr>
                                    <tr>
                                        <td><strong>1. Yarışma</strong> (2013)</td>
                                        <td><span class="badge bg-secondary">İlmihal</span></td>
                                        <td>Büyük İslam İlmihali (Ömer Nasuhi Bilmen)</td>
                                        <td class="text-end fw-bold">89.870</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>'
                ];

            case 'sinav-kurallari':
                return [
                    'title' => 'Sınav Kuralları ve Değerlendirme Yönergesi',
                    'type' => 'corporate',
                    'category_title' => 'Bilgi Merkezi',
                    'description' => 'Online sınav aşamaları, süreler, soru adetleri ve sınav güvenliği kuralları.',
                    'body' => '
                        <div class="mb-4">
                            <h4 class="fw-bold text-dark mb-3">1. Sınav Uygulama Esasları</h4>
                            <p>Ufka Yolculuk Bilgi ve Kültür Yarışması sınavları belirlenen tarihlerde internet üzerinden (online) merkezi sistem aracılığıyla gerçekleştirilir.</p>
                            <ul class="d-flex flex-column gap-2">
                                <li><strong>Sınav Girişi:</strong> Yarışmacılar, kayıt esnasında belirledikleri T.C. Kimlik Numarası / Yarışmacı No ve şifreleri ile sisteme giriş yapar.</li>
                                <li><strong>Cihaz Uyumluluğu:</strong> Sınava bilgisayar, tablet veya akıllı telefon üzerinden güncel bir internet tarayıcısı (Chrome, Firefox, Safari vb.) ile girilebilir.</li>
                                <li><strong>Zamanlama:</strong> Sınav başladıktan sonra süre durdurulamaz. İnternet kesintisi durumunda sınav süresi işlemeye devam eder.</li>
                            </ul>
                        </div>
                        <div class="mb-4">
                            <h4 class="fw-bold text-dark mb-3">2. Puanlama ve Değerlendirme</h4>
                            <p>Her kategorinin soru sayısı ve sınav süresi şartnamede belirtildiği şekildedir. Yanlış cevapların doğru cevaplara etkisi şartnamede yer alan orana göre hesaplanır.</p>
                        </div>
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="fw-bold text-dark">📌 Destek:</span> Sınav anında yaşanabilecek teknik aksaklıklar için Çağrı Merkezimiz <strong>444 83 17</strong> üzerinden kesintisiz destek sağlayacaktır.
                        </div>'
                ];

            case 'materyaller':
                return [
                    'title' => 'Yarışma Materyalleri ve Tanıtım Dosyaları',
                    'type' => 'corporate',
                    'category_title' => 'Bilgi Merkezi',
                    'description' => 'Afişler, tanıtım sunumları, veli izin dilekçesi, MEB resmi onay yazısı ve kılavuzlar.',
                    'body' => '
                        <p class="lead">Yarışmacı, takım liderleri, öğretmenler ve il temsilcilerimizin tanıtım ve duyuru çalışmalarında kullanabileceği resmi evrak ve tanıtım materyalleri aşağıdadır:</p>
                        <div class="list-group list-group-flush border rounded-3 mt-3">
                            <div class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <div>
                                    <div class="fw-bold text-dark">📄 MEB Resmi Onay Yazısı (PDF)</div>
                                    <div class="small text-muted">Milli Eğitim Bakanlığı Sosyal Etkinlikler İzin Belgesi</div>
                                </div>
                                <a href="' . base_url('sayfa/resmi-onaylar') . '" class="btn btn-sm btn-outline-primary">İncele</a>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <div>
                                    <div class="fw-bold text-dark">📝 Veli İzin Belgesi (Dilekçe Örneği)</div>
                                    <div class="small text-muted">18 yaşından küçük yarışmacılar için resmi veli onay formu</div>
                                </div>
                                <a href="' . base_url('sayfa/UY-Veli-izin-Belgesi') . '" class="btn btn-sm btn-outline-primary">İndir / Görüntüle</a>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <div>
                                    <div class="fw-bold text-dark">🎨 14. Ufka Yolculuk Tanıtım Afişleri (Baskı Paketi)</div>
                                    <div class="small text-muted">Okul panoları, stantlar ve sınıf duyuruları için yüksek çözünürlüklü afişler</div>
                                </div>
                                <a href="' . base_url('assets/images/logo.png') . '" target="_blank" class="btn btn-sm btn-outline-secondary">Görüntüle</a>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center p-3">
                                <div>
                                    <div class="fw-bold text-dark">👥 Takım Lideri Rehberi & Kılavuzu</div>
                                    <div class="small text-muted">Öğrenci gruplarına rehberlik eden liderler için adım adım kılavuz</div>
                                </div>
                                <a href="' . base_url('takim-lideri') . '" class="btn btn-sm btn-outline-primary">Liderlik Paneli</a>
                            </div>
                        </div>'
                ];

            case 'kitap-temin-noktalari':
                return [
                    'title' => 'Kitap Temin Noktaları ve Satış Kanalları',
                    'type' => 'corporate',
                    'category_title' => 'Yarışma Bilgisi',
                    'description' => 'Yarışma kitaplarının güvenle sipariş edilebileceği resmi kitabevleri, il temsilcilikleri ve online satış kanalları.',
                    'body' => '
                        <p class="lead">Ufka Yolculuk yarışma kitaplarını 81 ildeki temsilciliklerimizden, anlaşmalı kitabevlerinden veya yetkili online mağazalardan temin edebilirsiniz.</p>
                        <div class="row g-4 mt-2">
                            <div class="col-md-6">
                                <div class="p-4 bg-light rounded-3 border h-100">
                                    <h5 class="fw-bold text-dark mb-3">🛒 Yetkili Online Satış Mağazaları</h5>
                                    <p class="small text-muted">Yarışma kitaplarını indirimli ve hızlı kargo avantajıyla internet üzerinden sipariş verebilirsiniz:</p>
                                    <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                                        <li><a href="https://www.serveryayinlari.com" target="_blank" rel="noopener" class="fw-semibold text-primary">🌐 Server Yayınları Resmi E-Ticaret Sitesi ↗</a></li>
                                        <li><a href="https://www.kitapyurdu.com" target="_blank" rel="noopener" class="fw-semibold text-primary">🌐 Kitapyurdu Ufka Yolculuk Kitapları ↗</a></li>
                                        <li><a href="https://www.bkmkitap.com" target="_blank" rel="noopener" class="fw-semibold text-primary">🌐 BKM Kitap Satış Sayfası ↗</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-4 bg-light rounded-3 border h-100">
                                    <h5 class="fw-bold text-dark mb-3">📍 İl & İlçe Temsilcilikleri</h5>
                                    <p class="small text-muted">Kendi şehrinizdeki Ufka Yolculuk il temsilciliği veya gönüllü koordinasyon merkezlerinden doğrudan elden teslim alabilirsiniz:</p>
                                    <a href="' . base_url('iletisim#temsilciler') . '" class="btn btn-outline-dark btn-sm fw-semibold">
                                        İl Temsilcileri İletişim Bilgileri
                                    </a>
                                </div>
                            </div>
                        </div>'
                ];
        }

        return null;
    }
}
