<?php

namespace App\Support;

class PublicAsset
{
    /**
     * URL relativa al dominio (no depende de APP_URL).
     */
    public static function url(string $path): string
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');

        if (! app()->runningInConsole() && request()) {
            $base = rtrim(request()->getBaseUrl(), '/');

            return ($base !== '' ? $base : '').'/'.$path;
        }

        return '/'.$path;
    }

    /**
     * @return array{hot: bool, css: string[], js: string[]}
     */
    public static function viteEntries(): array
    {
        if (is_file(public_path('hot'))) {
            return ['hot' => true, 'css' => [], 'js' => []];
        }

        $manifestFile = public_path('build/manifest.json');
        if (! is_file($manifestFile)) {
            return ['hot' => false, 'css' => [], 'js' => []];
        }

        $manifest = json_decode((string) file_get_contents($manifestFile), true) ?: [];
        $cssKey = 'resources/css/app.css';
        $jsKey = 'resources/js/app.js';
        $css = [];
        $js = [];

        if (! empty($manifest[$cssKey]['file'])) {
            $css[] = self::url('build/'.$manifest[$cssKey]['file']);
        }
        if (! empty($manifest[$cssKey]['css'])) {
            foreach ($manifest[$cssKey]['css'] as $file) {
                $css[] = self::url('build/'.$file);
            }
        }
        if (! empty($manifest[$jsKey]['file'])) {
            $js[] = self::url('build/'.$manifest[$jsKey]['file']);
        }

        return ['hot' => false, 'css' => array_values(array_unique($css)), 'js' => $js];
    }
}
