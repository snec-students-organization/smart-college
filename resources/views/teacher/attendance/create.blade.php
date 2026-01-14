<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mark Attendance') }} - {{ $class->name }} ({{ $section->name }}) - {{ $date }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('teacher.attendance.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="class_id" value="{{ $class->id }}">
                        <input type="hidden" name="section_id" value="{{ $section->id }}">
                        <input type="hidden" name="date" value="{{ $date }}">

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 mb-6">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roll No</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remark</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($students as $student)
                                        @php
                                            $existingStatus = $attendance[$student->id]->status ?? 'present';
                                            $existingRemark = $attendance[$student->id]->remark ?? '';
                                        @endphp
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->roll_no ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center space-x-4">
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="attendance[{{ $student->id }}]" value="present" class="form-radio text-indigo-600" {{ $existingStatus == 'present' ? 'checked' : '' }}>
                                                        <span class="ml-2 text-sm text-gray-700">Present</span>
                                                    </label>
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="attendance[{{ $student->id }}]" value="absent" class="form-radio text-red-600" {{ $existingStatus == 'absent' ? 'checked' : '' }}>
                                                        <span class="ml-2 text-sm text-gray-700">Absent</span>
                                                    </label>
                                                    <label class="inline-flex items-center">
                                                        <input type="radio" name="attendance[{{ $student->id }}]" value="late" class="form-radio text-yellow-500" {{ $existingStatus == 'late' ? 'checked' : '' }}>
                                                        <span class="ml-2 text-sm text-gray-700">Late</span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="text" name="remarks[{{ $student->id }}]" value="{{ $existingRemark }}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm w-full" placeholder="Optional">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-end">
                            <x-secondary-button type="button" class="mr-3" onclick="window.history.back()">Cancel</x-secondary-button>
                            <x-primary-button>Save Attendance</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
