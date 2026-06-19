<?php

namespace App\Livewire\Trainee;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Trainee;            
use App\Services\TraineeService;   
use App\Services\FileUploadService;
use Carbon\Carbon;

class TraineeEdit extends Component
{
    use WithFileUploads; // تفعيل خاصية رفع الملفات

    public $isOpen = false;
    public $traineeId; 
    
    // حقول النموذج
    public $full_name, $military_id, $rank, $primary_specialty, $sub_specialty, $appointment_date, $confirmation_date, $current_promotion_date, $status, $notes;
    
    // الحقول الإضافية للمتدرب
    public $phone;
    public $service_years = 0;
    public $service_months = 0;
    
    // متغيرات الصورة
    public $avatar, $existingAvatar;

    // الاستماع لحدث فتح مودال التعديل الخاص بالمتدربين
    protected $listeners = ['open-edit-modal' => 'openModal'];

    public function openModal($id)
    {
        $trainee = Trainee::findOrFail($id);
        $this->traineeId = $trainee->id;
        $this->full_name = $trainee->full_name;
        $this->military_id = $trainee->military_id;
        
        // إسناد الرتبة النصية مباشرة من السجل (Alpine بالواجهة سيتكفل بالفرز والتحول التلقائي)
        $this->rank = $trainee->rank;
        $this->primary_specialty = $trainee->primary_specialty;
        
        // قراءة وتنسيق التواريخ بأمان
        $this->appointment_date = $trainee->appointment_date ? Carbon::parse($trainee->appointment_date)->format('Y-m-d') : null;
        
        $this->status = $trainee->status;
        $this->notes = $trainee->notes;
        $this->existingAvatar = $trainee->avatar; 
        
        // جلب وإسناد قيم الحقول الإضافية للمتدرب عند فتح المودال
        $this->phone = $trainee->phone;
        $this->service_years = $trainee->service_years ?? 0;
        $this->service_months = $trainee->service_months ?? 0;
        
        $this->isOpen = true;
    }

    public function update()
    {
        // إجراء وقائي: تحويل القيم الفارغة إلى 0 (قبل الفحص) لضمان عدم فشل شرط required
        $this->service_years = ($this->service_years === '' || is_null($this->service_years)) ? 0 : (int)$this->service_years;
        $this->service_months = ($this->service_months === '' || is_null($this->service_months)) ? 0 : (int)$this->service_months;

        // الحصول على اسم الجدول الفعلي ديناميكياً لحماية التحقق الفريد (Unique)
        $tableName = (new Trainee())->getTable();

        // تمرير مصفوفة التحقق بشكل صريح ومباشر (مرن مع الإدخال النصي للرتب حتى 100 حرف)
        $validatedData = $this->validate([
            'full_name' => 'required|string|max:255',
            'military_id' => 'required|string|max:255',
             // تعديل شرط التحقق ليكون نصياً مرناً يقبل الرتب المدخلة باليد لغاية 100 حرف
            'rank' => 'required|string|max:100',
            'primary_specialty' => 'nullable|string|max:255',
            'appointment_date' => 'nullable|date',
            'status' => 'required|string|in:نشط,غياب,إجازة,تأخير,إذن,مسلم,دورة',
            'notes' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048', 
            'phone' => 'nullable|string|max:15|unique:' . $tableName . ',phone,' . $this->traineeId,
            'service_years' => 'required|integer|min:0|max:50',
            'service_months' => 'required|integer|min:0|max:11',
        ]);

        try {
            $trainee = Trainee::findOrFail($this->traineeId);
            
            // استدعاء الخدمات عبر الـ Service Container
            $fileService = app(FileUploadService::class);
            $traineeService = app(TraineeService::class);

            // تحديث الصورة عبر الـ Service في حال رفع صورة جديدة
            if ($this->avatar) {
                $validatedData['avatar'] = $fileService->uploadAvatar($this->avatar);
            } else {
                $validatedData['avatar'] = $this->existingAvatar;
            }

            // تحديث بيانات المتدرب من خلال الـ TraineeService (الرتبة تحفظ مباشرة)
            $traineeService->updateTrainee($trainee, $validatedData);

            $this->isOpen = false;
            $this->reset(['avatar']); // إعادة تعيين حقل الصورة المرفوعة مؤقتاً
            
            // إطلاق التوست والحدث المتوافق مع Livewire 3 القياسي
            $this->dispatch('toast', message: 'تم تحديث كافة بيانات المتدرب بنجاح.', type: 'success');
            
            // إطلاق أحداث التحديث الفوري للواجهات والجداول الخارجية المسموعة
            $this->dispatch('trainee-updated'); 
            $this->dispatch('refreshTraineeShow');

        } catch (\Exception $e) {
            \Log::error('خطأ في تحديث المتدرب: ' . $e->getMessage());
            $this->dispatch('toast', message: 'حدث خطأ أثناء الحفظ: ' . $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.trainee.trainee-edit');
    }
}