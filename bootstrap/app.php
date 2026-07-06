<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// ✅ PERBAIKAN DETEKSI VERCEL: Gunakan getenv('VERCEL') agar pasti terbaca server
if (getenv('VERCEL') === '1' || isset($_SERVER['VERCEL_URL']) || env('VERCEL')) {
    $required_directories = [
        '/tmp/framework/views',
        '/tmp/framework/cache',
        '/tmp/framework/sessions'
    ];
    foreach ($required_directories as $directory) {
        if (!is_dir($directory)) {
            @mkdir($directory, 0755, true);
        }
    }
}

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        // 🔥 PERBAIKAN KAMU: Webhook Midtrans bebas CSRF
        $middleware->validateCsrfTokens(except: [
            'midtrans/webhook'
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// ✅ Pindahkan storage path utama ke /tmp jika terdeteksi di lingkungan Vercel
if (getenv('VERCEL') === '1' || isset($_SERVER['VERCEL_URL']) || env('VERCEL')) {
    $app->useStoragePath('/tmp');
}

return $app;