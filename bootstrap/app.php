<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// 1. Tampung konfigurasi aplikasi ke dalam variabel $app
$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        // 🔥 PERBAIKAN KAMU: Kecualikan route webhook Midtrans dari pemeriksaan CSRF Token
        $middleware->validateCsrfTokens(except: [
            'midtrans/webhook'
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// 2. 🔥 PERBAIKAN VERCEL: Pindahkan storage path dan buat foldernya secara otomatis jika di server Vercel
if (isset($_SERVER['VERCEL_URL'])) {
    $app->useStoragePath('/tmp');
    
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

// 3. Kembalikan instance aplikasi yang sudah dikonfigurasi lengkap
return $app;