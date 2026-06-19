<?php

namespace App\Livewire\Trainee;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\TraineeService;   
use App\Services\FileUploadService;
use App\Models\Trainee;            

class TraineeCreate extends Component
{
    use WithFileUploads;

    // حقول النموذج (Form Fields)
    public $full_name;
    public $military_id;            // الرقم العسكري للمتدرب
    public $rank;                   // الرتبة (تستقبل القيم الثابتة واليدوية مباشرة)
    public $primary_specialty;      // التخصص العام
    public $appointment_date;       // تاريخ التعيين / المباشرة
    public $avatar;                 // الصورة الشخصية
    public $status = 'نشط';          // الحالة الافتراضية
    public $notes;                  // ملاحظات
    
    // الحقول الإضافية للمتدرب
    public $phone;
    public $service_years = 0;   
    public $service_months = 0;  

    // public function mount()
    // {
    //     // جلب آخر متدرب تم تسجيله للبحث عن آخر رقم عسكري تم توليده
    //     $lastTrainee = Trainee::where('military_id', 'like', 'T2026%')->latest('id')->first();

    //     if ($lastTrainee) {
    //         $lastNumber = (int) substr($lastTrainee->military_id, 5); 
    //         $nextNumber = $lastNumber + 1;
    //         $this->military_id = 'T2026' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
    //     } else {
    //         $this->military_id = 'T20260001';
    //     }
    // }

    protected function rules()
    {
        return [
            'full_name' => 'required|string|max:255',
            'military_id' => 'required|string|max:255',
            // تعديل شروط التحقق لتصبح نصية مرنة تقبل الرتب المدخلة باليد لغاية 100 حرف
            'rank' => 'required|string|max:100',
            'primary_specialty' => 'required|string',
            'appointment_date' => 'required|date',
            'avatar' => 'nullable|image|max:2048', 
           'status' => 'required|string|in:نشط,غياب,إجازة,تأخير,إذن,مسلم,دورة',
            'notes' => 'nullable|string',
            'phone' => 'nullable|digits:10|unique:trainees,phone', 
            'service_years' => 'required|integer|min:0|max:50',
            'service_months' => 'required|integer|min:0|max:11',
        ];
    }

    public function save()
    {
        // إجراء وقائي: تحويل القيم الفارغة إلى 0 قبل الفحص لمنع فشل شرط required
        $this->service_years = ($this->service_years === '' || is_null($this->service_years)) ? 0 : (int)$this->service_years;
        $this->service_months = ($this->service_months === '' || is_null($this->service_months)) ? 0 : (int)$this->service_months;

        // 1. فحص البيانات بناءً على الـ rules المحدثة والمباشرة
        $validatedData = $this->validate();

        // 2. استدعاء الخدمات عبر الـ Service Container
        $fileService = app(FileUploadService::class);
        $traineeService = app(TraineeService::class); 

        // 3. معالجة الصورة الشخصية (الأفاتار)
        if ($this->avatar) {
            $validatedData['avatar'] = $fileService->uploadAvatar($this->avatar);
        }

        // 4. إنشاء سجل المتدرب الجديد من خلال الخدمة المختصة (الحفظ نظيف ومباشر)
        $traineeService->createTrainee($validatedData);

        // 5. إطلاق التوست بنجاح مخصص للمتدربين
        $this->dispatch('toast', message: 'تم تسجيل المتدرب بنجاح في النظام.', type: 'success');
        
        // 6. التوجيه الآمن لصفحة مؤشر المتدربين
        return redirect()->route('trainee.index'); 
    }

    public function render()
    {
        return view('livewire.trainee.trainee-create')
            ->layout('layouts.app');
    }
}