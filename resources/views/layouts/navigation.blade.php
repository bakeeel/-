<div class="space-y-2 px-4 font-cairo">
    
    <a href="{{ route('dashboard') }}" wire:navigate 
       class="{{ request()->routeIs('dashboard') ? 'bg-[#2563EB] text-white' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path></svg>
        <span>لوحة التحكم المركزية</span>
    </a>

    <a href="{{ route('personnel.index') }}" wire:navigate 
       class="{{ request()->routeIs('personnel.*') ? 'bg-[#2563EB] text-white' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        <span> الأفراد </span>
    </a>

    <a href="{{ route('personnel.create') }}" wire:navigate 
       class="{{ request()->routeIs('personnel.create') ? 'bg-[#2563EB] text-white' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition duration-200">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
        <span>تسجيل قيد جديد</span>
    </a>

</div>