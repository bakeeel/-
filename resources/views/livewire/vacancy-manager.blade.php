<div class="p-6 bg-[#070B14] min-h-screen text-white font-cairo text-right relative" 
     dir="rtl" 
     x-data="{ showModal: false }" 
     x-on:close-modal.window="showModal = false">
    
    <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4 mb-8">
        <div class="text-right">
            <h1 class="text-3xl font-black text-white tracking-wide mb-1">الأرقام الوظيفية الشاغرة</h1>
            <div class="w-32 h-1 bg-gradient-to-l from-[#2563EB] to-transparent rounded-full"></div>
        </div>

        <button type="button" 
            wire:click="openCreateModal"
            @click="showModal = true"
            class="flex items-center gap-2 bg-[#2563EB] hover:bg-[#1d4ed8] text-white text-sm font-bold px-4 py-2.5 rounded-xl border border-[#3b82f6]/30 shadow-lg shadow-[#2563EB]/10 transition-all cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            إضافة رقم وظيفي جديد
        </button>
    </div>

    <div class="max-w-6xl mx-auto mb-4">
        <div class="relative">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="ابحث من خلال الرقم الوظيفي، المسمى، أو الملاحظات..." 
                class="w-full bg-[#0b111e] border border-[#1e293b] focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB]/20 rounded-xl text-sm px-4 py-3 text-white pr-10 outline-none transition-all" />
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="max-w-6xl mx-auto mb-4 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl flex items-center gap-2 text-sm font-bold animate-fadeIn">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <div class="max-w-6xl mx-auto bg-[#0b111e] border border-[#1e293b] rounded-xl overflow-hidden shadow-2xl">
        <div class="w-full overflow-x-auto">
            <table class="w-full text-right border-collapse table-fixed min-w-[900px]">
                <thead>
                    <tr class="bg-[#111827] border-b border-[#1e293b] text-[#9CA3AF] text-xs font-bold select-none">
                        <th class="py-3.5 px-4 text-center w-14 border-l border-[#1e293b]/60">م</th>
                        <th class="py-3.5 px-4 w-1/4 border-l border-[#1e293b]/60">الرقم الوظيفي</th>
                        <th class="py-3.5 px-4 w-1/3 border-l border-[#1e293b]/60">المسمى الوظيفي</th>
                        <th class="py-3.5 px-4 w-40 border-l border-[#1e293b]/60 text-center">الحالة</th>
                        <th class="py-3.5 px-4 border-l border-[#1e293b]/60">ملاحظات</th>
                        <th class="py-3.5 px-4 w-24 text-center">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#1e293b]/50">
                    @forelse($paginatedVacancies as $index => $vacancy)
                        <tr wire:key="vacancy-row-{{ $vacancy->id }}" class="hover:bg-[#162235]/30 transition-colors group">
                            <td class="py-3 px-4 text-center font-mono text-xs text-gray-500 font-bold border-l border-[#1e293b]/40 bg-[#111827]/20">
                                {{ (($paginatedVacancies->currentPage() - 1) * $paginatedVacancies->perPage()) + $index + 1 }}
                            </td>
                            <td class="py-3 px-4 border-l border-[#1e293b]/40 font-mono text-sm tracking-wide text-white font-bold">
                                {{ $vacancy->vacancy_number ?: '—' }}
                            </td>
                            <td class="py-3 px-4 border-l border-[#1e293b]/40 text-xs text-gray-200">
                                {{ $vacancy->title ?: '—' }}
                            </td>
                            <td class="py-3 px-4 border-l border-[#1e293b]/40 text-center">
                                @if($vacancy->status == 'vacant')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> شاغر
                                    </span>
                                @elseif($vacancy->status == 'under_action')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> تحت الإجراء
                                    </span>
                                @elseif($vacancy->status == 'processing')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> جاري التثبيت
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 border-l border-[#1e293b]/40 text-xs text-gray-400 truncate max-w-[200px]" title="{{ $vacancy->notes }}">
                                {{ $vacancy->notes ?: '—' }}
                            </td>
                            <td class="py-3 px-2 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <button type="button" 
                                        wire:click="editVacancy({{ $vacancy->id }})"
                                        @click="showModal = true"
                                        class="text-gray-400 hover:text-blue-400 p-1.5 rounded-lg hover:bg-blue-500/10 transition-all cursor-pointer" title="تعديل">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </button>
                                    <button type="button" 
                                        wire:click="deleteVacancy({{ $vacancy->id }})"
                                        wire:confirm="هل أنت متأكد من رغبتك في حذف هذا الرقم الوظيفي؟"
                                        class="text-gray-550 hover:text-rose-500 p-1.5 rounded-lg hover:bg-rose-500/10 transition-all cursor-pointer" title="حذف">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr wire:key="vacancy-empty-row">
                            <td colspan="6" class="py-8 text-center text-sm text-gray-500 font-bold bg-[#070B14]/20">
                                لا توجد أرقام وظيفية مسجلة حالياً.
                            </td>
                        </tr>
                    @endforelse

                    @if($paginatedVacancies->count() > 0 && $paginatedVacancies->count() < 10)
                        @for($i = $paginatedVacancies->count(); $i < 10; $i++)
                            <tr wire:key="vacancy-blank-row-{{ $i }}" class="opacity-25 border-[#1e293b]/20 select-none pointer-events-none">
                                <td class="py-3 px-4 text-center font-mono text-xs text-gray-700 bg-[#111827]/10 border-l border-[#1e293b]/20">—</td>
                                <td class="py-3 px-4 border-l border-[#1e293b]/20 text-gray-700">—</td>
                                <td class="py-3 px-4 border-l border-[#1e293b]/20 text-gray-700">—</td>
                                <td class="py-3 px-4 border-l border-[#1e293b]/20 text-center text-gray-700">—</td>
                                <td class="py-3 px-4 border-l border-[#1e293b]/20 text-gray-700">—</td>
                                <td class="py-3 px-2 text-center text-gray-700">—</td>
                            </tr>
                        @endfor
                    @endif
                </tbody>
            </table>
        </div>

       <div class="p-4 bg-[#111827] border-t border-[#1e293b] flex flex-row items-center justify-between gap-4 text-xs w-full overflow-x-auto select-none">
    
    <div class="flex flex-row items-center gap-3 shrink-0">
        
        <div class="flex items-center gap-2 bg-[#1e293b]/60 border border-blue-500/20 rounded-xl px-3 py-2 shadow-md">
            <svg class="w-4 h-4 text-blue-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <span class="text-gray-400 font-bold whitespace-nowrap">شاغر:</span>
            <span class="font-mono text-xs font-black text-blue-400 bg-blue-500/10 px-2 py-0.5 rounded border border-blue-500/20">
                {{ $totalVacantCount }}
            </span>
        </div>

        <div class="flex items-center gap-2 bg-[#1e293b]/60 border border-amber-500/20 rounded-xl px-3 py-2 shadow-md">
            <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-gray-400 font-bold whitespace-nowrap">تحت الإجراء:</span>
            <span class="font-mono text-xs font-black text-amber-400 bg-amber-500/10 px-2 py-0.5 rounded border border-amber-500/20">
                {{ $totalUnderActionCount }}
            </span>
        </div>

        <div class="flex items-center gap-2 bg-[#1e293b]/60 border border-emerald-500/20 rounded-xl px-3 py-2 shadow-md">
            <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-gray-400 font-bold whitespace-nowrap">جاري التثبيت:</span>
            <span class="font-mono text-xs font-black text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded border border-emerald-500/20">
                {{ $totalProcessingCount }}
            </span>
        </div>

    </div>

    <div class="custom-pagination text-white flex items-center justify-center shrink-0 mx-4">
        {{ $paginatedVacancies->links() }}
    </div>

    <div class="shrink-0">
        <button type="button" 
            wire:click="exportExcel"
            class="flex items-center gap-2.5 bg-[#107C41] hover:bg-[#0e6b38] text-white font-bold px-4 py-2.5 rounded-xl border border-emerald-600/30 shadow-lg shadow-emerald-950/20 transition-all cursor-pointer whitespace-nowrap">
            <span>تنزيل تقرير إكسيل</span>
            <svg class="w-4 h-4 shrink-0 text-emerald-100" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </button>
    </div>

</div>
    </div>

    <div x-show="showModal" 
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-[#020408]/80 backdrop-blur-md"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         style="display: none;">
        
        <div class="relative w-full max-w-lg bg-[#0b111e] border border-[#1e293b] rounded-2xl shadow-2xl overflow-hidden text-right" @click.away="showModal = false">
            <div class="p-5 border-b border-[#1e293b] bg-[#111827] flex items-center justify-between">
                <h3 class="text-lg font-black text-white flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#2563EB]"></span>
                    {{ isset($vacancyForm['id']) ? 'تعديل الرقم الوظيفي الحالي' : 'إنشاء رقم وظيفي جديد' }}
                </h3>
                <button type="button" @click="showModal = false" class="text-gray-400 hover:text-white transition-colors cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <div>
                  <div x-data="{ 
                        init() {
                            // كود إضافي للتأكد من تنظيف الإدخال إذا تم النسخ واللصق
                            this.$el.querySelector('input').addEventListener('input', (e) => {
                                e.target.value = e.target.value.replace(/[^0-9]/g, '');
                            });
                        }
                    }">
                        <label class="block text-xs font-bold text-gray-400 mb-2">الرقم الوظيفي</label>
                        
                        <input type="text" 
                            wire:model.blur="vacancyForm.vacancy_number" 
                            placeholder="مثال: 100000234567" 
                            maxlength="15"
                            inputmode="numeric"
                            onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                            class="w-full bg-[#070B14] border {{ $errors->has('vacancyForm.vacancy_number') ? 'border-rose-500' : 'border-[#1e293b]' }} focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB]/20 rounded-xl text-sm px-4 py-3 text-white font-mono outline-none transition-all" />
                        
                        @error('vacancyForm.vacancy_number')
                            <span class="text-rose-500 text-xs mt-1 block font-bold">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 mb-2">المسمى الوظيفي</label>
                    <input type="text" wire:model.blur="vacancyForm.title" placeholder="مثال: 1321 متمم" 
                        class="w-full bg-[#070B14] border border-[#1e293b] focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB]/20 rounded-xl text-sm px-4 py-3 text-white outline-none transition-all" />
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 mb-2">حالة الرقم الوظيفي</label>
                    <select wire:model.blur="vacancyForm.status" class="w-full bg-[#070B14] border border-[#1e293b] focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB]/20 rounded-xl text-sm px-4 py-3 text-white outline-none transition-all cursor-pointer">
                        <option value="vacant">شاغر</option>
                        <option value="under_action">تحت الإجراء</option>
                        <option value="processing">جاري التثبيت</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 mb-2">ملاحظات إضافية</label>
                    <textarea rows="3" wire:model.blur="vacancyForm.notes" placeholder="أكتب أي ملاحظات متعلقة بالرقم الوظيفي هنا..." 
                        class="w-full bg-[#070B14] border border-[#1e293b] focus:border-[#2563EB] focus:ring-1 focus:ring-[#2563EB]/20 rounded-xl text-sm px-4 py-3 text-white outline-none transition-all resize-none"></textarea>
                </div>
            </div>

            <div class="p-4 bg-[#111827] border-t border-[#1e293b] flex items-center justify-end gap-3">
                <button type="button" @click="showModal = false" 
                    class="bg-transparent hover:bg-[#1e293b] text-gray-400 hover:text-white text-xs font-bold px-4 py-2.5 rounded-xl border border-[#1e293b] transition-all cursor-pointer">
                    إلغاء
                </button>
              <button type="button" 
                wire:click="saveSingleVacancy"
                @click="if ($wire.vacancyForm.vacancy_number) showModal = false"
                wire:loading.attr="disabled"
                class="bg-[#2563EB] hover:bg-[#1d4ed8] disabled:opacity-50 text-white text-xs font-bold px-5 py-2.5 rounded-xl border border-[#3b82f6]/30 shadow-lg shadow-[#2563EB]/10 transition-all cursor-pointer">
                <span wire:loading.remove>حفظ التغييرات</span>
                <span wire:loading>جاري الحفظ...</span>
            </button>
            </div>
        </div>
    </div>
</div>