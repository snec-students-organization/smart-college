<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fee Payments Status') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('admin.fees.index') }}" class="text-indigo-600 hover:text-indigo-900 font-medium flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Fee List
                </a>
                <div class="space-x-2">
                    <a href="{{ route('admin.fees.export.excel', $fee) }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm font-medium">
                        Export Excel
                    </a>
                    <a href="{{ route('admin.fees.export.pdf', $fee) }}" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 text-sm font-medium">
                        Export PDF
                    </a>
                </div>
            </div>

            <!-- Fee Details Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500 uppercase">Class</p>
                            <p class="text-lg font-bold">{{ $fee->school_class->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase">Fee Type</p>
                            <p class="text-lg font-bold">{{ $fee->type }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase">Amount</p>
                            <p class="text-lg font-bold text-green-600">${{ number_format($fee->amount, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase">Due Date</p>
                            <p class="text-lg font-bold text-red-600">{{ $fee->due_date->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Payment Status by Student</h3>
                    
                    @if($students->isEmpty())
                        <p class="text-gray-500 italic">No students found in this class.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php
                                        $currentSection = null;
                                    @endphp
                                    @foreach($students as $student)
                                        @if($currentSection !== $student->section->name)
                                            @php $currentSection = $student->section->name; @endphp
                                            <tr class="bg-gray-100">
                                                <td colspan="3" class="px-6 py-2 text-xs font-bold text-gray-700 uppercase">
                                                    Section: {{ $currentSection }}
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->section->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if(in_array($student->id, $paidStudentIds))
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        Paid
                                                    </span>
                                                @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                        Unpaid
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
