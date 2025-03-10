<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingResponsesTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create('rating_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rating_id')->constrained('ratings')->onDelete('cascade');
            $table->foreignId('responder_id')->constrained('users')->onDelete('cascade');
            $table->text('response');
            $table->enum('type', ['inquiry', 'general'])->default('general');
            $table->timestamps();
        });
    }

    /**
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rating_responses');
    }
}
