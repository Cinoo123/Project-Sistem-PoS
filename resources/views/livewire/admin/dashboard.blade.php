<div class="p-6 max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard Admin Burger Kingdom</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl p-6 shadow-lg border-b-4 border-green-700">
            <p class="text-sm font-medium uppercase tracking-wider opacity-90">Total Pendapatan (Midtrans)</p>
            <h3 class="text-3xl font-bold mt-2">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
        </div>

        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl p-6 shadow-lg border-b-4 border-blue-700">
            <p class="text-sm font-medium uppercase tracking-wider opacity-90">Pesanan Sukses</p>
            <h3 class="text-3xl font-bold mt-2">{{ $totalTransaksi }} Transaksi</h3>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-md border border-gray-100 flex justify-between items-center">
        <div>
            <h4 class="text-lg font-bold text-gray-700">Manajemen Data Restoran</h4>
            <p class="text-sm text-gray-500 mt-1">Tambah menu burger baru atau hapus makanan yang sudah tidak dijual.</p>
        </div>
        <a href="{{ route('admin.menu') }}" class="bg-yellow-500 text-white px-5 py-3 rounded-xl font-bold hover:bg-yellow-600 transition shadow">
            ➡️ Kelola Menu Makanan
        </a>
    </div>
</div>