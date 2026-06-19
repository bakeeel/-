<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    /** @use HasFactory<\Database\Factories\PromotionFactory> */
    use HasFactory;

    // 1. تحديد الأعمدة القابلة للتعبئة (مهم جداً لتجنب Mass Assignment Error)
    protected $fillable = [
        'officer_id', // العمود الذي أضفته حديثاً
        'rank',       // أي حقول أخرى لديك في الجدول (مثل الرتبة الجديدة)
        'date',       // تاريخ الترقية
        'notes',      // أي ملاحظات
    ];

    // 2. تعريف العلاقة العكسية مع الضابط
    public function officer()
    {
        // نحدد 'officer_id' كـ Foreign Key
        return $this->belongsTo(Officer::class, 'officer_id', 'id');
    }
}