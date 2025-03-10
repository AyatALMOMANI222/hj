<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('cources', function (Blueprint $table) {
            $table->string('external_instructor_name')->nullable();
            $table->string('external_instructor_email')->nullable();
            $table->string(column: 'external_instructor_phone')->nullable();
            $table->string(column: 'external_instructor_language')->nullable();
        });
    }


    public function down(): void
    {
        Schema::table('cources', function (Blueprint $table) {
            $table->dropColumn(['external_instructor_name', 'external_instructor_email', 'external_instructor_phone']);
        });
    }
};
