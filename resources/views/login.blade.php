<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Burger Kingdom POS</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 h-screen flex items-center justify-center relative select-none">

    <div class="absolute top-10 right-16 text-slate-200/40 text-[180px] pointer-events-none hidden md:block">
        <i class="fa-solid fa-utensils"></i>
    </div>
    <div class="absolute bottom-10 left-16 text-slate-200/40 text-[180px] pointer-events-none hidden md:block">
        <i class="fa-solid fa-burger"></i>
    </div>

    <div class="bg-white rounded-3xl shadow-2xl border border-slate-100 max-w-sm w-full overflow-hidden transition-all duration-300 hover:shadow-orange-900/5">
        <div class="p-8 text-center">
            
            <div class="flex items-center justify-center gap-3 mb-2">
                <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center shadow-xs">
                    <i class="fa-solid fa-hamburger text-2xl text-[#e67e22]"></i>
                </div>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">Burger Kingdom</h1>
            </div>
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-8">POS Terminal Station 01</p>

            <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
                @csrf <div class="space-y-1">
                    <div class="relative text-left">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required 
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 border @error('email') border-red-500 focus:border-red-500 focus:ring-red-500/10 @else border-slate-200 focus:border-[#e67e22] focus:ring-orange-500/10 @enderror rounded-xl text-sm focus:outline-none focus:bg-white focus:ring-4 transition-all text-slate-700 font-medium" 
                            placeholder="Alamat email kasir...">
                    </div>
                    @error('email')
                        <p class="text-left text-xs font-bold text-red-500 pl-1">
                            <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="relative text-left">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </span>
                    <input type="password" name="password" required 
                        class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:bg-white focus:border-[#e67e22] focus:ring-4 focus:ring-orange-500/10 transition-all text-slate-700 font-medium" 
                        placeholder="Kata sandi akun...">
                </div>

                <button type="submit" 
                    class="w-full bg-[#e67e22] hover:bg-[#d35400] text-white font-black py-3.5 px-4 rounded-xl shadow-lg shadow-orange-500/10 hover:shadow-orange-500/20 active:scale-[0.98] transition-all text-sm uppercase tracking-wider cursor-pointer mt-2">
                    Masuk Ke Sistem <i class="fa-solid fa-arrow-right ml-1 text-xs"></i>
                </button>
            </form>
        </div>

        <div class="bg-slate-50/80 px-8 py-5 border-t border-slate-100 text-center space-y-2">
            <a href="{{ route('password.request') }}" class="text-xs font-bold text-[#b87333] hover:text-[#d35400] hover:underline transition-all block">Lupa Kata Sandi?</a>
            <div class="border-b border-dashed border-slate-200 my-1"></div>
            <p class="text-[11px] text-slate-400 font-semibold tracking-wide">
                <i class="fa-solid fa-headset mr-1 text-orange-400"></i> Butuh bantuan teknis? Hubungi IT Support
            </p>
        </div>
    </div>

</body>
</html>