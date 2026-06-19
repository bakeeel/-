{{-- عنصر الجذر الرئيسي الموحد للمكون بالكامل --}}
<div class="space-y-6">
    
    {{-- الهيدر العلوي: شعار المنظومة وشريط الوقت اللحظي --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-[#1F2937] pb-4 w-full" dir="rtl">
        {{-- الجانب الأيمن: شعار المنظومة وعنوان لوحة التحكم الرئيسي --}}
        <div class="text-right">
            <h1 class="text-2xl font-bold text-[#E5E7EB] tracking-wide font-cairo">منظومة التدريب</h1>
            <p class="text-sm text-gray-400 mt-1">لوحة التحكم والمراقبة المركزية الفورية</p>
        </div>

        {{-- الجانب الأيسر: شريط الوقت اللحظي الشامل والجاهزية الأمنية (متكامل ومحدث ثانية بثانية) --}}
        <div class="flex flex-wrap items-center gap-3 bg-[#0a101d] border border-[#1e293b] p-2 rounded-xl" 
            x-data="{ 
                currentTime: '', 
                hijriDate: '',
                gregorianDate: '',
                init() {
                    this.updateClock();
                    setInterval(() => this.updateClock(), 1000);
                },
                updateClock() {
                    const now = new Date();
                    
                    // 1. الوقت اللحظي بتوقيت 12 ساعة (ساعة:دقيقة:ثانية م/ص)
                    this.currentTime = now.toLocaleTimeString('ar-SA', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });
                    
                    // 2. التاريخ الميلادي الحالي (السنة/الشهر/اليوم)
                    this.gregorianDate = now.toLocaleDateString('ar-SA', { year: 'numeric', month: '2-digit', day: '2-digit' }).replace('م', '') + ' مـ';
                    
                    // 3. التاريخ الهجري التلقائي المبني على تقويم أم القرى الرسمي بالمملكة
                    this.hijriDate = now.toLocaleDateString('ar-SA-u-ca-islamic-umalqura', { year: 'numeric', month: '2-digit', day: '2-digit' }).replace('هـ', '') + ' هـ';
                }
            }">
            
            <div class="flex items-center gap-2 text-[11px] font-bold text-gray-400 select-none px-1">
                <div class="flex items-center gap-1 bg-[#050811] px-2.5 py-1 rounded-md border border-[#1e293b]/60">
                    <i class="far fa-calendar-alt text-blue-500 text-[10px]"></i>
                    <span x-text="hijriDate">-- هـ</span>
                </div>
                
                <div class="text-gray-700 hidden sm:block">|</div>
                
                <div class="flex items-center gap-1 bg-[#050811] px-2.5 py-1 rounded-md border border-[#1e293b]/60">
                    <span x-text="gregorianDate">-- مـ</span>
                </div>
                
                <div class="text-gray-700 hidden sm:block">|</div>
                
                <div class="font-mono text-gray-300 bg-[#050811] px-2.5 py-1 rounded-md border border-[#1e293b]/60 min-w-[90px] text-center" 
                    x-text="currentTime">
                    --:--:--
                </div>
            </div>

            <div class="flex items-center gap-2 text-[10px] bg-[#2563EB]/10 border border-[#2563EB]/30 text-[#2563EB] px-3 py-1.5 rounded-md font-mono tracking-wider shadow-sm shrink-0">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                SECURE ACCESS // LIVE STATUS
            </div>
        </div>
    </div>

    {{-- شبكة كروت الإحصائيات (أصبحت الآن متناسقة 5 أعمدة على الشاشات الكبيرة) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
        {{-- كارت الضباط --}}
        <div class="bg-[#111827] border border-[#1F2937] rounded-xl p-5 relative overflow-hidden backdrop-blur-md bg-opacity-40 shadow-xl transition duration-300 hover:border-amber-500/50">
            <div class="absolute top-0 right-0 h-1 w-16 bg-amber-500"></div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider font-cairo">إجمالي الضباط</p>
                    <h3 class="text-3xl font-bold text-[#E5E7EB] mt-2 font-mono">{{ $count_officers }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-amber-500/10 border border-amber-500/20 text-amber-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.151-.312.59-.312.74 0l2.22 4.501 4.966.721c.345.05.483.473.233.717l-3.593 3.502.848 4.945c.059.344-.302.607-.61.444L12 16.007l-4.437 2.332c-.309.162-.668-.101-.61-.444l.849-4.945-3.593-3.502c-.25-.244-.112-.668.233-.717l4.966-.721 2.22-4.501z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- كارت الأفراد --}}
        <div class="bg-[#111827] border border-[#1F2937] rounded-xl p-5 relative overflow-hidden backdrop-blur-md bg-opacity-40 shadow-xl transition duration-300 hover:border-[#2563EB]/50">
            <div class="absolute top-0 right-0 h-1 w-16 bg-[#2563EB]"></div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider font-cairo">إجمالي الأفراد</p>
                    <h3 class="text-3xl font-bold text-[#E5E7EB] mt-2 font-mono">{{ $count_personnel }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-[#2563EB]/10 border border-[#2563EB]/20 text-[#2563EB]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- كارت المتدربين --}}
        <div class="bg-[#111827] border border-[#1F2937] rounded-xl p-5 relative overflow-hidden backdrop-blur-md bg-opacity-40 shadow-xl transition duration-300 hover:border-emerald-500/50">
           <div class="absolute top-0 right-0 h-1 w-16 bg-emerald-500"></div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider font-cairo">إجمالي المتدربين</p>
                    <h3 class="text-3xl font-bold text-[#E5E7EB] mt-2 font-mono">{{ $count_trainees }}</h3>
                </div>
               <div class="p-3 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998a12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- كارت الشواغر (تمت إضافة وإصلاح أيقونة مخصصة ومطابقة للهوية البصرية) --}}
        <div class="bg-[#111827] border border-[#1F2937] rounded-xl p-5 relative overflow-hidden backdrop-blur-md bg-opacity-40 shadow-xl transition duration-300 hover:border-purple-500/50">
            <div class="absolute top-0 right-0 h-1 w-16 bg-purple-500"></div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider font-cairo">إجمالي الشواغر</p>
                    <h3 class="text-3xl font-bold text-[#E5E7EB] mt-2 font-mono">{{ $count_vacancies }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-purple-500/10 border border-purple-500/20 text-purple-500"> 
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- كارت الدورات التدريبية --}}
        <div class="bg-[#111827] border border-[#1F2937] rounded-xl p-5 relative overflow-hidden backdrop-blur-md bg-opacity-40 shadow-xl transition duration-300 hover:border-purple-500/50">
            <div class="absolute top-0 right-0 h-1 w-16 bg-purple-500"></div>
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs font-medium text-gray-400 uppercase tracking-wider font-cairo">الدورات التدريبية</p>
                    <h3 class="text-3xl font-bold text-[#E5E7EB] mt-2 font-mono">{{ $count_courses }}</h3>
                </div>
                <div class="p-3 rounded-lg bg-purple-500/10 border border-purple-500/20 text-purple-500"> 
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
            </div>
        </div>
    </div> {{-- إغلاق شبكة كروت الإحصائيات الفعلي السليم --}}

    {{-- شبكة الجداول والمراقبة السفلية --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- جدول أحدث المضافين مؤخراً (أفراد / ضباط / متدربين) --}}
        <div class="bg-[#111827] border border-[#1F2937] rounded-xl p-5" x-data="{ activeTab: 'personnel' }">
            <div class="flex items-center justify-between border-b border-[#1F2937] pb-3 mb-4">
                <h3 class="text-lg font-bold text-[#E5E7EB] font-cairo flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full transition-colors duration-300" 
                        :class="activeTab === 'personnel' ? 'bg-[#2563EB]' : (activeTab === 'officers' ? 'bg-amber-500' : 'bg-emerald-500')"></span> 
                    <span>أحدث المضافين مؤخراً</span>
                </h3>
                
                <div class="flex bg-gray-900 p-0.5 rounded-lg border border-gray-800 text-xs font-cairo">
                    <button @click="activeTab = 'personnel'" 
                            :class="activeTab === 'personnel' ? 'bg-[#2563EB] text-white font-medium' : 'text-gray-400 hover:text-gray-200'"
                            class="px-3 py-1 rounded-md transition-all duration-200">
                        الأفراد
                    </button>
                    <button @click="activeTab = 'officers'" 
                            :class="activeTab === 'officers' ? 'bg-amber-600 text-white font-medium' : 'text-gray-400 hover:text-gray-200'"
                            class="px-3 py-1 rounded-md transition-all duration-200">
                        الضباط
                    </button>
                    <button @click="activeTab = 'trainees'" 
                            :class="activeTab === 'trainees' ? 'bg-emerald-600 text-white font-medium' : 'text-gray-400 hover:text-gray-200'"
                            class="px-3 py-1 rounded-md transition-all duration-200">
                        المتدربين
                    </button>
                </div>
            </div>

            {{-- تاب الأفراد --}}
            <div class="overflow-x-auto" x-show="activeTab === 'personnel'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0">
                <table class="w-full text-right">
                    <thead>
                        <tr class="text-xs text-gray-400 border-b border-[#1F2937]">
                            <th class="pb-3">الرقم العسكري</th>
                            <th class="pb-3">الاسم الكامل</th>
                            <th class="pb-3">الرتبة</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-300 divide-y divide-[#1F2937]">
                        @forelse($recent_personnel ?? [] as $person)
                        <tr class="hover:bg-gray-800/10 transition-colors">
                            <td class="py-3 font-mono text-[#2563EB]">{{ $person->military_id }}</td>
                            <td class="py-3 font-cairo">{{ $person->full_name }}</td>
                            <td class="py-3"><span class="px-2 py-0.5 rounded text-xs bg-gray-800 border border-gray-700 font-cairo">{{ $person->rank }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-4 text-center text-xs text-gray-500 font-cairo">لا يوجد بيانات أفراد مسجلة حالياً</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- تاب الضباط --}}
            <div class="overflow-x-auto" x-show="activeTab === 'officers'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0">
                <table class="w-full text-right">
                    <thead>
                        <tr class="text-xs text-gray-400 border-b border-[#1F2937]">
                            <th class="pb-3">الرقم العسكري</th>
                            <th class="pb-3">الاسم الكامل</th>
                            <th class="pb-3">الرتبة</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-300 divide-y divide-[#1F2937]">
                        @forelse($recent_officers ?? [] as $officer)
                        <tr class="hover:bg-gray-800/10 transition-colors">
                            <td class="py-3 font-mono text-amber-500">{{ $officer->military_id }}</td>
                            <td class="py-3 font-cairo">{{ $officer->full_name }}</td>
                            <td class="py-3"><span class="px-2 py-0.5 rounded text-xs bg-amber-950/30 text-amber-400 border border-amber-900/40 font-cairo">{{ $officer->rank }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-4 text-center text-xs text-gray-500 font-cairo">لا يوجد بيانات ضباط مسجلة حالياً</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- تاب المتدربين --}}
            <div class="overflow-x-auto" x-show="activeTab === 'trainees'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0">
                <table class="w-full text-right">
                    <thead>
                        <tr class="text-xs text-gray-400 border-b border-[#1F2937]">
                            <th class="pb-3">رقم الهوية / العسكري</th>
                            <th class="pb-3">الاسم الكامل</th>
                            <th class="pb-3">جهة التدريب / الرتبة</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-300 divide-y divide-[#1F2937]">
                        @forelse($recent_trainees ?? [] as $trainee)
                        <tr class="hover:bg-gray-800/10 transition-colors">
                            <td class="py-3 font-mono text-emerald-500">
                                {{ $trainee->identity_number ?? $trainee->military_id }}
                            </td>
                            <td class="py-3 font-cairo">{{ $trainee->full_name ?? $trainee->name }}</td>
                            <td class="py-3">
                                <span class="px-2 py-0.5 rounded text-xs bg-emerald-950/30 text-emerald-400 border border-emerald-900/40 font-cairo">
                                    {{ $trainee->rank ?? $trainee->training_side ?? 'متدرب' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-4 text-center text-xs text-gray-500 font-cairo">لا يوجد بيانات متدربين مسجلة حالياً</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- جدول الدورات التدريبية النشطة مؤخراً --}}
        <div class="bg-[#111827] border border-[#1F2937] rounded-xl p-5">
            <h3 class="text-lg font-bold text-[#E5E7EB] border-b border-[#1F2937] pb-3 mb-4 font-cairo flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> الدورات التدريبية النشطة مؤخراً
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead>
                        <tr class="text-xs text-gray-400 border-b border-[#1F2937]">
                            <th class="pb-3">اسم الدورة</th>
                            <th class="pb-3">تاريخ البداية</th>
                            <th class="pb-3">الحالة</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-300 divide-y divide-[#1F2937] text-right font-cairo">
                        @foreach($recent_courses as $course)
                        <tr class="hover:bg-gray-800/10 transition-colors">
                            <td class="py-3 font-medium text-[#E5E7EB]">{{ $course->name }}</td>
                            <td class="py-3 font-mono text-xs text-gray-400 select-none">
                                {{ $course->start_date ? $course->start_date->format('Y-m-d') : '-' }}
                            </td>
                            <td class="py-3 whitespace-nowrap">
                                @if($course->status === 'مستمرة حالياً')
                                <span class="inline-flex items-center gap-1.5 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[10px] md:text-xs font-bold px-2.5 py-1 rounded-lg backdrop-blur-sm select-none">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    <span>مستمرة حالياً</span>
                                </span>
                                @elseif($course->status === 'قيد الانتظار')
                                <span class="inline-flex items-center gap-1.5 bg-sky-500/10 text-sky-400 border border-sky-500/20 text-[10px] md:text-xs font-bold px-2.5 py-1 rounded-lg backdrop-blur-sm select-none">
                                    <span class="w-1.5 h-1.5 rounded-full bg-sky-400"></span>
                                    <span>قيد الانتظار</span>
                                </span>
                                @elseif($course->status === 'مكتملة ومؤرشفة')
                                <span class="inline-flex items-center gap-1.5 bg-purple-500/10 text-purple-400 border border-purple-500/20 text-[10px] md:text-xs font-bold px-2.5 py-1 rounded-lg backdrop-blur-sm select-none">
                                    <svg class="w-3 h-3 text-purple-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>مكتملة ومؤرشفة</span>
                                </span>
                                @elseif($course->status === 'ملغاة')
                                <span class="inline-flex items-center gap-1.5 bg-rose-500/10 text-rose-400 border border-rose-500/20 text-[10px] md:text-xs font-bold px-2.5 py-1 rounded-lg backdrop-blur-sm select-none">
                                    <svg class="w-3 h-3 text-rose-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span>ملغاة</span>
                                </span>
                                @else
                                <span class="inline-flex items-center bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[10px] font-bold px-1.5 py-0.5 rounded-md h-5 leading-none select-none">
                                    <span>{{ $course->status }}</span>
                                </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div> {{-- إغلاق عنصر الجذر الرئيسي الموحد والأخير للملف بالكامل --}}