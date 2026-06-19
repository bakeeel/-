<?php

namespace App\Repositories\Eloquent;

use App\Models\Officer;
use App\Repositories\Contracts\OfficerRepositoryInterface;

class OfficerRepository implements OfficerRepositoryInterface
{
    public function getAllAdvanced(array $filters, int $perPage = 10)
    {
        return Officer::query()
            ->with(['courses']) // Eager Loading لمنع n+1 query في الدورات للضباط
            ->when(!empty($filters['search']), function ($query) use ($filters) {
                $query->where(function($q) use ($filters) {
                    $q->where('full_name', 'like', '%' . $filters['search'] . '%')
                      ->orWhere('military_id', 'like', '%' . $filters['search'] . '%');
                });
            })
            ->when(!empty($filters['rank']), function ($query) use ($filters) {
                $query->where('rank', $filters['rank']);
            })
            ->when(!empty($filters['status']), function ($query) use ($filters) {
                $query->where('status', $filters['status']);
            })
            ->when(!empty($filters['specialty']), function ($query) use ($filters) {
                $query->where('specialty', $filters['specialty']);
            })
            // فلترة متقدمة مخصصة للضباط بناءً على الحد الأدنى لساعات الإبحار المدخلة
            ->when(!empty($filters['sailing_hours']), function ($query) use ($filters) {
                $query->where('sailing_hours', '>=', $filters['sailing_hours']);
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    public function findById(int $id)
    {
        return Officer::with(['courses', 'promotions'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Officer::create($data);
    }

    public function update(int $id, array $data)
    {
        $officer = $this->findById($id);
        $officer->update($data);
        return $officer;
    }

    public function delete(int $id)
    {
        return Officer::findOrFail($id)->forceDelete();
    }

    public function getStats()
    {
        return $this->renderStats();
    }

    private function renderStats()
    {
        return [
            'total'         => Officer::count(),
            'active'        => Officer::where('status', 'نشط')->count(),
            'on_leave'      => Officer::where('status', 'إجازة')->count(),
            'absent'        => Officer::where('status', 'غياب')->count(),
            'delayed'       => Officer::where('status', 'تأخير')->count(),
            'sailing_hours' => Officer::sum('sailing_hours'), // إجمالي الساعات المسجلة لكافة الضباط
        ];
    }
}