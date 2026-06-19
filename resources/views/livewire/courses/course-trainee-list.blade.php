<div class="space-y-6 font-cairo text-right select-none" dir="rtl">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-[#1F2937]/60 pb-5 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[#E5E7EB] tracking-wide flex items-center gap-2">
                <span>جناح شؤون المتدربين</span>
                <span class="text-sm font-normal text-gray-500 font-mono">//</span>
                <span class="text-xl font-medium text-gray-300">كشف دورات المتدربين النشطة</span>
            </h1>
            <p class="text-xs sm:text-sm text-gray-400 mt-1">تخطيط ومتابعة البرامج التدريبية، الدورات التطويرية، ومستويات اجتياز وتقييم المتدربين</p>
        </div>
        <div class="shrink-0">
            <a href="{{ route('courses.create') }}" wire:navigate 
               class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#2563EB] hover:bg-[#1d4ed8] text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 shadow-lg shadow-[#2563EB]/15 active:scale-[0.98]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>إنشاء برنامج تدريبي جديد</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <div class="bg-[#111827] border border-[#1F2937] rounded-2xl p-5 relative overflow-hidden shadow-xl group transition-all duration-300 hover:border-emerald-500/30">
            <div class="absolute top-0 right-0 h-[3px] w-24 bg-emerald-500"></div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">دورات جارية ومستمرة</p>
                    <h3 class="text-3xl font-extrabold text-[#E5E7EB] mt-2.5 font-mono tracking-tight">
                        {{ \App\Models\Course::whereIn('status', ['مستمرة حالياً', 'مستمرة حاليا'])->count() }}
                    </h3>
                </div>
                <div class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 transition-colors group-hover:bg-emerald-500/15">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-[#111827] border border-[#1F2937] rounded-2xl p-5 relative overflow-hidden shadow-xl group transition-all duration-300 hover:border-amber-500/30">
            <div class="absolute top-0 right-0 h-[3px] w-24 bg-amber-500"></div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">دورات في طور الانتظار</p>
                    <h3 class="text-3xl font-extrabold text-[#E5E7EB] mt-2.5 font-mono tracking-tight">
                        {{ \App\Models\Course::where('status', 'قيد الانتظار')->count() }}
                    </h3>
                </div>
                <div class="p-3 rounded-xl bg-amber-500/10 border border-amber-500/20 text-amber-500 transition-colors group-hover:bg-amber-500/15">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-[#111827] border border-[#1F2937] rounded-2xl p-5 relative overflow-hidden shadow-xl group transition-all duration-300 hover:border-blue-500/30">
            <div class="absolute top-0 right-0 h-[3px] w-24 bg-gradient-to-r from-blue-600 to-indigo-500"></div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">دورات مكتملة</p>
                    <h3 class="text-3xl font-extrabold text-[#E5E7EB] mt-2.5 font-mono tracking-tight">
                        {{ \App\Models\Course::whereIn('status', ['مكتملة', 'مكتملة ومؤرشفة'])->count() }}
                    </h3>
                </div>
                <div class="p-3 rounded-xl bg-[#2563EB]/10 border border-[#2563EB]/20 text-[#2563EB] transition-colors group-hover:bg-[#2563EB]/15">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-[#111827] border border-[#1F2937] rounded-2xl p-5 relative overflow-hidden shadow-xl group transition-all duration-300 hover:border-red-500/30">
            <div class="absolute top-0 right-0 h-[3px] w-24 bg-red-500"></div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">دورات ملغاة</p>
                    <h3 class="text-3xl font-extrabold text-[#E5E7EB] mt-2.5 font-mono tracking-tight">
                        {{ \App\Models\Course::where('status', 'ملغاة')->count() }}
                    </h3>
                </div>
                <div class="p-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 transition-colors group-hover:bg-red-500/15">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    @php
        // تعديل اسم الجدول الوسيط هنا ليصبح course_trainee بدلاً من course_officer
        $totalRegisteredTrainees = \DB::table('course_trainee')->count(); 
    @endphp
    <div class="bg-[#111827] border border-[#1F2937] rounded-2xl p-6 shadow-xl space-y-4">
        <div class="flex items-center justify-between border-b border-[#1F2937] pb-3.5">
            <h2 class="text-md font-bold text-[#E5E7EB] flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span>تقرير التوزيع النسبي للمتدربين على الحقائب التدريبية</span>
            </h2>
            <span class="text-xs font-mono text-gray-400 bg-[#070B14] border border-[#1F2937] px-3 py-1 rounded-lg">
                إجمالي المتدربين المسجلين: <span class="text-blue-400 font-bold font-mono">{{ $totalRegisteredTrainees }}</span> متدرب
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
            @forelse($courses->take(6) as $c) 
                @php
                    // تعديل استدعاء العلاقة البرمجية هنا إلى trainees() بدلاً من officers()
                    $courseCount = $c->trainees()->count(); 
                    $percentage = $totalRegisteredTrainees > 0 ? round(($courseCount / $totalRegisteredTrainees) * 100) : 0;
                    
                    $gradientBar = 'from-blue-600 to-indigo-400 shadow-[0_0_12px_rgba(37,99,235,0.25)]';
                    
                    if($c->status == 'مستمرة حالياً' || $c->status == 'مستمرة حاليا') {
                        $gradientBar = 'from-emerald-600 to-teal-400 shadow-[0_0_12px_rgba(16,185,129,0.3)]';
                    } elseif($c->status == 'قيد الانتظار') {
                        $gradientBar = 'from-amber-600 to-orange-400 shadow-[0_0_12px_rgba(245,158,11,0.25)]';
                    } elseif($c->status == 'ملغاة') {
                        $gradientBar = 'from-red-600 to-rose-400 shadow-[0_0_12px_rgba(239,68,68,0.2)]';
                    }
                @endphp
                <div class="bg-[#070B14]/60 border border-[#1F2937]/70 p-4 rounded-xl space-y-2.5 hover:border-[#2563EB]/30 transition-all duration-200">
                    <div class="flex justify-between items-center text-xs font-bold">
                        <span class="text-gray-200 text-sm truncate max-w-[220px]" title="{{ $c->name }}">{{ $c->name }}</span>
                        <div class="flex items-center gap-2 font-mono">
                            <span class="text-gray-400">({{ $courseCount }} متدرب)</span>
                            <span class="text-blue-400 text-sm">{{ $percentage }}%</span>
                        </div>
                    </div>
                    <div class="w-full bg-[#111827] rounded-full overflow-hidden border border-[#1F2937] p-[1.5px] h-3">
                        <div class="h-full bg-gradient-to-r {{ $gradientBar }} rounded-full transition-all duration-500" 
                             style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center text-gray-500 text-xs py-4">لا توجد دورات كافية لتوليد الرسم البياني الإحصائي.</div>
            @endforelse
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-[#111827] border border-[#1F2937] p-4 rounded-xl shadow-lg">
        <div class="sm:col-span-2 relative flex items-center">
            <span class="absolute right-3 text-gray-500 pointer-events-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </span>
            <input type="text" wire:model.live.debounce.300ms="search" 
                   class="w-full bg-[#070B14] border border-[#1F2937] text-gray-200 rounded-xl pr-10 pl-10 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition placeholder-gray-600" 
                   placeholder="ابحث برقم وثيقة السجل أو اسم الدورة التدريبية...">
            @if($search !== '')
                <button type="button" wire:click="$set('search', '')" class="absolute left-3 text-gray-500 hover:text-gray-300 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            @endif
        </div>
        <div>
            <select wire:model.live="filterStatus" 
                    class="w-full bg-[#070B14] border border-[#1F2937] text-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition cursor-pointer">
                <option value="">كل الحالات التشغيلية</option>
                <option value="مستمرة حالياً">مستمرة </option>
                <option value="قيد الانتظار">في الانتظار</option>
                <option value="مكتملة ومؤرشفة">مكتملة </option>
                <option value="ملغاة">ملغاة</option>
            </select>
        </div>
    </div>

    <div class="bg-[#111827] border border-[#1F2937] rounded-2xl shadow-2xl overflow-hidden">
        <div class="p-5 border-b border-[#1F2937] flex items-center justify-between bg-[#111827]/50">
            <h2 class="text-md font-bold text-[#E5E7EB] flex items-center gap-2.5">
                <span class="w-2 h-2 rounded-full bg-blue-500 shadow-md shadow-blue-500/50 animate-pulse"></span> 
                <span>البيانات التفصيلية للحقائب التدريبية للمتدربين</span>
            </h2>
            <span class="text-xs text-gray-500 font-mono tracking-widest hidden sm:inline">CLASSIFIED // OFFICIAL USE ONLY</span>
        </div>

        <div class="overflow-x-auto relative">
            <table class="w-full text-right text-sm text-gray-300" wire:loading.class="opacity-40 pointer-events-none transition-all duration-200">
                <thead>
                    <tr class="text-xs font-bold text-gray-400 border-b border-[#1F2937] uppercase bg-[#070B14]/50 tracking-wider">
                        <th class="p-4 select-none">رقم الوثيقة</th>
                        <th class="p-4 select-none">اسم الدورة </th>
                        <th class="p-4 select-none">التصنيف</th>
                        <th class="p-4 select-none">الفترة الزمنية</th>
                        <th class="p-4 select-none">المدة الزمنية</th>
                        <th class="p-4 select-none">الجهة القائمة</th>
                        <th class="p-4 text-center select-none">الحالة </th>
                        <th class="p-4 text-center select-none">الإجراءات </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1F2937]/70">
                    @forelse($courses as $course)
                    <tr class="hover:bg-gray-800/20 transition-colors duration-150 group">
                        <td class="p-4 whitespace-nowrap align-middle">
                            <div class="inline-flex items-center gap-2 font-mono text-[#2563EB] font-bold tracking-wider text-xs">
                                <svg class="w-5 h-5 opacity-90 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span>{{ $course->certificate_number }}</span>
                            </div>
                        </td>
                        <td class="p-4 font-medium text-white group-hover:text-blue-400 transition-colors">{{ $course->name }}</td>
                        <td class="p-4 whitespace-nowrap">
                            @if($course->type == 'tactical')
                                <span class="inline-flex items-center gap-1 bg-rose-500/10 text-rose-400 border border-rose-500/20 text-[11px] font-semibold px-2.5 py-0.5 rounded-md backdrop-blur-sm">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    <span> متوسط</span>
                                </span>
                            @elseif($course->type == 'advanced')
                                <span class="inline-flex items-center gap-1 bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[11px] font-semibold px-2.5 py-0.5 rounded-md backdrop-blur-sm">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    <span>متقدم </span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[11px] font-semibold px-2.5 py-0.5 rounded-md backdrop-blur-sm">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <span>تأسيسي </span>
                                </span>
                            @endif
                        </td>
                        <td class="p-4 font-mono text-xs text-gray-400 whitespace-nowrap tracking-tighter">
                            {{ $course->start_date->format('Y/m/d') }} <span class="text-gray-600 px-0.5">←</span> {{ $course->end_date->format('Y/m/d') }}
                        </td>
                        <td class="p-4 font-mono text-xs text-gray-300 whitespace-nowrap">{{ $course->duration_days }} يوم</td>
                        <td class="p-4 text-gray-400 text-xs max-w-[150px] truncate" title="{{ $course->location }}">{{ $course->location }}</td>
                        <td class="p-4 text-center whitespace-nowrap">
                            @if($course->status == 'مستمرة حالياً' || $course->status == 'مستمرة حاليا')
                                <span class="inline-flex items-center gap-1.5 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[11px] font-medium px-2.5 py-1 rounded-full backdrop-blur-sm">
                                    <svg class="w-3 h-3 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>مستمرة حالياً</span>
                                </span>
                            @elseif($course->status == 'قيد الانتظار')
                                <span class="inline-flex items-center gap-1.5 bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[11px] font-medium px-2.5 py-1 rounded-full backdrop-blur-sm">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>قيد الانتظار</span>
                                </span>
                            @elseif($course->status == 'ملغاة')
                                <span class="inline-flex items-center gap-1.5 bg-red-500/10 text-red-400 border border-red-500/20 text-[11px] font-medium px-2.5 py-1 rounded-full backdrop-blur-sm">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>
                                    <span>ملغاة</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[11px] font-medium px-2.5 py-1 rounded-full backdrop-blur-sm">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>مكتملة </span>
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-center align-middle whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" 
                                        wire:click="openTraineeModal({{ $course->id }})"
                                        title="إسناد وإضافة المتدربين لهذه الدورة"
                                        class="w-8 h-8 rounded-xl bg-[#070B14] border border-[#1F2937] text-emerald-400 hover:text-emerald-300 hover:bg-emerald-500/10 hover:border-emerald-500/40 flex items-center justify-center transition-all duration-200 active:scale-90 shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </button>

                                <a href="{{ route('courses.edit', $course->id) }}" 
                                   wire:navigate
                                   wire:loading.attr="disabled"
                                   wire:target="delete({{ $course->id }})"
                                   title="تعديل وثيقة السجل"
                                   class="w-8 h-8 rounded-xl bg-[#070B14] border border-[#1F2937] text-blue-400 hover:text-blue-300 hover:bg-blue-500/10 hover:border-blue-500/40 flex items-center justify-center transition-all duration-200 active:scale-90 disabled:opacity-40 disabled:pointer-events-none shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                <button type="button" 
                                        wire:click="delete({{ $course->id }})"
                                        wire:confirm="تحذير نظام صارم: هل أنت متأكد من حذف هذه الحقيبة التدريبية نهائياً من سجلات الجناح؟"
                                        wire:loading.attr="disabled"
                                        wire:target="delete({{ $course->id }})"
                                        title="حذف نهائي من السجل"
                                        class="w-8 h-8 rounded-xl bg-[#070B14] border border-[#1F2937] text-rose-400 hover:text-rose-300 hover:bg-rose-500/10 hover:border-rose-500/40 flex items-center justify-center transition-all duration-200 active:scale-90 disabled:opacity-40 shadow-sm">
                                    <span wire:loading.remove wire:target="delete({{ $course->id }})">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </span>
                                    <span wire:loading wire:target="delete({{ $course->id }})">
                                        <svg class="w-4 h-4 animate-spin text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-12 text-center text-gray-500 font-medium bg-[#111827]">
                            <div class="flex flex-col items-center justify-center space-y-3">
                                <div class="p-3 rounded-full bg-gray-800/30 border border-gray-700/30 text-gray-600">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5M5 19v-4a2 2 0 012-2h11a2 2 0 012 2v3m-7-2h1m-1 4h1m-4-4h1m-1 4h1"></path>
                                    </svg>
                                </div>
                                <span class="text-sm">لا توجد حقائب تدريبية مطابقة لخيارات البحث أو الفلترة الحالية.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($showTraineeModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/75 backdrop-blur-[2px] transition-all duration-200"
         wire:keydown.escape.window="closeTraineeModal">
        
        <div class="absolute inset-0 cursor-default" wire:click="closeTraineeModal"></div>

        <div class="bg-[#111827] border border-[#1F2937] w-full max-w-4xl rounded-xl shadow-2xl overflow-hidden transform transition-all relative z-10 animate-in fade-in zoom-in-95 duration-150">
            
            <div class="px-5 py-4 border-b border-[#1F2937] flex items-center justify-between bg-[#111827] select-none">
                <div>
                    <h3 class="text-md font-bold text-white tracking-wide">إسناد المتدربين والقوة البشرية</h3>
                    <p class="text-xs text-gray-400 mt-1">الدورة: <span class="text-gray-300 font-semibold">{{ $selectedCourseName }}</span></p>
                </div>
                <button type="button" wire:click="closeTraineeModal" class="w-7 h-7 rounded-lg bg-[#111827] border border-[#1F2937] text-gray-400 hover:text-white flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-5 space-y-4">
                <div class="relative flex items-center">
                    <span class="absolute right-3 text-gray-500 pointer-events-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" wire:model.live.debounce.250ms="searchTrainee" 
                           class="w-full bg-[#070B14] border border-[#1F2937] text-gray-200 rounded-xl pr-10 pl-10 py-2.5 text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition placeholder-gray-600 font-sans" 
                           placeholder="ابحث عن متدرب بالرقم الهوائي/الأكاديمي، المرتبة أو الاسم...">
                </div>

                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-400 tracking-wider select-none">حدد قوة المتدربين المختارين:</label>
                    
                    <div class="max-h-[160px] overflow-y-auto pr-0.5 pl-0.5 gap-3 grid grid-cols-1 md:grid-cols-2 scrollbar-thin scrollbar-thumb-gray-800">
                        @forelse($traineeList as $trainee)
                        <label class="flex items-center justify-between p-3.5 bg-[#070B14]/40 border border-[#1F2937] rounded-lg hover:border-gray-700/80 cursor-pointer transition-all duration-150 group">
                            <div class="flex flex-col text-right select-none">
                                <span class="text-xs font-bold text-white group-hover:text-blue-400 transition-colors">
                                    {{ $trainee->title ?? 'متدرب' }} / {{ $trainee->full_name }}
                                </span>
                                <span class="text-[11px] text-gray-500 font-sans mt-1">الرقم التعريفي: <span class="font-mono text-gray-400">{{ $trainee->military_id?? $militrary->id }}</span></span>
                            </div>
                            <input type="checkbox" value="{{ $trainee->id }}" wire:model="selectedTraineeIds"
                                   class="w-4 h-4 text-blue-600 bg-[#111827] border-[#374151] rounded focus:ring-blue-500/30 focus:ring-offset-[#111827] transition cursor-pointer">
                        </label>
                        @empty
                        <div class="text-center col-span-2 py-8 text-gray-500 text-xs">
                            <svg class="w-6 h-6 mx-auto mb-2 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                            </svg>
                            لا توجد سجلات متدربين متطابقة مع البحث.
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="px-5 py-4 border-t border-[#1F2937] flex items-center justify-between bg-[#111827]/60 select-none">
                <span class="text-xs font-mono text-gray-400">
                    تم تحديد: <span class="text-emerald-400 font-bold font-mono">{{ count($selectedTraineeIds ?? []) }}</span> من المتدربين
                </span>
                <div class="flex items-center gap-2.5">
                    <button type="button" wire:click="closeTraineeModal" class="px-4 py-2 text-xs font-semibold text-gray-400 hover:text-white transition duration-150">إلغاء الأمر</button>
                    <button type="button" wire:click="saveTraineeAssignment" 
                            class="inline-flex items-center gap-1.5 bg-[#2563EB] hover:bg-[#1d4ed8] text-white px-4 py-2 rounded-xl text-xs font-semibold transition-all duration-150 shadow-md active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>حفظ التعديلات والتكليف</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
    @endif

</div>