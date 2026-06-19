<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type', 
        'duration_days', 'location', 'certificate_number', 'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    public function officers(): BelongsToMany
    {
        // ربط العلاقة بموديل الضباط وتحديد الجدول الوسيط والأعمدة
        return $this->belongsToMany(Officer::class, 'course_officer', 'course_id', 'officer_id')
                    ->withPivot('start_date', 'location')
                    ->withTimestamps();
    }

    public function personnel(): BelongsToMany
    {
        return $this->belongsToMany(Personnel::class, 'course_personnel');
    }
    /**
 * علاقة الدورة بالمتدربين الملتحقين بها (Many-to-Many)
 */
    public function trainees()
    {
        return $this->belongsToMany(Trainee::class, 'course_trainee')
                    ->withPivot( 'start_date', 'end_date', 'location')
                    ->withTimestamps();
        }
  
}