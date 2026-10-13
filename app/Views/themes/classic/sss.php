<?= $this->extend('themes/classic/layouts/main') ?>

<?= $this->section('content') ?>
<div class="card shadow-sm border-0 mb-5">
    <div class="card-header border-bottom py-4">
        <h2 class="card-title fw-bold text-gray-900 m-0">Sıkça Sorulan Sorular</h2>
    </div>
    <div class="card-body p-6">
        <div class="accordion" id="accordionFaq">
            <div class="accordion-item mb-3 border rounded-3">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                        Ufka Yolculuk yarışmasına kimler katılabilir?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                    <div class="accordion-body text-muted fs-7">
                        İlkokul, ortaokul, lise ve yetişkin kategorilerinde yer alan tüm vatandaşlarımız ve yurtdışından ilgili kategorilere uygun adaylar yarışmaya katılabilir.
                    </div>
                </div>
            </div>
            <div class="accordion-item mb-3 border rounded-3">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                        Yarışma sınavları nasıl uygulanmaktadır?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                    <div class="accordion-body text-muted fs-7">
                        Sınavlar online ortamda web sitemiz ve sınav portalımız üzerinden belirlenen tarihlerde çoktan seçmeli olarak gerçekleştirilmektedir.
                    </div>
                </div>
            </div>
            <div class="accordion-item mb-3 border rounded-3">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button fw-bold collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                        Kitapları nereden temin edebilirim?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFaq">
                    <div class="accordion-body text-muted fs-7">
                        Yarışma kitaplarını yetkili kitapçılardan, sitemiz üzerinden online olarak okuyarak veya sesli kitap platformlarımızdan dinleyerek temin edebilirsiniz.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
