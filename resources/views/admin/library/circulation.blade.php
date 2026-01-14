<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Circulation (Issued Books)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Currently Issued Books</h3>
                        <a href="{{ route('admin.library.issue.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Issue New Book</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Book</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($issues as $issue)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $issue->book->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $issue->student->user->name }} <br>
                                            <span class="text-xs text-gray-500">{{ $issue->student->school_class->name }} - {{ $issue->student->section->name }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $issue->issue_date->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm 
                                            {{ $issue->due_date->isPast() ? 'text-red-600 font-bold' : 'text-gray-500' }}">
                                            {{ $issue->due_date->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <form action="{{ route('admin.library.return', $issue) }}" method="POST" onsubmit="return confirm('Return this book?');">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900">Mark Returned</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $issues->links() }}
                    </div>
                    @if($issues->isEmpty())
                        <p class="text-center text-gray-500 mt-4 italic">No books currently issued.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
