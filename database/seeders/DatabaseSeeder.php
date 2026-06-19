<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Personnel;
use App\Models\Course;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء الحساب القيادي المشرف على المنظومة
        User::factory()->create([
            'name' => 'اللواء ركن/ قائد المنظومة',
            'email' => 'admin@tactical.gov',
            'password' => Hash::make('MilitarySecure2026#'),
        ]);

        // 2. ضخ عينة عشوائية ذكية من الأفراد العسكريين
        $person1 = Personnel::create([
            'full_name' => 'خالد بن عبد الله الشمري',
            'military_id' => 'MIL-100293',
            'rank' => 'نقيب',
            'primary_specialty' => 'سلاح الإشارة وتقنية المعلومات',
            'appointment_date' => '2018-04-12',
            'current_promotion_date' => '2024-01-01',
            'status' => 'active',
        ]);

        $person2 = Personnel::create([
            'full_name' => 'سلطان بن محمد القحطاني',
            'military_id' => 'MIL-204958',
            'rank' => 'ملازم أول',
            'primary_specialty' => 'الدفاع الجوي والعمليات الخاصة',
            'appointment_date' => '2021-06-15',
            'current_promotion_date' => '2025-05-10',
            'status' => 'active',
        ]);

        // 3. ضخ دورات عسكرية متقدمة
        $course1 = Course::create([
            'name' => 'دورة مكافحة الإرهاب الإلكتروني وحرب المعلومات',
            'type' => 'تخصصية متقدمة',
            'start_date' => '2026-02-01',
            'end_date' => '2026-03-01',
            'duration_days' => 30,
            'conducting_entity' => 'مركز الحرب الإلكترونية المشترك',
            'status' => 'completed',
        ]);

        // ربط الأفراد بالدورات لإنشاء الـ Pivot Data فوراً
        $course1->personnel()->attach([$person1->id, $person2->id]);
    }
}