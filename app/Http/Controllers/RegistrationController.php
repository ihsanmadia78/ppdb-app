<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class RegistrationController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Create user account (not verified yet)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
            'email_verified' => false,
            'can_register' => false,
        ]);

        // Generate and send OTP
        try {
            $this->sendOtp($request->email);
        } catch (\Exception $e) {
            \Log::error('Failed to send OTP: ' . $e->getMessage());
            // Continue even if email fails
        }

        return redirect()->route('otp.verify.form', ['email' => $request->email])
            ->with('success', 'Akun berhasil dibuat! Silakan cek email Anda untuk kode OTP.');
    }

    public function showOtpForm(Request $request)
    {
        $email = $request->get('email');
        return view('auth.verify-otp', compact('email'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp_code' => 'required|string|size:6',
        ]);

        $otp = UserOtp::where('email', $request->email)
            ->where('otp_code', $request->otp_code)
            ->where('is_used', false)
            ->first();

        if (!$otp) {
            return back()->withErrors(['otp_code' => 'Kode OTP tidak valid.']);
        }

        if ($otp->isExpired()) {
            // Auto-generate and send new OTP when expired
            try {
                $this->sendOtp($request->email);
                return back()->with('success', 'Kode OTP sudah kadaluarsa. Kode OTP baru telah dikirim ke email Anda.');
            } catch (\Exception $e) {
                return back()->withErrors(['otp_code' => 'Kode OTP sudah kadaluarsa dan gagal mengirim kode baru.']);
            }
        }

        // Mark OTP as used
        $otp->update(['is_used' => true]);

        // Update user verification status
        User::where('email', $request->email)->update([
            'email_verified' => true,
            'can_register' => true,
        ]);

        // Store email in session for pendaftaran
        session(['registration_email' => $request->email]);

        return redirect()->route('pendaftaran.create', ['email' => $request->email])
            ->with('success', 'Email berhasil diverifikasi! Sekarang Anda dapat melakukan pendaftaran.');
    }

    public function resendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $this->sendOtp($request->email);

        return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
    }

    private function sendOtp($email)
    {
        // Generate 6-digit OTP
        $otpCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Save OTP to database
        UserOtp::create([
            'email' => $email,
            'otp_code' => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(10), // 10 minutes expiry
        ]);

        // Send email
        try {
            Mail::send('emails.otp-verification', ['otp_code' => $otpCode], function ($message) use ($email) {
                $message->to($email)
                    ->subject('Kode Verifikasi OTP - PPDB SMK BaktiNusantara 666');
            });
        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage());
            throw $e;
        }
    }
}