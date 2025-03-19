<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->foreignId('trainer_id')->nullable()->constrained('users')->onDelete('cascade'); // ربط المدرب بالمستخدمين
            $table->date('date')->nullable(); // تاريخ الحصة
            $table->time('time')->nullable(); // وقت الحصة
            $table->string('day')->nullable(); // اليوم (مثلاً: "Monday")
            $table->string('starting_location')->nullable(); // مكان الانطلاق
        });
    }

    /**
     * التراجع عن التعديلات
     */
    public function down(): void
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->dropForeign(['trainer_id']);
            $table->dropColumn(['trainer_id', 'date', 'time', 'day', 'starting_location']);
        });
    }
};
