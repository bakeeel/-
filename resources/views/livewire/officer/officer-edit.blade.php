
<div>
    @if($isOpen)
      <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
            x-data="{ show: @entangle('isOpen') }"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95">
            
            <div class="bg-gray-900 border border-gray-800 rounded-xl shadow-2xl w-full max-w-4xl overflow-hidden max-h-[90vh] flex flex-col" dir="rtl">
                
                {{-- رأس النافذة --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2 font-cairo">
                        <svg class="w-5 h-5 text-[#2563EB]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        تعديل بيانات الضابط: <span class="text-[#2563EB]">{{ $full_name }}</span>
                    </h3>
                    <button type="button" wire:click="$set('isOpen', false)" class="text-gray-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- جسم النموذج --}}
                <form wire:submit.prevent="update" class="overflow-y-auto p-6 space-y-6 flex-1 text-right">

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
<!-- 000000000000000000000 -->
                    
                    {{-- الصف الأول --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 mb-2 font-cairo">الاسم الكامل</label>
                            <input type="text" wire:model="full_name" class="w-full bg-gray-800/60 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:border-[#2563EB] focus:outline-none">
                            @error('full_name') <span class="text-red-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
                        </div>
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
                        <!-- 1111111111111111111 -->
                   <div x-data="{ 
                        isCustomRank: false, 
                        rankValue: @entangle('rank'),
                        defaultRanks: [
                            'ملازم بحري', 'ملازم أول بحري', 'نقيب بحري', 'رائد بحري', 
                            'مقدم بحري', 'مقدم بحري ركن', 'عقيد بحري', 'عقيد بحري ركن', 
                            'عميد بحري', 'عميد بحري ركن', 'لواء بحري', 'لواء بحري ركن'
                        ]
                    }" 
                    x-init="
                        const checkRank = (value) => {
                            if (value && value !== 'custom' && !defaultRanks.includes(value)) {
                                isCustomRank = true;
                            } else {
                                isCustomRank = false;
                            }
                        };

                        // فحص القيمة فوراً عند إطلاق المودال
                        checkRank(rankValue);

                        // مراقبة القيمة عند تغيرها أو جلبها من الـ Backend لمنع رجوعها فارغة
                        $watch('rankValue', value => {
                            checkRank(value);
                        });
                    }"
                    class="text-right space-y-2">
                    
                    <label class="block text-xs font-medium text-gray-400 mb-2 font-cairo">الرتبة القيادية</label>
                    
                    <div x-show="!isCustomRank">
                        <select x-model="rankValue" 
                                @change="if($event.target.value === 'custom') { isCustomRank = true; rankValue = ''; }"
                                class="w-full bg-[#070B14] border border-[#1F2937] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:border-[#2563EB] focus:outline-none text-right font-cairo">
                            <option value="">اختر الرتبة...</option>
                            
                            <option value="ملازم بحري">ملازم بحري</option>
                            <option value="ملازم أول بحري">ملازم أول بحري</option>
                            <option value="نقيب بحري">نقيب بحري</option>
                            <option value="رائد بحري">رائد بحري</option>
                            <option value="مقدم بحري">مقدم بحري</option>
                            <option value="مقدم بحري ركن">مقدم بحري ركن</option>
                            <option value="عقيد بحري">عقيد بحري</option>
                            <option value="عقيد بحري ركن">عقيد بحري ركن</option>
                            <option value="عميد بحري">عميد بحري</option>
                            <option value="عميد بحري ركن">عميد بحري ركن</option>
                            <option value="لواء بحري">لواء بحري</option>
                            <option value="لواء بحري ركن">لواء بحري ركن</option>

                            <template x-if="rankValue && !defaultRanks.includes(rankValue) && rankValue !== 'custom'">
                                <option :value="rankValue" x-text="rankValue" selected class="hidden"></option>
                            </template>

                            <option value="custom" class="text-[#2563EB] font-bold bg-[#111827]">➕ رتبة أخرى (إدخال يدوي)...</option>
                        </select>
                    </div>

                    <div x-show="isCustomRank" x-cloak class="relative flex items-center gap-2">
                        <input type="text" 
                            x-model="rankValue" 
                            placeholder="اكتب الرتبة المستجدة يدوياً هنا..." 
                            class="w-full bg-[#070B14] border border-[#2563EB] rounded-lg text-sm px-3 py-2 text-[#E5E7EB] focus:outline-none text-right font-cairo placeholder:text-gray-600" />
                        
                        <button type="button" 
                                @click="isCustomRank = false; rankValue = '';" 
                                class="bg-[#1F2937] hover:bg-[#374151] border border-[#374151] text-xs text-gray-300 px-3 py-2 rounded-lg font-cairo transition-all shrink-0">
                            رجوع للقائمة
                        </button>
                    </div>

                    @error('rank') <span class="text-rose-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
                </div>
                    <!-- 11111111111111111 -->

                    </div>

                    {{-- الصف الثاني --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 mb-2 font-cairo">التخصص الأساسي</label>
                            <input type="text" wire:model="specialty" class="w-full bg-gray-800/60 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:border-[#2563EB] focus:outline-none">
                            @error('specialty') <span class="text-red-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 mb-2 font-cairo">رقم التواصل المباشر</label>
                            <input type="tel" 
                                maxlength="10" 
                                wire:model="phone" 
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                placeholder="05xxxxxxxx"
                                class="w-full bg-gray-800/60 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:border-[#2563EB] focus:outline-none font-mono tracking-wider" dir="ltr">
                            @error('phone') <span class="text-red-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 mb-2 font-cairo">الحالة القيادية</label>
                            <select wire:model="status" class="w-full bg-gray-800/60 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:border-[#2563EB] focus:outline-none">
                             <option value="نشط">نشط</option>
                            <option value="غياب">غياب</option>
                            <option value="إجازة">إجازة</option>
                            <option value="تأخير">تأخير</option>
                            <option value="إذن">إذن</option>
                            <option value="مسلم">مسلم</option>
                            <option value="دورة">دورة</option>
                            </select>
                            @error('status') <span class="text-red-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
                        </div>
                    </div>

                   {{-- الصف الثالث (التواريخ والخدمة البحرية) --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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

                        {{-- التعديل هنا: تم تغيير bottom-full إلى top-auto و top-auto إلى mt-2 ليفتح لأسفل --}}
                        <div x-show="showPicker" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95"
                            class="absolute z-[9999] top-full bottom-auto mt-2 w-72 bg-[#0b111e] border border-[#1e293b] rounded-xl p-4 shadow-2xl left-1/2 -translate-x-1/2 text-white"
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
<!-- 000000000000000000000000000 -->

                        {{-- أيام الإبحار المضافة --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 mb-2 font-cairo">أيام الإبحار والقيادة</label>
                            <div class="relative flex items-center">
                                <input type="number" min="0" wire:model="sailing_days" class="w-full bg-gray-800/60 border border-gray-700 rounded-lg pl-3 pr-20 py-2 text-white text-sm focus:border-[#2563EB] focus:outline-none font-mono text-left" dir="ltr">
                                <span class="absolute right-3 text-[11px] text-gray-500 font-cairo font-bold pointer-events-none select-none border-l border-gray-700 pl-2 h-4 flex items-center">
                                    أيام بحرية
                                </span>
                            </div>
                            @error('sailing_days') <span class="text-red-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
                        </div>

                        {{-- ساعات الإبحار --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-400 mb-2 font-cairo">ساعات الإبحار </label>
                            <div class="relative flex items-center">
                                <input type="number" min="0" wire:model="sailing_hours" class="w-full bg-gray-800/60 border border-gray-700 rounded-lg pl-3 pr-20 py-2 text-white text-sm focus:border-[#2563EB] focus:outline-none font-mono text-left" dir="ltr">
                                <span class="absolute right-3 text-[11px] text-gray-500 font-cairo font-bold pointer-events-none select-none border-l border-gray-700 pl-2 h-4 flex items-center">
                                    ساعة بحرية
                                </span>
                            </div>
                            @error('sailing_hours') <span class="text-red-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
                        </div>
                    </div>

                   

                    {{-- الملاحظات القيادية --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 mb-2 font-cairo">ملاحظات القيادة أو التوصيات العسكرية</label>
                        <textarea wire:model="notes" rows="3" class="w-full bg-gray-800/60 border border-gray-700 rounded-lg px-3 py-2 text-white text-sm focus:border-[#2563EB] focus:outline-none resize-none font-cairo" placeholder="أدخل أي ملاحظات قيادية..."></textarea>
                        @error('notes') <span class="text-red-500 text-xs mt-1 block font-cairo">{{ $message }}</span> @enderror
                    </div>

                    {{-- الأزرار --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-800 font-cairo">
                        <button type="button" wire:click="$set('isOpen', false)" class="px-4 py-2 bg-gray-800 text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-700 transition">
                            إلغاء الأمر
                        </button>
                        <button type="submit" wire:loading.attr="disabled" class="px-5 py-2 bg-[#2563EB] hover:bg-[#1d4ed8] text-white rounded-lg text-sm font-medium transition flex items-center gap-2 disabled:opacity-50">
                            <svg wire:loading wire:target="update" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="update">حفظ التعديلات</span>
                            <span wire:loading wire:target="update">جاري الحفظ والتوثيق...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>