<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi - Burger Kingdom POS</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 h-screen flex items-center justify-center relative select-none">

    <div class="bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-sm w-full overflow-hidden">
        <div class="p-8 text-center">
            <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center shadow-xs mx-auto mb-4">
                <i class="fa-solid fa-key text-2xl text-emerald-600"></i>
            </div>
            
            <h1 class="text-xl font-black text-slate-800 tracking-tight mb-1">Kata Sandi Baru</h1>
            <p class="text-xs font-medium text-slate-400 mb-6">Silakan buat kata sandi baru untuk mengamankan akun terminal kasir Anda.</p>

            @if ($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-600 text-xs p-3 rounded-xl mb-4 font-bold text-left">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf
                <!-- Hidden Input Email otomatis terisi -->
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- Input Password Baru -->
                <div class="relative text-left">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </span>
                    <input type="password" name="password" required 
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all text-slate-700 font-medium" 
                        placeholder="Ketik kata sandi baru...">
                </div>

                <!-- Konfirmasi Password Baru -->
                <div class="relative text-left">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-check-double text-sm"></i>
                    </span>
                    <input type="password" name="password_confirmation" required 
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all text-slate-700 font-medium" 
                        placeholder="Ulangi kata sandi baru...">
                </div>

                <button type="submit" 
                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-black py-3.5 px-4 rounded-xl shadow-lg shadow-emerald-500/10 transition-all text-sm uppercase tracking-wider cursor-pointer mt-2">
                    Simpan Kata Sandi Baru
                </button>
            </form>
        </div>
    </div>

</body>
</html>