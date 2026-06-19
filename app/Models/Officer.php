<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    use HasFactory;

    // اسم الجدول في قاعدة البيانات
    protected $table = 'officers';

    // الحقول المسموح بتعبئتها
    protected $fillable = [
        'full_name',
        'military_id',
        'rank',
        'specialty',
        'appointment_date',
        'avatar',
        'status',
        'notes',
        'phone',
        'sailing_hours',
        'sailing_days', // 🌟 إضافة الحقل الجديد هنا
    ];

    // تفعيل الـ Casting لتحويل التواريخ إلى كائنات Carbon تلقائياً
    protected $casts = [
        'appointment_date' => 'date',
        'confirmation_date' => 'date',       // 🌟 تم إضافتها
        'current_promotion_date' => 'date',  // 🌟 تم إضافتها
    ];

    // علاقة الضباط بالدورات (Many-to-Many) متوافقة 100% مع موديل الـ Course
    public function courses()
    {
        return $this->belongsToMany(\App\Models\Course::class, 'course_officer', 'officer_id', 'course_id')
                    ->withPivot('start_date', 'end_date', 'status', 'location') // متطابق مع الموديل المقابل
                    ->withTimestamps();
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class, 'officer_id', 'id');
    }
}