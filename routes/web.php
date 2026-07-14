<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\MenuManagement;

/*
|--------------------------------------------------------------------------
| 1. RUTE UNTUK PENGUNJUNG / BELUM LOGIN (GUEST MULTIPLEX)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    // Jalur Logika Login Kasir
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

    // PERBAIKAN UTAMA: Rute Penyelamat jika Laravel otomatis mengarah ke URL /login
    Route::get('/login', function() {
        return redirect('/');
    });

    // Jalur Logika Lupa & Reset Password
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'checkEmail'])->name('password.email');
    Route::get('/reset-password/{email}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'updatePassword'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| 2. RUTE UNTUK KASIR YANG SUDAH LOGIN (AUTH REQUIRED)
|--------------------------------------------------------------------------
| Semua rute operasional POS dimasukkan ke sini agar tidak bisa di-bypass lewat URL!
*/
Route::middleware('auth')->group(function () {
    // Tombol Keluar Sistem
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Halaman Utama Aplikasi Kasir (POS)
    Route::get('/pos', [OrderController::class, 'index'])->name('pos.index');
    
    // Logika Pemesanan & Pembayaran
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
    Route::post('/order/payment', [OrderController::class, 'prosesPembayaran'])->name('order.payment');
    Route::post('/order/kitchen', [OrderController::class, 'sendToKitchen'])->name('order.kitchen');
    Route::get('/order/status/{order_id}', [OrderController::class, 'checkOrderStatus']);
    
    // Manajemen Buka/Tutup Kas Register Uang Uang Masuk
    Route::get('/register/check', [OrderController::class, 'checkRegister']);
    Route::post('/register/open', [OrderController::class, 'openRegister']);
    Route::get('/register/preview', [OrderController::class, 'previewCloseRegister']);
    Route::post('/register/close', [OrderController::class, 'closeRegister']);

    // Halaman Laporan Penjualan Kasir
    Route::get('/report', [ReportController::class, 'index'])->name('report');
});

/*
|--------------------------------------------------------------------------
| 3. RUTE KHUSUS MANAGER / ADMIN (ROLE MANAGEMENT)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', \App\Http\Middleware\IsAdmin::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/menu', MenuManagement::class)->name('admin.menu');
});

/*
|--------------------------------------------------------------------------
| 4. RUTE PUBLIK / API EXTERNAL (WEBHOOK)
|--------------------------------------------------------------------------
| Diletakkan di luar karena dipanggil otomatis oleh server Midtrans secara online
*/
Route::post('/midtrans/webhook', [OrderController::class, 'handleWebhook']);