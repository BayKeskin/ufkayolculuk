<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<style>
  .invite-portal-wrap {
    background-color: #f0f4f9;
    min-height: calc(100vh - 200px);
    padding: 2.5rem 0 4rem;
  }

  /* Cyan Banner Pill (Resim 1'deki Gibi) */
  .invite-banner-pill {
    background: #38bdf8;
    color: #ffffff;
    font-size: 1.4rem;
    font-weight: 800;
    padding: 0.65rem 1.6rem;
    border-radius: 14px;
    display: inline-block;
    margin-bottom: 1.5rem;
    letter-spacing: -0.2px;
  }

  .invite-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 1.75rem 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    border: 1px solid rgba(226, 232, 240, 0.8);
    margin-bottom: 1.75rem;
  }

  .invite-desc-text {
    font-size: 0.88rem;
    color: #475569;
    line-height: 1.5;
    margin-bottom: 1.25rem;
  }

  .invite-input-label {
    font-size: 0.88rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.5rem;
    display: block;
  }

  .invite-input-group {
    display: flex;
    gap: 0.75rem;
    align-items: stretch;
  }

  .invite-url-input {
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    border-radius: 12px;
    padding: 0.75rem 1.25rem;
    font-size: 0.95rem;
    color: #334155;
    font-weight: 500;
    flex: 1;
    cursor: text;
  }

  .invite-copy-btn {
    background: #6366f1;
    color: #ffffff;
    border: none;
    border-radius: 12px;
    padding: 0 1.5rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: background 0.2s;
  }

  .invite-copy-btn:hover {
    background: #4f46e5;
    color: #ffffff;
  }

  .invite-table-title {
    font-size: 1.15rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 1.25rem;
  }

  .invite-table-custom {
    margin-bottom: 0;
  }

  .invite-table-custom th {
    background: transparent;
    color: #64748b;
    font-size: 0.82rem;
    font-weight: 700;
    padding: 0.85rem 1rem;
    border-bottom: 1px solid #e2e8f0;
  }

  .invite-table-custom td {
    padding: 1rem;
    font-size: 0.9rem;
    color: #334155;
    vertical-align: middle;
    border-bottom: 1px solid #f8fafc;
  }

  .invite-empty-state {
    text-align: center;
    padding: 3.5rem 1rem;
    color: #64748b;
    font-size: 0.92rem;
    font-weight: 500;
  }

  .invite-table-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 1.25rem;
    font-size: 0.82rem;
    color: #64748b;
    flex-wrap: wrap;
    gap: 1rem;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="invite-portal-wrap">
  <div class="container">

    <!-- Cyan Banner Başlığı (Resim 1'deki Gibi) -->
    <div class="invite-banner-pill">
      Davet Et (<?= esc($user['invite_code'] ?? 'UYCOPBLLH1YDO') ?>)
    </div>

    <!-- 1. Kart: Davet Linki ve Paylaşım -->
    <div class="invite-card">
      <p class="invite-desc-text">
        Altta yer alan davet linkinizi paylaşarak tanıdıklarınızı yarışmaya davet edebilirsiniz. Linkinize tıklayarak kayıt olan her kişi bu ekranda listelenecektir.
      </p>

      <label class="invite-input-label" for="inviteUrlInput">Davet Linkiniz:</label>
      <div class="invite-input-group">
        <input type="text" id="inviteUrlInput" class="invite-url-input" value="<?= esc($inviteLink) ?>" readonly>
        <button type="button" class="invite-copy-btn" id="btnCopyInvite" onclick="copyInviteLink()">
          <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
          </svg>
          <span id="copyBtnText">Kopyala</span>
        </button>
      </div>

      <!-- Hızlı Sosyal Medya Paylaşım Butonları -->
      <div class="d-flex align-items-center gap-2 mt-3 flex-wrap">
        <span class="small text-muted fw-semibold">Hızlı Paylaş:</span>
        <a href="https://api.whatsapp.com/send?text=<?= urlencode('Ufka Yolculuk yarışmasına davetlisin! Sen de katıl: ' . $inviteLink) ?>"
          target="_blank" class="btn btn-sm btn-outline-success rounded-pill px-3 fw-semibold">
          💬 WhatsApp
        </a>
        <a href="https://t.me/share/url?url=<?= urlencode($inviteLink) ?>&text=<?= urlencode('Ufka Yolculuk Yarışması') ?>"
          target="_blank" class="btn btn-sm btn-outline-info rounded-pill px-3 fw-semibold">
          ✈️ Telegram
        </a>
      </div>
    </div>

    <!-- 2. Kart: Davet Ettiğim Yarışmacılar Tablosu (Resim 1'deki Gibi) -->
    <div class="invite-card">
      <h2 class="invite-table-title">Davet Ettiğim Yarışmacılar</h2>

      <div class="table-responsive">
        <table class="table invite-table-custom">
          <thead>
            <tr>
              <th>Adı Soyadı ▲</th>
              <th>Kategorisi</th>
              <th>Okulu</th>
              <th>Kayıt Tarihi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($invitedList)): ?>
              <?php foreach ($invitedList as $row): ?>
                <tr>
                  <td class="fw-bold text-dark"><?= esc($row['name']) ?></td>
                  <td><?= esc($row['category']) ?></td>
                  <td><?= esc($row['school']) ?></td>
                  <td><?= esc($row['created_at']) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="invite-empty-state">
                  Tabloda herhangi bir veri mevcut değil
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Sayfalama ve Sayaç (Resim 1'deki Gibi) -->
      <div class="invite-table-footer">
        <div class="d-flex align-items-center gap-2">
          <span>Sayfada</span>
          <select class="form-select form-select-sm d-inline-block w-auto py-0 px-2" style="font-size: 0.8rem;">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
          </select>
          <span>kayıt göster</span>
          <span class="ms-3 text-muted">Kayıt yok</span>
        </div>

        <div class="d-flex align-items-center gap-3">
          <span class="text-muted" style="cursor: not-allowed;">Önceki</span>
          <span class="text-muted" style="cursor: not-allowed;">Sonraki</span>
        </div>
      </div>

    </div>

  </div>
</div>

<script>
  function copyInviteLink() {
    const input = document.getElementById('inviteUrlInput');
    input.select();
    input.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(input.value).then(() => {
      const btnText = document.getElementById('copyBtnText');
      const orig = btnText.textContent;
      btnText.textContent = 'Kopyalandı! ✓';
      setTimeout(() => {
        btnText.textContent = orig;
      }, 2000);
    });
  }
</script>
<?= $this->endSection() ?>
