<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache; 
use Midtrans\CoreApi; 
use Midtrans\Config; 

class OrderController extends Controller
{
    public function index() {
        $menus = Menu::orderBy('id', 'asc')->get(); 
        return view('pos', compact('menus')); 
    }

    // 🔥 REGISTRY FEATURE 1: Cek Apakah Kasir Sudah Input Modal Awal
    public function checkRegister() {
        $active = DB::table('cash_registers')->where('status', 'open')->first();
        return response()->json(['is_open' => $active ? true : false, 'data' => $active]);
    }

    // 🔥 REGISTRY FEATURE 2: Buka Kasir & Simpan Modal Uang Kembalian
    public function openRegister(Request $request) {
        DB::table('cash_registers')->insert([
            'status' => 'open',
            'modal_awal' => (int)$request->modal_awal,
            'opened_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return response()->json(['success' => true]);
    }

    // 🔥 REGISTRY FEATURE 3: Ambil Preview Omset Berjalan untuk Bahan Relevansi Kasir
    public function previewCloseRegister() {
        $active = DB::table('cash_registers')->where('status', 'open')->first();
        if (!$active) return response()->json(['success' => false], 400);

        // Hitung akumulasi semua transaksi TUNAI sejak kasir ini dibuka
        $totalTunai = DB::table('orders')
            ->whereRaw('LOWER(payment_method) = ?', ['tunai'])
            ->where('created_at', '>=', $active->opened_at)
            ->sum('total_amount');

        return response()->json([
            'success' => true,
            'modal_awal' => $active->modal_awal,
            'total_tunai' => $totalTunai,
            'expected' => $active->modal_awal + $totalTunai
        ]);
    }

    // 🔥 REGISTRY FEATURE 4: Tutup Kasir, Hitung Selisih & Kunci Laporan Shift
   // 🔥 PERBAIKAN: Fungsi Tutup Kasir (Ubah 'uang_physic' menjadi 'uang_fisik')
    public function closeRegister(Request $request) {
        $active = DB::table('cash_registers')->where('status', 'open')->first();
        if (!$active) {
            return response()->json(['success' => false, 'message' => 'Tidak ada shift kasir yang aktif.'], 400);
        }

        $totalTunai = DB::table('orders')
            ->whereRaw('LOWER(payment_method) = ?', ['tunai'])
            ->where('created_at', '>=', $active->opened_at)
            ->sum('total_amount');

        $uangFisik = (int)$request->uang_physic;
        $expectedTotal = $active->modal_awal + $totalTunai;
        $selisih = $uangFisik - $expectedTotal;

        // 🔥 UBAH DI SINI: Pastikan nama kolomnya 'uang_fisik' sesuai file migration
        DB::table('cash_registers')->where('id', $active->id)->update([
            'status' => 'closed',
            'total_tunai' => $totalTunai,
            'uang_fisik' => $uangFisik, // <-- INI YANG BENAR!
            'selisih' => $selisih,
            'closed_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function prosesPembayaran(Request $request)
    {
        if ($request->has('cart_items')) {
            foreach ($request->cart_items as $item) {
                $menu = Menu::find($item['id']);
                if (!$menu || $menu->stock < $item['quantity']) {
                    return response()->json([
                        'success' => false, 
                        'message' => "Stok " . ($menu ? $menu->name : "Item") . " tidak cukup!"
                    ], 400); 
                }
            }
        }

        Config::$serverKey = env('MIDTRANS_SERVER_KEY'); 
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false); 
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $orderId = 'BK-' . time();
        $params = [
            'payment_type' => 'qris', 
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int)$request->amount, 
            ]
        ];

        try {
            $response = CoreApi::charge($params);
            Cache::put('pending_order_' . $orderId, $request->all(), 60);

            return response()->json([
                'success' => true,
                'qr_url' => $response->actions[0]->url,
                'order_id' => $orderId 
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function handleWebhook(Request $request)
    {
        $orderId = $request->input('order_id');
        $transactionStatus = $request->input('transaction_status');

        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
            $cachedData = Cache::get('pending_order_' . $orderId);
            if ($cachedData) {
                DB::beginTransaction();
                try {
                    $order = Order::create([
                        'order_number'   => $orderId,
                        'order_type'     => $cachedData['order_type'] ?? 'Dine-In',
                        'payment_method' => 'QRIS',
                        'subtotal'       => $cachedData['subtotal'] ?? 0,
                        'discount_amount'=> $cachedData['discount_amount'] ?? 0,
                        'tax_amount'     => $cachedData['tax_amount'] ?? 0,
                        'total_amount'   => $cachedData['total_amount'] ?? 0,
                        'status'         => 'success',
                    ]);

                    foreach ($cachedData['cart_items'] as $item) {
                        $menu = Menu::find($item['id']);
                        OrderItem::create([
                            'order_id'   => $order->id,
                            'menu_id'    => $item['id'],
                            'menu_name'  => $menu ? $menu->name : 'Menu Dihapus', 
                            'price'      => $item['price'],
                            'quantity'   => $item['quantity'],
                            'note'       => $item['note'] ?? null,
                        ]);

                        if ($menu) {
                            $menu->decrement('stock', $item['quantity']);
                        }
                    }

                    DB::commit();
                    Cache::put('status_order_' . $orderId, 'success', 30);
                    Cache::forget('pending_order_' . $orderId);

                    return response()->json(['success' => true, 'message' => 'Sistem Berhasil Sinkronisasi!']);
                } catch (\Throwable $e) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
                }
            }
        }
        return response()->json(['success' => true, 'message' => 'Status bukan lunas']);
    }

    public function checkOrderStatus($orderId)
    {
        $status = Cache::get('status_order_' . $orderId, 'pending');
        return response()->json(['status' => $status]);
    }

    public function store(Request $request)
    {
        require_once app_path('Models/Menu.php');
        require_once app_path('Models/Order.php');
        require_once app_path('Models/OrderItem.php');

        DB::beginTransaction();
        try {
            if (empty($request->cart_items)) {
                throw new \Exception("Keranjang belanja kosong!");
            }

            foreach ($request->cart_items as $item) {
                $menu = Menu::find($item['id']);
                if (!$menu) throw new \Exception("Menu dengan ID " . $item['id'] . " tidak ditemukan!");
                if ($menu->stock < $item['quantity']) throw new \Exception("Stok " . $menu->name . " tidak cukup!");
            }

            $orderNumber = 'BK-' . time();
            $order = Order::create([
                'order_number'   => $orderNumber,
                'order_type'     => $request->order_type ?? 'Dine-In',
                'payment_method' => $request->payment_method ?? 'Tunai',
                'subtotal'       => $request->subtotal ?? 0,
                'discount_amount'=> $request->discount_amount ?? 0,
                'tax_amount'     => $request->tax_amount ?? 0,
                'total_amount'   => $request->total_amount ?? 0,
                'status'         => 'success'
            ]);

            foreach ($request->cart_items as $item) {
                $menu = Menu::find($item['id']);
                OrderItem::create([
                    'order_id'   => $order->id,
                    'menu_id'    => $item['id'],
                    'menu_name'  => $menu ? $menu->name : 'Menu Dihapus',
                    'price'      => $item['price'],
                    'quantity'   => $item['quantity'],
                    'note'       => $item['note'] ?? null,
                ]);

                if ($menu) {
                    $menu->decrement('stock', $item['quantity']);
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'order_number' => $orderNumber]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }

    public function sendToKitchen(Request $request)
    {
        try {
            if (empty($request->cart_items)) throw new \Exception("Tidak ada menu!");
            foreach ($request->cart_items as $item) {
                $menu = Menu::find($item['id']);
                if (!$menu || $menu->stock < $item['quantity']) throw new \Exception("Stok tidak cukup!");
            }
            return response()->json(['success' => true, 'message' => 'Pesanan berhasil dikirim! Koki dapur sedang mulai memasak. 🍳🔥']);
        } catch (\Throwable $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}