<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Monthly Attendance Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Filter Section -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Generate Report') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Select Month to view the monthly report.") }}
                        </p>
                    </div>
                    <a href="{{ route('admin.attendance.teachers.index') }}"
                        class="text-indigo-600 hover:text-indigo-900 font-medium">
                        &larr; Back to Daily Attendance
                    </a>
                </header>

                <form method="GET" action="{{ route('admin.attendance.teachers.report') }}"
                    class="mt-6 flex items-center gap-4">
                    <div class="flex-grow max-w-xs">
                        <x-input-label for="month" :value="__('Month')" />
                        <x-text-input id="month" class="block mt-1 w-full" type="month" name="month"
                            :value="request('month', date('Y-m'))" required />
                    </div>

                    <div class="mt-6 flex gap-3">
                        <x-primary-button>{{ __('Generate Report') }}</x-primary-button>

                        @if(isset($reportData))
                            <a href="{{ route('admin.attendance.teachers.report.excel', request()->all()) }}"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-700 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Export Excel') }}
                            </a>
                            <a href="{{ route('admin.attendance.teachers.report.pdf', request()->all()) }}"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-700 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Export PDF') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Report Table -->
            @if(isset($reportData))
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <header class="mb-4">
                        <h3 class="text-lg font-bold text-gray-900">
                            Report for {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}
                        </h3>
                    </header>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left text-gray-500 border-collapse">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th scope="col" class="px-2 py-3 border sticky left-0 bg-gray-50 z-10 min-w-[150px]">
                                        Teacher Name</th>
                                    @foreach($dates as $date)
                                        <th scope="col" class="px-1 py-3 text-center border min-w-[30px]">
                                            {{ \Carbon\Carbon::parse($date)->format('d') }}
                                        </th>
                                    @endforeach
                                    <th scope="col" class="px-2 py-3 text-center border bg-gray-50 text-green-700">P</th>
                                    <th scope="col" class="px-2 py-3 text-center border bg-gray-50 text-red-700">A</th>
                                    <th scope="col" class="px-2 py-3 text-center border bg-gray-50 text-yellow-700">L</th>
                                    <th scope="col" class="px-2 py-3 text-center border bg-gray-50 text-blue-700">Le</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reportData as $data)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td
                                            class="px-2 py-2 font-medium text-gray-900 whitespace-nowrap border sticky left-0 bg-white z-10">
                                            {{ $data['teacher']->user->name }}
                                        </td>
                                        @foreach($dates as $date)
                                            @php
                                                $status = $data['attendance_by_date'][$date];
                                                $colorClass = match ($status) {
                                                    'P' => 'bg-green-100 text-green-800',
                                                    'A' => 'bg-red-100 text-red-800',
                                                    'L' => 'bg-yellow-100 text-yellow-800',
                                                    'Le' => 'bg-blue-100 text-blue-800',
                                                    default => 'text-gray-300'
                                                };
                                            @endphp
                                            <td class="px-1 py-2 text-center border">
                                                <span class="{{ $colorClass }} text-[10px] font-bold px-1 py-0.5 rounded">
                                                    {{ $status }}
                                                </span>
                                            </td>
                                        @endforeach
                                        <td class="px-2 py-2 text-center border font-bold text-green-700 bg-gray-50">
                                            {{ $data['present'] }}</td>
                                        <td class="px-2 py-2 text-center border font-bold text-red-700 bg-gray-50">
                                            {{ $data['absent'] }}</td>
                                        <td class="px-2 py-2 text-center border font-bold text-yellow-700 bg-gray-50">
                                            {{ $data['late'] }}</td>
                                        <td class="px-2 py-2 text-center border font-bold text-blue-700 bg-gray-50">
                                            {{ $data['leave'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ count($dates) + 5 }}" class="px-6 py-4 text-center">No teachers found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>