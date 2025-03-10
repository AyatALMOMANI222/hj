<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('center_name')->nullable();
            $table->string('center_location')->nullable();
        });
    }

    public function down(): void {
        Schema::table('centers', function (Blueprint $table) {
            $table->dropColumn(['center_name', 'center_location']);
        });}
};
