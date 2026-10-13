<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
  .profile-portal-wrap {
    background-color: #f8fafc;
    min-height: calc(100vh - 200px);
    padding: 2.5rem 0 4rem;
  }

  .portal-header-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 2rem;
  }

  .portal-user-name {
    font-size: 2.2rem;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.5px;
    margin-bottom: 0;
    font-family: 'Outfit', sans-serif;
  }

  /* 3 Stat Cards */
  .portal-stat-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 1.5rem 1.75rem;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
    border: 1px solid #e2e8f0;
    transition: all 0.25s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
  }

  .portal-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
    border-color: #cbd5e1;
  }

  .portal-stat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.75rem;
  }

  .portal-stat-label {
    font-size: 0.78rem;
    font-weight: 800;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    color: #64748b;
  }

  .portal-stat-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
  }

  .stat-icon-purple { background: #f3e8ff; color: #9333ea; }
  .stat-icon-blue   { background: #e0f2fe; color: #0284c7; }
  .stat-icon-green  { background: #dcfce7; color: #16a34a; }

  .portal-stat-value {
    font-size: 2.4rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.1;
    font-family: 'Outfit', sans-serif;
  }

  /* Role Cards */
  .portal-role-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    height: 100%;
    transition: all 0.25s ease;
  }

  .portal-role-card:hover {
    box-shadow: 0 8px 25px rgba(15, 23, 42, 0.06);
    border-color: #cbd5e1;
  }

  .role-icon-box {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #475569;
    font-size: 1.4rem;
    flex-shrink: 0;
  }

  .role-info-title {
    font-weight: 800;
    font-size: 1.15rem;
    color: #0f172a;
    margin-bottom: 0.15rem;
  }

  .role-info-sub {
    font-size: 0.85rem;
    color: #64748b;
  }

  .role-active-badge {
    background: #ecfdf5;
    color: #059669;
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 0.5px;
    padding: 0.4rem 0.85rem;
    border-radius: 50rem;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    text-transform: uppercase;
    border: 1px solid #a7f3d0;
  }

  .role-active-badge::before {
    content: '';
    display: inline-block;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #10b981;
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
    gap: 0.75rem;
    font-size: 1.35rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
    font-family: 'Outfit', sans-serif;
  }

  .portal-section-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    background: #4f46e5;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
  }

  .portal-count-pill {
    background: #f1f5f9;
    color: #475569;
    font-size: 0.85rem;
    font-weight: 600;
    padding: 0.45rem 1rem;
    border-radius: 50rem;
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
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
    padding: 1.1rem 1.25rem;
    white-space: nowrap;
  }

  .exam-table-custom tbody td {
    padding: 1.2rem 1.25rem;
    vertical-align: middle;
    font-size: 0.92rem;
    color: #1e293b;
    border-bottom: 1px solid #f1f5f9;
  }

  .exam-table-custom tbody tr:hover td {
    background-color: #f8fafc;
  }

  .exam-badge-score {
    background: #eef2ff;
    color: #4338ca;
    font-weight: 800;
    padding: 0.4rem 0.85rem;
    border-radius: 10px;
    display: inline-block;
    border: 1px solid #c7d2fe;
    font-size: 0.95rem;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="profile-portal-wrap">
  <div class="container">

    <!-- Kullanıcı Başlığı & Aksiyonlar (Düzeltildi: Kapanış div'i eklendi) -->
    <div class="portal-header-bar">
      <div>
        <h1 class="portal-user-name"><?= esc($user['name'] ?? 'ibrahim._. tekmen') ?></h1>
        <small class="text-muted fw-semibold">Sınav sonuçları, puan durumu ve derece karnesi</small>
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

    <!-- 1. Satır: 3 Ana İstatistik Kartı -->
    <div class="row g-3 g-md-4 mb-4">
      <div class="col-12 col-md-4">
        <div class="portal-stat-card">
          <div class="portal-stat-header">
            <span class="portal-stat-label">GENEL PUAN</span>
            <div class="portal-stat-icon stat-icon-purple">🎯</div>
          </div>
          <div class="portal-stat-value"><?= esc($user['general_score'] ?? '3.27') ?></div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="portal-stat-card">
          <div class="portal-stat-header">
            <span class="portal-stat-label">TÜRKİYE DERECESİ</span>
            <div class="portal-stat-icon stat-icon-blue">🏆</div>
          </div>
          <div class="portal-stat-value"><?= esc($user['turkey_rank'] ?? '48296') ?></div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="portal-stat-card">
          <div class="portal-stat-header">
            <span class="portal-stat-label">İL DERECESİ</span>
            <div class="portal-stat-icon stat-icon-green">📍</div>
          </div>
          <div class="portal-stat-value"><?= esc($user['city_rank'] ?? '460') ?></div>
        </div>
      </div>
    </div>

    <!-- 2. Satır: 2 Rol & Statü Kartı (Simetrik 6 + 6 Grid) -->
    <div class="row g-3 g-md-4 mb-4">
      <!-- Yarışmacı Kartı -->
      <div class="col-12 col-md-6">
        <div class="portal-role-card">
          <div class="d-flex align-items-center gap-3">
            <div class="role-icon-box text-primary">
              <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <rect x="4" y="3" width="16" height="18" rx="2" stroke-width="2" />
                <circle cx="12" cy="9" r="3" stroke-width="2" />
                <path stroke-linecap="round" stroke-width="2" d="M8 17c0-2 2-3 4-3s4 1 4 3" />
              </svg>
            </div>
            <div>
              <div class="role-info-title">Yarışmacı</div>
              <div class="role-info-sub"><?= esc($user['category_title'] ?? 'Yetişkin Kategorisi') ?></div>
            </div>
          </div>
          <span class="role-active-badge">Aktif</span>
        </div>
      </div>

      <!-- Takım Lideri Kartı -->
      <div class="col-12 col-md-6">
        <div class="portal-role-card">
          <div class="d-flex align-items-center gap-3">
            <div class="role-icon-box text-warning">
              <svg width="26" height="26" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
              <div class="role-info-sub text-muted">Puan: <strong class="text-dark"><?= number_format($lScore, 2, ',', '.') ?></strong></div>
            </div>
          </div>
          <span class="role-active-badge">Aktif</span>
        </div>
      </div>
    </div>

    <!-- 3. Satır: Katıldığınız Sınavlar Kartı -->
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
                    <div class="fw-bold text-dark"><?= esc($item['name']) ?></div>
                    <small class="text-success fw-bold d-inline-flex align-items-center gap-1">
                      <span style="display:inline-block;width:6px;height:6px;border-radius:50%;background:#10b981;"></span>
                      <?= esc($item['status']) ?>
                    </small>
                  </td>
                  <td class="text-secondary fw-semibold"><?= esc($item['date']) ?></td>
                  <td>
                    <span class="badge bg-success-subtle text-success me-1 px-2 py-1"><?= $item['correct'] ?> D</span>
                    <span class="badge bg-danger-subtle text-danger me-1 px-2 py-1"><?= $item['wrong'] ?> Y</span>
                    <span class="badge bg-secondary-subtle text-secondary px-2 py-1"><?= $item['empty'] ?> B</span>
                  </td>
                  <td>
                    <span class="exam-badge-score"><?= esc($item['score']) ?></span>
                  </td>
                  <td><span class="fw-bold text-dark"><?= esc($item['turkey_rank']) ?></span></td>
                  <td><span class="fw-bold text-dark"><?= esc($item['city_rank']) ?></span></td>
                  <td class="text-end">
                    <a href="<?= base_url('sertifikalarim') ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold">
                      Sertifika Görüntüle
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
