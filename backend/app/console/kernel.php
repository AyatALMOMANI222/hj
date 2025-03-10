<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // الجدولة التي تقوم بإرسال الإشعارات كل يوم (أو أي مدة أخرى)
        $schedule->call(function () {
            app('App\Http\Controllers\BookingController')->sendNotificationBeforeLesson();
        })->daily(); // قم بتحديد المدة الزمنية المناسبة
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        // تسجيل الأوامر المخصصة إذا كنت بحاجة إليها
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
