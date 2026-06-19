<?php

namespace App\Livewire\Courses;

use Livewire\Component;
use Livewire\WithPagination; // تفعيل ميزه التنقل بدون تحديث الصفحة
use App\Models\Course;
use App\Models\Personnel; 
use App\Models\Officer;
use App\Models\Trainee;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CourseList extends Component
{
    use WithPagination; // إدراج التريت ليعمل الارتباط بملف الـ Blade تلقائياً

    // اعتماد قالب الترقيم الخاص بـ Tailwind لمنع تصادم الفئات الافتراضية
    protected $paginationTheme = 'tailwind';

    // متغيرات البحث والتصفية للجدول الرئيسي
    public $search = '';
    public $filterStatus = '';
    public $perPage = 10; // المتغير المسؤول عن عدد العناصر بالصفحة

    // متغيرات النافذة المنبثقة
    public $showPersonnelModal = false;
    public $selectedCourseId;
    public $selectedCourseName;
    public $searchPersonnel = '';
    public $selectedPersonnelIds = [];

    // بيانات الـ Pivot
    public $course_start_date;
    public $course_location;
    public $course_cert_number;

    // تصفير الصفحة عند التغيير لضمان عدم الوقوع في صفحة فارغة
    public function updatingSearch() { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); } // تصفير الصفحة عند تغيير حجم السجلات

    public function openPersonnelModal($courseId)
    {
        $course = Course::find($courseId);
        if ($course) {
            $this->selectedCourseId = $courseId;
            $this->selectedCourseName = $course->name;
            // جلب المنسوبين المرتبطين (افتراضياً من جدول الأفراد)
            $this->selectedPersonnelIds = $course->personnel()->pluck('personnel_id')->map(fn($id) => (string)$id)->toArray();
            $this->showPersonnelModal = true;
        }
    }

    public function closePersonnelModal()
    {
        $this->showPersonnelModal = false;
        $this->selectedPersonnelIds = [];
        $this->searchPersonnel = '';
    }

    public function savePersonnelToCourse()
    {
        $this->validate([
            'selectedCourseId' => 'required|exists:courses,id',
            'selectedPersonnelIds' => 'array'
        ]);

        $course = Course::find($this->selectedCourseId);
        
        if ($course) {
            // تنفيذ الإسناد لجدول المنسوبين (Personnel)
            $course->personnel()->syncWithoutDetaching($this->selectedPersonnelIds);
            
            $this->dispatch('toast', [
                'type' => 'success', 
                'message' => 'تم تحديث سجلات الدورة بنجاح.'
            ]);
            $this->closePersonnelModal();
        }
    }

    /**
     * دالة الحذف المفقودة (حل مشكلة MethodNotFoundException)
     */
    public function delete($id)
    {
        $course = Course::find($id);

        if ($course) {
            // 1. تنظيف العلاقات في جداول الربط الثلاثية أولاً لمنع قيود مفاتيح قاعدة البيانات
            DB::table('course_officer')->where('course_id', $id)->delete();
            DB::table('course_personnel')->where('course_id', $id)->delete();
            DB::table('course_trainee')->where('course_id', $id)->delete();

            // 2. حذف الدورة نفسها نهائياً
            $course->delete();

            // 3. إرسال تنبيه نجاح للمستخدم
            $this->dispatch('toast', [
                'type' => 'success', 
                'message' => 'تم حذف الحقيبة التدريبية وكافة سجلات الارتباط التابعة لها بنجاح.'
            ]);
        }
    }

    /**
     * دالة تصدير الدورات المفلترة الحالية إلى ملف إكسيل حماية كاملة للغة العربية
     */
    public function exportToExcel()
    {
        // 1. جلب بيانات الدورات بناءً على حالة البحث والفلترة الحالية بدون تحديد حجم الصفحات
        $courses = \App\Models\Course::query()
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

        // 2. تجهيز اسم الملف باللغة العربية مع الامتداد المباشر لإكسيل .xls
        $fileName = 'تقرير_الدورات_والحقائب_' . date('Y-m-d') . '.xls';

        // 3. استخدام الـ streamDownload لتنزيل الجدول بهيكل خلايا إكسيل حقيقية متناسقة
        return response()->streamDownload(function () use ($courses) {
            
            // إرسال الـ BOM لضمان قراءة إكسيل للغة العربية فوراً ومنع الرموز الغريبة
            echo "\xEF\xBB\xBF";
            
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <x:DisplayRightToLeft/>
                                    </x:WorksheetOptions>
                                </x:ExcelWorksheet>
                            </x:ExcelWorksheets>
                        </x:ExcelWorkbook>
                    </xml>
                    <![endif]-->
                    <style>
                        body { font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; }
                        table { border-collapse: collapse; margin: 20px 0; font-size: 14px; width: 100%; }
                        th, td { border: 1px solid #cbd5e1; padding: 10px 12px; text-align: right; }
                        
                        /* تنسيق خاص بالخلايا لمنع تشويه أرقام الوثائق الطويلة والأعداد */
                        td.text-cell { mso-number-format:"\@"; text-align: right; }
                        td.number-cell { mso-number-format:"\#\,\#\#0"; text-align: right; }
                        
                        th { font-weight: bold; font-size: 13px; }
                    </style>
                </head>';
            echo '<body dir="rtl">'; 
            echo '<table>';
            
            // 4. عناوين الأعمدة الرئيسية (رأس الجدول بثيم الألوان الداكن الموحد والأنيق)
            echo '<tr style="background-color: #0f172a; color: #ffffff; height: 35px;">';
            echo '<th style="width: 140px;">رقم الوثيقة</th>';
            echo '<th style="width: 240px;">اسم الدورة التدريبية</th>';
            echo '<th style="width: 110px;">التصنيف</th>';
            echo '<th style="width: 120px;">تاريخ البدء</th>';
            echo '<th style="width: 120px;">تاريخ الانتهاء</th>';
            echo '<th style="width: 110px;">المدة (أيام)</th>';
            echo '<th style="width: 180px;">الجهة القائمة / المكان</th>';
            echo '<th style="width: 100px;">عدد الضباط</th>';
            echo '<th style="width: 100px;">عدد الأفراد</th>';
            echo '<th style="width: 100px;">عدد المتدربين</th>';
            echo '<th style="width: 110px;">إجمالي الحضور</th>';
            echo '<th style="width: 120px;">الحالة التشغيلية</th>';
            echo '</tr>';

            $counter = 1;

            // 5. كتابة بيانات كل دورة في سطر مستقل
            foreach ($courses as $course) {
                // جلب الأعداد الفعلية من جداول الربط الثلاثية المرتبطة بالدورة
                $courseOfficers = \DB::table('course_officer')->where('course_id', $course->id)->count();
                $courseSoldiers = \DB::table('course_personnel')->where('course_id', $course->id)->count();
                $courseTrainees = \DB::table('course_trainee')->where('course_id', $course->id)->count();
                $courseTotal    = $courseOfficers + $courseSoldiers + $courseTrainees;

                // تحويل نوع الدورة إلى لغة عربية مفهومة
                $typeMapping = [
                    'tactical' => 'متوسط',
                    'advanced' => 'متقدم',
                    'basic'    => 'تأسيسي'
                ];
                $courseType = $typeMapping[$course->type] ?? $course->type;

                // تلوين الصفوف بشكل تبادلي (Zebra striping) لمظهر مريح للقراءة
                $bgColor = ($counter % 2 == 0) ? '#f8fafc' : '#ffffff';
                $counter++;

                echo '<tr style="background-color: ' . $bgColor . '; height: 28px;">';
                
                // العمود الأول: رقم الوثيقة كـ Text مفرغ محمي تلقائياً بكلاس text-cell
                echo '<td class="text-cell">' . htmlspecialchars($course->certificate_number) . '</td>';
                echo '<td>' . htmlspecialchars($course->name) . '</td>';
                echo '<td>' . htmlspecialchars($courseType) . '</td>';
                
                // معالجة التواريخ لطباعتها بنظافة وثبات
                echo '<td class="text-cell">' . htmlspecialchars($course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('Y-m-d') : '—') . '</td>';
                echo '<td class="text-cell">' . htmlspecialchars($course->end_date ? \Carbon\Carbon::parse($course->end_date)->format('Y-m-d') : '—') . '</td>';
                
                echo '<td>' . htmlspecialchars($course->duration_days) . ' يوم</td>';
                echo '<td>' . htmlspecialchars($course->location ?? 'غير محدد') . '</td>';
                
                // خانات الأعداد الرقمية المنسقة
                echo '<td class="number-cell">' . $courseOfficers . '</td>';
                echo '<td class="number-cell">' . $courseSoldiers . '</td>';
                echo '<td class="number-cell">' . $courseTrainees . '</td>';
                echo '<td class="number-cell" style="font-weight: bold; color: #1e40af;">' . $courseTotal . '</td>';
                
                echo '<td>' . htmlspecialchars($course->status ?? 'غير محدد') . '</td>';
                echo '</tr>';
            }

            echo '</table>';
            echo '</body>';
            echo '</html>';
        }, $fileName, [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=' . urlencode($fileName),
        ]);
    }

    public function render()
    {
        // 1. الاستعلام المباشر عبر Eloquent مع دمج ميزة الـ Pagination الأساسية من Livewire بشكل صحيح ومستقر
        $courses = Course::query()
            ->with('personnel')
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
            ->paginate($this->perPage); // الترقيم الدايناميكي المبني على اختيار المستخدم

        // 2. حساب الأعداد من الجداول الرئيسية لضمان عدم حدوث تصادم مع الـ Pivot
        $totalOfficersCount = Officer::count();
        $totalSoldiersCount = Personnel::count();
        $totalTraineesCount = Trainee::count();
        
        // إجمالي المنسوبين الكلي بالنظام
        $totalRegisteredPersonnel = $totalOfficersCount + $totalSoldiersCount + $totalTraineesCount;

        // 3. جلب القائمة داخل الـ Modal بناءً على جدول الـ personnel مع دعم البحث
        $personnelList = Personnel::query()
            ->when($this->searchPersonnel, function ($query) {
                $query->where(function($q) {
                    $q->where('full_name', 'like', '%' . $this->searchPersonnel . '%')
                      ->orWhere('military_id', 'like', '%' . $this->searchPersonnel . '%');
                });
            })->get();

        return view('livewire.courses.course-list', [
            'courses' => $courses,
            'personnelList' => $personnelList,
            'totalRegisteredPersonnel' => $totalRegisteredPersonnel,
            'totalOfficersCount' => $totalOfficersCount,
            'totalSoldiersCount' => $totalSoldiersCount,
            'totalTraineesCount' => $totalTraineesCount,
        ])->layout('layouts.app');
    }
}