<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Fees') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 text-center">
                    <h3 class="text-lg font-bold mb-2">Fee Status</h3>
                    <p class="text-gray-600 mb-4">No pending dues found.</p>
                    <p class="text-sm text-gray-400 italic">Detailed fee history module coming soon.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
