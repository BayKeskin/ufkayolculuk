<?php

namespace App\Controllers;

use App\Services\UfkaApiService;
use CodeIgniter\HTTP\ResponseInterface;

class Oduller extends BaseController
{
    protected UfkaApiService $api;

    public function __construct()
    {
        $this->api = new UfkaApiService();
    }

    public function index(): string
    {
        $nationalAwards = $this->api->getNationalAwardsFormatted();
        $cities         = $this->api->getAwardCities();
        $selectedCity   = $this->request->getGet('il') ?? 'Konya';
        $cityAwardsMap  = $this->api->getCityAwardsMap();
        $selectedCityAwards = $cityAwardsMap[$selectedCity] ?? $this->api->getCityAwardsFormatted($selectedCity);

        $faqData   = $this->api->getFaqList();
        $awardFaqs = array_values(array_filter($faqData['items'] ?? [], function ($f) {
            return ($f['category_key'] ?? '') === 'oduller';
        }));

        $data = [
            'title'              => 'Yarışma Ödülleri - Ufka Yolculuk',
            'meta_description'   => 'Ufka Yolculuk yarışması Türkiye geneli, il, ilçe ve okul başarı ödülleri, Umre ödülü ve nakit para ödülleri.',
            'activePage'         => 'oduller',
            'nationalAwards'     => $nationalAwards,
            'cities'             => $cities,
            'selectedCity'       => $selectedCity,
            'selectedCityAwards' => $selectedCityAwards,
            'cityAwardsMap'      => $cityAwardsMap,
            'awardFaqs'          => $awardFaqs,
        ];

        return view('oduller', $data);
    }

    /**
     * İl seçildiğinde AJAX ile ilgili ilin ödül verilerini döner
     */
    public function cityAwardsAjax(string $cityName): ResponseInterface
    {
        $decodedCity = urldecode($cityName);
        $data = $this->api->getCityAwardsFormatted($decodedCity);

        return $this->response->setJSON($data);
    }
}

