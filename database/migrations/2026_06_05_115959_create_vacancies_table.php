<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تشغيل الهجرة لإنشاء جدول الشواغر الوظيفية.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('vacancies', function (Blueprint $table) {
            // المعرف الفريد التلقائي (م) لترقيم الصفوف بالتسلسل
            $table->id();

            // حقل "الرقم الوظيفي" - فريد (Unique) ومفهرس لمنع التكرار وسرعة البحث
            $table->string('vacancy_number')->nullable()->unique();

            // حقل "المسمى الوظيفي"
            $table->string('title')->nullable();

            // حقل "الحالة" باستخدام الـ Enum لحصر الخيارات المتاحة في الصورة:
            // vacant = شاغر | under_action = تحت الإجراء | processing = جاري التثبيت
            $table->enum('status', ['vacant', 'under_action', 'processing'])
                  ->default('vacant');

            // حقل "الملاحظات" للنصوص والشروحات الإضافية لكل صف
            $table->text('notes')->nullable();

            // حقول التوقيت الزمني للنظام تلقائياً (created_at و updated_at)
            $table->timestamps();

            // تحسين الأداء: إضافة فهرس مخصص لحقل الحالة لكثرة الفلترة وعمليات الحساب (Count) عليه
            $table->index('status');
        });
    }

    /**
     * التراجع عن الهجرة وحذف الجدول من قاعدة البيانات.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('vacancies');
    }
};