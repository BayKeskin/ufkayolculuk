<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
  .profile-portal-wrap {
    background-color: #f0f4f9;
    min-height: calc(100vh - 200px);
    padding: 2.5rem 0 4rem;
  }

  .portal-user-name {
    font-size: 2.4rem;
    font-weight: 800;
    color: #1e3a62;
    letter-spacing: -0.5px;
    margin-bottom: 1.5rem;
  }

  /* 3 Stat Cards */
  .portal-stat-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 1.5rem 1.75rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    border: 1px solid rgba(226, 232, 240, 0.8);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    height: 100%;
  }

  .portal-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
  }

  .portal-stat-label {
    font-size: 0.78rem;
    font-weight: 800;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    color: #64748b;
    margin-bottom: 0.6rem;
  }

  .portal-stat-value {
    font-size: 2.4rem;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
    font-family: 'Outfit', sans-serif;
  }

  /* Role Cards */
  .portal-role-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    border: 1px solid rgba(226, 232, 240, 0.8);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    height: 100%;
  }

  .role-icon-box {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
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
    font-size: 0.82rem;
    color: #64748b;
  }

  .role-active-badge {
    background: #e6f9ed;
    color: #10b981;
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 0.5px;
    padding: 0.35rem 0.75rem;
    border-radius: 50rem;
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    text-transform: uppercase;
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
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    border: 1px solid rgba(226, 232, 240, 0.8);
    margin-top: 1.75rem;
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
    font-size: 1.4rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
  }

  .portal-section-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: #6366f1;
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
  }

  .portal-count-pill {
    background: #f1f5f9;
    color: #475569;
    font-size: 0.82rem;
    font-weight: 600;
    padding: 0.4rem 0.9rem;
    border-radius: 50rem;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
  }

  .exam-table-custom {
    margin-bottom: 0;
  }

  .exam-table-custom th {
    background: #f8fafc;
    color: #64748b;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid #e2e8f0;
    padding: 1rem 1.25rem;
  }

  .exam-table-custom td {
    padding: 1.15rem 1.25rem;
    vertical-align: middle;
    font-size: 0.92rem;
    color: #1e293b;
    border-bottom: 1px solid #f1f5f9;
  }

  .exam-badge-score {
    background: #eef2ff;
    color: #4338ca;
    font-weight: 800;
    padding: 0.35rem 0.75rem;
    border-radius: 8px;
    display: inline-block;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="profile-portal-wrap">
  <div class="container">

    <!-- Kullanıcı Başlığı -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
      <h1 class="portal-user-name mb-0"><?= esc($user['name'] ?? 'ibrahim._. tekmen') ?></h1>
      <div class="d-flex align-items-center gap-2">
        <a href="<?= base_url('sertifikalarim') ?>" class="btn btn-outline-primary rounded-pill px-3 py-2 fw-semibold small">
          📜 Sertifikalarım
        </a>
        <a href="<?= base_url('vesile-olduklarim') ?>" class="btn btn-warning rounded-pill px-3 py-2 fw-semibold small">
          🔗 Davet Et & Kazan
        </a>
      </div>
    </div>

    <!-- 1. Satır: 3 Ana İstatistik Kartı (Resimdeki Gibi) -->
    <div class="row g-3 g-md-4 mb-4">
      <div class="col-12 col-md-4">
        <div class="portal-stat-card">
          <div class="portal-stat-label">GENEL PUAN</div>
          <div class="portal-stat-value"><?= esc($user['general_score'] ?? '3.27') ?></div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="portal-stat-card">
          <div class="portal-stat-label">TÜRKİYE DERECESİ</div>
          <div class="portal-stat-value"><?= esc($user['turkey_rank'] ?? '48296') ?></div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="portal-stat-card">
          <div class="portal-stat-label">İL DERECESİ</div>
          <div class="portal-stat-value"><?= esc($user['city_rank'] ?? '460') ?></div>
        </div>
      </div>
    </div>

    <!-- 2. Satır: 2 Rol & Statü Kartı (Yarışmacı ve Takım Lideri) -->
    <div class="row g-3 g-md-4 mb-4">
      <!-- Yarışmacı Kartı -->
      <div class="col-12 col-md-6 col-lg-4">
        <div class="portal-role-card">
          <div class="d-flex align-items-center gap-3">
            <div class="role-icon-box">
              <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
      <div class="col-12 col-md-6 col-lg-5">
        <div class="portal-role-card">
          <div class="d-flex align-items-center gap-3">
            <div class="role-icon-box">
              <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
            <div>
              <div class="role-info-title">Takım Lideri</div>
              <div class="role-info-sub"><?= esc($user['leader_category'] ?? 'DİĞER Kategorisi') ?></div>
              <div class="role-info-sub text-muted">Puan: <?= esc($user['leader_score'] ?? '0.0000000') ?></div>
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
            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
          </div>
          <span>Katıldığınız Sınavlar</span>
        </h2>
        <span class="portal-count-pill">
          <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          <?= count($userExams) ?> sınav kaydı görüntüleniyor
        </span>
      </div>

      <!-- Sınav Listesi Tablosu -->
      <div class="table-responsive rounded-3 border">
        <table class="table exam-table-custom table-hover align-middle mb-0">
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
                    <small class="text-success fw-semibold">● <?= esc($item['status']) ?></small>
                  </td>
                  <td><?= esc($item['date']) ?></td>
                  <td>
                    <span class="badge bg-success-subtle text-success me-1"><?= $item['correct'] ?> D</span>
                    <span class="badge bg-danger-subtle text-danger me-1"><?= $item['wrong'] ?> Y</span>
                    <span class="badge bg-secondary-subtle text-secondary"><?= $item['empty'] ?> B</span>
                  </td>
                  <td>
                    <span class="exam-badge-score"><?= esc($item['score']) ?></span>
                  </td>
                  <td><span class="fw-semibold text-dark"><?= esc($item['turkey_rank']) ?></span></td>
                  <td><span class="fw-semibold text-dark"><?= esc($item['city_rank']) ?></span></td>
                  <td class="text-end">
                    <a href="<?= base_url('sertifikalarim') ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
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
