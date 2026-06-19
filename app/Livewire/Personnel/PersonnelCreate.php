<?php

namespace App\Livewire\Personnel;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Services\PersonnelService;
use App\Services\FileUploadService;
use App\Models\Personnel;

class PersonnelCreate extends Component
{
    use WithFileUploads;

    // Form Fields
    public $full_name;
    public $military_id;
    public $b_n;
    public $rank;
    public $primary_specialty;
    public $sub_specialty;
    public $appointment_date;
    public $confirmation_date;
    public $current_promotion_date;
    public $avatar;
    public $status = 'نشط';
    public $notes;
    
    // الحقول الجديدة التي قمنا بإنشائها
    public $phone;
    public $service_years = 0;   // قيم افتراضية تبدأ من الصفر
    public $service_months = 0;  // قيم افتراضية تبدأ من الصفر

   public function mount()
    {
      

     // جلب آخر متدرب تم تسجيله للبحث عن آخر رقم عسكري تم توليده
        // $lastPersonnel = Personnel::where('military_id', 'like', 'P2026%')->latest('id')->first();

        // if ($lastPersonnel) {
        //     // استخراج الجزء الرقمي فقط من الرقم الموجود (مثلاً من P20260001 نأخذ 0001)
        //     // نفترض أن الرقم العسكري طوله دائماً P + 4 خانات للسنة + 4 خانات للترقيم
        //     $lastNumber = (int) substr($lastPersonnel->military_id, 5); 
            
        //     // زيادة الرقم بمقدار 1
        //     $nextNumber = $lastNumber + 1;
            
        //     // إعادة بناء الرقم العسكري مع التنسيق (P + السنة + الرقم المزاد)
        //     $this->military_id = 'P2026' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        // } else {
        //     // في حال عدم وجود سجلات، نبدأ بأول رقم
        //     $this->military_id = 'P20260001';
        // }
    }

  protected function rules()
    {
        return [
            'full_name' => 'required|string|max:255',
            'military_id' => 'required|string|max:255',
            'b_n' => 'required|string|max:255',
            // تعديل السطر أدناه ليقبل أي رتبة مدخلة يدوياً أو مختارة من القائمة
            'rank' => 'required|string|max:100', 
            'primary_specialty' => 'required|string',
            'sub_specialty' => 'required|string',
            'appointment_date' => 'required|date',
            'confirmation_date' => 'required|date',
            'current_promotion_date' => 'nullable|date',
            'avatar' => 'nullable|image|max:2048',
            'status' => 'required|string|in:نشط,غياب,إجازة,تأخير,إذن,مسلم,دورة',
            'notes' => 'nullable|string',
            'phone' => 'nullable|digits:10|unique:personnel,phone', 
            'service_years' => 'required|integer|min:0|max:50',
            'service_months' => 'required|integer|min:0|max:11',
        ];
    }

  public function save()
    {
        // 1. فحص البيانات (سيشمل الحقول الجديدة تلقائياً)
        $validatedData = $this->validate();

        // إجراء وقائي: تعيين صفر كقيمة افتراضية إذا لم يتم إدخال سنوات أو أشهر الخدمة
        $validatedData['service_years'] = $this->service_years ?? 0;
        $validatedData['service_months'] = $this->service_months ?? 0;

        // 2. استدعاء الخدمات عبر الـ Service Container الخاص بـ Laravel لضمان الاستقرار
        $fileService = app(FileUploadService::class);
        $personnelService = app(PersonnelService::class);

        // 3. معالجة الأفاتار من خلال الـ Service الخاصة بك
        if ($this->avatar) {
            $validatedData['avatar'] = $fileService->uploadAvatar($this->avatar);
        }

        // 4. إنشاء السجل العسكري من خلال الـ Service الخاصة بك (ستُحفظ الحقول الجديدة بأمان)
        $personnelService->createPersonnel($validatedData);

        // 5. إطلاق التوست التكتيكي بنجاح
        $this->dispatch('toast', message: 'تم تسجيل الفرد العسكري بنجاح في النظام.', type: 'success');
        
        // 6. التوجيه الآمن وكبس الشاشة
        return redirect()->route('personnel.index');
    }

    public function render()
    {
        return view('livewire.personnel.personnel-create')
            ->layout('layouts.app');
    }
}

