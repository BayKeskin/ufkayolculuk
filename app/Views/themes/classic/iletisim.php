<?= $this->extend('themes/classic/layouts/main') ?>

<?= $this->section('content') ?>
<style>
.mailbox{
    font-size:36px;
}
.phonebox{
    font-size:45px;
}
@media (max-width: 992px) {
    .mailbox{
        font-size:20px;
    }
    .phonebox{
        font-size:36px;
    }
}
</style>
<div class="card shadow-sm border-0">
    <div class="card-body p-lg-17">
        <div class="row g-5 mb-5 mb-lg-15">
            <div class="col-sm-12 pe-lg-10">
                <div class="bg-light card-rounded d-flex flex-column flex-center flex-center p-10 h-100 text-center">
                    <i class="ki-duotone ki-phone fs-3tx text-primary mb-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    
                    <div class="text-gray-700 fw-semibold mb-0 mt-5" style="font-size:14px">Her türlü öneri, istek ve şikayet için</div>
                    <h1 class="text-gray-800 fw-bold my-5" style="font-size:20px">İletişime Geçin</h1>
                    <div class="fw-bold phonebox"><a class="text-gray-800 text-decoration-none" href="tel:4448317">444 83 17</a></div>
                    <div class="fw-bold mailbox"><a class="text-gray-800 text-decoration-none" href="mailto:bilgi@ufkayolculuk.com">bilgi@ufkayolculuk.com</a></div>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-12">
                <div class="mb-xxl-10" style="border: 1px solid #f0f3f6;border-radius: 10px;">
                    <div class="card-header pt-5 border-bottom pb-4">
                        <div class="row w-100 align-items-center">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <h3 class="card-title align-items-start flex-column m-0">
                                    <span class="card-label fw-bold text-gray-900 fs-4">İl Temsilcisi</span>
                                    <span class="text-gray-500 pt-1 fw-semibold fs-7 d-block">İlinizdeki temsilciyi görmek için il seçimi yapınız</span>
                                </h3>
                            </div>
                            <div class="col-md-6">
                                <select name="city_id" id="city_contact_select" class="form-select">
                                    <option value="">İl Seçiniz</option>
                                    <?php 
                                    $cityList = $cities ?? [];
                                    foreach($cityList as $city){
                                        $cName = is_array($city) ? ($city['name'] ?? '') : (is_object($city) ? $city->name : $city);
                                        echo "<option value='".esc($cName)."'>".esc($cName)."</option>";
                                    } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-6">
                        <div id="city_contact_display">
                            <div class="alert alert-info" role="alert">
                                <h4 class="m-0">Lütfen Yukarıdaki Kutucuktan İl Seçimi Yapınız</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mb-4 bg-light text-center border-0">
            <div class="card-body py-8">
                <a href="https://www.instagram.com/ufkayolculukcom" target="_blank" class="mx-3">
                    <img src="<?=base_url('assets/m2/media/svg/brand-logos/instagram-2-1.svg');?>" class="my-2" style="height:32px" alt="Instagram Hesabımız">  
                </a>
                <a href="https://www.facebook.com/ufkayolculukcom" target="_blank" class="mx-3">
                    <img src="<?=base_url('assets/m2/media/svg/brand-logos/facebook-4.svg');?>" class="my-2" style="height:32px" alt="Facebook Hesabımız">  
                </a>
                <a href="https://x.com/ufkayolculukcom" target="_blank" class="mx-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 50 50">
                        <path d="M 11 4 C 7.134 4 4 7.134 4 11 L 4 39 C 4 42.866 7.134 46 11 46 L 39 46 C 42.866 46 46 42.866 46 39 L 46 11 C 46 7.134 42.866 4 39 4 L 11 4 z M 13.085938 13 L 21.023438 13 L 26.660156 21.009766 L 33.5 13 L 36 13 L 27.789062 22.613281 L 37.914062 37 L 29.978516 37 L 23.4375 27.707031 L 15.5 37 L 13 37 L 22.308594 26.103516 L 13.085938 13 z M 16.914062 15 L 31.021484 35 L 34.085938 35 L 19.978516 15 L 16.914062 15 z"></path>
                    </svg>
                </a> 
                <a href="https://t.me/ufkayolculukk" target="_blank" class="mx-3">
                    <img src="<?=base_url('assets/m2/media/svg/brand-logos/telegram.svg');?>" class="my-2" style="height:32px" alt="Telegram hesabımız">  
                </a>
                <a href="https://whatsapp.com/channel/0029VaDlLtEKwqSPSP3Ryg0z" target="_blank" class="mx-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 48 48">
                        <path fill="#40c351" d="M35.176,12.832c-2.98-2.982-6.941-4.625-11.157-4.626c-8.704,0-15.783,7.076-15.787,15.774c-0.001,2.981,0.833,5.883,2.413,8.396l0.376,0.597l-1.595,5.821l5.973-1.566l0.577,0.342c2.422,1.438,5.2,2.198,8.032,2.199h0.006c8.698,0,15.777-7.077,15.78-15.776C39.795,19.778,38.156,15.814,35.176,12.832z"></path>
                        <path fill="#fff" fill-rule="evenodd" d="M19.268,16.045c-0.355-0.79-0.729-0.806-1.068-0.82c-0.277-0.012-0.593-0.011-0.909-0.011c-0.316,0-0.83,0.119-1.265,0.594c-0.435,0.475-1.661,1.622-1.661,3.956c0,2.334,1.7,4.59,1.937,4.906c0.237,0.316,3.282,5.259,8.104,7.161c4.007,1.58,4.823,1.266,5.693,1.187c0.87-0.079,2.807-1.147,3.202-2.255c0.395-1.108,0.395-2.057,0.277-2.255c-0.119-0.198-0.435-0.316-0.909-0.554s-2.807-1.385-3.242-1.543c-0.435-0.158-0.751-0.237-1.068,0.238c-0.316,0.474-1.225,1.543-1.502,1.859c-0.277,0.317-0.554,0.357-1.028,0.119c-0.474-0.238-2.002-0.738-3.815-2.354c-1.41-1.257-2.362-2.81-2.639-3.285c-0.277-0.474-0.03-0.731,0.208-0.968c0.213-0.213,0.474-0.554,0.712-0.831c0.237-0.277,0.316-0.475,0.474-0.791c0.158-0.317,0.079-0.594-0.04-0.831C20.612,19.329,19.69,16.983,19.268,16.045z" clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
$('#city_contact_select').change(function(){
    var val = $(this).val();
    if (!val) {
        $('#city_contact_display').html('<div class="alert alert-info"><h4 class="m-0">Lütfen Yukarıdaki Kutucuktan İl Seçimi Yapınız</h4></div>');
        return;
    }
    $('#city_contact_display').html('<div class="p-4 rounded bg-light border"><h5 class="fw-bold mb-2">' + val + ' İl Temsilciliği</h5><p class="text-muted m-0">İletişim ve destek için: <strong>444 83 17</strong> veya <strong>bilgi@ufkayolculuk.com</strong></p></div>');
});
</script>
<?= $this->endSection() ?>
