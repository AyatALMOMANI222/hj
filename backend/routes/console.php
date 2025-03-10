<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Artisan::command('send:notifications', function () {
    // استدعاء دالة إرسال الإشعارات
    app('App\Http\Controllers\BookingController')->sendNotificationBeforeLesson();
})->describe('Send notifications before lessons');
