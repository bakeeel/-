<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainee extends Model
{
    use HasFactory;

    // الحقول المسموح بتعبئتها جماعياً لضمان الحماية
    protected $fillable = [
        'military_id',
        'full_name',
        'phone',
        'rank',
        'primary_specialty',
        
        'appointment_date',
        'service_years',
        'service_months',
      
        'avatar',
        'status',
        'notes',
    ];

    /**
     * 📆 تحويل حقول التواريخ العسكرية تلقائياً إلى كائنات Carbon (Date Casting)
     * هذا يمنع انهيار النظام عند استخدام دالة format() في الـ Blade أو السيرفر.
     */
    protected $casts = [
        'appointment_date'   => 'date',
       
    ];

    /**
     * علاقة المتدرب بالدورات (Many-to-Many)
     * جلب الحقول الإضافية المتواجدة في جدول الربط الوسيط (Pivot)
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_trainee')
                    ->withPivot( 'start_date', 'end_date', 'status', 'location') // الحقول الإضافية في جدول الربط
                    ->withTimestamps();
    }
}