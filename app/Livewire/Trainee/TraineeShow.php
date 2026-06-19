<?php

namespace App\Livewire\Trainee;

use Livewire\Component;
use App\Models\Trainee;

class TraineeShow extends Component
{
    public $traineeId;

    // الاستماع لحدث تحديث المتدربين لإعادة صياغة الـ DOM وتحديث الشاشة تلقائياً
    protected $listeners = [
        'trainee-updated' => '$refresh',
    ];

    /**
     * دالة البناء واستقبال المعرف الرقمي للمتدرب من المسار (Route)
     */
    public function mount($id)
    {
        $this->traineeId = $id;
    }

    /**
     * دالة عملياتية: إسقاط المتدرب من دورة تدريبية محددة
     * تفك الارتباط في جدول course_trainee دون حذف الدورة أو المتدرب من الجداول الأساسية
     * * @param int $courseId
     */
    public function dropCourse($courseId)
    {
        // جلب سجل المتدرب بشكل آمن
        $trainee = Trainee::find($this->traineeId);

        if ($trainee && $courseId) {
            // فك ارتباط المتدرب بالدورة المحددة من جدول الربط الوسيط
            $trainee->courses()->detach($courseId);

            // 🌟 تحديث واجهة المستخدم لحظياً (إعادة تشغيل الـ render تلقائياً بفضل الـ listeners)
            $this->dispatch('trainee-updated');

            // إشعار مستخدم النظام بنجاح العملية لمنظومة الإشعارات
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'تم إسقاط المتدرب من الدورة بنجاح.'
            ]);

            // اختيارياً: دعم جلسات الفلاش التقليدية في النظام
            session()->flash('success', 'تم إسقاط المتدرب من الدورة التدريبية بنجاح.');
        }
    }

    /**
     * دالة العرض وحقن موديل المتدربين عبر الـ Service Container الخاص بـ Laravel
     */
    public function render()
    {
        // جلب ملف المتدرب بشكل كامل وآمن من خلال الـ Model
        $trainee = Trainee::find($this->traineeId);

        // حماية أمنية عسكرية: إذا لم يتم العثور على القيد العسكري للمتدرب يتم كسر العملية فوراً
        if (!$trainee) {
            abort(404, 'لم يتم العثور على ملف المتدرب المستهدف.');
        }

        // 🌟 التأكد من شحن علاقة الدورات محملة بكافة بيانات جداول الربط الوسيطة (course_trainee)
        // تم تدوين الحقول بالكامل لضمان تغذية كود الـ Blade للعمودين دون نقص في البيانات
        $trainee->load(['courses' => function($query) {
            $query->withPivot('id', 'start_date', 'end_date', 'status', 'location');
        }]);

        // توجيه البيانات المقيدة إلى ملف الـ Blade الخاص بعرض تفاصيل المتدربين
        return view('livewire.trainee.trainee-show', [
            'trainee' => $trainee
        ])->layout('layouts.app');
    }
}