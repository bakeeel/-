<div x-data="{ open: @entangle('isOpen') }" 
     x-show="open" 
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm" 
     x-cloak>
    
    <div class="bg-[#111827] border border-[#1F2937] p-5 rounded-2xl shadow-2xl w-full max-w-xl max-h-[90vh] overflow-y-auto font-cairo text-right" dir="rtl" @click.away="open = false">
        
        {{-- رأس المودال التكتيكي --}}
        <div class="flex items-center justify-between mb-4 pb-2 border-b border-[#1F2937]">
            <h2 class="text-white text-base font-bold">تعديل بيانات ملف المتدرب</h2>
            <button @click="open = false" class="text-gray-500 hover:text-white transition text-sm">✕</button>
        </div>
        
        {{-- عرض قائمة بجميع أخطاء التحقق الفاشلة إن وجدت --}}
        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-3 rounded-xl text-xs mb-4">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form wire:submit="update" class="space-y-4">
            {{-- حقل الصورة الشخصية للمتدرب --}}
                            {{-- حاوية الصورة الشخصية المحدثة والمحمية --}}
                {{-- حاوية الصورة الشخصية المحدثة والمحمية برمجياً لمنع انهيار الـ Preview --}}
                <div class="flex items-center gap-3 p-2 bg-[#070B14] rounded-xl border border-[#1F2937]">
                    <div class="w-12 h-12 rounded-lg bg-[#111827] border border-[#1F2937] flex items-center justify-center overflow-hidden shrink-0 relative">
                        {{-- تحقق صارم من نوع الكائن وامتداده الفعلي قبل طلب المعاينة المؤقتة --}}
                        @if ($avatar && method_exists($avatar, 'temporaryUrl') && in_array(strtolower($avatar->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                            <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif ($existingAvatar)
                            <img src="{{ asset('storage/' . $existingAvatar) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-gray-600 text-[9px] font-cairo">لا صورة</span>
                        @endif

                        {{-- مؤشر تحميل مصغر يظهر حصراً أثناء المعالجة الفعلية --}}
                        <div wire:loading wire:target="avatar" class="absolute inset-0 bg-gray-950/80 flex items-center justify-center">
                            <svg class="animate-spin h-4 w-4 text-emerald-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </div>
                    </div>

                    {{-- فصل الربط التلقائي والاعتماد على الرفع اليدوي المشروط عبر Alpine.js --}}
                    <div class="flex-1" x-data="{ isUploading: false }">
                        <input type="file" 
                            accept="image/png, image/jpeg, image/jpg, image/gif, image/webp"
                            @change="
                                    const file = $event.target.files[0];
                                    if (file) {
                                        if (!file.type.startsWith('image/')) {
                                            alert('عذراً، يجب اختيار ملف صورة فقط (png, jpg, jpeg, gif, webp).');
                                            $event.target.value = ''; // تصفير الحقل فوراً لإحباط العملية
                                            return;
                                        }
                                        
                                        // تمرير الصورة برمجياً إلى الـ Backend فقط بعد التأكد من سلامتها
                                        isUploading = true;
                                        @this.upload('avatar', file, 
                                            (uploadedName) => { isUploading = false; }, 
                                            () => { isUploading = false; $event.target.value = ''; }, 
                                            (progressEvent) => {}
                                        );
                                    }
                            "
                            class="w-full text-[11px] text-gray-400 file:mr-2 file:py-1 file:px-2 file:rounded-md file:border-0 file:text-[10px] file:bg-[#1F2937] file:text-gray-300 cursor-pointer font-cairo">
                    </div>
                </div>

              

{{-- شبكة الحقول الأساسية والتدريبية --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
    {{-- الاسم الكامل --}}
    <div class="space-y-1">
        <label class="block text-xs font-semibold text-gray-400 font-cairo">الاسم الرباعي الكامل للمتدرب</label>
        <input type="text" wire:model="full_name" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none transition-colors font-cairo">
        @error('full_name') <span class="text-rose-500 text-[11px] block font-cairo">{{ $message }}</span> @enderror
    </div>
    
    {{-- الرقم العسكري الثابت للمتدرب --}}
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
                    // الرتب الافتراضية الثابتة للمطابقة الفورية بالواجهة
                    defaultRanks: ['جندي', 'جندي اول', 'عريف', 'وكيل رقيب', 'رقيب', 'رقيب اول', 'رئيس رقباء']
                }" 
                x-init="
                    const checkRank = (value) => {
                        if (value && value !== 'custom' && !defaultRanks.includes(value.trim())) {
                            isCustomRank = true;
                        } else {
                            isCustomRank = false;
                        }
                    };

                    // فحص القيمة فوراً عند إطلاق مودال التعديل
                    checkRank(rankValue);

                    // مراقبة القيمة لضمان استقرارها عند مزامنة الـ Backend ومنع الـ Reset
                    $watch('rankValue', value => {
                        checkRank(value);
                    });
                }"
                class="space-y-1 text-right">
                
                <label class="block text-xs font-semibold text-gray-400">الرتبة الحالية</label>
                
                <div x-show="!isCustomRank">
                    <select x-model="rankValue" 
                            @change="if($event.target.value === 'custom') { isCustomRank = true; rankValue = ''; }"
                            class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none transition-colors font-cairo">
                            <option value="">اختر الرتبة...</option>
                            <option value="جندي">جندي</option>
                            <option value="جندي اول">جندي أول</option>
                            <option value="عريف">عريف</option>
                            <option value="وكيل رقيب">وكيل رقيب</option>
                            <option value="رقيب">رقيب</option>
                            <option value="رقيب اول">رقيب أول</option>
                            <option value="رئيس رقباء">رئيس رقباء</option>

                        <template x-if="rankValue && !defaultRanks.includes(rankValue.trim()) && rankValue !== 'custom'">
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

                @error('rank') <span class="text-rose-500 text-[11px] font-cairo mt-1 block">{{ $message }}</span> @enderror
            </div>

                {{-- حالة القيد التدريبي --}}
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-gray-400">حالة القيد التدريبي</label>
                    <select wire:model="status" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none transition-colors">
                        <option value=""> الحالة...</option>
                        <option value="نشط">نشط</option>
                        <option value="غياب">غياب</option>
                        <option value="إجازة">إجازة</option>
                        <option value="تأخير">تأخير</option>
                        <option value="إذن">إذن</option>
                        <option value="مسلم">مسلم</option>
                        <option value="دورة">دورة</option>
                    </select>
                    @error('status') <span class="text-rose-500 text-[11px]">{{ $message }}</span> @enderror
                </div>

                {{-- التخصص الرئيسي --}}
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-gray-400">التخصص التدريبي الرئيسي</label>
                    <input type="text" wire:model="primary_specialty" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none transition-colors">
                    @error('primary_specialty') <span class="text-rose-500 text-[11px]">{{ $message }}</span> @enderror
                </div>

                {{-- رقم الجوال للاتصال البيني --}}
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-gray-400">رقم جوال المتدرب</label>
                    <input type="tel" 
                           maxlength="10" 
                           wire:model="phone" 
                           oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                           placeholder="05xxxxxxxx" 
                           class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] font-mono focus:border-[#2563EB] focus:outline-none transition-colors text-left" 
                           dir="ltr">
                    @error('phone') <span class="text-rose-500 text-[11px]">{{ $message }}</span> @enderror
                </div>

                {{-- تاريخ الالتحاق بالخدمة --}}
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
<!-- 000000000000000 -->
                {{-- حقل مدة الخدمة السابقة --}}
                <div class="space-y-1.5 md:col-span-2 border-t border-[#1F2937]/60 pt-3">
                    <label class="block text-xs font-semibold text-gray-400">مدة الخدمة العسكرية السابقة</label>
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
                            <span class="absolute right-3 text-xs text-gray-500 font-bold pointer-events-none select-none border-l border-[#1F2937] pl-2.5 h-5 flex items-center">
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
                            <span class="absolute right-3 text-xs text-gray-500 font-bold pointer-events-none select-none border-l border-[#1F2937] pl-2.5 h-5 flex items-center">
                                شهر
                            </span>
                        </div>
                    </div>
                    @error('service_years') <span class="text-rose-500 text-[11px] block mt-0.5">{{ $message }}</span> @enderror
                    @error('service_months') <span class="text-rose-500 text-[11px] block mt-0.5">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- الملاحظات والتعليقات مع تحسين التمدد التلقائي الذكي UI/UX --}}
            <div class="space-y-1" x-data="{ resize() { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px' } }" x-init="resize()">
                <label class="text-gray-400 text-xs font-semibold">ملاحظات عامة وملفات خدمة المتدرب</label>
                <textarea 
                    wire:model="notes" 
                    x-on:input="resize()"
                    rows="2" 
                    class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none resize-none overflow-hidden transition" 
                    placeholder="ملاحظات صحية، مستثنيات، تقارير تدريبية سابقة..."></textarea>
                @error('notes') <span class="text-rose-500 text-[11px]">{{ $message }}</span> @enderror
            </div>

            {{-- أزرار التحكم والاتصال المباشر --}}
            <div class="flex justify-end gap-2 pt-2 border-t border-[#1F2937]">
                <button type="button" @click="open = false" class="text-gray-400 hover:text-white px-3 py-1.5 text-xs transition-colors">إلغاء</button>
                
                {{-- قفل زر الحفظ والتحديث أثناء عملية الرفع أو المعالجة لمنع تصادم البيانات اللاسلكية --}}
                <button type="submit" 
                        wire:loading.attr="disabled" 
                        wire:target="update, avatar"
                        class="bg-blue-600 text-white px-4 py-1.5 rounded-lg text-xs font-bold hover:bg-blue-700 transition-colors tracking-wide disabled:opacity-50 disabled:cursor-not-allowed">
                    <span wire:loading.remove wire:target="update, avatar">حفظ التعديلات</span>
                    <span wire:loading wire:target="update, avatar" class="inline-flex items-center gap-1">
                        <svg class="animate-spin h-3 w-3 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        جاري المعالجة...
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>