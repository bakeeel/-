<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Vacancy;
use Symfony\Component\HttpFoundation\StreamedResponse;

class VacancyManager extends Component
{
    use WithPagination;

    // مصفوفة خفيفة مخصصة لحمل بيانات الموديل الحالي فقط لمنع ثقل الـ Hydration
    public $vacancyForm = [
        'id' => null,
        'vacancy_number' => '',
        'title' => '',
        'status' => 'vacant',
        'notes' => ''
    ];

    // متغير عام للبحث الفوري لتقليل حجم البيانات المسترجعة
    public $search = '';

    protected $rules = [
        'vacancyForm.vacancy_number' => 'required|string|max:50',
        'vacancyForm.title'          => 'nullable|string|max:255',
        'vacancyForm.status'         => 'required|in:vacant,under_action,processing',
        'vacancyForm.notes'          => 'nullable|string',
    ];

    protected $validationAttributes = [
        'vacancyForm.vacancy_number' => 'الرقم الوظيفي',
        'vacancyForm.title'          => 'المسمى الوظيفي',
        'vacancyForm.status'         => 'الحالة',
    ];

    // إعادة التصفح إلى الصفحة الأولى عند كتابة نص جديد في البحث
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // تهيئة حقول الموديل لإنشاء سطر جديد (خفيف وسريع جدًا)
    public function openCreateModal()
    {
        $this->resetErrorBag();
        $this->vacancyForm = [
            'id' => null,
            'vacancy_number' => '',
            'title' => '',
            'status' => 'vacant',
            'notes' => ''
        ];
    }

    // جلب بيانات السطر عبر الـ ID مباشرة باستخدام findOrFail لضمان الكفاءة والأمان
    public function editVacancy($id)
    {
        $this->resetErrorBag();
        $vacancy = Vacancy::findOrFail($id);
        $this->vacancyForm = $vacancy->toArray();
    }

    // عملية الحفظ الفردية المسرعة والمعززة بأداء قواعد البيانات العالي
    public function saveSingleVacancy()
    {
        $this->validate();

        // فحص سريع ومباشر لعدم التكرار دون سحب أي بيانات إضافية (exists)
        $isDuplicate = Vacancy::where('vacancy_number', $this->vacancyForm['vacancy_number'])
            ->when(!empty($this->vacancyForm['id']), function ($query) {
                return $query->where('id', '!=', $this->vacancyForm['id']);
            })->exists();
        
        if ($isDuplicate) {
            $this->addError('vacancyForm.vacancy_number', 'الرقم الوظيفي مستخدم ومسجل مسبقاً في النظام.');
            return;
        }

        // تنفيذ الحفظ السريع (Insert / Update)
        Vacancy::updateOrCreate(
            ['id' => $this->vacancyForm['id']],
            [
                'vacancy_number' => $this->vacancyForm['vacancy_number'],
                'title'          => $this->vacancyForm['title'],
                'status'         => $this->vacancyForm['status'],
                'notes'          => $this->vacancyForm['notes'],
            ]
        );

        session()->flash('message', !empty($this->vacancyForm['id']) ? 'تم تحديث الرقم الوظيفي بنجاح.' : 'تم إضافة الرقم الوظيفي الجديد بنجاح.');

        $this->dispatch('close-modal'); 
    }

    // دالة حذف رقم شاغر سريعة ومباشرة
    public function deleteVacancy($id)
    {
        if ($id) {
            Vacancy::where('id', $id)->delete();
            session()->flash('message', 'تم حذف الرقم الوظيفي بنجاح.');
        }
    }

    // دالة تصدير وتنزيل ملف Excel مصلح ومنسق بترميز يدعم اللغة العربية UTF-8 باستخدام الـ Chunking لمنع انهيار الذاكرة
    public function exportExcel()
        {
            // تسمية الملف باللغة العربية مع الامتداد المباشر لإكسيل .xls
            $fileName = 'تقرير_الأرقام_الوظيفية_الشاغرة_' . date('Y-m-d') . '.xls';

            // استخدام الـ Stream لتنزيل الجدول بهيكل خلايا إكسيل حقيقية تدعم العربية والصفوف المنفصلة
            return response()->streamDownload(function () {
                echo '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
                echo '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><style>td{mso-number-format:"\@"; text-align:right;}</style></head>';
                echo '<body dir="rtl">'; 
                echo '<table border="1">';
                
                // عناوين الأعمدة الرئيسية
                echo '<tr style="background-color: #0f172a; color: #ffffff; font-weight: bold;">';
                echo '<th>م</th>';
                echo '<th>الرقم الوظيفي</th>';
                echo '<th>المسمى الوظيفي</th>';
                echo '<th>الحالة</th>';
                echo '<th>ملاحظات</th>';
                echo '</tr>';

                $counter = 1;

                // جلب البيانات بـ chunk() لحماية الذاكرة والسرعة
                \App\Models\Vacancy::orderBy('id', 'asc')->chunk(200, function($vacancies) use(&$counter) {
                    foreach ($vacancies as $vacancy) {
                        // معالجة مسميات الحالات باللغة العربية
                        $statusLabel = match($vacancy->status) {
                            'vacant'       => 'شاغر',
                            'under_action' => 'تحت الإجراء',
                            'processing'   => 'جاري التثبيت',
                            default        => 'شاغر',
                        };

                        echo '<tr>';
                        echo '<td>' . $counter++ . '</td>';
                        // الفئة mso-number-format المرفقة بالـ style فوق تضمن عدم تحول الأرقام الطويلة إلى ترميز علمي مثل 4.65E+08
                        echo '<td>' . htmlspecialchars($vacancy->vacancy_number) . '</td>';
                        echo '<td>' . htmlspecialchars($vacancy->title ?? '—') . '</td>';
                        echo '<td>' . htmlspecialchars($statusLabel) . '</td>';
                        echo '<td>' . htmlspecialchars($vacancy->notes ?? '—') . '</td>';
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

  public function render()
{
    // حساب الإحصائيات بسرعة وبشكل منفصل من قاعدة البيانات مباشرة
    $totalVacantCount = Vacancy::where('status', 'vacant')->count();
    $totalUnderActionCount = Vacancy::where('status', 'under_action')->count();
    $totalProcessingCount = Vacancy::where('status', 'processing')->count();
    
    // جلب البيانات بشكل مرقم
    $paginatedVacancies = Vacancy::query()
        ->when(!empty($this->search), function($query) {
            $query->where('vacancy_number', 'like', '%' . $this->search . '%')
                  ->orWhere('title', 'like', '%' . $this->search . '%')
                  ->orWhere('notes', 'like', '%' . $this->search . '%');
        })
        ->orderBy('id', 'asc')
        ->paginate(10);

    return view('livewire.vacancy-manager', [
        'totalVacantCount'      => $totalVacantCount,
        'totalUnderActionCount' => $totalUnderActionCount,
        'totalProcessingCount'  => $totalProcessingCount,
        'paginatedVacancies'    => $paginatedVacancies
    ])->layout('layouts.app');
}
}