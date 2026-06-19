<div class="max-w-4xl mx-auto space-y-6 font-cairo text-right" dir="rtl">
    <div class="flex items-center justify-between border-b border-[#1F2937] pb-5">
        <div>
            <h1 class="text-2xl font-bold text-[#E5E7EB] tracking-wide">تسجيل دورة تدريبية جديدة</h1>
        </div>
        <div class="bg-[#2563EB]/10 border border-[#2563EB]/20 text-[#2563EB] px-3 py-1 rounded-full text-xs font-semibold font-cairo">
            جناح الدورات
        </div>
        <a href="{{ route('courses.index') }}" wire:navigate class="text-sm text-gray-400 hover:text-white transition flex items-center gap-1.5 bg-[#111827] border border-[#1F2937] px-3 py-2 rounded-xl">
            <span>إلغاء والعودة</span>
        </a>
    </div>

    <form wire:submit.prevent="save" class="bg-[#111827] border border-[#1F2937] rounded-xl shadow-2xl overflow-hidden">
        <div class="p-6 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-2">كود  الدورة</label>
                    <input type="text" 
                           wire:model="certificate_number" 
                           readonly 
                           class="w-full bg-[#111827] border border-[#1F2937] rounded-lg text-sm px-3 py-2 font-mono text-emerald-400 font-bold focus:outline-none cursor-not-allowed opacity-80" 
                           placeholder="جاري توليد الكود...">
                    @error('certificate_number') <span class="text-rose-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">اسم الدورة  </label>
                    <input type="text" wire:model="name" placeholder="مثال: الأمن السيبراني وحماية البنية التحتية" 
                           class="w-full bg-[#070B14] border border-[#1F2937] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#2563EB] transition">
                    @error('name') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                </div>
                 <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">تصنيف الدورة</label>
                    <select wire:model="type" class="w-full bg-[#070B14] border border-[#1F2937] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#2563EB] transition">
                        <option value="تطويرية"> تطويرية</option>
                        <option value="تأسيسية"> تأسيسية</option>
                        <option value="متقدمة">متقدمة </option>
                        <option value="تأهيلية">تأهيلية </option>
                    </select>
                    @error('type') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                </div>
                
            </div>

            

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">مدة البرنامج (بالأيام)</label>
                    <input type="number" wire:model="duration_days" min="1" placeholder="مثال: 30" 
                           class="w-full bg-[#070B14] border border-[#1F2937] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#2563EB] transition font-mono">
                    @error('duration_days') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">الجهة المقدمة</label>
                    <input type="text" wire:model="location" placeholder="وزارة الدفاع" 
                           class="w-full bg-[#070B14] border border-[#1F2937] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#2563EB] transition">
                    @error('location') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">حالة الدورة </label>
                    <select wire:model="status" class="w-full bg-[#070B14] border border-[#1F2937] rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-[#2563EB] transition font-cairo" dir="rtl">
                    <option value="مستمرة حالياً">مستمرة حالياً</option>
                    <option value="قيد الانتظار">قيد الانتظار</option>
                    <option value="مكتملة ومؤرشفة">مكتملة ومؤرشفة</option>
                    <option value="ملغاة">ملغاة</option>
                </select>
                    @error('status') <span class="text-xs text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                </div>

        </div> 

        <div class="px-6 py-4 bg-[#070B14]/50 border-t border-[#1F2937] flex items-center justify-between">
            <span class="text-xs text-gray-500 font-mono">ALL FIELDS SECURED BY SYSTEM POLICIES</span>
            <button type="submit" wire:loading.attr="disabled" class="bg-[#2563EB] hover:bg-[#1d4ed8] text-white px-5 py-2.5 rounded-xl text-sm font-medium transition shadow-lg shadow-[#2563EB]/20 disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                <span wire:loading.remove wire:target="save">اعتماد وحفظ  </span>
                <span wire:loading wire:target="save" class="flex items-center gap-1">
                    <i class="fas fa-circle-notch fa-spin text-xs"></i> جاري الحفظ والمعالجة...
                </span>
            </button>
        </div>
    </form>
</div>