<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Uploaded Marks') }}
            </h2>
            <a href="{{ route('teacher.marks.index') }}" class="inline-flex items-center px-4 py-2 bg-brand-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-700 focus:bg-brand-700 active:bg-brand-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Upload New Marks
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('teacher.marks.list') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                        <div>
                            <x-input-label for="class_id" :value="__('Class')" />
                            <select id="class_id" name="class_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">All Classes</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="section_id" :value="__('Section')" />
                            <select id="section_id" name="section_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">All Sections</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="subject_id" :value="__('Subject')" />
                            <select id="subject_id" name="subject_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">All Subjects</option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="exam_type" :value="__('Exam Type')" />
                            <select id="exam_type" name="exam_type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">All Exams</option>
                                <option value="Mid Term" {{ request('exam_type') == 'Mid Term' ? 'selected' : '' }}>Mid Term</option>
                                <option value="Final" {{ request('exam_type') == 'Final' ? 'selected' : '' }}>Final</option>
                                <option value="Class Test" {{ request('exam_type') == 'Class Test' ? 'selected' : '' }}>Class Test</option>
                            </select>
                        </div>

                        <div>
                            <x-primary-button class="w-full justify-center">Filter</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class/Section</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exam</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Marks</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($marks as $mark)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $mark->student->user->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $mark->student->school_class->name }} - {{ $mark->student->section->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $mark->subject->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $mark->exam_type }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                            {{ $mark->marks_obtained }} / {{ $mark->total_marks }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $mark->created_at->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No marks found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $marks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const classSelect = document.getElementById('class_id');
            const sectionSelect = document.getElementById('section_id');
            const subjectSelect = document.getElementById('subject_id');

            function loadOptions(classId, selectedSection = null, selectedSubject = null) {
                if (!classId) return;

                // Load Sections
                fetch(`/lookup/classes/${classId}/sections`)
                    .then(response => response.json())
                    .then(data => {
                        sectionSelect.innerHTML = '<option value="">All Sections</option>';
                        data.forEach(section => {
                            const option = document.createElement('option');
                            option.value = section.id;
                            option.textContent = section.name;
                            if (selectedSection == section.id) option.selected = true;
                            sectionSelect.appendChild(option);
                        });
                    });

                // Load Subjects
                fetch(`/lookup/classes/${classId}/subjects`)
                    .then(response => response.json())
                    .then(data => {
                        subjectSelect.innerHTML = '<option value="">All Subjects</option>';
                        data.forEach(subject => {
                            const option = document.createElement('option');
                            option.value = subject.id;
                            option.textContent = `${subject.name} (${subject.code})`;
                            if (selectedSubject == subject.id) option.selected = true;
                            subjectSelect.appendChild(option);
                        });
                    });
            }

            classSelect.addEventListener('change', function() {
                loadOptions(this.value);
            });

            // Initial load if class is selected
            if (classSelect.value) {
                loadOptions(classSelect.value, "{{ request('section_id') }}", "{{ request('subject_id') }}");
            }
        });
    </script>
</x-app-layout>
