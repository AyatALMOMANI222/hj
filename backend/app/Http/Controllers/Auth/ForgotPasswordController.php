<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('email');
    }



    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink(
            $request->only('email')
        );

        if ($response == Password::RESET_LINK_SENT) {
            return view('reset_link_sent'); // عرض صفحة النجاح
        } else {
            return view('reset_link_failed'); // عرض صفحة الفشل
        }}
    
}
