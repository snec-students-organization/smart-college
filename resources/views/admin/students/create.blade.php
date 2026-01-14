<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Add New Student</h2>
                <a href="{{ route('admin.students.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to List
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6 sm:p-8">
                <form method="POST" action="{{ route('admin.students.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Account Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Full Name')" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email Address')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- DOB (Moved here as it's the password) -->
                            <div>
                                <x-input-label for="dob" :value="__('Date of Birth (Password)')" />
                                <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="old('dob')" required />
                                <p class="text-xs text-gray-500 mt-1">This will be used as the initial password (format: DDMMYYYY).</p>
                                <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 mt-2">Academic Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <!-- Admission No -->
                             <div>
                                <x-input-label for="admission_no" :value="__('Admission Number')" />
                                <x-text-input id="admission_no" class="block mt-1 w-full" type="text" name="admission_no" :value="old('admission_no')" required />
                                <x-input-error :messages="$errors->get('admission_no')" class="mt-2" />
                            </div>

                            <!-- Class -->
                            <div>
                                <x-input-label for="class_id" :value="__('Class')" />
                                <select id="class_id" name="class_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select Class</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
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
                                        <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                            {{ $section->name }} (Class {{ $section->school_class->name ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Make sure to select a section belonging to the selected class.</p>
                                <x-input-error :messages="$errors->get('section_id')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Create Student') }}
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
        const sectionContainer = document.getElementById('section-container');
        
        // Hide initially if no class selected - REMOVED
        // sectionContainer.style.display = 'none';

        classSelect.addEventListener('change', function() {
            const classId = this.value;
            sectionSelect.innerHTML = '<option value="">Select Section</option>';

            if (classId) {
                fetch(`/lookup/classes/${classId}/sections`)
                    .then(response => response.json())
                    .then(data => {
                        // Always show, just populate
                        // sectionContainer.style.display = 'block'; 
                        
                        // If we want to show it only if sections exist, we keep the logic. 
                        // But user asked to "show the section field".
                        // So we simply populate.
                        
                        data.forEach(section => {
                            const option = document.createElement('option');
                            option.value = section.id;
                            option.textContent = section.name;
                            sectionSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching sections:', error));
            }
        });
    });
</script>
