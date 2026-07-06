<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - Burger Kingdom POS</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 h-screen flex items-center justify-center relative select-none">

    <div class="absolute top-10 right-16 text-slate-200/40 text-[180px] pointer-events-none hidden md:block">
        <i class="fa-solid fa-lock-open"></i>
    </div>
    <div class="absolute bottom-10 left-16 text-slate-200/40 text-[180px] pointer-events-none hidden md:block">
        <i class="fa-solid fa-key"></i>
    </div>

    <div class="bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-sm w-full overflow-hidden transition-all duration-300">
        <div class="p-8 text-center">
            
            <div class="w-12 h-12 bg-orange-50 rounded-2xl flex items-center justify-center shadow-xs mx-auto mb-4">
                <i class="fa-solid fa-shield-halved text-2xl text-[#e67e22]"></i>
            </div>
            
            <h1 class="text-xl font-black text-slate-800 tracking-tight mb-1">Pemulihan Kata Sandi</h1>
            <p class="text-xs font-medium text-slate-400 px-2 mb-6">Masukkan email terdaftar Anda. Setelah memvalidasi, sistem akan mengarahkan Anda kembali ke halaman utama.</p>

            <form action="/" method="GET" class="space-y-4" onsubmit="alert('Permintaan pemulihan telah diproses! Mengonfirmasi kembali ke halaman utama.');">
                
                <div class="relative text-left">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-envelope text-sm"></i>
                    </span>
                    <input type="email" required 
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-[#e67e22] focus:ring-4 focus:ring-orange-500/10 transition-all text-slate-700 font-medium" 
                        placeholder="Masukkan email terdaftar...">
                </div>

                <button type="submit" 
                    class="w-full bg-[#e67e22] hover:bg-[#d35400] text-white font-black py-3.5 px-4 rounded-xl shadow-lg shadow-orange-500/10 hover:shadow-orange-500/20 active:scale-[0.98] transition-all text-sm uppercase tracking-wider cursor-pointer mt-2">
                    Validasi Akun Kasir
                </button>
            </form>
        </div>

        <div class="bg-slate-50/80 px-8 py-4 border-t border-slate-100 text-center">
            <a href="/" class="text-xs font-black text-[#b87333] hover:text-[#d35400] transition-all inline-flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Halaman Login
            </a>
        </div>
    </div>

</body>
</html>