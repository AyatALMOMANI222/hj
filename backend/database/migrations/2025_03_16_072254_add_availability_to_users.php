<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->time('available_from')->nullable();
            $table->time('available_to')->nullable();
            $table->integer('break_time_duration')->nullable();
            $table->integer('lesson_duration')->nullable();
            $table->string('available_days')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['available_from', 'available_to', 'break_time_duration', 'lesson_duration', 'available_days']);
        });
    }
};
