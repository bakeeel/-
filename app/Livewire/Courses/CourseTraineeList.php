<?php

namespace App\Livewire\Courses;

use Livewire\Component;
use App\Models\Course;
use App\Models\Trainee; // الاعتماد الكلي والكامل على موديل الأفراد/المتدربين

class CourseTraineeList extends Component
{
    // متغيرات البحث والتصفية للجدول الرئيسي للمتدربين
    public $search = '';
    public $filterStatus = '';

    // متغيرات النافذة المنبثقة المخصصة للمتدربين بالكامل
    public $showTraineeModal = false; 
    public $selectedCourseId;
    public $selectedCourseName;
    public $searchTrainee = ''; // متغير البحث عن المتدرب داخل المودال
    public $selectedTraineeIds = []; // مصفوفة معرفات المتدربين المختارين (trainee_id)

    // متغيرات إضافية لبيانات جدول الربط (Pivot) الخاص بالمتدربين
    public $course_start_date;
    public $course_location;
    public $course_cert_number;

    /**
     * دالة فتح النافذة المنبثقة وإعداد بيانات المتدربين المسجلين
     */
    public function openTraineeModal($courseId)
    {
        $course = Course::find($courseId);
        if ($course) {
            $this->selectedCourseId = $courseId;
            $this->selectedCourseName = $course->name;
            
            // جلب المتدربين المسجلين مسبقاً في هذه الدورة عبر علاقة trainees ليظهروا كـ Checked
            $this->selectedTraineeIds = $course->trainees()->pluck('trainee_id')->map(fn($id) => (string)$id)->toArray();
            
            $this->showTraineeModal = true;
        }
    }

    /**
     * دالة إغلاق المودال وتصفير الحقول (تحل مشكلة الـ MethodNotFoundException)
     */
    public function closeTraineeModal()
    {
        $this->showTraineeModal = false;
        // تصفير الخيارات عند الإغلاق لمنع التداخل بين الدورات
        $this->selectedTraineeIds = [];
        $this->searchTrainee = '';
        $this->reset(['course_start_date', 'course_location', 'course_cert_number']);
    }

    /**
     * دالة حفظ وإسناد المتدربين للدورة (Many-to-Many Sync) في جدول course_trainee
     */
    public function saveTraineeAssignment()
    {
        // 1. التحقق من المدخلات وصحة المعرفات
        $this->validate([
            'selectedCourseId' => 'required|exists:courses,id',
            'selectedTraineeIds' => 'array'
        ]);

        $course = Course::find($this->selectedCourseId);
        $type = 'info';
        $message = '';
        
        if ($course) {
            // 2. جلب معرفات المتدربين المرتبطين بالدورة مسبقاً لمنع التكرار
            $existingTraineeIds = $course->trainees()->pluck('trainee_id')->toArray();

            $addedNames = [];
            $duplicateNames = [];
            $pivotData = [];

            // 3. فرز المتدربين والتحقق من التكرار بناءً على الاسم والرقم العسكري/المدني
            foreach ($this->selectedTraineeIds as $traineeId) {
                if (!empty($traineeId)) {
                    // جلب بيانات المتدرب من موديل Trainee
                    $trainee = Trainee::find($traineeId);
                    if (!$trainee) continue;

                    // الاعتماد على الاسم الكامل والرقم العسكري أو الهوية (military_id أو المتوفر لديك في الموديل)
                    $identity = $trainee->military_id ?? $trainee->identity_number ?? '';
                    $displayName = $trainee->full_name . ($identity ? ' (' . $identity . ')' : '');

                    if (in_array($traineeId, $existingTraineeIds)) {
                        // إذا كان المتدرب مضافاً مسبقاً لهذه الدورة
                        $duplicateNames[] = $displayName;
                    } else {
                        // إذا كان المتدرب جديداً بالكامل على الدورة
                        $addedNames[] = $displayName;
                        
                        // تجهيز بيانات الـ Pivot لجدول الربط الخاص بالمتدربين (course_trainee)
                        $pivotData[$traineeId] = [
                            'start_date'  => $this->course_start_date ?: now()->format('Y-m-d'),
                            'location'    => $this->course_location ?: 'مركز التدريب الرئيسي',
                            'cert_number' => $this->course_cert_number ?: 'TS-TRAIN-' . rand(1000, 9999),
                        ];
                    }
                }
            }

            // 4. تنفيذ الحفظ للمتدربين الجدد فقط دون حذف القدامى في جدول course_trainee
            if (!empty($pivotData)) {
                $course->trainees()->syncWithoutDetaching($pivotData);
            }

            // 5. صياغة الرسالة التوضيحية بناءً على حالة فرز المتدربين
            if (!empty($addedNames) && empty($duplicateNames)) {
                $message = 'تم إسناد الدورة بنجاح للمتدربين: ' . implode('، ', $addedNames);
                $type = 'success';
            } elseif (empty($addedNames) && !empty($duplicateNames)) {
                $message = 'تنبيه: المتدربون المختارون مسجلون في هذه الدورة مسبقاً: ' . implode('، ', $duplicateNames);
                $type = 'warning';
            } else {
                $message = 'تم إضافة المتدربين: (' . implode('، ', $addedNames) . ') | وتجاهل المكررين مسبقاً: (' . implode('، ', $duplicateNames) . ')';
                $type = 'info';
            }

            // إرسال الإشعار للواجهة متوافق مع نظام الـ Toast و الـ Components لديك
            $this->dispatch('toast', [
                'type' => $type,
                'message' => $message
            ]);
        }

        if ($type === 'success' || $type === 'info') {
            $this->closeTraineeModal(); // إغلاق المودال في حال تم تنفيذ الإجراء بنجاح
        } 
    }

    /**
     * دالة حذف الحقيبة التدريبية وفك ارتباط المتدربين بها
     */
    public function delete($id)
    {
        $course = Course::find($id);
        
        if ($course) {
            // فك ارتباط جميع المتدربين بالدورة من جدول course_trainee قبل حذف الدورة نفسها
            $course->trainees()->detach();
            $course->delete();

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'تم حذف الحقيبة التدريبية وإلغاء قيدها من سجلات المتدربين بنجاح.'
            ]);
        }
    }

    public function render()
    {
        // حساب إجمالي المتدربين المسجلين في النظام بالكامل لتغذية الإحصائيات بالواجهة
        $totalRegisteredTrainees = Trainee::count();

        // 1. بناء استعلام البحث والتصفية لدورات المتدربين بشكل ديناميكي مع جلب علاقة trainees
        $courses = Course::query()
            ->with('trainees') // حصر جلب البيانات على علاقة المتدربين المحددة في موديل Course
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('certificate_number', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->latest()
            ->get();

        // 2. بناء استعلام البحث عن المتدربين داخل المودال التفاعلي عند الفتح
        $traineeList = []; // مخصص لعرض قائمة المتدربين المتاحة للإسناد بالـ Blade
        if ($this->showTraineeModal) {
            $traineeList = Trainee::query()
                ->when($this->searchTrainee, function ($query) {
                    $query->where(function($q) {
                        $q->where('full_name', 'like', '%' . $this->searchTrainee . '%')
                          ->orWhere('military_id', 'like', '%' . $this->searchTrainee . '%') // البحث بالرقم العسكري إن وجد
                          ->orWhere('rank', 'like', '%' . $this->searchTrainee . '%'); // البحث بالرتبة/الدرجة
                    });
                })
                ->get();
        }

        // 3. تمرير المصفوفات والمتغيرات الحصرية بالمتدربين إلى واجهة الـ Blade
        return view('livewire.courses.course-trainee-list', [
            'courses'                 => $courses,
            'traineeList'             => $traineeList,
            'totalRegisteredTrainees' => $totalRegisteredTrainees,
        ])->layout('layouts.app');
    }
}