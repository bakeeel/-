<?php

namespace App\Livewire\Personnel;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\Contracts\PersonnelRepositoryInterface;
use Maatwebsite\Excel\Facades\Excel; // إذا كنت تستخدم حزمة Laravel Excel
use App\Exports\PersonnelExport; // إذا كنت تستخدم ملف Export مخصص

class PersonnelList extends Component
{
    use WithPagination;

    public $search = '';
    public $rank = '';
    public $status = '';
    
    // 🟩 إضافة متغير التخصص ليرتبط بـ wire:model="specialty" في الـ Blade
    public $specialty = ''; 
    
    // 💡 إضافة متغيرات الفلترة الجديدة لتمكين البحث المتقدم بمدة الخدمة
    public $service_years = '';

    // 🌟 خاصية التحكم بعدد العناصر المعروضة في الصفحة
    public $perPage = 10;

    // تحديث مصفوفة الـ queryString لتضمين الفلاتر الجديدة والتخصص في رابط الـ URL
    protected $queryString = [
        'search' => ['except' => ''], 
        'rank' => ['except' => ''], 
        'status' => ['except' => ''],
        'specialty' => ['except' => ''], // 🟩 حفظ فلتر التخصص في الـ URL
        'service_years' => ['except' => ''],
        'perPage' => ['except' => 10] // 🌟 تثبيت خيار الترقيم المختار في الـ URL
    ];

    // الاستماع لأحداث التحديث لإعادة صياغة الجدول تلقائياً
    protected $listeners = [
        'personnel-updated' => '$refresh',
        'personnel-created' => '$refresh' 
    ];

    // إعادة تعيين الصفحة عند تغيير فلاتر البحث لضمان عدم حدوث أخطاء بالصفحات
    public function updatingSearch() { $this->resetPage(); }
    public function updatingRank() { $this->resetPage(); }
    public function updatingStatus() { $this->resetPage(); }
    public function updatingSpecialty() { $this->resetPage(); } // 🟩 تصفير الصفحة عند تغيير التخصص
    public function updatingServiceYears() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); } // 🌟 تصفير الترقيم عند تغيير حجم عناصر الصفحة

    public function deletePersonnel(int $id, PersonnelRepositoryInterface $repo)
    {
        $repo->delete($id);
        $this->dispatch('toast', message: 'تم حذف الفرد بنجاح من المنظومة العسكرية.', type: 'success');
    }

            public function exportToExcel()
        {
            // 1. تجهيز اسم الملف باللغة العربية مع الامتداد المباشر لإكسيل .xls
            $fileName = 'تقرير_الافراد' . date('Y-m-d') . '.xls';

            // 2. استخدام الـ StreamDownload لتنزيل الجدول بهيكل خلايا إكسيل حقيقية
            return response()->streamDownload(function () {
                echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
                echo '<head>
                        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                        <style>
                            td { mso-number-format:"\@"; text-align:right; }
                            th { text-align:right; }
                        </style>
                    </head>';
                echo '<body dir="rtl">'; 
                echo '<table border="1">';
                
                // عناوين الأعمدة (رأس الجدول بنفس ثيم الألوان الداكن الأنيق)
                echo '<tr style="background-color: #0f172a; color: #ffffff; font-weight: bold;">';
                echo '<th>م</th>';
                echo '<th>الرقم العسكري</th>';
                 echo '<th> b_n</th>';
                echo '<th>الاسم الكامل</th>';
                echo '<th>الرتبة</th>';
                echo '<th>رقم الجوال</th>';
                echo '<th>التخصص الرئيسي</th>';
                echo '<th>التخصص الفرعي</th>';
                echo '<th>مدة الخدمة</th>';
                echo '<th>تاريخ التعيين</th>';
                echo '<th>تاريخ التثبيت</th>';
                echo '<th>تاريخ الترقية</th>';
                echo '<th>الحالة</th>';
                echo '</tr>';

                $counter = 1;

                // 3. جلب البيانات باستخدام chunk() بدلاً من all() لحماية الذاكرة والسرعة العالية
                \App\Models\Personnel::orderBy('id', 'asc')->chunk(200, function($personnelList) use(&$counter) {
                    foreach ($personnelList as $person) {
                        
                        // تجهيز صياغة مدة الخدمة بسلامة
                        $serviceText = $person->service_years . ' سنوات ' . $person->service_months . ' أشهر';
                        
                        echo '<tr>';
                        echo '<td>' . $counter++ . '</td>';
                        
                        // الـ mso-number-format المعرف بالأعلى يضمن بقاء الأرقام العسكرية والجوال كنصوص ثابتة لا تفقد الأصفار
                        echo '<td>' . htmlspecialchars($person->military_id) . '</td>';
                         echo '<td>' . htmlspecialchars($person->b_n) . '</td>';
                        echo '<td>' . htmlspecialchars($person->full_name) . '</td>';
                        echo '<td>' . htmlspecialchars($person->rank ?? '—') . '</td>';
                        echo '<td>' . htmlspecialchars($person->phone ?? '—') . '</td>';
                        echo '<td>' . htmlspecialchars($person->primary_specialty ?? '—') . '</td>';
                        echo '<td>' . htmlspecialchars($person->sub_specialty ?? '—') . '</td>';
                        echo '<td>' . htmlspecialchars($serviceText) . '</td>';
                        
                        // طباعة التواريخ المنسقة بسلامة في حال وجودها
                        echo '<td>' . htmlspecialchars($person->appointment_date ? $person->appointment_date->format('Y-m-d') : '—') . '</td>';
                        echo '<td>' . htmlspecialchars($person->confirmation_date ? $person->confirmation_date->format('Y-m-d') : '—') . '</td>';
                        echo '<td>' . htmlspecialchars($person->current_promotion_date ? $person->current_promotion_date->format('Y-m-d') : '—') . '</td>';
                        
                        echo '<td>' . htmlspecialchars($person->status ?? 'غير محدد') . '</td>';
                        echo '</tr>';
                    }
                });

                echo '</table>';
                echo '</body>';
                echo '</html>';
            }, $fileName, [
                'Content-Type' => 'application/vnd.ms-excel',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Disposition' => 'attachment; filename=' . $fileName,
            ]);
        }

    public function render(PersonnelRepositoryInterface $repo)
    {
        // 💡 تضمين الحقول والفلترة الجديدة وإرسالها للـ Repository
        $filters = [
            'search'        => $this->search, // سيبحث بالاسم، الرقم العسكري، أو رقم الهاتف
            'rank'          => $this->rank,
            'status'        => $this->status,
            'specialty'     => $this->specialty, // 🟩 إرسال التخصص إلى الـ Repository ليفلتر بناءً عليه
            'service_years' => $this->service_years, // فلترة الأفراد الذين خدموا مثلاً 5 سنوات
        ];

        // 🌟 تمرير الخاصية المتغيرة $this->perPage بدلاً من الرقم الثابت 10
        $personnel = $repo->getAllAdvanced($filters, $this->perPage);

        return view('livewire.personnel.personnel-list', [
            'personnel' => $personnel
        ])->layout('layouts.app');
    }
}