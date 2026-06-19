<?php

namespace App\Livewire\Officer;

use Livewire\Component;
use App\Repositories\Contracts\OfficerRepositoryInterface;

class OfficerShow extends Component
{
    public $officerId;

    // الاستماع لحدث تحديث الضباط لإعادة صياغة الـ DOM وتحديث الشاشة تلقائياً
    protected $listeners = [
        'officer-updated' => '$refresh',
    ];

    /**
     * دالة البناء واستقبال المعرف الرقمي للضابط من المسار (Route)
     */
    public function mount($id)
    {
        $this->officerId = $id;
    }

    /**
     * دالة تكتيكية لإسقاط فرد من دورة تدريبية معينة (Pivot Detach)
     * 
     * @param int $courseId
     * @param OfficerRepositoryInterface $repo
     */
    public function dropCourse($courseId, OfficerRepositoryInterface $repo)
    {
        // 1. جلب قيد الضابط عبر المستودع آمن برمجياً
        $officer = $repo->findById($this->officerId);

        if ($officer) {
            // 2. فك ارتباط الدورة من جدول الربط الوسيط (Pivot Table)
            $officer->courses()->detach($courseId);

            // 3. إطلاق تنبيه للمنظومة بنجاح العملية (أو استخدام إشعارات الـ SweetAlert/Toaster إذا كانت مدعومة لديك)
            $this->dispatch('officer-updated');
            
            // اختياري: إذا كنت تستخدم حزم إشعارات بصرية في النظام
            session()->flash('success', 'تم إسقاط الفرد من الدورة التدريبية بنجاح.');
        }
    }

    /**
     * دالة العرض وحقن مستودع الضباط عبر الـ Service Container الخاص بـ Laravel
     */
    public function render(OfficerRepositoryInterface $repo)
    {
        // جلب ملف الضابط بشكل كامل وآمن من خلال الـ Repository
        $officer = $repo->findById($this->officerId);

        // حماية أمنية عسكرية: إذا لم يتم العثور على القيد العسكري للضابط يتم كسر العملية فوراً
        if (!$officer) {
            abort(404, 'لم يتم العثور على ملف الضابط المستهدف.');
        }

        // 🌟 التأكد من شحن علاقة الدورات محملة بكافة بيانات جداول الربط الوسيطة
        // تم تضمين العلاقات الأساسية بشكل صريح لتفادي مشكلة الـ N+1 Query
        $officer->load(['courses' => function($query) {
            $query->withPivot('start_date', 'end_date', 'status');
        }]);

        // توجيه البيانات المقيدة إلى ملف الـ Blade الخاص بعرض تفاصيل الضباط
        return view('livewire.officer.officer-show', [
            'officer' => $officer
        ])->layout('layouts.app');
    }
}