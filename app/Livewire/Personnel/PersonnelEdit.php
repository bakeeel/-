<?php

namespace App\Livewire\Personnel;

use Livewire\Component;
use App\Models\Personnel;
use Livewire\WithFileUploads; // ضروري لرفع الصور

class PersonnelEdit extends Component
{
    use WithFileUploads; // تفعيل خاصية رفع الملفات

    public $isOpen = false;
    public $personId;
    public $full_name, $military_id, $rank, $primary_specialty, $sub_specialty, $appointment_date, $confirmation_date, $current_promotion_date, $status, $notes;
    
    // المتغيرات الجديدة المضافة لتحديث النموذج
    public $phone;
    public $service_years = 0;
    public $service_months = 0;
    
    // متغيرات الصورة
    public $avatar, $existingAvatar;

    protected $listeners = ['open-edit-modal' => 'openModal'];

    public function openModal($id)
    {
        $person = Personnel::findOrFail($id);
        $this->personId = $person->id;
        $this->full_name = $person->full_name;
        $this->military_id = $person->military_id;
        $this->b_n = $person->b_n;
        $this->rank = $person->rank;
        $this->primary_specialty = $person->primary_specialty;
        $this->sub_specialty = $person->sub_specialty;
        $this->appointment_date = $person->appointment_date?->format('Y-m-d');
        $this->confirmation_date = $person->confirmation_date?->format('Y-m-d');
        $this->current_promotion_date = $person->current_promotion_date?->format('Y-m-d');
        $this->status = $person->status;
        $this->notes = $person->notes;
        $this->existingAvatar = $person->avatar; // جلب الصورة الموجودة
        
        // جلب وإسناد قيم الحقول الجديدة عند فتح المودال للتعديل
        $this->phone = $person->phone;
        $this->service_years = $person->service_years ?? 0;
        $this->service_months = $person->service_months ?? 0;
        
        $this->isOpen = true;
    }

    public function update()
    {
       $this->validate([
        'full_name' => 'required|string|max:255',
        'military_id' => 'required|string|max:255',
         'b_n' => 'required|string|max:255',
        // تعديل السطر أدناه ليدعم الإدخال النصي اليدوي عند التعديل
        'rank' => 'required|string|max:100',
        
        'primary_specialty' => 'nullable|string|max:255',
        'sub_specialty' => 'nullable|string|max:255',
        'appointment_date' => 'nullable|date',
        'confirmation_date' => 'nullable|date',
        'current_promotion_date' => 'nullable|date',
        'status' => 'required|string|in:نشط,غياب,إجازة,تأخير,إذن,مسلم,دورة',
        'notes' => 'nullable|string',
        'avatar' => 'nullable|image|max:2048',
        'phone' => 'nullable|digits:10|unique:personnel,phone,' . $this->personId,
        'service_years' => 'required|integer|min:0|max:50',
        'service_months' => 'required|integer|min:0|max:11',
    ]);

        $person = Personnel::find($this->personId);
        
        // تجهيز بيانات التحديث بما فيها الحقول الجديدة
        $data = [
            'full_name' => $this->full_name,
            'military_id' => $this->military_id,
            'b_n' =>$this->b_n,
            'rank' => $this->rank,
            'primary_specialty' => $this->primary_specialty,
            'sub_specialty' => $this->sub_specialty,
            'appointment_date' => $this->appointment_date,
            'confirmation_date' => $this->confirmation_date,
            'current_promotion_date' => $this->current_promotion_date,
            'status' => $this->status,
            'notes' => $this->notes,
            
            // تعيين قيم الحقول الجديدة لقاعدة البيانات
            'phone' => $this->phone,
            'service_years' => $this->service_years ?? 0,
            'service_months' => $this->service_months ?? 0,
        ];

        // تحديث الصورة في حال رفع صورة جديدة
        if ($this->avatar) {
            $data['avatar'] = $this->avatar->store('avatars', 'public');
        }

        $person->update($data);

        $this->isOpen = false;
        $this->reset(['avatar']); // إعادة تعيين حقل الصورة بعد الحفظ
        
        $this->dispatch('toast', ['type' => 'success', 'message' => 'تم تحديث كافة بيانات الفرد بنجاح.']);
        $this->dispatch('personnel-updated');
    }

    public function render()
    {
        return view('livewire.personnel.personnel-edit');
    }
}