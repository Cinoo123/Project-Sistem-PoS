<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // ✅ PAKSA URL MENJADI HTTPS JIKA BERADA DI VERCEL
        if (getenv('VERCEL') === '1' || isset($_SERVER['VERCEL_URL'])) {
            URL::forceScheme('https');
        }
        
        // ✅ FIX REDIRECT PASCA LOGIN UNTUK LARAVEL 11/12 DI VERCEL
        // Jika ada library internal (seperti Fortify/Breeze) yang mencari rute /dashboard atau /home,
        // kita paksa rute tersebut tetap aman menampilkan halaman utama '/' tanpa memicu 404 Vercel.
        $this->app->bind('path.home', function () {
            return '/';
        });
    }
}