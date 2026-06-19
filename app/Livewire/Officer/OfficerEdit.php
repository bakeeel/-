<?php

namespace App\Livewire\Officer;

use Livewire\Component;
use App\Models\Officer;
use Livewire\WithFileUploads; // ضروري لرفع صور الضباط

class OfficerEdit extends Component
{
    use WithFileUploads; // تفعيل خاصية رفع الملفات

    public $isOpen = false;
    public $officerId;
    public $full_name, $military_id, $rank, $specialty, $sub_specialty, $appointment_date, $confirmation_date, $current_promotion_date, $status, $notes;
    
    // حقل التواصل وحقول الخدمة البحرية المخصصة للضباط
    public $phone;
    public $sailing_hours = 0;
    public $sailing_days = 0; 
    
    // متغيرات الصورة والأفاتار
    public $avatar, $existingAvatar;

    // الاستماع للحدث الموحد وتوجيهه للدالة الوسيطة للتحقق من النوع
    protected $listeners = ['open-edit-modal' => 'handleOpenModal'];

    /**
     * 🟢 التعديل النهائي والذكي لفك الهياكل المعقدة واستنتاج النوع
     * يضمن فتح المودال سواء تم إرسال {id: 5} أو {id: 5, type: 'officer'} أو حتى معاملات مفرودة
     */
    public function handleOpenModal(...$params)
    {
        $id = null;
        // افتراضياً نضع النوع 'officer' لأننا داخل مكون الضباط، لتجنب قفل الشرط إذا لم يرسله الزر
        $type = 'officer'; 

        if (!empty($params)) {
            $firstParam = $params[0];

            // الحالة 1: إذا أرسلت البيانات مفرودة كمفاتيح عادية (مثال: $this->dispatch('open-edit-modal', $id, $type))
            if (!is_array($firstParam)) {
                $id = $firstParam;
                if (isset($params[1])) {
                    $type = $params[1];
                }
            }
            // الحالة 2: إذا جاءت البيانات مغلفة داخل كائن 'data' (بسبب عمليات الـ Hydration الفنية لـ Livewire)
            elseif (is_array($firstParam) && isset($firstParam['data'])) {
                $id = $firstParam['data']['id'] ?? null;
                $type = $firstParam['data']['type'] ?? $type;
            }
            // الحالة 3: إذا جاءت البيانات كمصفوفة مفاتيح مباشرة (مثل الزر الخاص بك: { id: xx })
            elseif (is_array($firstParam)) {
                $id = $firstParam['id'] ?? null;
                $type = $firstParam['type'] ?? $type;
            }
        }

        // تشغيل المودال فوراً بعد تجاوز فخ الـ null في الـ type
        if ($type === 'officer' && $id) {
            $this->openModal($id);
        }
    }

    public function openModal($id)
    {
        $officer = Officer::findOrFail($id);
        $this->officerId = $officer->id;
        $this->full_name = $officer->full_name;
        $this->military_id = $officer->military_id;
        
        // إسناد الرتبة مباشرة
        $this->rank = $officer->rank;

        $this->specialty = $officer->specialty;
        $this->sub_specialty = $officer->sub_specialty;
        
        // جلب التواريخ وتنسيقها بأمان
        $this->appointment_date = $officer->appointment_date ? (\Carbon\Carbon::parse($officer->appointment_date)->format('Y-m-d')) : null;
        $this->confirmation_date = $officer->confirmation_date ? (\Carbon\Carbon::parse($officer->confirmation_date)->format('Y-m-d')) : null;
        $this->current_promotion_date = $officer->current_promotion_date ? (\Carbon\Carbon::parse($officer->current_promotion_date)->format('Y-m-d')) : null;
        
        $this->status = $officer->status;
        $this->notes = $officer->notes;
        $this->existingAvatar = $officer->avatar; 
        
        // جلب حقول الضباط الإضافية وساعات الخدمة البحرية وأيامها
        $this->phone = $officer->phone;
        $this->sailing_hours = $officer->sailing_hours ?? 0;
        $this->sailing_days = $officer->sailing_days ?? 0; 
        
        $this->isOpen = true;
    }

    public function update()
    {
        $validatedData = $this->validate([
            'full_name' => 'required|string|max:255',
            'military_id' => 'required|string|max:255',
            'rank' => 'required|string|max:100',
            'specialty' => 'required|string|max:255',
            'sub_specialty' => 'nullable|string|max:255',
            'appointment_date' => 'required|date', 
            'status' => 'required|string|in:نشط,غياب,إجازة,تأخير,إذن,مسلم,دورة',
            'notes' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048', 
            'phone' => 'nullable|string|max:15|unique:officers,phone,' . $this->officerId,
            'sailing_hours' => 'required|integer|min:0',
            'sailing_days' => 'required|integer|min:0', 
        ]);

        try {
            $officer = Officer::findOrFail($this->officerId);
            
            $officerFields = [
                'full_name' => $this->full_name,
                'military_id' => $this->military_id,
                'rank' => $this->rank,
                'specialty' => $this->specialty,
                'sub_specialty' => $this->sub_specialty,
                'appointment_date' => $this->appointment_date,
                'status' => $this->status,
                'notes' => $this->notes,
                'phone' => $this->phone,
                'sailing_hours' => $this->sailing_hours ?? 0,
                'sailing_days' => $this->sailing_days ?? 0, 
            ];

            if ($this->avatar) {
                $officerFields['avatar'] = $this->avatar->store('avatars', 'public');
            }

            $officer->update($officerFields);

            $this->isOpen = false;
            $this->reset(['avatar']); 
            
            $this->dispatch('toast', type: 'success', message: 'تم تحديث بيانات ملف الضابط بنجاح.');
            $this->dispatch('officer-updated');

        } catch (\Exception $e) {
            \Log::error('خطأ في تحديث الضابط: ' . $e->getMessage());
            $this->dispatch('toast', type: 'error', message: 'فشل التحديث: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.officer.officer-edit', []);
    }
}