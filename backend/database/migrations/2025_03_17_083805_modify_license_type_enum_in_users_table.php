<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // تعديل ENUM عبر SQL لأنه لا يمكن تغييره مباشرة في Laravel
        DB::statement("ALTER TABLE users MODIFY COLUMN license_type ENUM('private', 'motorcycle', 'truck', 'general') NULL");
    }

    /**
     * التراجع عن التعديلات
     */
    public function down(): void
    {
        // استعادة الحقل بدون "general"
        DB::statement("ALTER TABLE users MODIFY COLUMN license_type ENUM('private', 'motorcycle', 'truck') NULL");
    }
};
