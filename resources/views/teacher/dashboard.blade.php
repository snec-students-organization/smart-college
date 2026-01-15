<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(isset($error))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 flex justify-between items-center" role="alert">
                    <span class="block sm:inline">{{ $error }}</span>
                    <a href="{{ route('teacher.profile.setup') }}" class="bg-red-600 text-white px-4 py-1 rounded text-sm font-bold hover:bg-red-700 transition-colors">
                        Complete Your Profile
                    </a>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Total Students -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Students</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['students'] }}</div>
                </div>

                <!-- Classes -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Classes</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['classes'] }}</div>
                </div>

                <!-- Attendance Today -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Present Today</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['attendance_today'] }}</div>
                </div>

                <!-- Subjects -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Subjects</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['subjects'] }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Quick Actions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                        <div class="space-y-4">
                            <a href="{{ route('teacher.attendance.index') }}" class="block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Mark Attendance
                            </a>
                            <button class="block w-full text-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                                Enter Marks (Coming Soon)
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Notices -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 border-b">
                        <h3 class="text-lg font-semibold text-indigo-700">Today's Periods ({{ date('l') }})</h3>
                    </div>
                    <div class="p-4">
                        @if($todayPeriods->isNotEmpty())
                            <div class="space-y-4">
                                @foreach($todayPeriods as $period)
                                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg border border-gray-100">
                                        <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-lg flex flex-col items-center justify-center text-indigo-700">
                                            <span class="text-xs font-bold leading-none">PER</span>
                                            <span class="text-lg font-black leading-none">{{ $period->period_number }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-md font-bold text-gray-900 truncate">{{ $period->subject->name }}</h4>
                                            <p class="text-sm text-gray-600 uppercase font-medium tracking-tight">Class: {{ $period->section->school_class->name }} - {{ $period->section->name }}</p>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm font-bold text-indigo-600">
                                                {{ \Carbon\Carbon::parse($period->start_time)->format('h:i A') }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ \Carbon\Carbon::parse($period->end_time)->format('h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-10">
                                <p class="text-gray-500 italic">No periods assigned for today.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Notices -->
            </div>
        </div>
    </div>
</x-app-layout>
