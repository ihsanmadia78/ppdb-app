<?php

namespace App\Http\Controllers;

use App\Models\UserOtp;

class TestController extends Controller
{
    public function getLatestOtp($email = 'test@example.com')
    {
        $otp = UserOtp::where('email', $email)->latest()->first();
        
        if ($otp) {
            return response()->json([
                'email' => $email,
                'otp_code' => $otp->otp_code,
                'expires_at' => $otp->expires_at,
                'is_valid' => $otp->isValid()
            ]);
        }
        
        return response()->json(['message' => 'No OTP found for this email']);
    }
}