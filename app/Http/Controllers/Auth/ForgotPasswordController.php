<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('forgot-password');
    }

    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Cek apakah email kasir terdaftar di tabel users beneran
        $user = DB::table('users')->where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Alamat email kasir tidak ditemukan di sistem!']);
        }

        // Jika ada, lempar ke halaman ganti password dengan membawa parameter email
        return redirect()->route('password.reset', ['email' => $request->email]);
    }

    public function showResetForm($email)
    {
        return view('reset-password', ['email' => $email]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:4|confirmed' // Password minimal 4 karakter & harus sama dengan konfirmasi
        ]);

        // Update password beneran ke database dengan enkripsi aman (Bcrypt Hash)
        $updated = DB::table('users')
            ->where('email', $request->email)
            ->update([
                'password' => Hash::make($request->password)
            ]);

        if ($updated) {
            return redirect('/login')->with('success', 'Kata sandi Burger Kingdom berhasil diperbarui! Silakan login.');
        }

        return back()->withErrors(['password' => 'Gagal memperbarui kata sandi. Silakan coba lagi.']);
    }
}