<div class="space-y-6 font-cairo text-right p-4 md:p-6 bg-[#070B14] min-h-screen text-gray-200" dir="rtl">

    {{-- ===== قسم البحث الذكي للضباط ===== --}}
    <div class="bg-[#0f1626]/60 backdrop-blur-md border border-[#1e293b] rounded-xl p-6 shadow-xl">

        <h2 class="text-[#3b82f6] text-sm font-bold mb-6 flex items-center gap-3">
            <div class="p-2 rounded-lg bg-[#3b82f6]/10 flex items-center justify-center">
                <i class="fas fa-search text-sm"></i>
            </div>
            <span class="tracking-wide">منظومة البحث والتقصي الذكي عن الضباط</span>
        </h2>

        <form wire:submit.prevent="search" class="w-full bg-[#0f1626] p-5 rounded-xl border border-[#1e293b] font-cairo shadow-xl" dir="rtl">
            <div class="flex flex-col md:flex-row items-end gap-4 w-full">
                
                <div class="space-y-2 w-full md:flex-1">
                    <label class="text-xs font-bold text-gray-400 flex items-center gap-2 px-1 select-none">
                        <i class="fas fa-user-shield text-blue-500 w-4 text-center text-xs"></i> 
                        <span>اسم الضابط الكريم</span>
                    </label>
                    <input type="text" wire:model.defer="search_name" placeholder="أدخل اسم الضابط الرباعي..."
                           class="w-full bg-[#070B14] border border-[#1e293b] focus:border-blue-500/50 rounded-xl text-sm px-5 py-3.5 text-white focus:ring-4 focus:ring-blue-500/10 focus:outline-none text-right placeholder:text-gray-600">
                </div>

                <div class="space-y-2 w-full md:flex-1">
                    <label class="text-xs font-bold text-gray-400 flex items-center gap-2 px-1 select-none">
                        <i class="fas fa-id-card-alt text-blue-500 w-4 text-center text-xs"></i> 
                        <span>الرقم العسكري للضابط</span>
                    </label>
                    <input type="text" wire:model.defer="search_id" placeholder="0000000"
                           class="w-full bg-[#070B14] border border-[#1e293b] focus:border-blue-500/50 rounded-xl text-sm px-5 py-3.5 text-white focus:ring-4 focus:ring-blue-500/10 focus:outline-none text-right font-mono tracking-wide placeholder:text-gray-600">
                </div>

                <div class="w-full md:w-auto flex-none">
                    <button type="submit" wire:loading.attr="disabled"
                            class="w-full md:w-auto bg-blue-600 hover:bg-blue-500 disabled:opacity-60 disabled:pointer-events-none px-6 rounded-xl text-sm font-bold text-white transition-all active:scale-[0.98] flex items-center justify-center shadow-lg shadow-blue-950/40 border border-blue-500/20 min-w-[130px] h-[50px] whitespace-nowrap">
                        
                        <span wire:loading.remove wire:target="search" class="flex items-center gap-2">
                            <i class="fas fa-search text-base text-blue-100"></i>
                            <span>استعلام القيادة</span>
                        </span>
                        
                        <span wire:loading wire:target="search" class="flex items-center gap-2">
                            <i class="fas fa-circle-notch fa-spin text-base text-blue-100"></i>
                            <span>جاري الفحص...</span>
                        </span>
                    </button>
                </div>

            </div>
        </form>
    </div>

    {{-- ===== لوحة نتيجة الاستعلام وعرض ملف الضابط ===== --}}
    @if($officer)
    <div class="bg-[#0f1626]/40 backdrop-blur-md border border-[#1e293b] rounded-xl p-6 space-y-8 shadow-2xl">

        {{-- رأس القسم --}}
        <div class="flex items-center justify-between border-b border-[#1e293b] pb-4">
            <h2 class="text-[#3b82f6] text-sm font-bold flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="tracking-wide">ملف قيد الضابط المستعلم عنه رسمياً</span>
            </h2>
            <span class="text-[11px] px-2.5 py-1 rounded-md bg-[#2563EB]/10 text-blue-400 border border-[#2563EB]/20 font-bold">جناح القيادة والضباط</span>
        </div>

        {{-- شبكة العرض المعمارية المتزنة (3 أعمدة للشاشات الكبيرة) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

            {{-- ── العمود الأول: الصورة والرقم العسكري وأوامر العمليات ── --}}
            <div class="flex flex-col items-center gap-4 text-center bg-[#070B14]/40 border border-[#1e293b] p-5 rounded-2xl">

                {{-- الأفاتار العسكري --}}
                <div class="relative">
                    <div class="w-32 h-40 rounded-xl bg-[#0a0f1d] border border-[#1e293b] overflow-hidden shadow-2xl">
                        @if($officer->avatar && file_exists(storage_path('app/public/' . $officer->avatar)))
                            <img src="{{ asset('storage/' . $officer->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <div class="h-full flex flex-col items-center justify-center text-gray-700 bg-[#070B14]">
                                <i class="fas fa-user-shield text-4xl mb-2 text-gray-600"></i>
                                <span class="text-[9px] text-gray-500">لا توجد صورة رسمية</span>
                            </div>
                        @endif
                    </div>
                    <div class="absolute -bottom-2 -right-2 bg-emerald-600 p-1.5 rounded-full border-4 border-[#070B14] shadow-lg">
                        <i class="fas fa-shield-alt text-[10px] text-white"></i>
                    </div>
                </div>

                {{-- الهوية والرمز الرقمي --}}
                <div class="w-full bg-[#0a0f1d] border border-[#1e293b] rounded-xl py-3 px-4">
                    <p class="text-[10px] text-gray-500 mb-1">الرقم العسكري الموحد</p>
                    <p class="text-[#3b82f6] font-mono font-bold text-xl tracking-widest">{{ $officer->military_id }}</p>
                </div>

                {{-- الأزرار والتحكم التفاعلي بقيد الضابط --}}
                <div class="w-full space-y-2">
                    <button
                        wire:click="$dispatch('open-edit-modal', { id: {{ $officer->id }} })"
                        class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white py-2.5 rounded-lg text-xs font-bold transition border border-blue-500/40 shadow-lg shadow-blue-950/20">
                        <i class="fas fa-user-edit text-[11px]"></i> تعديل السجل العسكري
                    </button>
                    <button class="w-full flex items-center justify-center gap-2 bg-[#1e293b] hover:bg-[#334155] text-gray-300 py-2.5 rounded-lg text-xs font-semibold transition border border-gray-700">
                        <i class="fas fa-print text-[11px]"></i> تصدير الأمر والبيان
                    </button>
                </div>

                {{-- تضمين مودال التعديل الفوري الخاص بالضباط ليعمل خلف الكواليس --}}
                <livewire:officer.officer-edit />
            </div>

            {{-- ── العمود الثاني: السجل الميداني والبيانات العسكرية الأساسية ── --}}
            <div class="space-y-3">
                @php
                    $infoItems = [
                        ['label' => 'الاسم الكامل للضابط',  'value' => $officer->full_name, 'icon' => 'user-shield'],
                        ['label' => 'الرتبة القيادية',       'value' => $officer->rank, 'icon' => 'crown'],
                        ['label' => 'التخصص الأساسي',      'value' => $officer->specialty ?? 'بحري قيادي', 'icon' => 'anchor'],
                        ['label' => 'التخصص الفرعي',       'value' => $officer->sub_specialty ?? 'إدارة عمليات بحرية', 'icon' => 'layer-group'],
                        // ⚓ إضافة ساعات الإبحار هنا لإعطائها ثقل قيادي متميز في الواجهة
                        ['label' => 'ساعات الإبحار والقيادة', 'value' => ($officer->sailing_hours ?? 0) . ' ساعة', 'icon' => 'clock', 'mono' => true],
                        ['label' => 'الحالة القيادية الحالية', 'value' => $officer->status ?? 'نشط', 'icon' => 'toggle-on'],
                    ];
                @endphp

                @foreach($infoItems as $item)
                <div class="group flex items-center justify-between bg-[#070B14]/80 border border-[#1e293b] hover:border-blue-500/40 px-5 py-4 rounded-xl transition-all duration-200 hover:bg-[#0a1020] cursor-default min-h-[64px]">
                    
                    <span class="text-xs md:text-sm text-gray-400 flex items-center gap-3 group-hover:text-gray-300 transition-colors select-none">
                        <span class="shadow-inner" style="width:32px; height:32px; min-width:32px; border-radius:10px; background:#0f1626; border:1px solid #1e293b; display:inline-flex; align-items:center; justify-content:center;">
                            <i class="fas fa-{{ $item['icon'] }}" style="font-size:13px; color:#2563EB;"></i>
                        </span>
                        <span class="font-medium tracking-wide">{{ $item['label'] }}</span>
                    </span>
                    
                    <span class="inline-flex items-center justify-center bg-[#070B14] border border-[#1e293b] group-hover:border-blue-500/30 text-sm font-bold {{ isset($item['mono']) ? 'text-emerald-400 font-mono' : 'text-white' }} px-4 py-1.5 rounded-lg min-w-[140px] text-center tracking-wide transition-colors">
                        {{ $item['value'] }}
                    </span>

                </div>
                @endforeach
            </div>

            {{-- ── العمود الثالث: التواريخ ومحاضر الترقيات الرسمية ── --}}
            <div class="space-y-3">
                @php
                    $dates = [
                        ['label' => 'تاريخ التعيين والالتحاق', 'date' => $officer->appointment_date, 'icon' => 'calendar-check'],
                        ['label' => 'تاريخ التثبيت في الرتبة',  'date' => $officer->confirmation_date, 'icon' => 'award'],
                        ['label' => 'تاريخ الترقية الحالية',    'date' => $officer->current_promotion_date, 'icon' => 'chevron-double-up'],
                    ];
                @endphp

                @foreach($dates as $item)
                    <div class="group flex items-center justify-between bg-[#070B14]/60 border border-[#1e293b] p-4 rounded-xl hover:border-[#3b82f6]/50 hover:bg-[#0f1626] transition-all duration-200">
                        <div class="flex items-center gap-3">
                            <span style="width:28px; height:28px; min-width:28px; border-radius:8px; background:#0f1626; border:1px solid #1e293b; display:inline-flex; align-items:center; justify-content:center;">
                                <i class="fas fa-{{ $item['icon'] }}" style="font-size:12px; color:#2563EB; width:12px; height:12px; display:block; text-align:center; line-height:12px;"></i>
                            </span>
                            <span class="text-xs text-gray-400 group-hover:text-gray-300 transition-colors">{{ $item['label'] }}</span>
                        </div>
                        <span class="text-[11px] font-mono font-bold text-blue-400 bg-blue-900/20 px-3 py-1.5 rounded-lg border border-blue-900/30">
                            {{ $item['date'] ? \Carbon\Carbon::parse($item['date'])->format('Y-m-d') : '---' }}
                        </span>
                    </div>
                @endforeach

                {{-- صندوق الملاحظات العسكرية الملحق بالتواريخ لملء الفراغ بشكل متزن --}}
                <div class="bg-[#070B14]/40 border border-[#1e293b] p-4 rounded-xl space-y-2">
                    <span class="text-xs font-bold text-gray-400 block mb-1">ملاحظات القيادة العليا:</span>
                    <p class="text-xs text-gray-500 leading-relaxed bg-[#070B14] p-3 rounded-lg border border-[#1e293b]/60 min-h-[75px]">
                        {{ $officer->notes ?? 'لا توجد ملاحظات أو عقوبات عسكرية مسجلة على سجل الضابط الميداني.' }}
                    </p>
                </div>
            </div>

        </div>
        {{-- نهاية شبكة العرض الثلاثية --}}

        {{-- ===== قسم الدورات العسكرية المقررة للضباط ===== --}}
        <div class="space-y-5 pt-6 border-t border-[#1e293b]">
            <h3 class="text-xs font-bold text-gray-400 flex items-center gap-2 tracking-wide">
                <div class="p-1 rounded bg-[#3b82f6]/10 text-[#3b82f6]">
                    <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                    </svg>
                </div>
                <span>بيان الدورات العليا والشهادات الحاصل عليها الضابط</span>
            </h3>

            @if($officer->courses && $officer->courses->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    @foreach($officer->courses as $course)
                        <div class="bg-[#070B14]/60 border border-[#1e293b] p-4 rounded-xl space-y-3.5 text-center hover:border-[#3b82f6]/40 hover:-translate-y-1 transition-all duration-300 shadow-md group/item">
                            <span class="text-xs font-bold text-[#3b82f6] block border-b border-[#1e293b] pb-2 truncate">{{ $course->name }}</span>
                            <div class="text-[10px] text-gray-400 space-y-2 font-mono">
                                <div class="flex justify-between flex-row-reverse">
                                    <span class="font-sans text-gray-500">تاريخ الانعقاد</span>
                                    <span class="text-gray-300 font-bold">
                                        {{ $course->start_date ? \Carbon\Carbon::parse($course->start_date)->format('Y-m-d') : '---' }}
                                    </span>
                                </div>
                                <div class="flex justify-between flex-row-reverse">
                                    <span class="font-sans text-gray-500">منفذ الدورة</span>
                                    <span class="truncate max-w-[90px] text-gray-300 font-semibold">{{ $course->conducting_entity ?? '---' }}</span>
                                </div>
                              
                            </div>
                            <div class="pt-1">
                                <span class="inline-flex items-center gap-1 text-[9px] text-emerald-400 bg-emerald-500/5 border border-emerald-500/10 px-2.5 py-0.5 rounded-full font-medium">
                                    <span class="w-1 h-1 rounded-full bg-emerald-500"></span> براءة معتمدة
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- لوحة التنبيه عند خلو ملف الضابط من الدورات --}}
                <div class="flex flex-col items-center justify-center p-8 bg-[#070B14]/40 border border-dashed border-[#1e293b] rounded-xl text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-500">
                        <i class="fas fa-graduation-cap text-lg"></i>
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm font-bold text-gray-300">لا يوجد دورات مسجلة بملف الضابط</p>
                        <p class="text-xs text-blue-400 font-semibold max-w-md mx-auto">
                            " سيادة الضابط: {{ $officer->full_name }} "
                        </p>
                        <p class="text-[11px] text-gray-500">لم يتم رصد أو ربط أي شهادات تدريبية أو دورات قيادية عليا بهذا الملف حتى تاريخه.</p>
                    </div>
                </div>
            @endif
        </div>

    </div>
    @endif

</div>