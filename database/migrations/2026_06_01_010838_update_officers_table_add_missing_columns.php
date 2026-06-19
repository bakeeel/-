<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('officers', function (Blueprint $table) {
            // إضافة الحقول التي تظهر كـ "Unknown column" في الخطأ
            // استخدام nullable() لضمان عدم حدوث خطأ إذا كانت فارغة
            
            if (!Schema::hasColumn('officers', 'notes')) {
                $table->text('notes')->nullable();
            }
            
            if (!Schema::hasColumn('officers', 'sailing_hours')) {
                $table->integer('sailing_hours')->default(0)->nullable();
            }
            
            if (!Schema::hasColumn('officers', 'phone')) {
                $table->string('phone')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('officers', function (Blueprint $table) {
            $table->dropColumn(['notes', 'sailing_hours', 'phone']);
        });
    }
};