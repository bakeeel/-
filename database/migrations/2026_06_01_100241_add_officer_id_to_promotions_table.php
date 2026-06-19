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
        Schema::table('promotions', function (Blueprint $table) {
            // إضافة العمود مع ربطه بجدول الضباط
            $table->unsignedBigInteger('officer_id')->after('id');
            $table->foreign('officer_id')->references('id')->on('officers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropForeign(['officer_id']);
            $table->dropColumn('officer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
};
