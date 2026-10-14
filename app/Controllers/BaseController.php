<?php

namespace App\Controllers;

use App\Services\UfkaApiService;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Aktif tema adı ('modern' veya 'classic')
     */
    protected string $activeTheme = 'modern';

    /**
     * API Servisi
     */
    protected ?UfkaApiService $apiService = null;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        try {
            $this->apiService = new \App\Services\UfkaApiService();
            $this->activeTheme = $this->apiService->getActiveTheme();
        } catch (\Throwable $e) {
            $this->activeTheme = 'modern';
        }
    }

    /**
     * Temaya duyarlı View çağırma yardımcısı
     */
    protected function renderTheme(string $viewName, array $data = []): string
    {
        $data['activeTheme']   = $this->activeTheme;
        $data['themeAssetUrl'] = base_url("assets/themes/{$this->activeTheme}/");
        return view($viewName, $data);
    }
}
