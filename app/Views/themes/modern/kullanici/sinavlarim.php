<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
  .profile-portal-wrap {
    background-color: #f8fafc;
    min-height: calc(100vh - 200px);
    padding: 2rem 0 4rem;
  }

  /* Portal Sub-Nav Tabs */
  .portal-nav-tabs {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    overflow-x: auto;
    padding-bottom: 0.5rem;
    margin-bottom: 2rem;
    border-bottom: 2px solid #e2e8f0;
  }

  .portal-nav-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.35rem;
    border-radius: 14px;
    font-weight: 700;
    font-size: 0.95rem;
    color: #64748b;
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
  }

  .portal-nav-link:hover {
    color: #1e293b;
    background: #e2e8f0;
  }

  .portal-nav-link.active {
    color: #2563eb;
    background: #eff6ff;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.12);
  }

  /* Portal User Header */
  .portal-header-card {
    background: #ffffff;
    border-radius: 24px;
    padding: 1.75rem 2rem;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
    border: 1px solid #e2e8f0;
    margin-bottom: 2rem;
  }

  .portal-avatar-lg {
    width: 64px;
    height: 64px;
    border-radius: 20px;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    font-weight: 800;
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
    flex-shrink: 0;
  }

  .portal-user-name {
    font-size: 2rem;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.5px;
    margin-bottom: 0.35rem;
    font-family: 'Outfit', sans-serif;
  }

  .portal-tag-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.3rem 0.8rem;
    border-radius: 50rem;
    font-size: 0.82rem;
    font-weight: 700;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
  }

  .portal-tag-pill.tag-primary {
    background: #eff6ff;
    color: #1d4ed8;
    border-color: #bfdbfe;
  }

  .portal-tag-pill.tag-success {
    background: #ecfdf5;
    color: #047857;
    border-color: #a7f3d0;
  }

  /* 3 Stat Cards */
  .portal-stat-card {
    background: #ffffff;
    border-radius: 22px;
    padding: 1.6rem 1.75rem;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
    border: 1px solid #e2e8f0;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    height: 100%;
    position: relative;
    overflow: hidden;
  }

  .portal-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08);
    border-color: #cbd5e1;
  }

  .portal-stat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.85rem;
  }

  .portal-stat-label {
    font-size: 0.82rem;
    font-weight: 800;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    color: #64748b;
  }

  .portal-stat-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
  }

  .stat-icon-purple { background: #f3e8ff; color: #9333ea; }
  .stat-icon-blue   { background: #e0f2fe; color: #0284c7; }
  .stat-icon-green  { background: #dcfce7; color: #16a34a; }

  .portal-stat-value {
    font-size: 2.35rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.1;
    font-family: 'Outfit', sans-serif;
    margin-bottom: 0.35rem;
  }

  .portal-stat-desc {
    font-size: 0.82rem;
    color: #94a3b8;
    font-weight: 600;
  }

  /* Role Cards */
  .portal-role-card {
    background: #ffffff;
    border-radius: 22px;
    padding: 1.5rem 1.75rem;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.25rem;
    height: 100%;
    transition: all 0.25s ease;
  }

  .portal-role-card:hover {
    box-shadow: 0 10px 25px rgba(15, 23, 42, 0.06);
    border-color: #cbd5e1;
  }

  .role-icon-box {
    width: 56px;
    height: 56px;
    border-radius: 18px;
    background: #f8fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .role-info-title {
    font-weight: 800;
    font-size: 1.2rem;
    color: #0f172a;
    margin-bottom: 0.2rem;
    font-family: 'Outfit', sans-serif;
  }

  .role-info-sub {
    font-size: 0.88rem;
    color: #64748b;
  }

  .role-active-badge {
    background: #ecfdf5;
    color: #059669;
    font-size: 0.78rem;
    font-weight: 800;
    letter-spacing: 0.5px;
    padding: 0.45rem 0.95rem;
    border-radius: 50rem;
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    text-transform: uppercase;
    border: 1px solid #a7f3d0;
  }

  .pulse-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #10b981;
    display: inline-block;
    box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    animation: pulse 1.8s infinite;
  }

  @keyframes pulse {
    0% {
      transform: scale(0.95);
      box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    }
    70% {
      transform: scale(1);
      box-shadow: 0 0 0 6px rgba(16, 185, 129, 0);
    }
    100% {
      transform: scale(0.95);
      box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
    }
  }

  /* Exam History Card */
  .portal-section-card {
    background: #ffffff;
    border-radius: 24px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
    border: 1px solid #e2e8f0;
    margin-top: 2rem;
  }

  .portal-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
  }

  .portal-section-title {
    display: flex;
    align-items: center;
    gap: 0.85rem;
    font-size: 1.35rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
    font-family: 'Outfit', sans-serif;
  }

  .portal-section-icon {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
  }

  .portal-count-pill {
    background: #f8fafc;
    color: #475569;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.5rem 1.1rem;
    border-radius: 50rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    border: 1px solid #e2e8f0;
  }

  .exam-table-custom {
    margin-bottom: 0;
  }

  .exam-table-custom thead th {
    background: #f8fafc;
    color: #64748b;
    font-size: 0.78rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    border-bottom: 1px solid #e2e8f0;
    padding: 1.15rem 1.25rem;
    white-space: nowrap;
  }

  .exam-table-custom tbody td {
    padding: 1.25rem 1.25rem;
    vertical-align: middle;
    font-size: 0.94rem;
    color: #1e293b;
    border-bottom: 1px solid #f1f5f9;
  }

  .exam-table-custom tbody tr:hover td {
    background-color: #f8fafc;
  }

  .exam-badge-score {
    background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
    color: #3730a3;
    font-weight: 800;
    padding: 0.45rem 0.95rem;
    border-radius: 12px;
    display: inline-block;
    border: 1px solid #c7d2fe;
    font-size: 1rem;
    font-family: 'Outfit', sans-serif;
  }

  @media (max-width: 767.98px) {
    .portal-user-name {
      font-size: 1.6rem;
    }
    .portal-header-card {
      padding: 1.25rem;
    }
    .portal-section-card {
      padding: 1.25rem;
    }
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="profile-portal-wrap">
  <div class="container">

    <!-- 1. Portal Üst Sekme Menüsü (SaaS Sub-Navigation) -->
    <nav class="portal-nav-tabs" aria-label="Kullanıcı Paneli Gezinimi">
      <a href="<?= base_url('sinavlarim') ?>" class="portal-nav-link active">
        <span>📝</span>
        <span>Sınavlarım & Sonuçlarım</span>
      </a>
      <a href="<?= base_url('sertifikalarim') ?>" class="portal-nav-link">
        <span>📜</span>
        <span>Sertifikalarım</span>
      </a>
      <a href="<?= base_url('takim-lideri') ?>" class="portal-nav-link">
        <span>👥</span>
        <span>Takım Lideri</span>
      </a>
      <a href="<?= base_url('vesile-olduklarim') ?>" class="portal-nav-link">
        <span>🔗</span>
        <span>Davet Et / Vesile Olduklarım</span>
      </a>
    </nav>

    <!-- 2. Kullanıcı Profil Bilgi Kartı -->
    <div class="portal-header-card">
      <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
          <div class="portal-avatar-lg">
            <?= mb_strtoupper(mb_substr($user['name'] ?? 'U', 0, 1)) ?>
          </div>
          <div>
            <h1 class="portal-user-name"><?= esc($user['name'] ?? 'ibrahim._. tekmen') ?></h1>
            <div class="d-flex align-items-center gap-2 flex-wrap">
              <span class="portal-tag-pill tag-primary">
                <span>🎓</span>
                <span><?= esc($user['category_title'] ?? 'Yetişkin Kategorisi') ?></span>
              </span>
              <?php if (!empty($user['city'])): ?>
                <span class="portal-tag-pill">
                  <span>📍</span>
                  <span><?= esc($user['city']) ?></span>
                </span>
              <?php endif; ?>
              <?php if (!empty($user['school'])): ?>
                <span class="portal-tag-pill">
                  <span>🏫</span>
                  <span><?= esc($user['school']) ?></span>
                </span>
              <?php endif; ?>
              <?php if (!empty($user['invite_code'])): ?>
                <span class="portal-tag-pill tag-success" title="Özel Davet Kodunuz">
                  <span>🎟️</span>
                  <span>Kod: <strong><?= esc($user['invite_code']) ?></strong></span>
                </span>
              <?php endif; ?>
            </div>
          </div>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
          <a href="<?= base_url('sertifikalarim') ?>" class="btn btn-outline-primary rounded-pill px-3 py-2 fw-semibold small">
            📜 Sertifikalarım
          </a>
          <a href="<?= base_url('vesile-olduklarim') ?>" class="btn btn-warning rounded-pill px-3 py-2 fw-semibold small text-dark">
            🔗 Davet Et & Kazan
          </a>
        </div>
      </div>
    </div>

    <!-- Sınav Durum / Bekleme Bildirimi (API'den Gelen) -->
    <?php if (!empty($user['status_message']) || ($user['result_status'] ?? '') === 'pending'): ?>
      <div class="alert alert-info border-0 rounded-4 shadow-sm d-flex align-items-center gap-3 mb-4 p-3 bg-opacity-75">
        <span class="fs-4">⏳</span>
        <div>
          <div class="fw-bold text-dark mb-0"><?= esc($user['status_message'] ?? 'Sınav tamamlandı, sonuçlar değerlendirme aşamasında.') ?></div>
          <?php if (!empty($user['total_participants_global'])): ?>
            <small class="text-muted">Türkiye Geneli Katılımcı Sayısı: <strong><?= number_format((int)$user['total_participants_global'], 0, ',', '.') ?></strong></small>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>

    <!-- 3. Satır: 3 Ana İstatistik Kartı -->
    <div class="row g-3 g-md-4 mb-4">
      <div class="col-12 col-md-4">
        <div class="portal-stat-card">
          <div class="portal-stat-header">
            <span class="portal-stat-label">GENEL PUAN</span>
            <div class="portal-stat-icon stat-icon-purple">🎯</div>
          </div>
          <div class="portal-stat-value"><?= esc($user['general_score'] ?? '3.27') ?></div>
          <div class="portal-stat-desc">100 üzerinden genel başarı puanı</div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="portal-stat-card">
          <div class="portal-stat-header">
            <span class="portal-stat-label">TÜRKİYE DERECESİ</span>
            <div class="portal-stat-icon stat-icon-blue">🏆</div>
          </div>
          <?php 
            $tRankVal = is_numeric($user['turkey_rank'] ?? null) 
              ? number_format((int)$user['turkey_rank'], 0, ',', '.') 
              : ($user['turkey_rank'] ?? '48.296');
          ?>
          <div class="portal-stat-value"><?= esc($tRankVal) ?></div>
          <div class="portal-stat-desc">Türkiye geneli resmi sıralama</div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="portal-stat-card">
          <div class="portal-stat-header">
            <span class="portal-stat-label">İL DERECESİ</span>
            <div class="portal-stat-icon stat-icon-green">📍</div>
          </div>
          <?php 
            $cRankVal = is_numeric($user['city_rank'] ?? null) 
              ? number_format((int)$user['city_rank'], 0, ',', '.') 
              : ($user['city_rank'] ?? '460');
          ?>
          <div class="portal-stat-value"><?= esc($cRankVal) ?></div>
          <div class="portal-stat-desc"><?= esc($user['city'] ?? 'İl') ?> geneli başarı sırası</div>
        </div>
      </div>
    </div>

    <!-- 4. Satır: 2 Rol & Statü Kartı (Simetrik 6 + 6 Grid) -->
    <div class="row g-3 g-md-4 mb-4">
      <!-- Yarışmacı Kartı -->
      <div class="col-12 col-md-6">
        <div class="portal-role-card">
          <div class="d-flex align-items-center gap-3">
            <div class="role-icon-box text-primary">
              <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <rect x="4" y="3" width="16" height="18" rx="2" stroke-width="2" />
                <circle cx="12" cy="9" r="3" stroke-width="2" />
                <path stroke-linecap="round" stroke-width="2" d="M8 17c0-2 2-3 4-3s4 1 4 3" />
              </svg>
            </div>
            <div>
              <div class="role-info-title">Yarışmacı Statüsü</div>
              <div class="role-info-sub"><?= esc($user['category_title'] ?? 'Yetişkin Kategorisi') ?></div>
            </div>
          </div>
          <span class="role-active-badge">
            <span class="pulse-dot"></span>
            <span>Aktif</span>
          </span>
        </div>
      </div>

      <!-- Takım Lideri Kartı -->
      <div class="col-12 col-md-6">
        <div class="portal-role-card">
          <div class="d-flex align-items-center gap-3">
            <div class="role-icon-box text-warning">
              <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
            <div>
              <div class="role-info-title">Takım Lideri</div>
              <div class="role-info-sub"><?= esc($user['leader_category'] ?? 'DİĞER Kategorisi') ?></div>
              <?php 
                $lScore = floatval($user['leader_score'] ?? 0);
              ?>
              <div class="role-info-sub text-muted">
                Puan: <strong class="text-dark"><?= number_format($lScore, 2, ',', '.') ?></strong>
                <span class="mx-1">•</span>
                Danışan: <strong class="text-dark"><?= (int)($user['total_students'] ?? 0) ?></strong>
              </div>
            </div>
          </div>
          <a href="<?= base_url('takim-lideri') ?>" class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-bold text-dark">
            Paneli Gör →
          </a>
        </div>
      </div>
    </div>

    <!-- 5. Satır: Katıldığınız Sınavlar Kartı -->
    <div class="portal-section-card">
      <div class="portal-section-header">
        <h2 class="portal-section-title">
          <div class="portal-section-icon">
            <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
          </div>
          <span>Katıldığınız Sınavlar</span>
        </h2>
        <span class="portal-count-pill">
          <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <strong><?= count($userExams) ?></strong> sınav kaydı görüntüleniyor
        </span>
      </div>

      <!-- Sınav Listesi Tablosu -->
      <div class="table-responsive rounded-4 border bg-white">
        <table class="table exam-table-custom align-middle mb-0">
          <thead>
            <tr>
              <th>Sınav Adı</th>
              <th>Tarih</th>
              <th>D / Y / B</th>
              <th>Puan</th>
              <th>Türkiye Derecesi</th>
              <th>İl Derecesi</th>
              <th class="text-end">İşlem</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($userExams)): ?>
              <?php foreach ($userExams as $item): ?>
                <tr>
                  <td>
                    <div class="fw-bold text-dark fs-6"><?= esc($item['name']) ?></div>
                    <small class="text-success fw-bold d-inline-flex align-items-center gap-1 mt-1">
                      <span class="pulse-dot" style="width: 6px; height: 6px;"></span>
                      <span><?= esc($item['status']) ?></span>
                    </small>
                  </td>
                  <td class="text-secondary fw-semibold"><?= esc($item['date']) ?></td>
                  <td>
                    <span class="badge bg-success-subtle text-success me-1 px-2 py-1 fs-7"><?= $item['correct'] ?> D</span>
                    <span class="badge bg-danger-subtle text-danger me-1 px-2 py-1 fs-7"><?= $item['wrong'] ?> Y</span>
                    <span class="badge bg-secondary-subtle text-secondary px-2 py-1 fs-7"><?= $item['empty'] ?> B</span>
                  </td>
                  <td>
                    <span class="exam-badge-score"><?= esc($item['score']) ?></span>
                  </td>
                  <td>
                    <?php 
                      $itRank = is_numeric($item['turkey_rank']) ? number_format((int)$item['turkey_rank'], 0, ',', '.') : $item['turkey_rank'];
                    ?>
                    <span class="fw-bold text-dark"><?= esc($itRank) ?></span>
                  </td>
                  <td>
                    <?php 
                      $icRank = is_numeric($item['city_rank']) ? number_format((int)$item['city_rank'], 0, ',', '.') : $item['city_rank'];
                    ?>
                    <span class="fw-bold text-dark"><?= esc($icRank) ?></span>
                  </td>
                  <td class="text-end">
                    <a href="<?= base_url('sertifikalarim') ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold">
                      📜 Sertifika Görüntüle
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="text-center py-5 text-muted">
                  Henüz katıldığınız bir sınav kaydı bulunmamaktadır.
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

    </div>

  </div>
</div>
<?= $this->endSection() ?>
