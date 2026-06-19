<?php

namespace App\Livewire\Personnel;

use Livewire\Component;
use App\Models\Personnel;
use App\Models\Officer;  
use App\Models\Trainee;  

class PersonnelSearch extends Component
{
    // متغيرات حقول البحث والنوع
    public $search_type = 'personnel'; 
    public $search_name = '';
    public $search_id = '';
    public $search_phone = ''; 
    
    // 🟢 تم تغيير الاسم ونوعه إلى مصفوفة (Array) لمنع الـ Service Container من التخبط مع الموديلات
    public $resultDataArray = null;

    // الاستماع لأحداث التعديل
    protected $listeners = [
        'personnel-updated' => 'refreshSearchData',
        'officer-updated'   => 'refreshSearchData', 
        'trainee-updated'   => 'refreshSearchData', 
    ];

    /**
     * دالة التحديث التلقائي الفوري عند تعديل البيانات
     */
    public function refreshSearchData()
    {
        if ($this->resultDataArray && isset($this->resultDataArray['id'])) {
            if ($this->search_type === 'officer') {
                $record = Officer::with('courses')->find($this->resultDataArray['id']);
            } elseif ($this->search_type === 'trainee') {
                $record = Trainee::with('courses')->find($this->resultDataArray['id']);
            } else {
                $record = Personnel::with('courses')->find($this->resultDataArray['id']);
            }

            if ($record) {
                $this->resultDataArray = $record->toArray();
            }
        }
    }
    
    /**
     * دالة تنفيذ البحث الموحد في السجلات العسكرية
     */
    public function search()
    {
        // 1. التحقق من إدخال قيمة واحدة على الأقل
        if (empty($this->search_name) && empty($this->search_id) && empty($this->search_phone)) {
            $this->dispatch('toast', message: 'يرجى إدخال الاسم، الرقم العسكري/الهوية، أو رقم الهاتف لبدء الاستعلام.', type: 'warning');
            $this->resultDataArray = null;
            return;
        }

        // 2. تحديد الموديل والجدول المستهدف
        if ($this->search_type === 'officer') {
            $query = Officer::query();
            $targetType = 'ضابط';
        } elseif ($this->search_type === 'trainee') {
            $query = Trainee::query();
            $targetType = 'متدرب';
        } else {
            $query = Personnel::query();
            $targetType = 'فرد';
        }

        // 3. بناء الاستعلام
        $query->where(function ($q) {
            if (!empty($this->search_id)) {
                $q->where('military_id', $this->search_id);
            }
            if (!empty($this->search_phone)) {
                $q->where('phone', $this->search_phone);
            }
            if (!empty($this->search_name)) {
                $q->where('full_name', 'like', '%' . $this->search_name . '%');
            }
        });

        // 4. جلب السجل وتحويله فوراً إلى Array لحماية الكود من الـ Binding Resolution
        $record = $query->with('courses')->first();

        if ($record) {
            $this->resultDataArray = $record->toArray();
        } else {
            $this->resultDataArray = null;
            $this->dispatch('toast', message: "لم يتم العثور على أي سجل لـ ($targetType) مطابق للبيانات المدخلة.", type: 'error');
        }
    }

public function render()
{
    return view('livewire.personnel.personnel-search')->layout('layouts.app');
}
}