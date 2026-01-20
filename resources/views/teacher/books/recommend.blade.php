<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Recommend a Book') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-soft rounded-2xl">
                <div class="p-8">
                    <form action="{{ route('teacher.books.store-recommendation') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Book Selection -->
                        <div class="space-y-2">
                            <label for="book_id" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Select
                                Book</label>
                            <select name="book_id" id="book_id"
                                class="w-full px-4 py-3 rounded-xl border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all duration-200"
                                required>
                                <option value="">-- Choose a Book --</option>
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }} by {{ $book->author }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Recommendation Type -->
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-gray-700 uppercase tracking-wider">Recommend To</label>
                            <div class="flex gap-4">
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="type" value="section" class="hidden peer" checked
                                        onclick="toggleType('section')">
                                    <div
                                        class="p-4 border-2 border-gray-100 rounded-xl peer-checked:border-brand-500 peer-checked:bg-brand-50/50 transition-all text-center">
                                        <span class="font-bold text-gray-600 peer-checked:text-brand-700">Whole
                                            Section</span>
                                    </div>
                                </label>
                                <label class="flex-1 cursor-pointer">
                                    <input type="radio" name="type" value="individual" class="hidden peer"
                                        onclick="toggleType('individual')">
                                    <div
                                        class="p-4 border-2 border-gray-100 rounded-xl peer-checked:border-brand-500 peer-checked:bg-brand-50/50 transition-all text-center">
                                        <span class="font-bold text-gray-600 peer-checked:text-brand-700">Individual
                                            Student</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Section Selection -->
                        <div id="section_selector" class="space-y-2">
                            <label for="section_id"
                                class="text-sm font-bold text-gray-700 uppercase tracking-wider">Select Class &
                                Section</label>
                            <select name="section_id" id="section_id"
                                class="w-full px-4 py-3 rounded-xl border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all duration-200">
                                <option value="">-- Choose Section --</option>
                                @foreach($classes as $class)
                                    @foreach($class->sections as $section)
                                        <option value="{{ $section->id }}">{{ $class->name }} - {{ $section->name }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>

                        <!-- Individual Student Selection (Initially Hidden) -->
                        <div id="student_selector" class="space-y-2 hidden">
                            <label for="individual_student_id"
                                class="text-sm font-bold text-gray-700 uppercase tracking-wider">Select Student</label>
                            <div class="grid grid-cols-2 gap-4">
                                <select id="lookup_class_id"
                                    class="px-4 py-3 rounded-xl border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all duration-200">
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                                <select id="lookup_section_id"
                                    class="px-4 py-3 rounded-xl border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all duration-200">
                                    <option value="">Select Section</option>
                                </select>
                            </div>
                            <select name="student_id" id="student_id"
                                class="w-full mt-4 px-4 py-3 rounded-xl border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all duration-200">
                                <option value="">-- Choose Student --</option>
                            </select>
                        </div>

                        <!-- Notes -->
                        <div class="space-y-2">
                            <label for="notes" class="text-sm font-bold text-gray-700 uppercase tracking-wider">Notes /
                                Why this book?</label>
                            <textarea name="notes" id="notes" rows="4"
                                placeholder="Mention why you are recommending this book..."
                                class="w-full px-4 py-3 rounded-xl border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 transition-all duration-200"></textarea>
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                class="w-full py-4 bg-brand-600 text-white rounded-2xl font-bold text-lg shadow-lg shadow-brand-600/20 hover:bg-brand-700 hover:-translate-y-1 transition-all duration-300">
                                Send Recommendation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleType(type) {
            const sectionDiv = document.getElementById('section_selector');
            const studentDiv = document.getElementById('student_selector');

            if (type === 'section') {
                sectionDiv.classList.remove('hidden');
                studentDiv.classList.add('hidden');
                document.getElementById('student_id').required = false;
                document.getElementById('section_id').required = true;
            } else {
                sectionDiv.classList.add('hidden');
                studentDiv.classList.remove('hidden');
                document.getElementById('student_id').required = true;
                document.getElementById('section_id').required = false;
            }
        }

        // Student Lookup Logic
        document.getElementById('lookup_class_id').addEventListener('change', function () {
            const classId = this.value;
            const sectionSelect = document.getElementById('lookup_section_id');
            sectionSelect.innerHTML = '<option value="">Select Section</option>';

            if (classId) {
                fetch(`/lookup/classes/${classId}/sections`)
                    .then(r => r.json())
                    .then(sections => {
                        sections.forEach(s => {
                            const opt = document.createElement('option');
                            opt.value = s.id;
                            opt.textContent = s.name;
                            sectionSelect.appendChild(opt);
                        });
                    });
            }
        });

        document.getElementById('lookup_section_id').addEventListener('change', function () {
            const sectionId = this.value;
            const studentSelect = document.getElementById('student_id');
            studentSelect.innerHTML = '<option value="">Loading students...</option>';

            if (sectionId) {
                fetch(`/lookup/sections/${sectionId}/students`)
                    .then(r => r.json())
                    .then(students => {
                        studentSelect.innerHTML = '<option value="">-- Choose Student --</option>';
                        students.forEach(s => {
                            const opt = document.createElement('option');
                            opt.value = s.id;
                            opt.textContent = `${s.user.name} (Roll: ${s.roll_no})`;
                            studentSelect.appendChild(opt);
                        });
                    });
            }
        });
    </script>
</x-app-layout>