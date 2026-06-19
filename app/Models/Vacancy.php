<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Vacancy extends Model
{
    use HasFactory;

    /**
     * اسم الجدول المرتبط بقاعدة البيانات.
     *
     * @var string
     */
    protected $table = 'vacancies';

    /**
     * الحقول القابلة للتعبئة الجماعية (Mass Assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vacancy_number',
        'title',
        'status',
        'notes',
    ];

    /**
     * تحويل الحقول إلى أنواع بيانات محددة تلقائياً عند جلبها.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * نطاق (Scope) لجلب الوظائف "الشاغرة" فقط.
     * للاستخدام: Vacancy::vacant()->get();
     */
    public function scopeVacant(Builder $query): Builder
    {
        return $query->where('status', 'vacant');
    }

    /**
     * نطاق (Scope) لجلب الوظائف التي هي "تحت الإجراء".
     * للاستخدام: Vacancy::underAction()->get();
     */
    public function scopeUnderAction(Builder $query): Builder
    {
        return $query->where('status', 'under_action');
    }

    /**
     * نطاق (Scope) لجلب الوظائف التي هي "جاري التثبيت".
     * للاستخدام: Vacancy::processing()->get();
     */
    public function scopeProcessing(Builder $query): Builder
    {
        return $query->where('status', 'processing');
    }

    /**
     * دالة مساعدة للحصول على الاسم النصي للحالة باللغة العربية (إذا احتجت لعرضها بنص ثابت في جداول أخرى)
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'vacant' => 'شاغر',
            'under_action' => 'تحت الإجراء',
            'processing' => 'جاري التثبيت',
            default => 'غير محدد',
        };
    }
}