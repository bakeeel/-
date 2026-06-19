<div class="p-6 bg-slate-900 min-h-screen text-slate-100" x-data="{ openModal: false }">
    
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4 border-b border-slate-800 pb-5">
        <div>
            <h1 class="text-2xl font-bold text-white flex items-center gap-2">
                <svg class="w-7 h-7 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                منظومة ترشيح وإسناد الدورات الشاملة
            </h1>
        </div>
        
        <button wire:click="exportToExcel" class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold py-2 px-4 rounded-lg shadow transition duration-200 text-sm">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            تصدير الكشف الحالي (Excel)
        </button>
    </div>

    @if (session()->has('message'))
        <div x-data="{ show: true }" 
            x-init="setTimeout(() => show = false, 4000)" 
            x-show="show"
            x-transition:leave="transition ease-in duration-500"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="mb-5 p-4 bg-emerald-950/40 border border-emerald-500/50 text-emerald-300 rounded-xl flex items-center gap-2 text-sm shadow-lg">
            
            <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 bg-slate-800/40 p-4 rounded-xl border border-slate-700/50 items-center">
        <div>
            <label class="block text-xs font-semibold text-slate-400 mb-2">فئة المستعلم عنه والتحكم ببياناته:</label>
            <div class="flex bg-slate-950 p-1 rounded-lg border border-slate-800">
                <button wire:click="$set('user_type', 'officer')" class="flex-1 py-2 text-xs rounded-md transition font-bold {{ $user_type === 'officer' ? 'bg-blue-600 text-white shadow' : 'text-slate-400 hover:text-white' }}">قائمة الضباط</button>
                <button wire:click="$set('user_type', 'personnel')" class="flex-1 py-2 text-xs rounded-md transition font-bold {{ $user_type === 'personnel' ? 'bg-blue-600 text-white shadow' : 'text-slate-400 hover:text-white' }}">قائمة الأفراد</button>
                <button wire:click="$set('user_type', 'trainee')" class="flex-1 py-2 text-xs rounded-md transition font-bold {{ $user_type === 'trainee' ? 'bg-blue-600 text-white shadow' : 'text-slate-400 hover:text-white' }}">قائمة المتدربين</button>
            </div>
        </div>

        <div class="md:col-span-2">
            <label class="block text-xs font-semibold text-slate-400 mb-2">البحث الذكي في القوائم المتاحة:</label>
            <div class="relative">
                <input type="text" wire:model.live="search" placeholder="ابحث الآن بالاسم الكامل أو الرقم العسكري العائد للفئة المختارة..." class="w-full bg-slate-950 border border-slate-700/80 rounded-lg pr-10 pl-4 py-2 text-sm text-white focus:outline-none focus:border-blue-500 transition placeholder-slate-500">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- 1. جدول الكادر الحالي المتاح --}}
    <div class="bg-slate-800/30 border border-slate-700/60 rounded-xl overflow-hidden mb-8 shadow-sm">
        <div class="p-4 bg-slate-800/80 border-b border-slate-700 flex justify-between items-center">
            <h3 class="text-sm font-bold text-slate-200 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                1. كادر الفئة الحالية المتاحين للإسناد والترشيح الفوري
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-950/40 border-b border-slate-700 text-xs text-slate-400 font-bold uppercase">
                        <th class="p-4">الرقم العسكري / الهوية</th>
                        <th class="p-4">الاسم الكامل للمنسوب</th>
                        <th class="p-4">الرتبة أو التصنيف بالنظام</th>
                        <th class="p-4 text-center">عملية الترشيح</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-700/40">
                    @forelse($candidates as $candidate)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="p-4 font-mono text-emerald-400 font-semibold">{{ $candidate->military_id ?? $candidate->identity_number }}</td>
                            <td class="p-4 font-bold text-slate-200">{{ $candidate->full_name ?? $candidate->name }}</td>
                            <td class="p-4 text-slate-400 text-xs">{{ $candidate->rank && $candidate->rank !== '' ? $candidate->rank : 'تحت التدريب' }}</td>
                            <td class="p-4 text-center">
                                <button wire:click="openNominateModal({{ $candidate->id }})" @click="openModal = true" class="text-xs font-bold bg-blue-600/10 text-blue-400 border border-blue-500/20 hover:bg-blue-600 hover:text-white px-3 py-1.5 rounded-lg transition shadow-sm">
                                    + ترشيح لدورة 
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-500 text-sm">لا يوجد منسوبين متاحين للترشيح حالياً.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($candidates->hasPages())
            <div class="p-4 bg-slate-950/20 border-t border-slate-700">{{ $candidates->links() }}</div>
        @endif
    </div>

    {{-- 2. جدول لوحة التحكم وإدارة الحالات --}}
    <div class="bg-slate-800/30 border border-slate-700/60 rounded-xl overflow-hidden shadow-sm">
        <div class="p-4 bg-slate-800/80 border-b border-slate-700">
            <h3 class="text-sm font-bold text-amber-400 flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
                2. لوحة التحكم وإدارة الحالات للدورات المرشحين عليها حالياً
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="bg-slate-950/40 border-b border-slate-700 text-xs text-slate-400 font-bold">
                        <th class="p-4">بيانات المنسوب</th>
                        <th class="p-4">الدورة التدريبية المسندة</th>
                        <th class="p-4">تاريخ البداية</th>
                        <th class="p-4">تاريخ الانتهاء</th>
                        <th class="p-4">الحالة الإدارية الحالية</th>
                        <th class="p-4 text-center">إجراءات التحكم</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-slate-700/40">
                    @forelse($nominations as $nom)
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="p-4">
                                <div class="font-bold text-white">{{ $nom->user_name }}</div>
                                <div class="text-xs text-slate-500 font-mono mt-0.5">{{ $nom->military_id }}</div>
                            </td>
                            <td class="p-4 font-semibold text-slate-300">
                                {{ $nom->course_name }}
                               @if(!empty($nom->location))
                                    <div class="text-[11px] text-slate-400 mt-0.5">الجهة: {{ $nom->location }}</div>
                                @endif
                            </td>
                            <td class="p-4 font-mono text-slate-400 text-xs">{{ $nom->start_date ?? '—' }}</td>
                            <td class="p-4 font-mono text-slate-400 text-xs">{{ $nom->end_date ?? '—' }}</td>
                            <td class="p-4">
                               <span class="px-2.5 py-1 rounded-full text-xs font-bold shadow-sm inline-block
                            {{ $nom->status === 'مستمر في الدورة' ? 'bg-blue-950 text-blue-400 border border-blue-800/60' : '' }}
                            {{ in_array($nom->status, ['أكمل الدورة', 'تم الترشيح', 'تعميد للتحضير']) ? 'bg-emerald-950 text-emerald-400 border border-emerald-800/60' : '' }}
                            {{ $nom->status === 'إسقاط من الدورة' ? 'bg-rose-950 text-rose-400 border border-rose-800/60' : '' }}">
                            • {{ $nom->status }}
                        </span>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-center gap-3">
                                    <button wire:click="openEditModal({{ $nom->id }})" @click="openModal = true" class="text-amber-400 hover:text-amber-300 transition flex items-center gap-1 text-xs font-bold bg-amber-500/10 border border-amber-500/20 px-2 py-1 rounded-md">
                                        تعديل 
                                    </button>
                                    <button onclick="confirm('هل أنت متأكد؟') || event.stopImmediatePropagation()" wire:click="deleteNomination({{ $nom->id }})" class="text-rose-400 hover:text-rose-300 transition flex items-center gap-1 text-xs font-bold bg-rose-500/10 border border-rose-500/20 px-2 py-1 rounded-md">
                                        إلغاء الترشيح
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500 text-sm">لا توجد سجلات ترشيح مسجلة حالياً.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- الـ المودال الرئيسي الشامل --}}
    <div x-show="openModal" 
         @open-modal.window="if(Array.isArray($event.detail) ? $event.detail.includes('nomination-modal') : $event.detail === 'nomination-modal' || $event.detail.name === 'nomination-modal') openModal = true" 
         @close-modal.window="openModal = false" 
         class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto bg-black/70 backdrop-blur-sm" 
         x-cloak>
        
        <div class="bg-slate-800 border border-slate-700 w-full max-w-md p-6 rounded-xl shadow-2xl" @click.away="openModal = false">
            <h3 class="text-base font-bold text-white mb-4 border-b border-slate-700 pb-2 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full {{ $is_edit_mode ? 'bg-amber-500' : 'bg-blue-500' }}"></span>
                {{ $is_edit_mode ? 'تعديل تفاصيل وحالة الترشيح للدورة' : 'إسناد استمارة ترشيح جديدة' }}
            </h3>
            
            <form wire:submit.prevent="saveNomination" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1.5">الدورة التدريبية المستهدفة:</label>
                    <select wire:model.live="course_id" class="w-full bg-slate-950 border border-slate-700 text-white text-sm rounded-lg p-2.5 focus:border-blue-500 focus:outline-none">
                        <option value="">-- اختر الدورة     --</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                    @error('course_id') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div wire:key="location-field-{{ $course_id ?? 'empty' }}">
                        <label class="block text-xs font-bold text-gray-400 mb-1.5">الجهة المنفذة :</label>
                        <input type="text" 
                            wire:model="location" 
                            placeholder="اكتب اسم الجهة المنفذة هنا..."
                            class="w-full bg-slate-950/60 border border-slate-800 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 rounded-lg text-sm px-3 py-2 text-slate-200 font-medium outline-none transition-all">
                        
                        @error('location') 
                            <span class="text-rose-500 text-xs mt-1 block font-bold">{{ $message }}</span> 
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-1.5">حالة الدورة التدريبية:</label>
                        <select wire:model="status" class="w-full bg-slate-950 border border-slate-700 text-white text-sm rounded-lg p-2.5 focus:border-blue-500 focus:outline-none">
                          <option value="مستمر في الدورة">مستمر في الدورة</option>
                            <option value="أكمل الدورة">أكمل الدورة</option>
                            <option value="إسقاط من الدورة">إسقاط من الدورة</option>
                            <option value="تم الترشيح">تم الترشيح</option>
                            <option value="تعميد للتحضير">تعميد للتحضير</option>    
                        </select>
                        @error('status') <span class="text-rose-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full" dir="rtl">
                        
                        {{-- 1. حقل تاريخ بداية الدورة --}}
                        <div wire:key="start-date-field-{{ $current_pivot_id ?? $selected_model_id ?? 'new' }}"
                            class="relative text-right font-cairo" 
                            x-data="{
                                showPicker: false,
                                showYearGrid: false,
                                selectedDate: @entangle('start_date'),
                                currentYear: 1447,
                                currentMonth: 0,
                                daysInMonth: [],
                                monthNames: ['محرّم', 'صفر', 'ربيع الأول', 'ربيع الآخر', 'جمادى الأولى', 'جمادى الآخرة', 'رجب', 'شعبان', 'رمضان', 'شوال', 'ذو القعدة', 'ذو الحجة'],
                                
            init() {
                this.parseDate();
                this.generateCalendar();
                this.$watch('currentMonth', () => this.generateCalendar());
                this.$watch('currentYear', () => this.generateCalendar());
            },

            parseDate() {
                if (this.selectedDate) {
                    const parts = this.selectedDate.split('/');
                    if (parts.length === 3) {
                        this.currentYear = parseInt(parts[0]);
                        this.currentMonth = parseInt(parts[1]) - 1;
                        return;
                    }
                }
                this.setToCurrentHijri();
            },

            setToCurrentHijri() {
                try {
                    const now = new Date();
                    const yearStr = now.toLocaleDateString('en-US-u-ca-islamic-umalqura', { year: 'numeric' });
                    const monthStr = now.toLocaleDateString('en-US-u-ca-islamic-umalqura', { month: 'numeric' });
                    this.currentYear = parseInt(yearStr.replace(/\D/g, '')) || 1447;
                    this.currentMonth = (parseInt(monthStr.replace(/\D/g, '')) || 1) - 1;
                } catch(e) {
                    this.currentYear = 1447;
                    this.currentMonth = 0;
                }
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
            },
            
            nextMonth() {
                if (this.currentMonth === 11) {
                    this.currentMonth = 0;
                    this.currentYear++;
                } else {
                    this.currentMonth++;
                }
            },
            
            selectDay(day) {
                const monthStr = String(this.currentMonth + 1).padStart(2, '0');
                const dayStr = String(day).padStart(2, '0');
                this.selectedDate = `${this.currentYear}/${monthStr}/${dayStr}`;
                this.showPicker = false;
            },

            clearField() {
                this.selectedDate = null;
                this.showPicker = false;
                this.showYearGrid = false;
            }
        }"
        @click.outside="showPicker = false; showYearGrid = false">

        <label class="block text-xs font-bold text-gray-400 mb-2 select-none">تاريخ بداية الدورة:</label>
        
        <div class="relative flex items-center cursor-pointer bg-[#070B14] border border-[#1F2937] rounded-lg p-2.5 hover:border-gray-600 focus-within:border-[#2563EB] focus-within:ring-1 focus-within:ring-[#2563EB]/30 transition-all" 
             @click.stop="showPicker = !showPicker; if(!showPicker) showYearGrid = false">
            
            <div class="text-gray-500 ml-2.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>

            <input type="text" 
                readonly
                x-model="selectedDate"
                placeholder="1447/01/01"
                dir="ltr"
                class="w-full bg-transparent text-sm text-right text-white outline-none cursor-pointer font-mono tracking-wider" />
        </div>

        <div x-show="showPicker" 
            x-transition 
            @click.stop
            class="absolute right-0 mt-1.5 w-72 bg-[#0F172A] border border-[#1F2937] rounded-xl shadow-2xl p-3.5 z-[9999]" 
            x-cloak>
            
            <div x-show="showYearGrid">
                <div class="flex items-center justify-between mb-3 text-white text-xs font-bold select-none">
                    <button type="button" @click.stop="currentYear -= 8" class="p-1 hover:bg-gray-800 rounded transition-colors text-gray-400 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <span class="bg-[#1E293B] px-2.5 py-1 rounded text-[#38BDF8]">اختر السنة الهجرية</span>
                    <button type="button" @click.stop="currentYear += 8" class="p-1 hover:bg-gray-800 rounded transition-colors text-gray-400 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                </div>
                
                <div class="grid grid-cols-2 gap-1.5 mb-3 font-mono" dir="rtl">
                    <template x-for="offset in [-4, -3, -2, -1, 0, 1, 2, 3]" :key="offset">
                        <button type="button"
                            @click.stop="currentYear = (currentYear + offset); showYearGrid = false"
                            class="py-1.5 rounded-lg text-center text-xs transition-all border font-bold"
                            :class="currentYear === (currentYear + offset) ? 'bg-[#2563EB] text-white border-[#2563EB] shadow-md shadow-[#2563EB]/20' : 'bg-[#070B14] text-gray-300 border-[#1F2937] hover:border-gray-600'">
                            <span x-text="currentYear + offset"></span>
                        </button>
                    </template>
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-[#1F2937] text-xs font-bold select-none">
                    <button type="button" @click.stop="clearField()" class="text-rose-400 hover:text-rose-300 transition-colors">مسح</button>
                    <button type="button" @click.stop="showYearGrid = false" class="text-gray-400 hover:text-white transition-colors">إلغاء</button>
                </div>
            </div>

            <div x-show="!showYearGrid">
                <div class="flex items-center justify-between mb-3 text-white text-xs font-bold select-none">
                    <button type="button" @click.stop="prevMonth()" class="p-1 hover:bg-gray-800 rounded transition-colors text-gray-400 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <button type="button" @click.stop="showYearGrid = true" class="px-2 py-0.5 hover:bg-gray-800 rounded transition-colors text-[#38BDF8] flex items-center gap-1">
                        <span x-text="monthNames[currentMonth] + ' ' + currentYear"></span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <button type="button" @click.stop="nextMonth()" class="p-1 hover:bg-gray-800 rounded transition-colors text-gray-400 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                </div>

                <div class="grid grid-cols-7 gap-1 text-center text-xs text-gray-400 font-mono mb-3" dir="rtl">
                    <template x-for="day in daysInMonth" :key="day">
                        <button type="button" 
                                @click.stop="selectDay(day)" 
                                class="w-8 h-8 flex items-center justify-center mx-auto rounded-md hover:bg-[#2563EB] hover:text-white transition-colors"
                                :class="selectedDate && selectedDate.endsWith('/' + String(day).padStart(2, '0')) && selectedDate.includes('/' + String(currentMonth+1).padStart(2, '0') + '/') && selectedDate.startsWith(currentYear) ? 'bg-[#2563EB] text-white font-bold' : 'text-gray-300'"
                                x-text="day"></button>
                    </template>
                </div>

                <div class="text-left pt-2 border-t border-[#1F2937] text-xs font-bold select-none">
                    <button type="button" @click.stop="clearField()" class="text-rose-400 hover:text-rose-300 transition-colors">مسح الحقل</button>
                </div>
            </div>

        </div>

        @error('start_date') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
    </div>

    {{-- 2. حقل تاريخ نهاية الدورة --}}
    <div wire:key="end-date-field-{{ $current_pivot_id ?? $selected_model_id ?? 'new' }}"
        class="relative text-right font-cairo" 
        x-data="{
            showPicker: false,
            showYearGrid: false,
            selectedDate: @entangle('end_date'),
            currentYear: 1447,
            currentMonth: 0,
            daysInMonth: [],
            monthNames: ['محرّم', 'صفر', 'ربيع الأول', 'ربيع الآخر', 'جمادى الأولى', 'جمادى الآخرة', 'رجب', 'شعبان', 'رمضان', 'شوال', 'ذو القعدة', 'ذو الحجة'],
            
            init() {
                this.parseDate();
                this.generateCalendar();
                this.$watch('currentMonth', () => this.generateCalendar());
                this.$watch('currentYear', () => this.generateCalendar());
            },

            parseDate() {
                if (this.selectedDate) {
                    const parts = this.selectedDate.split('/');
                    if (parts.length === 3) {
                        this.currentYear = parseInt(parts[0]);
                        this.currentMonth = parseInt(parts[1]) - 1;
                        return;
                    }
                }
                this.setToCurrentHijri();
            },

            setToCurrentHijri() {
                try {
                    const now = new Date();
                    const yearStr = now.toLocaleDateString('en-US-u-ca-islamic-umalqura', { year: 'numeric' });
                    const monthStr = now.toLocaleDateString('en-US-u-ca-islamic-umalqura', { month: 'numeric' });
                    this.currentYear = parseInt(yearStr.replace(/\D/g, '')) || 1447;
                    this.currentMonth = (parseInt(monthStr.replace(/\D/g, '')) || 1) - 1;
                } catch(e) {
                    this.currentYear = 1447;
                    this.currentMonth = 0;
                }
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
            },
            
            nextMonth() {
                if (this.currentMonth === 11) {
                    this.currentMonth = 0;
                    this.currentYear++;
                } else {
                    this.currentMonth++;
                }
            },
            
            selectDay(day) {
                const monthStr = String(this.currentMonth + 1).padStart(2, '0');
                const dayStr = String(day).padStart(2, '0');
                this.selectedDate = `${this.currentYear}/${monthStr}/${dayStr}`;
                this.showPicker = false;
            },

            clearField() {
                this.selectedDate = null;
                this.showPicker = false;
                this.showYearGrid = false;
            }
        }"
        @click.outside="showPicker = false; showYearGrid = false">

        <label class="block text-xs font-bold text-gray-400 mb-2 select-none">تاريخ نهاية الدورة:</label>
        
        <div class="relative flex items-center cursor-pointer bg-[#070B14] border border-[#1F2937] rounded-lg p-2.5 hover:border-gray-600 focus-within:border-[#2563EB] focus-within:ring-1 focus-within:ring-[#2563EB]/30 transition-all" 
             @click.stop="showPicker = !showPicker; if(!showPicker) showYearGrid = false">
            
            <div class="text-gray-500 ml-2.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>

            <input type="text" 
                readonly
                x-model="selectedDate"
                placeholder="1447/01/01"
                dir="ltr"
                class="w-full bg-transparent text-sm text-right text-white outline-none cursor-pointer font-mono tracking-wider" />
        </div>

        <div x-show="showPicker" 
            x-transition 
            @click.stop
            class="absolute right-0 mt-1.5 w-72 bg-[#0F172A] border border-[#1F2937] rounded-xl shadow-2xl p-3.5 z-[9999]" 
            x-cloak>
            
            <div x-show="showYearGrid">
                <div class="flex items-center justify-between mb-3 text-white text-xs font-bold select-none">
                    <button type="button" @click.stop="currentYear -= 8" class="p-1 hover:bg-gray-800 rounded transition-colors text-gray-400 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <span class="bg-[#1E293B] px-2.5 py-1 rounded text-[#38BDF8]">اختر السنة الهجرية</span>
                    <button type="button" @click.stop="currentYear += 8" class="p-1 hover:bg-gray-800 rounded transition-colors text-gray-400 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                </div>
                
                <div class="grid grid-cols-2 gap-1.5 mb-3 font-mono" dir="rtl">
                    <template x-for="offset in [-4, -3, -2, -1, 0, 1, 2, 3]" :key="offset">
                        <button type="button"
                            @click.stop="currentYear = (currentYear + offset); showYearGrid = false"
                            class="py-1.5 rounded-lg text-center text-xs transition-all border font-bold"
                            :class="currentYear === (currentYear + offset) ? 'bg-[#2563EB] text-white border-[#2563EB] shadow-md shadow-[#2563EB]/20' : 'bg-[#070B14] text-gray-300 border-[#1F2937] hover:border-gray-600'">
                            <span x-text="currentYear + offset"></span>
                        </button>
                    </template>
                </div>

                <div class="flex items-center justify-between pt-2 border-t border-[#1F2937] text-xs font-bold select-none">
                    <button type="button" @click.stop="clearField()" class="text-rose-400 hover:text-rose-300 transition-colors">مسح</button>
                    <button type="button" @click.stop="showYearGrid = false" class="text-gray-400 hover:text-white transition-colors">إلغاء</button>
                </div>
            </div>

            <div x-show="!showYearGrid">
                <div class="flex items-center justify-between mb-3 text-white text-xs font-bold select-none">
                    <button type="button" @click.stop="prevMonth()" class="p-1 hover:bg-gray-800 rounded transition-colors text-gray-400 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <button type="button" @click.stop="showYearGrid = true" class="px-2 py-0.5 hover:bg-gray-800 rounded transition-colors text-[#38BDF8] flex items-center gap-1">
                        <span x-text="monthNames[currentMonth] + ' ' + currentYear"></span>
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <button type="button" @click.stop="nextMonth()" class="p-1 hover:bg-gray-800 rounded transition-colors text-gray-400 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                </div>

                <div class="grid grid-cols-7 gap-1 text-center text-xs text-gray-400 font-mono mb-3" dir="rtl">
                    <template x-for="day in daysInMonth" :key="day">
                        <button type="button" 
                                @click.stop="selectDay(day)" 
                                class="w-8 h-8 flex items-center justify-center mx-auto rounded-md hover:bg-[#2563EB] hover:text-white transition-colors"
                                :class="selectedDate && selectedDate.endsWith('/' + String(day).padStart(2, '0')) && selectedDate.includes('/' + String(currentMonth+1).padStart(2, '0') + '/') && selectedDate.startsWith(currentYear) ? 'bg-[#2563EB] text-white font-bold' : 'text-gray-300'"
                                x-text="day"></button>
                    </template>
                </div>

                <div class="text-left pt-2 border-t border-[#1F2937] text-xs font-bold select-none">
                    <button type="button" @click.stop="clearField()" class="text-rose-400 hover:text-rose-300 transition-colors">مسح الحقل</button>
                </div>
            </div>

        </div>

        @error('end_date') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
    </div>

</div>          
                <div class="flex justify-end gap-2 pt-4 border-t border-slate-700 mt-5">
                    <button type="button" @click="openModal = false" class="bg-slate-700 hover:bg-slate-600 text-xs font-bold py-2 px-4 rounded-lg text-slate-200 transition">إلغاء</button>
                    <button type="submit" class="text-xs font-bold py-2 px-4 rounded-lg text-white transition {{ $is_edit_mode ? 'bg-amber-600 hover:bg-amber-500' : 'bg-blue-600 hover:bg-blue-500' }}">
                        {{ $is_edit_mode ? 'تحديث وتأكيد البيانات' : 'حفظ الترشيح الفوري' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>