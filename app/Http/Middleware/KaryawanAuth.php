<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KaryawanAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
{
    if (!session()->has('karyawan_id')) {
        return redirect('/login')
            ->with('error', 'Silakan login terlebih dahulu.');
    }

    return $next($request);
}
}
