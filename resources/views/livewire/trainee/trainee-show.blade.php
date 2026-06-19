<div class="space-y-6 font-cairo text-right p-4 md:p-6 bg-[#070B14] min-h-screen text-gray-200 print:bg-white print:text-black print:p-0 print:min-h-auto" dir="rtl">

    {{-- ===== شريط الأدوات العلوي (مخفي أثناء الطباعة) ===== --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-[#0f1626]/60 backdrop-blur-md border border-[#1e293b] px-5 py-3.5 rounded-xl shadow-lg print:hidden">
        <a href="{{ route('trainee.index') }}" wire:navigate
           class="flex items-center gap-2 text-gray-400 hover:text-white transition-colors text-sm font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
            </svg>
            رجوع لقائمة المتدربين
        </a>
        
        <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
            @if(isset($trainee->id))
                <button wire:click="$dispatch('open-edit-modal', { id: {{ $trainee->id }} })" type="button"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white px-4 py-2.5 rounded-xl text-sm font-bold transition-all active:scale-95 shadow-md shadow-blue-900/10">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    <span>تعديل بيانات المتدرب</span>
                </button>
            @endif

            <button onclick="window.print()" type="button"
                    class="flex items-center gap-2 bg-[#1e293b] hover:bg-[#2c3e50] border border-gray-700 text-gray-200 px-4 py-2.5 rounded-xl text-sm font-bold transition-all active:scale-95">
                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>طباعة الملف</span>
            </button>
        </div>
    </div>

    {{-- ===== بطاقة هوية المتدرب والوضع العملياتي المحدثة ===== --}}
    <div class="bg-[#0f1626]/60 backdrop-blur-md border border-[#1e293b] px-6 py-5 rounded-xl shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4 print:bg-transparent print:border-gray-300 print:shadow-none">
        <div class="flex items-center gap-5">
            <div class="relative shrink-0">
                <div class="w-32 h-40 rounded-xl bg-[#0a0f1d] border border-[#1e293b] overflow-hidden shadow-2xl relative shrink-0 print:border-gray-400 print:shadow-none">
                    @if(!empty($trainee->avatar) && file_exists(storage_path('app/public/' . $trainee->avatar)))
                        <img src="{{ asset('storage/' . $trainee->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <div class="h-full flex flex-col items-center justify-center text-gray-600 bg-[#070B14] print:bg-gray-100 print:text-gray-400">
                            <svg class="w-12 h-12 mb-1 print:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-[10px] font-medium text-gray-500 print:text-gray-400">لا توجد صورة</span>
                        </div>
                    @endif
                </div>
                <div class="absolute -bottom-1 -right-1 bg-green-500 p-1 rounded-full border-2 border-[#070B14] print:hidden">
                    <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
            <div class="space-y-2">
                <div class="flex items-center gap-2">
                    <h1 class="text-xl font-bold text-white leading-tight print:text-black">{{ $trainee->full_name ?? '---' }}</h1>
                    <span class="text-gray-500 text-sm font-bold">---</span>
                </div>
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-[11px] font-mono font-bold text-blue-400 bg-blue-950/40 border border-blue-900/40 px-3 py-1 rounded-lg print:bg-gray-100 print:text-black print:border-gray-300">
                        الرقم العسكري: {{ $trainee->military_id ?? '---' }}
                    </span>
                    <span class="text-[11px] text-blue-300 bg-blue-950/30 border border-blue-900/30 px-3 py-1 rounded-lg font-bold print:bg-gray-100 print:text-black print:border-gray-300">
                        الرتبة: {{ $trainee->rank ?? '---' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="shrink-0">
            @if($trainee->status == 'active' || $trainee->status == 'نشط')
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-green-400 bg-green-950/30 border border-green-900/50 px-4 py-2 rounded-xl">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> جاهزية تامة / نشط
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-400 bg-amber-950/30 border border-amber-900/50 px-4 py-2 rounded-xl">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span> غير متواجد / {{ $trainee->status }}
                </span>
            @endif
        </div>
    </div>

    {{-- ===== المحتوى الرئيسي المقسم ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start print:grid-cols-3 print:gap-4">

        {{-- ── العمود الأول والثاني: البيانات الإدارية، الاتصال، والدورات المتقدمة ── --}}
        <div class="lg:col-span-2 space-y-6 print:space-y-4">
            
            {{-- بطاقة البيانات الإدارية والتخصصية --}}
            <div class="bg-[#0f1626]/60 backdrop-blur-md border border-[#1e293b] p-5 rounded-xl shadow-lg print:bg-transparent print:border-gray-300 print:shadow-none">
                <div class="flex items-center gap-2 pb-3 mb-4 border-b border-[#1e293b] print:border-gray-300">
                    <div class="p-1.5 rounded-lg bg-blue-500/10 text-blue-400 print:text-black">
                        <i class="fas fa-id-card-alt text-sm"></i>
                    </div>
                    <h3 class="text-sm font-bold text-white print:text-black">البيانات الإدارية والتخصصية</h3>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5" dir="rtl">
                    @php
                        $infoItems = [
                            ['label' => ' الاسم كامل', 'value' => $trainee->full_name ?? 'غير محدد', 'icon' => 'person', 'fullWidth' => false],
                            ['label' => 'التخصص الرئيسي', 'value' => $trainee->primary_specialty ?? 'غير محدد', 'icon' => 'star', 'fullWidth' => false],
                            ['label' => 'الرتبة الحالية', 'value' => $trainee->rank ?? 'غير محدد', 'icon' => 'award', 'fullWidth' => false],
                            ['label' => 'رقم الهاتف', 'value' => $trainee->phone ?? '---', 'icon' => 'phone', 'fullWidth' => false],
                            ['label' => 'ملاحظات وتقييمات', 'value' => $trainee->notes ?? 'لا توجد ملاحظات مرصودة', 'icon' => 'file-alt', 'fullWidth' => true],
                        ];
                    @endphp

                    @foreach($infoItems as $item)
                        <div class="flex items-center justify-between bg-[#070B14]/80 border border-[#1e293b] px-4 py-3 rounded-xl print:bg-transparent print:border-gray-300 {{ $item['fullWidth'] ? 'sm:col-span-2' : '' }}">
                            <span class="text-xs text-gray-400 flex items-center gap-2.5 print:text-gray-700">
                                <i class="fas fa-{{ $item['icon'] }} text-blue-500 w-4 text-center print:text-black"></i>
                                <span class="font-medium font-cairo">{{ $item['label'] }}</span>
                            </span>
                            
                            <span class="text-xs font-bold text-white print:text-black {{ !$item['fullWidth'] ? 'font-mono' : 'font-cairo text-right max-w-[70%] break-words' }}">
                                {{ $item['value'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- بطاقة بيانات الاتصال المؤكدة وملاحظات القيادة --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                {{-- بيانات الاتصال المؤكدة --}}
                <!-- <div class="bg-[#0f1626]/60 backdrop-blur-md border border-[#1e293b] p-5 rounded-xl shadow-lg">
                    <div class="flex items-center justify-between pb-3 mb-4 border-b border-[#1e293b]">
                        <div class="flex items-center gap-2">
                            <div class="p-1.5 rounded-lg bg-green-500/10 text-green-400">
                                <i class="fas fa-phone-alt text-xs"></i>
                            </div>
                            <h3 class="text-xs font-bold text-white">بيانات الاتصال المؤكدة</h3>
                        </div>
                    </div>
                    <div class="bg-[#070B14]/80 border border-[#1e293b] p-3.5 rounded-xl flex flex-col gap-1.5">
                        <span class="text-[11px] text-gray-500">رقم الجوال الرسمي</span>
                        <span class="text-sm font-bold font-mono text-gray-200">{{ $trainee->official_phone ?? '1233123213' }}</span>
                    </div>
                </div> -->

                {{-- ملاحظات وتوجيهات القيادة العليا --}}
                <!-- <div class="bg-[#0f1626]/60 backdrop-blur-md border border-[#1e293b] p-5 rounded-xl shadow-lg">
                    <div class="flex items-center gap-2 pb-3 mb-4 border-b border-[#1e293b]">
                        <div class="p-1.5 rounded-lg bg-amber-500/10 text-amber-400">
                            <i class="fas fa-clipboard-list text-xs"></i>
                        </div>
                        <h3 class="text-xs font-bold text-white">ملاحظات وتوجيهات القيادة العليا</h3>
                    </div>
                    <div class="bg-[#070B14]/80 border border-[#1e293b] p-3 rounded-xl min-h-[58px] flex items-start justify-between">
                        <p class="text-xs text-gray-400 leading-relaxed">{{ $trainee->command_notes ?? 'لا توجد ملاحظات مرصودة حالياً.' }}</p>
                        <span class="text-[10px] text-gray-600 font-bold px-1.5 py-0.5 bg-[#0a0f1d] rounded-md shrink-0">تم</span>
                    </div>
                </div> -->
            </div>
            
           {{-- بيان براءات السجل التدريبي وقيد حالات الدورات (مستوحى من واجهة النظام الفاخرة) --}}
        <div class="bg-[#0f1626]/60 backdrop-blur-md border border-[#1e293b] p-5 rounded-xl shadow-lg print:bg-transparent print:border-gray-300 print:shadow-none" dir="rtl">
            <div class="flex items-center gap-2 pb-3 mb-4 border-b border-[#1e293b] print:border-gray-300">
                <div class="p-1.5 rounded-lg bg-blue-500/10 text-blue-400 print:text-black">
                    <i class="fas fa-graduation-cap text-sm"></i>
                </div>
                <h3 class="text-sm font-bold text-white print:text-black">بيان براءات السجل التدريبي وقيد حالات الدورات</h3>
            </div>

            @if(isset($trainee->courses) && $trainee->courses->count() > 0)
                {{-- هنا تم تطبيق شبكة العمودين المتساويين الثابتة --}}
                <div class="grid grid-cols-2 gap-4">
                    @foreach($trainee->courses as $course)
                        @php
                            $pivotId = $course->pivot->id ?? '#';
                            $location = $course->pivot->location ?? 'وزارة الحج والعمرة';
                            $startDate = $course->pivot->start_date ? \Carbon\Carbon::parse($course->pivot->start_date) : null;
                            $endDate = $course->pivot->end_date ? \Carbon\Carbon::parse($course->pivot->end_date) : null;
                            $pivotStatus = trim($course->pivot->status ?? 'قيد الانتظار');
                            
                            // حساب المدة الإجمالية للأيام
                            $totalDays = ($startDate && $endDate) ? $startDate->diffInDays($endDate) + 1 : ($course->duration_days ?? 22);
                        @endphp

                        {{-- صندوق الدورة التدريبية كعمود مستقل --}}
                        <div class="bg-[#070B14]/60 border border-[#1e293b] p-4 rounded-xl flex flex-col justify-between gap-4 hover:border-blue-500/20 transition-all print:bg-transparent print:border-gray-300">
                            
                            {{-- تفاصيل الدورة العلوية --}}
                            <div class="space-y-2.5 w-full">
                                <div class="flex items-start justify-between gap-2">
                                    <h4 class="text-sm font-bold text-white print:text-black leading-tight">{{ $course->name ?? 'رعاية الحجاج' }}</h4>
                                    <span class="text-[10px] font-mono font-bold text-blue-400 bg-blue-950/50 px-2 py-0.5 rounded border border-blue-900/50 shrink-0">
                                        #{{ $course->id ?? $pivotId }}
                                    </span>
                                </div>
                                
                                <div class="space-y-1.5 text-[11px]">
                                    <div class="flex items-center gap-1.5 text-gray-400">
                                        <span class="text-gray-500 shrink-0">الجهة المنفذة:</span>
                                            <span class="text-gray-300 font-medium truncate" title="{{ $course->location ?? '---' }}">{{ $course->pivot->location ?? '---' }}</span>
                                    </div>
                                    <div class="flex items-center justify-between font-mono bg-[#0a0f1d]/40 p-1.5 rounded-lg border border-[#1e293b]/40">
                                        <div class="flex flex-col gap-0.5">
                                            <span class="text-[9px] font-sans text-gray-500">تاريخ البدء</span>
                                            <span class="text-emerald-400 font-bold text-[10px]">{{ $startDate ? $startDate->format('d-m-Y') : '01-06-2026' }}</span>
                                        </div>
                                        <div class="w-px h-5 bg-[#1e293b]"></div>
                                        <div class="flex flex-col gap-0.5 items-end">
                                            <span class="text-[9px] font-sans text-gray-500">تاريخ النهاية</span>
                                            <span class="text-rose-400 font-bold text-[10px]">{{ $endDate ? $endDate->format('d-m-Y') : '11-06-2026' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- شريط التحكم السفلي المدمج لكل عمود --}}
                            <div class="flex items-center justify-between border-t border-[#1e293b]/50 pt-2.5 shrink-0">
                                <div class="flex items-center gap-1.5">
                                    {{-- فرز تلوين الحالة المقيدة تكتيكياً --}}
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

                                    @if($totalDays)
                                        <span class="text-[10px] font-mono text-gray-400 bg-[#0f1626] border border-[#1e293b]/60 px-1.5 py-0.5 rounded-md">
                                            {{ $totalDays }} يوماً
                                        </span>
                                    @endif
                                </div>

                                {{-- زر الإسقاط الإداري للدورة --}}
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
                <div class="text-center py-8 border border-dashed border-[#1e293b] rounded-xl print:border-gray-300">
                    <i class="fas fa-graduation-cap text-gray-600 text-2xl mb-2"></i>
                    <p class="text-xs text-gray-500">لا توجد براءات تدريبية مسجلة في قيد المتدرب حالياً.</p>
                </div>
            @endif
        </div>
        </div>

        {{-- ── العمود الثالث: التواريخ والمؤشرات الزمنية + وحدة التعديل السريع ── --}}
        <div class="space-y-6">
            
            {{-- بطاقة المؤشرات الزمنية --}}
            <div class="bg-[#0f1626]/60 backdrop-blur-md border border-[#1e293b] p-5 rounded-xl shadow-lg print:bg-transparent print:border-gray-300 print:shadow-none">
                <div class="flex items-center gap-2 pb-3 mb-4 border-b border-[#1e293b] print:border-gray-300">
                    <div class="p-1.5 rounded-lg bg-amber-500/10 text-amber-400 print:text-black">
                        <i class="fas fa-calendar-alt text-sm"></i>
                    </div>
                    <h3 class="text-sm font-bold text-white print:text-black">المؤشرات والتواريخ الزمنية</h3>
                </div>

                <div class="space-y-3">
                    @php
                        $dates = [
                            ['label' => 'تاريخ التعيين', 'date' => $trainee->appointment_date ?? null, 'icon' => 'calendar-check'],
             
                        ];
                    @endphp

                    @foreach($dates as $item)
                        <div class="flex items-center justify-between bg-[#070B14]/60 border border-[#1e293b] p-3.5 rounded-xl print:bg-transparent print:border-gray-300">
                            <div class="flex items-center gap-2.5">
                                <i class="fas fa-{{ $item['icon'] }} text-amber-500 text-xs print:text-black"></i>
                                <span class="text-xs text-gray-400 print:text-gray-700">{{ $item['label'] }}</span>
                            </div>
                            <span class="text-xs font-mono font-bold text-amber-400 bg-amber-900/20 border border-amber-900/30 px-2.5 py-1 rounded-lg print:text-black print:bg-transparent print:border-none">
                                {{ $item['date'] ? \Carbon\Carbon::parse($item['date'])->format('Y-m-d') : '---' }}
                            </span>
                        </div>
                    @endforeach

                    {{-- عرض مدة الخدمة المحسوبة من النظام تلقائياً --}}
                    <div class="flex items-center justify-between bg-[#070B14]/60 border border-[#1e293b] p-3.5 rounded-xl print:bg-transparent print:border-gray-300">
                        <div class="flex items-center gap-2.5">
                            <i class="fas fa-hourglass-half text-blue-400 text-xs print:text-black"></i>
                            <span class="text-xs text-gray-400 print:text-gray-700">مدة الخدمة بالمنظومة</span>
                        </div>
                        <span class="text-xs font-bold text-blue-400 print:text-black">
                            {{ $trainee->service_years ?? 0 }} سنة و {{ $trainee->service_months ?? 0 }} شهر
                        </span>
                    </div>
                </div>
            </div>

            {{-- استدعاء مودال التعديل السريع للمتدرب --}}
            @if(isset($trainee->id))
                <div class="block print:hidden">
                    <livewire:trainee.trainee-edit :traineeId="$trainee->id" :wire:key="'trainee-edit-'.$trainee->id" />
                </div>
            @endif
        </div>

    </div>
</div>