<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('cources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('duration');
            $table->decimal('price', 10, 2);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('center_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('cources');
    }
};
