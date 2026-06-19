<?php

namespace App\Livewire\Officer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Repositories\Contracts\OfficerRepositoryInterface;
use Carbon\Carbon;

class OfficerList extends Component
{
    use WithPagination;

    // فلاتر البحث والمطابقة المرتبطة بالواجهة (wire:model)
    public $search = '';
    public $rank = '';
    public $status = '';
    public $specialty = ''; 
    public $sailing_hours = ''; // فلترة مخصصة للضباط بناءً على ساعات الإبحار
    public $sailing_days = ''; // فلترة مخصصة للضباط بناءً على أيام الإبحار
    
    // 🌟 إضافة خاصية التحكم بعدد العناصر في الصفحة وتحديد القيمة الافتراضية
    public $perPage = 10; 

    // الحفاظ على الفلاتر نشطة داخل رابط الـ URL للتنقل المرن
    protected $queryString = [
        'search'        => ['except' => ''], 
        'rank'          => ['except' => ''], 
        'status'        => ['except' => ''],
        'specialty'     => ['except' => ''], 
        'sailing_hours' => ['except' => ''],
        'sailing_days'  => ['except' => ''], 
        'perPage'       => ['except' => 10], // 🌟 الحفاظ على خيار عدد العناصر المحددة في الـ URL
    ];

    // الاستماع لأحداث التحديث التلقائي للجدول عند الإضافة أو التعديل
    protected $listeners = [
        'officer-updated' => '$refresh',
        'officer-created' => '$refresh' 
    ];

    // إعادة تعيين ترقيم الصفحات تلقائياً عند كتابة أو تغيير أي فلتر
    public function updatingSearch() { $this->resetPage(); }
    public function updatingRank() { $this->resetPage(); }
    public function updatingStatus() { $this->resetPage(); }
    public function updatingSpecialty() { $this->resetPage(); } 
    public function updatingSailingHours() { $this->resetPage(); }
    public function updatingSailingDays() { $this->resetPage(); }
    public function updatingPerPage() { $this->resetPage(); } // 🌟 إعادة الترقيم للصفحة الأولى عند تغيير حجم المعروض

    /**
     * مصفوفة تجميع الفلاتر الحالية لتمريرها للـ Repository
     */
    private function getFilters()
    {
        return [
            'search'        => $this->search, 
            'rank'          => $this->rank,
            'status'        => $this->status,
            'specialty'     => $this->specialty, 
            'sailing_hours' => $this->sailing_hours, 
            'sailing_days'  => $this->sailing_days,
        ];
    }

    /**
     * حذف ملف الضابط من المنظومة العسكرية
     */
    public function deleteOfficer(int $id, OfficerRepositoryInterface $repo)
    {
        $repo->delete($id);
        $this->dispatch('toast', message: 'تم حذف ملف الضابط بنجاح من المنظومة.', type: 'success');
    }

    /**
     * تصدير بيانات الضباط المفلترة إلى ملف Excel متوافق تماماً مع اللغة العربية والأرقام الطويلة
     */
    public function exportToExcel(OfficerRepositoryInterface $repo)
    {
        // 1. جلب بيانات الضباط المفلترين بناءً على حالة البحث الحالية
        $filters = $this->getFilters();
        
        // جلب كافة النتائج المفلترة الحالية للتصدير الكامل
        $officers = $repo->getAllAdvanced($filters, 10000); 

        // 2. تجهيز اسم الملف باللغة العربية مع الامتداد المباشر لإكسيل .xls
        $fileName = 'تقرير_بيانات_الضباط_' . date('Y-m-d') . '.xls';

        // 3. استخدام الـ streamDownload لتنزيل الجدول بهيكل خلايا إكسيل حقيقية متناسقة
        return response()->streamDownload(function () use ($officers) {
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
            echo '<th>التخصص</th>';
            echo '<th>تاريخ التعيين</th>';
            echo '<th>ساعات الإبحار</th>';
            echo '<th>أيام الإبحار</th>';
            echo '<th>رقم التواصل</th>';
            echo '<th>الحالة</th>';
            echo '</tr>';

            $counter = 1;

            // 4. طباعة بيانات كل ضابط داخل صف مستقل
            foreach ($officers as $officer) {
                
                // صيغة تاريخ التعيين بسلامة باستخدام المساعد المباشر أو الـ Carbon
                $appointmentDate = $officer->appointment_date 
                    ? (\Carbon\Carbon::parse($officer->appointment_date)->format('Y-m-d')) 
                    : '—';

                echo '<tr>';
                echo '<td>' . $counter++ . '</td>';
                
                // ستايل mso-number-format يحمي الأرقام العسكرية ورقم الجوال تلقائياً من الاختصار أو حذف الأصفار دون الحاجة لصيغة =""
                echo '<td>' . htmlspecialchars($officer->military_id) . '</td>';
                echo '<td>' . htmlspecialchars($officer->full_name) . '</td>';
                echo '<td>' . htmlspecialchars($officer->rank ?? '—') . '</td>';
                echo '<td>' . htmlspecialchars($officer->specialty ?? '—') . '</td>';
                echo '<td>' . htmlspecialchars($appointmentDate) . '</td>';
                echo '<td>' . htmlspecialchars($officer->sailing_hours ?? 0) . ' ساعة</td>';
                echo '<td>' . htmlspecialchars($officer->sailing_days ?? 0) . ' يوم</td>';
                echo '<td>' . htmlspecialchars($officer->phone ?? '—') . '</td>';
                echo '<td>' . htmlspecialchars($officer->status ?? 'غير محدد') . '</td>';
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
     * رندرة الصفحة وعرض الجدول المفلتر
     */
    public function render(OfficerRepositoryInterface $repo)
    {
        // حصر الفلاتر المتقدمة وإرسالها إلى الـ Repository المخصص للضباط
        $filters = $this->getFilters();

        // 🌟 تمرير الخاصية الديناميكية $this->perPage بدلاً من الرقم الثابت 10
        $officers = $repo->getAllAdvanced($filters, $this->perPage);

        return view('livewire.officer.officer-list', [
            'officers' => $officers
        ])->layout('layouts.app');
    }
}