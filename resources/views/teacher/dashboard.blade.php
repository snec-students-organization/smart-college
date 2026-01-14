<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Recent Notices</h3>
                        <p class="text-gray-500 italic">No new notices.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
