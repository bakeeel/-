<?php

namespace App\Repositories\Eloquent;

use App\Models\Trainee;
use App\Repositories\Contracts\TraineeRepositoryInterface;
use Illuminate\Support\Facades\DB;

class TraineeRepository implements TraineeRepositoryInterface
{
    /**
     * جلب كافة المتدربين مع الفلترة المتقدمة والترقيم الصفحي وحل مشكلة N+1
     */
    public function getAllAdvanced(array $filters, int $perPage = 10)
    {
        return Trainee::query()
            ->with(['courses']) // Eager Loading لجلب الدورات المرتبطة بالمتدربين دفعة واحدة
            ->when(!empty($filters['search']), function ($query) use ($filters) {
                $query->where(function($q) use ($filters) {
                    $q->where('full_name', 'like', '%' . $filters['search'] . '%')
                      ->orWhere('military_id', 'like', '%' . $filters['search'] . '%')
                      ->orWhere('phone', 'like', '%' . $filters['search'] . '%');
                });
            })
            ->when(!empty($filters['rank']), function ($query) use ($filters) {
                $query->where('rank', $filters['rank']);
            })
            ->when(!empty($filters['status']), function ($query) use ($filters) {
                $query->where('status', $filters['status']);
            })
            ->when(!empty($filters['specialty']), function ($query) use ($filters) {
                $query->where(function($q) use ($filters) {
                    $q->where('primary_specialty', 'like', '%' . $filters['specialty'] . '%')
                      ->orWhere('sub_specialty', 'like', '%' . $filters['specialty'] . '%');
                });
            })
            ->when(!empty($filters['service_years']), function ($query) use ($filters) {
                $query->where('service_years', $filters['service_years']);
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    /**
     * البحث عن متدرب محدد وجلب تاريخه التدريبي بالكامل
     */
    public function findById(int $id)
    {
        return Trainee::with(['courses'])->findOrFail($id);
    }

    /**
     * إنشاء سجل متدرب جديد
     */
    public function create(array $data)
    {
        return Trainee::create($data);
    }

    /**
     * تحديث بيانات متدرب عسكري
     */
    public function update(int $id, array $data)
    {
        // تحسين: جلب السجل الأساسي فقط بدون شحن العلاقات (Eager Loading) لتوفير الذاكرة وسرعة الأداء
        $trainee = Trainee::findOrFail($id);
        $trainee->update($data);
        return $trainee;
    }

    /**
     * حذف متدرب عسكري نهائياً من المنظومة التدريبية (بما يشمل دوراته التزاماً بـ Cascade الحذف)
     */
    public function delete(int $id)
    {
        return Trainee::findOrFail($id)->forceDelete();
    }

    /**
     * جلب الإحصائيات اللحظية لقسم المتدربين لربطها ببطاقات لوحة التحكم الإشرافية
     */
    public function getStats()
    {
        // استخدام استعلام مجمع واحد لرفع أداء السيرفر بدلاً من الاستعلام المتكرر
        $statuses = Trainee::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return [
            'total'     => Trainee::count(),
            'active'    => $statuses['نشط'] ?? 0,    // متوافق تماماً مع قيم الـ Validation العربية
            'completed' => Trainee::whereHas('courses')->count(), // المتدربين الذين التحقوا بدورة واحدة على الأقل
            'inactive'  => $statuses['موقوف'] ?? 0,  // أو أي حالة تعبر عن غير النشطين بنظامك مثل (غياب)
            'absence'   => $statuses['غياب'] ?? 0,   // إحصائية إضافية حيوية للوحة التحكم الإشرافية
        ];
    }
}