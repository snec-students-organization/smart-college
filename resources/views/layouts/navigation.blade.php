<nav x-data="{ open: false }" class="bg-white border-r border-gray-100 w-64 min-h-screen flex-shrink-0 hidden md:flex flex-col transition-all duration-300">
    <!-- Logo -->
    <div class="h-16 flex items-center justify-center border-b border-gray-100">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <x-application-logo class="block h-9 w-auto fill-current text-brand-600" />
            <span class="font-bold text-xl tracking-tight text-gray-800">Smart<span class="text-brand-600">School</span></span>
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
        
        <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Menu</p>

        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            {{ __('Dashboard') }}
        </x-nav-link>

        @if(Auth::user()->isAdmin())
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">Administration</p>
            
            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50' }}">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                {{ __('Users') }}
            </x-nav-link>

            <x-nav-link :href="route('admin.students.index')" :active="request()->routeIs('admin.students.*')" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.students.*') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50' }}">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                {{ __('Students') }}
            </x-nav-link>

             <x-nav-link :href="route('admin.classes.index')" :active="request()->routeIs('admin.classes.*')" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.classes.*') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                {{ __('Classes & Sections') }}
            </x-nav-link>

            <x-nav-link :href="route('admin.subjects.index')" :active="request()->routeIs('admin.subjects.*')" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.subjects.*') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50' }}">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                {{ __('Subjects') }}
            </x-nav-link>

             <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">Finance & Library</p>

            <x-nav-link :href="route('admin.fees.index')" :active="request()->routeIs('admin.fees.index')" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.fees.index') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50' }}">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ __('Fee Structure') }}
            </x-nav-link>

             <x-nav-link :href="route('admin.fees.collect.index')" :active="request()->routeIs('admin.fees.collect.*')" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.fees.collect.*') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50' }}">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                {{ __('Collect Fees') }}
            </x-nav-link>

             <x-nav-link :href="route('admin.library.index')" :active="request()->routeIs('admin.library.index') || request()->routeIs('admin.library.store') || request()->routeIs('admin.library.destroy')" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.library.index') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50' }}">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                {{ __('Library Books') }}
            </x-nav-link>

            <x-nav-link :href="route('admin.library.circulation')" :active="request()->routeIs('admin.library.circulation') || request()->routeIs('admin.library.issue.*')" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('admin.library.circulation') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                {{ __('Circulation') }}
            </x-nav-link>
        @endif
        
        @if(Auth::user()->isTeacher())
             <x-nav-link :href="route('teacher.attendance.index')" :active="request()->routeIs('teacher.attendance.*')" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('teacher.attendance.*') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50' }}">
                {{ __('Attendance') }}
            </x-nav-link>
             <x-nav-link :href="route('teacher.marks.index')" :active="request()->routeIs('teacher.marks.*')" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('teacher.marks.*') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50' }}">
                {{ __('Marks') }}
            </x-nav-link>
        @endif

        @if(Auth::user()->isStudent())
             <x-nav-link :href="route('student.attendance')" :active="request()->routeIs('student.attendance')" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('student.attendance') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50' }}">
                {{ __('Attendance') }}
            </x-nav-link>
            <x-nav-link :href="route('student.marks')" :active="request()->routeIs('student.marks')" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('student.marks') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50' }}">
                {{ __('Results') }}
            </x-nav-link>
             <x-nav-link :href="route('student.fees')" :active="request()->routeIs('student.fees')" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg transition-colors {{ request()->routeIs('student.fees') ? 'bg-brand-50 text-brand-700' : 'text-gray-600 hover:bg-gray-50' }}">
                {{ __('Fees') }}
            </x-nav-link>
        @endif
    </div>

    <!-- User Profile Dropdown (Bottom Sidebar) -->
    <div class="p-4 border-t border-gray-100">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-full bg-brand-100 flex items-center justify-center text-brand-700 font-bold">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ ucfirst(Auth::user()->role) }}</p>
            </div>
        </div>
         <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Log Out
            </button>
        </form>
    </div>
</nav>

<!-- Mobile Header (Visible only on small screens) -->
<div class="md:hidden bg-white border-b border-gray-100 p-4 flex justify-between items-center" x-data="{ open: false }">
     <div class="font-bold text-xl tracking-tight text-gray-800">Smart<span class="text-brand-600">School</span></div>
     <button @click="open = !open" class="text-gray-600 focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
    </button>
    
    <!-- Mobile Menu Overlay -->
     <div x-show="open" class="absolute top-16 left-0 w-full bg-white border-b border-gray-100 shadow-lg z-50 flex flex-col p-4" style="display: none;">
         <!-- Replicate links here or include a partial for mobile -->
         <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-responsive-nav-link>
        <!-- Add other links similarly if needed for full mobile optimization -->
        <form method="POST" action="{{ route('logout') }}" class="mt-4 border-t pt-4">
            @csrf
            <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-responsive-nav-link>
        </form>
     </div>
</div>
