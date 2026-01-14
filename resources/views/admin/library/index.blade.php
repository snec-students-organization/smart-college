<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Library Books') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Add Book Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Add New Book</h3>
                    <form action="{{ route('admin.library.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 items-end">
                        @csrf
                        <div class="lg:col-span-2">
                            <x-input-label for="title" value="Book Title" />
                            <x-text-input id="title" name="title" class="block mt-1 w-full" required />
                        </div>
                        <div class="lg:col-span-1">
                            <x-input-label for="author" value="Author" />
                            <x-text-input id="author" name="author" class="block mt-1 w-full" required />
                        </div>
                         <div class="lg:col-span-1">
                            <x-input-label for="isbn" value="ISBN" />
                            <x-text-input id="isbn" name="isbn" class="block mt-1 w-full" />
                        </div>
                        <div class="lg:col-span-1">
                            <x-input-label for="quantity" value="Qty" />
                            <x-text-input id="quantity" type="number" name="quantity" class="block mt-1 w-full" min="1" value="1" required />
                        </div>
                         <div class="lg:col-span-1">
                            <x-primary-button class="w-full justify-center">Add</x-primary-button>
                        </div>
                    </form>
                    <x-input-error :messages="$errors->all()" class="mt-2" />
                </div>
            </div>

            <!-- Book List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                         <h3 class="text-lg font-semibold">Book Inventory</h3>
                         <a href="{{ route('admin.library.circulation') }}" class="text-indigo-600 hover:text-indigo-900">Go to Circulation &rarr;</a>
                    </div>
                   
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ISBN</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($books as $book)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $book->title }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $book->author }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $book->isbn ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $book->quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <form action="{{ route('admin.library.destroy', $book) }}" method="POST" onsubmit="return confirm('Delete this book?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $books->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
