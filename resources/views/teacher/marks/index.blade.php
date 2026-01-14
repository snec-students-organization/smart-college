<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Enter Marks') }}
            </h2>
            <a href="{{ route('teacher.marks.list') }}" class="inline-flex items-center px-4 py-2 bg-brand-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 focus:bg-brand-700 active:bg-brand-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                View Uploaded Marks
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('teacher.marks.create') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                        
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

                        <!-- Subject -->
                        <div>
                            <x-input-label for="subject_id" :value="__('Subject')" />
                            <select id="subject_id" name="subject_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Subject</option>
                            </select>
                        </div>

                        <!-- Exam Type -->
                        <div>
                            <x-input-label for="exam_type" :value="__('Exam Type')" />
                            <select id="exam_type" name="exam_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Exam Type</option>
                                <option value="Mid Term">Mid Term</option>
                                <option value="Final">Final</option>
                                <option value="Class Test">Class Test</option>
                            </select>
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
            const subjectSelect = document.getElementById('subject_id');

            classSelect.addEventListener('change', function() {
                const classId = this.value;
                
                // Clear dropdowns
                sectionSelect.innerHTML = '<option value="">Select Section</option>';
                subjectSelect.innerHTML = '<option value="">Select Subject</option>';

                if (classId) {
                    // Fetch Sections
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

                    // Fetch Subjects
                    fetch(`/lookup/classes/${classId}/subjects`)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(subject => {
                                const option = document.createElement('option');
                                option.value = subject.id;
                                option.textContent = `${subject.name} (${subject.code})`;
                                subjectSelect.appendChild(option);
                            });
                        });
                }
            });
        });
    </script>
</x-app-layout>
