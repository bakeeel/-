<?php

namespace App\Repositories\Contracts;

interface OfficerRepositoryInterface
{
    /**
     * جلب جميع الضباط مع تطبيق الفلاتر المتقدمة والترقيم (Pagination)
     *
     * @param array $filters
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllAdvanced(array $filters, int $perPage = 10);

    /**
     * جلب بيانات ضابط محدد بواسطة المعرف الرقمي (ID)
     *
     * @param int $id
     * @return \App\Models\Officer|null
     */
    public function findById(int $id);

    /**
     * إنشاء سجل ضابط جديد في المنظومة العسكرية
     *
     * @param array $data
     * @return \App\Models\Officer
     */
    public function create(array $data);

    /**
     * تحديث بيانات ضابط حالي
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data);

    /**
     * حذف ملف ضابط من قاعدة البيانات
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id);

    /**
     * جلب إحصائيات عامة ومتقدمة خاصة بقسم الضباط
     * (مثل: إجمالي الضباط، المتواجدين، المجازين، وتوزيع الرتب وساعات الإبحار)
     *
     * @return array
     */
    public function getStats();
}