<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// [1] PANDUAN VERCEL: Siapkan folder /tmp di awal sebelum sistem Laravel berjalan
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

// [2] Konfigurasi utama aplikasi
$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        // ✅ SOLUSI UNTUK LAYAR PERINGATAN BROWSER:
        // Paksa Laravel memercayai jembatan proxy SSL Vercel agar semua rute otomatis dikonversi ke HTTPS aman
        $middleware->trustProxies(at: '*');

        // Jalur Webhook Midtrans bebas CSRF
        $middleware->validateCsrfTokens(except: [
            'midtrans/webhook'
        ]);

        // 🌟 INI DIA YANG HILANG! Daftarkan kata kunci 'admin' agar rute mengenali satpam IsAdmin kamu
        $middleware->alias([
            'admin' => \App\Http\Middleware\IsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        
        // 🔥 TRICK DEBUGGING FINAL: Bongkar eror asli tanpa memanggil komponen 'view'
        $exceptions->render(function (\Throwable $e) {
            if (getenv('VERCEL') === '1' || isset($_SERVER['VERCEL_URL'])) {
                return new \Symfony\Component\HttpFoundation\Response(
                    "BIANG KEROK BERHASIL DIBONGKAR! -> EROR ASLI: " . $e->getMessage() . " | Lokasi File: " . $e->getFile() . " (Lini: " . $e->getLine() . ")",
                    500,
                    ['Content-Type' => 'text/plain; charset=UTF-8']
                );
            }
        });

    })->create();

// [3] Alihkan jalur utama storage ke /tmp jika di Vercel
if (getenv('VERCEL') === '1' || isset($_SERVER['VERCEL_URL']) || env('VERCEL')) {
    $app->useStoragePath('/tmp');
}

return $app;

// Pemicu Update Git Vercel Sukses