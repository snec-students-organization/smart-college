<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Parent Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(isset($error))
                 <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ $error }}</span>
                </div>
            @else

            <!-- Child Switcher (Only if multiple children) -->
            @if($children->count() > 1)
                <div class="mb-6 flex space-x-4 overflow-x-auto pb-2">
                    @foreach($children as $child)
                        <a href="{{ route('parent.dashboard', ['child_id' => $child->id]) }}" 
                           class="px-4 py-2 rounded-full border {{ $child->id === $student->id ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }} transition">
                            {{ $child->user->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            <!-- Selected Child Banner -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 border-l-4 border-indigo-500">
                    <h3 class="text-2xl font-bold mb-1">{{ $student->user->name }}</h3>
                    <p class="text-sm text-gray-600">
                        Class: {{ $student->school_class->name ?? '-' }} ({{ $student->section->name ?? '-' }}) | 
                        Roll No: {{ $student->roll_no ?? '-' }} | 
                        Admission No: {{ $student->admission_no ?? '-' }}
                    </p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Attendance Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-green-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Attendance</div>
                    <div class="mt-2 text-4xl font-bold text-gray-900">{{ $attendancePercentage }}%</div>
                    <p class="text-xs text-gray-500 mt-1">Overall Present</p>
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
                    <div class="mt-2 text-xl font-bold text-green-600">Clear</div>
                    <p class="text-xs text-gray-500 mt-1">No pending dues</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Recent Marks -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Recent Marks</h3>
                         @if($recentMarks->isNotEmpty())
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Exam</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Score</th>
                                        </tr>
                                    </thead>
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
                            <p class="text-gray-500 italic text-sm">No recent marks found.</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Attendance Log -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Recent Attendance</h3>
                        @if($recentAttendance->isNotEmpty())
                             <div class="space-y-3">
                                @foreach($recentAttendance as $record)
                                    <div class="flex items-center justify-between border-b pb-2 last:border-0">
                                        <span class="text-sm font-medium text-gray-700">{{ $record->date->format('d M, Y') }}</span>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-md 
                                            {{ $record->status === 'present' ? 'bg-green-100 text-green-700' : '' }}
                                            {{ $record->status === 'absent' ? 'bg-red-100 text-red-700' : '' }}
                                            {{ $record->status === 'late' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                                            {{ ucfirst($record->status) }}
                                        </span>
                                    </div>
                                @endforeach
                             </div>
                        @else
                            <p class="text-gray-500 italic text-sm">No recent attendance records.</p>
                        @endif
                    </div>
                </div>
            </div>

            @endif
        </div>
    </div>
</x-app-layout>
