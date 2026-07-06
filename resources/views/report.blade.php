<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Burger Kingdom - Laporan &amp; Riwayat Shift</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 text-slate-800 font-sans p-6 md:p-10">

    <div class="max-w-6xl mx-auto space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
            <div>
                <h1 class="text-xl font-black tracking-tight flex items-center gap-2">
                    <i class="fa-solid fa-chart-pie text-amber-600"></i> Dashboard Analisis Restoran
                </h1>
                <p class="text-xs text-slate-400 font-medium mt-1">Pantau performa penjualan produk dan rekonsiliasi keuangan laci kasir.</p>
            </div>
            <a href="/pos" class="inline-flex items-center gap-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs px-4 py-2.5 rounded-xl transition shadow-sm self-start sm:self-center">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Kasir POS
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-5 rounded-2xl border border-slate-200 flex items-center justify-between shadow-xs">
                <div class="space-y-1">
                    <p class="text-[11px] font-bold text-slate-400 uppercase">Total Omset Pendapatan</p>
                    <h3 class="text-xl font-black text-slate-900">Rp {{ number_format($total_pendapatan) }}</h3>
                </div>
                <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center"><i class="fa-solid fa-money-bill-wave text-xl text-emerald-600"></i></div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 flex items-center justify-between shadow-xs">
                <div class="space-y-1">
                    <p class="text-[11px] font-bold text-slate-400 uppercase">Jumlah Nota Terbit</p>
                    <h3 class="text-xl font-black text-slate-900">{{ $total_transaksi }} Transaksi</h3>
                </div>
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center"><i class="fa-solid fa-receipt text-xl text-blue-600"></i></div>
            </div>

            <div class="bg-white p-5 rounded-2xl border border-slate-200 flex items-center justify-between shadow-xs">
                <div class="space-y-1">
                    <p class="text-[11px] font-bold text-slate-400 uppercase">Akumulasi Selisih Laci</p>
                    <h3 class="text-xl font-black {{ $total_selisih < 0 ? 'text-rose-600' : ($total_selisih > 0 ? 'text-blue-600' : 'text-slate-900') }}">
                        {{ $total_selisih < 0 ? '-' : '' }} Rp {{ number_format(abs($total_selisih)) }}
                        <span class="text-[10px] font-bold block mt-0.5 {{ $total_selisih < 0 ? 'text-rose-400' : 'text-slate-400' }}">
                        </span>
                    </h3>
                </div>
                <div class="w-12 h-12 {{ $total_selisih < 0 ? 'bg-rose-50' : 'bg-slate-50' }} rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-calculator-combined text-xl {{ $total_selisih < 0 ? 'text-rose-600' : 'text-slate-500' }}"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
            <div class="p-5 border-b bg-slate-50/50">
                <h2 class="text-sm font-black uppercase tracking-wide flex items-center gap-2">
                    <i class="fa-solid fa-cash-register text-amber-600"></i> Pengawasan Riwayat Tutup Shift &amp; Selisih Uang Laci
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 font-bold border-b border-slate-200">
                            <th class="p-4 w-12 text-center">No</th>
                            <th class="p-4">Waktu Buka Shift</th>
                            <th class="p-4">Waktu Tutup Shift</th>
                            <th class="p-4 text-right">Modal Awal</th>
                            <th class="p-4 text-right">Omset Tunai Sistem</th>
                            <th class="p-4 text-right">Uang Fisik Terhitung</th>
                            <th class="p-4 text-center">Status Selisih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($shifts as $index => $shift)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-4 text-center text-slate-400 font-bold">{{ $index + 1 }}</td>
                            <td class="p-4 font-semibold">{{ date('d M Y, H:i', strtotime($shift->opened_at)) }} WIB</td>
                            <td class="p-4 text-slate-500">
                                {{ $shift->closed_at ? date('d M Y, H:i', strtotime($shift->closed_at)) . ' WIB' : 'Sedang Aktif (Berjalan)' }}
                            </td>
                            <td class="p-4 text-right">Rp {{ number_format($shift->modal_awal) }}</td>
                            <td class="p-4 text-right text-slate-600">Rp {{ number_format($shift->total_tunai) }}</td>
                            <td class="p-4 text-right font-bold">
                                {{ $shift->closed_at ? 'Rp ' . number_format($shift->uang_fisik) : '-' }}
                            </td>
                            <td class="p-4 text-center">
                                @if(!$shift->closed_at)
                                    <span class="px-2.5 py-1 bg-amber-50 text-amber-700 rounded-lg text-[10px] font-black uppercase">Shift Berjalan</span>
                                @elseif($shift->selisih == 0)
                                    <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-lg text-[10px] font-black uppercase"><i class="fa-solid fa-check-double mr-1"></i> Cocok</span>
                                @elseif($shift->selisih < 0)
                                    <span class="px-2.5 py-1 bg-rose-50 text-rose-700 rounded-lg text-[10px] font-black uppercase">
                                        <i class="fa-solid fa-triangle-exclamation mr-1"></i> Minus {{ number_format(abs($shift->selisih)) }}
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 bg-blue-50 text-blue-700 rounded-lg text-[10px] font-black uppercase">
                                        +{{ number_format($shift->selisih) }} (Lebih)
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400 font-medium">Belum ada riwayat shift register kasir yang tercatat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
            <div class="p-5 border-b bg-slate-50/50">
                <h2 class="text-sm font-black uppercase tracking-wide flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-slate-600"></i> Riwayat Nota Transaksi Penjualan Masuk
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 font-bold border-b border-slate-200">
                            <th class="p-4">Nomor Nota</th>
                            <th class="p-4">Tanggal Nota</th>
                            <th class="p-4">Tipe Service</th>
                            <th class="p-4">Metode Bayar</th>
                            <th class="p-4 text-right">Potongan</th>
                            <th class="p-4 text-right">Pajak Resto</th>
                            <th class="p-4 text-right">Total Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="p-4 font-black text-slate-900 tracking-tight">{{ $order->order_number }}</td>
                            <td class="p-4 text-slate-500">{{ date('d M Y, H:i', strtotime($order->created_at)) }} WIB</td>
                            <td class="p-4">
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase {{ $order->order_type == 'Dine-In' ? 'bg-slate-100 text-slate-700' : 'bg-orange-50 text-orange-700' }}">
                                    {{ $order->order_type }}
                                </span>
                            </td>
                            <td class="p-4 font-bold uppercase text-slate-600">{{ $order->payment_method }}</td>
                            <td class="p-4 text-right text-rose-600">Rp {{ number_format($order->discount_amount) }}</td>
                            <td class="p-4 text-right text-slate-500">Rp {{ number_format($order->tax_amount) }}</td>
                            <td class="p-4 text-right font-black text-amber-700 text-sm">Rp {{ number_format($order->total_amount) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-slate-400 font-medium">Belum ada data nota penjualan masuk hari ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>