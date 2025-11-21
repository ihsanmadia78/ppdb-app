<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            
            // Redirect berdasarkan role
            switch ($user->role) {
                case 'eksekutif':
                    return redirect()->route('eksekutif.dashboard');
                case 'verifikator':
                    return redirect()->route('verifikator.dashboard');
                case 'keuangan':
                    return redirect()->route('keuangan.dashboard');
                default:
                    return redirect()->route('dashboard');
            }
        }

        return back()->with('error', 'Email atau password salah.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout');
    }
}
