<div class="space-y-6 font-cairo text-right p-4 md:p-6 bg-[#070B14] min-h-screen text-gray-200" dir="rtl">

    {{-- ===== قسم البحث ===== --}}
    <div class="bg-[#0f1626]/60 backdrop-blur-md border border-[#1e293b] rounded-xl p-6 shadow-xl">

        <h2 class="text-[#3b82f6] text-sm font-bold mb-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-lg bg-[#3b82f6]/10 flex items-center justify-center">
                    <i class="fas fa-search text-sm"></i>
                </div>
                <span class="tracking-wide">المنظومة الذكية للاستعلام العسكري</span>
            </div>
            <span class="text-xs bg-[#1e293b] text-gray-400 px-2.5 py-1 rounded-md border border-[#334155]">البحث الموحد</span>
        </h2>

        <form wire:submit.prevent="search" class="w-full bg-[#0f1626] p-5 rounded-xl border border-[#1e293b] font-cairo shadow-xl" dir="rtl">
            
            {{-- خيار تحديد نوع البحث (ضابط / فرد / متدرب) --}}
            <div class="flex items-center gap-6 mb-6 pb-4 border-b border-[#1e293b]/60">
                <span class="text-xs font-bold text-gray-400 select-none">فئة المستعلم عنه:</span>
                
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-2.5 cursor-pointer group select-none">
                        <input type="radio" wire:model="search_type" value="personnel" 
                               class="w-4 h-4 text-blue-600 bg-[#070B14] border-[#1e293b] focus:ring-blue-500/20 focus:ring-2">
                        <span class="text-xs font-semibold text-gray-300 group-hover:text-blue-400 transition-colors">أفراد </span>
                    </label>

                    <label class="flex items-center gap-2.5 cursor-pointer group select-none">
                        <input type="radio" wire:model="search_type" value="officer" 
                               class="w-4 h-4 text-amber-500 bg-[#070B14] border-[#1e293b] focus:ring-amber-500/20 focus:ring-2">
                        <span class="text-xs font-semibold text-gray-300 group-hover:text-amber-400 transition-colors">ضباط</span>
                    </label>

                    <label class="flex items-center gap-2.5 cursor-pointer group select-none">
                        <input type="radio" wire:model="search_type" value="trainee" 
                               class="w-4 h-4 text-emerald-500 bg-[#070B14] border-[#1e293b] focus:ring-emerald-500/20 focus:ring-2">
                        <span class="text-xs font-semibold text-gray-300 group-hover:text-emerald-400 transition-colors">متدربين</span>
                    </label>
                </div>
            </div>
            
            <div class="flex flex-col md:flex-row items-end gap-4 w-full">
                
                <div class="space-y-2 w-full md:flex-1">
                    <label class="text-xs font-bold text-gray-400 flex items-center gap-2 px-1 select-none">
                        <i class="fas fa-user @if($search_type === 'officer') text-amber-500 @elseif($search_type === 'trainee') text-emerald-500 @else text-blue-500 @endif w-4 text-center text-xs"></i> 
                        <span>الاسم الكامل</span>
                    </label>
                    <input type="text" 
                        wire:model.defer="search_name" 
                        dir="rtl"
                        placeholder="@if($search_type === 'officer') أدخل اسم الضابط... @elseif($search_type === 'trainee') أدخل اسم المتدرب... @else أدخل اسم الفرد... @endif"
                        class="w-full bg-[#070B14] border border-[#1e293b] @if($search_type === 'officer') focus:border-amber-500/50 focus:ring-amber-500/10 @elseif($search_type === 'trainee') focus:border-emerald-500/50 focus:ring-emerald-500/10 @else focus:border-blue-500/50 focus:ring-blue-500/10 @endif rounded-xl text-xs px-3 py-2.5 text-white focus:ring-4 focus:outline-none text-right placeholder:text-gray-600 tracking-wide overflow-ellipsis">
                </div>

                <div class="space-y-2 w-full md:flex-1">
                    <label class="text-xs font-bold text-gray-400 flex items-center gap-2 px-1 select-none">
                        <i class="fas fa-id-card @if($search_type === 'officer') text-amber-500 @elseif($search_type === 'trainee') text-emerald-500 @else text-blue-500 @endif w-4 text-center text-xs"></i> 
                        <span>الرقم العسكري  </span>
                    </label>
                    <input type="text" wire:model.defer="search_id" placeholder="0000000"
                        class="w-full bg-[#070B14] border border-[#1e293b] @if($search_type === 'officer') focus:border-amber-500/50 focus:ring-amber-500/10 @elseif($search_type === 'trainee') focus:border-emerald-500/50 focus:ring-emerald-500/10 @else focus:border-blue-500/50 focus:ring-blue-500/10 @endif rounded-xl text-xs px-4 py-2.5 text-white focus:ring-4 focus:outline-none text-right font-mono tracking-wide placeholder:text-gray-600">
                </div>

                <div class="space-y-2 w-full md:flex-1">
                    <label class="text-xs font-bold text-gray-400 flex items-center gap-2 px-1 select-none">
                        <i class="fas fa-phone @if($search_type === 'officer') text-amber-500 @elseif($search_type === 'trainee') text-emerald-500 @else text-blue-500 @endif w-4 text-center text-xs"></i> 
                        <span>رقم الهاتف</span>
                    </label>
                    <input 
                    type="tel" 
                    maxlength="10"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                    wire:model.defer="search_phone" placeholder="05xxxxxxxx"
                        class="w-full bg-[#070B14] border border-[#1e293b] @if($search_type === 'officer') focus:border-amber-500/50 focus:ring-amber-500/10 @elseif($search_type === 'trainee') focus:border-emerald-500/50 focus:ring-emerald-500/10 @else focus:border-blue-500/50 focus:ring-blue-500/10 @endif rounded-xl text-xs px-4 py-2.5 text-white focus:ring-4 focus:outline-none text-right font-mono tracking-wide placeholder:text-gray-600">
                </div>

                <div class="w-full md:w-auto flex-none">
                    <button type="submit" wire:loading.attr="disabled"
                            class="w-full md:w-auto @if($search_type === 'officer') bg-amber-600 hover:bg-amber-500 shadow-amber-950/40 border-amber-500/20 @elseif($search_type === 'trainee') bg-emerald-600 hover:bg-emerald-500 shadow-emerald-950/40 border-emerald-500/20 @else bg-blue-600 hover:bg-blue-500 shadow-blue-950/40 border-blue-500/20 @endif disabled:opacity-60 disabled:pointer-events-none px-6 rounded-xl text-xs font-bold text-white transition-all active:scale-[0.98] flex items-center justify-center shadow-lg border min-w-[120px] h-[40px] whitespace-nowrap">
                        
                        <span wire:loading.remove wire:target="search" class="flex items-center gap-2">
                            <i class="fas fa-search text-sm text-gray-100"></i>
                            <span>بحث</span>
                        </span>
                        
                        <span wire:loading wire:target="search" class="flex items-center gap-2">
                            <i class="fas fa-circle-notch fa-spin text-sm text-gray-100"></i>
                            <span>جاري...</span>
                        </span>
                    </button>
                </div>

            </div>
        </form>
    </div>

    {{-- ===== نتيجة البحث ===== --}}
    @if($resultDataArray)
    <div class="bg-[#0f1626]/40 backdrop-blur-md border border-[#1e293b] rounded-xl p-6 space-y-8 shadow-2xl">

        {{-- رأس القسم --}}
        <div class="flex items-center justify-between border-b border-[#1e293b] pb-4">
            <h2 class="@if($search_type === 'officer') text-amber-500 @elseif($search_type === 'trainee') text-emerald-500 @else text-blue-500 @endif text-sm font-bold flex items-center gap-2">
                <span class="w-2 h-2 rounded-full @if($search_type === 'officer') bg-amber-500 @elseif($search_type === 'trainee') bg-emerald-500 @else bg-blue-500 @endif animate-pulse"></span>
                <span>ملف بيانات @if($search_type === 'officer') الضابط @elseif($search_type === 'trainee') المتدرب @else الفرد @endif المستعلم عنه</span>
            </h2>
            <span class="text-[11px] px-2.5 py-1 rounded-md bg-[#1e293b]/60 text-gray-400 border border-[#1e293b]/40">نظام التدريب الشامل</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

            {{-- ── العمود الأول: الصورة والرقم والأزرار ── --}}
            <div class="flex flex-col items-center gap-4 text-center bg-[#070B14]/40 border border-[#1e293b] p-5 rounded-2xl">

                {{-- الصورة الشخصية للمستعلم عنه --}}
                <div class="relative">
                    <div class="w-32 h-40 rounded-xl bg-[#0a0f1d] border border-[#1e293b] overflow-hidden shadow-2xl">
                        @if(($resultDataArray['avatar'] ?? null) && file_exists(storage_path('app/public/' . $resultDataArray['avatar'])))
                            <img src="{{ asset('storage/' . $resultDataArray['avatar']) }}" class="w-full h-full object-cover">
                        @else
                            <div class="h-full flex flex-col items-center justify-center text-gray-700">
                                <i class="fas @if($search_type === 'officer') fa-user-tie text-amber-600/30 @elseif($search_type === 'trainee') fa-user-graduate text-emerald-600/30 @else fa-user-circle text-blue-600/30 @endif text-5xl mb-2"></i>
                                <span class="text-[9px]">لا توجد صورة</span>
                            </div>
                        @endif
                    </div>
                    <div class="absolute -bottom-2 -right-2 @if($search_type === 'officer') bg-amber-600 @elseif($search_type === 'trainee') bg-emerald-600 @else bg-blue-600 @endif p-1.5 rounded-full border-4 border-[#070B14]">
                        <i class="fas fa-check text-[10px] text-white"></i>
                    </div>
                </div>

                {{-- الرقم العسكري أو الهوية بارز --}}
                <div class="w-full bg-[#0a0f1d] border border-[#1e293b] rounded-xl py-3 px-4">
                    <p class="text-[10px] text-gray-500 mb-1">الرقم العسكري </p>
                    <p class="@if($search_type === 'officer') text-amber-500 @elseif($search_type === 'trainee') text-emerald-500 @else text-[#3b82f6] @endif font-mono font-bold text-xl tracking-widest">
                        {{ $resultDataArray['military_id'] ?? $resultDataArray['identity_number'] ?? '---' }}
                    </p>
                </div>

                {{-- الأزرار ووحدة التعديل --}}
                <div class="w-full space-y-2">
                    <button type="button"
                        wire:click="$dispatch('open-edit-modal', { id: {{ $resultDataArray['id'] }}, type: '{{ $search_type }}' })"
                        class="w-full flex items-center justify-center gap-2 @if($search_type === 'officer') bg-amber-600 hover:bg-amber-500 border-amber-500/40 @elseif($search_type === 'trainee') bg-emerald-600 hover:bg-emerald-500 border-emerald-500/40 @else bg-blue-600 hover:bg-blue-500 border-blue-500/40 @endif text-white py-2.5 rounded-lg text-xs font-bold transition border">
                        <i class="fas fa-pen text-[11px]"></i> تعديل البيانات
                    </button>
                    <button class="w-full flex items-center justify-center gap-2 bg-[#1e293b] hover:bg-[#334155] text-gray-300 py-2.5 rounded-lg text-xs font-semibold transition border border-gray-700">
                        <i class="fas fa-print text-[11px]"></i> طباعة / تصدير
                    </button>
                </div>

                {{-- التوجيه للمكونات الفرعية ديناميكياً --}}
                <div class="w-full block mt-4">
                    @if($search_type === 'officer')
                        <div>
                            <livewire:officer.officer-edit :officerId="$resultDataArray['id']" :wire:key="'officer-edit-'.$resultDataArray['id']" />
                        </div>
                    @elseif($search_type === 'trainee')
                        <div>
                            <livewire:trainee.Trainee-edit :traineeId="$resultDataArray['id']" :wire:key="'trainee-edit-'.$resultDataArray['id']" />
                        </div>
                    @else
                        <div>
                            <livewire:personnel.personnel-edit :personnelId="$resultDataArray['id']" :wire:key="'personnel-edit-'.$resultDataArray['id']" />
                        </div>
                    @endif
                </div>
            </div>

           {{-- ── العمود الثاني: البيانات الأساسية الديناميكية ── --}}
<div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-3 items-start">
    
    {{-- القسم الأيسر --}}
    <div class="space-y-3">
        @php
            if($search_type === 'officer') {
                $infoItemsLeft = [
                    ['label' => 'الاسم الكامل',       'value' => $resultDataArray['full_name'] ?? '---', 'icon' => 'user-tie'],
                    ['label' => 'أيام الإبحار',      'value' => ($resultDataArray['sailing_days'] ?? 0) . ' أيام', 'icon' => 'ship'],
                    ['label' => 'التخصص الرئيسي',    'value' => $resultDataArray['specialty'] ?? 'غير محدد', 'icon' => 'graduation-cap'],
                    ['label' => 'رقم الهاتف',        'value' => $resultDataArray['phone'] ?? '---', 'icon' => 'mobile-alt'],
                ];
            } elseif($search_type === 'trainee') {
                $years = $resultDataArray['service_years'] ?? 0;
                $months = $resultDataArray['service_months'] ?? 0;
                $yearsStr = $years > 0 ? $years . ' سنة' : '';
                $monthsStr = $months > 0 ? $months . ' شهر' : '';
                $serviceDuration = trim($yearsStr . ' و ' . $monthsStr, ' و ');
                if (empty($serviceDuration)) { $serviceDuration = 'أقل من شهر'; }

                $infoItemsLeft = [
                    ['label' => 'الاسم الكامل',       'value' => $resultDataArray['full_name'] ?? $resultDataArray['name'] ?? '---', 'icon' => 'user-graduate'],
                    ['label' => 'سنوات وأشهر الخدمة', 'value' => $serviceDuration, 'icon' => 'history'],
                    ['label' => 'حالة التدريب',       'value' => $resultDataArray['status'] ?? 'مستمر', 'icon' => 'check-circle'],
                ];
            } else {
                $infoItemsLeft = [
                    ['label' => 'الاسم الكامل',       'value' => $resultDataArray['full_name'] ?? $resultDataArray['name'] ?? '---', 'icon' => 'user'],
                    ['label' => 'رقم الهاتف',        'value' => $resultDataArray['phone'] ?? '---', 'icon' => 'phone'],
                    ['label' => 'التخصص الرئيسي',    'value' => $resultDataArray['primary_specialty'] ?? 'عمومي / ميدان', 'icon' => 'cogs'],
                    ['label' => 'التخصص الفرعي',     'value' => $resultDataArray['sub_specialty'] ?? 'إسناد عسكري', 'icon' => 'layer-group'],
                ];
            }
        @endphp

        @foreach($infoItemsLeft as $item)
            <div class="group flex items-center justify-between bg-[#070B14]/80 border border-[#1e293b] @if($search_type === 'officer') hover:border-amber-500/40 @elseif($search_type === 'trainee') hover:border-emerald-500/40 @else hover:border-blue-500/40 @endif px-4 py-3 rounded-xl transition-all duration-200 hover:bg-[#0a1020] cursor-default min-h-[58px]">
                <span class="text-xs text-gray-400 flex items-center gap-3 group-hover:text-gray-300 transition-colors select-none">
                    <span class="shadow-inner" style="width:32px; height:32px; min-width:32px; border-radius:10px; background:#0f1626; border:1px solid #1e293b; display:inline-flex; align-items:center; justify-content:center;">
                        <i class="fas fa-{{ $item['icon'] }}" style="font-size:13px; color:@if($search_type === 'officer') #D97706 @elseif($search_type === 'trainee') #10B981 @else #2563EB @endif;"></i>
                    </span>
                    <span class="font-medium tracking-wide text-xs">{{ $item['label'] }}</span>
                </span>
                
                {{-- 🟢 تم تعديل وحجم خط القيمة هنا ليصبح أصغر text-[11px] ومرن بدون عرض ثابت ينقص الكلمات --}}
                <span class="inline-flex items-center justify-center bg-[#070B14] border border-[#1e293b] @if($search_type === 'officer') group-hover:border-amber-500/30 @elseif($search_type === 'trainee') group-hover:border-emerald-500/30 @else group-hover:border-blue-500/30 @endif text-[11px] font-bold text-white px-2.5 py-1.5 rounded-lg max-w-[180px] break-words text-center transition-colors leading-relaxed">
                    {{ $item['value'] }}
                </span>
            </div>
        @endforeach
    </div>

    {{-- القسم الأيمن --}}
    <div class="space-y-3">
        @php
            if($search_type === 'officer') {
                $infoItemsRight = [
                    ['label' => 'الرتبة العسكرية',    'value' => $resultDataArray['rank'] ?? '---',      'icon' => 'star'],
                    ['label' => 'ساعات الإبحار',      'value' => ($resultDataArray['sailing_hours'] ?? 0) . ' ساعة', 'icon' => 'ship'],
                    ['label' => 'الحالة العسكرية',    'value' => $resultDataArray['status'] ?? 'نشط', 'icon' => 'info-circle'],
                ];
            } elseif($search_type === 'trainee') {
                $infoItemsRight = [
                    ['label' => 'الدرجة / الرتبة',     'value' => $resultDataArray['rank'] ?? 'متدرب مستجد', 'icon' => 'award'],
                    ['label' => 'رقم الهاتف',        'value' => $resultDataArray['phone'] ?? '---', 'icon' => 'phone'],
                ];
            } else {
                $infoItemsRight = [
                    ['label' => 'الرتبة',              'value' => $resultDataArray['rank'] ?? '---', 'icon' => 'award'],
                ];
            }
        @endphp

        @foreach($infoItemsRight as $item)
            <div class="group flex items-center justify-between bg-[#070B14]/80 border border-[#1e293b] @if($search_type === 'officer') hover:border-amber-500/40 @elseif($search_type === 'trainee') hover:border-emerald-500/40 @else hover:border-blue-500/40 @endif px-4 py-3 rounded-xl transition-all duration-200 hover:bg-[#0a1020] cursor-default min-h-[58px]">
                <span class="text-xs text-gray-400 flex items-center gap-3 group-hover:text-gray-300 transition-colors select-none">
                    <span class="shadow-inner" style="width:32px; height:32px; min-width:32px; border-radius:10px; background:#0f1626; border:1px solid #1e293b; display:inline-flex; align-items:center; justify-content:center;">
                        <i class="fas fa-{{ $item['icon'] }}" style="font-size:13px; color:@if($search_type === 'officer') #D97706 @elseif($search_type === 'trainee') #10B981 @else #2563EB @endif;"></i>
                    </span>
                    <span class="font-medium tracking-wide text-xs">{{ $item['label'] }}</span>
                </span>
                
                {{-- 🟢 تعديل الحجم هنا أيضاً ليصبح متناسقاً text-[11px] --}}
                <span class="inline-flex items-center justify-center bg-[#070B14] border border-[#1e293b] @if($search_type === 'officer') group-hover:border-amber-500/30 @elseif($search_type === 'trainee') group-hover:border-emerald-500/30 @else group-hover:border-blue-500/30 @endif text-[11px] font-bold text-white px-2.5 py-1.5 rounded-lg max-w-[180px] break-words text-center transition-colors leading-relaxed">
                    {{ $item['value'] }}
                </span>
            </div>
        @endforeach

        {{-- قسم التواريخ المطور --}}
        @php
            if($search_type === 'officer') {
                $dates = [
                    ['label' => 'تاريخ التعيين', 'date' => $resultDataArray['appointment_date'] ?? null, 'icon' => 'calendar-alt'],
                ];
            } elseif($search_type === 'trainee') {
                $dates = [
                    ['label' => 'تاريخ الالتحاق', 'date' => $resultDataArray['join_date'] ?? $resultDataArray['created_at'] ?? null, 'icon' => 'calendar-plus'],
                ];
            } else {
                $dates = [
                    ['label' => 'تاريخ التعيين',         'date' => $resultDataArray['appointment_date'] ?? null,       'icon' => 'calendar-alt'],
                    ['label' => 'تاريخ التثبيت',         'date' => $resultDataArray['confirmation_date'] ?? null,      'icon' => 'user-check'],
                    ['label' => 'تاريخ الترقية الحالية', 'date' => $resultDataArray['current_promotion_date'] ?? null, 'icon' => 'angle-double-up'],
                ];
            }
        @endphp

        @foreach($dates as $item)
            <div class="group flex items-center justify-between bg-[#070B14]/60 border border-[#1e293b] p-4 rounded-xl @if($search_type === 'officer') hover:border-amber-500/50 @elseif($search_type === 'trainee') hover:border-emerald-500/50 @else hover:border-blue-500/50 @endif hover:bg-[#0f1626] transition-all duration-200 min-h-[58px]">
                <div class="flex items-center gap-3">
                    <span style="width:28px; height:28px; min-width:28px; border-radius:8px; background:#0f1626; border:1px solid #1e293b; display:inline-flex; align-items:center; justify-content:center;">
                        <i class="fas fa-{{ $item['icon'] }}" style="font-size:12px; color:@if($search_type === 'officer') #D97706 @elseif($search_type === 'trainee') #10B981 @else #2563EB @endif; width:12px; height:12px; display:block; text-align:center; line-height:12px;"></i>
                    </span>
                    <span class="text-xs text-gray-400 group-hover:text-gray-300 transition-colors">{{ $item['label'] }}</span>
                </div>
                
                {{-- الخط للتواريخ تم الحفاظ عليه كـ text-[11px] مع الحفاظ على التنسيق الجميل المتناسق --}}
                <span class="text-[11px] font-mono font-bold @if($search_type === 'officer') text-amber-400 bg-amber-900/20 border-amber-900/30 @elseif($search_type === 'trainee') text-emerald-400 bg-emerald-900/20 border-emerald-900/30 @else text-blue-400 bg-blue-900/20 border-blue-900/30 @endif px-3 py-1.5 rounded-lg border">
                    {{ $item['date'] ? \Carbon\Carbon::parse($item['date'])->format('Y-m-d') : '---' }}
                </span>
            </div>
        @endforeach
    </div>

</div>
        </div>

        {{-- ===== قسم الدورات المطور كلياً UI/UX ===== --}}
        <div class="space-y-6 pt-6 border-t border-slate-800/80">
            
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-bold text-slate-400 flex items-center gap-2.5 tracking-wide">
                    <div class="p-1.5 rounded-lg bg-blue-500/10 text-blue-400 border border-blue-500/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                        </svg>
                    </div>
                    <span class="text-slate-300 font-bold">بيان الدورات العسكرية والشهادات الحاصل عليها 
                        <span class="font-black px-1.5 py-0.5 rounded
                            @if($search_type === 'officer') text-amber-400 bg-amber-500/5 @elseif($search_type === 'trainee') text-emerald-400 bg-emerald-500/5 @else text-blue-400 bg-blue-500/5 @endif">
                            @if($search_type === 'officer') الضابط @elseif($search_type === 'trainee') المتدرب @else الفرد @endif
                        </span>
                    </span>
                </h3>
                
                @if(!empty($resultDataArray['courses']) && count($resultDataArray['courses']) > 0)
                    <span class="text-[10px] font-mono bg-slate-950 font-bold text-slate-400 border border-slate-800 px-2 py-0.5 rounded-full">
                        مجموع السجلات: {{ count($resultDataArray['courses']) }}
                    </span>
                @endif
            </div>

            @if(!empty($resultDataArray['courses']) && count($resultDataArray['courses']) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                 @foreach($resultDataArray['courses'] as $course)
    @php
        // 1. تحديد درجات الألوان ديناميكياً بناءً على نوع البحث لتقليل تكرار الشروط في الـ DOM
        $themeClasses = [
            'officer' => [
                'hover_border' => 'hover:border-amber-500/30 hover:shadow-amber-500/[0.02]',
                'gradient'     => 'bg-gradient-to-r from-transparent via-amber-500/40 to-transparent',
                'text'         => 'text-amber-400'
            ],
            'trainee' => [
                'hover_border' => 'hover:border-emerald-500/30 hover:shadow-emerald-500/[0.02]',
                'gradient'     => 'bg-gradient-to-r from-transparent via-emerald-500/40 to-transparent',
                'text'         => 'text-emerald-400'
            ]
        ][$search_type] ?? [
            'hover_border' => 'hover:border-blue-500/30 hover:shadow-blue-500/[0.02]',
            'gradient'     => 'bg-gradient-to-r from-transparent via-blue-500/40 to-transparent',
            'text'         => 'text-blue-400'
        ];

        // 2. معالجة منطق الحالة الإدارية
        $status = $course['pivot']['status'] ?? 'مستمر في الدورة';
        $statusClass = 'text-blue-400 bg-blue-500/5 border-blue-500/10';
        
        if(str_contains($status, 'أكمل') || str_contains($status, 'ناجح')) {
            $statusClass = 'text-emerald-400 bg-emerald-500/5 border-emerald-500/10';
        } elseif(str_contains($status, 'إسقاط') || str_contains($status, 'ملغي')) {
            $statusClass = 'text-rose-400 bg-rose-500/5 border-rose-500/10';
        }
    @endphp

    <div class="relative overflow-hidden bg-slate-950/40 border border-slate-800/80 p-4 rounded-xl flex flex-col justify-between space-y-4 hover:-translate-y-1 transition-all duration-300 shadow-lg group/item {{ $themeClasses['hover_border'] }}">
        
        {{-- الخط العلوي المضيء عند الهوفر --}}
        <div class="absolute top-0 inset-x-0 h-[2px] transition-all duration-300 opacity-0 group-hover/item:opacity-100 {{ $themeClasses['gradient'] }}"></div>

        <div class="space-y-3">
            {{-- اسم الدورة --}}
            <div class="border-b border-slate-800/60 pb-2 text-right">
                <span class="text-xs font-black tracking-wide leading-relaxed block transition-colors duration-200 group-hover/item:text-white {{ $themeClasses['text'] }}">
                    {{ $course['name'] ?? '---' }}
                </span>
            </div>
            
            {{-- تفاصيل الدورة --}}
            <div class="text-[11px] space-y-2.5 font-sans">
                
                {{-- تاريخ البداية --}}
                <div class="flex justify-between items-center bg-slate-950/20 p-1.5 rounded border border-slate-900">
                    <span class="text-slate-500 flex items-center gap-1.5 text-[10px]">
                        <svg class="w-3 h-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        تاريخ البداية
                    </span>
                    <span class="text-slate-300 font-mono font-bold">
                        {{ ($course['pivot']['start_date'] ?? null) ? \Carbon\Carbon::parse($course['pivot']['start_date'])->format('Y-m-d') : '---' }}
                    </span>
                </div>

                {{-- تاريخ النهاية --}}
                <div class="flex justify-between items-center bg-slate-950/20 p-1.5 rounded border border-slate-900">
                    <span class="text-slate-500 flex items-center gap-1.5 text-[10px]">
                        <svg class="w-3 h-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        تاريخ النهاية
                    </span>
                    <span class="text-slate-300 font-mono font-bold">
                        {{ ($course['pivot']['end_date'] ?? null) ? \Carbon\Carbon::parse($course['pivot']['end_date'])->format('Y-m-d') : '---' }}
                    </span>
                </div>

                {{-- الجهة المنفذة --}}
                <div class="flex justify-between items-center bg-slate-950/20 p-1.5 rounded border border-slate-900">
                    <span class="text-slate-500 flex items-center gap-1.5 text-[10px]">
                        <svg class="w-3 h-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        الجهة المنفذة
                    </span>
                    <span class="text-slate-200 font-semibold max-w-[120px] truncate" title="{{ $course['pivot']['location'] ?? '---' }}">
                        {{ $course['pivot']['location'] ?? '---' }}
                    </span>
                </div>

            </div>
        </div>

        {{-- الحالة الإدارية الحالية للدورة --}}
        <div class="pt-2 border-t border-slate-900/60 flex justify-center">
            <span class="inline-flex items-center gap-1.5 text-[10px] {{ $statusClass }} border px-2 py-0.5 rounded-md font-medium select-none">
                <span class="w-1 h-1 rounded-full bg-current"></span>
                {{ $status }}
            </span>
        </div>

    </div>
@endforeach
                </div>
            @else
                {{-- تنبيه في حال عدم وجود دورات --}}
                <div class="border border-dashed border-slate-800 p-6 rounded-xl text-center">
                    <span class="text-xs text-slate-500 font-medium select-none">لا توجد دورات مسجلة في ملف هذا السجل العسكري حالياً.</span>
                </div>
            @endif
        </div>

    </div>
    @endif
</div>