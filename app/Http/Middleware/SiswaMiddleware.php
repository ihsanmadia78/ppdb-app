<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SiswaMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('siswa_id')) {
            // Clear any existing session data
            $request->session()->flush();
            return redirect()->route('siswa.login');
        }

        return $next($request);
    }
}