<?php

namespace App\Livewire\Trainee;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Trainee;

class TraineeList extends Component
{
    use WithPagination;

    // محركات البحث والفلترة الخاصة بالمتدربين
    public $search = '';
    public $rank = '';
    public $status = '';
    public $specialty = ''; 
    public $service_years = '';

    // 🌟 خاصية التحكم بعدد العناصر المعروضة في الصفحة للمتدربين
    public $perPage = 10;

    // حفظ حالة الفلاتر في الـ URL للرجوع إليها أو مشاركة الرابط بسهولة
    protected $queryString = [
        'search' => ['except' => ''], 
        'rank' => ['except' => ''], 
        'status' => ['except' => ''],
        'specialty' => ['except' => ''],
        'service_years' => ['except' => ''],
        'perPage' => ['except' => 10] // 🌟 تثبيت خيار الترقيم المختار في الـ URL للمتدربين
    ];

    // الاستماع للأحداث الخاصة بالمتدربين لتحديث الجدول تلقائياً بدون تحديث الصفحة
    protected $listeners = [
        'trainee-updated' => '$refresh',
        'trainee-created' => '$refresh' 
    ];

    // إعادة تعيين الصفحة إلى (1) عند تغيير أي فلتر لضمان دقة العرض
    public function updatingSearch() { $this->resetPage(); }
    public function updatingRank() { $this->resetPage(); }
    public function updatingStatus() { $this->resetPage(); }
    public function updatingSpecialty() { $this->resetPage(); } 
    public function updatingServiceYears() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); } // 🌟 تصفير الترقيم عند تغيير حجم عناصر الصفحة

    /**
     * حذف المتدرب نهائياً من النظام العسكري
     */
    public function deleteTrainee(int $id)
    {
        $trainee = Trainee::find($id);
        if ($trainee) {
            $trainee->delete();
            $this->dispatch('toast', message: 'تم حذف المتدرب بنجاح من المنظومة التدريبية.', type: 'success');
        }
    }

    /**
     * تصدير كشف المتدربين الفوري إلى ملف Excel بترميز UTF-16LE لسلامة اللغة العربية
     */
     public function exportToExcel()
        {
            // 1. استعلام ديناميكي مبني على نفس الفلاتر المحددة بالشاشة الحالية
            $trainees = Trainee::query()
                ->when($this->search, function ($q) {
                    $q->where(function ($sub) {
                        $sub->where('full_name', 'like', '%' . $this->search . '%')
                            ->orWhere('military_id', 'like', '%' . $this->search . '%')
                            ->orWhere('phone', 'like', '%' . $this->search . '%');
                    });
                })
                ->when($this->rank, function ($q) {
                    $q->where('rank', $this->rank);
                })
                ->when($this->status, function ($q) {
                    $q->where('status', $this->status);
                })
                ->when($this->specialty, function ($q) {
                    $q->where(function ($sub) {
                        $sub->where('primary_specialty', 'like', '%' . $this->specialty . '%')
                            ->orWhere('sub_specialty', 'like', '%' . $this->specialty . '%');
                    });
                })
                ->when($this->service_years, function ($q) {
                    $q->where('service_years', $this->service_years);
                })
                ->get();

            // 2. تجهيز اسم الملف باللغة العربية مع الامتداد المباشر لإكسيل .xls
            $fileName = 'تقرير_بيانات_المتدربين_' . date('Y-m-d') . '.xls';

            // 3. استخدام الـ streamDownload لتنزيل الجدول بهيكل خلايا إكسيل حقيقية متناسقة
            return response()->streamDownload(function () use ($trainees) {
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
                
                // عناوين الأعمدة الرئيسية (رأس الجدول بثيم الألوان الداكن الموحد)
                echo '<tr style="background-color: #0f172a; color: #ffffff; font-weight: bold;">';
                echo '<th>م</th>';
                echo '<th>الرقم العسكري</th>';
                echo '<th>الاسم الكامل</th>';
                echo '<th>الرتبة</th>';
                echo '<th>رقم الجوال</th>';
                echo '<th>التخصص الرئيسي</th>';
                echo '<th>التخصص الفرعي</th>';
                echo '<th>مدة الخدمة</th>';
                echo '<th>تاريخ التعيين</th>';
                echo '<th>تاريخ التثبيت</th>';
                echo '<th>تاريخ الترقية الحالية</th>';
                echo '<th>الحالة</th>';
                echo '</tr>';

                $counter = 1;

                // 4. طباعة بيانات كل متدرب داخل صف مستقل
                foreach ($trainees as $trainee) {
                    
                    // تجهيز صياغة مدة الخدمة بسلامة
                    $serviceText = $trainee->service_years . ' سنوات ' . $trainee->service_months . ' أشهر';
                    
                    // صياغة التواريخ بسلامة في حال وجودها
                    $appointmentDate = $trainee->appointment_date ? \Carbon\Carbon::parse($trainee->appointment_date)->format('Y-m-d') : '—';
                    $confirmationDate = $trainee->confirmation_date ? \Carbon\Carbon::parse($trainee->confirmation_date)->format('Y-m-d') : '—';
                    $promotionDate = $trainee->current_promotion_date ? \Carbon\Carbon::parse($trainee->current_promotion_date)->format('Y-m-d') : '—';

                    echo '<tr>';
                    echo '<td>' . $counter++ . '</td>';
                    
                    // ستايل mso-number-format يحمي الأرقام العسكرية والهواتف من الاختصار الرياضي أو حذف الأصفار
                    echo '<td>' . htmlspecialchars($trainee->military_id) . '</td>';
                    echo '<td>' . htmlspecialchars($trainee->full_name) . '</td>';
                    echo '<td>' . htmlspecialchars($trainee->rank ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($trainee->phone ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($trainee->primary_specialty ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($trainee->sub_specialty ?? '—') . '</td>';
                    echo '<td>' . htmlspecialchars($serviceText) . '</td>';
                    echo '<td>' . htmlspecialchars($appointmentDate) . '</td>';
                    echo '<td>' . htmlspecialchars($confirmationDate) . '</td>';
                    echo '<td>' . htmlspecialchars($promotionDate) . '</td>';
                    echo '<td>' . htmlspecialchars($trainee->status ?? 'نشط') . '</td>';
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

    /**
     * معالجة الاستعلام وعرض السجلات متوافقة مع الـ Layout الرئيسي للمنظومة
     */
    #[Layout('layouts.app')] 
    public function render()
    {
        // بناء جملة الاستعلام بشكل مرن وتراكمي (Advanced Query Building)
        $query = Trainee::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('full_name', 'like', '%' . $this->search . '%')
                  ->orWhere('military_id', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->rank) {
            $query->where('rank', $this->rank);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        if ($this->specialty) {
            $query->where(function ($q) {
                $q->where('primary_specialty', 'like', '%' . $this->specialty . '%')
                  ->orWhere('sub_specialty', 'like', '%' . $this->specialty . '%');
            });
        }

        if ($this->service_years) {
            $query->where('service_years', $this->service_years);
        }

        // 🌟 استدعاء الترقيم التلقائي بناءً على الخاصية الديناميكية المحددة بـ $this->perPage
        $trainees = $query->latest()->paginate($this->perPage);

        return view('livewire.trainee.trainee-list', [
            'trainees' => $trainees
        ]);
    }
}