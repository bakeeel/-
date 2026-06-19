<div class="max-w-4xl mx-auto space-y-6"> {{-- 🌟 العنصر الرئيسي الواحد المغلف للمكون بالكامل --}}

  

    <div class="border-b border-[#1F2937] pb-4 flex items-center justify-between" dir="rtl">
         {{-- هيدر الصفحة التكتيكي --}}
        <div class="border-b border-[#1F2937] pb-4" dir="rtl">
            <h1 class="text-xl font-bold text-[#E5E7EB] font-cairo">تسجيل قيد متدرب جديد</h1>
            <p class="text-xs text-gray-400 mt-1 font-cairo">يرجى إدخال البيانات التدريبية والعسكرية بدقة عيارية مطلقة</p>
        </div>
        <div class="bg-[#2563EB]/10 border border-[#2563EB]/20 text-[#2563EB] px-3 py-1 rounded-full text-xs font-semibold font-cairo">
            جناح النتدربين
        </div>
    </div>

    {{-- استمارة إدخال بيانات المتدرب --}}
    <form wire:submit.prevent="save" class="bg-[#111827] border border-[#1F2937] rounded-xl p-6 space-y-6" dir="rtl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- الاسم الكامل --}}
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-2 font-cairo">الاسم الرباعي الكامل للمتدرب</label>
                <input type="text" wire:model="full_name" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none font-cairo">
                @error('full_name') <span class="text-rose-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
            </div>

            {{-- الرقم العسكري الموحد --}}
           <div class="text-right">
                <label class="block text-xs font-medium text-gray-400 mb-2 font-cairo">الرقم العسكري للضباط</label>
                <input type="text" 
                 oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15)"
                    wire:model="military_id" 
                    class="text-right w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 font-mono text-emerald-400 font-bold opacity-80 text-left" 
                    dir="ltr"
                    placeholder="">
                @error('military_id') <span class="text-rose-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
            </div>

            {{-- رتبة المتدرب --}}
            <div x-data="{ 
                    isCustomRank: false, 
                    rankValue: @entangle('rank'),
                    // الرتب الافتراضية المتاحة للمتدربين للمطابقة السريعة
                    defaultRanks: ['جندي', 'جندي اول', 'عريف', 'وكيل رقيب', 'رقيب', 'رقيب اول', 'رئيس رقباء']
                }" 
                x-init="
                    // دالة فحص فورية لتحديد حالة حقل الإدخال
                    const checkRank = (value) => {
                        if (value && value !== 'custom' && !defaultRanks.includes(value)) {
                            isCustomRank = true;
                        } else {
                            isCustomRank = false;
                        }
                    };

                    // الفحص عند أول تشغيل للشاشة أو المودال
                    checkRank(rankValue);

                    // مراقبة القيمة بشكل ديناميكي لمنع رجوع الحقل فارغاً عند مزامنة الـ Backend
                    $watch('rankValue', value => {
                        checkRank(value);
                    });
                }"
                class="text-right">
                
                <label class="block text-xs font-medium text-gray-400 mb-2 font-cairo">الرتبة الحالية</label>
                
                <div x-show="!isCustomRank">
                    <select x-model="rankValue" 
                            @change="if($event.target.value === 'custom') { isCustomRank = true; rankValue = ''; }"
                            class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none font-cairo">
                        <option value="">اختر الرتبة...</option>
                        <option value="جندي">جندي</option>
                        <option value="جندي اول">جندي أول</option>
                        <option value="عريف">عريف</option>
                        <option value="وكيل رقيب">وكيل رقيب</option>
                        <option value="رقيب">رقيب</option>
                        <option value="رقيب اول">رقيب أول</option>
                        <option value="رئيس رقباء">رئيس رقباء</option>

                        <template x-if="rankValue && !defaultRanks.includes(rankValue) && rankValue !== 'custom'">
                            <option :value="rankValue" x-text="rankValue" selected class="hidden"></option>
                        </template>

                        <option value="custom" class="text-[#2563EB] font-bold bg-[#111827]">✍️ أخرى (إدخال يدوي)...</option>
                    </select>
                </div>

                <div x-show="isCustomRank" x-cloak class="relative flex items-center gap-2">
                    <input type="text" 
                        x-model="rankValue" 
                        placeholder="اكتب رتبة المتدرب يدوياً هنا..." 
                        class="w-full bg-[#070B14] border border-[#2563EB] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:outline-none font-cairo text-right" />
                    
                    <button type="button" 
                            @click="isCustomRank = false; rankValue = '';" 
                            class="bg-[#1F2937] hover:bg-[#374151] border border-[#374151] text-xs text-gray-300 px-3 py-2 rounded-lg font-cairo transition-all shrink-0">
                        رجوع للقائمة
                    </button>
                </div>

                @error('rank') <span class="text-rose-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
            </div>
<!-- 111111111111111 -->

            {{-- حالة القيد التدريبي داخل الدورة --}}
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-2 font-cairo">حالة القيد التدريبي</label>
                <select wire:model="status" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none font-cairo">
                    <option value="">اختر الحالة ...</option>
                        <option value="نشط">نشط</option>
                        <option value="غياب">غياب</option>
                        <option value="إجازة">إجازة</option>
                        <option value="تأخير">تأخير</option>
                        <option value="إذن">إذن</option>
                        <option value="مسلم">مسلم</option>
                        <option value="دورة">دورة</option>
                </select>
                @error('status') <span class="text-rose-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
            </div>

            {{-- التخصص الرئيسي --}}
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-2 font-cairo">التخصص التدريبي الرئيسي</label>
                <input type="text" wire:model="primary_specialty" placeholder="مثال: مدفعية، إشارة" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none font-cairo">
                @error('primary_specialty') <span class="text-rose-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
            </div>
              {{-- تاريخ الالتحاق العسكري للقطاع --}}
        {{-- تاريخ التعيين --}}
<div class="text-right relative block" 
    x-data="{
        showPicker: false,
        viewMode: 'days', 
        selectedDate: @entangle('appointment_date'),
        currentYear: 1447,
        currentMonth: 0,
        daysInMonth: [],
        monthNames: ['محرّم', 'صفر', 'ربيع الأول', 'ربيع الآخر', 'جمادى الأولى', 'جمادى الآخرة', 'رجب', 'شعبان', 'رمضان', 'شوال', 'ذو القعدة', 'ذو الحجة'],
        pickerTop: 0,
        pickerLeft: 0,
        
        get availableYears() {
            let start = this.currentYear - 4; 
            return Array.from({ length: 8 }, (_, i) => start + i);
        },

        init() {
            if (this.selectedDate) {
                const parts = this.selectedDate.split('/');
                if (parts.length === 3) {
                    this.currentYear = parseInt(parts[0]);
                    this.currentMonth = parseInt(parts[1]) - 1;
                }
            } else {
                const now = new Date();
                const hijriStr = now.toLocaleDateString('ar-SA-u-ca-islamic-umalqura', { year: 'numeric', month: 'numeric' });
                const parts = hijriStr.split('/');
                this.currentYear = parseInt(parts[1]) || 1447;
                this.currentMonth = (parseInt(parts[0]) || 1) - 1;
            }
            this.generateCalendar();
        },
        
        generateCalendar() {
            let days = (this.currentMonth % 2 === 0) ? 30 : 29;
            if (this.currentMonth === 11 && ((11 * this.currentYear + 14) % 30) < 11) days = 30;
            this.daysInMonth = Array.from({ length: days }, (_, i) => i + 1);
        },
        
        togglePicker() {
            if (!this.showPicker) {
                const rect = this.$refs.inputField.getBoundingClientRect();
                this.pickerTop = rect.top + window.scrollY - 340;
                this.pickerLeft = rect.right - 280; 
                this.viewMode = 'days';
                this.showPicker = true;
            } else {
                this.showPicker = false;
            }
        },
        
        prevMonth() {
            if (this.currentMonth === 0) {
                this.currentMonth = 11;
                this.currentYear--;
            } else {
                this.currentMonth--;
            }
            this.generateCalendar();
        },
        
        nextMonth() {
            if (this.currentMonth === 11) {
                this.currentMonth = 0;
                this.currentYear++;
            } else {
                this.currentMonth++;
            }
            this.generateCalendar();
        },

        prevYearPage() {
            this.currentYear -= 8;
            this.generateCalendar();
        },

        nextYearPage() {
            this.currentYear += 8;
            this.generateCalendar();
        },

        selectYear(year) {
            this.currentYear = year;
            this.generateCalendar();
            this.viewMode = 'days'; 
        },
        
        selectDay(day) {
            const monthStr = String(this.currentMonth + 1).padStart(2, '0');
            const dayStr = String(day).padStart(2, '0');
            this.selectedDate = `${this.currentYear}/${monthStr}/${dayStr}`;
            this.showPicker = false;
        }
    }"
    @click.away="showPicker = false; viewMode = 'days'"
    class="relative">

    <label class="block text-xs font-bold text-gray-400 mb-2 font-cairo select-none">تاريخ (التعيين)</label>
    
    <div class="relative group" x-ref="inputField">
        <input type="text" 
            readonly
            x-model="selectedDate"
            @click="togglePicker()"
            placeholder="اختر التاريخ الهجري..."
            class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2.5 text-white focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB]/30 outline-none cursor-pointer text-right transition-all font-mono pl-10" />
        
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 pointer-events-none group-hover:text-[#2563EB] transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </div>
    </div>

    <div x-show="showPicker" 
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform translate-y-2 scale-95"
        x-transition:enter-end="transform translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform translate-y-0 scale-100"
        x-transition:leave-end="transform translate-y-2 scale-95"
        class="fixed z-[999999] w-72 bg-[#0b111e] border border-[#1e293b] rounded-xl p-4 shadow-[0_-25px_50px_-12px_rgba(0,0,0,0.95)] text-white"
        :style="`top: ${pickerTop}px !important; left: ${pickerLeft}px !important; min-width: 280px !important; max-width: 280px !important;`"
        x-cloak>
        
        <div class="flex items-center justify-between border-b border-[#1e293b]/60 pb-2 mb-3 select-none w-full">
            <button type="button" @click="viewMode === 'days' ? prevMonth() : prevYearPage()" class="p-1 hover:bg-[#162235] rounded-md text-gray-400 hover:text-white transition-colors cursor-pointer shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>
            
            <div @click="viewMode = viewMode === 'days' ? 'years' : 'days'" class="flex items-center justify-center gap-1 font-bold text-xs text-gray-200 font-cairo cursor-pointer hover:text-blue-400 transition-colors px-2 py-0.5 rounded hover:bg-[#162235] overflow-hidden whitespace-nowrap">
                <template x-if="viewMode === 'days'">
                    <div class="flex items-center">
                        <span x-text="monthNames[currentMonth]"></span>
                        <span x-text="currentYear" class="font-mono text-blue-500 mx-1"></span>
                        <span>هـ</span>
                        <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </template>
                <template x-if="viewMode === 'years'">
                    <div class="flex items-center">
                        <span>اختر السنة الهجرية</span>
                    </div>
                </template>
            </div>
            
            <button type="button" @click="viewMode === 'days' ? nextMonth() : nextYearPage()" class="p-1 hover:bg-[#162235] rounded-md text-gray-400 hover:text-white transition-colors cursor-pointer shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </button>
        </div>

        <div x-show="viewMode === 'days'">
            <div class="grid grid-cols-7 gap-1 text-center text-[11px] font-bold text-gray-500 mb-2 select-none w-full" style="display: grid !important; grid-template-columns: repeat(7, minmax(0, 1fr)) !important; direction: rtl !important;">
                <div class="w-full text-center">ح</div><div class="w-full text-center">ن</div><div class="w-full text-center">ث</div><div class="w-full text-center">ر</div><div class="w-full text-center">خ</div><div class="w-full text-center">ج</div><div class="w-full text-center">س</div>
            </div>
            <div class="grid grid-cols-7 gap-1 w-full" style="display: grid !important; grid-template-columns: repeat(7, minmax(0, 1fr)) !important; direction: rtl !important;">
                <template x-for="day in daysInMonth" :key="day">
                    <button type="button" @click="selectDay(day)" class="block w-full text-center p-1.5 text-xs rounded-lg font-mono transition-all cursor-pointer" style="aspect-ratio: 1/1 !important;" :class="selectedDate && selectedDate.startsWith(currentYear + '/' + String(currentMonth + 1).padStart(2, '0') + '/' + String(day).padStart(2, '0')) ? 'bg-[#2563EB] border border-[#2563EB] text-white font-bold shadow-lg shadow-[#2563EB]/40' : 'bg-[#101726]/40 border border-[#1e293b]/50 text-gray-300 hover:bg-[#2563EB] hover:text-white'">
                        <span x-text="day" class="block w-full text-center"></span>
                    </button>
                </template>
            </div>
        </div>

        <div x-show="viewMode === 'years'" class="space-y-2 max-h-48 overflow-y-auto pr-1">
            <div class="grid grid-cols-2 gap-2 w-full">
                <template x-for="year in availableYears" :key="year">
                    <button type="button" @click="selectYear(year)" class="w-full text-center py-2 px-1 text-xs font-mono font-bold rounded-lg transition-all duration-200 cursor-pointer block border" :class="currentYear === year ? 'bg-[#2563EB] text-white border-[#2563EB] shadow-md shadow-[#2563EB]/20' : 'bg-[#101726]/60 text-gray-300 border-[#1e293b]/80 hover:bg-[#162235] hover:text-white'">
                        <span x-text="year"></span>
                    </button>
                </template>
            </div>
        </div>

        <div class="mt-4 pt-2 border-t border-[#1e293b]/60 flex justify-between items-center select-none w-full">
            <button type="button" @click="selectedDate = ''; showPicker = false; viewMode = 'days'" class="text-[10px] text-rose-400 hover:text-rose-300 font-bold font-cairo px-1 py-0.5 rounded transition-colors cursor-pointer">مسح الحقل</button>
            <button type="button" @click="showPicker = false; viewMode = 'days'" class="text-[10px] text-gray-400 hover:text-gray-200 font-bold font-cairo px-1 py-0.5 rounded transition-colors cursor-pointer">إغلاق</button>
        </div>
    </div>

    @error('appointment_date') 
        <span class="text-rose-500 text-xs mt-1.5 block font-cairo font-bold">{{ $message }}</span> 
    @enderror
</div>
<!-- 000000000000000000000000000 -->

            {{-- مدة الخدمة العسكرية السابقة --}}
            <div class="space-y-2">
                <label class="block text-xs font-medium text-gray-400 font-cairo">مدة الخدمة العسكرية السابقة</label>
                
                <div class="grid grid-cols-2 gap-3">
                    {{-- حقل السنوات --}}
                    <div class="relative flex items-center">
                        <input type="number" 
                            min="0"
                            max="50"
                            wire:model="service_years" 
                            placeholder="0"
                            class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm pl-3 pr-14 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none font-mono text-left"
                            dir="ltr">
                        <span class="absolute right-3 text-xs text-gray-500 font-cairo font-bold pointer-events-none select-none border-l border-[#1F2937] pl-2.5 h-5 flex items-center">
                            سنة
                        </span>
                    </div>

                    {{-- حقل الأشهر --}}
                    <div class="relative flex items-center">
                        <input type="number" 
                            min="0"
                            max="11"
                            wire:model="service_months" 
                            placeholder="0"
                            class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm pl-3 pr-14 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none font-mono text-left"
                            dir="ltr">
                        <span class="absolute right-3 text-xs text-gray-500 font-cairo font-bold pointer-events-none select-none border-l border-[#1F2937] pl-2.5 h-5 flex items-center">
                            شهر
                        </span>
                    </div>
                </div>
                @error('service_years') <span class="text-rose-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
                @error('service_months') <span class="text-rose-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
            </div>

            {{-- رقم جوال التواصل --}}
            <div>
                <label class="block text-xs font-medium text-gray-400 mb-2 font-cairo">رقم جوال المتدرب</label>
                <input type="tel" 
                    maxlength="10" 
                    wire:model="phone" 
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                    placeholder="05xxxxxxxx"
                    class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none font-mono tracking-wider text-left" 
                    dir="ltr">
                @error('phone') <span class="text-rose-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
            </div>
              
          

        </div>

{{-- التواريخ الإضافية وملف الصورة العسكرية للمتدرب --}}
<div class="grid grid-cols-1 gap-6 font-cairo" x-data="{ isUploading: false }">
    
    {{-- صندوق الصورة العسكرية والرفع الذكي --}}
    <div class="bg-[#111827]/40 border border-[#1F2937] p-5 rounded-2xl flex flex-row-reverse items-center justify-between gap-4 relative overflow-hidden group">
        
        <div class="space-y-1 flex-1 text-right">
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">الصورة الشخصية الرسمية</label>
            <p class="text-[11px] text-gray-500 leading-relaxed">يرجى رفع صورة رسمية بالزي العسكري وبخلفية سادة (بحد أقصى 2 ميجابايت).</p>
            
            <div class="pt-2">
                <label class="cursor-pointer inline-flex items-center gap-1.5 bg-[#2563EB]/10 border border-[#2563EB]/20 hover:bg-[#2563EB]/20 text-[#2563EB] px-3 py-1.5 rounded-lg text-xs font-medium transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                    </svg>
                    <span>رفع صورة المتدرب</span>
                    {{-- الحماية الفورية: رفع يدوي مشروط بعد التحقق من نوع الملف لمنع وصول الـ PDF للسيرفر --}}
                    <input type="file" 
                           class="hidden" 
                           accept="image/png, image/jpeg, image/jpg, image/gif, image/webp"
                           @change="
                                const file = $event.target.files[0];
                                if (file) {
                                    if (!file.type.startsWith('image/')) {
                                        alert('عذراً، يجب اختيار ملف صورة فقط (png, jpg, jpeg, gif, webp).');
                                        $event.target.value = ''; 
                                        return;
                                    }
                                    
                                    isUploading = true;
                                    @this.upload('avatar', file, 
                                        (uploadedName) => { isUploading = false; }, 
                                        () => { isUploading = false; $event.target.value = ''; }, 
                                        (progressEvent) => {}
                                    );
                                }
                           ">
                </label>
            </div>
        </div>

        <div class="relative shrink-0">
            <div class="w-20 h-20 bg-[#070B14] border-2 border-dashed border-[#1F2937] group-hover:border-[#2563EB]/50 p-1 transition-all duration-300 flex items-center justify-center overflow-hidden rounded-lg">
                {{-- التحقق الصارم من امتداد الملف قبل طلب المعاينة لمنع الانهيار الخلفي --}}
                @if ($avatar && method_exists($avatar, 'temporaryUrl') && in_array(strtolower($avatar->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                    <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full object-cover rounded-md">
                @elseif (isset($existingAvatar) && $existingAvatar)
                    <img src="{{ asset('storage/' . $existingAvatar) }}" class="w-full h-full object-cover rounded-md">
                @else
                    <div class="text-gray-600 flex flex-col items-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                @endif
            </div>
        </div>

        {{-- مؤشر جاري الرفع اللاسلكي الفوري --}}
        <div wire:loading wire:target="avatar" class="absolute inset-0 bg-[#070B14]/95 flex flex-col items-center justify-center gap-2 transition-all z-10">
            <svg class="animate-spin h-5 w-5 text-[#2563EB]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-[11px] text-gray-400 font-mono tracking-widest animate-pulse">UPLOADING IMAGE...</span>
        </div>

    </div>
    @error('avatar') <span class="text-rose-400 text-xs mt-1 block col-span-full text-right">{{ $message }}</span> @enderror

</div>

        {{-- الملاحظات التدريبية الإضافية مع تحسين التمدد التلقائي UI/UX --}}
        <div class="mt-4 font-cairo" x-data="{ 
            resize() { 
                $el.style.height = 'auto'; 
                $el.style.height = $el.scrollHeight + 'px' 
            } 
        }" x-init="resize()">
            <label class="block text-xs font-bold text-gray-400 mb-2">ملاحظات وتقييمات سابقة وموانع صحية</label>
            <textarea 
                wire:model="notes" 
                x-on:input="resize()"
                rows="3" 
                class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] outline-none transition resize-none overflow-hidden"
                placeholder="أدخل أي ملاحظات هامة أو تقييم أمني/تدريبي يتعلق بهذا المتدرب..."></textarea>
            @error('notes') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="text-sm text-gray-500 font-cairo">ملاحظة نظامية: بعد إدراج ملف المتدرب بالمنظومة، يتاح تعديل البيانات وتحديث التقييم الدوري والدرجات عبر لوحة التحكم الفردية للمتدربين.</div>    
         
        {{-- أزرار حفظ وإلغاء الحركة --}}
        <div class="flex justify-end gap-3 border-t border-[#1F2937] pt-4 font-cairo">
            <a href="{{ route('trainee.index') }}" wire:navigate class="bg-gray-800 text-gray-300 px-4 py-2 rounded-lg text-sm hover:bg-gray-700 transition">إلغاء الأمر</a>
            
            <button type="submit" 
                    wire:loading.attr="disabled"
                    class="bg-[#2563EB] hover:bg-[#1d4ed8] text-white px-5 py-2 rounded-lg text-sm font-medium shadow-lg transition flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                
                <svg wire:loading wire:target="save" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

                <span>إدراج ملف المتدرب</span>
            </button>
        </div>
    </form>
</div>