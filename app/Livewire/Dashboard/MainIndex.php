<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Personnel;
use App\Models\Officer; // استدعاء موديل الضباط الفعلي
use App\Models\trainee;  // استدعاء موديل المتدربين الجديد
use App\Models\Course;
use App\Models\Promotion;
use App\Models\Vacancy;
use App\Models\User;

class MainIndex extends Component
{
    public function render()
    {
        // حساب إجمالي القوة البشرية الفعلي (تجميع الأفراد والضباط معاً)
        $totalPersonnelPower = Personnel::count() + Officer::count();

        return view('livewire.dashboard.main-index', [
            'count_officers'   => Officer::count(),
            'count_personnel'  => Personnel::count(),
            'count_trainees'   => Trainee::count(), // إجمالي المتدربين
            'count_courses'    => Course::count(),
            'count_promotions' => Promotion::count(),
            'count_vacancies' => Vacancy::count(),
            // جلب القوائم الجانبية الفورية لأحدث البيانات
            'recent_courses'   => Course::latest()->take(5)->get(),
            'recent_personnel' => Personnel::latest()->take(5)->get(),
            'recent_officers'  => Officer::latest()->take(5)->get(), // تم التموين بنجاح لجدول الـ Blade الجديد
            'recent_trainees'  => Trainee::latest()->take(5)->get(), // تم التموين بنجاح لجدول الـ Blade الجديد
        ])->layout('layouts.app');
    }
    
}