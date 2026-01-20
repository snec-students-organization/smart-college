<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(isset($error))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ $error }}</span>
                </div>
            @else

                <!-- Profile Overview -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900 flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold">Welcome, {{ Auth::user()->name }}!</h3>
                            <p class="text-gray-600">Class: {{ $student->school_class->name ?? 'N/A' }} -
                                {{ $student->section->name ?? 'N/A' }} | Roll No: {{ $student->roll_no }}</p>
                        </div>
                        <div class="text-right">
                            <span
                                class="inline-block bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full uppercase font-semibold tracking-wide">Student</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Attendance Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-green-500">
                        <div class="text-gray-500 text-sm font-medium uppercase">Attendance</div>
                        <div class="mt-2 text-4xl font-bold text-gray-900">{{ $attendancePercentage }}%</div>
                        <p class="text-xs text-gray-500 mt-1">Overall Present</p>
                        <div class="mt-4">
                            <a href="{{ route('student.attendance') }}"
                                class="text-indigo-600 hover:text-indigo-900 text-sm">View History &rarr;</a>
                        </div>
                    </div>

                    <!-- Library Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-yellow-500">
                        <div class="text-gray-500 text-sm font-medium uppercase">Library Books</div>
                        <div class="mt-2 text-4xl font-bold text-gray-900">{{ $pendingBooks }}</div>
                        <p class="text-xs text-gray-500 mt-1">Due for return</p>
                    </div>

                    <!-- Fees Card (Mockup) -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-red-500">
                        <div class="text-gray-500 text-sm font-medium uppercase">Fee Status</div>
                        <div class="mt-2 text-xl font-bold text-green-600">Paid</div>
                        <p class="text-xs text-gray-500 mt-1">Next due: 15th Feb</p>
                        <div class="mt-4">
                            <a href="{{ route('student.fees') }}" class="text-indigo-600 hover:text-indigo-900 text-sm">View
                                Details &rarr;</a>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- Today's Timetable -->
                    <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-indigo-700">Today's Schedule ({{ date('l') }})</h3>
                                <span
                                    class="text-xs font-medium px-2 py-1 bg-indigo-50 text-indigo-700 rounded-full">Section:
                                    {{ $student->school_class->name }} - {{ $student->section->name }}</span>
                            </div>

                            @if($timetable->isNotEmpty())
                                <div class="relative">
                                    <div class="absolute top-0 bottom-0 left-4 w-0.5 bg-gray-100"></div>
                                    <div class="space-y-6 relative">
                                        @foreach($timetable as $period)
                                            <div class="flex items-start gap-4">
                                                <div
                                                    class="z-10 w-8 h-8 rounded-full bg-white border-2 border-indigo-500 flex items-center justify-center text-xs font-bold text-indigo-600">
                                                    {{ $period->period_number }}
                                                </div>
                                                <div
                                                    class="flex-1 bg-gray-50 rounded-lg p-3 border border-gray-100 hover:border-indigo-200 transition-colors">
                                                    <div class="flex justify-between items-start">
                                                        <h4 class="font-bold text-gray-900">{{ $period->subject->name }}</h4>
                                                        <span
                                                            class="text-xs font-medium text-gray-500 bg-white px-2 py-1 rounded border">
                                                            {{ \Carbon\Carbon::parse($period->start_time)->format('h:i A') }}
                                                        </span>
                                                    </div>
                                                    <div class="text-sm text-gray-600 mt-1">Teacher:
                                                        {{ $period->teacher->user->name }}</div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-6 bg-gray-50 rounded-lg border border-dashed text-gray-500">
                                    <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p>No periods scheduled for today.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Class Teacher info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-lg font-semibold mb-4 text-gray-800">Class Information</h3>
                            <div class="space-y-4">
                                <div class="p-4 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white">
                                    <div class="text-xs uppercase opacity-75 mb-1 font-semibold">Class Teacher</div>
                                    <div class="text-xl font-bold">
                                        {{ $student->section->class_teacher->user->name ?? 'Not Assigned' }}</div>
                                    @if($student->section->class_teacher)
                                        <div class="text-xs mt-2 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                </path>
                                            </svg>
                                            {{ $student->section->class_teacher->phone ?? 'Ask administration' }}
                                        </div>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between p-3 border rounded-lg">
                                    <span class="text-sm text-gray-600 font-medium">Classroom</span>
                                    <span class="text-sm font-bold text-gray-900">{{ $student->school_class->name }} -
                                        {{ $student->section->name }}</span>
                                </div>

                                <div class="flex items-center justify-between p-3 border rounded-lg">
                                    <span class="text-sm text-gray-600 font-medium">Total Students</span>
                                    <span
                                        class="text-sm font-bold text-gray-900">{{ $student->section->students->count() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Parent Management -->
                <div class="grid grid-cols-1 lg:grid-cols-1 gap-6 mb-6">
                    <div
                        class="bg-white/80 backdrop-blur-xl overflow-hidden shadow-soft rounded-2xl border border-gray-100">
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-6">
                                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Parent Management</h3>
                            </div>

                            @if($student->parent)
                                <div class="bg-indigo-50/50 rounded-2xl p-6 border border-indigo-100/50">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div class="space-y-1">
                                            <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">Parent
                                                Name</p>
                                            <p class="text-base font-bold text-gray-900">{{ $student->parent->user->name }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">Phone
                                                Number</p>
                                            <p class="text-base font-bold text-gray-900">{{ $student->parent->phone }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">Email
                                                Address</p>
                                            <p class="text-base font-bold text-gray-900">{{ $student->parent->user->email }}</p>
                                        </div>
                                    </div>
                                    <div
                                        class="mt-6 flex items-start gap-2 p-3 bg-white/50 rounded-xl border border-indigo-100">
                                        <svg class="w-5 h-5 text-indigo-500 mt-0.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-xs text-indigo-700 italic">Your parent can log in using their email and
                                            phone number as password.</p>
                                    </div>
                                </div>
                            @else
                                @if(session('success'))
                                    <div
                                        class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100 flex items-center gap-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span class="text-sm font-medium">{{ session('success') }}</span>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div
                                        class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-100 flex items-center gap-3">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="text-sm font-medium">{{ session('error') }}</span>
                                    </div>
                                @endif

                                <form action="{{ route('student.parent.store') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                        <div class="space-y-2">
                                            <label class="text-sm font-bold text-gray-700">Full Name</label>
                                            <input type="text" name="name" required placeholder="Parent's Full Name"
                                                class="w-full px-4 py-3 rounded-xl border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-sm font-bold text-gray-700">Phone Number</label>
                                            <input type="text" name="phone" required placeholder="e.g. +1234567890"
                                                class="w-full px-4 py-3 rounded-xl border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="text-sm font-bold text-gray-700">Email Address</label>
                                            <input type="email" name="email" required placeholder="parent@example.com"
                                                class="w-full px-4 py-3 rounded-xl border-gray-100 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200">
                                        </div>
                                    </div>
                                    <div class="flex justify-end pt-2">
                                        <button type="submit"
                                            class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-600/20 transition-all duration-200 flex items-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Register Parent
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Recent Marks -->
                <div class="bg-white/80 backdrop-blur-xl overflow-hidden shadow-soft rounded-2xl border border-gray-100 mb-6">
                    <div class="p-6 text-gray-900">
                        <div class="flex justify-between items-center mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900">Recent Marks</h3>
                            </div>
                            <a href="{{ route('student.marks') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-bold flex items-center gap-1 transition-all">
                                View All <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </div>
                        @if($recentMarks->isNotEmpty())
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-100">
                                    <thead>
                                        <tr class="bg-gray-50/50">
                                            <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Subject</th>
                                            <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-widest">Exam</th>
                                            <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-widest">Score</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100/50">
                                        @foreach($recentMarks as $mark)
                                            <tr class="hover:bg-gray-50/30 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $mark->subject->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">{{ $mark->exam_type }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                                    <span class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-700 text-sm font-bold rounded-lg border border-emerald-100/50">
                                                        {{ $mark->marks_obtained }} / {{ $mark->total_marks }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-12 bg-gray-50/50 rounded-2xl border border-dashed border-gray-200">
                                <p class="text-gray-500 font-medium italic">No marks recorded yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Book Recommendations -->
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900">Recommended for You</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($bookRecommendations as $recommendation)
                            <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 border border-gray-100 shadow-soft hover:shadow-lg transition-all duration-300">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <h4 class="font-bold text-gray-900 text-lg leading-tight">{{ $recommendation->book->title }}</h4>
                                        <p class="text-sm text-gray-500 font-medium mt-1">by {{ $recommendation->book->author }}</p>
                                    </div>
                                    <div class="p-2 bg-amber-50 rounded-lg">
                                        <svg class="w-6 h-6 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z"></path>
                                        </svg>
                                    </div>
                                </div>

                                @if($recommendation->notes)
                                    <div class="mb-4 p-3 bg-gray-50 rounded-xl border border-gray-100 relative">
                                        <p class="text-sm text-gray-600 italic">"{{ $recommendation->notes }}"</p>
                                        <div class="absolute -top-2 left-4 px-2 bg-gray-50 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Teacher's Note</div>
                                    </div>
                                @endif

                                <div class="flex items-center gap-3 mt-4 pt-4 border-t border-gray-50">
                                    <div class="w-8 h-8 rounded-full bg-brand-50 flex items-center justify-center font-bold text-brand-600 text-xs text-uppercase">
                                        {{ substr($recommendation->teacher->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest leading-none">Recommended By</p>
                                        <p class="text-xs font-bold text-gray-700 mt-1">{{ $recommendation->teacher->user->name }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center bg-white/50 rounded-2xl border border-dashed border-gray-200">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-500 font-medium italic">Your teachers haven't recommended any books for you yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            @endif
        </div>
    </div>
</x-app-layout>