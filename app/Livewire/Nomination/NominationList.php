<?php

namespace App\Livewire\Nomination;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Officer;
use App\Models\Personnel;
use App\Models\Trainee;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class NominationList extends Component
{
    use WithPagination;

    public $user_type = 'officer'; 
    public $search = '';

    public $selected_model_id; 
    public $course_id;
    public $start_date;
    public $end_date;
    public $status = 'مستمر في الدورة';
    
    // متغيرات الـ Pivot (تستقبل البيانات تلقائياً من جدول الدورات عند الاختيار)
    public $cert_number; 
    public $location;

    public $is_edit_mode = false;
    public $current_pivot_id; 

    protected $paginationTheme = 'tailwind';

    // 🌟 دالة مراقبة ذكية: بمجرد اختيار الدورة، تجلب رقمها وجهتها تلقائياً لجدول الـ Pivot
    public function updatedCourseId($value)
    {
        if (!empty($value)) {
            $course = Course::find($value);
            if ($course) {
                // إذا كنا في وضع "إسناد جديد" فقط، نقوم بسحب البيانات الافتراضية للدورة
                if (!$this->is_edit_mode) {
                    $this->cert_number = $course->certificate_number; // سحب certificate_number إلى cert_number
                    $this->location = $course->location;              // سحب الجهة المنفذة
                }
            }
        } else {
            if (!$this->is_edit_mode) {
                $this->cert_number = '';
                $this->location = '';
            }
        }
    }

public function exportToExcel()
    {
        $config = $this->tableConfig[$this->user_type];

        // تحديد اسم عمود التخصص ديناميكياً حسب نوع المستخدم لمنع خطأ الـ SQL
        $specialtyColumn = ($this->user_type === 'officer') ? 'specialty' : 'primary_specialty';

        // 1. جلب البيانات من قاعدة البيانات وتضمين العمود الديناميكي بالتوافق مع بنيتك البرمجية
        $nominations = DB::table($config['table'])
            ->join($config['route_part'], $config['table'] . '.' . $config['foreign_id'], '=', $config['route_part'] . '.id')
            ->join('courses', $config['table'] . '.course_id', '=', 'courses.id')
            ->select(
                $config['route_part'] . '.' . $config['name_column'] . ' as full_name',
                $config['route_part'] . '.military_id as military_id', 
                $config['route_part'] . '.rank as user_rank',
                $config['route_part'] . '.' . $specialtyColumn . ' as specialty', // جلب التخصص ديناميكياً وتسميته كـ specialty ثابت للطباعة
                $config['route_part'] . '.phone as phone',                         
                $config['route_part'] . '.appointment_date as appointment_date',   
                'courses.name as course_name',
                $config['table'] . '.start_date as start_date', 
                $config['table'] . '.end_date as end_date',     
                $config['table'] . '.location as location',       
               
                $config['table'] . '.status as status'
            )->get();

        // تسمية الملف باللغة العربية مع الامتداد المباشر لإكسيل .xls
        $fileName = "كشف_ترشيح_" . $this->user_type . "_" . now()->format('Y-m-d') . ".xls";

        // 2. استخدام الـ Stream لتنزيل الجدول بهيكل خلايا إكسيل حقيقية
        return response()->streamDownload(function () use ($nominations) {
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><style>td{mso-number-format:"\@"; text-align:right;}</style></head>';
            echo '<body dir="rtl">'; 
            echo '<table border="1">';
            
            // عناوين الأعمدة
            echo '<tr style="background-color: #0f172a; color: #ffffff; font-weight: bold;">';
            echo '<th>الرقم العسكري</th>';
            echo '<th>الاسم الكامل</th>';
            echo '<th>الرتبة</th>';
            echo '<th>التخصص</th>';
            echo '<th>رقم الهاتف</th>';
            echo '<th>تاريخ التعيين</th>';
            echo '<th>الدورة التدريبية</th>';
            echo '<th>تاريخ البداية</th>';
            echo '<th>تاريخ الانتهاء</th>';
            echo '<th>الجهة المنفذة</th>';
           
            echo '<th>الحالة الإدارية</th>';
            echo '</tr>';

            // تعبئة الصفوف
            foreach ($nominations as $row) {
                $rank = ($row->user_rank && $row->user_rank !== '') ? $row->user_rank : 'تحت التدريب';
                
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row->military_id) . '</td>';
                echo '<td>' . htmlspecialchars($row->full_name) . '</td>';
                echo '<td>' . htmlspecialchars($rank) . '</td>';
                echo '<td>' . htmlspecialchars($row->specialty ?? '—') . '</td>'; // طباعة التخصص المستدعى ديناميكياً بسلامة
                echo '<td>' . htmlspecialchars($row->phone ?? '—') . '</td>';
                echo '<td>' . htmlspecialchars($row->appointment_date ?? '—') . '</td>';
                echo '<td>' . htmlspecialchars($row->course_name) . '</td>';
                echo '<td>' . htmlspecialchars($row->start_date ?? '—') . '</td>';
                echo '<td>' . htmlspecialchars($row->end_date ?? '—') . '</td>';
                echo '<td>' . htmlspecialchars($row->location ?? '—') . '</td>';
            
                echo '<td>' . htmlspecialchars($row->status) . '</td>';
                echo '</tr>';
            }

            echo '</table>';
            echo '</body>';
            echo '</html>';
        }, $fileName, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=' . $fileName,
        ]);
    }
protected function rules()
{
    $config = $this->tableConfig[$this->user_type];

    return [
        'course_id' => [
            'required',
            'exists:courses,id',
            function ($attribute, $value, $fail) use ($config) {
                if (!$this->is_edit_mode) {
                    $exists = DB::table($config['table'])
                        ->where($config['foreign_id'], $this->selected_model_id)
                        ->where('course_id', $value)
                        ->exists();

                    if ($exists) {
                        $fail('هذا المنسوب مسجل بالفعل في هذه الدورة التدريبية مسبقاً.');
                    }
                } else {
                    $currentRecord = DB::table($config['table'])->where('id', $this->current_pivot_id)->first();
                    if ($currentRecord) {
                        $exists = DB::table($config['table'])
                            ->where($config['foreign_id'], $currentRecord->{$config['foreign_id']})
                            ->where('course_id', $value)
                            ->where('id', '!=', $this->current_pivot_id)
                            ->exists();

                        if ($exists) {
                            $fail('هذا المنسوب مسجل بالفعل في هذه الدورة التدريبية في سجل آخر.');
                        }
                    }
                }
            }
        ],
        'start_date' => 'required|date',
        'end_date'   => 'required|date|after_or_equal:start_date',
        // 🟢 تم التصحيح هنا: جمع كافة الحالات داخل سياق نصي موحد ومغلق
       'status' => 'required|in:مستمر في الدورة,أكمل الدورة,إسقاط من الدورة,تم الترشيح,تعميد للتحضير',      
        'location'   => 'nullable|string|max:255',
    ];
}

    private $tableConfig = [
        'officer' => [
            'table' => 'course_officer', 
            'foreign_id' => 'officer_id', 
            'model' => Officer::class, 
            'route_part' => 'officers',
            'name_column' => 'full_name' 
        ],
        'personnel' => [
            'table' => 'course_personnel', 
            'foreign_id' => 'personnel_id', 
            'model' => Personnel::class, 
            'route_part' => 'personnel', 
            'name_column' => 'full_name' 
        ],
        'trainee' => [
            'table' => 'course_trainee', 
            'foreign_id' => 'trainee_id', 
            'model' => Trainee::class, 
            'route_part' => 'trainees',
            'name_column' => 'full_name' 
        ],
    ];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingUserType() { $this->resetPage(); $this->search = ''; $this->is_edit_mode = false; }

    public function render()
    {
        $courses = Course::all();
        $config = $this->tableConfig[$this->user_type];
        $modelClass = $config['model'];
        $query = $modelClass::query();

        if (!empty($this->search)) {
            $query->where(function($q) use ($config) {
                $q->where($config['name_column'], 'like', '%' . $this->search . '%')
                  ->orWhere('military_id', 'like', '%' . $this->search . '%');
            });
        }

        $candidates = $query->select(['id', $config['name_column'] . ' as full_name', 'military_id', 'rank'])->paginate(10);

        $nominations = DB::table($config['table'])
            ->join($config['route_part'], $config['table'] . '.' . $config['foreign_id'], '=', $config['route_part'] . '.id')
            ->join('courses', $config['table'] . '.course_id', '=', 'courses.id')
            ->select(
                $config['table'] . '.id as id', 
                $config['table'] . '.course_id', 
                $config['table'] . '.status', 
                $config['table'] . '.start_date as start_date', 
                $config['table'] . '.end_date as end_date',     
             
                $config['table'] . '.location as location',       
                $config['route_part'] . '.' . $config['name_column'] . ' as user_name', 
                $config['route_part'] . '.id as user_raw_id',
                $config['route_part'] . '.military_id as military_id', 
                $config['route_part'] . '.rank as user_rank', 
                'courses.name as course_name'
            )->get();

        return view('livewire.nomination.nomination-list', [
            'candidates' => $candidates,
            'courses' => $courses,
            'nominations' => $nominations
        ])->layout('layouts.app');
    }

    public function openNominateModal($id)
    {
        $this->resetValidation();
        $this->is_edit_mode = false;
        
        $this->selected_model_id = $id;
        $this->course_id = '';
        $this->start_date = '';
        $this->end_date = '';
        $this->status = 'مستمر في الدورة';
     
        $this->location = '';    
        
        $this->dispatch('open-modal', 'nomination-modal');
    }

    public function openEditModal($pivotId)
    {
        $this->resetValidation();
        $this->is_edit_mode = true;
        $this->current_pivot_id = $pivotId;

        $config = $this->tableConfig[$this->user_type];
        $pivotData = DB::table($config['table'])->where('id', $pivotId)->first();

        if ($pivotData) {
            $this->course_id = $pivotData->course_id;
            $this->start_date = $pivotData->start_date ?? '';
            $this->end_date = $pivotData->end_date ?? '';
            $this->status = $pivotData->status;
          
            $this->location = $pivotData->location ?? '';       
            
            $this->dispatch('open-modal', 'nomination-modal');
        }
    }

    public function saveNomination()
    {
        $this->validate($this->rules());
        $config = $this->tableConfig[$this->user_type];

        $data = [
            'course_id' => $this->course_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
           
            'location' => $this->location,       
            'updated_at' => now(),
        ];

        if ($this->is_edit_mode) {
            DB::table($config['table'])->where('id', $this->current_pivot_id)->update($data);
            session()->flash('message', 'تم تحديث بيانات وتفاصيل الدورة بنجاح في السجل العسكري.');
        } else {
            $data[$config['foreign_id']] = $this->selected_model_id;
            $data['created_at'] = now();
            DB::table($config['table'])->insert($data);
            session()->flash('message', 'تم ترشيح المنسوب وسحب بيانات الدورة وحفظها تلقائياً.');
        }

        $this->dispatch('close-modal', 'nomination-modal');
    }

    public function deleteNomination($pivotId)
    {
        $config = $this->tableConfig[$this->user_type];
        DB::table($config['table'])->where('id', $pivotId)->delete();
        session()->flash('message', 'تم إلغاء ترشيح المنسوب بنجاح.');
    }
}