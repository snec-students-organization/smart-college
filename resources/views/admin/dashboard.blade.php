<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Students Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Students</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['students'] }}</div>
                </div>

                <!-- Teachers Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Teachers</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['teachers'] }}</div>
                </div>

                <!-- Parents Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Parents</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['parents'] }}</div>
                </div>

                <!-- Classes Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Classes</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $stats['classes'] }}</div>
                </div>
            </div>

            <!-- Recent Activity / Quick Actions Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <x-primary-button>Add New Student</x-primary-button>
                        <x-primary-button>Add New Teacher</x-primary-button>
                        <x-primary-button>Manage Classes</x-primary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
