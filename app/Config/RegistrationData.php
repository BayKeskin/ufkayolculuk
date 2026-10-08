<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Ufka Yolculuk Kayıt Sistemi Ülke ve Telefon Kodu Konfigürasyonu
 */
class RegistrationData extends BaseConfig
{
    /**
     * Varsayılan Ülke Kodu ve Telefon Kodu
     */
    public string $defaultCountryId = '225'; // Turkey - Türkiye
    public string $defaultPhoneCode = '90';

    /**
     * 251 Dünya Ülkesi Listesi (id => name)
     */
    public array $countries = [];

    /**
     * 251 Telefon Ülke Kodları Listesi (code, data_id, name)
     */
    public array $phoneCodes = [];

    public function __construct()
    {
        parent::__construct();
        $this->loadData();
    }

    private function loadData(): void
    {
        // JSON dosyalarından optimize veriyi yükle
        $countriesPath = __DIR__ . '/../Database/data/countries.json';
        $phoneCodesPath = __DIR__ . '/../Database/data/country_phone_codes.json';

        if (file_exists($countriesPath)) {
            $this->countries = json_decode(file_get_contents($countriesPath), true) ?: [];
        }
        if (file_exists($phoneCodesPath)) {
            $this->phoneCodes = json_decode(file_get_contents($phoneCodesPath), true) ?: [];
        }
    }
}
