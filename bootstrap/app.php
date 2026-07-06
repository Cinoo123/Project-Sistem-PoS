<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// [1] PANDUAN VERCEL: Siapkan folder /tmp di awal sebelum sistem Laravel berjalan
if (isset($_SERVER['VERCEL_URL'])) {
    $required_directories = [
        '/tmp/framework/views',
        '/tmp/framework/cache',
        '/tmp/framework/sessions'
    ];
    foreach ($required_directories as $directory) {
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }
}

// [2] Konfigurasi utama aplikasi
$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        // Jalur Webhook Midtrans bebas CSRF
        $middleware->validateCsrfTokens(except: [
            'midtrans/webhook'
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// [3] Alihkan jalur utama storage ke /tmp jika di Vercel
if (isset($_SERVER['VERCEL_URL'])) {
    $app->useStoragePath('/tmp');
}

return $app;