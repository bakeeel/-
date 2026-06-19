<div class="space-y-6 font-cairo text-right" dir="rtl">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between border-b border-[#1F2937] pb-5 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-[#E5E7EB] tracking-wide">مركز التقارير الاستراتيجية // الجاهزية العامة</h1>
            <p class="text-sm text-gray-400 mt-1">توليد كشف حساب للافراد/الضباط/المتدربين المسجلين في الدورات</p>
        </div>
        
        <div class="flex items-center gap-2">
            <button wire:click="exportExcel" wire:loading.attr="disabled" class="bg-[#111827] border border-[#1F2937] text-gray-300 hover:text-white hover:bg-gray-800 px-4 py-2 rounded-xl text-sm font-medium transition flex items-center gap-2 disabled:opacity-50">
                <span wire:loading.remove wire:target="exportExcel">تصدير Excel</span>
                <span wire:loading wire:target="exportExcel" class="text-xs text-gray-400">جاري التصدير...</span>
            </button>

            <button wire:click="refreshData" wire:loading.attr="disabled" class="bg-[#2563EB] hover:bg-[#1d4ed8] text-white px-4 py-2 rounded-xl text-sm font-medium transition flex items-center gap-2 shadow-lg shadow-[#2563EB]/20 disabled:opacity-50">
                <span>التحديث الفوري</span>
            </button>
        </div>
    </div>

    {{-- منطقة الفلاتر والتصفية السنوية والربع سنوية --}}
    <div class="bg-[#111827] border border-[#1F2937] rounded-xl p-4 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <label class="block text-xs font-semibold text-gray-400 mb-1.5">نوع التقرير التشغيلي</label>
            <select wire:model.live="report_type" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-[#2563EB]">
                <option value="officer_readiness">⭐ كشف الضباط</option>
                <option value="personnel_readiness">🎖️ كشف الأفراد</option>
                <option value="personnel_core_courses">📕 تقرير الدورات الأساسية (للأفراد)</option>
                <option value="trainee_readiness">🎓 كشف المتدربين</option> 
                <option value="trainee_core_courses">📘 تقرير الدورات الأساسية (للمتدربين)</option> 
            </select>
        </div>
        <div>
            <label class="block text-xs font-semibold text-gray-400 mb-1.5">الفترة الزمنية للتقرير (1447 هـ)</label>
            <select wire:model.live="time_period" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg px-3 py-2 text-xs text-white focus:outline-none focus:border-[#2563EB]">
                <option value="full_year">تقرير سنوي شامل</option>
                <option value="q1">الربع السنوي الأول (محرم - صفر - ربيع أول)</option>
                <option value="q2">الربع السنوي الثاني (ربيع ثاني - جمادى أولى - جمادى آخرة)</option>
                <option value="q3">الربع السنوي الثالث (رجب - شعبان - رمضان)</option>
                <option value="q4">الربع السنوي الرابع والأخير (شوال - ذو القعدة - ذو الحجة)</option>
                <option value="half_year">النصف الأول من العام</option>
            </select>
        </div>
        <div class="flex items-end">
            <button wire:click="calculateReportData" wire:loading.attr="disabled" class="w-full bg-gray-800 hover:bg-gray-700 text-white text-xs font-medium py-2 rounded-lg border border-[#1F2937] transition flex items-center justify-center gap-2">
                <span>تطبيق الفلترة والتصفية</span>
            </button>
        </div>
    </div>

    {{-- جدول عرض البيانات المفلترة --}}
    <div class="bg-[#111827] border border-[#1F2937] rounded-xl shadow-2xl overflow-hidden">
        <div class="p-4 border-b border-[#1F2937] bg-[#111827]/50 flex justify-between items-center">
            <h3 class="text-sm font-bold text-[#E5E7EB]">
                تقرير رصد موقف الحقائب والدورات الأساسية الإلزامية
            </h3>
            <span class="text-[10px] bg-[#070B14] text-gray-400 border border-[#1F2937] px-2 py-0.5 rounded font-mono">
                ROW COUNT: {{ count($table_data) }}
            </span>
        </div>
        
        <div class="overflow-x-auto relative">
            <table class="w-full text-right text-xs text-gray-300 min-w-max border-collapse">
                <thead>
                    <tr class="text-gray-400 border-b border-[#1F2937] uppercase bg-[#070B14]/70">
                        <th class="p-3 sticky right-0 bg-[#111827] z-30 min-w-[220px] shadow-[calc(-1*1px)_0_0_0_#1F2937]">
                            رتبة واسم الفرد
                        </th>
                        <th class="p-3 min-w-[90px]">الحالة</th>

                        @if(!empty($active_courses_list))
                            @foreach($active_courses_list as $courseName)
                                <th class="p-3 text-center border-x border-[#1F2937]/40 bg-[#070B14]/40 font-bold min-w-[120px] text-[#2563EB]">
                                    {{ $courseName }}
                                </th>
                            @endforeach
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1F2937]">
                    @forelse($table_data as $row)
                        <tr class="hover:bg-gray-800/30 transition group">
                            <td class="p-3 font-medium text-white sticky right-0 bg-[#111827] group-hover:bg-[#1C2434] transition z-20 shadow-[calc(-1*1px)_0_0_0_#1F2937]">
                                {{ $row['title'] }}
                            </td>
                            <td class="p-3">
                                <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-0.5 rounded text-[10px] inline-flex items-center gap-1">
                                    <span class="w-1 h-1 rounded-full bg-emerald-400 animate-pulse"></span>
                                    {{ $row['status_badge'] }}
                                </span>
                            </td>

                            @if(isset($row['course_checks']))
                                @foreach($row['course_checks'] as $checkStatus)
                                    <td class="p-3 text-center font-bold text-base border-x border-[#1F2937]/20 {{ $checkStatus === '✔' ? 'text-emerald-400 bg-emerald-500/5' : 'text-gray-600' }}">
                                        {{ $checkStatus }}
                                    </td>
                                @endforeach
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ !empty($active_courses_list) ? (2 + count($active_courses_list)) : 2 }}" class="p-8 text-center text-gray-500 font-mono">
                                NO RECORD FILES FOUND IN DATABASE FOR THIS TIMEFRAME
                            </td>
                        </tr>
                    @endempty
                </tbody>
            </table>
        </div>
    </div>
</div>