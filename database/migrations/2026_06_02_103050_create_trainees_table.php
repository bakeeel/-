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
        Schema::create('trainees', function (Blueprint $table) {
            $table->id();
            $table->string('military_id')->unique(); // الرقم العسكري (فريد ومفهرس للبحث السريع)
            $table->string('full_name'); // الاسم الكامل
            $table->string('phone')->nullable(); // رقم الهاتف
            $table->string('rank'); // الرتبة
            $table->string('primary_specialty')->nullable(); // التخصص الرئيسي
            $table->string('sub_specialty')->nullable(); // التخصص الفرعي
            $table->date('appointment_date')->nullable(); // تاريخ التعيين
            $table->integer('service_years')->default(0); // سنوات الخدمة
            $table->integer('service_months')->default(0); // أشهر الخدمة
            $table->date('confirmation_date')->nullable(); // تاريخ التثبيت
            $table->date('current_promotion_date')->nullable(); // تاريخ الترقية الحالية
            $table->string('avatar')->nullable(); // الصورة الشخصية
            $table->string('status')->default('active'); // الحالة (نشط، منقول، متقاعد... إلخ)
            $table->text('notes')->nullable(); // ملاحظات إضافية
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainees');
    }
};