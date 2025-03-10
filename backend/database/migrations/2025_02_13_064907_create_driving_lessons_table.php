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
        Schema::create('driving_lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->nullable()->constrained('cources')->onDelete('set null');
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('center_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->decimal('price', 10, 2)->default(0.00); 
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->string('location')->nullable();
            $table->enum('status', ['pending', 'scheduled', 'completed', 'canceled'])->default('pending');
            $table->integer('max_students')->default(0);
            $table->enum('visibility', ['public', 'registered', 'invited'])->default('registered');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
         
         
            $table->index('start_time');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('driving_lessons');
    }
};
