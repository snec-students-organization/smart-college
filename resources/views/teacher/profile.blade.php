<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Profile Setup') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold">Personal & Professional Information</h3>
                        <p class="text-sm text-gray-500">Please complete your profile to enable all features.</p>
                    </div>

                    <form action="{{ route('teacher.profile.update') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Gender -->
                            <div>
                                <x-input-label for="gender" :value="__('Gender')" />
                                <select name="gender" id="gender" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">-- Select Gender --</option>
                                    <option value="male" {{ (old('gender', $teacher->gender ?? '')) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ (old('gender', $teacher->gender ?? '')) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ (old('gender', $teacher->gender ?? '')) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>

                            <!-- Phone -->
                            <div>
                                <x-input-label for="phone" :value="__('Phone Number')" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $teacher->phone ?? '')" placeholder="e.g. +1234567890" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <!-- Qualification -->
                            <div>
                                <x-input-label for="qualification" :value="__('Qualification')" />
                                <x-text-input id="qualification" class="block mt-1 w-full" type="text" name="qualification" :value="old('qualification', $teacher->qualification ?? '')" placeholder="e.g. B.Ed, M.Sc Mathematics" />
                                <x-input-error :messages="$errors->get('qualification')" class="mt-2" />
                            </div>

                            <!-- Date of Birth -->
                            <div>
                                <x-input-label for="dob" :value="__('Date of Birth')" />
                                <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob" :value="old('dob', isset($teacher->dob) ? $teacher->dob->format('Y-m-d') : '')" />
                                <x-input-error :messages="$errors->get('dob')" class="mt-2" />
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <x-input-label for="address" :value="__('Address')" />
                                <textarea id="address" name="address" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('address', $teacher->address ?? '') }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end gap-4">
                            <a href="{{ route('teacher.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Save Profile') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
