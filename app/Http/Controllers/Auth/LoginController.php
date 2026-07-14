<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // 1. Menampilkan Halaman Login (Anti-Cache)
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/pos'); // Jika sudah login, langsung lempar ke kasir
        }
        
        // PERBAIKAN: Memaksa browser kasir TIDAK MENYIMPAN cache halaman login
        return response()
            ->view('login')
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }

    // 2. Logika Validasi Masuk Akun
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Mengacak session ID baru demi keamanan

            return redirect()->intended('/pos');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // 3. Logika Keluar Sistem (Logout Total)
    public function logout(Request $request)
    {
        Auth::logout();
        
        // Hapus dan hancurkan session lama kasir agar tidak menyangkut di serverless Vercel
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Kembalikan ke halaman login awal
        return redirect('/');
    }
}