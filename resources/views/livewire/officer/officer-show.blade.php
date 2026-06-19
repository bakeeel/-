<div class="space-y-6 font-cairo text-right p-4 md:p-6 bg-[#070B14] min-h-screen text-gray-200" dir="rtl">

    {{-- ===== شريط الأدوات العلوي للقيادة ===== --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 bg-[#0f1626]/60 backdrop-blur-md border border-[#1e293b] px-5 py-3.5 rounded-xl shadow-lg">
        <a href="{{ route('officer.index') }}" wire:navigate
           class="flex items-center gap-2 text-gray-400 hover:text-white transition-colors text-sm font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
            </svg>
            رجوع لمنظومة الضباط
        </a>
        
        <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
            <button wire:click="$dispatch('open-edit-modal', { id: {{ $officer->id }}, type: 'officer' })" 
                @click="open = false" 
                type="button" 
                class="w-full block px-3 py-2 text-right text-gray-300 hover:bg-blue-600 hover:text-white text-[11px] font-medium transition whitespace-nowrap">
            تعديل البيانات
        </button>

            <button onclick="window.print()" type="button"
                    class="flex items-center gap-2 bg-[#1e293b] hover:bg-[#2c3e50] border border-gray-700 text-gray-200 px-4 py-2.5 rounded-xl text-sm font-bold transition-all active:scale-95">
                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                <span>طباعة الأمر</span>
            </button>
        </div>
    </div>

    {{-- ===== بطاقة هوية الضابط وعرض رصيد الإبحار الاستراتيجي ===== --}}
    <div class="bg-[#0f1626]/60 backdrop-blur-md border border-[#1e293b] px-6 py-5 rounded-xl shadow-xl flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center gap-5">
            <div class="relative shrink-0">
                <div class="w-32 h-40 rounded-xl bg-[#0a0f1d] border border-[#1e293b] overflow-hidden shadow-2xl relative shrink-0">
                    @if($officer->avatar && file_exists(storage_path('app/public/' . $officer->avatar)))
                        <img src="{{ asset('storage/' . $officer->avatar) }}" class="w-full h-full object-cover">
                    @else
                        <div class="h-full flex flex-col items-center justify-center text-gray-600 bg-[#070B14]">
                            <svg class="w-12 h-12 mb-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="text-[10px] font-medium text-gray-500">لا توجد صورة رسمية</span>
                        </div>
                    @endif
                </div>
                <div class="absolute -bottom-1 -right-1 bg-emerald-600 p-1.5 rounded-full border-2 border-[#070B14] shadow-md">
                    <i class="fas fa-shield-alt text-[9px] text-white"></i>
                </div>
            </div>
            
            <div class="space-y-2">
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-xl font-bold text-white leading-tight">{{ $officer->full_name }}</h1>
                    <span class="text-xs text-blue-300 bg-blue-950/40 border border-blue-900/40 px-2.5 py-0.5 rounded-md font-bold flex items-center gap-1">
                        <i class="fas fa-crown text-[10px]"></i> {{ $officer->rank }}
                    </span>
                </div>
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-[11px] font-mono font-bold text-blue-400 bg-blue-950/30 border border-blue-900/30 px-3 py-1 rounded-lg">
                        الرقم العسكري: {{ $officer->military_id }}
                    </span>
                    
                    {{-- عرض أيام الإبحار في الهوية العلوية --}}
                    <span class="text-[11px] font-mono font-bold text-sky-400 bg-sky-950/30 border border-sky-900/40 px-3 py-1 rounded-lg flex items-center gap-1.5">
                        <i class="fas fa-ship text-[10px]"></i> أيام البحر: {{ $officer->sailing_days ?? 0 }} يوم
                    </span>

                    {{-- عرض ساعات الإبحار بجانب الأيام --}}
                    <span class="text-[11px] font-mono font-bold text-emerald-400 bg-emerald-950/30 border border-emerald-900/40 px-3 py-1 rounded-lg flex items-center gap-1.5">
                        <i class="fas fa-clock text-[10px]"></i> ساعات البحر: {{ $officer->sailing_hours ?? 0 }} ساعة
                    </span>
                </div>
            </div>
        </div>

        <div class="shrink-0 w-full md:w-auto flex md:justify-end">
            @if($officer->status == 'active' || $officer->status == 'نشط')
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-green-400 bg-green-950/30 border border-green-900/50 px-4 py-2 rounded-xl">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> الجاهزية العملياتية / نشط
                </span>
            @else
                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-400 bg-amber-950/30 border border-amber-900/50 px-4 py-2 rounded-xl">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span> الوضع الميداني / {{ $officer->status }}
                </span>
            @endif
        </div>
    </div>

    {{-- ===== المحتوى الرئيسي المقسم تكتيكياً ===== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        {{-- ── العمود الأول: بيانات الخدمة والاتصال والملاحظات العليا ── --}}
        <div class="space-y-6">
            
            {{-- بطاقة السجل والخدمة --}}
            <div class="bg-[#0f1626]/60 backdrop-blur-md border border-[#1e293b] p-5 rounded-xl shadow-lg">
                <div class="flex items-center gap-2 pb-3 mb-4 border-b border-[#1e293b]">
                    <div class="w-6 h-6 rounded-lg bg-[#0a0f1d] border border-[#1e293b] flex items-center justify-center shrink-0">
                        <i class="fas fa-anchor text-xs text-blue-500"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-300 tracking-wide">بيانات السجل العسكري</h3>
                </div>

                {{-- مصفوفة البيانات مع دمج أيام الإبحار وساعات الإبحار بشكل منفصل ومنظم --}}
                @php
                    $serviceData = [
                        ['label' => 'الرتبة الحالية', 'value' => $officer->rank, 'color' => 'text-blue-400', 'icon' => 'crown'],
                        ['label' => 'التخصص الأساسي', 'value' => $officer->specialty ?? ($officer->primary_specialty ?? 'بحري قيادي'), 'color' => 'text-gray-200', 'icon' => 'compass'],
                        ['label' => 'أيام الإبحار المعتمدة', 'value' => ($officer->sailing_days ?? 0) . ' يوم', 'color' => 'text-sky-400 font-mono', 'icon' => 'ship'],
                        ['label' => 'ساعات الابحار المعتمدة', 'value' => ($officer->sailing_hours ?? 0) . ' ساعة', 'color' => 'text-emerald-400 font-mono', 'icon' => 'clock'],
                        ['label' => 'تاريخ التعيين والالتحاق', 'value' => $officer->appointment_date ? \Carbon\Carbon::parse($officer->appointment_date)->format('Y-m-d') : '---', 'color' => 'text-gray-200', 'icon' => 'calendar-alt'],
                    ];
                @endphp

                <div class="space-y-2">
                    @foreach($serviceData as $item)
                        <div class="group flex items-center justify-between bg-[#070B14]/50 border border-[#1e293b] hover:border-blue-500/30 px-3 py-2.5 rounded-xl transition-all duration-150">
                            <div class="flex items-center gap-2 min-w-0 flex-1">
                                <span class="w-6 h-6 rounded-lg bg-[#0f1626] border border-[#1e293b] flex items-center justify-center shrink-0">
                                    <i class="fas fa-{{ $item['icon'] }} text-[10px] text-blue-500"></i>
                                </span>
                                <span class="text-[11px] text-gray-400 font-medium truncate group-hover:text-gray-300 transition-colors">
                                    {{ $item['label'] }}
                                </span>
                            </div>
                            <div class="shrink-0 mr-3">
                                <span class="text-[11px] font-bold bg-[#0f1626] border border-[#1e293b] px-2 py-1 rounded-lg {{ $item['color'] }}">
                                    {{ $item['value'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>        

        </div>

        {{-- ── العمود الثاني والثلث: السجلات التدريبية والترقيات والخط الزمني للرتب ── --}}
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
                        <span class="font-mono font-bold text-gray-200" dir="ltr">{{ $officer->phone ?? '---' }}</span>
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
                        {{ $officer->notes ?? 'لا توجد ملاحظات مسجلة.' }}
                    </p>
                </div>

            </div>
            <div class="hidden md:block w-px bg-[#1e293b] self-stretch my-1 -mr-3"></div>
                

           {{-- السجل التدريبي وقيد حالات الدورات --}}
            <div class="bg-[#0f1626]/60 backdrop-blur-md border border-[#1e293b] p-5 rounded-xl shadow-lg space-y-4" dir="rtl">
                <div class="flex items-center gap-2 pb-3 border-b border-[#1e293b]">
                    <div class="w-6 h-6 rounded-lg bg-[#0a0f1d] border border-[#1e293b] flex items-center justify-center shrink-0">
                        <i class="fas fa-graduation-cap text-xs text-blue-500"></i>
                    </div>
                    <h3 class="text-xs font-bold text-gray-300 tracking-wide">بيان براءات السجل التدريبي وقيد حالات الدورات</h3>
                </div>

                @if(isset($officer->courses) && $officer->courses->count() > 0)
                    {{-- هنا تم تفعيل شبكة العمودين المتساويين الثابتة لبيان الضباط --}}
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($officer->courses as $course)
                            @php
                                $pivotStatus = trim($course->pivot->status ?? 'قيد الانتظار');
                            @endphp

                            {{-- كرت الدورة التدريبية كعمود مستقل مرن --}}
                            <div class="group flex flex-col justify-between bg-[#070B14]/80 border border-[#1e293b] hover:border-blue-500/40 p-4 rounded-xl transition-all duration-200 hover:bg-[#0a1020] gap-4">
                                
                                {{-- تفاصيل الدورة والبيانات اللوجستية العليا --}}
                                <div class="space-y-2.5 w-full">
                                    <div class="flex items-start justify-between gap-2">
                                        <h4 class="text-xs font-bold text-gray-200 group-hover:text-white transition-colors leading-tight">
                                            {{ $course->name }}
                                        </h4>
                                        <span class="text-[9px] font-mono text-blue-400 bg-blue-950/40 border border-blue-900/30 px-1.5 py-0.5 rounded font-bold shrink-0">
                                            #{{ $course->id }}
                                        </span>
                                    </div>

                                    <div class="space-y-1 text-[11px] text-gray-400">
                                        <div class="flex items-center gap-1">
                                            <span class="text-gray-600">الموقع:</span>
                                            <span class="text-gray-300 font-medium truncate" title="{{ $course->location ?? '---' }}">{{ $course->pivot->location ?? '---' }}</span>
                                        </div>
                                        
                                      

                                        {{-- صندوق حظر التواريخ التكتيكي المدمج لعدم تكديس مساحة العمود --}}
                                        <div class="flex items-center justify-between font-mono bg-[#0a0f1d]/50 p-1.5 rounded-lg border border-[#1e293b]/40 mt-1.5 text-[10px]">
                                            <div class="flex flex-col gap-0.5">
                                                <span class="text-[9px] font-sans text-gray-600">البدء</span>
                                                <span class="text-emerald-400 font-bold">{{ $course->pivot->start_date ? \Carbon\Carbon::parse($course->pivot->start_date)->format('Y-m-d') : 'غير محدد' }}</span>
                                            </div>
                                            <div class="w-px h-5 bg-[#1e293b]"></div>
                                            <div class="flex flex-col gap-0.5 items-end">
                                                <span class="text-[9px] font-sans text-gray-600">النهاية</span>
                                                <span class="text-rose-400 font-bold">{{ $course->pivot->end_date ? \Carbon\Carbon::parse($course->pivot->end_date)->format('Y-m-d') : 'غير محدد' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- شريط الإجراء السفلي والمحاذاة التلقائية لعمود السجل الحركي --}}
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

                                        @if($course->duration_days)
                                            <span class="text-[10px] font-mono text-gray-400 bg-[#0f1626] border border-[#1e293b]/60 px-1.5 py-0.5 rounded-md">
                                                {{ $course->duration_days }} يوماً
                                            </span>
                                        @endif
                                    </div>

                                    {{-- زر إسقاط من الدورة التدريبية --}}
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
                    {{-- Empty State المحدثة والمحاذاة بإطار منقط فاخر --}}
                    <div class="flex flex-col items-center justify-center py-12 space-y-3 border border-dashed border-[#1e293b] rounded-xl">
                        <div class="w-14 h-14 rounded-full bg-blue-500/10 border border-blue-500/20 flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-lg text-blue-500"></i>
                        </div>
                        <p class="text-sm font-bold text-gray-300">لا يوجد براءات دورات مسجلة بملف الخدمة</p>
                        <p class="text-[11px] text-gray-500">لم يتم ربط أو رصد شهادات أو ارتباطات تدريبية حالية.</p>
                    </div>
                @endif
            </div>

        </div>

    </div>

    {{-- المكان المستقر لـ Modal التعديل --}}
    <livewire:officer.officer-edit />

</div>