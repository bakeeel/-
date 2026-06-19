<?php

namespace App\Livewire\Personnel;

use Livewire\Component;
use App\Repositories\Contracts\PersonnelRepositoryInterface;

class PersonnelShow extends Component
{
    public $personnelId;

    // الاستماع لحدث تحديث الأفراد لإعادة صياغة الـ DOM وتحديث الشاشة تلقائياً
    protected $listeners = [
        'personnel-updated' => '$refresh',
    ];

    /**
     * دالة البناء واستقبال المعرف الرقمي للفرد من المسار (Route)
     */
    public function mount($id)
    {
        $this->personnelId = $id;
    }

    /**
     * دالة عملياتية: إسقاط الفرد/المتدرب من دورة تدريبية محددة
     * تفك الارتباط في جدول course_trainee أو course_personnel دون حذف السجلات الأساسية
     * * @param int $courseId
     * @param PersonnelRepositoryInterface $repo
     */
    public function dropCourse($courseId, PersonnelRepositoryInterface $repo)
    {
        // جلب سجل الفرد الحالي عبر المستودع
        $person = $repo->findById($this->personnelId);

        if ($person && $courseId) {
            // فك ارتباط الفرد بالدورة المحددة من جدول الربط الوسيط
            $person->courses()->detach($courseId);

            // 🌟 تحديث واجهة المستخدم لحظياً (إعادة تشغيل الـ render تلقائياً بفضل الـ listeners)
            $this->dispatch('personnel-updated');

            // إرسال إشعار بنجاح العملية لمنظومة الإشعارات (Toast / SweetAlert)
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'تم إسقاط الفرد من الدورة التدريبية بنجاح.'
            ]);
            
            // اختيارياً: دعم نظام جلسات الفلاش التقليدية في النظام
            session()->flash('success', 'تم إسقاط الفرد من الدورة التدريبية بنجاح.');
        }
    }

    /**
     * دالة العرض وحقن مستودع الأفراد عبر الـ Service Container الخاص بـ Laravel
     */
    public function render(PersonnelRepositoryInterface $repo)
    {
        // جلب بيانات الفرد الحالية
        $person = $repo->findById($this->personnelId);

        // حماية أمنية: إرجاع صفحة 404 في حال عدم العثور على السجل
        if (!$person) {
            abort(404, 'لم يتم العثور على ملف قيد الفرد المستهدف.');
        }

        /* | تكتيك برمجي: لضمان تحميل حقول الـ Pivot بالكامل في حال لم تكن محملة افتراضياً في الـ Repository،
         | نقوم بعمل Eager Loading مخصص للحقول المطلوبة من جدول الربط الوسيط بما فيها المعرف والموقع.
         */
        $person->load(['courses' => function($query) {
            $query->withPivot('id', 'start_date', 'end_date', 'status', 'location');
        }]);

        return view('livewire.personnel.personnel-show', [
            'person' => $person
        ])->layout('layouts.app');
    }
}