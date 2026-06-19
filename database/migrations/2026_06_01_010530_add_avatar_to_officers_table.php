<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('officers', function (Blueprint $table) {
            // إضافة عمود الصورة ليكون قابلاً للفراغ (nullable)
            $table->string('avatar')->nullable()->after('appointment_date');
        });
    }

    public function down(): void
    {
        Schema::table('officers', function (Blueprint $table) {
            $table->dropColumn('avatar');
        });
    }
};