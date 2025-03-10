<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('trainer_id')->constrained('users')->onDelete('cascade');
            $table->integer('rating')->default(0);
            $table->text('feedback')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
