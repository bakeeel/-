<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_logs'; // تأكد من اسم الجدول

    protected $fillable = [
        'user_id', 
        'activity', 
        'description',
        'action', // أضف هذا الحقل هنا ليتمكن لارافيل من ملئه
    ];
}