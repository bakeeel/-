<?php

namespace App\Livewire\Courses;

use Livewire\Component;
use App\Models\Course;

class CourseCreate extends Component
{
    // متغيرات النموذج المحدثة لتطابق الـ fillable تماماً
    public $name;
    public $type = 'تطويرية'; // بديل الـ difficulty (مثلاً: tactical, basic, advanced)
    public $start_date;
    public $end_date;
    public $duration_days;
    public $location;
    public $certificate_number;
    public $status = 'قيد الانتظار'; // الحالة الافتراضية (مثلاً: active, pending, completed)

    // قواعد التحقق المحدثة بناءً على الحقول الجديدة
    protected $rules = [
        'name' => 'required|string|max:255',
        'type' => 'required|string|max:100',
        
        'duration_days' => 'required|integer|min:1',
        'location' => 'required|string|max:255',
        'certificate_number' => 'required|unique:courses,certificate_number',
        'status' => 'required|string|in:مستمرة حالياً,قيد الانتظار,مكتملة ومؤرشفة,ملغاة',  ];

    public function mount()
    {
        // توليد الرقم التسلسلي التلقائي للشهادة/الدورة عند فتح الصفحة
        $this->generateCertificateNumber();
    }

    /**
     * دالة توليد رقم السجل/الشهادة التلقائي بشكل تكتيكي
     */
    private function generateCertificateNumber()
    {
        // جلب آخر سجل بناءً على الرقم التسلسلي الجديد
        $lastCourse = Course::latest('id')->first();
        $prefix = 'CERT-TAC';

        if ($lastCourse && $lastCourse->certificate_number) {
            // استخراج الرقم الأخير بعد الشرطة (مثال: CERT-TAC-01 سيستخرج 1)
            $lastNumber = (int) substr($lastCourse->certificate_number, strrpos($lastCourse->certificate_number, '-') + 1);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        // تنسيق الرقم بخانتين (01, 02, 03...)
        $this->certificate_number = $prefix . '-' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);
    }

    /**
     * دالة الحفظ المعتمدة
     */
    public function save()
    {
        // 1. تشغيل التحقق الصارم على البيانات المدخلة
        $validatedData = $this->validate();
        
        // 2. إعادة التوليد قبل الحفظ مباشرة لحماية البيانات من التكرار في قاعدة البيانات
        $this->generateCertificateNumber();
        $validatedData['certificate_number'] = $this->certificate_number;

        // 3. الخزن الفعلي في قاعدة البيانات باستخدام الـ fillable المعتمد لديك
        Course::create($validatedData);
        
        // 4. تأخير الـ UX البصري (نصف ثانية) لتأكيد حركة الـ Loading
        usleep(500000); 

        // 5. إرسال إشعار النجاح للتوست
        $this->dispatch('toast', [
            'type' => 'success',
            'message' => 'تم تسجيل الحقيبة التدريبية بنجاح ودخولها طور الاستعداد.'
        ]);
        
        // 6. التوجيه لصفحة الفهرس
        return redirect()->route('courses.index');
    }

    public function render()
    {
        return view('livewire.courses.course-create')
            ->layout('layouts.app');
    }
}