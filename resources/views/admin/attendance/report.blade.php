<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Monthly Attendance Report') }}
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
                            {{ __("Select Class, Section, and Month to view the monthly report.") }}
                        </p>
                    </div>
                    <a href="{{ route('admin.attendance.index') }}"
                        class="text-indigo-600 hover:text-indigo-900 font-medium">
                        &larr; Back to Daily Attendance
                    </a>
                </header>

                <form method="GET" action="{{ route('admin.attendance.report') }}" class="mt-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Class -->
                        <div>
                            <x-input-label for="class_id" :value="__('Class')" />
                            <select id="class_id" name="class_id"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Section -->
                        <div>
                            <x-input-label for="section_id" :value="__('Section')" />
                            <select id="section_id" name="section_id"
                                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required>
                                <option value="">Select Section</option>
                            </select>
                        </div>

                        <!-- Month -->
                        <div>
                            <x-input-label for="month" :value="__('Month')" />
                            <x-text-input id="month" class="block mt-1 w-full" type="month" name="month"
                                :value="request('month', date('Y-m'))" required />
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Generate Report') }}</x-primary-button>
                        
                        @if(isset($reportData))
                            <a href="{{ route('admin.attendance.report.excel', request()->all()) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:bg-green-700 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Export Excel') }}
                            </a>
                            <a href="{{ route('admin.attendance.report.pdf', request()->all()) }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-700 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Roll No</th>
                                    <th scope="col" class="px-6 py-3">Student Name</th>
                                    <th scope="col" class="px-6 py-3 text-center">Present</th>
                                    <th scope="col" class="px-6 py-3 text-center">Absent</th>
                                    <th scope="col" class="px-6 py-3 text-center">Late</th>
                                    <th scope="col" class="px-6 py-3 text-center">Half Day</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reportData as $data)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $data['student']->roll_no ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $data['student']->user->name }}
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                                {{ $data['present'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                                {{ $data['absent'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                                {{ $data['late'] }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span
                                                class="bg-orange-100 text-orange-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                                                {{ $data['half_day'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center">No students found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const classSelect = document.getElementById('class_id');
            const sectionSelect = document.getElementById('section_id');
            const selectedSectionId = "{{ request('section_id') }}";

            function loadSections(classId, selectedId = null) {
                sectionSelect.innerHTML = '<option value="">Select Section</option>';
                if (classId) {
                    fetch(`/lookup/classes/${classId}/sections`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(section => {
                                const option = document.createElement('option');
                                option.value = section.id;
                                option.textContent = section.name;
                                if (selectedId && section.id == selectedId) {
                                    option.selected = true;
                                }
                                sectionSelect.appendChild(option);
                            });
                        });
                }
            }

            classSelect.addEventListener('change', function () {
                loadSections(this.value);
            });

            // Initial load if class is selected
            if (classSelect.value) {
                loadSections(classSelect.value, selectedSectionId);
            }
        });
    </script>
</x-app-layout>