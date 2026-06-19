<div class="space-y-6" x-data="{ confirmDelete: false, targetId: null }">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-[#1F2937] pb-5 gap-4 font-cairo" dir="rtl">
    
        {{-- الجانب الأيمن: العناوين والوصف --}}
        <div class="space-y-1">
            <h1 class="text-xl font-bold text-[#E5E7EB] tracking-wide">إدارة الأفراد</h1>
            <p class="text-xs text-gray-400">البحث، التعديل والتحكم بملفات القوة البشرية</p>
        </div>

        {{-- الجانب الأيسر: الأزرار في صف واحد متناسق --}}
        <div class="flex items-center gap-2.5 self-stretch sm:self-center">
            
            {{-- زر تصدير إكسيل --}}
           <button wire:click="exportToExcel" 
                class="flex-1 sm:flex-none border border-[#107C41]/30 bg-[#107C41]/10 hover:bg-[#107C41]/20 text-[#107C41] hover:text-[#15964f] px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all duration-200 flex items-center justify-center gap-2 group shadow-sm">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-y-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>تصدير Excel</span>
        </button>

            {{-- زر تسجيل فرد جديد --}}
            <a href="{{ route('personnel.create') }}" 
            class="flex-1 sm:flex-none bg-[#2563EB] hover:bg-[#1d4ed8] text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-[1.01] shadow-lg shadow-blue-900/10 flex items-center justify-center gap-2 group whitespace-nowrap">
                <svg class="w-4 h-4 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>تسجيل فرد جديد</span>
            </a>
            
        </div>
    </div>

    <div class="bg-[#0b1329]/30 border border-[#1e293b] p-5 rounded-xl grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="block text-xs font-medium text-gray-400 mb-1.5 font-cairo">البحث السريع</label>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="ابحث بالاسم أو الرقم العسكري..." class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] placeholder-gray-500 focus:outline-none focus:border-[#2563EB] font-cairo">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-400 mb-1.5 font-cairo">الفلترة حسب الرتبة</label>
            <select wire:model.live="rank" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:outline-none focus:border-[#2563EB] font-cairo">
                <option value="">كل الرتب</option>
                <option value="جندي">جندي</option>
                <option value="رقيب">رقيب</option>
                <option value="ملازم">ملازم</option>
                <option value="نقيب">نقيب</option>
                <option value="عميد">عميد</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-400 mb-1.5 font-cairo">حالة الفرد</label>
            <select wire:model.live="status" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:outline-none focus:border-[#2563EB] font-cairo">
                <option value="">كل الحالات</option>
                  <option value="نشط">نشط</option>
                        <option value="غياب">غياب</option>
                        <option value="إجازة">إجازة</option>
                        <option value="تأخير">تأخير</option>
                        <option value="إذن">إذن</option>
                        <option value="مسلم">مسلم</option>
            </select>
        </div>
        <!-- <div>
            <label class="block text-xs font-medium text-gray-400 mb-2 font-cairo">التخصص</label>
            <select wire:model.live="specialty" class="w-full bg-[#070B14] border border-[#1e293b] rounded-lg text-sm px-3 py-2.5 text-[#E5E7EB] focus:outline-none focus:border-blue-500 font-cairo">
                <option value="">جميع التخصصات</option>
                <option value="مدفعية">مدفعية</option>
                <option value="مشاة">مشاة</option>
                <option value="إشارة">إشارة</option>
                <option value="هندسة">هندسة</option>
                <option value="إمداد وتموين">إمداد وتموين</option>
                <option value="اتصالات">اتصالات</option>
            </select>
        </div> -->
    </div>
<div class="bg-[#0a0f1d] border border-[#1e293b] rounded-xl shadow-2xl">
    <div class="overflow-x-auto lg:overflow-visible rounded-xl">
        <table class="w-full text-right border-collapse table-fixed lg:table-auto text-[11px] sm:text-xs">
            <thead>
                <tr class="bg-[#070B14] border-b border-[#1e293b] font-bold text-gray-400 font-cairo uppercase tracking-wider text-[10px] sm:text-[11px]">
                    <th class="px-2 py-3.5 w-[9%]">الرقم العسكري</th>
                    <th class="px-2 py-3.5 w-[8%]">B/N</th>
                    <th class="px-3 py-3.5 w-[16%]">الاسم الكامل</th>
                    <th class="px-2 py-3.5 w-[10%]">الرتبة</th>
                    <th class="px-2 py-3.5 w-[11%]">التخصص</th>
                    <th class="px-2 py-3.5 w-[10%]">تاريخ التعيين</th>
                    <th class="px-2 py-3.5 w-[10%]">تاريخ التثبيت</th>
                    <th class="px-2 py-3.5 w-[8%]">مدة الخدمة</th>
                    <th class="px-2 py-3.5 w-[10%]">رقم التواصل</th>
                    <th class="px-2 py-3.5 text-center w-[8%]">الحالة</th>
                    <th class="px-2 py-3.5 text-center w-[6%]">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#1e293b] text-gray-300 font-cairo">
                @forelse($personnel as $person)
                <tr class="hover:bg-[#111827]/50 transition duration-150">
                    {{-- الرقم العسكري --}}
                    <td class="px-2 py-2 font-mono text-blue-400 font-semibold truncate">{{ $person->military_id }}</td>
                    
                    {{-- B/N --}}
                    <td class="px-2 py-2 font-mono text-blue-400 font-semibold break-all">{{ $person->b_n }}</td>
                    
                    {{-- الاسم الكامل --}}
                    <td class="px-3 py-2 font-medium text-gray-200 break-words leading-tight">{{ $person->full_name }}</td>
                    
                    {{-- الرتبة --}}
                    <td class="px-2 py-2 text-gray-200 whitespace-nowrap">{{ $person->rank }}</td>

                    {{-- التخصص --}}
                    <td class="px-2 py-2 text-gray-300 break-words max-w-[120px] leading-tight">{{ $person->primary_specialty }}</td>
                    
                    {{-- تاريخ التعيين --}}
                    <td class="px-2 py-2 font-mono text-gray-400 text-[11px] whitespace-nowrap">
                        {{ $person->appointment_date?->format('Y/m/d') ?? $person->appointment_date }}
                    </td>
                    
                    {{-- تاريخ التثبيت --}}
                    <td class="px-2 py-2 font-mono text-gray-400 text-[11px] whitespace-nowrap">
                        {{ $person->confirmation_date?->format('Y/m/d') ?? $person->confirmation_date }}
                    </td>
                    
                    {{-- مدة الخدمة --}}
                    <td class="px-2 py-2 whitespace-nowrap">
                        <div class="flex flex-col text-right leading-tight">
                            <span class="text-gray-200 font-medium">{{ $person->service_years }} س</span>
                            <span class="text-[10px] text-gray-500">{{ $person->service_months }} ش</span>
                        </div>
                    </td>

                    {{-- رقم التواصل --}}
                    <td class="px-2 py-2 font-mono text-gray-300 text-[11px] whitespace-nowrap">
                        {{ $person->phone ?? '05XXXXXXXX' }}
                    </td>
                    
                    {{-- الحالة --}}
                    <td class="px-1 py-2 text-center whitespace-nowrap">
                        @if($person->status === 'active' || $person->status === 'نشط')
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 text-[10px] font-medium">
                                <span class="w-1 h-1 rounded-full bg-emerald-500"></span>نشط
                            </span>
                        @elseif($person->status === 'غياب')
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded border border-rose-500/30 bg-rose-500/10 text-rose-400 text-[10px] font-medium">
                                <span class="w-1 h-1 rounded-full bg-rose-500"></span>غياب
                            </span>
                        @elseif($person->status === 'تأخير')
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded border border-yellow-500/30 bg-yellow-500/10 text-yellow-400 text-[10px] font-medium">
                                <span class="w-1 h-1 rounded-full bg-yellow-500"></span>تأخير
                            </span>
                        @elseif($person->status === 'إذن')
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded border border-blue-500/30 bg-blue-500/10 text-blue-400 text-[10px] font-medium">
                                <span class="w-1 h-1 rounded-full bg-blue-500"></span>إذن
                            </span>
                        @elseif($person->status === 'مسلم')
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded border border-green-500/30 bg-green-500/10 text-green-400 text-[10px] font-medium">
                                <span class="w-1 h-1 rounded-full bg-green-500"></span>مسلم
                            </span>
                        @elseif($person->status === 'إجازة')
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded border border-amber-500/30 bg-amber-500/10 text-amber-400 text-[10px] font-medium">
                                <span class="w-1 h-1 rounded-full bg-amber-500"></span>إجازة
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded border border-rose-500/30 bg-rose-500/10 text-rose-400 text-[10px] font-medium">
                                {{ $person->status }}
                            </span>
                        @endif
                    </td>

                    {{-- الإجراءات --}}
                    <td class="px-2 py-2 text-center whitespace-nowrap relative" x-data="{ open: false }" @click.away="open = false">
                        <div class="inline-block relative text-right">
                            <button @click.stop="open = !open" type="button" class="text-gray-400 hover:text-white p-1 rounded-lg hover:bg-gray-800/80 transition focus:outline-none flex items-center justify-center mx-auto">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M6 10a2 2 0 100 4 2 2 0 000-4zm12 0a2 2 0 100 4 2 2 0 000-4zm-6 0a2 2 0 100 4 2 2 0 000-4z"/>
                                </svg>
                            </button>

                            <div x-show="open" 
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95 translate-x-2"
                                x-transition:enter-end="transform opacity-100 scale-100 translate-x-0"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100 translate-x-0"
                                x-transition:leave-end="transform opacity-0 scale-95 translate-x-2"
                                x-cloak 
                                class="absolute left-0 mt-1 w-28 bg-[#070B14] border border-[#1e293b] rounded-lg shadow-2xl z-50 overflow-hidden divide-y divide-[#1e293b]/60 origin-top-left">
                                <a href="{{ route('personnel.show', $person->id) }}" wire:navigate class="block px-3 py-1.5 text-right text-gray-300 hover:bg-blue-600 hover:text-white text-[11px] font-medium transition whitespace-nowrap">
                                    عرض الملف
                                </a>
                                <button wire:click="$dispatch('open-edit-modal', { id: {{ $person->id }} })" @click="open = false" type="button" class="w-full block px-3 py-1.5 text-right text-gray-300 hover:bg-blue-600 hover:text-white text-[11px] font-medium transition whitespace-nowrap">
                                    تعديل البيانات
                                </button>
                                <button @click="targetId = {{ $person->id }}; confirmDelete = true; open = false" type="button" class="w-full block px-3 py-1.5 text-right text-rose-400 hover:bg-rose-600 hover:text-white text-[11px] font-medium transition whitespace-nowrap">
                                    حذف القيد
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="11" class="px-6 py-12 text-center text-gray-500 font-cairo text-sm">
                        لا توجد سجلات عسكرية متطابقة مع خيارات البحث الحالية في القوة البشرية.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- الباجينيشن السفلي --}}
    <div class="bg-[#070B14] px-6 py-3 border-t border-[#1e293b] flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 text-xs text-gray-400 font-cairo">
        <div class="flex items-center gap-2">
            <span>عرض كل صفحة</span>
            <select wire:model.live="perPage" class="bg-[#0a0f1d] border border-[#1e293b] rounded px-2 py-0.5 text-gray-300 focus:outline-none">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
            </select>
        </div>
        <div>
            {{ $personnel->links() }}
        </div>
    </div>
</div>

    <livewire:personnel.personnel-edit />

    <div x-show="confirmDelete" class="fixed inset-0 bg-black/80 flex items-center justify-center p-4 z-50 backdrop-blur-sm" x-cloak>
        <div class="bg-[#0a0f1d] border border-[#1e293b] rounded-xl p-6 max-w-sm w-full space-y-4 shadow-2xl animate-fade-in">
            <h3 class="text-base font-bold text-white font-cairo">تأكيد عملية الحذف العسكرية</h3>
            <p class="text-xs text-gray-400 leading-relaxed font-cairo">هل أنت متأكد تماماً من شطب هذا الفرد من النظام؟ سيتم أرشفة البيانات بشكل دائم ولن تظهر في الكشوفات الميدانية النشطة.</p>
            <div class="flex justify-end gap-3 font-cairo text-xs pt-2">
                <button @click="confirmDelete = false" class="bg-gray-800 text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-700 transition">إلغاء</button>
                <button @click="$wire.deletePersonnel(targetId); confirmDelete = false" class="bg-rose-600 text-white px-4 py-2 rounded-lg hover:bg-rose-700 font-medium transition">نعم، تأكيد الحذف</button>
            </div>
        </div>
    </div>