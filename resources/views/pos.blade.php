<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Burger Kingdom POS - Ultimate Premium Final</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        html, html[data-theme="light"] {
            --bg-main: #f0f2f5;
            --bg-card: #ffffff;
            --bg-nested: #f8fafc;
            --border-color: #e2e8f0;
            --icon-color: #8b5a2b;
            --text-color: #1e293b;
            --text-muted: #64748b;
            --bg-modal-box: #ffffff;
            --bg-small-btn: #ffffff;
            --text-small-btn: #1e293b;
            --bg-discount-inactive: #ffffff;
            --bg-pay-disabled: #e2e8f0;
            --text-pay-disabled: #94a3b8;
            --qr-modal-header: linear-gradient(135deg, #f5efe6 0%, #e8dec9 100%);
            --qr-border: #8b5a2b;
            color-scheme: light;
        }
        
        html, html[data-theme="light"] * {
            color: #1e293b !important;
        }
        
        html, html[data-theme="light"] .bg-[#c0392b], html, html[data-theme="light"] .bg-[#c0392b] *,
        html, html[data-theme="light"] .bg-[#e67e22], html, html[data-theme="light"] .bg-[#e67e22] *, 
        html, html[data-theme="light"] .bg-[#2980b9], html, html[data-theme="light"] .bg-[#2980b9] *, 
        html, html[data-theme="light"] .bg-[#2ecc71], html, html[data-theme="light"] .bg-[#2ecc71] *,
        html, html[data-theme="light"] .bg-[#27ae60], html, html[data-theme="light"] .bg-[#27ae60] *,
        html, html[data-theme="light"] .bg-amber-600, html, html[data-theme="light"] .bg-amber-600 *,
        html, html[data-theme="light"] .bg-[#8b5a2b], html, html[data-theme="light"] .bg-[#8b5a2b] *,
        html, html[data-theme="light"] .btn-qty-plus-fixed, html, html[data-theme="light"] .btn-qty-plus-fixed * {
            color: #ffffff !important;
        }

        html.dark, html[data-theme="dark"] {
            --bg-main: #121212;
            --bg-card: #1e1e1e;
            --bg-nested: #2d2d2d;
            --border-color: #27272a;
            --icon-color: #f59e0b;
            --text-color: #f4f4f5;
            --text-muted: #a1a1aa;
            --bg-modal-box: #1e1e1e;
            --bg-small-btn: #2d2d2d;
            --text-small-btn: #f4f4f5;
            --bg-discount-inactive: #2d2d2d;
            --bg-pay-disabled: #27272a;
            --text-pay-disabled: #52525b;
            --qr-modal-header: linear-gradient(135deg, #3d2a1c 0%, #1e1e1e 100%);
            --qr-border: #f59e0b;
            color-scheme: dark;
        }
        html.dark *, html[data-theme="dark"] * {
            color: #f4f4f5 !important;
        }
        html.dark p, html[data-theme="dark"] p {
            color: #a1a1aa !important;
        }

        body { background-color: var(--bg-main) !important; }
        aside, header, .menu-item, .custom-sidebar, .custom-header, .custom-panel, .modal-box-theme { 
            background-color: var(--bg-card) !important; 
            border-color: var(--border-color) !important;
            border-style: solid;
        }
        .bg-slate-50, #cart-items-container input, .bg-slate-100 { background-color: var(--bg-nested) !important; }
        .border-slate-200, .border-slate-100, .border-b, .border-t, .border-l, .border-r { border-color: var(--border-color) !important; }
        
        .fa-burger, .fa-drumstick-bite, .fa-box, .fa-cookie, .fa-glass-water-droplet, .fa-hamburger { color: var(--icon-color) !important; }
        .discount-btn-fixed { background-color: var(--bg-discount-inactive) !important; border-color: var(--border-color) !important; }
        .btn-pay-disabled-fixed { background-color: var(--bg-pay-disabled) !important; border-color: var(--border-color) !important; }
        .btn-pay-disabled-fixed * { color: var(--text-pay-disabled) !important; }

        .cart-qty-container {
            background-color: var(--bg-card) !important;
            border: 1px solid var(--border-color) !important;
            display: flex; align-items: center; gap: 0.375rem; padding: 0.125rem; border-radius: 0.5rem;
        }
        .btn-qty-minus-fixed {
            background-color: var(--bg-small-btn) !important; border: 1px solid var(--border-color) !important;
            color: var(--text-small-btn) !important; width: 1.25rem; height: 1.25rem; border-radius: 0.375rem;
            font-size: 10px; font-weight: 700; display: flex; align-items: center; justify-content: center; cursor: pointer;
        }
        .btn-qty-plus-fixed {
            background-color: #2ecc71 !important; border: 1px solid #27ae60 !important; color: #ffffff !important;
            width: 1.25rem; height: 1.25rem; border-radius: 0.375rem; font-size: 10px; font-weight: 700;
            display: flex; align-items: center; justify-content: center; cursor: pointer;
        }
        .method-btn-fixed {
            background-color: var(--bg-card) !important; border: 2px solid var(--border-color) !important;
            color: var(--text-color) !important; font-weight: 700; font-size: 0.75rem; padding: 0.6rem 0;
            border-radius: 0.5rem; text-align: center; text-transform: uppercase; width: 100%; cursor: pointer;
        }
        .order-type-btn-fixed {
            background-color: var(--bg-card) !important; border: 2px solid var(--border-color) !important;
            color: var(--text-color) !important; flex: 1 1 0%; padding: 0.5rem 0; border-radius: 0.5rem;
            font-weight: 700; font-size: 0.75rem; text-transform: uppercase; cursor: pointer;
        }
        .cash-calculator-fixed { background-color: var(--bg-card) !important; border: 1px solid var(--border-color) !important; padding: 0.625rem !important; border-radius: 0.75rem !important; }
        .cash-calculator-fixed input { background-color: var(--bg-nested) !important; border: 1px solid var(--border-color) !important; color: var(--text-color) !important; }

        /* FIX PENAMPILAN TOMBOL TUTUP KASIR KONTRAST DI MODE GELAP */
        .btn-close-shift {
            background-color: #fff1f2 !important;
            border: 1px solid #fecdd3 !important;
        }
        .btn-close-shift, .btn-close-shift * {
            color: #be123c !important;
        }
        html.dark .btn-close-shift, html[data-theme="dark"] .btn-close-shift {
            background-color: #4c0519 !important;
            border: 1px solid #9f1239 !important;
        }
        html.dark .btn-close-shift, html.dark .btn-close-shift *,
        html[data-theme="dark"] .btn-close-shift, html[data-theme="dark"] .btn-close-shift * {
            color: #fda4af !important;
        }

        /* FIX WARNA TOMBOL NAVIGASI SIDEBAR SECARA SPESIFIK AGAR KELIHATAN DI MODE GELAP */
        .category-nav-btn {
            background-color: transparent !important;
            border: 1px solid transparent !important;
        }
        .category-nav-btn, .category-nav-btn * {
            color: #64748b !important;
        }
        html.dark .category-nav-btn, html.dark .category-nav-btn * {
            color: #a1a1aa !important;
        }
        
        .category-nav-btn.active-btn-style {
            background-color: #f5efe6 !important;
            border: 1px solid #e8dec9 !important;
        }
        .category-nav-btn.active-btn-style, .category-nav-btn.active-btn-style * {
            color: #8b5a2b !important;
            font-weight: 800 !important;
        }
        html.dark .category-nav-btn.active-btn-style {
            background-color: #3d2a1c !important;
            border: 1px solid #5c3e2e !important;
        }
        html.dark .category-nav-btn.active-btn-style, html.dark .category-nav-btn.active-btn-style * {
            color: #f59e0b !important;
            font-weight: 800 !important;
        }

        /* MODAL QRIS ULTRA AESTHETIC & MODERN */
        #qris-modal { 
            background-color: rgba(15, 23, 42, 0.4) !important; 
            backdrop-filter: blur(12px) !important; 
            display: none; 
            align-items: center; 
            justify-content: center; 
        }
        #qris-modal-box { 
            background-color: var(--bg-modal-box) !important; 
            border-radius: 28px !important; 
            border: 1px solid var(--border-color) !important; 
            max-width: 380px !important; 
            width: 100% !important; 
            overflow: hidden; 
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
            animation: modalScaleIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        #qris-modal-box .premium-header { 
            background: transparent !important; 
            padding: 32px 24px 12px 24px !important; 
            border-bottom: none !important; 
            text-align: center; 
        }
        #qris-modal-box .premium-header i {
            color: #d97706 !important;
            background-color: #fef3c7 !important;
            padding: 16px;
            border-radius: 50%;
            margin-bottom: 12px;
            display: inline-block;
        }
        html.dark #qris-modal-box .premium-header i {
            background-color: #78350f !important;
            color: #fbbf24 !important;
        }
        #qris-modal-box h3.text-lg {
            font-size: 1.25rem !important;
            font-weight: 800 !important;
            letter-spacing: -0.025em;
            margin-bottom: 4px !important;
        }
        #qris-modal-box .premium-header p {
            font-size: 0.75rem !important;
            color: var(--text-muted) !important;
        }
        #qris-modal-box .modal-body { 
            padding: 12px 32px 32px 32px !important; 
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
        }
        #qr-amount-display { 
            font-size: 2rem !important; 
            font-weight: 900 !important; 
            color: var(--text-color) !important; 
            letter-spacing: -0.04em;
            margin-bottom: 24px !important; 
            display: block; 
        }
        #qris-container { 
            background-color: #ffffff !important; 
            padding: 16px !important; 
            border-radius: 24px !important; 
            border: 1px solid #e2e8f0 !important; 
            width: 230px !important; 
            height: 230px !important; 
            margin: 0 auto 28px auto !important; 
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            overflow: hidden;
        }
        #qris-container img { 
            width: 100% !important; 
            height: 100% !important; 
            display: block !important; 
            object-fit: contain !important; 
            transform: none !important;
        }
        #qris-modal-box button {
            border-radius: 14px !important;
            font-weight: 700 !important;
        }

        @keyframes modalScaleIn {
            0% { transform: scale(0.95); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }

        @media print {
            body * { visibility: hidden; }
            #receipt-print-area, #receipt-print-area * { visibility: visible; }
            #receipt-print-area { position: absolute; left: 0; top: 0; width: 80mm; font-family: monospace; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body class="font-sans h-screen flex overflow-hidden select-none transition-colors duration-200">

    <aside class="w-64 border-r flex flex-col justify-between shrink-0 custom-sidebar">
        <div>
            <div class="p-6 text-center border-b">
                <div class="w-16 h-16 bg-slate-100 border rounded-2xl mx-auto flex items-center justify-center shadow-xs mb-3">
                    <i class="fa-solid fa-hamburger text-3xl"></i>
                </div>
                <h1 class="text-xl font-black tracking-tight">Burger Kingdom</h1>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-0.5">Makanan Cepat Saji</p>
            </div>
            <nav class="p-4 space-y-2">
                <button onclick="filterCategory('burger')" id="nav-all" class="category-nav-btn active-btn-style w-full flex items-center gap-3 px-4 py-3 font-bold rounded-xl transition-all cursor-pointer">
                    <i class="fa-solid fa-utensils text-lg"></i>
                    <span>MENU MAKANAN</span>
                </button>
                <button onclick="filterCategory('drinks')" id="nav-drinks" class="category-nav-btn w-full flex items-center gap-3 px-4 py-3 font-semibold rounded-xl transition-all cursor-pointer">
                    <i class="fa-solid fa-glass-water text-lg"></i>
                    <span>MINUMAN</span>
                </button>
            </nav>
        </div>
        <div class="p-4 border-t">
            <button onclick="window.location.href='/'" class="w-full flex items-center gap-3 px-4 py-3 text-rose-600 font-bold rounded-xl transition-all cursor-pointer">
                <i class="fa-solid fa-right-from-bracket text-lg" style="color: #e11d48 !important;"></i>
                <span style="color: #e11d48 !important;">LOGOUT</span>
            </button>
        </div>
    </aside>

    <main class="flex-1 flex flex-col overflow-hidden">
        <header class="border-b px-8 py-4 flex items-center justify-between shrink-0 custom-header">
            <h2 class="text-lg font-bold" id="category-title">Menu Makanan</h2>
            <div class="flex items-center gap-4">
                <button onclick="toggleDarkMode()" class="w-10 h-10 bg-slate-100 dark:bg-zinc-800 hover:bg-slate-200 dark:hover:bg-zinc-700 rounded-xl flex items-center justify-center transition-all shadow-xs cursor-pointer">
                    <i id="theme-icon" class="fa-solid fa-moon text-lg"></i>
                </button>
                
                <a href="/report" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs px-4 py-2 rounded-xl border border-slate-200 transition flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-amber-500"></i> Lihat Riwayat Laporan
                </a>

                <button onclick="openCloseRegisterModal()" class="btn-close-shift font-black text-xs px-4 py-2 rounded-xl transition flex items-center gap-2 cursor-pointer shadow-xs">
                    <i class="fa-solid fa-store-slash"></i> Tutup Kasir (Close Shift)
                </button>

                <div class="relative w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </span>
                    <input type="text" id="search-input" onkeyup="searchMenu()" class="w-full pl-9 pr-4 py-2 bg-slate-100 border border-transparent rounded-xl text-sm focus:outline-none focus:bg-white transition-all" placeholder="Cari menu...">
                </div>
            </div>
        </header>

        <div class="flex-1 p-6 overflow-y-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" id="menu-grid">
                @foreach($menus as $menu)
                <div onclick="openModifierModal({{ $menu->id }}, '{{ $menu->name }}', {{ $menu->price }}, {{ $menu->stock }}, '{{ $menu->category }}')" 
                     class="menu-item border rounded-xl shadow-xs flex flex-col justify-between relative transition-colors duration-200 cursor-pointer overflow-hidden
                     {{ $menu->stock <= 0 ? 'opacity-50 grayscale cursor-not-allowed' : '' }}" 
                     data-category="{{ $menu->category }}" data-name="{{ $menu->name }}">
                    @if($menu->stock <= 0)
                        <div class="absolute inset-0 flex items-center justify-center bg-black/50 text-white font-black z-10">HABIS</div>
                    @endif
                    
                    <div>
                        <div class="w-full aspect-square bg-transparent flex items-center justify-center overflow-hidden">
                            @if($menu->image)
                                <img src="{{ asset('images/' . $menu->image) }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105" alt="{{ $menu->name }}">
                            @else
                                <div class="w-full h-full bg-slate-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <i class="fa-solid fa-utensils text-4xl text-slate-300 dark:text-zinc-600"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-3 pb-1">
                            <h3 class="font-bold text-xs truncate">{{ $menu->name }}</h3>
                            <p class="text-xs font-bold mt-0.5" style="color: #b87333 !important;">Rp {{ number_format($menu->price) }}</p>
                            <p class="text-[9px] text-slate-400">Stok: {{ $menu->stock }}</p>
                        </div>
                    </div>
                    
                    <div class="px-3 pb-3">
                        <div class="text-center text-[10px] bg-slate-50 p-1 rounded-md border mt-1 font-bold text-slate-500">Klik Kustomisasi</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>

    <aside class="w-[420px] border-l flex flex-col overflow-hidden shrink-0 custom-panel">
        <div class="p-3 border-b flex gap-2 bg-slate-50 dark:bg-zinc-900/40">
            <button onclick="setOrderType('Dine-In')" id="type-dine-in" class="order-type-btn-fixed" style="border-color: #b87333 !important; background-color: #f5efe6 !important; color: #8b5a2b !important;">Makan Di Sini</button>
            <button onclick="setOrderType('Take-Away')" id="type-take-away" class="order-type-btn-fixed">Bawa Pulang</button>
        </div>

        <div class="p-3 border-b flex justify-between items-center">
            <h3 class="text-xs font-black uppercase tracking-wide">Daftar Item Belanja</h3>
            <p class="text-[10px] text-slate-400 font-bold"><i class="fa-solid fa-receipt mr-1"></i> Order #84920</p>
        </div>

        <div class="px-4 py-2 mx-3 mt-3 bg-amber-50 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-900/50 rounded-xl flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-folder-open text-amber-600 dark:text-amber-400"></i>
                <span class="text-xs font-bold text-amber-800 dark:text-amber-300">Nota Ditahan: <span id="held-count" class="font-black text-sm text-amber-600 dark:text-amber-400">0</span></span>
            </div>
            <button onclick="openRecallModal()" class="bg-amber-600 hover:bg-amber-700 text-white font-bold text-[10px] px-3 py-1.5 rounded-lg transition shadow-xs cursor-pointer">Panggil Nota</button>
        </div>

        <div class="flex-1 p-4 overflow-y-auto space-y-4" id="cart-items-container">
            <div id="cart-empty" class="h-full flex flex-col items-center justify-center py-20">
                <i class="fa-solid fa-basket-shopping text-5xl text-slate-200 dark:text-zinc-700 mb-2"></i>
                <p class="text-sm font-medium text-slate-400">Belum ada item pesanan.</p>
            </div>
        </div>

        <div class="px-4 pt-2 flex items-center justify-between gap-1 border-t">
            <span class="text-xs font-bold text-slate-500">Pilih Promo Diskon:</span>
            <div class="flex gap-1">
                <button onclick="applyDiscount(0)" id="disc-0" class="px-2.5 py-1 text-[10px] font-bold border rounded bg-[#f5efe6] border-[#b87333] text-[#8b5a2b] cursor-pointer">0%</button>
                <button onclick="applyDiscount(10)" id="disc-10" class="discount-btn-fixed px-2.5 py-1 text-[10px] font-bold border rounded border-slate-200 dark:border-zinc-700 cursor-pointer">10%</button>
                <button onclick="applyDiscount(20)" id="disc-20" class="discount-btn-fixed px-2.5 py-1 text-[10px] font-bold border rounded border-slate-200 dark:border-zinc-700 cursor-pointer">20%</button>
            </div>
        </div>

        <div class="p-4 bg-slate-50 space-y-3">
            <div class="space-y-1.5 px-1 text-sm font-semibold">
                <div class="flex justify-between"><span>Subtotal:</span><span id="summary-subtotal">Rp 0</span></div>
                <div class="flex justify-between text-rose-600 font-bold"><span>Potongan Diskon:</span><span id="summary-discount">- Rp 0</span></div>
                <div class="flex justify-between"><span>Pajak Resto (10%):</span><span id="summary-tax">Rp 0</span></div>
                <div class="flex justify-between text-base font-black pt-2 border-t"><span>Total Tagihan:</span><span id="summary-total" class="text-xl" style="color: #b87333 !important;">Rp 0</span></div>
            </div>

            <div id="cash-calculator-row" class="hidden cash-calculator-fixed space-y-2">
                <div class="flex items-center justify-between">
                    <label class="text-xs font-bold text-slate-500">Uang Tunai Diterima:</label>
                    <input type="number" id="cash-received-input" onkeyup="calculateChange()" class="w-32 text-right text-xs font-bold p-1.5 rounded-lg focus:outline-none" placeholder="Masukkan Rp...">
                </div>
                <div class="flex justify-between items-center text-xs font-black pt-1.5 border-t border-slate-100 border-dashed"><span>Kembalian Kasir:</span><span id="cash-change-display" class="text-green-600 font-black">Rp 0</span></div>
            </div>

            <div class="grid grid-cols-4 gap-2 text-white-force">
                <button onclick="clearCart()" class="bg-[#c0392b] text-white font-bold text-xs py-3 rounded-lg hover:bg-[#a93226] uppercase text-center cursor-pointer">Batalkan</button>
                <button onclick="holdOrder()" class="bg-[#e67e22] text-white font-bold text-xs py-3 rounded-lg hover:bg-[#d35400] uppercase text-center cursor-pointer">Tahan</button>
                <button onclick="sendToKitchen()" class="bg-[#2980b9] text-white font-bold text-xs py-3 rounded-lg hover:bg-[#2471a3] uppercase text-center cursor-pointer">Ke Dapur</button>
                <button onclick="triggerPayment()" id="btn-bayar-utama" disabled class="btn-pay-disabled-fixed text-slate-500 font-black text-sm py-3 rounded-lg uppercase text-center cursor-not-allowed">Bayar</button>
            </div>

            <div class="grid grid-cols-3 gap-2 pt-1">
                <button onclick="selectMethod('tunai')" id="pay-tunai" class="method-btn-fixed">Tunai</button>
                <button onclick="selectMethod('kartu')" id="pay-kartu" class="method-btn-fixed">Kartu</button>
                <button onclick="selectMethod('qris')" id="pay-qris" class="method-btn-fixed">QRIS/E-Wallet</button>
            </div>
        </div>
    </aside>

    <div id="modifier-modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center p-4 z-50">
        <div class="modal-box-theme rounded-2xl max-w-sm w-full p-6 space-y-4 shadow-xl">
            <h3 id="mod-title" class="text-base font-black text-slate-800">Kustomisasi Menu</h3>
            <div class="border-b pb-2">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Pilih Ukuran (*Size)</p>
                <div class="flex gap-2">
                    <label class="flex-1 flex items-center justify-between p-2 border rounded-xl bg-slate-50 cursor-pointer text-xs font-semibold">
                        <span class="flex items-center gap-2"><input type="radio" name="item-size" value="Reguler" checked onclick="setModSize(0)"> Reguler</span>
                        <span>Normal</span>
                    </label>
                    <label class="flex-1 flex items-center justify-between p-2 border rounded-xl bg-slate-50 cursor-pointer text-xs font-semibold">
                        <span class="flex items-center gap-2"><input type="radio" name="item-size" value="Large" onclick="setModSize(15000)"> Large</span>
                        <span class="text-amber-600 font-bold">+15k</span>
                    </label>
                </div>
            </div>
            <div id="addon-section" class="border-b pb-3">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Pilihan Kustomisasi</p>
                <div id="burger-addons" class="space-y-2">
                    <label class="flex items-center justify-between p-2 border rounded-xl bg-slate-50 cursor-pointer text-xs font-semibold">
                        <span class="flex items-center gap-2"><input type="checkbox" id="addon-cheese" value="5000"> Ekstra Keju Mulur</span>
                        <span class="text-amber-600 font-bold">+5k</span>
                    </label>
                    <label class="flex items-center justify-between p-2 border rounded-xl bg-slate-50 cursor-pointer text-xs font-semibold">
                        <span class="flex items-center gap-2"><input type="checkbox" id="addon-meat" value="15000"> Ekstra Daging Sapi</span>
                        <span class="text-amber-600 font-bold">+15k</span>
                    </label>
                </div>
                <div id="drink-addons" class="space-y-2 hidden">
                    <label class="flex items-center justify-between p-2 border rounded-xl bg-slate-50 cursor-pointer text-xs font-semibold">
                        <span class="flex items-center gap-2"><input type="checkbox" id="addon-sugar" value="0"> Kurangi Gula (Less Sugar)</span>
                    </label>
                    <label class="flex items-center justify-between p-2 border rounded-xl bg-slate-50 cursor-pointer text-xs font-semibold">
                        <span class="flex items-center gap-2"><input type="checkbox" id="addon-jelly" value="3000"> Tambah Jelly</span>
                        <span class="text-amber-600 font-bold">+3k</span>
                    </label>
                </div>
            </div>
            <div class="flex gap-2 text-white-force pt-1">
                <button onclick="closeModifierModal()" class="flex-1 bg-slate-400 hover:bg-slate-500 font-bold py-2 rounded-xl text-xs cursor-pointer">Batal</button>
                <button onclick="confirmAddToCart()" class="flex-1 bg-amber-500 hover:bg-amber-600 font-black py-2 rounded-xl text-xs cursor-pointer">Masukkan Keranjang</button>
            </div>
        </div>
    </div>

    <div id="qris-modal" style="display: none;" class="fixed inset-0 p-4 z-50">
        <div id="qris-modal-box">
            <div class="premium-header">
                <i class="fa-solid fa-qrcode text-2xl"></i>
                <h3 class="text-lg">Scan QRIS Midtrans</h3>
                <p>Selesaikan pembayaran digital pelanggan Anda</p>
            </div>
            <div class="modal-body">
                <span id="qr-amount-display">Rp 0</span>
                <div id="qris-container"></div>
                <div class="w-full flex gap-3 text-white-force">
                    <button onclick="closeModal()" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-zinc-800 dark:hover:bg-zinc-700 dark:text-zinc-300 font-bold py-3 text-xs transition-all cursor-pointer">Tutup</button>
                    <button onclick="bypassQrisSuccess()" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-black py-3 text-xs transition-all cursor-pointer shadow-md shadow-emerald-600/10 text-white-force">Simulasi Lunas</button>
                </div>
            </div>
        </div>
    </div>

    <div id="receipt-modal" class="fixed inset-0 bg-black/60 hidden items-center justify-center p-4 z-50 overflow-y-auto">
        <div class="bg-white text-black p-6 rounded-xl max-w-xs w-full shadow-2xl space-y-4 modal-box-theme" style="color: #000000 !important;">
            <div id="receipt-print-area" class="text-left space-y-3 text-xs font-mono" style="color: #000000 !important; font-family: monospace;">
                <div class="text-center space-y-0.5">
                    <h4 class="text-sm font-bold uppercase">BURGER KINGDOM</h4>
                    <p class="text-[10px]">Jl. Magelang No. 1, Jogja</p>
                    <p class="text-[10px]">Telp: 081229892212</p>
                </div>
                <div class="border-b border-dashed border-black my-1"></div>
                <div class="text-[10px] space-y-0.5">
                    <p id="rec-date">Tanggal: --/--/--</p>
                    <p id="rec-type">Tipe: DINE-IN</p>
                    <p id="rec-method">Metode: TUNAI</p>
                    <p>Kasir: Abel (Terminal 01)</p>
                </div>
                <div class="border-b border-dashed border-black my-1"></div>
                <div id="receipt-items-list" class="space-y-1.5 text-[10px]"></div>
                <div class="border-b border-dashed border-black my-1"></div>
                <div class="space-y-0.5 text-[10px]">
                    <div class="flex justify-between"><span>Subtotal:</span><span id="rec-subtotal">Rp 0</span></div>
                    <div class="flex justify-between text-red-700 font-bold"><span>Diskon:</span><span id="rec-discount">Rp 0</span></div>
                    <div class="flex justify-between"><span>Pajak (10%):</span><span id="rec-tax">Rp 0</span></div>
                    <div class="flex justify-between font-bold text-sm"><span>TOTAL:</span><span id="rec-total">Rp 0</span></div>
                </div>
                <div id="rec-cash-section" class="border-t border-dashed border-black pt-1 space-y-0.5 text-[10px] hidden">
                    <div class="flex justify-between"><span>Tunai Diterima:</span><span id="rec-cash-pay">Rp 0</span></div>
                    <div class="flex justify-between"><span>Kembalian:</span><span id="rec-cash-change">Rp 0</span></div>
                </div>
                <div class="border-b border-dashed border-black my-1"></div>
                <p class="text-center text-[9px] font-bold mt-2 uppercase tracking-tight">*** TERIMA KASIH ***<br>SELAMAT MENIKMATI KEMBALI</p>
            </div>
            <div class="flex gap-2 text-white-force no-print">
                <button onclick="closeReceiptModal()" class="flex-1 bg-slate-500 font-bold py-2 rounded-xl text-xs cursor-pointer">Selesai / Nota Baru</button>
                <button onclick="window.print()" class="flex-1 bg-blue-600 font-black py-2 rounded-xl text-xs flex items-center justify-center gap-1 cursor-pointer"><i class="fa-solid fa-print"></i> Cetak Struk</button>
            </div>
        </div>
    </div>

    <div id="recallModal" class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white dark:bg-zinc-900 rounded-2xl w-full max-w-md p-6 shadow-xl transform scale-95 transition-transform duration-300 modal-box-theme">
            <div class="flex items-center justify-between border-b pb-3 mb-4">
                <h3 class="text-base font-black flex items-center gap-2"><i class="fa-solid fa-list-check text-amber-500"></i> Daftar Nota Ditahan</h3>
                <button onclick="closeRecallModal()" class="text-gray-400 hover:text-gray-600 text-lg cursor-pointer">&times;</button>
            </div>
            <div id="held-orders-list" class="space-y-3 max-h-64 overflow-y-auto pr-1"></div>
            <div class="mt-5 pt-3 border-t flex justify-end">
                <button onclick="closeRecallModal()" class="bg-gray-100 text-gray-700 font-bold text-xs px-4 py-2 rounded-xl hover:bg-gray-200 transition cursor-pointer">Tutup</button>
            </div>
        </div>
    </div>

    <div id="open-register-modal" class="fixed inset-0 bg-black/80 flex items-center justify-center p-4 z-[100] hidden backdrop-blur-md">
        <div class="bg-white dark:bg-zinc-950 p-6 rounded-2xl max-w-sm w-full shadow-2xl border border-slate-200 dark:border-zinc-800 space-y-4 text-center">
            <div class="w-14 h-14 bg-amber-100 rounded-2xl mx-auto flex items-center justify-center shadow-xs">
                <i class="fa-solid fa-cash-register text-2xl text-amber-700"></i>
            </div>
            <div>
                <h3 class="text-base font-black text-slate-800 dark:text-zinc-100">Buka Shift Kasir Baru</h3>
                <p class="text-xs text-slate-400 mt-1">Masukkan nominal uang modal awal di dalam laci untuk uang kembalian.</p>
            </div>
            <div class="text-left space-y-1">
                <label class="text-[11px] font-bold text-slate-400 uppercase">Uang Modal Awal (Rp):</label>
                <input type="number" id="modal-awal-input" class="w-full text-sm font-black p-3 bg-slate-50 border rounded-xl focus:outline-none" placeholder="Contoh: 500000">
            </div>
            <button onclick="submitOpenRegister()" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-black text-sm py-3 rounded-xl transition shadow-md cursor-pointer">BUKA KASIR &amp; MULAI</button>
        </div>
    </div>

    <div id="close-register-modal" class="fixed inset-0 bg-black/60 hidden items-center justify-center p-4 z-[90]">
        <div class="bg-white dark:bg-zinc-900 rounded-2xl max-w-sm w-full p-6 shadow-xl border space-y-4 modal-box-theme">
            <div class="flex items-center justify-between border-b pb-2">
                <h3 class="text-base font-black text-slate-800 flex items-center gap-2"><i class="fa-solid fa-calculator text-rose-500"></i> Rekonsiliasi Kasir</h3>
                <button onclick="closeRegisterModalOverlay()" class="text-gray-400 text-lg cursor-pointer">&times;</button>
            </div>
            <div class="space-y-2 text-xs font-bold px-1 border-b pb-3">
                <div class="flex justify-between"><span>Uang Modal Awal:</span><span id="reg-preview-modal">Rp 0</span></div>
                <div class="flex justify-between"><span>Total Omset Tunai:</span><span id="reg-preview-sales">Rp 0</span></div>
                <div class="flex justify-between text-slate-800 dark:text-zinc-200 text-sm font-black pt-1.5 border-t border-dashed">
                    <span>Uang Wajib Ada di Laci:</span><span id="reg-preview-expected" class="text-amber-600">Rp 0</span>
                </div>
            </div>
            <div class="space-y-3">
                <div class="space-y-1">
                    <label class="text-[11px] font-bold text-slate-400 uppercase">Hitung &amp; Masukkan Uang Fisik Asli (Rp):</label>
                    <input type="number" id="physical-cash-input" onkeyup="calculateLiveVariance()" class="w-full text-sm font-black p-2.5 bg-slate-50 border rounded-xl focus:outline-none" placeholder="Masukkan jumlah uang laci...">
                </div>
                <div class="flex justify-between items-center text-xs font-black p-2 rounded-xl bg-slate-50 dark:bg-zinc-800">
                    <span>Status Selisih Finansial:</span>
                    <span id="live-variance-display" class="font-black text-gray-700">Rp 0</span>
                </div>
            </div>
            <div class="flex gap-2 text-white-force pt-1">
                <button onclick="closeRegisterModalOverlay()" class="flex-1 bg-slate-400 font-bold py-2 rounded-xl text-xs cursor-pointer">Batal</button>
                <button onclick="submitCloseRegister()" class="flex-1 bg-rose-600 hover:bg-rose-700 font-black py-2 rounded-xl text-xs cursor-pointer">PROSES TUTUP SHIFT</button>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        let selectedMethod = null;
        let currentOrderType = 'Dine-In';
        let currentDiscountPercent = 0;
        let tempModItem = null;
        let tempSizePrice = 0;
        
        let qrisPollingInterval = null; 
        let currentOrderId = null;       

        let expectedCashInDrawer = 0;

        function toggleDarkMode() {
            const htmlElement = document.documentElement;
            const icon = document.getElementById('theme-icon');
            if (htmlElement.classList.contains('dark') || htmlElement.getAttribute('data-theme') === 'dark') {
                htmlElement.classList.remove('dark');
                htmlElement.setAttribute('data-theme', 'light');
                icon.className = 'fa-solid fa-moon text-lg';
                localStorage.setItem('theme', 'light');
            } else {
                htmlElement.classList.add('dark');
                htmlElement.setAttribute('data-theme', 'dark');
                icon.className = 'fa-solid fa-sun text-lg';
                localStorage.setItem('theme', 'dark');
            }
        }

        window.onload = function() {
            filterCategory('burger');
            updateHeldCountBadge(); 
            checkRegisterStatus(); 
        };

        window.addEventListener('DOMContentLoaded', () => {
            const icon = document.getElementById('theme-icon');
            if (document.documentElement.classList.contains('dark')) {
                icon.className = 'fa-solid fa-sun text-lg';
            } else {
                icon.className = 'fa-solid fa-moon text-lg';
            }
        });

        function checkRegisterStatus() {
            fetch('/register/check')
            .then(res => responseJson(res))
            .then(data => {
                if (!data.is_open) {
                    document.getElementById('open-register-modal').style.display = 'flex'; 
                } else {
                    document.getElementById('open-register-modal').style.display = 'none';
                }
            });
        }

        function responseJson(res) { return res.json(); }

        function submitOpenRegister() {
            let val = parseInt(document.getElementById('modal-awal-input').value);
            if (!val || val < 0) {
                alert("Mohon masukkan nominal modal awal yang valid!");
                return;
            }
            fetch('/register/open', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                body: JSON.stringify({ modal_awal: val })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('open-register-modal').style.display = 'none';
                    alert("Kasir Berhasil Dibuka! Selamat bertugas. 🚀");
                }
            });
        }

        function openCloseRegisterModal() {
            fetch('/register/preview')
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    expectedCashInDrawer = data.expected; 
                    document.getElementById('reg-preview-modal').innerText = 'Rp ' + data.modal_awal.toLocaleString('id-ID');
                    document.getElementById('reg-preview-sales').innerText = 'Rp ' + data.total_tunai.toLocaleString('id-ID');
                    document.getElementById('reg-preview-expected').innerText = 'Rp ' + data.expected.toLocaleString('id-ID');
                    
                    document.getElementById('physical-cash-input').value = '';
                    document.getElementById('live-variance-display').innerText = 'Rp 0';
                    document.getElementById('live-variance-display').className = "font-black text-gray-500";
                    
                    document.getElementById('close-register-modal').style.display = 'flex';
                }
            });
        }

        function closeRegisterModalOverlay() {
            document.getElementById('close-register-modal').style.display = 'none';
        }

        function calculateLiveVariance() {
            let physical = parseInt(document.getElementById('physical-cash-input').value) || 0;
            let variance = physical - expectedCashInDrawer;
            let display = document.getElementById('live-variance-display');
            
            if (variance === 0) {
                display.innerText = "Rp 0 (Cocok/Sesuai)";
                display.className = "font-black text-green-600";
            } else if (variance > 0) {
                display.innerText = "+ Rp " + variance.toLocaleString('id-ID') + " (Kelebihan Uang)";
                display.className = "font-black text-blue-600";
            } else {
                display.innerText = "- Rp " + Math.abs(variance).toLocaleString('id-ID') + " (Kurang/Teakor)";
                display.className = "font-black text-rose-600";
            }
        }

        function submitCloseRegister() {
            let physical = document.getElementById('physical-cash-input').value;
            if (physical === '') {
                alert("Mohon hitung fisik uang di laci dan isi kolomnya!");
                return;
            }

            let konfirmasi = confirm("Apakah Anda yakin ingin mengunci laporan shift kasir ini dan menutup laci?");
            if (!konfirmasi) return;

            fetch('/register/close', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                body: JSON.stringify({ uang_physic: parseInt(physical) })
            })
            .then(res => res.json().then(data => ({ status: res.status, body: data })))
            .then(result => {
                if (result.status === 200 || result.body.success === true) {
                    closeRegisterModalOverlay();
                    clearCart();
                    alert("Shift Kasir Resmi Ditutup Sempurna! Layar otomatis dikunci untuk kasir berikutnya.");
                    checkRegisterStatus(); 
                } else {
                    alert("Gagal menutup shift: " + result.body.message);
                }
            })
            .catch(err => {
                alert("Error Sistem Server: " + err);
            });
        }

        function setOrderType(type) {
            const dineInBtn = document.getElementById('type-dine-in');
            const takeAwayBtn = document.getElementById('type-take-away');

            dineInBtn.style.setProperty('border-color', 'var(--border-color)', 'important');
            dineInBtn.style.setProperty('background-color', 'var(--bg-card)', 'important');
            dineInBtn.style.setProperty('color', 'var(--text-color)', 'important');

            takeAwayBtn.style.setProperty('border-color', 'var(--border-color)', 'important');
            takeAwayBtn.style.setProperty('background-color', 'var(--bg-card)', 'important');
            takeAwayBtn.style.setProperty('color', 'var(--text-color)', 'important');
            
            const activeBtn = type === 'Dine-In' ? dineInBtn : takeAwayBtn;
            activeBtn.style.setProperty('border-color', '#b87333', 'important');
            activeBtn.style.setProperty('background-color', '#f5efe6', 'important');
            activeBtn.style.setProperty('color', '#8b5a2b', 'important');
        }

        function openModifierModal(id, name, basePrice, stock, category) {
            if (stock <= 0) {
                alert("Maaf, stok " + name + " sudah habis!");
                return;
            }
            tempModItem = { id: id, name: name, basePrice: basePrice };

            const burgerAddons = document.getElementById('burger-addons');
            const drinkAddons = document.getElementById('drink-addons');

            if (burgerAddons && drinkAddons) {
                if (category === 'drinks') {
                    burgerAddons.classList.add('hidden');
                    drinkAddons.classList.remove('hidden');
                } else {
                    burgerAddons.classList.remove('hidden');
                    drinkAddons.classList.add('hidden');
                }
            }

            document.querySelectorAll('#addon-section input[type="checkbox"]').forEach(cb => cb.checked = false);
            document.getElementById('mod-title').innerText = `Kustomisasi: ${name}`;
            document.getElementById('modifier-modal').style.display = 'flex';
        }

        function closeModifierModal() {
            document.getElementById('modifier-modal').style.display = 'none';
            tempModItem = null;
        }

        function setModSize(extraPrice) {
            tempSizePrice = extraPrice;
        }

        function confirmAddToCart() {
            if (!tempModItem) {
                alert("Data menu tidak ditemukan!");
                return;
            }

            let sizeEl = document.querySelector('input[name="item-size"]:checked');
            let sizeLabel = sizeEl ? sizeEl.value : 'Regular';
            let extraSizePrice = (typeof tempSizePrice !== 'undefined') ? tempSizePrice : 0;
            let finalPrice = tempModItem.basePrice + extraSizePrice;
            
            let noteParts = [];
            if (sizeLabel !== 'Regular') noteParts.push('Ukuran ' + sizeLabel);

            const addons = [
                { id: 'addon-cheese', price: 5000, name: 'Ekstra Keju' },
                { id: 'addon-meat', price: 15000, name: 'Ekstra Daging' },
                { id: 'addon-sugar', price: 0, name: 'Less Sugar' },
                { id: 'addon-jelly', price: 3000, name: 'Tambah Jelly' }
            ];

            addons.forEach(addon => {
                let el = document.getElementById(addon.id);
                if (el && el.checked) {
                    finalPrice += parseInt(addon.price);
                    noteParts.push(addon.name);
                }
            });

            let noteText = noteParts.join(', ');
            const itemKey = tempModItem.id + '-' + sizeLabel + '-' + noteText;
            const existingItem = cart.find(i => i.itemKey === itemKey);

            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    id: tempModItem.id,
                    itemKey: itemKey,
                    name: tempModItem.name + (sizeLabel !== 'Regular' ? ` (${sizeLabel})` : ''),
                    price: finalPrice,
                    quantity: 1,
                    note: noteText
                });
            }

            closeModifierModal();
            updateUI();
        }

        function changeQuantity(itemKey, delta) {
            const item = cart.find(i => i.itemKey === itemKey);
            if(item) {
                item.quantity += delta;
                if(item.quantity <= 0) {
                    cart = cart.filter(i => i.itemKey !== itemKey);
                }
            }
            updateUI();
        }

        function updateNoteDirect(itemKey, text) {
            const item = cart.find(i => i.itemKey === itemKey);
            if(item) item.note = text;
        }

        function applyDiscount(percent) {
            currentDiscountPercent = percent;
            document.querySelectorAll('.discount-btn-fixed, [id^="disc-"]').forEach(btn => {
                btn.style.setProperty('background-color', 'var(--bg-discount-inactive)', 'important');
                btn.style.setProperty('border-color', 'var(--border-color)', 'important');
                btn.style.setProperty('color', 'var(--text-color)', 'important');
            });
            document.getElementById('disc-0').className = "px-2.5 py-1 text-[10px] font-bold border rounded bg-white dark:bg-zinc-800 border-slate-200 dark:border-zinc-700 cursor-pointer";
            const activeBtn = document.getElementById(`disc-${percent}`);
            if (activeBtn) {
                activeBtn.style.setProperty('border-color', '#b87333', 'important');
                activeBtn.style.setProperty('background-color', '#f5efe6', 'important');
                activeBtn.style.setProperty('color', '#8b5a2b', 'important');
            }
            updateUI();
        }

        function clearCart() {
            cart = [];
            selectedMethod = null;
            document.querySelectorAll('.method-btn-fixed').forEach(btn => {
                btn.style.borderColor = ""; btn.style.backgroundColor = ""; btn.style.color = "";
            });
            applyDiscount(0);
            document.getElementById('cash-received-input').value = '';
            updateUI();
        }

        function selectMethod(method) {
            selectedMethod = method;
            document.querySelectorAll('.method-btn-fixed').forEach(btn => {
                btn.style.borderColor = ""; btn.style.backgroundColor = ""; btn.style.color = "";
            });
            
            const activeBtn = document.getElementById(`pay-${method}`);
            activeBtn.style.setProperty('border-color', '#b87333', 'important');
            activeBtn.style.setProperty('background-color', '#f5efe6', 'important');
            activeBtn.style.setProperty('color', '#8b5a2b', 'important');

            const cashRow = document.getElementById('cash-calculator-row');
            if(method === 'tunai') {
                cashRow.classList.remove('hidden');
            } else {
                cashRow.classList.add('hidden');
            }

            checkPayButtonState();
            calculateChange();
        }

        function filterCategory(category) {
            document.querySelectorAll('.category-nav-btn').forEach(btn => {
                btn.classList.remove('active-btn-style');
            });
            
            const titleEl = document.getElementById('category-title');
            if (category === 'drinks') {
                document.getElementById('nav-drinks').classList.add('active-btn-style');
                if (titleEl) titleEl.innerText = "Menu Minuman";
            } else {
                document.getElementById('nav-all').classList.add('active-btn-style');
                if (titleEl) titleEl.innerText = "Menu Makanan";
            }
            
            document.querySelectorAll('.menu-item').forEach(item => {
                let cat = (item.getAttribute('data-category') || "").trim().toLowerCase();
                let target = category.trim().toLowerCase();
                if (target === 'all' || cat === target) {
                    item.style.setProperty('display', 'flex', 'important');
                } else {
                    item.style.setProperty('display', 'none', 'important');
                }
            });
        }

        function calculateChange() {
            if(selectedMethod !== 'tunai') return;
            let subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            let discountAmount = Math.round(subtotal * (currentDiscountPercent / 100));
            let totalAmount = (subtotal - discountAmount) + Math.round((subtotal - discountAmount) * 0.10);
            let cashInput = parseInt(document.getElementById('cash-received-input').value) || 0;
            let change = cashInput - totalAmount;

            const changeDisplay = document.getElementById('cash-change-display');
            if(change >= 0) {
                changeDisplay.innerText = 'Rp ' + change.toLocaleString('id-ID');
                changeDisplay.className = "text-green-600 font-black";
            } else {
                changeDisplay.innerText = '- Rp ' + Math.abs(change).toLocaleString('id-ID') + ' (Kurang)';
                changeDisplay.className = "text-rose-600 font-bold";
            }
        }

        function checkPayButtonState() {
            const btn = document.getElementById('btn-bayar-utama');
            if(cart.length > 0 && selectedMethod !== null) {
                btn.disabled = false;
                btn.className = "bg-[#27ae60] hover:bg-[#219653] text-white font-black text-sm py-3 rounded-lg shadow-md transition-all uppercase text-center cursor-pointer text-white-force";
            } else {
                btn.disabled = true;
                btn.className = "btn-pay-disabled-fixed text-slate-500 font-black text-sm py-3 rounded-lg uppercase text-center cursor-not-allowed";
            }
        }

        function updateUI() {
            const container = document.getElementById('cart-items-container');
            container.innerHTML = '';
            let qtyTotals = {};
            document.querySelectorAll('[id^="badge-"]').forEach(el => el.classList.add('hidden'));

            if(cart.length === 0) {
                container.innerHTML = `<div id="cart-empty" class="h-full flex flex-col items-center justify-center py-20"><i class="fa-solid fa-basket-shopping text-5xl text-slate-200 dark:text-zinc-700 mb-2"></i><p class="text-sm font-medium text-slate-400">Belum ada item pesanan.</p></div>`;
                document.getElementById('summary-subtotal').innerText = 'Rp 0';
                document.getElementById('summary-discount').innerText = '- Rp 0';
                document.getElementById('summary-tax').innerText = 'Rp 0';
                document.getElementById('summary-total').innerText = 'Rp 0';
                checkPayButtonState();
                return;
            }

            let subtotal = 0;
            cart.forEach(item => {
                subtotal += item.price * item.quantity;
                qtyTotals[item.id] = (qtyTotals[item.id] || 0) + item.quantity;

                const itemHtml = document.createElement('div');
                itemHtml.className = "border-b pb-3 space-y-1.5";
                itemHtml.innerHTML = `
                    <div class="flex items-start justify-between">
                        <div class="flex-1 pr-2">
                            <h4 class="font-bold text-sm">${item.name}</h4>
                            <p class="text-[10px] text-amber-600 font-bold mt-0.5">${item.note || 'Reguler'}</p>
                        </div>
                        <span class="font-bold text-sm shrink-0">Rp ${(item.price * item.quantity).toLocaleString('id-ID')}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <input type="text" value="${item.note}" onchange="updateNoteDirect('${item.itemKey}', this.value)" 
                            class="w-52 text-[10px] border border-transparent rounded-md px-1.5 py-0.5 focus:outline-none focus:bg-white transition-all italic" placeholder="Catatan tambahan kasir...">
                        <div class="cart-qty-container">
                            <button onclick="changeQuantity('${item.itemKey}', -1)" class="btn-qty-minus-fixed">-</button>
                            <span class="text-xs font-bold px-1 text-qty-num">${item.quantity}</span>
                            <button onclick="changeQuantity('${item.itemKey}', 1)" class="btn-qty-plus-fixed">+</button>
                        </div>
                    </div>
                `;
                container.appendChild(itemHtml);
            });

            for (let id in qtyTotals) {
                const badge = document.getElementById(`badge-${id}`);
                if(badge) {
                    badge.innerText = `${qtyTotals[id]} Ditambahkan`;
                    badge.classList.remove('hidden');
                }
            }

            let discountAmount = Math.round(subtotal * (currentDiscountPercent / 100));
            let netSubtotal = subtotal - discountAmount;
            let tax = Math.round(netSubtotal * 0.10);
            let total = netSubtotal + tax;

            document.getElementById('summary-subtotal').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
            document.getElementById('summary-discount').innerText = '- Rp ' + discountAmount.toLocaleString('id-ID');
            document.getElementById('summary-tax').innerText = 'Rp ' + tax.toLocaleString('id-ID');
            document.getElementById('summary-total').innerText = 'Rp ' + total.toLocaleString('id-ID');
            checkPayButtonState();
            calculateChange();
        }

        function searchMenu() {
            const query = document.getElementById('search-input').value.toLowerCase();
            document.querySelectorAll('.menu-item').forEach(item => {
                const name = item.getAttribute('data-name').toLowerCase();
                item.style.display = name.includes(query) ? 'flex' : 'none';
            });
        }

        async function triggerPayment() {
            let subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            let discountAmount = Math.round(subtotal * (currentDiscountPercent / 100));
            let totalAmount = (subtotal - discountAmount) + Math.round((subtotal - discountAmount) * 0.10);

            if(selectedMethod !== 'qris') {
                openReceiptModal(false); 
                return;
            }

            const btn = document.getElementById('btn-bayar-utama');
            btn.innerHTML = `<i class="fa-solid fa-spinner animate-spin"></i> Menghubungkan...`;

            try {
                let response = await fetch("/order/payment", {
                    method: "POST",
                    headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                    body: JSON.stringify({ 
                        amount: totalAmount, cart_items: cart, order_type: currentOrderType,
                        subtotal: subtotal, discount_amount: discountAmount,
                        tax_amount: Math.round((subtotal - discountAmount) * 0.10), total_amount: totalAmount
                    })
                });
                let data = await response.json();
                btn.innerHTML = 'Bayar';
                if(data.success) {
                    currentOrderId = data.order_id;
                    document.getElementById('qr-amount-display').innerText = 'Rp ' + totalAmount.toLocaleString('id-ID');
                    document.getElementById('qris-modal').style.display = 'flex';
                    document.getElementById('qris-container').innerHTML = `<img src="${data.qr_url}" alt="QRIS Code">`;
                    startQrisPolling(data.order_id);
                } else {
                    alert("Gagal terhubung ke Midtrans: " + data.message);
                }
            } catch (err) {
                btn.innerHTML = 'Bayar';
                alert("Terjadi kesalahan jaringan server.");
            }
        }

        function startQrisPolling(orderId) {
            if (qrisPollingInterval) clearInterval(qrisPollingInterval);
            qrisPollingInterval = setInterval(() => {
                fetch(`/order/status/${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        clearInterval(qrisPollingInterval);
                        closeModal();
                        openReceiptModal(true); 
                        alert("Pembayaran QRIS Sukses Terdeteksi! Struk otomatis dicetak. 🎉");
                    }
                })
                .catch(err => console.error(err));
            }, 3000); 
        }

        function bypassQrisSuccess() {
            if (qrisPollingInterval) clearInterval(qrisPollingInterval);
            closeModal();
            openReceiptModal(false);
        }

        function openReceiptModal(alreadyStored = false) {
            const listContainer = document.getElementById('receipt-items-list');
            listContainer.innerHTML = '';

            let subtotal = 0;
            cart.forEach(item => {
                subtotal += item.price * item.quantity;
                const itemRow = document.createElement('div');
                itemRow.className = "space-y-0.5";
                itemRow.innerHTML = `
                    <div class="flex justify-between font-bold"><span>${item.name}</span><span>Rp ${(item.price * item.quantity).toLocaleString('id-ID')}</span></div>
                    <div class="flex justify-between text-[9px] text-gray-600 pl-1">
                        <span>${item.quantity} x Rp ${item.price.toLocaleString('id-ID')}</span>
                        <span>${item.note ? '('+item.note+')' : ''}</span>
                    </div>
                `;
                listContainer.appendChild(itemRow);
            });
            let discountAmount = Math.round(subtotal * (currentDiscountPercent / 100));
            let netSubtotal = subtotal - discountAmount;
            let tax = Math.round(netSubtotal * 0.10);
            let total = netSubtotal + tax;

            document.getElementById('rec-date').innerText = "Tanggal: " + new Date().toLocaleString('id-ID');
            document.getElementById('rec-type').innerText = "Tipe Pesanan: " + currentOrderType.toUpperCase();
            document.getElementById('rec-method').innerText = "Metode: " + selectedMethod.toUpperCase();
            
            document.getElementById('rec-subtotal').innerText = "Rp " + subtotal.toLocaleString('id-ID');
            document.getElementById('rec-discount').innerText = "Rp " + discountAmount.toLocaleString('id-ID');
            document.getElementById('rec-tax').innerText = "Rp " + tax.toLocaleString('id-ID');
            document.getElementById('rec-total').innerText = "Rp " + total.toLocaleString('id-ID');

            let cashInput = total;
            let change = 0;

            const cashSection = document.getElementById('rec-cash-section');
            if(selectedMethod === 'tunai') {
                cashInput = parseInt(document.getElementById('cash-received-input').value) || total;
                change = cashInput - total;
                document.getElementById('rec-cash-pay').innerText = "Rp " + cashInput.toLocaleString('id-ID');
                document.getElementById('rec-cash-change').innerText = "Rp " + (change >= 0 ? change : 0).toLocaleString('id-ID');
                cashSection.classList.remove('hidden');
            } else {
                cashSection.classList.add('hidden');
            }

            if (alreadyStored) {
                document.getElementById('receipt-modal').style.display = 'flex';
                return;
            }

            fetch("/order/store", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                body: JSON.stringify({
                    order_type: currentOrderType, payment_method: selectedMethod, subtotal: subtotal,
                    discount_amount: discountAmount, tax_amount: tax, total_amount: total,
                    cash_received: selectedMethod === 'tunai' ? cashInput : null,
                    cash_change: selectedMethod === 'tunai' ? (change >= 0 ? change : 0) : null,
                    cart_items: cart 
                })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(result => {
                if (result.status === 200 || result.body.success === true) {
                    document.getElementById('receipt-modal').style.display = 'flex';
                } else {
                    alert("Transaksi Gagal: " + result.body.message); 
                }
            })
            .catch(err => { alert("Error Sistem: " + err); });
        }

        function closeReceiptModal() {
            document.getElementById('receipt-modal').style.display = 'none';
            clearCart();
        }

        function closeModal() {
            document.getElementById('qris-modal').style.display = 'none';
            if (qrisPollingInterval) clearInterval(qrisPollingInterval); 
        }

        function holdOrder() {
            if (cart.length === 0) { alert("Keranjang masih kosong!"); return; }
            let heldOrders = JSON.parse(localStorage.getItem('bk_held_orders')) || [];
            let newHeldOrder = {
                timestamp: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }),
                items: [...cart], total_items: cart.reduce((sum, item) => sum + item.quantity, 0)
            };
            heldOrders.push(newHeldOrder);
            localStorage.setItem('bk_held_orders', JSON.stringify(heldOrders));
            cart = []; updateUI(); updateHeldCountBadge();
            alert("Pesanan berhasil ditahan!");
        }

        function updateHeldCountBadge() {
            let heldOrders = JSON.parse(localStorage.getItem('bk_held_orders')) || [];
            const badge = document.getElementById('held-count');
            if (badge) badge.innerText = heldOrders.length;
        }

        function openRecallModal() {
            let heldOrders = JSON.parse(localStorage.getItem('bk_held_orders')) || [];
            const container = document.getElementById('held-orders-list');
            container.innerHTML = "";
            if (heldOrders.length === 0) {
                container.innerHTML = `<div class="text-center py-6 text-gray-400 text-xs font-medium">Tidak ada nota ditahan.</div>`;
            } else {
                heldOrders.forEach((order, index) => {
                    container.innerHTML += `
                        <div class="p-3 bg-slate-50 dark:bg-zinc-800 rounded-xl border flex items-center justify-between">
                            <div><p class="text-xs font-black">Nota Antrean #${index + 1}</p><p class="text-[10px] text-gray-400">Waktu: ${order.timestamp} (${order.total_items} Item)</p></div>
                            <button onclick="recallOrder(${index})" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs px-3 py-1.5 rounded-lg cursor-pointer">Buka</button>
                        </div>`;
                });
            }
            const modal = document.getElementById('recallModal');
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.remove('opacity-0'), 10);
        }

        function closeRecallModal() {
            const modal = document.getElementById('recallModal');
            modal.classList.add('opacity-0');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        function recallOrder(index) {
            if (cart.length > 0) {
                let konfirmasi = confirm("Keranjang terisi, nota ditahan akan menimpa menu saat ini. Lanjutkan?");
                if (!konfirmasi) return;
            }
            let heldOrders = JSON.parse(localStorage.getItem('bk_held_orders')) || [];
            cart = heldOrders[index].items;
            heldOrders.splice(index, 1);
            localStorage.setItem('bk_held_orders', JSON.stringify(heldOrders));
            updateUI(); updateHeldCountBadge(); closeRecallModal();
        }

        function sendToKitchen() {
            if (cart.length === 0) { alert("Keranjang kosong!"); return; }
            fetch('/order/kitchen', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') },
                body: JSON.stringify({ cart_items: cart })
            })
            .then(res => res.json())
            .then(data => { alert(data.message); });
        }
    </script>
</body>
</html>