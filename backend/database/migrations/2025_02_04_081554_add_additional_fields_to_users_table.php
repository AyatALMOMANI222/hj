<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('language')->nullable();  // لتحديد اللغة التي يتحدث بها المستخدم
            $table->integer('years_of_experience')->nullable();  // لتخزين عدد سنوات الخبرة إذا كان مدربًا
            $table->enum('training_type', ['beginner', 'advanced', 'highway_driving', 'city_driving'])->nullable();  // نوع التدريب
            $table->string('car_type')->nullable();  // نوع السيارة
            $table->integer('rating')->nullable();  // لتخزين تقييم المدرب أو المركز
            $table->enum('license_type', ['private', 'motorcycle', 'truck'])->nullable();  // نوع الرخصة
            $table->integer('age')->nullable();  // لتخزين عمر المستخدم
            $table->string('session_duration')->nullable();  // لتحديد مدة الدورة التدريبية
            $table->decimal('session_price', 8, 2)->nullable();  // لتخزين سعر الجلسة التدريبية
            $table->enum('session_time', ['morning', 'afternoon', 'evening'])->nullable();  // لتحديد الوقت المتاح للجلسات
            $table->boolean('field_training_available')->default(false);  // لتحديد إذا كان هناك تدريب عملي
            $table->string('test_preparation')->nullable();  // لتحديد إذا كان المدرب أو المركز يقدم تدريباً خاصاً للاختبارات
            $table->enum('special_training_programs', ['women', 'elderly', 'special_needs'])->nullable();  // برامج تدريب خاصة
            $table->boolean('is_active')->default(true);  // لتحديد ما إذا كان الحساب نشطًا
            $table->string('profile_picture')->nullable(); // لإضافة صورة شخصية
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'language',
                'years_of_experience',
                'training_type',
                'car_type',
                'rating',
                'license_type',
                'age',
                'session_duration',
                'session_price',
                'session_time',
                'field_training_available',
                'test_preparation',
                'special_training_programs',
                'is_active',
                'profile_picture'
            ]);
        });
    }
}
