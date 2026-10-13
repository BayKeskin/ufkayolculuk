<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

use Config\View;

if (! function_exists('theme_asset')) {
    /**
     * Aktif temanın asset URL'ini döner
     */
    function theme_asset(string $path = '', ?string $theme = null): string
    {
        if ($theme === null) {
            try {
                $api = new \App\Services\UfkaApiService();
                $theme = $api->getActiveTheme();
            } catch (\Throwable $e) {
                $theme = 'modern';
            }
        }
        $themePath = 'assets/themes/' . $theme . '/' . ltrim($path, '/');
        // Eğer tema dizininde yoksa genel assets dizininde ara
        if (defined('FCPATH') && ! file_exists(FCPATH . $themePath)) {
            $themePath = 'assets/' . ltrim($path, '/');
        }
        return base_url($themePath);
    }
}

if (! function_exists('view')) {
    /**
     * Temaya duyarlı View fonksiyonu.
     * Aktif tema altında view varsa onu yükler, yoksa modern temaya veya kök view'a fallback yapar.
     */
    function view(string $name, array $data = [], array $options = []): string
    {
        $renderer = service('renderer');

        $config   = config(View::class);
        $saveData = $config->saveData ?? true;

        if (array_key_exists('saveData', $options)) {
            $saveData = (bool) $options['saveData'];
            unset($options['saveData']);
        }

        // errors/ veya layouts/ veya zaten themes/ ile başlıyorsa dokunma
        $resolvedName = $name;
        if (! str_starts_with($name, 'errors/') && ! str_starts_with($name, 'themes/')) {
            try {
                $api = new \App\Services\UfkaApiService();
                $activeTheme = $api->getActiveTheme();

                if (! isset($data['activeTheme'])) {
                    $data['activeTheme'] = $activeTheme;
                }

                $themedFile = APPPATH . 'Views/themes/' . $activeTheme . '/' . ltrim($name, '/') . '.php';
                if (file_exists($themedFile)) {
                    $resolvedName = 'themes/' . $activeTheme . '/' . ltrim($name, '/');
                } else {
                    $modernFile = APPPATH . 'Views/themes/modern/' . ltrim($name, '/') . '.php';
                    if (file_exists($modernFile)) {
                        $resolvedName = 'themes/modern/' . ltrim($name, '/');
                    }
                }
            } catch (\Throwable $e) {
                // Hata durumunda varsayılan name ile devam et
                $resolvedName = $name;
            }
        }

        return $renderer->setData($data, 'raw')->render($resolvedName, $options, $saveData);
    }
}
