<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// 1. Tampilan Pertama: Halaman Login Kasir
Route::get('/', function () {
    return view('login');
})->name('login');
Route::get('/forgot-password', function () {
    return view('forgot-password');
});

Route::get('/pos', [OrderController::class, 'index'])->name('pos.index');
Route::post('/order/payment', [OrderController::class, 'prosesPembayaran'])->name('order.payment');
Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
Route::get('/report', [ReportController::class, 'index'])->name('report');
Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
Route::post('/order/kitchen', [OrderController::class, 'sendToKitchen'])->name('order.kitchen');
Route::post('/midtrans/webhook', [OrderController::class, 'handleWebhook']);
Route::get('/order/status/{order_id}', [OrderController::class, 'checkOrderStatus']);
Route::get('/register/check', [OrderController::class, 'checkRegister']);
Route::post('/register/open', [OrderController::class, 'openRegister']);
Route::get('/register/preview', [OrderController::class, 'previewCloseRegister']);
Route::post('/register/close', [OrderController::class, 'closeRegister']);
Route::get('/report', [ReportController::class, 'index'])->name('report');
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'checkEmail'])->name('password.email');

Route::get('/reset-password/{email}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'updatePassword'])->name('password.update');