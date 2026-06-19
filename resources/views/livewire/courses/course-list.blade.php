<div class="space-y-6 font-cairo text-right select-none" dir="rtl">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-[#1F2937]/60 pb-5 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[#E5E7EB] tracking-wide flex items-center gap-2">
                <span>جناح التدريب المركزي</span>
                <span class="text-sm font-normal text-gray-500 font-mono">//</span>
                <span class="text-xl font-medium text-gray-300">كشف الدورات </span>
            </h1>
            <p class="text-xs sm:text-sm text-gray-400 mt-1"> متابعة الدورات التدريبية، ومستويات الاجتياز </p>
        </div>
        
        <div class="shrink-0">
             <button wire:click="exportToExcel" 
            wire:loading.attr="disabled"
            class="inline-flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 shadow-lg shadow-emerald-600/15 active:scale-[0.98] disabled:opacity-50">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <span>تصدير البيانات الحالي لـ Excel</span>
    </button>

           <a href="{{ route('courses.create') }}" wire:navigate 
              class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-[#2563EB] hover:bg-[#1d4ed8] text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 shadow-lg shadow-[#2563EB]/15 active:scale-[0.98]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>إنشاء  دورة جديد</span>
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
            <div class="absolute top-0 right-0 h-[3px] w-24 bg-[#2563EB]"></div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">دورات مكتملة</p>
                    <h3 class="text-3xl font-extrabold text-[#E5E7EB] mt-2.5 font-mono tracking-tight">
                        {{ \App\Models\Course::whereIn('status', ['مكتملة', 'مكتملة ومؤرشفة'])->count() }}
                    </h3>
                </div>
                <div class="p-3 rounded-xl bg-[#2563EB]/10 border border-[#2563EB]/20 text-[#2563EB] transition-colors group-hover:bg-[#2563EB]/15">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
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
        // التحديث الجذري: حساب الأعداد الإجمالية الكلية مباشرة من الجداول الأساسية للقوة البشرية بالنظام وليس جداول الربط
        $globalTotalOfficers = \DB::table('officers')->count(); // اسم الجدول الأساسي للضباط
        $globalTotalSoldiers = \DB::table('personnel')->count(); // اسم الجدول الأساسي للأفراد بناءً على كلامك personnel
        $globalTotalTrainees = \DB::table('trainees')->count();  // اسم الجدول الأساسي للمتدربين
        
        // إجمالي القوة البشرية الكلية المسجلة بالنظام بالكامل
        $globalSystemTotal = $globalTotalOfficers + $globalTotalSoldiers + $globalTotalTrainees;
    @endphp

    <div class="bg-[#111827] border border-[#1F2937] rounded-2xl p-6 shadow-xl space-y-5" dir="rtl">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between border-b border-[#1F2937] pb-4 gap-4">
            <h2 class="text-md font-bold text-[#E5E7EB] flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span>تقرير التوزيع النسبي الإجمالي ( /  / ) لكل دورة    </span>
            </h2>
            <div class="flex flex-wrap items-center gap-2 font-mono text-xs">
                <span class="text-gray-400 bg-[#070B14] border border-[#1F2937] px-3 py-1.5 rounded-lg">
                    إجمالي  الكلي : <span class="text-blue-400 font-bold">{{ $globalSystemTotal }}</span>
                </span>
                <span class="text-gray-400 bg-[#070B14] border border-[#1F2937] px-2.5 py-1.5 rounded-lg">
                    اجمالي الضباط : <span class="text-blue-400 font-bold">{{ $globalTotalOfficers }}</span>
                </span>
                <span class="text-gray-400 bg-[#070B14] border border-[#1F2937] px-2.5 py-1.5 rounded-lg">
                    اجمالي الأفراد : <span class="text-amber-400 font-bold">{{ $globalTotalSoldiers }}</span>
                </span>
                <span class="text-gray-400 bg-[#070B14] border border-[#1F2937] px-2.5 py-1.5 rounded-lg">
                    اجمالي المتدربين : <span class="text-teal-400 font-bold">{{ $globalTotalTrainees }}</span>
                </span>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pt-2" dir="rtl">
            @forelse($courses->take(9) as $c) 
                @php
                    // 1. حساب المسجلين في هذه الدورة من جداول الـ Pivot
                    $courseOfficers   = \DB::table('course_officer')->where('course_id', $c->id)->count();
                    $courseSoldiers   = \DB::table('course_personnel')->where('course_id', $c->id)->count();
                    $courseTrainees   = \DB::table('course_trainee')->where('course_id', $c->id)->count();
                    $courseTotalCount = $courseOfficers + $courseSoldiers + $courseTrainees;

                    // 2. حساب نسبة كل فئة داخل "هذه الدورة تحديداً" (ليكتمل مجموع الدائرة 100%)
                    $pctOfTotalOfficers = $courseTotalCount > 0 ? round(($courseOfficers / $courseTotalCount) * 100) : 0;
                    $pctOfTotalSoldiers = $courseTotalCount > 0 ? round(($courseSoldiers / $courseTotalCount) * 100) : 0;
                    $pctOfTotalTrainees = $courseTotalCount > 0 ? round(($courseTrainees / $courseTotalCount) * 100) : 0;

                    // 3. تحويل النسب إلى درجات تراكمية لرسم التدرج الزاوي (Conic Gradient) بشكل صحيح
                    $deg1 = round(($pctOfTotalOfficers / 100) * 360);
                    $deg2 = $deg1 + round(($pctOfTotalSoldiers / 100) * 360);
                    
                    // 4. حساب النسب العامة من إجمالي القوة بالنظام
                    $pctGlobalOfficers = $globalTotalOfficers > 0 ? round(($courseOfficers / $globalTotalOfficers) * 100) : 0;
                    $pctGlobalSoldiers = $globalTotalSoldiers > 0 ? round(($courseSoldiers / $globalTotalSoldiers) * 100) : 0;
                    $pctGlobalTrainees = $globalTotalTrainees > 0 ? round(($courseTrainees / $globalTotalTrainees) * 100) : 0;
                    $globalPercentage  = $globalSystemTotal > 0 ? round(($courseTotalCount / $globalSystemTotal) * 100) : 0;
                @endphp
                
                <div class="bg-[#0b1329]/50 backdrop-blur-md border border-slate-800/80 p-5 rounded-2xl flex flex-col justify-between space-y-4 hover:border-blue-500/40 hover:shadow-lg hover:shadow-blue-950/20 transition-all duration-300 group">
                    
                    <div class="flex justify-between items-start border-b border-slate-800/60 pb-3">
                        <div class="space-y-1">
                            <h3 class="text-slate-100 text-sm font-bold tracking-wide group-hover:text-blue-400 transition-colors duration-200" title="{{ $c->name }}">
                                {{ $c->name }}
                            </h3>
                            <p class="text-[11px] text-slate-400">إجمالي المسجلين بالدورة: <span class="font-mono text-blue-400 font-bold text-xs">{{ $courseTotalCount }}</span></p>
                        </div>
                        <div class="bg-blue-500/10 border border-blue-500/20 px-2.5 py-1 rounded-lg text-center">
                            <span class="block font-mono text-xs font-black text-blue-400">{{ $globalPercentage }}%</span>
                            <span class="text-[9px] text-blue-300/70 block whitespace-nowrap">من قوة النظام</span>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between gap-4 py-2">
                        
                        <div class="relative w-28 h-28 rounded-full flex items-center justify-center shrink-0 shadow-lg shadow-black/40" 
                            style="background: conic-gradient(
                                #3b82f6 0deg {{ $deg1 }}deg, 
                                #f59e0b {{ $deg1 }}deg {{ $deg2 }}deg, 
                                #14b8a6 {{ $deg2 }}deg 360deg
                            );">
                            <div class="w-[74%] h-[74%] bg-[#0d1527] rounded-full flex flex-col items-center justify-center border border-slate-800/60 shadow-inner">
                                <span class="text-[10px] text-slate-400 font-medium block">توزيع الدورة</span>
                                <span class="font-mono text-xs font-bold text-slate-200">{{ $courseTotalCount }}</span>
                            </div>
                        </div>

                        <div class="flex-1 space-y-2">
                            <div class="flex items-center justify-between p-1.5 rounded-lg bg-slate-900/30 border border-slate-800/30">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                    <span class="text-[11px] font-medium text-slate-300">الضباط</span>
                                </div>
                                <div class="text-left">
                                    <span class="font-mono text-xs font-bold text-blue-400 block">{{ $pctOfTotalOfficers }}%</span>
                                    <span class="text-[9px] text-slate-500 font-mono block">{{ $courseOfficers }} ضابط ({{ $pctGlobalOfficers }}%)</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-1.5 rounded-lg bg-slate-900/30 border border-slate-800/30">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                    <span class="text-[11px] font-medium text-slate-300">الأفراد</span>
                                </div>
                                <div class="text-left">
                                    <span class="font-mono text-xs font-bold text-amber-400 block">{{ $pctOfTotalSoldiers }}%</span>
                                    <span class="text-[9px] text-slate-500 font-mono block">{{ $courseSoldiers }} فرد ({{ $pctGlobalSoldiers }}%)</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between p-1.5 rounded-lg bg-slate-900/30 border border-slate-800/30">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                                    <span class="text-[11px] font-medium text-slate-300">المتدربين</span>
                                </div>
                                <div class="text-left">
                                    <span class="font-mono text-xs font-bold text-teal-400 block">{{ $pctOfTotalTrainees }}%</span>
                                    <span class="text-[9px] text-slate-500 font-mono block">{{ $courseTrainees }} متدرب ({{ $pctGlobalTrainees }}%)</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="pt-2 border-t border-slate-800/40 text-[10px] text-slate-500 flex justify-between items-center">
                        <span>توزيع نسبي مدمج تلقائياً</span>
                        <span class="text-slate-600 font-mono">حالة جاهزية مستقرة</span>
                    </div>
                    
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center text-slate-500 text-xs py-12 bg-[#0b1329]/20 rounded-2xl border border-dashed border-slate-800">
                    لا توجد دورات تدريبية حالية لعرضها.
                </div>
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
                <option value="مستمرة حالياً">مستمرة حالياً</option>
                <option value="قيد الانتظار">قيد الانتظار</option>
                <option value="مكتملة ومؤرشفة">مكتملة ومؤرشفة</option>
                <option value="ملغاة">ملغاة</option>
            </select>
        </div>
    </div>

    <div class="bg-[#111827] border border-[#1F2937] rounded-2xl shadow-2xl overflow-hidden">
        <div class="p-5 border-b border-[#1F2937] flex items-center justify-between bg-[#111827]/50">
            <h2 class="text-md font-bold text-[#E5E7EB] flex items-center gap-2.5">
                <span class="w-2 h-2 rounded-full bg-blue-500 shadow-md shadow-blue-500/50 animate-pulse"></span> 
                <span>البيانات التفصيلية للدورات التدريبية</span>
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
                          <th class="p-4 select-none">المدة</th>
                      
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
                            @if($course->type == 'تطويرية')
                                <span class="inline-flex items-center gap-1 bg-rose-500/10 text-rose-400 border border-rose-500/20 text-[11px] font-semibold px-2.5 py-0.5 rounded-md backdrop-blur-sm">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    <span> تطويرية</span>
                                </span>
                            @elseif($course->type == 'تأسيسية')
                                <span class="inline-flex items-center gap-1 bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[11px] font-semibold px-2.5 py-0.5 rounded-md backdrop-blur-sm">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    <span>تاسيسية </span>
                                </span>
                                 @elseif($course->type == 'تأهيلية')
                                <span class="inline-flex items-center gap-1 bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[11px] font-semibold px-2.5 py-0.5 rounded-md backdrop-blur-sm">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    <span>تاهيلية </span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[11px] font-semibold px-2.5 py-0.5 rounded-md backdrop-blur-sm">
                                    <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                    <span>متقدمة </span>
                                </span>
                            @endif
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
                                    <span>مستمرة </span>
                                </span>
                            @elseif($course->status == 'قيد الانتظار')
                                <span class="inline-flex items-center gap-1.5 bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[11px] font-medium px-2.5 py-1 rounded-full backdrop-blur-sm">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>قيد الانتظار</span>
                                </span>
                            @elseif($course->status == 'مكتملة ومؤرشفة' || $course->status == 'مكتملة')
                                <span class="inline-flex items-center gap-1.5 bg-blue-500/10 text-blue-400 border border-blue-500/20 text-[11px] font-medium px-2.5 py-1 rounded-full backdrop-blur-sm">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>مكتملة </span>
                                </span>
                            @elseif($course->status == 'ملغاة')
                                <span class="inline-flex items-center gap-1.5 bg-rose-500/10 text-rose-400 border border-rose-500/20 text-[11px] font-medium px-2.5 py-1 rounded-full backdrop-blur-sm">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                    </svg>
                                    <span>ملغاة</span>
                                </span>
                            @endif
                        </td>

                        <td class="p-4 text-center align-middle whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
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
                                        wire:confirm="تحذير نظام صارم: هل أنت متأكد من حذف هذه الحقيبة التدريبية نهائياً من سجلات الجناح المركزي؟"
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
        {{-- شريط التحكم بالصفحات والـ Pagination --}}
        <div class="bg-[#070B14] px-6 py-4 border-t border-[#1e293b] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-xs text-gray-400 font-cairo">
            <div class="flex items-center gap-2">
                <span>عرض كل صفحة</span>
                <select wire:model.live="perPage" class="bg-[#0a0f1d] border border-[#1e293b] rounded px-2 py-1 text-gray-300 focus:outline-none">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
            <div>
                {{ $courses->links() }}
            </div>
        </div>
    </div>

</div>