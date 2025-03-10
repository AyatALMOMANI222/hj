<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;


Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = \App\Models\User::findOrFail($id);

    // تحقق مما إذا كان الرابط صالحًا باستخدام Laravel's Signed URL Verification
    if (! URL::hasValidSignature($request)) {
        return response()->view('email_verify_failed', ['status' => 'failed', 'message' => 'Invalid or expired verification link.'], 400);
    }

    // تحقق مما إذا كان البريد قد تم التحقق منه مسبقًا
    if ($user->hasVerifiedEmail()) {
        return view('email_verify', ['status' => 'success', 'message' => 'Your email is already verified.']);
    }

    // تحقق من الـ hash المرسل مع الرابط
    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        return response()->view('email_verify_failed', ['status' => 'failed', 'message' => 'Invalid verification link.'], 400);
    }

    // تعليم المستخدم بأن البريد تحقق بنجاح
    $user->markEmailAsVerified();
    
    return view('email_verify', ['status' => 'success', 'message' => 'Email verified successfully!']);
})->middleware(['signed'])->name('verification.verify');


Route::get('password/reset', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.reset');







Route::get('/password/email', [ResetPasswordController::class, 'showResetFormWithEmail'])->name('password.reset');



Route::post('/password/update', [ResetPasswordController::class, 'reset'])->name('password.update');





Route::get('/register', function () {
    return view('register');
})->name('register.view');

Route::post('/register', [UserController::class, 'store'])->name('register');
Route::get('/login', function () {
    return view('login');
})->name('login.view');

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/users', function () {
    return view('users');
});

// Admin page route
Route::get('/admin', function () {
    return view('admin');
})->name('admin');