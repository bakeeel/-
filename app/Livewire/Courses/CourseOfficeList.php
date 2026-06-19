<?php

namespace App\Livewire\Courses;

use Livewire\Component;
use App\Models\Course;
use App\Models\Officer; // الاعتماد الكلي والكامل على موديل الضباط

class CourseOfficeList extends Component
{
    // متغيرات البحث والتصفية للجدول الرئيسي للضباط
    public $search = '';
    public $filterStatus = '';

    // متغيرات النافذة المنبثقة المخصصة للضباط بالكامل
    public $showOfficerModal = false; 
    public $selectedCourseId;
    public $selectedCourseName;
    public $searchOfficer = ''; // متغير البحث عن الضابط داخل المودال
    public $selectedOfficerIds = []; // مصفوفة معرفات الضباط المختارين (officer_id)

    // متغيرات إضافية لبيانات جدول الربط (Pivot) الخاص بالضباط
    public $course_start_date;
    public $course_location;
   

    /**
     * دالة فتح النافذة المنبثقة وإعداد بيانات الضباط المسجلين
     */
    public function openOfficerModal($courseId)
    {
        $course = Course::find($courseId);
        if ($course) {
            $this->selectedCourseId = $courseId;
            $this->selectedCourseName = $course->name;
            
            // جلب الضباط المسجلين مسبقاً في هذه الدورة عبر علاقة officers ليظهروا كـ Checked
            $this->selectedOfficerIds = $course->officers()->pluck('officer_id')->map(fn($id) => (string)$id)->toArray();
            
            $this->showOfficerModal = true;
        }
    }

    /**
     * دالة إغلاق المودال وتصفير الحقول (تحل مشكلة الـ MethodNotFoundException)
     */
    public function closeOfficerModal()
    {
        $this->showOfficerModal = false;
        // تصفير الخيارات عند الإغلاق لمنع التداخل بين الدورات
        $this->selectedOfficerIds = [];
        $this->searchOfficer = '';
        $this->reset(['course_start_date', 'course_location', ]);
    }

    /**
     * دالة حفظ وإسناد الضباط للدورة (Many-to-Many Sync) في جدول course_officer
     */
    public function saveOfficers()
    {
        // 1. التحقق من المدخلات وصحة المعرفات
        $this->validate([
            'selectedCourseId' => 'required|exists:courses,id',
            'selectedOfficerIds' => 'array'
        ]);

        $course = Course::find($this->selectedCourseId);
        $type = 'info';
        $message = '';
        
        if ($course) {
            // 2. جلب معرفات الضباط المرتبطين بالدورة مسبقاً لمنع التكرار
            $existingOfficerIds = $course->officers()->pluck('officer_id')->toArray();

            $addedNames = [];
            $duplicateNames = [];
            $pivotData = [];

            // 3. فرز الضباط والتحقق من التكرار بناءً على الاسم والرقم العسكري
            foreach ($this->selectedOfficerIds as $officerId) {
                if (!empty($officerId)) {
                    // جلب بيانات الضابط من موديل Officer
                    $officer = Officer::find($officerId);
                    if (!$officer) continue;

                    $displayName = $officer->full_name . ' (' . $officer->military_id . ')';

                    if (in_array($officerId, $existingOfficerIds)) {
                        // إذا كان الضابط مضافاً مسبقاً لهذه الدورة
                        $duplicateNames[] = $displayName;
                    } else {
                        // إذا كان الضابط جديداً بالكامل على الدورة
                        $addedNames[] = $displayName;
                        
                        // تجهيز بيانات الـ Pivot لجدول الربط الخاص بالضباط (course_officer)
                        $pivotData[$officerId] = [
                            'start_date'  => $this->course_start_date ?: now()->format('Y-m-d'),
                            'location'    => $this->course_location ?: 'كلية الملك خالد العسكرية',
                           
                        ];
                    }
                }
            }

            // 4. تنفيذ الحفظ للضباط الجدد فقط دون حذف القدامى في جدول course_officer
            if (!empty($pivotData)) {
                $course->officers()->syncWithoutDetaching($pivotData);
            }

            // 5. صياغة الرسالة التوضيحية بناءً على حالة فرز الضباط
            if (!empty($addedNames) && empty($duplicateNames)) {
                $message = 'تم إسناد الدورة بنجاح للضباط: ' . implode('، ', $addedNames);
                $type = 'success';
            } elseif (empty($addedNames) && !empty($duplicateNames)) {
                $message = 'تنبيه: الضباط المختارون مسجلون في هذه الدورة مسبقاً: ' . implode('، ', $duplicateNames);
                $type = 'warning';
            } else {
                $message = 'تم إضافة الضباط: (' . implode('، ', $addedNames) . ') | وتجاهل المكررين مسبقاً: (' . implode('، ', $duplicateNames) . ')';
                $type = 'info';
            }

            // إرسال الإشعار للواجهة متوافق مع نظام الـ Toast و الـ Components لديك
            $this->dispatch('toast', [
                'type' => $type,
                'message' => $message
            ]);
        }

        if ($type === 'success' || $type === 'info') {
            $this->closeOfficerModal(); // إغلاق المودال في حال تم تنفيذ الإجراء بنجاح
        } 
    }

    /**
     * دالة حذف الحقيبة التدريبية وفك ارتباط الضباط بها
     */
    public function delete($id)
    {
        $course = Course::find($id);
        
        if ($course) {
            // فك ارتباط جميع الضباط بالدورة من جدول course_officer قبل حذف الدورة نفسها
            $course->officers()->detach();
            $course->delete();

            $this->dispatch('toast', [
                'type' => 'success',
                'message' => 'تم حذف الحقيبة التدريبية وإلغاء قيدها من سجلات الضباط بنجاح.'
            ]);
        }
    }

    public function render()
    {
        // حساب إجمالي الضباط المسجلين في النظام بالكامل لتغذية الإحصائيات بالواجهة
        $totalRegisteredOfficers = Officer::count();

        // 1. بناء استعلام البحث والتصفية لدورات الضباط بشكل ديناميكي مع جلب علاقة officers
        $courses = Course::query()
            ->with('officers') // حصر جلب البيانات على علاقة الضباط المحددة في موديل Course
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

        // 2. بناء استعلام البحث عن الضباط داخل المودال التفاعلي عند الفتح
        $officerList = []; // مخصص لعرض قائمة الضباط المتاحة للإسناد بالـ Blade
        if ($this->showOfficerModal) {
            $officerList = Officer::query()
                ->when($this->searchOfficer, function ($query) {
                    $query->where(function($q) {
                        $q->where('full_name', 'like', '%' . $this->searchOfficer . '%')
                          ->orWhere('military_id', 'like', '%' . $this->searchOfficer . '%')
                          ->orWhere('rank', 'like', '%' . $this->searchOfficer . '%'); // أضفت لك البحث بالرتبة أيضاً
                    });
                })
                ->get();
        }

        // 3. تمرير المصفوفات والمتغيرات الحصرية بالضباط إلى واجهة الـ Blade
        return view('livewire.courses.course-office-list', [
            'courses'                 => $courses,
            'officerList'             => $officerList,
            'totalRegisteredOfficers' => $totalRegisteredOfficers,
        ])->layout('layouts.app');
    }
}