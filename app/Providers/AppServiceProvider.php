<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// مستودعات الأفراد
use App\Repositories\Contracts\PersonnelRepositoryInterface;
use App\Repositories\Eloquent\PersonnelRepository;

// مستودعات الضباط
use App\Repositories\Contracts\OfficerRepositoryInterface;
use App\Repositories\Eloquent\OfficerRepository;

// مستودعات الدورات والتدريب
use App\Repositories\Contracts\CourseRepositoryInterface;
use App\Repositories\Eloquent\CourseRepository;

// 🎓 مستودعات المتدربين (تمت إضافتها حديثاً لإنهاء ثغرة الـ Binding)
use App\Repositories\Contracts\TraineeRepositoryInterface;
use App\Repositories\Eloquent\TraineeRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 1. ربط مستودع شؤون الأفراد والعساكر
        $this->app->bind(PersonnelRepositoryInterface::class, PersonnelRepository::class);
        
        // 🪖 2. ربط مستودع شؤون الضباط وقادة المجموعات
        $this->app->bind(OfficerRepositoryInterface::class, OfficerRepository::class);
        
        // 3. ربط مستودع الدورات المركزية والتدريب
        $this->app->bind(CourseRepositoryInterface::class, CourseRepository::class);

        // 🎓 4. ربط مستودع شؤون المتدربين بالمنظومة التدريبية
        $this->app->bind(TraineeRepositoryInterface::class, TraineeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}