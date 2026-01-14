<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Collect Fees') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-6">Select Student</h3>
                    <form action="{{ route('admin.fees.collect.show') }}" method="GET" class="max-w-xl">
                        <div class="mb-4">
                            <x-input-label for="admin_student_id" value="Search Student" />
                            <select id="admin_student_id" name="admin_student_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Student</option>
                                @foreach($classes as $class)
                                    <optgroup label="{{ $class->name }}">
                                        @foreach($class->students as $student)
                                            <option value="{{ $student->id }}">{{ $student->user->name }} (Roll: {{ $student->roll_no }})</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-primary-button>Proceed to Collect Fees</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
