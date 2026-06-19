<?php

namespace App\Livewire\Officer;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\OfficerService;
use App\Services\FileUploadService;
use App\Models\Officer;

class OfficerCreate extends Component
{
    use WithFileUploads;

    // حقول النموذج (Form Fields) الخاصة بالضابط
    public $full_name;
    public $military_id;
    public $rank;              // يتم استقبال الرتبة مباشرة هنا (سواءً ثابتة أو مكتوبة باليد)
    public $specialty;         // التخصص المباشر للضابط
    public $sub_specialty;
    public $appointment_date;
    public $confirmation_date;
    public $current_promotion_date;
    public $avatar;
    public $status = 'نشط';     // الحالة الافتراضية باللغة العربية
    public $notes;
    public $phone;
    
    // حقل مخصص لشؤون الضباط وساعات القيادة البحرية
    public $sailing_hours = 0;
    public $sailing_days = 0; 

    public function mount()
    {
        // جلب آخر ضابط تم تسجيله للبحث عن آخر رقم عسكري تم توليده
        // $lastOfficer = Officer::where('military_id', 'like', 'O2026%')->latest('id')->first();

        // if ($lastOfficer) {
        //     $lastNumber = (int) substr($lastOfficer->military_id, 5); 
        //     $nextNumber = $lastNumber + 1;
        //     $this->military_id = 'O2026' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        // } else {
        //     $this->military_id = 'O20260001';
        // }
    }
    protected function rules()
    {
        return [
            'full_name' => 'required|string|max:255',
            'military_id' => 'required|string|max:255',
            // تعديل القاعدة لتكون نصاً مفتوحاً يقبل الرتب الثابتة أو اليدوية المكتوبة دون قيود مقيدة
            'rank' => 'required|string|max:100',
            'specialty' => 'required|string',
            'appointment_date' => 'required|date',
            'avatar' => 'nullable|image|max:2048', 
           'status' => 'required|string|in:نشط,غياب,إجازة,تأخير,إذن,مسلم,دورة',
            'notes' => 'nullable|string',
            'phone' => 'nullable|digits:10|unique:officers,phone', 
            'sailing_hours' => 'required|integer|min:0',
            'sailing_days' => 'required|integer|min:0', 
        ];
    }

    public function save()
    {
        // 1. فحص وتحقق البيانات طبقاً للشروط المحدثة والمباشرة
        $validatedData = $this->validate();

        // إجراء وقائي لضمان حفظ ساعات وأيام الإبحار كقيمة رقمية صحيحة
        $validatedData['sailing_hours'] = $this->sailing_hours ?? 0;
        $validatedData['sailing_days'] = $this->sailing_days ?? 0; 

        // 2. استدعاء الخدمات عبر الـ Service Container لضمان الاستقرار
        $fileService = app(FileUploadService::class);
        $officerService = app(OfficerService::class);

        // 3. معالجة ورفع الأفاتار الخاص بالضابط
        if ($this->avatar) {
            $validatedData['avatar'] = $fileService->uploadAvatar($this->avatar);
        }

        // 4. إنشاء السجل العسكري للضابط من خلال الـ OfficerService (الحفظ مباشر ونظيف)
        $officerService->createOfficer($validatedData);

        // 5. إطلاق التوست بنجاح العملية
        $this->dispatch('toast', message: 'تم تسجيل الضابط بنجاح في النظام.', type: 'success');
        
        // 6. التوجيه الآمن إلى جدول بيانات الضباط الأساسي
        return redirect()->route('officer.index');
    }

    public function render()
    {
        return view('livewire.officer.officer-create')
            ->layout('layouts.app');
    }
}