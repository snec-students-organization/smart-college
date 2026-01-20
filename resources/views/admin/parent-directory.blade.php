<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Parent Directory') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @foreach($classes as $class)
                <div class="mb-12">
                    <!-- Class Header -->
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-12 h-12 bg-brand-600 rounded-2xl flex items-center justify-center shadow-lg shadow-brand-600/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $class->name }}</h3>
                            <p class="text-xs font-bold text-brand-600 uppercase tracking-widest">{{ $class->students->count() }} Students Total</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($class->students as $student)
                            <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 border border-gray-100 shadow-soft hover:shadow-lg transition-all duration-300 group">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center font-bold text-gray-600 group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors">
                                            {{ substr($student->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900 leading-tight">{{ $student->user->name }}</h4>
                                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Roll No: {{ $student->roll_no ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 bg-gray-50 text-gray-500 text-[10px] font-bold rounded-lg">{{ $student->section->name ?? 'N/A' }}</span>
                                </div>

                                <div class="space-y-4 pt-4 border-t border-gray-50">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[9px] font-bold text-indigo-400 uppercase tracking-widest leading-none">Parent Name</p>
                                            <p class="text-sm font-bold text-gray-900 truncate">{{ $student->parent->user->name ?? 'Not Registered' }}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[9px] font-bold text-emerald-400 uppercase tracking-widest leading-none">Contact Number</p>
                                            <p class="text-sm font-bold text-gray-900">{{ $student->parent->phone ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center bg-white/50 rounded-2xl border border-dashed border-gray-200">
                                <p class="text-gray-400 font-medium italic">No students found in this class.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</x-app-layout>
