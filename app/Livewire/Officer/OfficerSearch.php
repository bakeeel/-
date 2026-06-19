<?php

namespace App\Livewire\Officer;

use Livewire\Component;
use App\Models\Officer; // موديل الضباط وعلاقة الدورات المربوطة به

class OfficerSearch extends Component
{
    // متغيرات حقول البحث الخاصة بجناح الضباط
    public $search_name = '';
    public $search_id = '';
    public $search_phone = ''; 
    
    // متغير تخزين بيانات الضابط المعثور عليه لربطه بلوحة العرض التفصيلية
    public $officer = null;

    // الاستماع لحدث التعديل الخاص بالضباط لإبقاء الشاشة متزامنة واحترافية فوراً
    protected $listeners = [
        'officer-updated' => 'refreshOfficerData',
    ];

    /**
     * دالة التحديث التلقائي عند تعديل بيانات الضابط من مودال التعديل العائم
     */
    public function refreshOfficerData()
    {
        if ($this->officer && $this->officer->id) {
            // إعادة جلب بيانات الضابط الحالي مع علاقاته لتحديث الواجهة في نفس اللحظة
            $this->officer = Officer::with('courses')->find($this->officer->id);
        }
    }
    
    /**
     * دالة تنفيذ البحث التكتيكي في السجلات العسكرية للضباط
     */
    public function search()
    {
        // التحقق من إدخال قيمة واحدة على الأقل في حقول البحث الثلاثة لمنع الاستعلامات الفارغة
        if (empty($this->search_name) && empty($this->search_id) && empty($this->search_phone)) {
            $this->dispatch('toast', message: 'يرجى إدخال اسم الضابط، الرقم العسكري، أو رقم الهاتف لبدء الاستعلام.', type: 'warning');
            $this->officer = null;
            return;
        }

        // بناء استعلام البحث الخاص بجدول الضباط
        $query = Officer::query();

        // ترتيب أولويات البحث التكتيكي (الأدق فالأقل دقة) لمنع تشتت الاستعلام
        if (!empty($this->search_id)) {
            // البحث بالرقم العسكري (مطابقة كاملة وضمان الدقة العالية)
            $query->where('military_id', $this->search_id);
        } elseif (!empty($this->search_phone)) {
            // البحث برقم الهاتف المحمول (مطابقة كاملة)
            $query->where('phone', $this->search_phone);
        } elseif (!empty($this->search_name)) {
            // البحث بالاسم (مطابقة جزئية مرنة)
            $query->where('full_name', 'like', '%' . $this->search_name . '%');
        }

        // جلب ملف الضابط مع تحميل علاقة الدورات التدريبية لثبات واجهة العرض والتأهيل
        $this->officer = $query->with('courses')->first();

        if (!$this->officer) {
            $this->dispatch('toast', message: 'لم يتم العثور على أي قيد عسكري مطابق لبيانات الضباط المدخلة.', type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.officer.officer-search')
            ->layout('layouts.app');
    }
}