<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Issue Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.library.issue.store') }}" method="POST">
                        @csrf
                        
                        <!-- Book Selection -->
                        <div class="mb-4">
                            <x-input-label for="book_id" value="Select Book" />
                            <select id="book_id" name="book_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm select2" required>
                                <option value="">-- Choose Book --</option>
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}">{{ $book->title }} ({{ $book->quantity }} available)</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Student Selection (Simplified for now - listing all students could be huge, but ok for MVP) -->
                        <div class="mb-4">
                            <x-input-label for="student_id" value="Select Student" />
                             <!-- Ideally this would be AJAX or filtered by class first -->
                             <select id="student_id" name="student_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">-- Choose Student --</option>
                                @foreach($classes as $class)
                                    <optgroup label="{{ $class->name }}">
                                        @foreach($class->students as $student) <!-- Assuming relation exists -->
                                            <option value="{{ $student->id }}">{{ $student->user->name }} (Roll: {{ $student->roll_no }})</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                             <!-- Note: accessing class->students requires the relationship 'students' on SchoolClass model which might not be eager loaded or defined yet in the controller passed data properly. 
                                  Let's check SchoolClass model. It has many students? 
                                  Wait, SchoolClass model usually hasMany Students? 
                                  Let's check. 
                             -->
                        </div>

                        <!-- Due Date -->
                        <div class="mb-6">
                            <x-input-label for="due_date" value="Due Date" />
                            <x-text-input id="due_date" type="date" name="due_date" class="block mt-1 w-full" :value="now()->addDays(14)->format('Y-m-d')" required />
                        </div>

                        <div class="flex justify-end">
                            <x-secondary-button type="button" class="mr-3" onclick="window.history.back()">Cancel</x-secondary-button>
                            <x-primary-button>Issue Book</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
