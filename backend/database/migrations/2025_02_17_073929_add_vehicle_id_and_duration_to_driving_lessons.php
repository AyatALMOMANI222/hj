<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('driving_lessons', function (Blueprint $table) {
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->onDelete('set null'); 
            $table->integer('duration')->nullable()->after('end_time'); 
            $table->enum('training_type', [
                'مبتدئين', 
                'متقدم', 
                'القيادة في الطرق السريعة', 
                'القيادة في المدن',
                'القيادة الليلية', 
                'القيادة في الظروف الجوية السيئة',
                'القيادة في المناطق الجبلية',
                'القيادة الدفاعية',
                'القيادة لذوي الاحتياجات الخاصة',
                'قيادة السيارات ذات الجير اليدوي',
                'قيادة السيارات ذات الجير الأوتوماتيكي'
            ])->nullable();
            
        });
    }

    public function down()
    {
        Schema::table('driving_lessons', function (Blueprint $table) {
            $table->dropForeign(['vehicle_id']);
            $table->dropColumn(['vehicle_id', 'duration','training_type']);
        });
    }
};
