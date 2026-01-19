<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Filter Section -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Select Date') }}
                    </h2>
                </header>

                <form method="GET" action="{{ route('admin.attendance.teachers.index') }}"
                    class="mt-6 flex items-center gap-4">
                    <div class="flex-grow max-w-xs">
                        <x-input-label for="date" :value="__('Date')" />
                        <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="$date"
                            required />
                    </div>
                    <div class="mt-6">
                        <x-primary-button>{{ __('Filter') }}</x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Attendance Form -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header class="mb-6 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <h2 class="text-lg font-medium text-gray-900">
                            Attendance for {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}
                        </h2>
                        @if($isMarked)
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span>
                                Marked
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                <span class="w-2 h-2 mr-1 bg-yellow-500 rounded-full"></span>
                                Pending
                            </span>
                        @endif
                    </div>

                    <a href="{{ route('admin.attendance.teachers.report') }}"
                        class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">
                        View Monthly Report &rarr;
                    </a>
                </header>

                @if(session('success'))
                    <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.attendance.teachers.store') }}">
                    @csrf
                    <input type="hidden" name="date" value="{{ $date }}">

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Teacher Name</th>
                                    <th scope="col" class="px-6 py-3 text-center">Status</th>
                                    <th scope="col" class="px-6 py-3">Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teachers as $teacher)
                                    @php
                                        $attendance = $teacher->attendances->first();
                                        $status = $attendance ? $attendance->status : null;
                                        $remark = $attendance ? $attendance->remark : '';
                                    @endphp
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $teacher->user->name }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex justify-center gap-4">
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="attendance[{{ $teacher->id }}][status]"
                                                        value="present"
                                                        class="text-green-600 border-gray-300 focus:ring-green-500" {{ $status === 'present' || !$status ? 'checked' : '' }}>
                                                    <span class="ml-2 text-gray-700">Present</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="attendance[{{ $teacher->id }}][status]"
                                                        value="absent"
                                                        class="text-red-600 border-gray-300 focus:ring-red-500" {{ $status === 'absent' ? 'checked' : '' }}>
                                                    <span class="ml-2 text-gray-700">Absent</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="attendance[{{ $teacher->id }}][status]"
                                                        value="late"
                                                        class="text-yellow-600 border-gray-300 focus:ring-yellow-500" {{ $status === 'late' ? 'checked' : '' }}>
                                                    <span class="ml-2 text-gray-700">Late</span>
                                                </label>
                                                <label class="inline-flex items-center">
                                                    <input type="radio" name="attendance[{{ $teacher->id }}][status]"
                                                        value="leave"
                                                        class="text-blue-600 border-gray-300 focus:ring-blue-500" {{ $status === 'leave' ? 'checked' : '' }}>
                                                    <span class="ml-2 text-gray-700">Leave</span>
                                                </label>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <x-text-input name="attendance[{{ $teacher->id }}][remark]" :value="$remark"
                                                class="w-full text-xs" placeholder="Remark" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center">No teachers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-primary-button>{{ __('Save Attendance') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>