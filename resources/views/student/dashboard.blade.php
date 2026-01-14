<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(isset($error))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ $error }}</span>
                </div>
            @else

            <!-- Profile Overview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold">Welcome, {{ Auth::user()->name }}!</h3>
                        <p class="text-gray-600">Class: {{ $student->school_class->name ?? 'N/A' }} - {{ $student->section->name ?? 'N/A' }} | Roll No: {{ $student->roll_no }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-block bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full uppercase font-semibold tracking-wide">Student</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Attendance Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-green-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Attendance</div>
                    <div class="mt-2 text-4xl font-bold text-gray-900">{{ $attendancePercentage }}%</div>
                    <p class="text-xs text-gray-500 mt-1">Overall Present</p>
                    <div class="mt-4">
                        <a href="{{ route('student.attendance') }}" class="text-indigo-600 hover:text-indigo-900 text-sm">View History &rarr;</a>
                    </div>
                </div>

                <!-- Library Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-yellow-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Library Books</div>
                    <div class="mt-2 text-4xl font-bold text-gray-900">{{ $pendingBooks }}</div>
                    <p class="text-xs text-gray-500 mt-1">Due for return</p>
                </div>

                <!-- Fees Card (Mockup) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-red-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Fee Status</div>
                    <div class="mt-2 text-xl font-bold text-green-600">Paid</div>
                    <p class="text-xs text-gray-500 mt-1">Next due: 15th Feb</p>
                    <div class="mt-4">
                         <a href="{{ route('student.fees') }}" class="text-indigo-600 hover:text-indigo-900 text-sm">View Details &rarr;</a>
                    </div>
                </div>
            </div>

            <!-- Recent Marks -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Recent Marks</h3>
                        <a href="{{ route('student.marks') }}" class="text-indigo-600 hover:text-indigo-900 text-sm">View All</a>
                    </div>
                    @if($recentMarks->isNotEmpty())
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($recentMarks as $mark)
                                        <tr>
                                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $mark->subject->name }}</td>
                                            <td class="px-4 py-3 text-sm text-gray-500">{{ $mark->exam_type }}</td>
                                            <td class="px-4 py-3 text-sm font-bold text-gray-900">{{ $mark->marks_obtained }} / {{ $mark->total_marks }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 italic">No marks recorded recently.</p>
                    @endif
                </div>
            </div>

            @endif
        </div>
    </div>
</x-app-layout>
