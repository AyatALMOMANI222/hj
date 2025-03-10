<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->change(); // تغيير مؤقت إلى string
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['trainee', 'instructor', 'training_center', 'admin'])->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->change(); // تغيير مؤقت إلى string
        });

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['trainee', 'instructor', 'training_center'])->change();
        });
    }
};
