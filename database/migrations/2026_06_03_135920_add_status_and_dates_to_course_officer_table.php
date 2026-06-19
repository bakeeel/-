<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_officer', function (Blueprint $table) {
            if (!Schema::hasColumn('course_officer', 'status')) {
                $table->string('status')->default('مستمر في الدورة')->after('officer_id');
            }
            if (!Schema::hasColumn('course_officer', 'start_date')) {
                $table->date('start_date')->nullable()->after('status');
            }
            if (!Schema::hasColumn('course_officer', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('course_officer', function (Blueprint $table) {
            $table->dropColumn(['status', 'start_date', 'end_date']);
        });
    }
};