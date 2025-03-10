<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // تغيير نوع الحقل 'images' إلى JSON
            $table->json('images')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            // إعادة نوع الحقل إلى نوعه السابق (مثال: string)
            $table->string('images')->nullable()->change();
        });
    }
    
};
