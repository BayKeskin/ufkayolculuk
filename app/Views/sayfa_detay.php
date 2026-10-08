<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

  <!-- ==========================================
       BREADCRUMB & HERO BANNER
       ========================================== -->
  <section class="page-hero-banner">
    <div class="container">
      <?php if (!empty($content)): ?>
        <!-- Breadcrumb Navigasyon -->
        <nav class="breadcrumb-custom" aria-label="Sayfa Yolu">
          <a href="<?= base_url('/') ?>">Ana Sayfa</a>
          <span class="separator">/</span>
          <?php if (($pageType ?? 'corporate') === 'announcement'): ?>
            <a href="<?= base_url('duyurular') ?>">Duyurular & Haberler</a>
          <?php else: ?>
            <a href="<?= base_url('sayfa-detay') ?>">Kurumsal & Kılavuzlar</a>
          <?php endif; ?>
          <span class="separator">/</span>
          <span class="current"><?= esc(mb_strlen($content['title'] ?? '') > 45 ? mb_substr($content['title'], 0, 45) . '...' : ($content['title'] ?? 'Detay')) ?></span>
        </nav>

        <!-- Sayfa Başlığı ve Kısa Özet -->
        <h1 class="page-hero-title"><?= esc($content['title'] ?? 'Sayfa Detayı') ?></h1>
        <div class="d-flex flex-wrap align-items-center gap-3 mt-2 text-white-50 small">
          <?php if (!empty($content['publish_time'])): ?>
            <span>📅 <?= date('d.m.Y', strtotime($content['publish_time'])) ?></span>
            <span>•</span>
          <?php endif; ?>
          <span>🏷️ <?= esc($content['category_title'] ?? $content['primary_category']['title'] ?? (($pageType ?? '') === 'announcement' ? 'Duyuru & Haber' : 'Resmi Belge & Bilgilendirme')) ?></span>
        </div>
      <?php else: ?>
        <!-- Breadcrumb Navigasyon (Hakkımızda veya Genel) -->
        <nav class="breadcrumb-custom" aria-label="Sayfa Yolu">
          <a href="<?= base_url('/') ?>">Ana Sayfa</a>
          <span class="separator">/</span>
          <a href="<?= base_url('sayfa-detay') ?>">Yarışma Hakkında</a>
          <span class="separator">/</span>
          <span class="current"><?= esc($title ?? 'Hakkımızda') ?></span>
        </nav>

        <!-- Sayfa Başlığı ve Kısa Özet -->
        <h1 class="page-hero-title"><?= esc($title ?? 'Hakkımızda & Misyonumuz') ?></h1>
      <?php endif; ?>
    </div>
  </section>

  <!-- ==========================================
       ANA SAYFA İÇERİK DÜZENİ (2 Kolon)
       ========================================== -->
  <section class="page-detail-section">
    <div class="container">
      <div class="row g-4">
        
        <!-- ========================================
             SOL / ANA İÇERİK ALANI (col-lg-9)
             ======================================== -->
        <div class="col-lg-9">
          <article class="page-detail-card">
            
            <div class="rich-content">
              <?php if (!empty($content)): ?>
                <?php 
                  $rawImage = $content['image'] ?? $content['primary_category']['image'] ?? null;
                  if ($rawImage):
                ?>
                  <div class="article-banner mb-4 rounded-3 overflow-hidden shadow-xs">
                    <img src="<?= esc($api->getMediaUrl($rawImage)) ?>" alt="<?= esc($content['title'] ?? '') ?>" class="w-100 img-fluid rounded-3" style="max-height: 480px; object-fit: cover;" onerror="this.style.display='none'">
                  </div>
                <?php endif; ?>

                <?php if (!empty($content['description'])): ?>
                  <div class="lead fw-semibold text-dark mb-4 p-3 bg-light rounded-3 border-start border-4 border-warning">
                    <?= esc($content['description']) ?>
                  </div>
                <?php endif; ?>

                <div class="article-body-text">
                  <?= $content['body'] ?? '' ?>
                </div>

              <?php elseif ($slug !== 'hakkimizda'): ?>
                <div class="text-center py-5">
                  <div class="display-3 text-warning mb-3">📄</div>
                  <h2 class="fw-bold text-dark">İçerik Bulunamadı</h2>
                  <p class="text-muted lead mx-auto" style="max-width: 540px;">
                    Aradığınız kurumsal sayfa, resmi kılavuz veya duyuru sistemimizde mevcut değil ya da yayından kaldırılmış olabilir.
                  </p>
                  <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="<?= base_url('sayfa-detay') ?>" class="btn-yellow px-4 py-2 fw-semibold">Hakkımızda Sayfası</a>
                    <a href="<?= base_url('/') ?>" class="btn btn-outline-secondary px-4 py-2">Ana Sayfa</a>
                  </div>
                </div>

              <?php else: ?>
                <!-- Lead Giriş Paragrafı -->
                <p class="lead">
                  <strong>Ufka Yolculuk Bilgi ve Kültür Yarışmaları</strong>, Server Yaşam Vakfı bünyesinde organize edilen, her yaştan bireye kitap okuma alışkanlığı kazandırmayı ve onları sahih kaynaklarla buluşturmayı amaçlayan Türkiye'nin en kapsamlı sivil bilgi yarışması hareketidir.
                </p>

                <p>
                  12 yılı aşkın süredir her yıl farklı bir temada düzenlediğimiz yarışmalarımız ile ilkokul, ortaokul, lise ve yetişkin olmak üzere 4 temel kategoride milyonlarca gencimize ve yetişkinimize ulaşmanın gururunu yaşıyoruz. Amacımız yalnızca bir yarışma düzenlemek değil; okuma kültürünü yaygınlaştırarak eleştirel düşünebilen, değerlerine bağlı ve geleceğe umutla bakan nesiller yetiştirmektir.
                </p>

                <!-- Vurgu Kutusu (Info Callout) -->
                <div class="rich-callout-box info">
                  <div class="rich-callout-icon">💡</div>
                  <div>
                    <strong>Biliyor muydunuz?</strong>
                    <p class="mb-0 mt-1 small">
                      Ufka Yolculuk, bugüne kadar 81 ilde ve cezaevlerinde 4.5 milyondan fazla yarışmacının katılımıyla Türkiye'nin en büyük sivil toplum organizasyonlarından biri haline gelmiştir.
                    </p>
                  </div>
                </div>

                <!-- H2 Başlık -->
                <h2>Biz Kimiz ve Neyi Hedefliyoruz?</h2>
                
                <p>
                  Toplumların gelişiminde ve medeniyetlerin inşasında en temel unsur 'insan' ve insanın edindiği 'doğru bilgi'dir. Dijital çağın getirdiği bilgi kirliliği ve yüzeyselleşme karşısında, gençlerimizi nitelikli eserlerle buluşturmak en büyük gayemizdir.
                </p>

                <!-- Değerler ve Misyon 3'lü Grid -->
                <div class="values-grid">
                  <div class="value-card-box">
                    <div class="value-card-icon">
                      <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                      </svg>
                    </div>
                    <h4 class="value-card-title">Sahih Bilgi</h4>
                    <p class="value-card-desc">Kaynakları güvenilir, alanında uzman akademisyen ve yazarlar tarafından hazırlanan nitelikli kitaplar.</p>
                  </div>

                  <div class="value-card-box">
                    <div class="value-card-icon">
                      <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                      </svg>
                    </div>
                    <h4 class="value-card-title">Güzel Ahlak</h4>
                    <p class="value-card-desc">Bireysel ve toplumsal ahlakı merkeze alan, sevgi, saygı, adalet ve merhamet temelli değerler.</p>
                  </div>

                  <div class="value-card-box">
                    <div class="value-card-icon">
                      <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                    </div>
                    <h4 class="value-card-title">Kalıcı Kazanım</h4>
                    <p class="value-card-desc">Sadece yarışma günüyle sınırlı kalmayan, ömür boyu rehberlik edecek bilgi ve davranış alışkanlıkları.</p>
                  </div>
                </div>

                <!-- H2 Başlık -->
                <h2>Temel İlkelerimiz ve Yarışma Modelimiz</h2>
                <p>
                  Yarışmamız, tüm aşamalarında şeffaflık, eşitlik ve erişilebilirlik ilkeleri üzerine inşa edilmiştir:
                </p>

                <!-- Özel İkonlu Liste -->
                <ul>
                  <li><strong>Geniş Kapsam:</strong> 81 ilde, yüzlerce ilçede ve cezaevlerinde eş zamanlı uygulanabilirlik.</li>
                  <li><strong>Çok Aşamalı Sınav Sistemi:</strong> 1. Aşama Online Sınav ile herkesin evinden rahatça katılımı, 2. Aşama Final Sınavı ile derece belirleme.</li>
                  <li><strong>Pedagojik Uygunluk:</strong> Her yaş grubuna özel psikolog, pedagog ve eğitimciler tarafından denetlenen dil ve içerik yapısı.</li>
                  <li><strong>Zengin Ödül Havuzu:</strong> Umre, laptop, bisiklet, burs ve teknoloji hediye çekleri gibi teşvik edici büyük ödüller.</li>
                </ul>

                <!-- Alıntı (Blockquote) -->
                <blockquote>
                  "Kitap okumak, insanı zihnen ve kalben yücelten en asil yolculuktur. Biz bu yolculukta gençlerimize rehber olmaktan onur duyuyoruz."
                  <footer>— Ufka Yolculuk İcra Kurulu</footer>
                </blockquote>

                <!-- H2 Başlık -->
                <h2>Yıllara Göre Yarışma Temalarımız ve İstatistikler</h2>
                <p>
                  Ufka Yolculuk her dönem toplumun ihtiyaç duyduğu temel bir ahlak veya inanç konusunu gündeme taşımaktadır:
                </p>

                <!-- Responsive Veri Tablosu -->
                <div class="rich-table-wrapper">
                  <table class="rich-table">
                    <thead>
                      <tr>
                        <th>Dönem</th>
                        <th>Tema / Kitap Konusu</th>
                        <th>Kategori Sayısı</th>
                        <th>Toplam Katılımcı</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><strong>12. Yarışma (2026)</strong></td>
                        <td>İbadet Bilinci ve Günlük Hayatta Ahlak</td>
                        <td>4 Kategori</td>
                        <td><em>Başvurular Devam Ediyor</em></td>
                      </tr>
                      <tr>
                        <td>11. Yarışma (2025)</td>
                        <td>Ramazan ve Oruç Bilinci</td>
                        <td>4 Kategori</td>
                        <td>960.000+</td>
                      </tr>
                      <tr>
                        <td>10. Yarışma (2024)</td>
                        <td>Sağlıklı Yaşam ve Helal Beslenme</td>
                        <td>4 Kategori</td>
                        <td>850.000+</td>
                      </tr>
                      <tr>
                        <td>9. Yarışma (2023)</td>
                        <td>Doğru İnanç ve Güzel Düşünce</td>
                        <td>4 Kategori</td>
                        <td>780.000+</td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <!-- Başarı / Tebrik Kutusu (Success Callout) -->
                <div class="rich-callout-box success">
                  <div class="rich-callout-icon">🌟</div>
                  <div>
                    <strong>Siz de Bu Büyük Ailenin Bir Parçası Olun!</strong>
                    <p class="mb-0 mt-1 small">
                      12. Ufka Yolculuk yarışmasına tamamen ücretsiz olarak kaydolabilir, seviyenize uygun kitabı temin ederek büyük ödüller için yarışmaya başlayabilirsiniz.
                    </p>
                  </div>
                </div>
              <?php endif; ?>

            </div>

            <!-- Sayfa Altı Paylaşım Çubuğu -->
            <div class="article-share-bar">
              <div class="d-flex align-items-center gap-2">
                <span class="small fw-bold text-dark">Bu Sayfayı Paylaş:</span>
              </div>
              <div class="share-buttons-group">
                <a href="https://api.whatsapp.com/send?text=<?= urlencode(($title ?? 'Ufka Yolculuk') . ' ' . current_url()) ?>" target="_blank" rel="noopener" class="share-btn whatsapp" title="WhatsApp'ta Paylaş">
                  <span>💬 WhatsApp</span>
                </a>
                <a href="https://twitter.com/intent/tweet?text=<?= urlencode($title ?? 'Ufka Yolculuk') ?>&url=<?= urlencode(current_url()) ?>" target="_blank" rel="noopener" class="share-btn twitter" title="X'te Paylaş">
                  <span>𝕏 Twitter</span>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>" target="_blank" rel="noopener" class="share-btn facebook" title="Facebook'ta Paylaş">
                  <span>Facebook</span>
                </a>
                <a href="https://t.me/share/url?url=<?= urlencode(current_url()) ?>&text=<?= urlencode($title ?? 'Ufka Yolculuk') ?>" target="_blank" rel="noopener" class="share-btn telegram" style="background:#229ED9; color:#fff;" title="Telegram'da Paylaş">
                  <span>✈️ Telegram</span>
                </a>
                <button type="button" class="share-btn copy border-0" onclick="navigator.clipboard.writeText(window.location.href); alert('Sayfa bağlantısı panoya kopyalandı!');" title="Bağlantıyı Kopyala">
                  <span>🔗 Linki Kopyala</span>
                </button>
              </div>
            </div>

          </article>
        </div>

        <!-- ========================================
             SAĞ / YAN MENÜ & ETKİLEŞİM PANELİ (col-lg-3)
             ======================================== -->
        <div class="col-lg-3">
          <aside class="sidebar-sticky-wrapper">
            
            <!-- 1. Son Duyurular (API'den Canlı) -->
            <?php if (!empty($recentAnnouncements)): ?>
            <div class="sidebar-nav-card mb-4">
              <div class="sidebar-nav-header">
                <span>📢</span>
                <span>Son Duyurular</span>
              </div>
              <div class="p-3">
                <?php foreach ($recentAnnouncements as $rItem): 
                    $rTitle = $rItem['title'] ?? 'Duyuru';
                    $rSlug  = $rItem['slug'] ?? '';
                    $rRawImg = $rItem['image'] ?? $rItem['primary_category']['image'] ?? null;
                    $rThumbUrl = $rRawImg ? $api->getMediaUrl($rRawImg) : base_url('assets/images/duyuru-1.webp');
                    $rDate = !empty($rItem['publish_time']) ? date('d.m.Y', strtotime($rItem['publish_time'])) : 'Güncel';
                    $rUrl = base_url('sayfa/' . ($rSlug ?: $rItem['id']));
                ?>
                <a href="<?= esc($rUrl) ?>" class="d-flex align-items-center gap-2 py-2 border-bottom text-decoration-none text-dark hover-opacity">
                  <img src="<?= esc($rThumbUrl) ?>" alt="<?= esc($rTitle) ?>" width="44" height="44" class="rounded object-fit-cover flex-shrink-0" onerror="this.src='<?= base_url('assets/images/duyuru-1.webp') ?>'">
                  <div class="overflow-hidden">
                    <div class="small fw-semibold text-truncate" title="<?= esc($rTitle) ?>"><?= esc($rTitle) ?></div>
                    <span class="text-muted" style="font-size: 0.75rem;">📅 <?= esc($rDate) ?></span>
                  </div>
                </a>
                <?php endforeach; ?>
                <div class="mt-3 text-center">
                  <a href="<?= base_url('duyurular') ?>" class="small fw-bold text-warning text-decoration-none">
                    Tüm Duyuruları Gör →
                  </a>
                </div>
              </div>
            </div>
            <?php endif; ?>

            <!-- 2. Yan Menü Kartı: Kurumsal & Kılavuzlar -->
            <div class="sidebar-nav-card">
              <div class="sidebar-nav-header">
                <span>📑</span>
                <span>Kurumsal & Bilgiler</span>
              </div>
              <ul class="sidebar-nav-list">
                <?php foreach (($corporatePages ?? []) as $cpSlug => $cp): 
                    $isActive = ($slug === $cpSlug) || (empty($content) && $cpSlug === 'hakkimizda');
                ?>
                <li class="sidebar-nav-item">
                  <a href="<?= esc($cp['url']) ?>" class="sidebar-nav-link <?= $isActive ? 'active' : '' ?>">
                    <span><?= esc($cp['icon']) ?> <?= esc($cp['title']) ?></span>
                    <span class="arrow">›</span>
                  </a>
                </li>
                <?php endforeach; ?>
                <li class="sidebar-nav-item">
                  <a href="<?= base_url('/#takvim') ?>" class="sidebar-nav-link">
                    <span>📅 Yarışma Takvimi</span>
                    <span class="arrow">›</span>
                  </a>
                </li>
                <li class="sidebar-nav-item">
                  <a href="<?= base_url('oduller') ?>" class="sidebar-nav-link">
                    <span>🏆 Ödüller & Dereceler</span>
                    <span class="arrow">›</span>
                  </a>
                </li>
                <li class="sidebar-nav-item">
                  <a href="<?= base_url('sss') ?>" class="sidebar-nav-link">
                    <span>❓ Sıkça Sorulan Sorular (SSS)</span>
                    <span class="arrow">›</span>
                  </a>
                </li>
              </ul>
            </div>

            <!-- 3. Hızlı Başvuru CTA Kartı -->
            <div class="sidebar-cta-card">
              <span class="badge bg-warning text-dark fw-bold mb-2">12. YARIŞMA</span>
              <h3 class="fs-5 fw-bold text-white mb-2">Yarışmaya Şimdi Katıl!</h3>
              <p class="small text-white-50 mb-3">
                Kitaplarını oku, online sınava katıl, binlerce liralık ödülleri kazanma şansı yakala.
              </p>
              <a href="<?= base_url('kayit-ol') ?>" class="btn-yellow w-100 justify-content-center fw-bold py-2 border-0 text-decoration-none">
                <span>Ücretsiz Kayıt Ol</span>
                <span>→</span>
              </a>
            </div>

            <!-- 4. Destek & İletişim Kutusu (WhatsApp Icon) -->
            <div class="sidebar-support-card">
              <div class="d-flex align-items-center gap-3 mb-2">
                <div class="modal-icon-badge" style="background: rgba(37, 211, 102, 0.15); color: #25D366;">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="#25D366">
                    <path d="M12.031 2C6.496 2 2 6.496 2 12.031c0 1.768.461 3.492 1.336 5.008L2 22l5.102-1.313a10.007 10.007 0 0 0 4.929 1.282h.004c5.531 0 10.027-4.496 10.027-10.031A10.02 10.02 0 0 0 12.031 2zm0 18.36a8.337 8.337 0 0 1-4.25-1.164l-.305-.181-3.158.813.843-3.078-.198-.315a8.318 8.318 0 0 1-1.274-4.404c0-4.606 3.748-8.354 8.354-8.354a8.305 8.305 0 0 1 5.908 2.451 8.307 8.307 0 0 1 2.446 5.903c0 4.606-3.748 8.354-8.354 8.354zm4.578-6.242c-.251-.126-1.485-.733-1.716-.816-.23-.084-.398-.126-.565.126-.168.251-.649.816-.795.983-.147.168-.293.189-.544.063a6.896 6.896 0 0 1-2.02-1.246 7.618 7.618 0 0 1-1.398-1.741c-.147-.251-.016-.387.11-.512.113-.113.251-.293.377-.44.126-.147.168-.251.251-.418.084-.168.042-.314-.021-.44-.063-.126-.565-1.36-.774-1.863-.204-.49-.41-.423-.565-.431l-.481-.008c-.168 0-.44.063-.67.314-.23.251-.879.858-.879 2.093s.9 2.428 1.025 2.595c.126.168 1.77 2.703 4.288 3.791.6.259 1.069.414 1.434.53.603.191 1.152.164 1.586.099.484-.072 1.485-.607 1.694-1.193.21-.586.21-1.089.147-1.193-.063-.105-.23-.168-.481-.293z"/>
                  </svg>
                </div>
                <div>
                  <h4 class="fs-6 fw-bold text-dark mb-0">Sorularınız mı Var?</h4>
                  <small class="text-muted">Danışma ve Destek Hattı</small>
                </div>
              </div>
              <p class="small text-muted mb-3">
                Yarışma şartları, kitap temini veya kayıt süreçleri hakkında bilgi almak için bize dilediğiniz zaman ulaşabilirsiniz.
              </p>
              <a href="https://wa.me/908508880088" target="_blank" rel="noopener" class="btn btn-outline-success btn-sm w-100 fw-bold rounded-2 d-flex align-items-center justify-content-center gap-2" style="border-color: #25D366; color: #128C7E;">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M12.031 2C6.496 2 2 6.496 2 12.031c0 1.768.461 3.492 1.336 5.008L2 22l5.102-1.313a10.007 10.007 0 0 0 4.929 1.282h.004c5.531 0 10.027-4.496 10.027-10.031A10.02 10.02 0 0 0 12.031 2zm0 18.36a8.337 8.337 0 0 1-4.25-1.164l-.305-.181-3.158.813.843-3.078-.198-.315a8.318 8.318 0 0 1-1.274-4.404c0-4.606 3.748-8.354 8.354-8.354a8.305 8.305 0 0 1 5.908 2.451 8.307 8.307 0 0 1 2.446 5.903c0 4.606-3.748 8.354-8.354 8.354zm4.578-6.242c-.251-.126-1.485-.733-1.716-.816-.23-.084-.398-.126-.565.126-.168.251-.649.816-.795.983-.147.168-.293.189-.544.063a6.896 6.896 0 0 1-2.02-1.246 7.618 7.618 0 0 1-1.398-1.741c-.147-.251-.016-.387.11-.512.113-.113.251-.293.377-.44.126-.147.168-.251.251-.418.084-.168.042-.314-.021-.44-.063-.126-.565-1.36-.774-1.863-.204-.49-.41-.423-.565-.431l-.481-.008c-.168 0-.44.063-.67.314-.23.251-.879.858-.879 2.093s.9 2.428 1.025 2.595c.126.168 1.77 2.703 4.288 3.791.6.259 1.069.414 1.434.53.603.191 1.152.164 1.586.099.484-.072 1.485-.607 1.694-1.193.21-.586.21-1.089.147-1.193-.063-.105-.23-.168-.481-.293z"/>
                </svg>
                <span>WhatsApp ile Ulaşın</span>
              </a>
            </div>

          </aside>
        </div>

      </div>
    </div>
  </section>

  <!-- ==========================================
       FLOATING AI DESTEK ROBOTU
       ========================================== -->
  <aside class="floating-ai-widget" id="ufyoChatTrigger" aria-label="Ufyo AI Destek Asistanı">
    <div class="floating-ai-bubble" id="ufyoBubble">
      Sorularını<br>sorabilirsin!
    </div>
    <img src="<?= base_url('assets/') ?>images/icon6.png" alt="AI Destek Robotu" class="bot-mascot-img" width="76" height="76">
  </aside>

  <!-- Ufyo AI Canlı Sohbet Penceresi -->
  <div class="ufyo-chat-panel" id="ufyoChatPanel" role="dialog" aria-labelledby="ufyoChatTitle" aria-hidden="true">
    <div class="ufyo-chat-header">
      <div class="d-flex align-items-center gap-2">
        <div class="ufyo-avatar-ring">
          <img src="<?= base_url('assets/') ?>images/icon6.png" alt="Ufyo" width="34" height="34">
          <span class="ufyo-status-dot"></span>
        </div>
        <div>
          <h5 class="ufyo-title mb-0" id="ufyoChatTitle">Ufyo AI Asistan</h5>
          <span class="ufyo-subtitle">Yapay Zeka Destek Sistemi</span>
        </div>
      </div>
      <button type="button" class="btn-ufyo-minimize" id="ufyoMinimizeBtn" title="Kapat" aria-label="Kapat">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>

    <div class="ufyo-chat-body" id="ufyoChatBody">
      <div class="chat-msg bot-msg">
        <div class="chat-msg-avatar">
          <img src="<?= base_url('assets/') ?>images/icon6.png" alt="Ufyo">
        </div>
        <div class="chat-msg-content">
          <p class="mb-1">Merhaba! Ben Ufka Yolculuk yapay zeka rehberiniz <strong>Ufyo</strong> 🤖</p>
          <p class="mb-0">Yarışma şartnamesi, başvuru koşulları, kitaplar veya sınav takvimi hakkında merak ettiğiniz tüm soruları yanıtlayabilirim.</p>
        </div>
      </div>

      <div class="ufyo-quick-chips" id="ufyoQuickChips">
        <span class="chips-title">Örnek Sorular:</span>
        <div class="d-flex flex-wrap gap-1 mt-1">
          <button type="button" class="ufyo-chip-btn" data-question="Sınav tarihi ve yarışma takvimi ne zaman?">📅 Sınav Ne Zaman?</button>
          <button type="button" class="ufyo-chip-btn" data-question="Kategorime ait yarışma kitabını nasıl temin ederim?">📚 Kitap Temini</button>
          <button type="button" class="ufyo-chip-btn" data-question="Yarışmada hangi ödüller verilecek?">🏆 Ödüller Nelerdir?</button>
          <button type="button" class="ufyo-chip-btn" data-question="Oyunlar ve Online Soru Çöz sistemine nasıl ulaşırım?">🎯 Oyun & Soru Portalı</button>
        </div>
      </div>
    </div>

    <div class="ufyo-chat-footer">
      <form id="ufyoChatForm" class="d-flex align-items-center gap-2 m-0">
        <input type="text" class="ufyo-input" id="ufyoInput" placeholder="Ufyo'ya bir soru sorun..." autocomplete="off" required>
        <button type="submit" class="btn-ufyo-send" id="ufyoSendBtn" aria-label="Mesaj Gönder">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor">
            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
          </svg>
        </button>
      </form>
    </div>
  </div>

<?= $this->endSection() ?>
