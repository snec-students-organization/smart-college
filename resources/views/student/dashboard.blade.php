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

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Today's Timetable -->
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-indigo-700">Today's Schedule ({{ date('l') }})</h3>
                            <span class="text-xs font-medium px-2 py-1 bg-indigo-50 text-indigo-700 rounded-full">Section: {{ $student->school_class->name }} - {{ $student->section->name }}</span>
                        </div>
                        
                        @if($timetable->isNotEmpty())
                            <div class="relative">
                                <div class="absolute top-0 bottom-0 left-4 w-0.5 bg-gray-100"></div>
                                <div class="space-y-6 relative">
                                    @foreach($timetable as $period)
                                        <div class="flex items-start gap-4">
                                            <div class="z-10 w-8 h-8 rounded-full bg-white border-2 border-indigo-500 flex items-center justify-center text-xs font-bold text-indigo-600">
                                                {{ $period->period_number }}
                                            </div>
                                            <div class="flex-1 bg-gray-50 rounded-lg p-3 border border-gray-100 hover:border-indigo-200 transition-colors">
                                                <div class="flex justify-between items-start">
                                                    <h4 class="font-bold text-gray-900">{{ $period->subject->name }}</h4>
                                                    <span class="text-xs font-medium text-gray-500 bg-white px-2 py-1 rounded border">
                                                        {{ \Carbon\Carbon::parse($period->start_time)->format('h:i A') }}
                                                    </span>
                                                </div>
                                                <div class="text-sm text-gray-600 mt-1">Teacher: {{ $period->teacher->user->name }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="text-center py-6 bg-gray-50 rounded-lg border border-dashed text-gray-500">
                                <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p>No periods scheduled for today.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Class Teacher info -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                         <h3 class="text-lg font-semibold mb-4 text-gray-800">Class Information</h3>
                         <div class="space-y-4">
                            <div class="p-4 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white">
                                <div class="text-xs uppercase opacity-75 mb-1 font-semibold">Class Teacher</div>
                                <div class="text-xl font-bold">{{ $student->section->class_teacher->user->name ?? 'Not Assigned' }}</div>
                                @if($student->section->class_teacher)
                                    <div class="text-xs mt-2 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        {{ $student->section->class_teacher->phone ?? 'Ask administration' }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center justify-between p-3 border rounded-lg">
                                <span class="text-sm text-gray-600 font-medium">Classroom</span>
                                <span class="text-sm font-bold text-gray-900">{{ $student->school_class->name }} - {{ $student->section->name }}</span>
                            </div>

                            <div class="flex items-center justify-between p-3 border rounded-lg">
                                <span class="text-sm text-gray-600 font-medium">Total Students</span>
                                <span class="text-sm font-bold text-gray-900">{{ $student->section->students->count() }}</span>
                            </div>
                         </div>
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
