<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Mengambil riwayat nota transaksi penjualan seperti biasa
        $orders = DB::table('orders')->orderBy('created_at', 'desc')->get();
        
        // 2. Menghitung ringkasan statistik total omset penjualan berjalan
        $total_pendapatan = DB::table('orders')->sum('total_amount');
        $total_transaksi = DB::table('orders')->count();

        // 🔥 FITUR BARU: Mengambil riwayat buka/tutup laci kasir beserta selisih minusnya
        $shifts = DB::table('cash_registers')->orderBy('created_at', 'desc')->get();
        
        // Menghitung total teakor/selisih kumulatif untuk ringkasan owner
        $total_selisih = DB::table('cash_registers')->sum('selisih');

        return view('report', compact('orders', 'total_pendapatan', 'total_transaksi', 'shifts', 'total_selisih'));
    }
}