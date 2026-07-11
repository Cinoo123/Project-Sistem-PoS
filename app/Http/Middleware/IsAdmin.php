<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika belum login ATAU role-nya bukan admin, tendang ke halaman kasir utama '/'
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Anda tidak memiliki hak akses Admin!');
        }

        return $next($request);
    }
}