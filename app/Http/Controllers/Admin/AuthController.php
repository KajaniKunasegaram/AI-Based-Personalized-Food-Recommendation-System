<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    public function loginForm()
    {
        return view('admin.login');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $otp = rand(100000, 999999);

        session([
            'admin_otp' => $otp,
            'admin_email_entered' => $request->email
        ]);

        // OTP ALWAYS goes to OFFICIAL MAIL
        Mail::raw("Master Chef Admin OTP is: $otp", function ($message) {
            $message->to('officialcarparking2025@gmail.com')
                    ->subject('Admin OTP Verification');
        });

        return view('admin.verifyOtp', [
            'email' => $request->email
        ]);
    }



    public function verifyOtp(Request $request)
    {
        if ($request->otp == session('admin_otp')) {

            session([
                'admin_otp_verified' => true
            ]);

            return redirect()->route('admin.orders');
        }

        return view('admin.verifyOtp', [
            'email' => session('admin_email_entered'),
            'error' => 'Invalid OTP. Please try again.'
        ]);
       
    }

    
}
