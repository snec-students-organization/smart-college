<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mark Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('teacher.attendance.create') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        
                        <!-- Class -->
                        <div>
                            <x-input-label for="class_id" :value="__('Class')" />
                            <select id="class_id" name="class_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Section -->
                        <div>
                            <x-input-label for="section_id" :value="__('Section')" />
                            <select id="section_id" name="section_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Section</option>
                            </select>
                        </div>

                        <!-- Date -->
                        <div>
                            <x-input-label for="date" :value="__('Date')" />
                            <x-text-input id="date" class="block mt-1 w-full" type="date" name="date" :value="date('Y-m-d')" required />
                        </div>

                        <div>
                            <x-primary-button class="w-full justify-center">Proceed</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const classSelect = document.getElementById('class_id');
            const sectionSelect = document.getElementById('section_id');

            classSelect.addEventListener('change', function() {
                const classId = this.value;
                sectionSelect.innerHTML = '<option value="">Select Section</option>';

                if (classId) {
                    fetch(`/lookup/classes/${classId}/sections`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(section => {
                                const option = document.createElement('option');
                                option.value = section.id;
                                option.textContent = section.name;
                                sectionSelect.appendChild(option);
                            });
                        });
                }
            });
        });
    </script>
</x-app-layout>
