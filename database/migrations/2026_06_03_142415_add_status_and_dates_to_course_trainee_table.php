<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_trainee', function (Blueprint $table) {
            if (!Schema::hasColumn('course_trainee', 'status')) {
                $table->string('status')->default('مستمر في الدورة')->after('trainee_id');
            }
            if (!Schema::hasColumn('course_trainee', 'start_date')) {
                $table->date('start_date')->nullable()->after('status');
            }
            if (!Schema::hasColumn('course_trainee', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('course_trainee', function (Blueprint $table) {
            $table->dropColumn(['status', 'start_date', 'end_date']);
        });
    }
};