<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function showResetFormWithEmail(Request $request)
    {
        // التحقق من وجود الـ token و email في الرابط
        $token = $request->query('token');
        $email = $request->query('email');

        // إذا كانت القيم موجودة، قم بتمريرها إلى الـ view
        return view('reset', ['token' => $token, 'email' => $email]);
    }






 

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required'
        ]);
    
        // التأكد من وجود التوكن
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 400);
        }
    
        // محاولة استعادة كلمة المرور
        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
    
                event(new PasswordReset($user));
            }
        );
    
        // التأكد من حالة إعادة تعيين كلمة المرور
        if ($response == Password::PASSWORD_RESET) {
            return view('success'); // عرض الصفحة الناجحة
        } else {
            return view('failed'); // عرض صفحة الفشل
        }
    }
}
