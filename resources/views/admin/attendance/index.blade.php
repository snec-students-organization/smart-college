<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Class Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Filter Section -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Filter Attendance') }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Select Class, Section, and Date to view attendance records.") }}
                        </p>
                    </div>
                    <a href="{{ route('admin.attendance.report') }}"
                        class="text-indigo-600 hover:text-indigo-900 font-medium">
                        View Monthly Report &rarr;
                    </a>
                </header>

                <form method="GET" action="{{ route('admin.attendance.index') }}" class="mt-6 space-y-6">
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

                        <!-- Date -->
                        <div>
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date"
                                :value="request('date', date('Y-m-d'))" required />
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Show Attendance') }}</x-primary-button>
                    </div>
                </form>
            </div>

            <!-- Summary & Results Section -->
            @if(isset($attendanceData))
                <!-- Summary Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    <div class="bg-blue-100 p-4 rounded-lg shadow-sm text-center">
                        <div class="text-2xl font-bold text-blue-800">{{ $summary['total'] }}</div>
                        <div class="text-xs font-semibold text-blue-600 uppercase">Total Students</div>
                    </div>
                    <div class="bg-green-100 p-4 rounded-lg shadow-sm text-center">
                        <div class="text-2xl font-bold text-green-800">{{ $summary['present'] }}</div>
                        <div class="text-xs font-semibold text-green-600 uppercase">Present</div>
                    </div>
                    <div class="bg-red-100 p-4 rounded-lg shadow-sm text-center">
                        <div class="text-2xl font-bold text-red-800">{{ $summary['absent'] }}</div>
                        <div class="text-xs font-semibold text-red-600 uppercase">Absent</div>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-lg shadow-sm text-center">
                        <div class="text-2xl font-bold text-yellow-800">{{ $summary['late'] }}</div>
                        <div class="text-xs font-semibold text-yellow-600 uppercase">Late</div>
                    </div>
                    <div class="bg-orange-100 p-4 rounded-lg shadow-sm text-center">
                        <div class="text-2xl font-bold text-orange-800">{{ $summary['half_day'] }}</div>
                        <div class="text-xs font-semibold text-orange-600 uppercase">Half Day</div>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg shadow-sm text-center">
                        <div class="text-2xl font-bold text-gray-800">{{ $summary['not_marked'] }}</div>
                        <div class="text-xs font-semibold text-gray-600 uppercase">Not Marked</div>
                    </div>
                </div>

                <!-- Students Table -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Roll No</th>
                                    <th scope="col" class="px-6 py-3">Student Name</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Remark</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendanceData as $data)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $data['student']->roll_no ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $data['student']->user->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            @php
                                                $statusColors = [
                                                    'present' => 'bg-green-100 text-green-800',
                                                    'absent' => 'bg-red-100 text-red-800',
                                                    'late' => 'bg-yellow-100 text-yellow-800',
                                                    'half_day' => 'bg-orange-100 text-orange-800',
                                                    'not_marked' => 'bg-gray-100 text-gray-800'
                                                ];
                                                $colorClass = $statusColors[$data['status']] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span
                                                class="{{ $colorClass }} text-xs font-medium mr-2 px-2.5 py-0.5 rounded uppercase">
                                                {{ str_replace('_', ' ', $data['status']) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $data['remark'] ?? '-' }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center">No students found.</td>
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

            classSelect.addEventListener('change', functio n() {
                loadSections(this.value);
        });

        // Initial load if class is selected
        if (classSelect.value) {
            loadSections(classSelect.value, selectedSectionId);
        }
        });
    </script>
</x-app-layout>