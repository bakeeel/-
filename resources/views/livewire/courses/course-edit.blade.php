<div class="max-w-4xl mx-auto space-y-6 font-cairo text-right" dir="rtl">
    
    <div class="flex items-center justify-between border-b border-[#1F2937] pb-5">
        <div>
            <h1 class="text-2xl font-bold text-[#E5E7EB] tracking-wide">جناح التدريب المركزي // تعديل وثيقة البرنامج</h1>
            <p class="text-sm text-gray-400 mt-1">تحديث وتصحيح تفاصيل السجل التدريبي العسكري للحقيبة الحالية</p>
        </div>
        <div>
            <a href="{{ route('courses.index') }}" wire:navigate 
               class="inline-flex items-center gap-2 bg-[#1F2937] hover:bg-gray-800 border border-[#374151] text-gray-300 px-4 py-2 rounded-xl text-sm font-medium transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m7 7l-7-7 7-7"></path>
                </svg>
                <span>العودة للكشف</span>
            </a>
        </div>
    </div>

    <form wire:submit.prevent="update" class="bg-[#111827] border border-[#1F2937] rounded-2xl p-6 shadow-2xl space-y-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">اسم الدورة التدريبية</label>
                <input type="text" wire:model="name" 
                       class="w-full bg-[#070B14] border border-[#1F2937] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#2563EB] transition placeholder-gray-600" 
                       placeholder="مثال: التخطيط العملياتي والمناورات الميدانية">
                @error('name') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">رقم وثيقة السجل (الكود التكتيكي)</label>
                <input type="text" wire:model="certificate_number" 
                          readonly
                       class="w-full bg-[#070B14] border border-[#1F2937] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#2563EB] transition font-mono" 
                       placeholder="CRS-TAC-01">
                @error('certificate_number') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
            
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">الجهة المانحة والقائمة بالتدريب</label>
                <input type="text" wire:model="location"
                       class="w-full bg-[#070B14] border border-[#1F2937] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#2563EB] transition" 
                       placeholder="مثال: مركز التدريب التخصصي">
                @error('location') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">تصنيف البرنامج التدريبي</label>
                <select wire:model="type" class="w-full bg-[#070B14] border border-[#1F2937] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#2563EB] transition">
                    <option value="تطويرية"> تطويرية</option>
                        <option value="تأسيسية"> تأسيسية</option>
                        <option value="متقدمة">متقدمة </option>
                        <option value="تأهيلية">تأهيلية </option>
                </select>
                @error('type') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
            </div>
           
           

            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">الحالة التشغيلية الحالية</label>
                <select wire:model="status" class="w-full bg-[#070B14] border border-[#1F2937] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#2563EB] transition font-cairo" dir="rtl">
                <option value="قيد الانتظار">قيد الانتظار (قادمة)</option>
                <option value="مستمرة حالياً">مستمرة حالياً (في الميدان)</option>
                <option value="مكتملة ومؤرشفة">مكتملة ومؤرشفة</option>
                <option value="ملغاة">ملغاة</option>
            </select>
                @error('status') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">إجمالي مدة البرنامج (بالأيام)</label>
                <input type="number" wire:model="duration_days" 
                       class="w-full bg-[#070B14] border border-[#1F2937] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#2563EB] transition font-mono" 
                       placeholder="مثال: 20">
                @error('duration_days') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
            </div>

        </div>

        <div class="pt-4 border-t border-[#1F2937] flex items-center justify-end gap-3">
            <a href="{{ route('courses.index') }}" wire:navigate 
               class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-400 hover:text-white transition">
                إلغاء الأمر
            </a>
            <button type="submit" wire:loading.attr="disabled"
                    class="inline-flex items-center gap-2 bg-[#2563EB] hover:bg-[#1d4ed8] text-white px-6 py-2.5 rounded-xl text-sm font-medium transition shadow-lg shadow-[#2563EB]/20 disabled:opacity-50">
                
                <span wire:loading wire:target="update" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                <span wire:loading.remove wire:target="update">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </span>
                <span>تحديث وتعديل وثيقة البيانات</span>
            </button>
        </div>

    </form>
</div>