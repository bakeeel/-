<?php

namespace App\Livewire\Reports;

use Livewire\Component;
use App\Models\Personnel;
use App\Models\Officer; 
use App\Models\Course;
use App\Models\Trainee;
use Illuminate\Support\Facades\DB;

class ReportIndex extends Component
{
    public $report_type = 'personnel_core_courses'; 
    public $time_period = 'full_year'; 

    public $stat_pass_rate = 0;
    public $stat_readiness_rate = 0;
    public $stat_budget_rate = 45; 
    public $stat_general_grade = 'A+';
    public $stat_active_count = 0;

    public $table_data = [];
    public $active_courses_list = []; 

    public function updatedTimePeriod() { $this->calculateReportData(); }
    public function updatedReportType() { $this->calculateReportData(); }

    public function mount()
    {
        $this->calculateReportData();
    }

    public function calculateReportData()
    {
        $this->table_data = [];
        $this->active_courses_list = [];

        $coreCoursesNames = [
            'تأسيسية',
            'متقدمة',
            'مكافحة الحريق وحصر عطب',
            'الصيانة الوقائية (PMS)',
            'إدارة نظم الصيانه (MMS)'
        ];

        if (in_array($this->report_type, ['personnel_core_courses', 'trainee_core_courses'])) {
            $this->active_courses_list = Course::whereIn('name', $coreCoursesNames)
                ->pluck('name', 'id')
                ->toArray();
        } else {
            $this->active_courses_list = Course::pluck('name', 'id')->toArray();
        }

        $dateFilter = function($query) {
            if ($this->time_period === 'q1') {
                $query->whereRaw("MONTH(appointment_date) IN (7, 8, 9)"); 
            } elseif ($this->time_period === 'q2') {
                $query->whereRaw("MONTH(appointment_date) IN (10, 11, 12)");
            } elseif ($this->time_period === 'q3') {
                $query->whereRaw("MONTH(appointment_date) IN (1, 2, 3)");
            } elseif ($this->time_period === 'q4') {
                $query->whereRaw("MONTH(appointment_date) IN (4, 5, 6)");
            } elseif ($this->time_period === 'half_year') {
                $query->whereRaw("MONTH(appointment_date) <= 6");
            }
        };

        // 1. تقرير الضباط
        if ($this->report_type === 'officer_readiness') {
            $query = Officer::with('courses')->select(
                'id', 'military_id', 'full_name', 'rank', 'specialty', 'status',
                'appointment_date', 'sailing_hours', 'sailing_days', 'phone', 'notes'
            );
            $dateFilter($query);
            $this->table_data = $query->latest()->get()->map(function ($officer) {
                return array_merge(
                    $this->mapReportRow($officer, $officer->rank . ' / ' . $officer->full_name, $officer->specialty),
                    [
                        'appointment_date' => $officer->appointment_date ?? '—',
                        'sailing_hours'    => $officer->sailing_hours ?? 0,
                        'sailing_days'     => $officer->sailing_days ?? 0,
                        'phone'            => $officer->phone ?? '—',
                        'notes'            => $officer->notes ?? '—',
                    ]
                );
            })->toArray();

        // 2. تقارير المتدربين
        } else if (in_array($this->report_type, ['trainee_readiness', 'trainee_core_courses'])) { 
            $query = Trainee::with('courses')->select(
                'id', 'military_id', 'full_name', 'rank', 'primary_specialty', 'status',
                'appointment_date', 'service_years', 'service_months', 'phone', 'notes'
            );
            $dateFilter($query);
            $this->table_data = $query->latest()->get()->map(function ($trainee) {
                return array_merge(
                    $this->mapReportRow($trainee, ($trainee->rank ? $trainee->rank . ' / ' : '') . $trainee->full_name, $trainee->primary_specialty),
                    [
                        'appointment_date' => $trainee->appointment_date ?? '—',
                        'confirmation_date'=> '—', // غير موجود في جدول المتدربين حسب الصورة
                        'promotion_date'   => '—', 
                        'service_years'    => $trainee->service_years ?? 0,
                        'service_months'   => $trainee->service_months ?? 0,
                        'phone'            => $trainee->phone ?? '—',
                        'notes'            => $trainee->notes ?? '—',
                    ]
                );
            })->toArray();

        // 3. تقارير الأفراد
        } else if (in_array($this->report_type, ['personnel_readiness', 'personnel_core_courses'])) {
            $query = Personnel::with('courses')->select(
                'id', 'military_id', 'full_name', 'rank', 'primary_specialty', 'sub_specialty', 'status',
                'appointment_date', 'confirmation_date', 'current_promotion_date', 'service_years', 'service_months', 'phone', 'notes'
            );
            $dateFilter($query);
            $this->table_data = $query->latest()->get()->map(function ($person) {
                return array_merge(
                    $this->mapReportRow($person, $person->rank . ' / ' . $person->full_name, $person->primary_specialty, $person->sub_specialty),
                    [
                        'appointment_date' => $person->appointment_date ?? '—',
                        'confirmation_date'=> $person->confirmation_date ?? '—',
                        'promotion_date'   => $person->current_promotion_date ?? '—',
                        'service_years'    => $person->service_years ?? 0,
                        'service_months'   => $person->service_months ?? 0,
                        'phone'            => $person->phone ?? '—',
                        'notes'            => $person->notes ?? '—',
                    ]
                );
            })->toArray();
        }
    }

    private function mapReportRow($model, $title, $metric1 = '—', $metric2 = '—')
    {
        $registered_courses = $model->courses->pluck('name')->toArray();
        $model_course_ids = $model->courses->pluck('id')->toArray();
        
        $course_checks = [];
        foreach ($this->active_courses_list as $courseId => $courseName) {
            $hasCourse = in_array($courseId, $model_course_ids) || in_array(trim($courseName), array_map('trim', $registered_courses));
            $course_checks[$courseId] = $hasCourse ? '✔' : '—';
        }

        return [
            'code'           => $model->military_id ?? '—',
            'title'          => $title,
            'metric_1'       => $metric1, 
            'metric_2'       => $metric2, 
            'status_badge'   => $model->status ?? 'نشط',
            'course_checks'  => $course_checks
        ];
    }

    public function exportExcel()
    {
        $this->calculateReportData();
        
        $fileName = 'strategic-data-' . $this->report_type . '-' . date('Y-m-d') . '.xls';

        if ($this->report_type === 'officer_readiness') {
            $headers = ["الرقم العسكري", "الرتبة", "الاسم الكامل", "التخصص", "تاريخ التعيين", "ساعات الإبحار", "أيام الإبحار", "رقم الهاتف", "الحالة", "ملاحظات"];
            foreach ($this->active_courses_list as $courseName) { $headers[] = $courseName; }
            
        } else if (in_array($this->report_type, ['trainee_readiness', 'trainee_core_courses'])) { 
            $headers = ["الرقم العسكري", "الاسم الكامل", "رقم الهاتف", "الرتبة", "التخصص الرئيسي", "تاريخ التعيين", "سنوات الخدمة", "أشهر الخدمة", "الحالة", "ملاحظات"];
            foreach ($this->active_courses_list as $courseName) { $headers[] = $courseName; }

        } else if (in_array($this->report_type, ['personnel_readiness', 'personnel_core_courses'])) {
            $headers = ["الرقم العسكري", "الرتبة / الإسم كامل", "التصنيف الرئيسي", "التصنيف الفرعي", "تاريخ التعيين", "تاريخ التثبيت", "تاريخ الترقية", "سنوات الخدمة", "أشهر الخدمة", "رقم الهاتف", "ملاحظات"];
            foreach ($this->active_courses_list as $courseName) { $headers[] = $courseName; }
            $headers[] = "الحالة";
        } else {
            $headers = ["رمز السجل (الشهادة)", "اسم الحقيبة التدريبية", "المدة التدريبية", "معدل الكفاءة والامتثال", "الحالة المستندية"];
        }

        return response()->streamDownload(function () use ($headers) {
            echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
            echo '<head>
                    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                    <style>
                        td { mso-number-format:"\@"; text-align:right; }
                        th { text-align:right; font-weight: bold; }
                    </style>
                  </head>';
            echo '<body dir="rtl">'; 
            echo '<table border="1">';
            
            echo '<tr style="background-color: #0f172a; color: #ffffff; font-weight: bold;">';
            foreach ($headers as $header) {
                echo '<th>' . htmlspecialchars($header) . '</th>';
            }
            echo '</tr>';

            foreach ($this->table_data as $row) {
                echo '<tr>';
                
                // تصدير الضباط
                if ($this->report_type === 'officer_readiness') {
                    echo '<td>' . htmlspecialchars($row['code'] ?? '—') . '</td>';
                    $parts = explode(' / ', $row['title'] ?? '—');
                    echo '<td>' . htmlspecialchars($parts[0] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($parts[1] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['metric_1'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['appointment_date'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['sailing_hours'] ?? 0) . '</td>';
                    echo '<td>' . htmlspecialchars($row['sailing_days'] ?? 0) . '</td>';
                    echo '<td>' . htmlspecialchars($row['phone'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['status_badge'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['notes'] ?? '—') . '</td>';
                    
                    if (isset($row['course_checks'])) {
                        foreach ($row['course_checks'] as $checkStatus) {
                            echo '<td>' . htmlspecialchars($checkStatus) . '</td>';
                        }
                    }
                } 
                // تصدير المتدربين
                else if (in_array($this->report_type, ['trainee_readiness', 'trainee_core_courses'])) { 
                    echo '<td>' . htmlspecialchars($row['code'] ?? '—') . '</td>';
                    $parts = explode(' / ', $row['title'] ?? '—');
                    echo '<td>' . htmlspecialchars($parts[1] ?? ($parts[0] ?? '—')) . '</td>';
                    echo '<td>' . htmlspecialchars($row['phone'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($parts[0] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['metric_1'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['appointment_date'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['service_years'] ?? 0) . '</td>';
                    echo '<td>' . htmlspecialchars($row['service_months'] ?? 0) . '</td>';
                    echo '<td>' . htmlspecialchars($row['status_badge'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['notes'] ?? '—') . '</td>';

                    if (isset($row['course_checks'])) {
                        foreach ($row['course_checks'] as $checkStatus) {
                            echo '<td>' . htmlspecialchars($checkStatus) . '</td>';
                        }
                    }
                } 
                // تصدير الأفراد
                else if (in_array($this->report_type, ['personnel_readiness', 'personnel_core_courses'])) {
                    echo '<td>' . htmlspecialchars($row['code'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['title'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['metric_1'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['metric_2'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['appointment_date'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['confirmation_date'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['promotion_date'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['service_years'] ?? 0) . '</td>';
                    echo '<td>' . htmlspecialchars($row['service_months'] ?? 0) . '</td>';
                    echo '<td>' . htmlspecialchars($row['phone'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['notes'] ?? '—') . '</td>';
                    
                    if (isset($row['course_checks'])) {
                        foreach ($row['course_checks'] as $checkStatus) {
                            echo '<td>' . htmlspecialchars($checkStatus) . '</td>';
                        }
                    }
                    echo '<td>' . htmlspecialchars($row['status_badge'] ?? '—') . '</td>';
                } else {
                    echo '<td>' . htmlspecialchars($row['code'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['title'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['metric_1'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['metric_6'] ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($row['status_badge'] ?? '—') . '</td>';
                }

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
    
    public function refreshData() { $this->calculateReportData(); }

    public function render()
    {
        return view('livewire.reports.report-index')->layout('layouts.app');
    }
}