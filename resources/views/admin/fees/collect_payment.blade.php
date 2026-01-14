<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Fee Collection') }} - {{ $student->user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Student Profile Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold">{{ $student->user->name }}</h3>
                        <p class="text-gray-600">Class: {{ $student->school_class->name }} | Section: {{ $student->section->name }}</p>
                        <p class="text-gray-600">Roll No: {{ $student->roll_no }} | Admission No: {{ $student->admission_no }}</p>
                    </div>
                     <div class="text-right">
                        <a href="{{ route('admin.fees.collect.index') }}" class="text-indigo-600 hover:text-indigo-900 text-sm">Change Student</a>
                    </div>
                </div>
            </div>

            <!-- Fees Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Applicable Fees</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fee Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Due Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($fees as $fee)
                                    @php
                                        $payment = $payments[$fee->id] ?? null;
                                        $isPaid = $payment && $payment->status == 'paid';
                                    @endphp
                                    <tr class="{{ $isPaid ? 'bg-green-50' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $fee->type }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $fee->due_date->format('d M Y') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap font-bold">${{ number_format($fee->amount, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($isPaid)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                                                <div class="text-xs text-green-600 mt-1">{{ $payment->payment_date->format('d M Y') }}</div>
                                            @else
                                                 <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Unpaid</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if(!$isPaid)
                                                <!-- Collect Button triggers modal or submits directly if full amount handled -->
                                                <!-- Simplified: Direct Payment Button -->
                                                <form action="{{ route('admin.fees.payment.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                    <input type="hidden" name="fee_id" value="{{ $fee->id }}">
                                                    <input type="hidden" name="amount_paid" value="{{ $fee->amount }}">
                                                    <input type="hidden" name="payment_date" value="{{ date('Y-m-d') }}">
                                                    <button type="submit" class="text-indigo-600 hover:text-indigo-900 font-medium" onclick="return confirm('Confirm payment of ${{ $fee->amount }}?')">Collect</button>
                                                </form>
                                            @else
                                                <span class="text-gray-400">ID: {{ $payment->transaction_id }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 italic">No fee structure found for this student's class.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
