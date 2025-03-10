<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('type')->nullable();
            $table->string('model')->nullable();
            $table->enum('status', ['available', 'unavailable']);
            $table->string('location')->nullable();
            $table->integer('year')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('color')->nullable();
            $table->integer('seats')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('fuel_type')->nullable();
            $table->integer('mileage')->nullable();
            $table->integer('engine_capacity')->nullable();
            $table->date('last_service_date')->nullable();
            $table->text('notes')->nullable();
            $table->json('images')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
