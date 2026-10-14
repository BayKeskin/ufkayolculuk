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
                    'title' => 'Geçmiş Yıllar - 13 Yıllık Ufka Yolculuk Arşivi',
                    'type' => 'corporate',
                    'category_title' => 'Tarihçe & Arşiv',
                    'description' => '2013\'ten 2026\'ya kadar 1. - 13. Yarışmaların tamamının konu, slogan, kitap ve kayıt sayıları ile 6.622.447 yarışmacılık köklü tarihçesi.',
                    'body' => '
                        <!-- Toplam İstatistik Paneli (6.622.447 Yarışmacı) -->
                        <div class="card border-0 shadow-sm rounded-4 mb-4 text-white overflow-hidden" style="background: linear-gradient(135deg, #0B2B6F 0%, #1D4ED8 100%);">
                            <div class="card-body p-4 p-md-5">
                                <div class="row align-items-center g-4">
                                    <div class="col-lg-8">
                                        <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill bg-white bg-opacity-20 text-warning small fw-bold mb-3">
                                            <span>🏆</span>
                                            <span>13 YILLIK KESİNTİSİZ SERÜVEN</span>
                                        </div>
                                        <h2 class="display-6 fw-bold mb-2 text-white">Toplam 6.622.447 Yarışmacı</h2>
                                        <p class="lead mb-0 text-white-50" style="font-size: 1.05rem;">
                                            2013 yılından bu yana her yıl farklı bir tema ile 81 ilde ve dünyada milyonlarca okuyucuyu sahih bilgi, güzel ahlak ve erdemle buluşturduk.
                                        </p>
                                    </div>
                                    <div class="col-lg-4 text-lg-end">
                                        <div class="d-flex flex-column flex-sm-row flex-lg-column gap-2 justify-content-lg-end">
                                            <div class="bg-white bg-opacity-10 rounded-3 p-3 text-center text-lg-end">
                                                <div class="fs-4 fw-bold text-warning">13 Dönem</div>
                                                <div class="small text-white-50">Tamamlanan Yarışma</div>
                                            </div>
                                            <div class="bg-white bg-opacity-10 rounded-3 p-3 text-center text-lg-end">
                                                <div class="fs-4 fw-bold text-warning">2013 - 2026</div>
                                                <div class="small text-white-50">Köklü Yolculuk</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Görünüm Seçici Sekmeler (Kart vs Liste) -->
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4 pb-2 border-bottom">
                            <div>
                                <h4 class="fw-bold text-dark mb-1">Dönemlere Göre Yarışma Arşivi</h4>
                                <p class="text-muted small mb-0">Detayları incelemek için ilgili yarışma kartına tıklayınız.</p>
                            </div>
                            <div class="nav nav-pills" id="historyViewPills" role="tablist">
                                <button class="nav-link active btn-sm py-1 px-3 fw-bold rounded-pill" id="view-cards-tab" data-bs-toggle="pill" data-bs-target="#view-cards" type="button" role="tab">🗂️ Kart Görünümü</button>
                                <button class="nav-link btn-sm py-1 px-3 fw-bold rounded-pill" id="view-table-tab" data-bs-toggle="pill" data-bs-target="#view-table" type="button" role="tab">📋 Tablo Görünümü</button>
                            </div>
                        </div>

                        <div class="tab-content" id="historyTabContent">
                            <!-- KART / AKORDİYON GÖRÜNÜMÜ -->
                            <div class="tab-pane fade show active" id="view-cards" role="tabpanel">
                                <div class="accordion accordion-flush d-flex flex-column gap-3" id="historyAccordion">

                                    <!-- 13. Yarışma (2026) -->
                                    <div class="accordion-item border rounded-3 overflow-hidden shadow-xs">
                                        <h2 class="accordion-header" id="heading13">
                                            <button class="accordion-button fw-bold py-3 px-4 d-flex align-items-center gap-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse13" aria-expanded="true" aria-controls="collapse13">
                                                <span class="badge bg-primary px-3 py-2 rounded-pill fs-6">13. Yarışma (2026)</span>
                                                <span class="fs-6 text-dark flex-grow-1">Konu: <strong>Nasıl İnanmalı?</strong></span>
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-1">824.878 Yarışmacı</span>
                                            </button>
                                        </h2>
                                        <div id="collapse13" class="accordion-collapse collapse show" aria-labelledby="heading13" data-bs-parent="#historyAccordion">
                                            <div class="accordion-body p-4 bg-white">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">📢 Slogan</div>
                                                            <div class="fs-6 fw-bold text-primary">"İlk Sözleşmeni Hatırla!"</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">👥 Katılım</div>
                                                            <div class="fs-6 fw-bold text-dark">824.878 Kayıtlı Yarışmacı</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-3 border rounded-3 bg-white">
                                                            <div class="text-muted small fw-bold text-uppercase mb-2">📚 Yarışma Kitapları</div>
                                                            <ul class="mb-0 ps-3 text-secondary">
                                                                <li><strong>İlkokul:</strong> Kuşların Çağrısı</li>
                                                                <li><strong>Ortaokul:</strong> Tevhid Muhafızları</li>
                                                                <li><strong>Lise:</strong> Gördüğüme Görmediğime</li>
                                                                <li><strong>Yetişkin & Üniversite:</strong> Nasıl İnanmalı?</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 12. Yarışma (2025) -->
                                    <div class="accordion-item border rounded-3 overflow-hidden shadow-xs">
                                        <h2 class="accordion-header" id="heading12">
                                            <button class="accordion-button collapsed fw-bold py-3 px-4 d-flex align-items-center gap-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse12">
                                                <span class="badge bg-secondary px-3 py-2 rounded-pill fs-6">12. Yarışma (2025)</span>
                                                <span class="fs-6 text-dark flex-grow-1">Konu: <strong>Hacı Bektaş-ı Veli (Hak & Adalet)</strong></span>
                                                <span class="badge bg-light text-dark border px-3 py-1">595.601 Yarışmacı</span>
                                            </button>
                                        </h2>
                                        <div id="collapse12" class="accordion-collapse collapse" aria-labelledby="heading12" data-bs-parent="#historyAccordion">
                                            <div class="accordion-body p-4 bg-white">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">📢 Slogan</div>
                                                            <div class="fs-6 fw-bold text-primary">"İncinsen De İncitme"</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">👥 Katılım</div>
                                                            <div class="fs-6 fw-bold text-dark">595.601 Kayıtlı Yarışmacı</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-3 border rounded-3 bg-white">
                                                            <div class="text-muted small fw-bold text-uppercase mb-2">📚 Yarışma Kitapları</div>
                                                            <ul class="mb-0 ps-3 text-secondary">
                                                                <li><strong>İlkokul:</strong> Maske Düştü</li>
                                                                <li><strong>Ortaokul:</strong> Zamansızlar Mektebi Hak Muhafızları</li>
                                                                <li><strong>Lise:</strong> Yolların Kanunu</li>
                                                                <li><strong>Yetişkin:</strong> İncinsen de İncitme</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 11. Yarışma (2024) -->
                                    <div class="accordion-item border rounded-3 overflow-hidden shadow-xs">
                                        <h2 class="accordion-header" id="heading11">
                                            <button class="accordion-button collapsed fw-bold py-3 px-4 d-flex align-items-center gap-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11">
                                                <span class="badge bg-secondary px-3 py-2 rounded-pill fs-6">11. Yarışma (2024)</span>
                                                <span class="fs-6 text-dark flex-grow-1">Konu: <strong>Ramazan</strong></span>
                                                <span class="badge bg-light text-dark border px-3 py-1">550.000 Yarışmacı</span>
                                            </button>
                                        </h2>
                                        <div id="collapse11" class="accordion-collapse collapse" aria-labelledby="heading11" data-bs-parent="#historyAccordion">
                                            <div class="accordion-body p-4 bg-white">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">📢 Slogan</div>
                                                            <div class="fs-6 fw-bold text-primary">"Manevi Bahar Mevsimi"</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">👥 Katılım</div>
                                                            <div class="fs-6 fw-bold text-dark">550.000 Kayıtlı Yarışmacı</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-3 border rounded-3 bg-white">
                                                            <div class="text-muted small fw-bold text-uppercase mb-2">📚 Yarışma Kitapları</div>
                                                            <ul class="mb-0 ps-3 text-secondary">
                                                                <li>Eyvah! Ramazan Kayıp</li>
                                                                <li>Bir Başka Zaman Ramazan</li>
                                                                <li>1\'e 1000 Yok mu İsteyen</li>
                                                                <li>Manevi Bahar Mevsimi Ramazan</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 10. Yarışma (2022) -->
                                    <div class="accordion-item border rounded-3 overflow-hidden shadow-xs">
                                        <h2 class="accordion-header" id="heading10">
                                            <button class="accordion-button collapsed fw-bold py-3 px-4 d-flex align-items-center gap-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10">
                                                <span class="badge bg-secondary px-3 py-2 rounded-pill fs-6">10. Yarışma (2022)</span>
                                                <span class="fs-6 text-dark flex-grow-1">Konu: <strong>Sağlıklı Düşünmek</strong></span>
                                                <span class="badge bg-light text-dark border px-3 py-1">880.000 Yarışmacı</span>
                                            </button>
                                        </h2>
                                        <div id="collapse10" class="accordion-collapse collapse" aria-labelledby="heading10" data-bs-parent="#historyAccordion">
                                            <div class="accordion-body p-4 bg-white">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">📢 Slogan</div>
                                                            <div class="fs-6 fw-bold text-primary">"Bir De Sağlıklı Düşün"</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">👥 Katılım</div>
                                                            <div class="fs-6 fw-bold text-dark">880.000 Kayıtlı Yarışmacı</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-3 border rounded-3 bg-white">
                                                            <div class="text-muted small fw-bold text-uppercase mb-2">📚 Yarışma Kitapları</div>
                                                            <ul class="mb-0 ps-3 text-secondary">
                                                                <li>Elma Dersem Düşün</li>
                                                                <li>Eyvah! Ceviz Çatırdıyor</li>
                                                                <li>Düşün! Bir de Sağlıklı Düşün</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 9. Yarışma (2021) -->
                                    <div class="accordion-item border rounded-3 overflow-hidden shadow-xs">
                                        <h2 class="accordion-header" id="heading9">
                                            <button class="accordion-button collapsed fw-bold py-3 px-4 d-flex align-items-center gap-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9">
                                                <span class="badge bg-secondary px-3 py-2 rounded-pill fs-6">9. Yarışma (2021)</span>
                                                <span class="fs-6 text-dark flex-grow-1">Konu: <strong>Sağlıklı Yaşam</strong></span>
                                                <span class="badge bg-light text-dark border px-3 py-1">400.000 Yarışmacı</span>
                                            </button>
                                        </h2>
                                        <div id="collapse9" class="accordion-collapse collapse" aria-labelledby="heading9" data-bs-parent="#historyAccordion">
                                            <div class="accordion-body p-4 bg-white">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">📢 Slogan</div>
                                                            <div class="fs-6 fw-bold text-primary">"Oku, Seç, Harekete Geç"</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">👥 Katılım</div>
                                                            <div class="fs-6 fw-bold text-dark">400.000 Kayıtlı Yarışmacı</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-3 border rounded-3 bg-white">
                                                            <div class="text-muted small fw-bold text-uppercase mb-2">📚 Yarışma Kitapları</div>
                                                            <ul class="mb-0 ps-3 text-secondary">
                                                                <li>İçimdeki Dostlar</li>
                                                                <li>Hastasızhane</li>
                                                                <li>Sağlıklı Beslen Sağlıklı Yaşa</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 8. Yarışma (2020) -->
                                    <div class="accordion-item border rounded-3 overflow-hidden shadow-xs">
                                        <h2 class="accordion-header" id="heading8">
                                            <button class="accordion-button collapsed fw-bold py-3 px-4 d-flex align-items-center gap-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8">
                                                <span class="badge bg-secondary px-3 py-2 rounded-pill fs-6">8. Yarışma (2020)</span>
                                                <span class="fs-6 text-dark flex-grow-1">Konu: <strong>Edep & Nezaket (Adap)</strong></span>
                                                <span class="badge bg-light text-dark border px-3 py-1">670.571 Yarışmacı</span>
                                            </button>
                                        </h2>
                                        <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#historyAccordion">
                                            <div class="accordion-body p-4 bg-white">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">📢 Slogan</div>
                                                            <div class="fs-6 fw-bold text-primary">"Bize Okumak Yakışır"</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">👥 Katılım</div>
                                                            <div class="fs-6 fw-bold text-dark">670.571 Kayıtlı Yarışmacı</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-3 border rounded-3 bg-white">
                                                            <div class="text-muted small fw-bold text-uppercase mb-2">📚 Yarışma Kitapları</div>
                                                            <ul class="mb-0 ps-3 text-secondary">
                                                                <li>Rota Oluşturuluyor</li>
                                                                <li>Edep Mektebi</li>
                                                                <li>İletişim Nezaket ve Adap</li>
                                                                <li>Kur\'an-ı Kerim\'de Görgü Kuralları (Adab-ı Muaşeret)</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 7. Yarışma (2019) -->
                                    <div class="accordion-item border rounded-3 overflow-hidden shadow-xs">
                                        <h2 class="accordion-header" id="heading7">
                                            <button class="accordion-button collapsed fw-bold py-3 px-4 d-flex align-items-center gap-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7">
                                                <span class="badge bg-secondary px-3 py-2 rounded-pill fs-6">7. Yarışma (2019)</span>
                                                <span class="fs-6 text-dark flex-grow-1">Konu: <strong>Güzel Ahlak</strong></span>
                                                <span class="badge bg-light text-dark border px-3 py-1">537.289 Yarışmacı</span>
                                            </button>
                                        </h2>
                                        <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#historyAccordion">
                                            <div class="accordion-body p-4 bg-white">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">📢 Slogan</div>
                                                            <div class="fs-6 fw-bold text-primary">"İçindeki Güzelliği Paylaş"</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">👥 Katılım</div>
                                                            <div class="fs-6 fw-bold text-dark">537.289 Kayıtlı Yarışmacı</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-3 border rounded-3 bg-white">
                                                            <div class="text-muted small fw-bold text-uppercase mb-2">📚 Yarışma Kitapları</div>
                                                            <ul class="mb-0 ps-3 text-secondary">
                                                                <li>Güzel Ahlak Yolculuğu</li>
                                                                <li>Erdemler Kampı</li>
                                                                <li>İhyau Ulumi\'d-Din\'den Kesitlerle Güzel Ahlak</li>
                                                                <li>İhyau Ulumi\'d-Din\'den Kesitlerle Kalbin Ahlakı</li>
                                                                <li>Bidayetül Hidaye (Arp.)</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 6. Yarışma (2018) -->
                                    <div class="accordion-item border rounded-3 overflow-hidden shadow-xs">
                                        <h2 class="accordion-header" id="heading6">
                                            <button class="accordion-button collapsed fw-bold py-3 px-4 d-flex align-items-center gap-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6">
                                                <span class="badge bg-secondary px-3 py-2 rounded-pill fs-6">6. Yarışma (2018)</span>
                                                <span class="fs-6 text-dark flex-grow-1">Konu: <strong>Kur\'an ve Sünnet Bütünlüğü</strong></span>
                                                <span class="badge bg-light text-dark border px-3 py-1">669.306 Yarışmacı</span>
                                            </button>
                                        </h2>
                                        <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#historyAccordion">
                                            <div class="accordion-body p-4 bg-white">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">📢 Slogan</div>
                                                            <div class="fs-6 fw-bold text-primary">"Sünnet Olmadan Ümmet Olmaz"</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">👥 Katılım</div>
                                                            <div class="fs-6 fw-bold text-dark">669.306 Kayıtlı Yarışmacı</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-3 border rounded-3 bg-white">
                                                            <div class="text-muted small fw-bold text-uppercase mb-2">📚 Yarışma Kitapları</div>
                                                            <ul class="mb-0 ps-3 text-secondary">
                                                                <li>Sırlı Anahtarların Peşinde</li>
                                                                <li>Kandela İkinci Uyanış</li>
                                                                <li>Sünnet Olmadan Ümmet Olmaz</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 5. Yarışma (2017) -->
                                    <div class="accordion-item border rounded-3 overflow-hidden shadow-xs">
                                        <h2 class="accordion-header" id="heading5">
                                            <button class="accordion-button collapsed fw-bold py-3 px-4 d-flex align-items-center gap-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5">
                                                <span class="badge bg-secondary px-3 py-2 rounded-pill fs-6">5. Yarışma (2017)</span>
                                                <span class="fs-6 text-dark flex-grow-1">Konu: <strong>Kur\'an-ı Kerim Meali</strong></span>
                                                <span class="badge bg-light text-dark border px-3 py-1">595.372 Yarışmacı</span>
                                            </button>
                                        </h2>
                                        <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#historyAccordion">
                                            <div class="accordion-body p-4 bg-white">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">📢 Slogan</div>
                                                            <div class="fs-6 fw-bold text-primary">"Yola Çıkmak İsteyene Yol Açık"</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">👥 Katılım</div>
                                                            <div class="fs-6 fw-bold text-dark">595.372 Kayıtlı Yarışmacı</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-3 border rounded-3 bg-white">
                                                            <div class="text-muted small fw-bold text-uppercase mb-2">📚 Yarışma Kitapları</div>
                                                            <ul class="mb-0 ps-3 text-secondary">
                                                                <li>Kur\'an-ı Kerim Meali (Feyzü\'l-Furkan)</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 4. Yarışma (2016) -->
                                    <div class="accordion-item border rounded-3 overflow-hidden shadow-xs">
                                        <h2 class="accordion-header" id="heading4">
                                            <button class="accordion-button collapsed fw-bold py-3 px-4 d-flex align-items-center gap-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                                <span class="badge bg-secondary px-3 py-2 rounded-pill fs-6">4. Yarışma (2016)</span>
                                                <span class="fs-6 text-dark flex-grow-1">Konu: <strong>Hadis-i Şerif</strong></span>
                                                <span class="badge bg-light text-dark border px-3 py-1">369.712 Yarışmacı</span>
                                            </button>
                                        </h2>
                                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="heading4" data-bs-parent="#historyAccordion">
                                            <div class="accordion-body p-4 bg-white">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">📢 Slogan</div>
                                                            <div class="fs-6 text-muted fst-italic">-</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">👥 Katılım</div>
                                                            <div class="fs-6 fw-bold text-dark">369.712 Kayıtlı Yarışmacı</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-3 border rounded-3 bg-white">
                                                            <div class="text-muted small fw-bold text-uppercase mb-2">📚 Yarışma Kitapları</div>
                                                            <ul class="mb-0 ps-3 text-secondary">
                                                                <li>Riyazü\'s-Salihin\'den 1001 Hadis Seçkisi</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 3. Yarışma (2015) -->
                                    <div class="accordion-item border rounded-3 overflow-hidden shadow-xs">
                                        <h2 class="accordion-header" id="heading3">
                                            <button class="accordion-button collapsed fw-bold py-3 px-4 d-flex align-items-center gap-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                                <span class="badge bg-secondary px-3 py-2 rounded-pill fs-6">3. Yarışma (2015)</span>
                                                <span class="fs-6 text-dark flex-grow-1">Konu: <strong>Siyer-i Nebi (İdeal İnsan Hz. Muhammed s.a.s.)</strong></span>
                                                <span class="badge bg-light text-dark border px-3 py-1">265.397 Yarışmacı</span>
                                            </button>
                                        </h2>
                                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="heading3" data-bs-parent="#historyAccordion">
                                            <div class="accordion-body p-4 bg-white">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">📢 Slogan</div>
                                                            <div class="fs-6 text-muted fst-italic">-</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">👥 Katılım</div>
                                                            <div class="fs-6 fw-bold text-dark">265.397 Kayıtlı Yarışmacı</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-3 border rounded-3 bg-white">
                                                            <div class="text-muted small fw-bold text-uppercase mb-2">📚 Yarışma Kitapları</div>
                                                            <ul class="mb-0 ps-3 text-secondary">
                                                                <li>Kur\'an-ı Kerim\'e Göre Peygamberler ve Tevhid Mücadelesi</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 2. Yarışma (2014) -->
                                    <div class="accordion-item border rounded-3 overflow-hidden shadow-xs">
                                        <h2 class="accordion-header" id="heading2">
                                            <button class="accordion-button collapsed fw-bold py-3 px-4 d-flex align-items-center gap-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                                <span class="badge bg-secondary px-3 py-2 rounded-pill fs-6">2. Yarışma (2014)</span>
                                                <span class="fs-6 text-dark flex-grow-1">Konu: <strong>Kur\'an-ı Kerim Meali</strong></span>
                                                <span class="badge bg-light text-dark border px-3 py-1">174.451 Yarışmacı</span>
                                            </button>
                                        </h2>
                                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="heading2" data-bs-parent="#historyAccordion">
                                            <div class="accordion-body p-4 bg-white">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">📢 Slogan</div>
                                                            <div class="fs-6 text-muted fst-italic">-</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">👥 Katılım</div>
                                                            <div class="fs-6 fw-bold text-dark">174.451 Kayıtlı Yarışmacı</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-3 border rounded-3 bg-white">
                                                            <div class="text-muted small fw-bold text-uppercase mb-2">📚 Yarışma Kitapları</div>
                                                            <ul class="mb-0 ps-3 text-secondary">
                                                                <li>Kur\'an-ı Kerim ve Açıklamalı Meali</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 1. Yarışma (2013) -->
                                    <div class="accordion-item border rounded-3 overflow-hidden shadow-xs">
                                        <h2 class="accordion-header" id="heading1">
                                            <button class="accordion-button collapsed fw-bold py-3 px-4 d-flex align-items-center gap-3 bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                                <span class="badge bg-secondary px-3 py-2 rounded-pill fs-6">1. Yarışma (2013)</span>
                                                <span class="fs-6 text-dark flex-grow-1">Konu: <strong>İlmihal</strong></span>
                                                <span class="badge bg-light text-dark border px-3 py-1">89.870 Yarışmacı</span>
                                            </button>
                                        </h2>
                                        <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="heading1" data-bs-parent="#historyAccordion">
                                            <div class="accordion-body p-4 bg-white">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">📢 Slogan</div>
                                                            <div class="fs-6 text-muted fst-italic">-</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded-3 h-100">
                                                            <div class="text-muted small fw-bold text-uppercase mb-1">👥 Katılım</div>
                                                            <div class="fs-6 fw-bold text-dark">89.870 Kayıtlı Yarışmacı</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="p-3 border rounded-3 bg-white">
                                                            <div class="text-muted small fw-bold text-uppercase mb-2">📚 Yarışma Kitapları</div>
                                                            <ul class="mb-0 ps-3 text-secondary">
                                                                <li>Büyük İslam İlmihali (Ömer Nasuhi Bilmen)</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- TABLO GÖRÜNÜMÜ -->
                            <div class="tab-pane fade" id="view-table" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle border rounded-3 overflow-hidden">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 15%;">Dönem</th>
                                                <th style="width: 25%;">Tema / Konu</th>
                                                <th style="width: 20%;">Slogan</th>
                                                <th style="width: 25%;">Yarışma Kitapları</th>
                                                <th style="width: 15%;" class="text-end">Kayıt Sayısı</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="table-primary table-opacity-10">
                                                <td><strong>13. Yarışma</strong> (2026)</td>
                                                <td><span class="badge bg-primary">Nasıl İnanmalı?</span></td>
                                                <td><em>"İlk Sözleşmeni Hatırla!"</em></td>
                                                <td>Kuşların Çağrısı, Tevhid Muhafızları, Gördüğüme Görmediğime, Nasıl İnanmalı?</td>
                                                <td class="text-end fw-bold text-primary">824.878</td>
                                            </tr>
                                            <tr>
                                                <td><strong>12. Yarışma</strong> (2025)</td>
                                                <td><span class="badge bg-secondary">Hacı Bektaş-ı Veli</span></td>
                                                <td><em>"İncinsen De İncitme"</em></td>
                                                <td>Maske Düştü, Zamansızlar Mektebi Hak Muhafızları, Yolların Kanunu, İncinsen de İncitme</td>
                                                <td class="text-end fw-bold">595.601</td>
                                            </tr>
                                            <tr>
                                                <td><strong>11. Yarışma</strong> (2024)</td>
                                                <td><span class="badge bg-secondary">Ramazan</span></td>
                                                <td><em>"Manevi Bahar Mevsimi"</em></td>
                                                <td>Eyvah! Ramazan Kayıp, Bir Başka Zaman Ramazan, 1\'e 1000 Yok mu İsteyen</td>
                                                <td class="text-end fw-bold">550.000</td>
                                            </tr>
                                            <tr>
                                                <td><strong>10. Yarışma</strong> (2022)</td>
                                                <td><span class="badge bg-secondary">Sağlıklı Düşünmek</span></td>
                                                <td><em>"Bir De Sağlıklı Düşün"</em></td>
                                                <td>Elma Dersem Düşün, Eyvah! Ceviz Çatırdıyor, Düşün! Bir de Sağlıklı Düşün</td>
                                                <td class="text-end fw-bold">880.000</td>
                                            </tr>
                                            <tr>
                                                <td><strong>9. Yarışma</strong> (2021)</td>
                                                <td><span class="badge bg-secondary">Sağlıklı Yaşam</span></td>
                                                <td><em>"Oku, Seç, Harekete Geç"</em></td>
                                                <td>İçimdeki Dostlar, Hastasızhane, Sağlıklı Beslen Sağlıklı Yaşa</td>
                                                <td class="text-end fw-bold">400.000</td>
                                            </tr>
                                            <tr>
                                                <td><strong>8. Yarışma</strong> (2020)</td>
                                                <td><span class="badge bg-secondary">Adap</span></td>
                                                <td><em>"Bize Okumak Yakışır"</em></td>
                                                <td>Rota Oluşturuluyor, Edep Mektebi, İletişim Nezaket ve Adap, Adab-ı Muaşeret</td>
                                                <td class="text-end fw-bold">670.571</td>
                                            </tr>
                                            <tr>
                                                <td><strong>7. Yarışma</strong> (2019)</td>
                                                <td><span class="badge bg-secondary">Güzel Ahlak</span></td>
                                                <td><em>"İçindeki Güzelliği Paylaş"</em></td>
                                                <td>Güzel Ahlak Yolculuğu, Erdemler Kampı, İhyau Ulumi\'d-Din Kesitleri</td>
                                                <td class="text-end fw-bold">537.289</td>
                                            </tr>
                                            <tr>
                                                <td><strong>6. Yarışma</strong> (2018)</td>
                                                <td><span class="badge bg-secondary">Kur\'an ve Sünnet</span></td>
                                                <td><em>"Sünnet Olmadan Ümmet Olmaz"</em></td>
                                                <td>Sırlı Anahtarların Peşinde, Kandela İkinci Uyanış</td>
                                                <td class="text-end fw-bold">669.306</td>
                                            </tr>
                                            <tr>
                                                <td><strong>5. Yarışma</strong> (2017)</td>
                                                <td><span class="badge bg-secondary">Kur\'an-ı Kerim Meali</span></td>
                                                <td><em>"Yola Çıkmak İsteyene Yol Açık"</em></td>
                                                <td>Kur\'an-ı Kerim Meali (Feyzü\'l-Furkan)</td>
                                                <td class="text-end fw-bold">595.372</td>
                                            </tr>
                                            <tr>
                                                <td><strong>4. Yarışma</strong> (2016)</td>
                                                <td><span class="badge bg-secondary">Hadis</span></td>
                                                <td>-</td>
                                                <td>Riyazü\'s-Salihin\'den 1001 Hadis Seçkisi</td>
                                                <td class="text-end fw-bold">369.712</td>
                                            </tr>
                                            <tr>
                                                <td><strong>3. Yarışma</strong> (2015)</td>
                                                <td><span class="badge bg-secondary">Siyer</span></td>
                                                <td>-</td>
                                                <td>Kur\'an-ı Kerim\'e Göre Peygamberler ve Tevhid Mücadelesi</td>
                                                <td class="text-end fw-bold">265.397</td>
                                            </tr>
                                            <tr>
                                                <td><strong>2. Yarışma</strong> (2014)</td>
                                                <td><span class="badge bg-secondary">Kur\'an-ı Kerim Meali</span></td>
                                                <td>-</td>
                                                <td>Kur\'an-ı Kerim ve Açıklamalı Meali</td>
                                                <td class="text-end fw-bold">174.451</td>
                                            </tr>
                                            <tr>
                                                <td><strong>1. Yarışma</strong> (2013)</td>
                                                <td><span class="badge bg-secondary">İlmihal</span></td>
                                                <td>-</td>
                                                <td>Büyük İslam İlmihali (Ömer Nasuhi Bilmen)</td>
                                                <td class="text-end fw-bold">89.870</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
