<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Edit Student</h2>
                <a href="{{ route('admin.students.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to List
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6 sm:p-8">
                <form method="POST" action="{{ route('admin.students.update', $student) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Account Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Full Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $student->user->name)" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email Address')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $student->user->email)" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- DOB -->
                            <div>
                                <x-input-label for="dob" :value="__('Date of Birth')" />
                                <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="old('dob', $student->dob ? $student->dob->format('Y-m-d') : '')" required />
                                <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div>
                                <x-input-label for="password" :value="__('New Password (Optional)')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
                                <p class="text-xs text-gray-500 mt-1">Leave blank to keep current password.</p>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 mt-2">Academic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <!-- Admission No -->
                             <div>
                                <x-input-label for="admission_no" :value="__('Admission Number')" />
                                <x-text-input id="admission_no" class="block mt-1 w-full" type="text" name="admission_no" :value="old('admission_no', $student->admission_no)" required />
                                <x-input-error :messages="$errors->get('admission_no')" class="mt-2" />
                            </div>

                            <!-- Class -->
                            <div>
                                <x-input-label for="class_id" :value="__('Class')" />
                                <select id="class_id" name="class_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('class_id')" class="mt-2" />
                            </div>

                            <!-- Section -->
                            <div id="section-container">
                                <x-input-label for="section_id" :value="__('Section')" />
                                <select id="section_id" name="section_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Section</option>
                                    @foreach($sections as $section)
                                        <option value="{{ $section->id }}" {{ old('section_id', $student->section_id) == $section->id ? 'selected' : '' }}>
                                            {{ $section->name }} (Class {{ $section->school_class->name ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('section_id')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Update Student') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const classSelect = document.getElementById('class_id');
        const sectionSelect = document.getElementById('section_id');
        const initialSectionId = "{{ $student->section_id }}";

        const sectionContainer = document.getElementById('section-container');

        // Function to load sections
        function loadSections(classId, selectedSectionId = null) {
            sectionSelect.innerHTML = '<option value="">Select Section</option>';
            
            if (classId) {
                fetch(`/admin/classes/${classId}/sections`)
                    .then(response => response.json())
                    .then(data => {
                        // sectionContainer.style.display = 'block';
                        data.forEach(section => {
                            const option = document.createElement('option');
                            option.value = section.id;
                            option.textContent = section.name;
                            if (selectedSectionId && section.id == selectedSectionId) {
                                option.selected = true;
                            }
                            sectionSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching sections:', error));
            }
        }
        
        // Initial check logic removed, always show.

        // On change
        classSelect.addEventListener('change', function() {
            loadSections(this.value);
        });
        
        // Don't auto-load on edit since we are using backend blade to pre-select. 
        // But if we want to be safe or if the user changes class and changes back:
        // Actually, on edit load, Blade handles the initial state. 
        // We only need JS if the user changes the class.
    });
</script>
