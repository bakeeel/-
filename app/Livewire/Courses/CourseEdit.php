<?php

namespace App\Livewire\Courses;

use Livewire\Component;
use App\Models\Course;

class CourseEdit extends Component
{
    // تعريف نفس المتغيرات الموجودة في صفحة الإنشاء
    public $courseId;
    public $name;
    public $type;
   
    public $duration_days;
    public $location;
    public $certificate_number;
    public $status = 'قيد الانتظار'; 

    /**
     * تجهيز البيانات وتعبئتها عند تحميل الصفحة
     */
    public function mount(Course $course)
    {
        $this->courseId = $course->id;
        $this->name = $course->name;
        $this->type = $course->type;
      
        $this->duration_days = $course->duration_days;
        $this->location = $course->location;
        $this->certificate_number = $course->certificate_number;
        $this->status = $course->status;
    }

    /**
     * قواعد التحقق (تستثني رقم السجل الحالي من شرط الـ unique)
     */
    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
   
            'duration_days' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'certificate_number' => 'required|unique:courses,certificate_number,' . $this->courseId,
            'status' => 'required|string|in:قيد الانتظار,مستمرة حالياً,مكتملة ومؤرشفة,ملغاة',
        ];
    }

    /**
     * معالجة وحفظ التحديثات
     */
    public function update()
    {
        $this->validate();

        $course = Course::find($this->courseId);
        
        $course->update([
            'name' => $this->name,
            'type' => $this->type,
          
            'duration_days' => $this->duration_days,
            'location' => $this->location,
            'certificate_number' => $this->certificate_number,
            'status' => $this->status,
        ]);

        // إرسال رسالة نجاح وتوجيه المستخدم للجدول الرئيسي
        session()->flash('message', 'تم تحديث البيانات وتعديل وثيقة البرنامج بنجاح.');
        
        return $this->redirect(route('courses.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.courses.course-edit')->layout('layouts.app');
    }
}