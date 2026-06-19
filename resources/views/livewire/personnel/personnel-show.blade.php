<div class="space-y-6 font-cairo text-right p-4 md:p-6 bg-[#070B14] min-h-screen text-gray-200" dir="rtl">

    {{-- ===== شريط الأدوات العلوي ===== --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-[#0f1626]/60 backdrop-blur-md border border-[#1e293b] px-5 py-3.5 rounded-xl shadow-lg">
        <a href="{{ route('personnel.index') }}" wire:navigate
           class="flex items-center gap-2 text-gray-400 hover:text-white transition-colors text-sm font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
            </svg>
            رجوع للقائمة
        </a>
        
        <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
            <button wire:click="$dispatch('open-edit-modal', { id: {{ $person->id }} })" type="button"
                    class="flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-all active:scale-95 shadow-md shadow-blue-900/10">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                <span>تعديل البيانات</span>
            </button>

            <button onclick="window.print()" type="button"
                    class="flex items-center gap-2 bg-[#1e293b] hover:bg-[#2c3e50] border border-gray-700 text-gray-200 px-4 py-2.5 rounded-xl text-sm font-bold transition-all active:scale-95">
                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>طباعة</span>
            </button>
        </div>
    </div>

    {{-- ===== بطاقة هوية الفرد والوضع العملياتي ===== --}}
    <div class="bg-[#0f1626]/60 backdrop-blur-md border border-[#1e293b] px-6 py-5 rounded-xl shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center gap-5">
            <div class="relative shrink-0">
                <div class="w-32 h-40 rounded-xl bg-[#0a0f1d] border border-[#1e293b] overflow-hidden shadow-2xl relative shrink-0">
                    @if($person->avatar && file_exists(storage_path('app/public/' . $person->avatar)))
                        <img src="{{ asset('storage/' . $person->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <div class="h-full flex flex-col items-center justify-center text-gray-600 bg-[#070B14]">
                            <svg class="w-12 h-12 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-[10px] font-medium text-gray-500">لا توجد صورة</span>
                        </div>
                    @endif
                </div>
                <div class="absolute -bottom-1 -right-1 bg-green-500 p-1 rounded-full border-2 border-[#070B14]">
                    <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
            <div class="space-y-2">
                <h1 class="text-xl font-bold text-white leading-tight">{{ $person->full_name }}</h1>
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-[11px] font-mono font-bold text-blue-400 bg-blue-950/40 border border-blue-900/40 px-3 py-1 rounded-lg">
                        الرقم العسكري: {{ $person->military_id }}
                    </span>
                    <span class="text-[11px] text-blue-300 bg-blue-950/30 border border-blue-900/30 px-3 py-1 rounded-lg font-bold">
                        {{ $person->rank }}
                    </span>
                </div>
            </div>
        </div>

        <div class="shrink-0">
            @if($person->status == 'active' || $person->status == 'نشط')
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-green-400 bg-green-950/30 border border-green-900/50 px-4 py-2 rounded-xl">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> جاهزية تامة / نشط
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-400 bg-amber-950/30 border border-amber-900/50 px-4 py-2 rounded-xl">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span> غير متواجد / {{ $person->status }}
                </span>
            @endif
        </div>
    </div>

    {{-- ===== المحتوى الرئيسي ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- ── العمود الأول: بيانات الخدمة والاتصال والملاحظات ── --}}
        <div class="space-y-6 lg:col-span-1">
            
            {{-- بيانات الخدمة العسكرية --}}
            <div class="bg-[#0f1626]/60 backdrop-blur-md border border-[#1e293b] p-5 rounded-xl shadow-lg">
                <div class="flex items-center gap-2 pb-3 mb-4 border-b border-[#1e293b]">
                    <div class="w-6 h-6 rounded-lg bg-[#0a0f1d] border border-[#1e293b] flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1"/>
                        </svg>
                    </div>
                    <h3 class="text-xs font-bold text-gray-300 tracking-wide">بيانات الخدمة العسكرية</h3>
                </div>

                @php
                    $serviceData = [
                        ['label' => 'الرتبة الحالية', 'value' => $person->rank, 'color' => 'text-blue-400', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>'],
                        ['label' => 'التخصص الرئيسي', 'value' => $person->primary_specialty, 'color' => 'text-gray-200', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>'],
                        ['label' => 'التخصص الفرعي', 'value' => $person->sub_specialty, 'color' => 'text-gray-200', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16"/>'],
                        ['label' => 'تاريخ التعيين والالتحاق', 'value' => $person->appointment_date?->format('Y-m-d'), 'color' => 'text-gray-200', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>'],
                        ['label' => 'تاريخ التثبيت بالخدمة', 'value' => $person->confirmation_date?->format('Y-m-d'), 'color' => 'text-gray-200', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'],
                        ['label' => 'تاريخ آخر ترقية عسكرية', 'value' => $person->current_promotion_date?->format('Y-m-d'), 'color' => 'text-amber-400', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>'],
                        ['label' => 'مدة الخدمة العسكرية', 'value' => "{$person->service_years} سنة و {$person->service_months} شهر", 'color' => 'text-emerald-400', 'svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>'],
                    
                        ];
                @endphp

                <div class="space-y-2">
                    @foreach($serviceData as $item)
                        <div class="group flex items-center justify-between bg-[#070B14]/50 border border-[#1e293b] hover:border-blue-500/30 px-3 py-2.5 rounded-xl transition-all duration-150">
                            <div class="flex items-center gap-2 min-w-0 flex-1">
                                <span class="w-6 h-6 rounded-lg bg-[#0f1626] border border-[#1e293b] flex items-center justify-center shrink-0">
                                    <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        {!! $item['svg'] !!}
                                    </svg>
                                </span>
                                <span class="text-[11px] text-gray-400 font-medium truncate group-hover:text-gray-300 transition-colors">
                                    {{ $item['label'] }}
                                </span>
                            </div>
                            <div class="shrink-0 mr-3">
                                <span class="text-[11px] font-bold font-mono bg-[#0f1626] border border-[#1e293b] px-2 py-1 rounded-lg {{ $item['color'] }}">
                                    {{ $item['value'] ?? '---' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        {{-- ── العمود الثاني والثلث: السجلات التدريبية والترقيات ── --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- بطاقة الاتصال والملاحظات المدمجة في صف واحد متجاوب --}}
            <div class="bg-[#0f1626]/60 backdrop-blur-md border border-[#1e293b] p-5 rounded-xl shadow-lg">
                <div class="grid grid-cols-2 gap-4 items-stretch" dir="rtl">
                
                {{-- العمود الأيمن: بيانات الاتصال --}}
                <div class="space-y-2 flex flex-col justify-between bg-[#070B14]/50 border border-[#1e293b] p-3 rounded-xl">
                    <div class="flex items-center gap-2 pb-1.5 border-b border-[#1e293b]/60">
                        <div class="w-5 h-5 rounded-md bg-[#0a0f1d] border border-[#1e293b] flex items-center justify-center shrink-0">
                            <i class="fas fa-phone-alt text-[10px] text-emerald-500"></i>
                        </div>
                        <h3 class="text-[11px] font-bold text-gray-300">بيانات الاتصال</h3>
                    </div>
                    
                    <div class="flex items-center justify-between text-[11px] pt-1">
                        <span class="text-gray-400">رقم الجوال الرسمي:</span>
                        <span class="font-mono font-bold text-gray-200" dir="ltr">{{ $person->phone ?? '---' }}</span>
                    </div>
                </div>

                {{-- العمود الأيسر: ملاحظات وتوجيهات القيادة --}}
                <div class="space-y-2 flex flex-col bg-[#070B14]/50 border border-[#1e293b] p-3 rounded-xl">
                    <div class="flex items-center gap-2 pb-1.5 border-b border-[#1e293b]/60">
                        <div class="w-5 h-5 rounded-md bg-[#0a0f1d] border border-[#1e293b] flex items-center justify-center shrink-0">
                            <i class="fas fa-clipboard text-[10px] text-amber-500"></i>
                        </div>
                        <h3 class="text-[11px] font-bold text-gray-300">ملاحظات وتوجيهات القيادة</h3>
                    </div>
                    
                    <p class="text-[11px] text-gray-400 leading-relaxed pt-1 flex-1 min-h-[32px]">
                        {{ $person->notes ?? 'لا توجد ملاحظات مسجلة.' }}
                    </p>
                </div>

            </div>
            </div>
            
       {{-- السجل التدريبي والدورات الحاصل عليها ومتابعة الـ Pivot ديناميكياً --}}
            <div class="bg-[#0f1626]/60 backdrop-blur-md border border-[#1e293b] p-5 rounded-xl shadow-lg space-y-4" dir="rtl">
                <div class="flex items-center gap-2 pb-3 border-b border-[#1e293b]">
                    <div class="w-6 h-6 rounded-lg bg-[#0a0f1d] border border-[#1e293b] flex items-center justify-center shrink-0">
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998a12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                        </svg>
                    </div>
                    <h3 class="text-xs font-bold text-gray-300 tracking-wide">السجل التدريبي الميداني وبيانات التسجيل الحرة</h3>
                </div>

                @if(isset($person->courses) && $person->courses->count() > 0)
                    {{-- شبكة العمودين المتساويين الثابتة --}}
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($person->courses as $course)
                            @php
                                $pivotStatus = trim($course->pivot->status ?? 'قيد الانتظار');
                            @endphp

                            {{-- كرت الدورة كعمود مستقل مرن بارتفاع متناسق --}}
                            <div class="group flex flex-col justify-between bg-[#070B14]/80 border border-[#1e293b] hover:border-blue-500/40 p-4 rounded-xl transition-all duration-200 hover:bg-[#0a1020] gap-4">
                                
                                {{-- معلومات الدورة الأساسية الحرة --}}
                                <div class="space-y-3 w-full flex flex-col">
                                    
                                    {{-- الصف الأول: اسم الدورة وجهة التنفيذ --}}
                                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-2">
                                        <h4 class="text-xs font-bold text-gray-200 group-hover:text-white transition-colors leading-tight max-w-[60%]">
                                            {{ $course->name }}
                                        </h4>
                                        
                                        <div class="flex items-center gap-1 text-[11px] text-gray-400 shrink-0">
                                            <span class="text-gray-600">الجهة المنفذة:</span>
                                            <span class="text-gray-300 font-medium truncate max-w-[120px]" title="{{ $course->pivot->location ?? $course->location ?? '---' }}">
                                                {{ $course->pivot->location ?? $course->location ?? '---' }}
                                            </span>
                                        </div>
                                    </div>

                                    {{-- الصف الثاني: شريط التواريخ الداخلي المدمج بنظام كتل أفقي في سطر مستقل تماماً لمنع التداخل --}}
                                    @if(($course->pivot->start_date ?? null) || ($course->pivot->end_date ?? null))
                                        <div class="flex items-center justify-between font-mono bg-[#0a0f1d]/50 p-2 rounded-lg border border-[#1e293b]/40 w-full text-[10px]">
                                            @if($course->pivot->start_date ?? null)
                                                <div class="flex flex-col gap-0.5">
                                                    <span class="text-[9px] font-sans text-gray-600">البدء</span>
                                                    <span class="text-gray-400 font-bold">{{ \Carbon\Carbon::parse($course->pivot->start_date)->format('Y-m-d') }}</span>
                                                </div>
                                            @endif
                                            
                                            @if(($course->pivot->start_date ?? null) && ($course->pivot->end_date ?? null))
                                                <div class="w-px h-5 bg-[#1e293b] mx-2"></div>
                                            @endif

                                            @if($course->pivot->end_date ?? null)
                                                <div class="flex flex-col gap-0.5 items-end">
                                                    <span class="text-[9px] font-sans text-gray-600">النهاية</span>
                                                    <span class="text-gray-400 font-bold">{{ \Carbon\Carbon::parse($course->pivot->end_date)->format('Y-m-d') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                {{-- شريط التحكم والحالة السفلي الموحد برمجياً داخل كرت العمود --}}
                                <div class="flex items-center justify-between border-t border-[#1e293b]/50 pt-2.5 shrink-0">
                                    <div class="flex items-center gap-1.5">
                                        {{-- فرز تلوين الحالة المقيدة بجدول الربط (Pivot) --}}
                                        @php
                                            if(in_array($pivotStatus, ['مستمر في الدورة', 'مستمر في الدوره', 'مستمر', 'active', 'running'])) {
                                                $statusClass = 'text-blue-400 bg-blue-950/40 border-blue-900/50';
                                                $dotClass = 'bg-blue-500 animate-pulse';
                                            } elseif(in_array($pivotStatus, ['اكمل الدورة', 'أكمل الدورة', 'اكمل الدوره', 'أكمل الدوره', 'مكتمل', 'completed'])) {
                                                $statusClass = 'text-emerald-400 bg-emerald-950/40 border-emerald-900/50';
                                                $dotClass = 'bg-emerald-500';
                                            } elseif(in_array($pivotStatus, ['اسقاط من الدورة', 'إسقاط من الدورة', 'اسقاط من الدروه', 'إسقاط من الدوره', 'اسقاط', 'منقطع', 'dropped'])) {
                                                $statusClass = 'text-rose-400 bg-rose-950/40 border-rose-900/50';
                                                $dotClass = 'bg-rose-500';
                                            } else {
                                                $statusClass = 'text-amber-400 bg-amber-950/40 border-amber-900/50';
                                                $dotClass = 'bg-amber-500';
                                            }
                                        @endphp

                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-lg border {{ $statusClass }} whitespace-nowrap">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                                            {{ $pivotStatus }}
                                        </span>

                                        @if($course->duration_days)
                                            <span class="text-[10px] font-mono text-gray-400 bg-[#0f1626] border border-[#1e293b]/60 px-1.5 py-0.5 rounded-md">
                                                {{ $course->duration_days }} يوماً
                                            </span>
                                        @endif
                                    </div>

                                    {{-- زر الإسقاط الإداري للدورة من الـ Component --}}
                                    <button wire:click="dropCourse({{ $course->id }})" 
                                            wire:confirm="هل أنت متأكد من رغبتك في إسقاط هذا الفرد من الدورة التدريبية؟"
                                            wire:loading.attr="disabled"
                                            type="button"
                                            class="p-1 rounded-md border border-rose-900/30 bg-rose-950/20 text-rose-400 hover:bg-rose-950/60 hover:text-rose-300 transition-all shrink-0 cursor-pointer disabled:opacity-40" 
                                            title="إسقاط من الدورة">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- حالة عدم وجود أي دورات مسجلة (Empty State) --}}
                    <div class="flex flex-col items-center justify-center py-12 space-y-3 border border-dashed border-[#1e293b] rounded-xl">
                        <div class="w-14 h-14 rounded-full bg-blue-500/10 border border-blue-500/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998a12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                            </svg>
                        </div>
                        <p class="text-sm font-bold text-gray-300">لا توجد دورات مسجلة</p>
                        <p class="text-[11px] text-gray-500">لم يلتحق الفرد بأي دورات تدريبية ميدانية حتى الآن</p>
                    </div>
                @endif
            </div>

        </div>

    </div>

    {{-- المودال المستقر --}}
    <livewire:personnel.personnel-edit />

</div>