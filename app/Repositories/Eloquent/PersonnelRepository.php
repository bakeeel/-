<?php

namespace App\Repositories\Eloquent;

use App\Models\Personnel;
use App\Repositories\Contracts\PersonnelRepositoryInterface;

class PersonnelRepository implements PersonnelRepositoryInterface
{
    public function getAllAdvanced(array $filters, int $perPage = 10)
    {
        return Personnel::query()
            ->with(['courses']) // Eager Loading لمنع n+1 query
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
            // 🟩 إضافة فلترة التخصص (تم ربطها مع عمود primary_specialty في قاعدة البيانات)
            ->when(!empty($filters['specialty']), function ($query) use ($filters) {
                $query->where('primary_specialty', $filters['specialty']);
            })
            // 💡 إضافة فلترة مدة الخدمة (في حال رغبت بتفعيلها مستقبلاً من الحقل المتقدم)
            ->when(!empty($filters['service_years']), function ($query) use ($filters) {
                $query->where('service_years', $filters['service_years']);
            })
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    public function findById(int $id)
    {
        return Personnel::with(['courses', 'promotions'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Personnel::create($data);
    }

    public function update(int $id, array $data)
    {
        $person = $this->findById($id);
        $person->update($data);
        return $person;
    }

    public function delete(int $id)
    {
        return Personnel::findOrFail($id)->forceDelete();
    }

    public function getStats()
    {
        return [
            $this->renderStats(),
        ];
    }

    private function renderStats()
    {
        return [
            'total' => Personnel::count(),
            'active' => Personnel::where('status', 'active')->count(),
            'suspended' => Personnel::where('status', 'suspended')->count(),
        ];
    }
}