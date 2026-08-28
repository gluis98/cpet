<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            return;
        }

        $request = request();
        if (! $request || ! $request->getHost()) {
            return;
        }

        // Detrás de Coolify / proxy: generar asset() y @vite con el dominio real de la petición.
        $scheme = $request->header('X-Forwarded-Proto', $request->getScheme());
        if (! in_array($scheme, ['http', 'https'], true)) {
            $scheme = $request->getScheme();
        }

        URL::forceRootUrl($scheme.'://'.$request->getHost());
        URL::forceScheme($scheme);
    }
}
