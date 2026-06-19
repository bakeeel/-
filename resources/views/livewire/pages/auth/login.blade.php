<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * معالجة طلب تسجيل الدخول للمنظومة الأمنية
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        // التوجيه التلقائي إلى لوحة القيادة (Dashboard) بعد التحقق
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="w-full max-w-md mx-auto px-4" dir="rtl">
    <x-auth-session-status class="mb-5 text-xs text-center font-bold" :status="session('status')" />

    {{-- الهيكل السيبراني المطور الخالي من خلفية لارفل والمطابق تماماً للصورة --}}
    <div class="relative bg-[#070c16] border border-[#1e293b]/70 p-6 sm:p-10 rounded-2xl shadow-[0_25px_50px_-12px_rgba(0,0,0,0.8)] space-y-6 overflow-hidden">
        
        {{-- شريط توهج علوي دقيق لإعطاء مظهر الأنظمة المتقدمة --}}
        <div class="absolute top-0 inset-x-0 h-[2px] bg-gradient-to-r from-transparent via-blue-500/50 to-transparent"></div>

       {{-- رأسية الصندوق المتمركزة في المنتصف تماماً --}}
        <div class="flex flex-col items-center text-center pb-2 space-y-4 relative z-10">
            
            {{-- الشعار البصري الدائري المحاط بظل --}}
            <div class="w-16 h-16 rounded-full bg-[#0d1527] border border-[#26354a] flex items-center justify-center shadow-lg shrink-0 p-1 overflow-hidden transition-transform duration-300 hover:scale-105">
                <img src="{{ asset('images/logo1.png') }}" 
                     alt="شعار الإدارة" 
                     class="w-full h-full object-contain rounded-full">
            </div>
            
            {{-- العناوين والنصوص بتباين ألوان سيبراني دقيق --}}
            <div class="space-y-2">
                <h2 class="text-xs font-bold text-slate-400 tracking-wide">التحقق من الهوية الرقمية</h2>
                <h1 class="text-sm font-extrabold text-slate-200">كفاءة (منظومة التدريب )</h1>
            </div>
        </div>

        <form wire:submit="login" class="space-y-5">
            
            {{-- حقل البريد الإلكتروني المعتمد --}}
            <div class="space-y-2">
                <label for="email" class="block text-xs font-bold text-slate-300 select-none">
                    البريد الإلكتروني المعتمد
                </label>
                <div class="relative flex items-center bg-[#0d1527] border border-[#1e293b] rounded-xl focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500/30 transition-all duration-200 overflow-hidden">
                    <input wire:model="form.email" 
                           id="email" 
                           class="block w-full text-xs font-medium bg-transparent text-slate-100 placeholder-slate-600 px-4 py-3.5 outline-none border-none order-1
                                  autofill:bg-transparent autofill:text-slate-100 
                                  [-webkit-text-fill-color:rgb(241,245,249)] 
                                  [transition:background-color_5000s_ease-in-out_0s]" 
                           type="email" 
                           name="email" 
                           placeholder="username@domain.gov.sa"
                           required 
                           autofocus 
                           autocomplete="username" />
                    
                    {{-- أيقونة حقل البريد مثبتة في اليسار بشكل مرن ومحمي --}}
                    <div class="flex items-center justify-center px-4 text-slate-500 select-none border-l border-[#1e293b]/50 h-5 my-auto order-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206"/>
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('form.email')" class="mt-1 text-[11px] font-bold text-rose-400" />
            </div>

            {{-- حقل كلمة المرور --}}
            <div class="space-y-2">
                <label for="password" class="block text-xs font-bold text-slate-300 select-none">
                    كلمة المرور
                </label>
                <div class="relative flex items-center bg-[#0d1527] border border-[#1e293b] rounded-xl focus-within:border-blue-500 focus-within:ring-1 focus-within:ring-blue-500/30 transition-all duration-200 overflow-hidden" x-data="{ showPassword: false }">
                    <input wire:model="form.password" 
                           id="password" 
                           class="block w-full text-xs font-mono bg-transparent text-slate-100 placeholder-slate-600 px-4 py-3.5 outline-none border-none order-1
                                  autofill:bg-transparent autofill:text-slate-100
                                  [-webkit-text-fill-color:rgb(241,245,249)] 
                                  [transition:background-color_5000s_ease-in-out_0s]" 
                           :type="showPassword ? 'text' : 'password'" 
                           name="password" 
                           placeholder="••••••••••••"
                           required 
                           autocomplete="current-password" />

                    {{-- أزرار التحكم بالرؤية والأيقونة مدمجة في أقصى اليسار بترتيب مرن --}}
                    <div class="flex items-center gap-3 px-4 border-l border-[#1e293b]/50 h-5 my-auto order-2">
                        <button type="button" 
                                @click="showPassword = !showPassword" 
                                class="text-slate-500 hover:text-blue-400 transition-colors outline-none cursor-pointer">
                            
                            <svg x-show="showPassword" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" x-cloak>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>

                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" x-cloak>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/>
                            </svg>
                        </button>

                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('form.password')" class="mt-1.5 text-[11px] font-bold text-rose-400" />
            </div>

            {{-- خيار حفظ الجلسة (تذكرني) --}}
            <div class="flex items-center justify-start pt-1">
                <label for="remember" class="inline-flex items-center cursor-pointer group select-none">
                    <input wire:model="form.remember" 
                           id="remember" 
                           type="checkbox" 
                           class="rounded bg-[#0d1527] border-[#1e293b] text-blue-600 focus:ring-blue-500/20 focus:ring-offset-0 w-4 h-4 cursor-pointer transition-all">
                    <span class="ms-2.5 text-[11px] font-bold text-slate-400 group-hover:text-slate-300 transition-colors">تذكرني على هذا الجهاز الآمن</span>
                </label>
            </div>

            {{-- زر الدخول الآمن للمنظومة --}}
            <div class="pt-2">
                <button type="submit" 
                        wire:loading.attr="disabled"
                        class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs px-4 py-3.5 rounded-xl transition-all duration-150 cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed border border-blue-500/30 shadow-[0_4px_20px_rgba(37,99,235,0.4)]">
                    
                    {{-- مؤشر التحميل الديناميكي المتناسق --}}
                    <span wire:loading wire:target="login" class="w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin shrink-0"></span>
                    
                    {{-- أيقونة المفتاح الافتراضية --}}
                    <svg wire:loading.remove wire:target="login" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    
                    <span wire:loading.remove wire:target="login">دخول آمـن للمنظومة</span>
                    <span wire:loading wire:target="login">جاري فحص تصريح الدخول...</span>
                </button>
            </div>

        </form>
    </div>
    
    {{-- تفاصيل خادم الاتصال --}}
    <div class="flex items-center justify-center gap-1.5 mt-8 select-none">
        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
        <p class="text-[10px] text-gray-500 font-medium font-sans">الخادم الرئيسي يعمل ومؤمن بالكامل</p>
    </div>
</div>