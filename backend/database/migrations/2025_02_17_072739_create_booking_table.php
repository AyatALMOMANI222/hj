<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'driving_lessons_id')->constrained('driving_lessons')->onDelete('cascade');
            $table->foreignId('trainee_id')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'confirmed', 'canceled', 'completed', 'postponed'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending'); 
            $table->integer('rating')->nullable()->unsigned()->check('rating >= 1 AND rating <= 5');
            $table->text('feedback')->nullable(); 
            $table->text('notes')->nullable();
            $table->text('trainer_notes')->nullable();
            $table->boolean('is_reminded')->default(false); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('booking');
    }
};
