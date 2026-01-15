<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ isset($timetable) ? __('Edit Period') : __('Add New Period') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-bold">Section: {{ $section->school_class->name }} - {{ $section->name }}</h3>
                    </div>

                    <form action="{{ isset($timetable) ? route('admin.timetable.update', $timetable->id) : route('admin.timetable.store') }}" method="POST">
                        @csrf
                        @if(isset($timetable))
                            @method('PUT')
                        @else
                            <input type="hidden" name="section_id" value="{{ $section->id }}">
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Day -->
                            <div>
                                <x-input-label for="day" :value="__('Day')" />
                                <select name="day" id="day" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    @foreach($days as $day)
                                        <option value="{{ $day }}" {{ (old('day', $timetable->day ?? '')) == $day ? 'selected' : '' }}>{{ $day }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('day')" class="mt-2" />
                            </div>

                            <!-- Period Number -->
                            <div>
                                <x-input-label for="period_number" :value="__('Period Number')" />
                                <x-text-input id="period_number" class="block mt-1 w-full" type="number" name="period_number" :value="old('period_number', $timetable->period_number ?? '')" required />
                                <x-input-error :messages="$errors->get('period_number')" class="mt-2" />
                            </div>

                            <!-- Subject -->
                            <div>
                                <x-input-label for="subject_id" :value="__('Subject')" />
                                <select name="subject_id" id="subject_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">-- Choose Subject --</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ (old('subject_id', $timetable->subject_id ?? '')) == $subject->id ? 'selected' : '' }}>{{ $subject->name }} ({{ $subject->code }})</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('subject_id')" class="mt-2" />
                            </div>

                            <!-- Teacher -->
                            <div>
                                <x-input-label for="teacher_id" :value="__('Teacher')" />
                                <select name="teacher_id" id="teacher_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">-- Choose Teacher --</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ (old('teacher_id', $timetable->teacher_id ?? '')) == $teacher->id ? 'selected' : '' }}>{{ $teacher->user->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('teacher_id')" class="mt-2" />
                            </div>

                            <!-- Start Time -->
                            <div>
                                <x-input-label for="start_time" :value="__('Start Time')" />
                                <x-text-input id="start_time" class="block mt-1 w-full" type="time" name="start_time" :value="old('start_time', $timetable->start_time ?? '')" required />
                                <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
                            </div>

                            <!-- End Time -->
                            <div>
                                <x-input-label for="end_time" :value="__('End Time')" />
                                <x-text-input id="end_time" class="block mt-1 w-full" type="time" name="end_time" :value="old('end_time', $timetable->end_time ?? '')" required />
                                <x-input-error :messages="$errors->get('end_time')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mt-8 flex justify-end gap-4">
                            <a href="{{ route('admin.timetable.index', ['section_id' => $section->id]) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ isset($timetable) ? __('Update Period') : __('Save Period') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
