<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_officer', function (Blueprint $table) {
            $table->id(); 
            
            // الربط الصحيح والمباشر مع جدول الضباط الجديد (officers)
            $table->foreignId('officer_id')->constrained('officers')->onDelete('cascade');
            
            // الربط مع جدول الدورات التدريبية (courses)
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            
            // الحقول الإضافية العسكرية والتدريبية
            $table->string('cert_number')->nullable(); // رقم وثيقة أو شهادة التخرج
            $table->string('location')->nullable();    // مكان انعقاد الدورة (مثال: كلية الملك خالد العسكرية)
            $table->date('start_date')->nullable();    // تاريخ بدء البرنامج التدريبي
            
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_officer');
    }
};