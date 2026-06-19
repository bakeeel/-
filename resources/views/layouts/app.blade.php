<!DOCTYPE html>
<html lang="ar" dir="rtl" class="h-full bg-[#070B14]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>منظومة التدريب الشامل العسكرية</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body { font-family: 'Cairo', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="h-full text-[#E5E7EB] antialiased overflow-x-hidden">

    <div class="min-h-screen flex" x-data="{ sidebarOpen: true }">
        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" class="bg-[#111827] border-l border-[#1F2937] fixed h-full top-0 right-0 z-40 transition-all duration-300 flex flex-col shadow-2xl">
         <div class="h-16 flex items-center px-4 border-b border-[#1F2937] transition-all duration-300">
            <div class="flex items-center gap-3 w-full">
                <div class="w-10 h-10 flex-shrink-0 bg-white/5 rounded-full p-1 border border-[#2563EB]/30 flex items-center justify-center">
                    <img src="{{ asset('images/logo1.png') }}" 
                        alt="الشعار" 
                        class="w-full h-full object-contain">
                </div>
                
                <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" class="flex flex-col">
                    <span class="text-[10px] font-bold text-[#2563EB] uppercase tracking-widest">Navy System</span>
                    <span class="text-xs font-semibold text-gray-200">كفاءة (منظومة التدريب ) </span>
                </div>
            </div>

            <button @click="sidebarOpen = !sidebarOpen" 
                    class="p-1.5 rounded-lg bg-[#070B14] border border-[#1F2937] text-gray-400 hover:text-white hover:border-[#2563EB] transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

            <nav class="flex-1 px-3 py-4 space-y-2 overflow-y-auto">
                
                <a href="{{ route('dashboard') }}" wire:navigate 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-[#2563EB]/10 text-[#2563EB] border border-[#2563EB]/20' : 'text-gray-400 hover:bg-gray-800/40 hover:text-white border border-transparent' }} text-sm font-medium transition group">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m0 0l-7 7-7-7M19 10v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span x-show="sidebarOpen" class="transition-opacity">الرئيسية </span>
                </a>
                <a href="{{ route('personnel.search') }}" wire:navigate 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('personnel.search') ? 'bg-[#2563EB]/10 text-[#2563EB] border border-[#2563EB]/20' : 'text-gray-400 hover:bg-gray-800/40 hover:text-white border border-transparent' }} text-sm font-medium transition group">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span x-show="sidebarOpen" class="transition-opacity">البحث </span>
                </a>

             
                {{-- قسم الضباط --}}
               <a href="{{ route('officer.index') }}" wire:navigate 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('officer.index') || request()->routeIs('officer.show') ? 'bg-[#2563EB]/10 text-[#2563EB] border border-[#2563EB]/20' : 'text-gray-400 hover:bg-gray-800/40 hover:text-white border border-transparent' }} text-sm font-medium transition group">
                    <svg class="w-5 h-5 shrink-0 transition-colors group-hover:text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.381-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    <span x-show="sidebarOpen" class="transition-opacity">الضباط</span>
                </a>
                  <!-- <a href="{{ route('course-office.index') }}" wire:navigate 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('course-office.*') ? 'bg-[#2563EB]/10 text-[#2563EB] border border-[#2563EB]/20' : 'text-gray-400 hover:bg-gray-800/40 hover:text-white border border-transparent' }} text-sm font-medium transition group">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l1.82 3.69 4.07.59-2.94 2.87.69 4.05L12 12.29l-3.64 1.91.69-4.05-2.94-2.87 4.07-.59L12 3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18h12M8 21h8" />
                    </svg>
                        <span x-show="sidebarOpen" class="transition-opacity">دورات الضباط </span>
                    </a> -->
                  {{-- قسم الأفراد --}}
                    <a href="{{ route('personnel.index') }}" wire:navigate 
                        class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('personnel.index') || request()->routeIs('personnel.show') ? 'bg-[#2563EB]/10 text-[#2563EB] border border-[#2563EB]/20' : 'text-gray-400 hover:bg-gray-800/40 hover:text-white border border-transparent' }} text-sm font-medium transition group">
                            <svg class="w-5 h-5 shrink-0 transition-colors group-hover:text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span x-show="sidebarOpen" class="transition-opacity">الأفراد</span>
                    </a>
                   


                {{-- قسم المتدربين --}}
               {{-- 🎓 زر المتدربين --}}
               <a href="{{ route('trainee.index') }}" wire:navigate 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ (request()->routeIs('trainee.*') && !request()->routeIs('trainee.course.*')) ? 'bg-[#2563EB]/10 text-[#2563EB] border border-[#2563EB]/20' : 'text-gray-400 hover:bg-gray-800/40 hover:text-white border border-transparent' }} text-sm font-medium transition group">
                    
                    <svg class="w-5 h-5 shrink-0 transition-colors {{ (request()->routeIs('trainee.*') && !request()->routeIs('trainee.course.*')) ? 'text-[#2563EB]' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                    <span x-show="sidebarOpen" class="transition-opacity">المتدربين</span>
                </a>
              <a href="{{ route('vacancies.index') }}" wire:navigate 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('vacancies.*') ? 'bg-[#2563EB]/10 text-[#2563EB] border border-[#2563EB]/20' : 'text-gray-400 hover:bg-gray-800/40 hover:text-white border border-transparent' }} text-sm font-medium transition group">
                    
                    <svg class="w-5 h-5 shrink-0 transition-colors {{ request()->routeIs('vacancies.*') ? 'text-[#2563EB]' : 'text-gray-400 group-hover:text-white' }}" 
                        fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a3 3 0 100-6 3 3 0 000 6zm5-3h3m-3 2h3" />
                    </svg>
                    
                    <span x-show="sidebarOpen" class="transition-opacity font-cairo">الشواغر</span>
                </a>

                  <a href="{{ route('courses.index') }}" wire:navigate 
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('courses.*') ? 'bg-[#2563EB]/10 text-[#2563EB] border border-[#2563EB]/20' : 'text-gray-400 hover:bg-gray-800/40 hover:text-white border border-transparent' }} text-sm font-medium transition group">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <span x-show="sidebarOpen" class="transition-opacity">الدورات  </span>
                    </a>

              
           
             <a href="{{ route('nomination.index') }}" wire:navigate 
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition group 
                {{ request()->routeIs('nomination.*') ? 'bg-blue-600/10 text-blue-400 border border-blue-500/20' : 'text-gray-400 hover:bg-gray-800/40 hover:text-white border border-transparent' }}">
                    
                    <svg class="w-5 h-5 shrink-0 transition-colors {{ request()->routeIs('nomination.*') ? 'text-blue-400' : 'text-gray-400 group-hover:text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    
                    <span x-show="sidebarOpen" class="transition-opacity">الترشيح  للدورات</span>
                </a>

           <a href="{{ route('reports.index') }}" wire:navigate 
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('reports.*') ? 'bg-[#2563EB]/10 text-[#2563EB] border border-[#2563EB]/20' : 'text-gray-400 hover:bg-gray-800/40 hover:text-white border border-transparent' }} text-sm font-medium transition group">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span x-show="sidebarOpen" class="transition-opacity">التقارير</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 border border-transparent hover:border-rose-500/20 text-sm font-medium transition group cursor-pointer mt-1">
                    <svg class="w-5 h-5 shrink-0 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span x-show="sidebarOpen" class="transition-opacity">تسجيل الخروج</span>
                </button>
            </form>

            </nav>
        </aside>

        <div :class="sidebarOpen ? 'mr-64' : 'mr-20'" class="flex-1 flex flex-col transition-all duration-300 min-w-0">
            <header class="h-16 bg-[#111827]/80 backdrop-blur-md border-b border-[#1F2937] flex items-center justify-between px-6 sticky top-0 z-30">
                <div class="flex items-center gap-4">
                    <span class="text-xs font-mono text-emerald-400 bg-emerald-500/10 px-2.5 py-1 rounded border border-emerald-500/20">GRID NODE: ONLINE</span>
                </div>
                <div class="flex items-center gap-4" x-data="{ openProfile: false }">
                    <div class="relative">
                        <button @click="openProfile = !openProfile" class="flex items-center gap-2 focus:outline-none">
                            <div class="w-8 h-8 rounded-full bg-[#2563EB] flex items-center justify-center font-bold text-white text-xs border border-[#1F2937]">C1</div>
                        </button>
                        <div x-show="openProfile" @click.away="openProfile = false" x-cloak class="absolute left-0 mt-2 w-48 bg-[#111827] border border-[#1F2937] rounded-lg shadow-xl py-1 text-sm text-gray-300 z-50">
                            <a href="#" class="block px-4 py-2 hover:bg-[#070B14]">الملف الشخصي</a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-right px-4 py-2 text-rose-400 hover:bg-[#070B14] focus:outline-none">
                                    تسجيل الخروج
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-6 lg:p-8 bg-gradient-to-br from-[#070B14] to-[#111827]">
                <div x-data="{ messages: [] }" @toast.window="messages.push($event.detail); setTimeout(() => messages.shift(), 3500)" class="fixed bottom-5 left-5 space-y-2 z-50">
                    <template x-for="msg in messages">
                        <div class="bg-gray-900 border border-emerald-500/30 text-emerald-400 text-xs px-4 py-3 rounded-lg shadow-2xl flex items-center gap-2 font-cairo">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span x-text="msg.message"></span>
                        </div>
                    </template>
                </div>

                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
    <div x-data="{ 
            messages: [],
            addToast(event) {
                let detail = Array.isArray(event.detail) ? event.detail[0] : event.detail;
                this.messages.push({ 
                    text: detail.message, 
                    type: detail.type || 'success' 
                });
                setTimeout(() => this.messages.shift(), 5000);
            }
        }" 
        @toast.window="addToast($event)" 
        class="fixed bottom-5 left-5 space-y-2 z-[9999]">
        
        <template x-for="(msg, index) in messages" :key="index">
            <div class="px-6 py-4 rounded shadow-2xl flex items-center gap-3 border-l-4 transition-all"
                :class="{
                    'bg-gray-900 border-emerald-500 text-emerald-400': msg.type === 'success',
                    'bg-gray-900 border-amber-500 text-amber-400': msg.type === 'warning',
                    'bg-gray-900 border-blue-500 text-blue-400': msg.type === 'info'
                }">
                <span :class="msg.type === 'success' ? 'text-emerald-400' : 'text-amber-400'">●</span>
                <span x-text="msg.text" class="text-sm font-bold"></span>
            </div>
        </template>
    </div>
    
</body>
</html>