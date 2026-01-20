<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(isset($error))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 flex justify-between items-center" role="alert">
                    <span class="block sm:inline">{{ $error }}</span>
                    <a href="{{ route('teacher.profile.setup') }}" class="bg-red-600 text-white px-4 py-1 rounded text-sm font-bold hover:bg-red-700 transition-colors">
                        Complete Your Profile
                    </a>
                </div>
            @endif

            @if($isMentor)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Mentored Students -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 border border-indigo-100 shadow-soft hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest leading-none mb-1">My Students</p>
                                <h3 class="text-2xl font-black text-gray-900">{{ $stats['mentor_students'] }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Mentored Subjects -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 border border-blue-100 shadow-soft hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest leading-none mb-1">Class Subjects</p>
                                <h3 class="text-2xl font-black text-gray-900">{{ $stats['mentor_subjects'] }}</h3>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Today -->
                    <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 border border-emerald-100 shadow-soft hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest leading-none mb-1">Present Today</p>
                                <h3 class="text-2xl font-black text-gray-900">{{ $stats['attendance_today'] }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Quick Actions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                        <div class="space-y-4">
                            <a href="{{ route('teacher.attendance.index') }}" class="block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                Mark Attendance
                            </a>
                            <a href="{{ route('teacher.marks.index') }}" class="block w-full text-center px-4 py-2 bg-brand-600 text-white rounded-md hover:bg-brand-700">
                                Enter Marks
                            </a>
                            <a href="{{ route('teacher.books.recommend') }}" class="block w-full text-center px-4 py-2 bg-emerald-600 text-white rounded-md hover:bg-emerald-700">
                                Recommend Book
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Notices -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 border-b">
                        <h3 class="text-lg font-semibold text-indigo-700">Today's Periods ({{ date('l') }})</h3>
                    </div>
                    <div class="p-4">
                        @if($todayPeriods->isNotEmpty())
                            <div class="space-y-4">
                                @foreach($todayPeriods as $period)
                                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg border border-gray-100">
                                        <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-lg flex flex-col items-center justify-center text-indigo-700">
                                            <span class="text-xs font-bold leading-none">PER</span>
                                            <span class="text-lg font-black leading-none">{{ $period->period_number }}</span>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-md font-bold text-gray-900 truncate">{{ $period->subject->name }}</h4>
                                            <p class="text-sm text-gray-600 uppercase font-medium tracking-tight">Class: {{ $period->section->school_class->name }} - {{ $period->section->name }}</p>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-sm font-bold text-indigo-600">
                                                {{ \Carbon\Carbon::parse($period->start_time)->format('h:i A') }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                {{ \Carbon\Carbon::parse($period->end_time)->format('h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-10">
                                <p class="text-gray-500 italic">No periods assigned for today.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Notices -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b">
                    <h3 class="text-lg font-semibold text-indigo-700">Notifications</h3>
                </div>
                <div class="p-6">
                    @if(isset($notifications) && $notifications->isNotEmpty())
                        <div class="space-y-6">
                            @foreach($notifications as $notification)
                                <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4 rounded-md shadow-sm">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-bold text-indigo-900">{{ $notification->message }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    @if($notification->type === 'fee_created' && isset($notification->data['section_id']))
                                        <div class="mt-4">
                                            <details class="group">
                                                <summary class="cursor-pointer text-sm font-medium text-indigo-600 hover:text-indigo-800 flex items-center">
                                                    <span>View Class Students</span>
                                                    <span class="ml-1 transition-transform group-open:rotate-180">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                        </svg>
                                                    </span>
                                                </summary>
                                                <div class="mt-3 overflow-x-auto bg-white rounded-lg border border-gray-200">
                                                    @php
                                                        $sectionStudents = \App\Models\Student::where('section_id', $notification->data['section_id'])->get();
                                                    @endphp
                                                    <table class="min-w-full divide-y divide-gray-200">
                                                        <thead class="bg-gray-50">
                                                            <tr>
                                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                                                            @foreach($sectionStudents as $student)
                                                                @php
                                                                    $isPaid = \App\Models\FeePayment::where('student_id', $student->id)
                                                                                ->where('fee_id', $notification->data['fee_id'])
                                                                                ->exists();
                                                                @endphp
                                                                <tr id="student-row-{{ $student->id }}-{{ $notification->data['fee_id'] }}">
                                                                    <td class="px-4 py-2 text-gray-900">{{ $student->user->name ?? 'N/A' }}</td>
                                                                    <td class="px-4 py-2" id="status-cell-{{ $student->id }}-{{ $notification->data['fee_id'] }}">
                                                                        @if($isPaid)
                                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                                                Paid
                                                                            </span>
                                                                        @else
                                                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                                                Unpaid
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="px-4 py-2" id="action-cell-{{ $student->id }}-{{ $notification->data['fee_id'] }}">
                                                                        @if(!$isPaid)
                                                                            <button type="button" onclick="markPaid({{ $student->id }}, {{ $notification->data['fee_id'] }})" class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 text-xs transition duration-150 ease-in-out">
                                                                                Mark Paid
                                                                            </button>
                                                                        @else
                                                                            <span class="text-gray-400 text-xs">-</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    @if($sectionStudents->isEmpty())
                                                        <p class="p-4 text-center text-gray-500 text-sm">No students found in this section.</p>
                                                    @endif
                                                </div>
                                            </details>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        <script>
                            function markPaid(studentId, feeId) {
                                if (!confirm('Mark this student as paid?')) return;

                                fetch("{{ route('teacher.fee.mark-paid') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        student_id: studentId,
                                        fee_id: feeId
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    // Update Status Badge
                                    const statusCell = document.getElementById(`status-cell-${studentId}-${feeId}`);
                                    statusCell.innerHTML = `
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Paid
                                        </span>
                                    `;

                                    // Remove Action Button
                                    const actionCell = document.getElementById(`action-cell-${studentId}-${feeId}`);
                                    actionCell.innerHTML = '<span class="text-gray-400 text-xs">-</span>';
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Failed to mark as paid.');
                                });
                            }
                        </script>
                    @else
                        <p class="text-gray-500 text-center italic">No new notifications.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
