<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
                <!-- Students Card -->
                <div
                    class="relative group overflow-hidden bg-white/70 backdrop-blur-xl border border-white/40 shadow-soft rounded-2xl p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div
                        class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-blue-500/10 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-all duration-500">
                    </div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div
                            class="p-3 bg-blue-100/50 rounded-xl text-blue-600 transition-colors group-hover:bg-blue-600 group-hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Students</p>
                            <h3 class="text-2xl font-bold font-sans text-gray-900">{{ $stats['students'] }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Teachers Card -->
                <div
                    class="relative group overflow-hidden bg-white/70 backdrop-blur-xl border border-white/40 shadow-soft rounded-2xl p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div
                        class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all duration-500">
                    </div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div
                            class="p-3 bg-emerald-100/50 rounded-xl text-emerald-600 transition-colors group-hover:bg-emerald-600 group-hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Teachers</p>
                            <h3 class="text-2xl font-bold font-sans text-gray-900">{{ $stats['teachers'] }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Parents Card -->
                <div
                    class="relative group overflow-hidden bg-white/70 backdrop-blur-xl border border-white/40 shadow-soft rounded-2xl p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div
                        class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-amber-500/10 rounded-full blur-2xl group-hover:bg-amber-500/20 transition-all duration-500">
                    </div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div
                            class="p-3 bg-amber-100/50 rounded-xl text-amber-600 transition-colors group-hover:bg-amber-600 group-hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Parents</p>
                            <h3 class="text-2xl font-bold font-sans text-gray-900">{{ $stats['parents'] }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Classes Card -->
                <div
                    class="relative group overflow-hidden bg-white/70 backdrop-blur-xl border border-white/40 shadow-soft rounded-2xl p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                    <div
                        class="absolute top-0 right-0 -mr-4 -mt-4 w-24 h-24 bg-purple-500/10 rounded-full blur-2xl group-hover:bg-purple-500/20 transition-all duration-500">
                    </div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div
                            class="p-3 bg-purple-100/50 rounded-xl text-purple-600 transition-colors group-hover:bg-purple-600 group-hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Classes</p>
                            <h3 class="text-2xl font-bold font-sans text-gray-900">{{ $stats['classes'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Section -->
            <div class="bg-white/70 backdrop-blur-xl border border-white/40 shadow-soft rounded-2xl overflow-hidden">
                <div class="p-4 sm:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                            <span class="w-2 h-6 bg-brand-600 rounded-full"></span>
                            Quick Actions
                        </h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        <a href="{{ route('admin.students.create') }}"
                            class="group flex items-center justify-between p-4 bg-gray-50/50 hover:bg-brand-600 rounded-xl border border-gray-100 transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 flex items-center justify-center bg-white rounded-lg text-brand-600 group-hover:bg-white/20 group-hover:text-white transition-colors shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <span class="font-semibold text-gray-800 group-hover:text-white transition-colors">Add
                                    New Student</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors transform group-hover:translate-x-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>

                        <a href="{{ route('admin.users.index') }}"
                            class="group flex items-center justify-between p-4 bg-gray-50/50 hover:bg-accent-600 rounded-xl border border-gray-100 transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 flex items-center justify-center bg-white rounded-lg text-accent-600 group-hover:bg-white/20 group-hover:text-white transition-colors shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4"></path>
                                    </svg>
                                </div>
                                <span class="font-semibold text-gray-800 group-hover:text-white transition-colors">Add
                                    New Teacher</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors transform group-hover:translate-x-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>

                        <a href="{{ route('admin.classes.index') }}"
                            class="group flex items-center justify-between p-4 bg-gray-50/50 hover:bg-gray-800 rounded-xl border border-gray-100 transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 flex items-center justify-center bg-white rounded-lg text-gray-800 group-hover:bg-white/20 group-hover:text-white transition-colors shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                </div>
                                <span
                                    class="font-semibold text-gray-800 group-hover:text-white transition-colors">Manage
                                    Classes</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors transform group-hover:translate-x-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>