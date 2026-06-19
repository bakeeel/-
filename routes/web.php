<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\MainIndex;

// 🔹 جناح الأفراد
use App\Livewire\Personnel\PersonnelList;
use App\Livewire\Personnel\PersonnelCreate;
use App\Livewire\Personnel\PersonnelEdit;
use App\Livewire\Personnel\PersonnelShow;
use App\Livewire\Personnel\PersonnelSearch;

// 🟩 جناح الضباط
use App\Livewire\Officer\OfficerList;
use App\Livewire\Officer\OfficerCreate;
use App\Livewire\Officer\OfficerEdit;
use App\Livewire\Officer\OfficerShow;

// 🟩 جناح المتدربين
use App\Livewire\Trainee\TraineeList;
use App\Livewire\Trainee\TraineeCreate;
use App\Livewire\Trainee\TraineeEdit;
use App\Livewire\Trainee\TraineeShow;

// 🔹 جناح الدورات والتقارير
use App\Livewire\Courses\CourseList; 
use App\Livewire\Courses\CourseOfficeList; 
use App\Livewire\Courses\CourseTraineeList; 
use App\Livewire\Courses\CourseCreate; 
use App\Livewire\Courses\CourseEdit;

use App\Livewire\VacancyManager;

// 🎯 جناح الترشيح وإسناد الدورات الجديد
use App\Livewire\Nomination\NominationList;

use App\Livewire\Reports\ReportIndex;

// 🌟 تم إزالة استدعاء الـ AuthenticatedSessionController المفقود من هنا لمنع الـ ReflectionException

// التوجيه التلقائي للمنظومة
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// الجدار الأمني العسكري لحماية اللوحة
Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. لوحة التحكم الأساسية
    Route::get('/dashboard', MainIndex::class)->name('dashboard');

    // 2. جناح البحث والاستعلام الشامل
    Route::get('/personnel/search', PersonnelSearch::class)->name('personnel.search');

    // 3. كشوفات الأفراد وشؤون العساكر (تم تقديم الـ create والـ edit قبل الـ id لعدم التداخل)
    Route::get('/personnel', PersonnelList::class)->name('personnel.index');
    Route::get('/personnel/create', PersonnelCreate::class)->name('personnel.create');
    Route::get('/personnel/{person}/edit', PersonnelEdit::class)->name('personnel.edit');
    Route::get('/personnel/{id}', PersonnelShow::class)->name('personnel.show');

    // 🪖 4. جناح إدارة شؤون الضباط
    Route::get('/officers', OfficerList::class)->name('officer.index');
    Route::get('/officers/create', OfficerCreate::class)->name('officer.create');
    Route::get('/officers/{officer}/edit', OfficerEdit::class)->name('officer.edit');
    Route::get('/officers/{id}', OfficerShow::class)->name('officer.show');
    
    // 🎓 5. جناح شؤون المتدربين والدورات التخصصية
    Route::get('/trainees', TraineeList::class)->name('trainee.index');
    Route::get('/trainees/create', TraineeCreate::class)->name('trainee.create');
    Route::get('/trainees/{trainee}/edit', TraineeEdit::class)->name('trainee.edit');
    Route::get('/trainees/{id}', TraineeShow::class)->name('trainee.show');

    // 6. جناح التدريب والدورات المركزية والتقارير (تأمين ترتيب مسار الإنشاء)
    Route::get('/courses', CourseList::class)->name('courses.index');                           // سجل دورات الأفراد العام
    Route::get('/courses-office', CourseOfficeList::class)->name('course-office.index');        // سجل دورات الضباط
    Route::get('/courses-trainee', CourseTraineeList::class)->name('trainee.course.index');     // سجل دورات المتدربين
    Route::get('/courses/create', CourseCreate::class)->name('courses.create');                 // 👈 تم جلبها هنا لمنع تضاربها مع مفسر الـ ID
    Route::get('/courses/{course}/edit', CourseEdit::class)->name('courses.edit');
    Route::get('/vacancies', VacancyManager::class)->name('vacancies.index');
    
    // 🎯 7. مسار منظومة الترشيح وإسناد الدورات الشاملة الجديد
    Route::get('/nomination', NominationList::class)->name('nomination.index');

    // 8. التقارير الذكية والجاهزية
    Route::get('/reports', ReportIndex::class)->name('reports.index');

    // 🌟 9. مسار تسجيل الخروج الآمن المباشر (تجاوز الكنترولر المفقود بالكامل)
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        Illuminate\Support\Facades\Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // التحويل للموقع الرئيسي بعد الخروج بنجاح
    })->name('logout');
});

if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}