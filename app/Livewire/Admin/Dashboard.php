<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    public function render()
    {
        // Hitung total uang masuk dari pesanan yang sukses (settlement)
        $totalPendapatan = DB::table('orders')->where('status', 'settlement')->sum('total_price');
        
        // Hitung total transaksi sukses
        $totalTransaksi = DB::table('orders')->where('status', 'settlement')->count();

        return view('livewire.admin.dashboard', [
            'totalPendapatan' => $totalPendapatan,
            'totalTransaksi' => $totalTransaksi
        ])->layout('layouts.app');
    }
}