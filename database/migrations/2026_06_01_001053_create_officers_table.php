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
    Schema::create('officers', function (Blueprint $table) {
        $table->id();
        $table->string('military_id')->unique(); // الرقم العسكري
        $table->string('full_name'); // الاسم الكامل
        $table->string('rank'); // الرتبة (نقيب، رائد، مقدم...)
        $table->string('specialty'); // التخصص
        $table->date('appointment_date'); // تاريخ التعيين
        $table->integer('sailing_hours')->default(0); // ساعات الإبحار
        $table->string('phone')->nullable(); // رقم التواصل
        $table->string('status')->default('نشط'); // الحالة (نشط، إجازة، مهمة...)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('officers');
    }
};
