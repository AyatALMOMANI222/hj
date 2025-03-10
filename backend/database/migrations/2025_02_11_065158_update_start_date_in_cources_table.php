<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::table('cources', function (Blueprint $table) {
            $table->dateTime('start_date')->change();
            $table->dateTime('end_date')->nullable()->change();
            $table->decimal('duration',8,2)->change();

        });
    }
                       
                   
    public function down(): void
    {
        Schema::table('cources', function (Blueprint $table) {
            $table->date('start_date')->change(); 
            $table->date('end_date')->nullable()->change(); 
        });
    }
};
