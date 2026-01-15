<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Timetable') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Selection Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.timetable.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                        <div class="flex-1 min-w-[200px]">
                            <x-input-label for="section_id" :value="__('Select Section')" />
                            <select name="section_id" id="section_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">-- Choose Section --</option>
                                @foreach($classes as $class)
                                    <optgroup label="{{ $class->name }}">
                                        @foreach($class->sections as $section)
                                            <option value="{{ $section->id }}" {{ request('section_id') == $section->id ? 'selected' : '' }}>
                                                {{ $class->name }} - {{ $section->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <x-primary-button>
                            {{ __('Filter') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>

            @if($selected_section)
                <!-- Class Teacher Management -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6 border-l-4 border-indigo-500">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Section: {{ $selected_section->school_class->name }} - {{ $selected_section->name }}</h3>
                            <div class="text-sm font-medium">
                                Class Teacher: 
                                <span class="text-indigo-600">
                                    {{ $selected_section->class_teacher->user->name ?? 'Not Assigned' }}
                                </span>
                            </div>
                        </div>
                        <form action="{{ route('admin.timetable.assign-teacher') }}" method="POST" class="flex items-end gap-4">
                            @csrf
                            <input type="hidden" name="section_id" value="{{ $selected_section->id }}">
                            <div class="flex-1">
                                <x-input-label for="teacher_id" :value="__('Update Class Teacher')" />
                                <select name="teacher_id" id="teacher_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">-- No Teacher --</option>
                                    @php $allTeachers = \App\Models\Teacher::with('user')->get(); @endphp
                                    @foreach($allTeachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ $selected_section->class_teacher_id == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <x-secondary-button type="submit">
                                {{ __('Assign') }}
                            </x-secondary-button>
                        </form>
                    </div>
                </div>

                <!-- Timetable Management -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-semibold">Timetable Weekly Schedule</h3>
                            <a href="{{ route('admin.timetable.create', ['section_id' => $selected_section->id]) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                Add Period
                            </a>
                        </div>

                        @if(count($timetables) > 0)
                            <div class="space-y-8">
                                @php 
                                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                @endphp
                                @foreach($days as $day)
                                    @if(isset($timetables[$day]))
                                        <div>
                                            <h4 class="font-bold text-gray-700 border-b pb-2 mb-4">{{ $day }}</h4>
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                                @foreach($timetables[$day] as $period)
                                                    <div class="p-4 rounded-lg border bg-gray-50 relative group">
                                                        <div class="text-xs font-semibold text-indigo-600 mb-1">Period {{ $period->period_number }}</div>
                                                        <div class="font-bold text-gray-900">{{ $period->subject->name }}</div>
                                                        <div class="text-sm text-gray-600">{{ $period->teacher->user->name }}</div>
                                                        <div class="text-xs text-gray-500 mt-2">
                                                            {{ \Carbon\Carbon::parse($period->start_time)->format('h:i A') }} - 
                                                            {{ \Carbon\Carbon::parse($period->end_time)->format('h:i A') }}
                                                        </div>
                                                        
                                                        <div class="mt-4 pt-3 border-t flex justify-between items-center">
                                                            <a href="{{ route('admin.timetable.edit', $period->id) }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.138 6.638a2.25 2.25 0 113.182 3.182L12 17H9v-3l7.138-7.138z"></path></svg>
                                                                Edit
                                                            </a>
                                                            <form action="{{ route('admin.timetable.destroy', $period->id) }}" method="POST" onsubmit="return confirm('Delete this period?')">
                                                                @csrf @method('DELETE')
                                                                <button type="submit" class="text-xs font-bold text-red-600 hover:text-red-800 flex items-center gap-1">
                                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-12 text-gray-500 italic">
                                No periods scheduled yet for this section.
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12 text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p>Please select a section to view and manage its timetable.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
