<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Smart School') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-50 selection:bg-brand-500 selection:text-white">

    <!-- Navigation -->
    <div class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-2">
                    <x-application-logo class="w-10 h-10 text-brand-600 fill-current" />
                    <span class="font-bold text-2xl tracking-tight">Smart<span class="text-brand-600">School</span></span>
                </div>
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-brand-600 transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="font-medium text-gray-600 hover:text-brand-600 px-4 py-2 transition-colors">Log in</a>


                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <!-- Background Elements -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full z-0 pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-brand-300/30 rounded-full blur-3xl mix-blend-multiply animate-blob"></div>
            <div class="absolute top-40 right-10 w-72 h-72 bg-accent-300/30 rounded-full blur-3xl mix-blend-multiply animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-20 left-1/2 w-96 h-96 bg-indigo-300/30 rounded-full blur-3xl mix-blend-multiply animate-blob animation-delay-4000"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-brand-50 text-brand-600 text-sm font-semibold mb-6 border border-brand-100">next-gen education management</span>
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-gray-900 mb-8 leading-tight">
                Empowering Schools <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent-500">To Shape The Future.</span>
            </h1>
            <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto mb-10 leading-relaxed">
                Streamline administration, enhance learning, and connect your entire school community with our all-in-one smart management platform.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('login') }}" class="px-8 py-4 bg-gray-900 text-white font-semibold rounded-xl hover:bg-gray-800 transition-all shadow-xl shadow-gray-900/20 transform hover:-translate-y-1">Login to Portal</a>
                <a href="#features" class="px-8 py-4 bg-white text-gray-700 border border-gray-200 font-semibold rounded-xl hover:bg-gray-50 transition-all shadow-md hover:shadow-lg">Learn More</a>
            </div>
        </div>
    </div>

    <!-- Features Grid -->
    <div id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Everything you need to run your school</h2>
                <p class="text-gray-500 max-w-xl mx-auto">From attendance to academic results, we cover every aspect of school management.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:shadow-soft hover:bg-white transition-all duration-300 group">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">User Management</h3>
                    <p class="text-gray-600 leading-relaxed">Dedicated portals for Admins, Teachers, Students, and Parents with role-based access control.</p>
                </div>

                <!-- Feature 2 -->
                <div class="p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:shadow-soft hover:bg-white transition-all duration-300 group">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                         <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Academic Records</h3>
                    <p class="text-gray-600 leading-relaxed">Manage Classes, Sections, Subjects, and Exams seamlessly. Generate report cards instantly.</p>
                </div>

                <!-- Feature 3 -->
                <div class="p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:shadow-soft hover:bg-white transition-all duration-300 group">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Smart Attendance</h3>
                    <p class="text-gray-600 leading-relaxed">Digital attendance tracking for teachers with instant reporting to parents.</p>
                </div>

                <!-- Feature 4 -->
                 <div class="p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:shadow-soft hover:bg-white transition-all duration-300 group">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Fee Management</h3>
                    <p class="text-gray-600 leading-relaxed">Complete fee lifecycle management from structure definition to collection and receipt generation.</p>
                </div>

                 <!-- Feature 5 -->
                 <div class="p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:shadow-soft hover:bg-white transition-all duration-300 group">
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Library System</h3>
                    <p class="text-gray-600 leading-relaxed">Digital cataloging of books and tracking of issued/returned items with due date alerts.</p>
                </div>

                 <!-- Feature 6 -->
                 <div class="p-8 rounded-2xl bg-gray-50 border border-gray-100 hover:shadow-soft hover:bg-white transition-all duration-300 group">
                    <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Parent Connect</h3>
                    <p class="text-gray-600 leading-relaxed">Keep parents informed about their child's progress, attendance, and dues in real-time.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Live School Schedule Section -->
    <div id="schedule" class="py-24 bg-white overflow-hidden relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                <div>
                    <span class="inline-flex items-center gap-2 py-1 px-3 rounded-full bg-brand-50 text-brand-700 text-xs font-bold uppercase tracking-widest mb-4 border border-brand-100">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                        </span>
                        Real-time Campus Pulse
                    </span>
                    <h2 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight">Today's <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-accent-500">Live Schedule</span></h2>
                </div>
                <div class="flex flex-col items-end">
                    <div class="text-3xl font-bold text-gray-900" id="current-time-display">{{ now()->format('h:i') }} <span class="text-lg font-medium text-gray-500" id="current-period-display">{{ now()->format('A') }}</span></div>
                    <div class="text-sm font-semibold text-brand-600 uppercase tracking-widest">{{ $dayToday }}</div>
                </div>
            </div>

            <script>
                function updateClock() {
                    const now = new Date();
                    const optionsTime = { hour: '2-digit', minute: '2-digit', hour12: false };
                    const optionsPeriod = { hour12: true, hour: 'numeric' };
                    
                    let hours = now.getHours();
                    let minutes = now.getMinutes();
                    let ampm = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // the hour '0' should be '12'
                    minutes = minutes < 10 ? '0'+minutes : minutes;
                    let strTime = hours + ':' + minutes;
                    
                    document.getElementById('current-time-display').childNodes[0].nodeValue = strTime + ' ';
                    document.getElementById('current-period-display').innerText = ampm;
                }
                setInterval(updateClock, 1000);
            </script>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($sections as $section)
                    @php
                        $activePeriod = $section->timetables->first(function($p) {
                            $now = now()->format('H:i:s');
                            return $now >= $p->start_time && $now <= $p->end_time;
                        });
                    @endphp
                    <div class="group relative">
                        <!-- Card Glow Backdrop (visible on active or hover) -->
                        <div class="absolute -inset-0.5 bg-gradient-to-r {{ $activePeriod ? 'from-brand-500 to-accent-400 opacity-30 blur-xl animate-pulse' : 'from-gray-200 to-gray-100 opacity-0 group-hover:opacity-20' }} rounded-[2.5rem] transition duration-1000"></div>
                        
                        <div class="relative bg-white border border-gray-100 rounded-[2.5rem] p-8 shadow-2xl shadow-gray-200/40 hover:shadow-brand-500/10 transition-all duration-500 flex flex-col h-full">
                            <div class="flex justify-between items-start mb-8">
                                <div>
                                    <h3 class="text-2xl font-black text-gray-900 leading-none mb-2">{{ $section->school_class->name }}</h3>
                                    <div class="inline-flex items-center px-2 py-1 bg-gray-100 rounded-lg text-[10px] font-bold text-gray-500 uppercase tracking-tighter">Section {{ $section->name }}</div>
                                </div>
                                @if($activePeriod)
                                    <div class="flex items-center gap-1.5 px-3 py-1.5 bg-brand-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest animate-bounce shadow-lg shadow-brand-500/40">
                                        <div class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></div>
                                        Live Now
                                    </div>
                                @endif
                            </div>

                            <!-- Class Teacher Widget -->
                            <div class="mb-8 p-5 bg-gradient-to-br from-gray-50 to-white border border-gray-100 rounded-3xl group-hover:border-brand-100 transition-colors">
                                <div class="text-[9px] uppercase text-gray-400 font-extrabold mb-3 tracking-[0.2em]">Class Mentor</div>
                                <div class="flex items-center gap-4">
                                    <div class="relative">
                                        <div class="w-12 h-12 rounded-2xl bg-brand-100 flex items-center justify-center text-brand-700 font-black text-xl">
                                            {{ substr($section->class_teacher->user->name ?? '?', 0, 1) }}
                                        </div>
                                        <div class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-green-500 border-2 border-white"></div>
                                    </div>
                                    <div>
                                        <div class="font-black text-gray-900 text-sm tracking-tight">{{ $section->class_teacher->user->name ?? 'Not Assigned' }}</div>
                                        <div class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">Primary Instructor</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline -->
                            <div class="space-y-3 flex-1">
                               @if($section->timetables->count() > 0)
                                    @foreach($section->timetables as $period)
                                        @php
                                            $isCurrent = $activePeriod && $activePeriod->id === $period->id;
                                        @endphp
                                        <div class="relative pl-6 py-2 border-l-2 {{ $isCurrent ? 'border-brand-500' : 'border-gray-100' }} transition-colors">
                                            <!-- Dot -->
                                            <div class="absolute -left-[5px] top-1/2 -translate-y-1/2 w-2 h-2 rounded-full {{ $isCurrent ? 'bg-brand-600 ring-4 ring-brand-100' : 'bg-gray-200' }}"></div>
                                            
                                            <div class="flex items-center justify-between gap-4">
                                                <div class="min-w-0">
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-[10px] font-black {{ $isCurrent ? 'text-brand-600' : 'text-gray-400' }}">P{{ $period->period_number }}</span>
                                                        <h4 class="text-sm font-black {{ $isCurrent ? 'text-gray-900' : 'text-gray-600' }} truncate tracking-tight">{{ $period->subject->name }}</h4>
                                                    </div>
                                                    <div class="text-[10px] {{ $isCurrent ? 'text-gray-600' : 'text-gray-400' }} font-bold mt-0.5">{{ $period->teacher->user->name }}</div>
                                                </div>
                                                <div class="text-right flex-shrink-0">
                                                    <div class="text-[10px] font-black {{ $isCurrent ? 'text-brand-600' : 'text-gray-900' }}">{{ \Carbon\Carbon::parse($period->start_time)->format('h:i') }}</div>
                                                    <div class="text-[8px] font-bold text-gray-400 uppercase">{{ \Carbon\Carbon::parse($period->start_time)->format('A') }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="h-32 flex items-center justify-center rounded-3xl border-2 border-dashed border-gray-100">
                                        <p class="text-xs text-gray-400 font-bold uppercase tracking-widest italic text-center">No Active<br>Periods Today</p>
                                    </div>
                                @endif
                            </div>

                            <button class="mt-8 w-full py-4 rounded-2xl bg-gray-50 text-gray-600 font-black text-xs uppercase tracking-widest hover:bg-brand-600 hover:text-white transition-all duration-300">
                                View Full Details
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-6 md:mb-0">
                 <div class="flex items-center gap-2 mb-2">
                    <x-application-logo class="w-8 h-8 text-white fill-current" />
                     <span class="font-bold text-xl tracking-tight">Smart<span class="text-brand-400">School</span></span>
                </div>
                <p class="text-gray-400 text-sm">© {{ date('Y') }} All rights reserved.</p>
            </div>
            <div class="flex gap-6">
                <a href="#" class="text-gray-400 hover:text-white transition-colors">Privacy Policy</a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors">Terms of Service</a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors">Contact Support</a>
            </div>
        </div>
    </footer>
</body>
</html>
