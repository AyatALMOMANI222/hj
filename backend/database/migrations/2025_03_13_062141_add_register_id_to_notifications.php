<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->string('register_id')->nullable()->after('user_id'); // إضافة register_id بعد user_id
        });
    }

    /**
     * التراجع عن الترحيل.
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('register_id'); // حذف register_id عند التراجع
        });
    }
};
