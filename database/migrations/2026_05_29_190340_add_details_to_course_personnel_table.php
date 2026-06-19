<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('course_personnel', function (Blueprint $table) {
            $table->string('cert_number')->nullable()->after('course_id');
            $table->string('location')->nullable()->after('cert_number');
            $table->date('start_date')->nullable()->after('location');
        });
    }

    public function down(): void
    {
        Schema::table('course_personnel', function (Blueprint $table) {
            $table->dropColumn(['cert_number', 'location', 'start_date']);
        });
    }
};