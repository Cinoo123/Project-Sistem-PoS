<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/pos'); // Jika sudah login, langsung ke kasir
        }
        return view('login');
    }

    // Memproses data login dari form (Validasi Backend)
    public function login(Request $request)
    {
        // 1. Validasi format input di backend
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Cek kecocokan data ke database (Password otomatis didekripsi aman oleh Laravel)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // Mencegah serangan Session Fixation

            return redirect()->intended('/pos'); // Redirect ke halaman kasir
        }

        // 3. Jika salah, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Logika Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}