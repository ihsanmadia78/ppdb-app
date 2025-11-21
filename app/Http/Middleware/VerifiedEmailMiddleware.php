<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class VerifiedEmailMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $email = $request->input('email') ?? session('registration_email');
        
        if (!$email) {
            return redirect()->route('register')->with('error', 'Silakan registrasi terlebih dahulu.');
        }

        $user = User::where('email', $email)->first();
        
        if (!$user || !$user->email_verified || !$user->can_register) {
            return redirect()->route('otp.verify.form', ['email' => $email])
                ->with('error', 'Email belum diverifikasi. Silakan verifikasi email terlebih dahulu.');
        }

        return $next($request);
    }
}