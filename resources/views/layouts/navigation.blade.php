@php
    $dashboardRoute = Auth::user()->getDashboardRoute();
    $isDashboardActive = request()->routeIs('dashboard') ||
        request()->routeIs('admin.dashboard') ||
        request()->routeIs('teacher.dashboard') ||
        request()->routeIs('student.dashboard') ||
        request()->routeIs('parent.dashboard');
@endphp

<!-- Sidebar for Desktop -->
<nav class="hidden md:flex w-64 bg-white/80 backdrop-blur-xl border-r border-gray-100 flex-col">
    <!-- Logo -->
    <div class="h-20 flex items-center px-6 border-b border-gray-100/50">
        <a href="{{ route($dashboardRoute) }}" class="flex items-center gap-3">
            <div
                class="w-10 h-10 bg-brand-600 rounded-xl flex items-center justify-center shadow-lg shadow-brand-600/20">
                <x-application-logo class="w-7 h-7 fill-white" />
            </div>
            <span class="font-bold text-xl tracking-tight text-gray-900">Smart<span
                    class="text-brand-600">College</span></span>
        </a>
    </div>

    <!-- Navigation Links -->
    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1 custom-scrollbar">
        <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mb-4">Main Menu</p>

        <x-nav-link :href="route($dashboardRoute)" :active="$isDashboardActive"
            class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $isDashboardActive ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-600' }}">
            <svg class="w-5 h-5 {{ $isDashboardActive ? 'text-white' : 'text-gray-400 group-hover:text-brand-600' }}"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                </path>
            </svg>
            <span class="font-medium">{{ __('Dashboard') }}</span>
        </x-nav-link>

        @if(Auth::user()->isAdmin())
            <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-8 mb-4">Administration</p>

            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')"
                class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-600' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-gray-400 group-hover:text-brand-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                <span class="font-medium">{{ __('Users') }}</span>
            </x-nav-link>

            <x-nav-link :href="route('admin.students.index')" :active="request()->routeIs('admin.students.*')"
                class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.students.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-600' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.students.*') ? 'text-white' : 'text-gray-400 group-hover:text-brand-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                <span class="font-medium">{{ __('Students') }}</span>
            </x-nav-link>

            <x-nav-link :href="route('admin.parent-directory')" :active="request()->routeIs('admin.parent-directory')"
                class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.parent-directory') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-600' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.parent-directory') ? 'text-white' : 'text-gray-400 group-hover:text-brand-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                <span class="font-medium">{{ __('Parent Directory') }}</span>
            </x-nav-link>

            <x-nav-link :href="route('admin.classes.index')" :active="request()->routeIs('admin.classes.*')"
                class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.classes.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-600' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.classes.*') ? 'text-white' : 'text-gray-400 group-hover:text-brand-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                <span class="font-medium">{{ __('Classes & Sections') }}</span>
            </x-nav-link>

            <x-nav-link :href="route('admin.subjects.index')" :active="request()->routeIs('admin.subjects.*')"
                class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.subjects.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-600' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.subjects.*') ? 'text-white' : 'text-gray-400 group-hover:text-brand-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
                <span class="font-medium">{{ __('Subjects') }}</span>
            </x-nav-link>

            <p class="px-4 text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em] mt-8 mb-4">Finance & Library</p>

            <x-nav-link :href="route('admin.fees.index')" :active="request()->routeIs('admin.fees.*')"
                class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.fees.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-600' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.fees.*') ? 'text-white' : 'text-gray-400 group-hover:text-brand-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
                <span class="font-medium">{{ __('Fees') }}</span>
            </x-nav-link>

            <x-nav-link :href="route('admin.library.index')" :active="request()->routeIs('admin.library.*')"
                class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.library.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-600' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.library.*') ? 'text-white' : 'text-gray-400 group-hover:text-brand-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                    </path>
                </svg>
                <span class="font-medium">{{ __('Library') }}</span>
            </x-nav-link>

            <x-nav-link :href="route('admin.notices.index')" :active="request()->routeIs('admin.notices.*')"
                class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.notices.*') ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/20' : 'text-gray-600 hover:bg-gray-50 hover:text-brand-600' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.notices.*') ? 'text-white' : 'text-gray-400 group-hover:text-brand-600' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5.882V19.247A7.6 7.6 0 0117.5 13a7.6 7.6 0 01-6.5-7.118zM11 5.882v13.365A7.6 7.6 0 004.5 13a7.6 7.6 0 006.5-7.118z">
                    </path>
                </svg>
                <span class="font-medium">{{ __('Notice Board') }}</span>
            </x-nav-link>
        @endif
    </div>

    <!-- User Profile (Bottom) -->
    <div class="p-4 border-t border-gray-100/50">
        <div class="flex items-center gap-3 p-3 rounded-2xl bg-gray-50/50 mb-3 border border-gray-100/30">
            <div
                class="w-10 h-10 rounded-xl bg-brand-100 text-brand-700 flex items-center justify-center font-bold shadow-sm">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                <p class="text-[10px] font-bold text-brand-600 uppercase tracking-wider">{{ Auth::user()->role }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
                <span>Log Out</span>
            </button>
        </form>
    </div>
</nav>

<!-- Mobile Navigation (Toggle Style) -->
<div x-data="{ open: false }" class="md:hidden sticky top-0 z-[60] w-full">
    <!-- Header -->
    <div class="flex items-center justify-between h-16 px-4 bg-white shadow-sm border-b border-gray-100">
        <a href="{{ route($dashboardRoute) }}" class="flex items-center gap-2">
            <div class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center">
                <x-application-logo class="w-5 h-5 fill-white" />
            </div>
            <span class="font-bold text-lg text-gray-900 tracking-tight">Smart<span
                    class="text-brand-600">College</span></span>
        </a>
        <button @click="open = !open"
            class="p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                :class="{'hidden': open, 'block': !open}">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                :class="{'block': open, 'hidden': !open}" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Toggle Menu (Slide Down) -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="absolute top-16 left-0 w-full bg-white border-b border-gray-100 shadow-xl py-4 px-6 max-h-[calc(100vh-4rem)] overflow-y-auto"
        style="display: none;">

        <x-responsive-nav-link :href="route($dashboardRoute)" :active="$isDashboardActive"
            class="flex items-center gap-3 py-3 font-medium border-none !text-gray-700 hover:!text-brand-600 hover:!bg-brand-50 rounded-xl px-4 transition-all duration-200 {{ $isDashboardActive ? '!bg-brand-50 !text-brand-700' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                </path>
            </svg>
            {{ __('Dashboard') }}
        </x-responsive-nav-link>

        @if(Auth::user()->isAdmin())
            <div class="mt-4 pt-4 border-t border-gray-100">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3 px-4">Administration</p>
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')"
                    class="flex items-center gap-3 py-3 font-medium border-none !text-gray-700 hover:!text-brand-600 hover:!bg-brand-50 rounded-xl px-4 transition-all duration-200 {{ request()->routeIs('admin.users.*') ? '!bg-brand-50 !text-brand-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    {{ __('Users') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.students.index')"
                    :active="request()->routeIs('admin.students.*')"
                    class="flex items-center gap-3 py-3 font-medium border-none !text-gray-700 hover:!text-brand-600 hover:!bg-brand-50 rounded-xl px-4 transition-all duration-200 {{ request()->routeIs('admin.students.*') ? '!bg-brand-50 !text-brand-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    {{ __('Students') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.parent-directory')"
                    :active="request()->routeIs('admin.parent-directory')"
                    class="flex items-center gap-3 py-3 font-medium border-none !text-gray-700 hover:!text-brand-600 hover:!bg-brand-50 rounded-xl px-4 transition-all duration-200 {{ request()->routeIs('admin.parent-directory') ? '!bg-brand-50 !text-brand-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                    {{ __('Parent Directory') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.classes.index')" :active="request()->routeIs('admin.classes.*')"
                    class="flex items-center gap-3 py-3 font-medium border-none !text-gray-700 hover:!text-brand-600 hover:!bg-brand-50 rounded-xl px-4 transition-all duration-200 {{ request()->routeIs('admin.classes.*') ? '!bg-brand-50 !text-brand-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    {{ __('Classes') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.fees.index')" :active="request()->routeIs('admin.fees.*')"
                    class="flex items-center gap-3 py-3 font-medium border-none !text-gray-700 hover:!text-brand-600 hover:!bg-brand-50 rounded-xl px-4 transition-all duration-200 {{ request()->routeIs('admin.fees.*') ? '!bg-brand-50 !text-brand-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                    {{ __('Fees') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.library.index')" :active="request()->routeIs('admin.library.*')"
                    class="flex items-center gap-3 py-3 font-medium border-none !text-gray-700 hover:!text-brand-600 hover:!bg-brand-50 rounded-xl px-4 transition-all duration-200 {{ request()->routeIs('admin.library.*') ? '!bg-brand-50 !text-brand-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    {{ __('Library') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('admin.notices.index')" :active="request()->routeIs('admin.notices.*')"
                    class="flex items-center gap-3 py-3 font-medium border-none !text-gray-700 hover:!text-brand-600 hover:!bg-brand-50 rounded-xl px-4 transition-all duration-200 {{ request()->routeIs('admin.notices.*') ? '!bg-brand-50 !text-brand-700' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5.882V19.247A7.6 7.6 0 0117.5 13a7.6 7.6 0 01-6.5-7.118zM11 5.882v13.365A7.6 7.6 0 004.5 13a7.6 7.6 0 006.5-7.118z">
                        </path>
                    </svg>
                    {{ __('Notice Board') }}
                </x-responsive-nav-link>
            </div>
        @endif

        <div class="mt-4 pt-4 border-t border-gray-100">
            <div class="flex items-center gap-3 mb-4 px-4">
                <div
                    class="w-10 h-10 rounded-xl bg-brand-100 text-brand-700 flex items-center justify-center font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] font-bold text-brand-600 uppercase">{{ Auth::user()->role }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 py-3 font-bold text-red-600 hover:bg-red-50 rounded-xl px-4 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Log Out
                </button>
            </form>
        </div>
    </div>
</div>