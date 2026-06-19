<div class="max-w-4xl mx-auto space-y-6">
    <!-- الهيدر -->
    <div class="border-b border-[#1F2937] pb-4 flex items-center justify-between" dir="rtl">
        <div class="text-right">
            <h1 class="text-xl font-bold text-[#E5E7EB] font-cairo">تسجيل فرد عسكري جديد</h1>
            <p class="text-xs text-gray-400 mt-1">يرجى إدخال البيانات بدقة عيارية مطلقة للقيادة</p>
        </div>
        <div class="bg-[#2563EB]/10 border border-[#2563EB]/20 text-[#2563EB] px-3 py-1 rounded-full text-xs font-semibold font-cairo">
            جناح الأفراد
        </div>
    </div>
        
    <!-- النموذج الرئيسي -->
    <form wire:submit.prevent="save" class="bg-[#111827] border border-[#1F2937] rounded-xl p-6 space-y-6">
        
        <!-- قسم رفع ومعاينة الصورة الشخصية المطور -->
        <div class="flex flex-col items-center justify-center pb-6 border-b border-[#1F2937]/60" dir="rtl">
            <label class="block text-xs font-medium text-gray-400 mb-3 font-cairo w-full text-right">الصورة الشخصية للفرد</label>
            
            <div class="flex flex-col w-full" x-data="{ isUploading: false }">
    <div class="flex items-center gap-5 w-full justify-start">
        <div class="relative w-20 h-20 rounded-full border-2 border-[#1F2937] bg-[#070B14] flex items-center justify-center overflow-hidden shrink-0 group">
            {{-- تحقق صارم من امتداد ونوع كائن الأفاتار قبل المعاينة المؤقتة لمنع الانهيار الخلفي --}}
            @if ($avatar && method_exists($avatar, 'temporaryUrl') && in_array(strtolower($avatar->getClientOriginalExtension()), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                <img src="{{ $avatar->temporaryUrl() }}" class="w-full h-full object-cover">
            @elseif (isset($existingAvatar) && $existingAvatar)
                <img src="{{ asset('storage/' . $existingAvatar) }}" class="w-full h-full object-cover">
            @else
                <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            @endif

            <div wire:loading wire:target="avatar" class="absolute inset-0 bg-black/70 flex items-center justify-center">
                <svg class="animate-spin h-5 w-5 text-[#2563EB]" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </div>

        <div class="space-y-1.5">
            <div class="flex items-center gap-2">
                <label class="cursor-pointer bg-[#1F2937] hover:bg-[#374151] border border-[#374151] text-xs text-gray-200 px-4 py-2 rounded-lg font-cairo transition-all inline-block">
                    <span>رفع صورة جديدة</span>
                    <input type="file" 
                           accept="image/png, image/jpeg, image/jpg, image/gif, image/webp" 
                           class="hidden"
                           @change="
                                const file = $event.target.files[0];
                                if (file) {
                                    if (!file.type.startsWith('image/')) {
                                        alert('عذراً، يجب اختيار ملف صورة فقط (png, jpg, jpeg, gif, webp).');
                                        $event.target.value = ''; // تصفير حقل الرفع فوراً ومنع وصوله للسيرفر
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
                
                @if ($avatar)
                    <button type="button" wire:click="$set('avatar', null)" class="text-xs text-rose-400 hover:text-rose-300 px-3 py-2 rounded-lg font-cairo transition-all">
                        إزالة الصورة
                    </button>
                @endif
            </div>
            <p class="text-[11px] text-gray-500 font-cairo">الصيغ المدعومة: JPG, PNG, WEBP (الحد الأقصى: 2 ميجابايت)</p>
        </div>
    </div>
    
    @error('avatar') 
        <span class="text-rose-500 text-xs mt-1 block font-cairo w-full text-right">{{ $message }}</span> 
    @enderror
</div>

        <!-- الشبكة الأولى: البيانات الأساسية -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" dir="rtl">
            
            <!-- الاسم الرباعي -->
            <div class="text-right">
                <label class="block text-xs font-medium text-gray-400 mb-2 font-cairo">الاسم الرباعي الكامل</label>
                <input type="text" wire:model="full_name" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none">
                @error('full_name') <span class="text-rose-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
            </div>

            <!-- الرقم العسكري -->
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
             <!-- n_b  -->
            <div class="text-right">
                <label class="block text-xs font-medium text-gray-400 mb-2 font-cairo">b_n  </label>
                <input type="text" wire:model="b_n" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none">
                @error('b_n') <span class="text-rose-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
            </div>

            <!-- الرتبة الحالية مع الإصلاح الذكي المستقر للـ Alpine -->
            <div x-data="{ 
                    isCustomRank: false, 
                    rankValue: @entangle('rank'),
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
                    checkRank(rankValue);

                    $watch('rankValue', value => {
                        if (value === 'custom') {
                            isCustomRank = true;
                        } else if (value === '' || defaultRanks.includes(value.trim())) {
                            isCustomRank = false;
                        }
                    });
                }"
                class="text-right">
                
                <label class="block text-xs font-medium text-gray-400 mb-2 font-cairo">الرتبة الحالية</label>
                
                <div x-show="!isCustomRank">
                    <select x-model="rankValue" 
                            @change="if($event.target.value === 'custom') { isCustomRank = true; rankValue = ''; }"
                            class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none font-cairo text-right">
                        <option value="">اختر الرتبة...</option>
                        
                        <optgroup label="🪖 رتب الأفراد" class="bg-[#111827] text-gray-400 font-bold">
                            <option value="جندي" class="text-[#E5E7EB]">جندي</option>
                            <option value="جندي اول" class="text-[#E5E7EB]">جندي أول</option>
                            <option value="عريف" class="text-[#E5E7EB]">عريف</option>
                            <option value="وكيل رقيب" class="text-[#E5E7EB]">وكيل رقيب</option>
                            <option value="رقيب" class="text-[#E5E7EB]">رقيب</option>
                            <option value="رقيب اول" class="text-[#E5E7EB]">رقيب أول</option>
                            <option value="رئيس رقباء" class="text-[#E5E7EB]">رئيس رقباء</option>
                        </optgroup>

                        <template x-if="rankValue && !defaultRanks.includes(rankValue.trim()) && rankValue !== 'custom'">
                            <option :value="rankValue" x-text="rankValue" selected class="hidden"></option>
                        </template>

                        <option value="custom" class="text-[#2563EB] font-bold bg-[#111827]">✍️ أخرى (إدخال يدوي)...</option>
                    </select>
                </div>

                <div x-show="isCustomRank" x-cloak class="relative flex items-center gap-2">
                    <input type="text" 
                        x-model="rankValue" 
                        placeholder="اكتب الرتبة يدوياً هنا..." 
                        class="w-full bg-[#070B14] border border-[#2563EB] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:outline-none font-cairo text-right" />
                    
                    <button type="button" 
                            @click="isCustomRank = false; rankValue = '';" 
                            class="bg-[#1F2937] hover:bg-[#374151] border border-[#374151] text-xs text-gray-300 px-3 py-2 rounded-lg font-cairo transition-all shrink-0">
                        رجوع للقائمة
                    </button>
                </div>

                @error('rank') <span class="text-rose-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
            </div>

            <!-- الحالة الميدانية -->
            <div class="text-right">
                <label class="block text-xs font-medium text-gray-400 mb-2 font-cairo">الحالة الميدانية</label>
                <select wire:model="status" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none font-cairo">
                    <option value="">اختر الحالة...</option>
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

            <!-- التخصص الرئيسي -->
            <div class="text-right">
                <label class="block text-xs font-medium text-gray-400 mb-2 font-cairo">التخصص الرئيسي</label>
                <input type="text" wire:model="primary_specialty" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none">
                @error('primary_specialty') <span class="text-rose-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
            </div>

            <!-- التخصص الفرعي -->
            <div class="text-right">
                <label class="block text-xs font-medium text-gray-400 mb-2 font-cairo">التخصص الفرعي</label>
                <input type="text" wire:model="sub_specialty" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none">
                @error('sub_specialty') <span class="text-rose-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
            </div>

            <!-- مدة الخدمة -->
            <div class="space-y-2 text-right">
                <label class="block text-xs font-medium text-gray-400 font-cairo">مدة الخدمة</label>
                <div class="grid grid-cols-2 gap-3">
                    <div class="relative flex items-center">
                        <input type="number" min="0" max="50" wire:model="service_years" placeholder="0" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm pl-3 pr-14 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none font-mono text-left" dir="ltr">
                        <span class="absolute right-3 text-xs text-gray-500 font-cairo font-bold pointer-events-none select-none border-l border-[#1F2937] pl-2.5 h-5 flex items-center">سنة</span>
                    </div>
                    <div class="relative flex items-center">
                        <input type="number" min="0" max="11" wire:model="service_months" placeholder="0" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm pl-3 pr-14 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none font-mono text-left" dir="ltr">
                        <span class="absolute right-3 text-xs text-gray-500 font-cairo font-bold pointer-events-none select-none border-l border-[#1F2937] pl-2.5 h-5 flex items-center">شهر</span>
                    </div>
                </div>
                @error('service_years') <span class="text-rose-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
                @error('service_months') <span class="text-rose-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
            </div>

            <!-- رقم التواصل -->
            <div class="text-right">
                <label class="block text-xs font-medium text-gray-400 mb-2 font-cairo">رقم التواصل</label>
                <input type="tel" maxlength="10" wire:model="phone" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" placeholder="05xxxxxxxx" class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none font-mono tracking-wider text-left" dir="ltr">
                @error('phone') <span class="text-rose-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
            </div>

            <!-- تاريخ التعيين -->
         <div class="text-right relative block" 
                x-data="{
                    showPicker: false,
                    viewMode: 'days', 
                    selectedDate: @entangle('appointment_date'),
                    currentYear: 1447,
                    currentMonth: 0,
                    daysInMonth: [],
                    monthNames: ['محرّم', 'صفر', 'ربيع الأول', 'ربيع الآخر', 'جمادى الأولى', 'جمادى الآخرة', 'رجب', 'شعبان', 'رمضان', 'شوال', 'ذو القعدة', 'ذو الحجة'],
                    
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
                @click.away="showPicker = false; viewMode = 'days'">

                <label class="block text-xs font-bold text-gray-400 mb-2 font-cairo select-none">تاريخ (التعيين)</label>
                
                <div class="relative group">
                    <input type="text" 
                        readonly
                        x-model="selectedDate"
                        @click="showPicker = !showPicker; viewMode = 'days'"
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
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="absolute z-[9999] bottom-full top-auto mb-3 w-72 bg-[#0b111e] border border-[#1e293b] rounded-xl p-4 shadow-2xl left-1/2 -translate-x-1/2 text-white"
                    x-cloak>
                    
                    <div class="flex items-center justify-between border-b border-[#1e293b]/60 pb-2 mb-3 select-none">
                        <button type="button" 
                                @click="viewMode === 'days' ? prevMonth() : prevYearPage()" 
                                class="p-1 hover:bg-[#162235] rounded-md text-gray-400 hover:text-white transition-colors cursor-pointer">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </button>
                        
                        <div @click="viewMode = viewMode === 'days' ? 'years' : 'days'" 
                            class="flex items-center gap-1 font-bold text-xs text-gray-200 font-cairo cursor-pointer hover:text-blue-400 transition-colors px-2 py-0.5 rounded hover:bg-[#162235]">
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
                                    <span class="font-mono text-gray-400 text-[10px] mr-1">(من <span x-text="availableYears[0]"></span> إلى <span x-text="availableYears[7]"></span>)</span>
                                </div>
                            </template>
                        </div>
                        
                        <button type="button" 
                                @click="viewMode === 'days' ? nextMonth() : nextYearPage()" 
                                class="p-1 hover:bg-[#162235] rounded-md text-gray-400 hover:text-white transition-colors cursor-pointer">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                    </div>

                    <div x-show="viewMode === 'days'">
                        <div class="grid grid-cols-7 gap-1 text-center text-[11px] font-bold text-gray-500 mb-2 select-none w-full" style="display: grid !important; grid-template-columns: repeat(7, minmax(0, 1fr)) !important;">
                            <div class="w-full text-center">ح</div>
                            <div class="w-full text-center">ن</div>
                            <div class="w-full text-center">ث</div>
                            <div class="w-full text-center">ر</div>
                            <div class="w-full text-center">خ</div>
                            <div class="w-full text-center">ج</div>
                            <div class="w-full text-center">س</div>
                        </div>

                        <div class="grid grid-cols-7 gap-1 w-full" style="display: grid !important; grid-template-columns: repeat(7, minmax(0, 1fr)) !important;">
                            <template x-for="day in daysInMonth" :key="day">
                                <button type="button" 
                                        @click="selectDay(day)"
                                        class="block w-full aspect-square text-center p-1 text-xs rounded-lg font-mono text-gray-300 hover:bg-[#2563EB] hover:text-white transition-all cursor-pointer"
                                        :class="selectedDate && selectedDate.startsWith(currentYear + '/' + String(currentMonth + 1).padStart(2, '0') + '/' + String(day).padStart(2, '0')) ? 'bg-[#2563EB] border border-[#2563EB] text-white font-bold' : 'bg-[#101726]/40 border border-[#1e293b]/50'">
                                    <span x-text="day" class="block w-full text-center"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div x-show="viewMode === 'years'" 
                        x-transition
                        class="space-y-2 max-h-64 overflow-y-auto pr-1 scrollbar-thin">
                        
                        <template x-for="year in availableYears" :key="year">
                            <button type="button" 
                                    @click="selectYear(year)"
                                    class="w-full text-center py-2.5 px-4 text-xs font-mono font-bold rounded-xl transition-all duration-200 cursor-pointer block border"
                                    :class="currentYear === year ? 
                                            'bg-[#2563EB] text-white border-[#2563EB] shadow-lg shadow-[#2563EB]/20 scale-[1.01]' : 
                                            'bg-[#101726]/60 text-gray-300 border-[#1e293b]/80 hover:bg-[#162235] hover:text-white hover:border-gray-700'">
                                <span x-text="year" class="tracking-wider"></span>
                            </button>
                        </template>
                    </div>

                    <div class="mt-4 pt-2 border-t border-[#1e293b]/60 flex justify-between items-center select-none">
                        <button type="button" 
                                @click="selectedDate = ''; showPicker = false; viewMode = 'days'" 
                                class="text-[10px] text-rose-400 hover:text-rose-300 font-bold font-cairo px-1 py-0.5 rounded transition-colors cursor-pointer">
                            مسح الحقل
                        </button>
                        <button type="button" 
                                @click="showPicker = false; viewMode = 'days'" 
                                class="text-[10px] text-gray-400 hover:text-gray-200 font-bold font-cairo px-1 py-0.5 rounded transition-colors cursor-pointer">
                            إغلاق
                        </button>
                    </div>
                </div>

                @error('appointment_date') 
                    <span class="text-rose-500 text-xs mt-1.5 block font-cairo font-bold">{{ $message }}</span> 
                @enderror
            </div>

        </div>

        <!-- الشبكة الثانية: التواريخ الإدارية الإضافية -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6" dir="rtl">
            
            <!-- تاريخ التثبيت -->
          <div class="text-right relative block" 
                x-data="{
                    showPicker: false,
                    viewMode: 'days', 
                    selectedDate: @entangle('confirmation_date'),
                    currentYear: 1447,
                    currentMonth: 0,
                    daysInMonth: [],
                    monthNames: ['محرّم', 'صفر', 'ربيع الأول', 'ربيع الآخر', 'جمادى الأولى', 'جمادى الآخرة', 'رجب', 'شعبان', 'رمضان', 'شوال', 'ذو القعدة', 'ذو الحجة'],
                    
                    // ميزة السنوات الديناميكية للتنقل الحر (توليد 8 سنوات حول السنة الحالية)
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

                    // دوال القفز السريع بين السنوات بالأسهم (8 سنوات للخلف أو الأمام)
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
                @click.away="showPicker = false; viewMode = 'days'">

                <label class="block text-xs font-bold text-gray-400 mb-2 font-cairo select-none">تاريخ (التثبيت)</label>
                
                <div class="relative group">
                    <input type="text" 
                        readonly
                        x-model="selectedDate"
                        @click="showPicker = !showPicker; viewMode = 'days'"
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
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="absolute z-[9999] bottom-full top-auto mb-3 w-72 bg-[#0b111e] border border-[#1e293b] rounded-xl p-4 shadow-2xl left-1/2 -translate-x-1/2 text-white"
                    x-cloak>
                    
                    <div class="flex items-center justify-between border-b border-[#1e293b]/60 pb-2 mb-3 select-none">
                        <button type="button" 
                                @click="viewMode === 'days' ? prevMonth() : prevYearPage()" 
                                class="p-1 hover:bg-[#162235] rounded-md text-gray-400 hover:text-white transition-colors cursor-pointer">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </button>
                        
                        <div @click="viewMode = viewMode === 'days' ? 'years' : 'days'" 
                            class="flex items-center gap-1 font-bold text-xs text-gray-200 font-cairo cursor-pointer hover:text-blue-400 transition-colors px-2 py-0.5 rounded hover:bg-[#162235]">
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
                                    <span class="font-mono text-gray-400 text-[10px] mr-1">(من <span x-text="availableYears[0]"></span> إلى <span x-text="availableYears[7]"></span>)</span>
                                </div>
                            </template>
                        </div>
                        
                        <button type="button" 
                                @click="viewMode === 'days' ? nextMonth() : nextYearPage()" 
                                class="p-1 hover:bg-[#162235] rounded-md text-gray-400 hover:text-white transition-colors cursor-pointer">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                    </div>

                    <div x-show="viewMode === 'days'">
                        <div class="grid grid-cols-7 gap-1 text-center text-[11px] font-bold text-gray-500 mb-2 select-none w-full" style="display: grid !important; grid-template-columns: repeat(7, minmax(0, 1fr)) !important;">
                            <div class="w-full text-center">ح</div>
                            <div class="w-full text-center">ن</div>
                            <div class="w-full text-center">ث</div>
                            <div class="w-full text-center">ر</div>
                            <div class="w-full text-center">خ</div>
                            <div class="w-full text-center">ج</div>
                            <div class="w-full text-center">س</div>
                        </div>

                        <div class="grid grid-cols-7 gap-1 w-full" style="display: grid !important; grid-template-columns: repeat(7, minmax(0, 1fr)) !important;">
                            <template x-for="day in daysInMonth" :key="day">
                                <button type="button" 
                                        @click="selectDay(day)"
                                        class="block w-full aspect-square text-center p-1 text-xs rounded-lg font-mono text-gray-300 hover:bg-[#2563EB] hover:text-white transition-all cursor-pointer"
                                        :class="selectedDate && selectedDate.startsWith(currentYear + '/' + String(currentMonth + 1).padStart(2, '0') + '/' + String(day).padStart(2, '0')) ? 'bg-[#2563EB] border border-[#2563EB] text-white font-bold' : 'bg-[#101726]/40 border border-[#1e293b]/50'">
                                    <span x-text="day" class="block w-full text-center"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    <div x-show="viewMode === 'years'" 
                        x-transition
                        class="space-y-2 max-h-64 overflow-y-auto pr-1 scrollbar-thin">
                        
                        <template x-for="year in availableYears" :key="year">
                            <button type="button" 
                                    @click="selectYear(year)"
                                    class="w-full text-center py-2.5 px-4 text-xs font-mono font-bold rounded-xl transition-all duration-200 cursor-pointer block border"
                                    :class="currentYear === year ? 
                                            'bg-[#2563EB] text-white border-[#2563EB] shadow-lg shadow-[#2563EB]/20 scale-[1.01]' : 
                                            'bg-[#101726]/60 text-gray-300 border-[#1e293b]/80 hover:bg-[#162235] hover:text-white hover:border-gray-700'">
                                <span x-text="year" class="tracking-wider"></span>
                            </button>
                        </template>
                    </div>

                    <div class="mt-4 pt-2 border-t border-[#1e293b]/60 flex justify-between items-center select-none">
                        <button type="button" 
                                @click="selectedDate = ''; showPicker = false; viewMode = 'days'" 
                                class="text-[10px] text-rose-400 hover:text-rose-300 font-bold font-cairo px-1 py-0.5 rounded transition-colors cursor-pointer">
                            مسح الحقل
                        </button>
                        <button type="button" 
                                @click="showPicker = false; viewMode = 'days'" 
                                class="text-[10px] text-gray-400 hover:text-gray-200 font-bold font-cairo px-1 py-0.5 rounded transition-colors cursor-pointer">
                            إغلاق
                        </button>
                    </div>
                </div>

                @error('confirmation_date') 
                    <span class="text-rose-500 text-xs mt-1.5 block font-cairo font-bold">{{ $message }}</span> 
                @enderror
            </div>

            <!-- تاريخ الترقية -->
           <div class="text-right relative block" 
    x-data="{
        showPicker: false,
        viewMode: 'days', 
        selectedDate: @entangle('current_promotion_date'),
        currentYear: 1447,
        currentMonth: 0,
        daysInMonth: [],
        monthNames: ['محرّم', 'صفر', 'ربيع الأول', 'ربيع الآخر', 'جمادى الأولى', 'جمادى الآخرة', 'رجب', 'شعبان', 'رمضان', 'شوال', 'ذو القعدة', 'ذو الحجة'],
        
        // ميزة السنوات الديناميكية للتنقل الحر (توليد 8 سنوات حول السنة الحالية)
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

        // دوال القفز السريع بين السنوات بالأسهم (8 سنوات للخلف أو الأمام)
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
    @click.away="showPicker = false; viewMode = 'days'">

    <label class="block text-xs font-bold text-gray-400 mb-2 font-cairo select-none">تاريخ (الترقية)</label>
    
    <div class="relative group">
        <input type="text" 
            readonly
            x-model="selectedDate"
            @click="showPicker = !showPicker; viewMode = 'days'"
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
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute z-[9999] bottom-full top-auto mb-3 w-72 bg-[#0b111e] border border-[#1e293b] rounded-xl p-4 shadow-2xl left-1/2 -translate-x-1/2 text-white"
        x-cloak>
        
        <div class="flex items-center justify-between border-b border-[#1e293b]/60 pb-2 mb-3 select-none">
            <button type="button" 
                    @click="viewMode === 'days' ? prevMonth() : prevYearPage()" 
                    class="p-1 hover:bg-[#162235] rounded-md text-gray-400 hover:text-white transition-colors cursor-pointer">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </button>
            
            <div @click="viewMode = viewMode === 'days' ? 'years' : 'days'" 
                 class="flex items-center gap-1 font-bold text-xs text-gray-200 font-cairo cursor-pointer hover:text-blue-400 transition-colors px-2 py-0.5 rounded hover:bg-[#162235]">
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
                        <span class="font-mono text-gray-400 text-[10px] mr-1">(من <span x-text="availableYears[0]"></span> إلى <span x-text="availableYears[7]"></span>)</span>
                    </div>
                </template>
            </div>
            
            <button type="button" 
                    @click="viewMode === 'days' ? nextMonth() : nextYearPage()" 
                    class="p-1 hover:bg-[#162235] rounded-md text-gray-400 hover:text-white transition-colors cursor-pointer">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
            </button>
        </div>

        <div x-show="viewMode === 'days'">
            <div class="grid grid-cols-7 gap-1 text-center text-[11px] font-bold text-gray-500 mb-2 select-none w-full" style="display: grid !important; grid-template-columns: repeat(7, minmax(0, 1fr)) !important;">
                <div class="w-full text-center">ح</div>
                <div class="w-full text-center">ن</div>
                <div class="w-full text-center">ث</div>
                <div class="w-full text-center">ر</div>
                <div class="w-full text-center">خ</div>
                <div class="w-full text-center">ج</div>
                <div class="w-full text-center">س</div>
            </div>

            <div class="grid grid-cols-7 gap-1 w-full" style="display: grid !important; grid-template-columns: repeat(7, minmax(0, 1fr)) !important;">
                <template x-for="day in daysInMonth" :key="day">
                    <button type="button" 
                            @click="selectDay(day)"
                            class="block w-full aspect-square text-center p-1 text-xs rounded-lg font-mono text-gray-300 hover:bg-[#2563EB] hover:text-white transition-all cursor-pointer"
                            :class="selectedDate && selectedDate.startsWith(currentYear + '/' + String(currentMonth + 1).padStart(2, '0') + '/' + String(day).padStart(2, '0')) ? 'bg-[#2563EB] border border-[#2563EB] text-white font-bold' : 'bg-[#101726]/40 border border-[#1e293b]/50'">
                        <span x-text="day" class="block w-full text-center"></span>
                    </button>
                </template>
            </div>
        </div>

        <div x-show="viewMode === 'years'" 
             x-transition
             class="space-y-2 max-h-64 overflow-y-auto pr-1 scrollbar-thin">
            
            <template x-for="year in availableYears" :key="year">
                <button type="button" 
                        @click="selectYear(year)"
                        class="w-full text-center py-2.5 px-4 text-xs font-mono font-bold rounded-xl transition-all duration-200 cursor-pointer block border"
                        :class="currentYear === year ? 
                                'bg-[#2563EB] text-white border-[#2563EB] shadow-lg shadow-[#2563EB]/20 scale-[1.01]' : 
                                'bg-[#101726]/60 text-gray-300 border-[#1e293b]/80 hover:bg-[#162235] hover:text-white hover:border-gray-700'">
                    <span x-text="year" class="tracking-wider"></span>
                </button>
            </template>
        </div>

        <div class="mt-4 pt-2 border-t border-[#1e293b]/60 flex justify-between items-center select-none">
            <button type="button" 
                    @click="selectedDate = ''; showPicker = false; viewMode = 'days'" 
                    class="text-[10px] text-rose-400 hover:text-rose-300 font-bold font-cairo px-1 py-0.5 rounded transition-colors cursor-pointer">
                ...مسح الحقل
            </button>
            <button type="button" 
                    @click="showPicker = false; viewMode = 'days'" 
                    class="text-[10px] text-gray-400 hover:text-gray-200 font-bold font-cairo px-1 py-0.5 rounded transition-colors cursor-pointer">
                إغلاق
            </button>
        </div>
    </div>

    @error('current_promotion_date') 
        <span class="text-rose-500 text-xs mt-1.5 block font-cairo font-bold">{{ $message }}</span> 
    @enderror
</div>

        </div>

        <!-- أزرار التحكم والإرسال السفليّة -->
        <div class="pt-4 border-t border-[#1F2937] flex items-center justify-end gap-3 font-cairo" dir="rtl">
            <button type="submit" class="bg-[#2563EB] hover:bg-[#1D4ED8] text-white px-5 py-2 rounded-lg text-sm font-semibold shadow-lg shadow-[#2563EB]/20 transition-all cursor-pointer">
                حفظ بيانات الفرد
            </button>
           <a href="{{ route('personnel.index') }}" {{-- استبدل باسم الـ Route الصحيح لجدول الأفراد عندك --}}
            wire:navigate
            class="bg-transparent hover:bg-[#1F2937] text-gray-400 hover:text-white px-4 py-2 rounded-lg text-sm font-medium transition-all cursor-pointer text-center inline-flex items-center justify-center">
                إلغاء الأمر
            </a>
        </div>

    </form>
</div>