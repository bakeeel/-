<?php

namespace App\Repositories\Contracts;

interface TraineeRepositoryInterface
{
    /**
     * جلب كافة المتدربين مع الفلترة المتقدمة والترقيم الصفحي
     */
    public function getAllAdvanced(array $filters, int $perPage = 10);

    /**
     * البحث عن متدرب محدد عبر الرقم المعرف (ID)
     */
    public function findById(int $id);

    /**
     * إنشاء سجل متدرب جديد في قاعدة البيانات
     */
    public function create(array $data);

    /**
     * تحديث بيانات متدرب عسكري حالي
     */
    public function update(int $id, array $data);

    /**
     * حذف متدرب نهائياً من المنظومة التدريبية
     */
    public function delete(int $id);

    /**
     * جلب الإحصائيات الحيوية لقسم المتدربين (إجمالي النشطين، الدورات المنتهية، إلخ)
     */
    public function getStats();
}