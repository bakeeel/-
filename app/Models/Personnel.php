<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Personnel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'personnel';

    protected $fillable = [
        'full_name', 
        'military_id', 
        'b_n',
        'rank', 
        'primary_specialty', 
        'sub_specialty', 
        'appointment_date', 
        'confirmation_date', 
        'current_promotion_date', 
        'avatar', 
        'status', 
        'notes',
        'phone',           // رقم التواصل
        'service_years',   // مدة الخدمة (سنوات)
        'service_months'   // مدة الخدمة (أشهر)
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'confirmation_date' => 'date',
        'current_promotion_date' => 'date',
        'service_years' => 'integer',
        'service_months' => 'integer'
    ];

    /**
     * علاقة الدورات العسكرية (Many-to-Many)
     * تم تحديثها لقراءة حقول جدول الربط الوسيط
     */
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_personnel')
                    ->withPivot(['start_date', 'end_date','status', 'location']) // الحقول المطلوبة للعرض في الـ Blade
                    ->withTimestamps(); // لحفظ وقراءة created_at و updated_at تلقائياً
    }

    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class)->orderBy('promotion_date', 'desc');
    }
}