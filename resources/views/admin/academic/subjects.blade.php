<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Subjects') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Add New Subject</h3>
                    <form action="{{ route('admin.subjects.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                        @csrf
                        <div>
                            <x-input-label for="name" value="Subject Name" />
                            <x-text-input id="name" name="name" class="block mt-1 w-full" placeholder="Mathematics" required />
                        </div>
                        <div>
                            <x-input-label for="code" value="Subject Code" />
                            <x-text-input id="code" name="code" class="block mt-1 w-full" placeholder="MATH101" required />
                        </div>
                        <div>
                            <x-input-label for="type" value="Type" />
                            <select id="type" name="type" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="theory">Theory</option>
                                <option value="practical">Practical</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="class_id" value="Class" />
                            <select id="class_id" name="class_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Select Class</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-primary-button class="w-full justify-center">Add Subject</x-primary-button>
                        </div>
                    </form>
                    <x-input-error :messages="$errors->all()" class="mt-2" />
                </div>
            </div>

            <!-- Class Tiles -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Subject List by Class</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($classes as $class)
                        <button type="button" 
                                onclick="selectClass({{ $class->id }}, '{{ $class->name }}')"
                                id="class-tile-{{ $class->id }}"
                                class="class-tile bg-white p-4 rounded-xl shadow-sm border-2 border-transparent hover:border-brand-300 hover:shadow-md transition-all duration-200 text-center group">
                            <div class="w-12 h-12 bg-brand-50 rounded-full flex items-center justify-center mx-auto mb-2 group-hover:bg-brand-100 transition-colors">
                                <svg class="w-6 h-6 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <span class="font-bold text-gray-800">{{ $class->name }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Dynamic Subject Table -->
            <div id="subject-container" class="bg-white overflow-hidden shadow-sm sm:rounded-lg hidden">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold" id="selected-class-name">Subjects</h3>
                        <span class="text-sm text-gray-500" id="subject-count">0 subjects</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="subject-table-body" class="bg-white divide-y divide-gray-200">
                                <!-- Populated via JS -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div id="empty-state" class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl p-12 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Select a Class</h3>
                <p class="text-gray-500 mt-1">Choose a class tile above to view its associated subjects.</p>
            </div>
        </div>
    </div>

    <script>
        function selectClass(classId, className) {
            // UI Feedback
            document.querySelectorAll('.class-tile').forEach(el => {
                el.classList.remove('border-brand-600', 'bg-brand-50', 'shadow-md');
                el.classList.add('border-transparent', 'bg-white');
            });
            const selectedTile = document.getElementById(`class-tile-${classId}`);
            selectedTile.classList.remove('border-transparent', 'bg-white');
            selectedTile.classList.add('border-brand-600', 'bg-brand-50', 'shadow-md');

            // Show container, hide empty state
            document.getElementById('subject-container').classList.remove('hidden');
            document.getElementById('empty-state').classList.add('hidden');
            document.getElementById('selected-class-name').textContent = `Subjects for ${className}`;

            // Fetch Subjects
            fetch(`/lookup/classes/${classId}/subjects`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('subject-table-body');
                    const countEl = document.getElementById('subject-count');
                    tbody.innerHTML = '';
                    countEl.textContent = `${data.length} subject${data.length !== 1 ? 's' : ''}`;

                    if (data.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-gray-500">No subjects found for this class.</td></tr>`;
                        return;
                    }

                    data.forEach(subject => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">${subject.name}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">${subject.code}</td>
                            <td class="px-6 py-4 whitespace-nowrap uppercase text-xs text-gray-500">${subject.type}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="/admin/subjects/${subject.id}" method="POST" onsubmit="return confirm('Delete this subject?');">
                                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').content}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold transition-colors">Delete</button>
                                </form>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                });
        }
    </script>
</x-app-layout>
