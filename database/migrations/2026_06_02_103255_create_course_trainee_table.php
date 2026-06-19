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
        Schema::create('course_trainee', function (Blueprint $table) {
            $table->id();
            // الربط مع جدول المتدربين (عند حذف المتدرب تحذف سجلات دوراته تلقائياً Cascade)
            $table->foreignId('trainee_id')->constrained('trainees')->onDelete('cascade');
            
            // الربط مع جدول الدورات (تأكد أن اسم جدول الدورات لديك هو 'courses')
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            
            // بيانات الشهادة المخصصة للمتدرب في هذه الدورة بالذات
            $table->string('cert_number')->nullable(); // رقم الشهادة
            $table->date('start_date')->nullable(); // تاريخ بداية دورة المتدرب
            $table->date('end_date')->nullable(); // تاريخ نهاية دورة المتدرب
            $table->string('conducting_entity')->nullable(); // الجهة المنفذة للدورة
            $table->string('grade')->nullable(); // التقدير / النتيجة (امتياز، جيد جداً...)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_trainee');
    }
};