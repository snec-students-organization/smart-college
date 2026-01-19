<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fee Structures') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Add Fee Form -->
                <div class="md:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-semibold mb-4">Add Fee Master</h3>
                            <form action="{{ route('admin.fees.store') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <x-input-label for="class_id" value="Class" />
                                    <select id="class_id" name="class_id"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        required>
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="type" value="Fee Type" />
                                    <x-text-input id="type" name="type" class="block mt-1 w-full"
                                        placeholder="e.g. Annual, Tuition" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="amount" value="Amount" />
                                    <x-text-input id="amount" type="number" name="amount" class="block mt-1 w-full"
                                        step="0.01" required />
                                </div>
                                <div class="mb-4">
                                    <x-input-label for="due_date" value="Due Date" />
                                    <x-text-input id="due_date" type="date" name="due_date" class="block mt-1 w-full"
                                        required />
                                </div>
                                <div>
                                    <x-primary-button class="w-full justify-center">Save</x-primary-button>
                                </div>
                            </form>
                            <x-input-error :messages="$errors->all()" class="mt-2" />
                        </div>
                    </div>
                </div>

                <!-- Fee List -->
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-semibold mb-4">Fee Master List</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Class</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Type</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Amount</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Due Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($fees as $fee)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    {{ $fee->school_class->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $fee->type }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold">
                                                    ${{ number_format($fee->amount, 2) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    {{ $fee->due_date->format('d M Y') }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <form action="{{ route('admin.fees.destroy', $fee) }}" method="POST"
                                                        onsubmit="return confirm('Delete this fee structure?');"
                                                        class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-900 ml-3">Delete</button>
                                                    </form>
                                                    <a href="{{ route('admin.fees.status', $fee) }}"
                                                        class="text-indigo-600 hover:text-indigo-900 font-medium">View
                                                        Status</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                {{ $fees->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>