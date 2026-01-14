<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Classes & Sections') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Add New Class Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Add New Class</h3>
                    <form action="{{ route('admin.classes.store') }}" method="POST" class="flex gap-4">
                        @csrf
                        <div class="flex-1">
                            <x-text-input name="name" placeholder="Class Name (e.g. Class 10)" class="w-full" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <x-primary-button>Add Class</x-primary-button>
                    </form>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($classes as $class)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-xl font-bold">{{ $class->name }}</h4>
                                <form action="{{ route('admin.classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Delete this class? All sections and students within will be affected.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Delete Class</button>
                                </form>
                            </div>

                            <div class="mb-4">
                                <h5 class="text-sm font-semibold text-gray-500 mb-2">Sections</h5>
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($class->sections as $section)
                                        <li class="text-sm flex justify-between items-center group">
                                            <span>Section {{ $section->name }}</span>
                                            <form action="{{ route('admin.classes.sections.destroy', $section) }}" method="POST" class="hidden group-hover:block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-600 text-xs">Remove</button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                                @if($class->sections->isEmpty())
                                    <p class="text-xs text-gray-400 italic">No sections added.</p>
                                @endif
                            </div>

                            <div class="mt-4 border-t pt-4">
                                <form action="{{ route('admin.classes.sections.store', $class) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    <x-text-input name="name" placeholder="Section (e.g. A)" class="w-full text-sm py-1" required />
                                    <x-secondary-button type="submit" class="text-xs">Add</x-secondary-button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>
