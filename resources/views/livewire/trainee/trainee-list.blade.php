<div class="space-y-6" x-data="{ confirmDelete: false, targetId: null }">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-[#1F2937] pb-5 gap-4 font-cairo" dir="rtl">
        
        {{-- الجانب الأيمن: العناوين والوصف --}}
        <div class="space-y-1">
            <h1 class="text-xl font-bold text-[#E5E7EB] tracking-wide">إدارة شؤون المتدربين</h1>
            <p class="text-xs text-gray-400">البحث، الفلترة المتقدمة وشطب قيود المتدربين داخل المنظومة التدريبية</p>
        </div>

        {{-- الجانب الأيسر: الأزرار والروابط --}}
        <div class="flex items-center gap-2.5 self-stretch sm:self-center">
            
            {{-- زر تصدير إكسيل الفوري --}}
            <button wire:click="exportToExcel" 
                    class="flex-1 sm:flex-none border border-[#107C41]/30 bg-[#107C41]/10 hover:bg-[#107C41]/20 text-[#107C41] hover:text-[#15964f] px-4 py-2 rounded-xl text-xs md:text-sm font-bold transition-all duration-200 flex items-center justify-center gap-2 group shadow-sm">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-y-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>تصدير Excel</span>
            </button>

            {{-- زر تسجيل متدرب جديد --}}
            <a href="{{ route('trainee.create') }}" 
               class="flex-1 sm:flex-none bg-[#2563EB] hover:bg-[#1d4ed8] text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-[1.01] shadow-lg shadow-blue-900/10 flex items-center justify-center gap-2 group whitespace-nowrap">
                <svg class="w-4 h-4 transition-transform group-hover:rotate-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>تسجيل متدرب جديد</span>
            </a>
            
        </div>
    </div>

    {{-- لوحة الفلترة والبحث المتقدم --}}
    <div class="bg-[#0b1329]/30 border border-[#1e293b] p-5 rounded-xl grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="block text-xs font-medium text-gray-400 mb-1.5 font-cairo">البحث السريع</label>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="ابحث بالاسم، الرقم العسكري..." class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] placeholder-gray-500 focus:outline-none focus:border-[#2563EB] font-cairo">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-400 mb-1.5 font-cairo">رتبة المتدرب</label>
            <select wire:model.live="rank" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:outline-none focus:border-[#2563EB] font-cairo">
                <option value="">كل الرتب</option>
                <option value="جندي">جندي</option>
                <option value="جندي أول">جندي أول</option>
                <option value="عريف">عريف</option>
                <option value="وكيل رقيب">وكيل رقيب</option>
                <option value="رقيب">رقيب</option>
                <option value="رقيب أول">رقيب أول</option>
                <option value="رئيس رقباء">رئيس رقباء</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-400 mb-1.5 font-cairo">حالة القيد التدريبي</label>
            {{-- 🌟 تم تصحيح الـ values هنا لتتطابق برمجياً مع قاعدة بيانات لوحة التعديل الحالية --}}
            <select wire:model.live="status" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:outline-none focus:border-[#2563EB] font-cairo">
                <option value="">كل الحالات</option>
                <option value="نشط">مستمر بالدورة</option>
                  
                    <option value="غياب">غياب</option>
                    <option value="إجازة">إجازة</option>
                    <option value="تأخير">تأخير</option>
                    <option value="إذن">إذن</option>
                    <option value="مسلم">مسلم</option>
            </select>
        </div>
        <!-- <div>
            <label class="block text-xs font-medium text-gray-400 mb-2 font-cairo">التخصص الرئيسي</label>
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

    {{-- جدول كشوفات بيانات المتدربين الرئيسي --}}
    <div class="bg-[#0a0f1d] border border-[#1e293b] rounded-xl overflow-visible shadow-2xl">
        <div class="overflow-x-auto rounded-xl">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-[#070B14] border-b border-[#1e293b] text-[11px] font-bold text-gray-400 font-cairo uppercase tracking-wider">
                        
                        <th class="px-4 py-4">الرقم العسكري</th>
                        <th class="px-4 py-4">الاسم الكامل</th>
                       
                        <th class="px-4 py-4">الرتبة</th>
                        <th class="px-4 py-4">التخصص</th>
                        <th class="px-4 py-4">تاريخ التعيين</th>
               
                        <th class="px-4 py-4">مدة الخدمة</th>
                        <th class="px-4 py-4">رقم التواصل</th>
                        <th class="px-4 py-4 text-center">الحالة</th>
                        <th class="px-4 py-4 text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1e293b] text-xs text-gray-300 font-cairo">
                    @forelse($trainees as $trainee)
                    {{-- 🌟 إلحاق الـ wire:key لمنع Livewire من خلط حقول العناصر أثناء البحث والترقيم الفوري --}}
                    <tr wire:key="trainee-row-{{ $trainee->id }}" class="hover:bg-[#111827]/50 transition duration-150">
                        
                       

                       
                        <td class="px-4 py-2.5 font-mono text-blue-400 font-semibold whitespace-nowrap">{{ $trainee->military_id }}</td>
                         <td class="px-4 py-2.5 font-medium text-gray-200 whitespace-nowrap">{{ $trainee->full_name }}</td>
                        
                        <td class="px-4 py-2.5 text-gray-200 whitespace-nowrap">
                            <div class="flex items-center gap-1.5">
                                <!-- <svg class="w-3.5 h-3.5 text-amber-500/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg> -->
                                <span>{{ $trainee->rank }}</span>
                            </div>
                        </td>

                        <td class="px-4 py-2.5 text-gray-300 whitespace-nowrap">{{ $trainee->primary_specialty }}</td>
                        <td class="px-4 py-2.5 font-mono text-gray-400 whitespace-nowrap">{{ $trainee->appointment_date ? \Carbon\Carbon::parse($trainee->appointment_date)->format('Y/m/d') : 'غير محدد' }}</td>
                        
                        
                        <td class="px-4 py-2.5 whitespace-nowrap">
                            <div class="flex flex-col text-right leading-tight">
                                <span class="text-gray-200 font-medium">{{ $trainee->service_years }} سنوات</span>
                                <span class="text-[10px] text-gray-500">{{ $trainee->service_months }} شهر</span>
                            </div>
                        </td>

                        <td class="px-4 py-2.5 whitespace-nowrap">
                            <div class="flex items-center gap-2 font-mono text-gray-300" >
                                <!-- <svg class="w-3.5 h-3.5 text-blue-500/80" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-1C7.22 18 2 12.78 2 6V3z"/>
                                </svg> -->
                                <span>{{ $trainee->phone ?? '05XXXXXXXX' }}</span>
                            </div>
                        </td>
                        
                        {{-- بطاقة الحالة الأمنية للمتدرب --}}
                        <td class="px-4 py-2.5 text-center whitespace-nowrap">
                            @if($trainee->status === 'active' || $trainee->status === 'نشط')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    مستمر
                                </span>
                            @elseif($trainee->status === 'completed' || $trainee->status === 'إذن')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded border border-blue-500/30 bg-blue-500/10 text-blue-400 text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                    إذن 
                                </span>
                                  @elseif($trainee->status === 'completed' || $trainee->status === 'إجازة')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded border border-blue-500/30 bg-blue-500/10 text-blue-400 text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                     إجازة
                                </span>
                                 @elseif($trainee->status === 'completed' || $trainee->status === 'غياب')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded border border-blue-500/30 bg-blue-500/10 text-blue-400 text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                     غياب
                                </span>
                                  @elseif($trainee->status === 'completed' || $trainee->status === 'تأخير')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded border border-blue-500/30 bg-blue-500/10 text-blue-400 text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                     تأخير
                                </span>
                                   @elseif($trainee->status === 'completed' || $trainee->status === 'مستشفى')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded border border-blue-500/30 bg-blue-500/10 text-blue-400 text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                     مستشفى
                                </span>
                                   @elseif($trainee->status === 'completed' || $trainee->status === 'مسلم')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded border border-blue-500/30 bg-blue-500/10 text-blue-400 text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                     مسلم
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded border border-rose-500/30 bg-rose-500/10 text-rose-400 text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    منقطع  
                                </span>
                            @endif
                        </td>

                        {{-- قائمة الإجراءات المنسدلة --}}
                        <td class="px-4 py-2 text-center whitespace-nowrap font-cairo" x-data="{ open: false }" @click.away="open = false">
                            <div class="inline-block relative text-right">
                                
                                <button @click.stop="open = !open" type="button" class="text-gray-400 hover:text-white p-1.5 rounded-lg hover:bg-gray-800/80 transition focus:outline-none flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
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
                                     class="absolute left-0 mt-1.5 w-28 bg-[#070B14] border border-[#1e293b] rounded-lg shadow-2xl z-40 overflow-hidden divide-y divide-[#1e293b]/60 origin-top-left">
                                    
                                    <a href="{{ route('trainee.show', $trainee->id) }}" class="block px-3 py-2 text-right text-gray-300 hover:bg-blue-600 hover:text-white text-[11px] font-medium transition whitespace-nowrap">
                                        عرض الملف
                                    </a>
                                    
                                    {{-- 🌟 تم تحويل هذا الزر التكتيكي ليطلق الحدث الفوري لفتح المودال الهجين بدلاً من الرابط المعطل --}}
                                    <button type="button" 
                                            @click.prevent="$dispatch('open-edit-modal', { id: {{ $trainee->id }} }); open = false" 
                                            class="w-full block px-3 py-2 text-right text-gray-300 hover:bg-blue-600 hover:text-white text-[11px] font-medium transition whitespace-nowrap">
                                        تعديل البيانات
                                    </button>
                                    
                                    <button @click="targetId = {{ $trainee->id }}; confirmDelete = true; open = false" type="button" class="w-full block px-3 py-2 text-right text-rose-400 hover:bg-rose-600 hover:text-white text-[11px] font-medium transition whitespace-nowrap">
                                        حذف القيد
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="px-6 py-12 text-center text-gray-500 font-cairo text-sm">
                            لا توجد سجلات عسكرية متطابقة مع خيارات البحث الحالية في منظومة المتدربين.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- التحكم بالصفحات والعدد المعروض للترقيم الصفحي --}}
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
                {{ $trainees->links() }}
            </div>
        </div>
    </div>
    
    {{-- تضمين المودال الفرعي في أسفل الصفحة ليعمل بشكل هجين وتلقائي --}}
    @livewire('trainee.trainee-edit') 

    {{-- نافذة التأكيد المنبثقة عبر الـ Alpine.js لحذف السجل التكتيكي للمتدرب --}}
    <div x-show="confirmDelete" class="fixed inset-0 bg-black/80 flex items-center justify-center p-4 z-50 backdrop-blur-sm" x-cloak>
        <div class="bg-[#0a0f1d] border border-[#1e293b] rounded-xl p-6 max-w-sm w-full space-y-4 shadow-2xl animate-fade-in">
            <h3 class="text-base font-bold text-white font-cairo">تأكيد عملية حذف قيد المتدرب</h3>
            <p class="text-xs text-gray-400 leading-relaxed font-cairo">هل أنت متأكد تماماً من شطب هذا المتدرب من الدورة؟ سيتم مسح قياده الميدانية النشطة بشكل دائم من المنظومة العسكرية الحالية.</p>
            <div class="flex justify-end gap-3 font-cairo text-xs pt-2">
                <button @click="confirmDelete = false" class="bg-gray-800 text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-700 transition">إلغاء</button>
                <button @click="$wire.deleteTrainee(targetId); confirmDelete = false" class="bg-rose-600 text-white px-4 py-2 rounded-lg hover:bg-rose-700 font-medium transition">نعم، تأكيد الشطب</button>
            </div>
        </div>
    </div>
</div>