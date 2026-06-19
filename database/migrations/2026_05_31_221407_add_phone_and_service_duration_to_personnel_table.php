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
        Schema::table('personnel', function (Blueprint $blue) {
            // إضافة عمود رقم الهاتف (طوله 10 خانات، ويكون فريد غير متكرر وقابل لإلغاء الإلزام nullable إذا لزم الأمر)
            $blue->string('phone', 10)->nullable()->unique()->after('military_id');
            
            // إضافة أعمدة مدة الخدمة (سنوات وأشهر) كأرقام صحيحة موجبة بعد عمود تاريخ التعيين
            $blue->unsignedTinyInteger('service_years')->default(0)->after('appointment_date');
            $blue->unsignedTinyInteger('service_months')->default(0)->after('service_years');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('personnel', function (Blueprint $blue) {
            // حذف الأعمدة في حال تراجعنا عن الـ Migration
            $blue->dropColumn(['phone', 'service_years', 'service_months']);
        });
    }
};