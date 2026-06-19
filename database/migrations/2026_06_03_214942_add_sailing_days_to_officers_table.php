<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('officers', function (Blueprint $table) {
            // إضافة حقل أيام الإبحار بعد حقل ساعات الإبحار
            $table->integer('sailing_days')->default(0)->after('sailing_hours');
        });
    }

    public function down(): void
    {
        Schema::table('officers', function (Blueprint $table) {
            $table->dropColumn('sailing_days');
        });
    }
};