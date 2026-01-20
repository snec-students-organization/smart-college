<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EduConnect | Future of Education Management</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .hero-gradient {
            background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.1), transparent),
                radial-gradient(circle at bottom left, rgba(6, 182, 212, 0.1), transparent);
        }
    </style>
</head>

<body class="antialiased text-gray-900 bg-[#f8fafc] selection:bg-brand-500 selection:text-white">

    <!-- Global Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-brand-200/40 rounded-full blur-[100px] animate-blob"></div>
        <div
            class="absolute top-1/2 -right-24 w-80 h-80 bg-cyan-200/40 rounded-full blur-[100px] animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-24 left-1/2 w-96 h-96 bg-indigo-200/40 rounded-full blur-[100px] animate-blob animation-delay-4000">
        </div>
    </div>

    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-50 transition-all duration-300 glass border-b border-gray-100/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-brand-600 rounded-xl flex items-center justify-center shadow-lg shadow-brand-600/20">
                        <x-application-logo class="w-7 h-7 fill-white" />
                    </div>
                    <span class="font-bold text-2xl tracking-tighter text-gray-900">Edu<span
                            class="text-brand-600">Connect</span></span>
                </div>
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features"
                        class="text-sm font-semibold text-gray-600 hover:text-brand-600 transition-colors">Features</a>
                    <a href="#schedule"
                        class="text-sm font-semibold text-gray-600 hover:text-brand-600 transition-colors">Live
                        Schedule</a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="px-5 py-2.5 bg-brand-600 text-white text-sm font-bold rounded-xl hover:bg-brand-700 transition shadow-lg shadow-brand-600/20">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="px-5 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-gray-800 transition shadow-lg shadow-gray-900/20">Sign
                                In</a>
                        @endauth
                    @endif
                </div>
                <div class="md:hidden">
                    <a href="{{ route('login') }}" class="p-2.5 bg-brand-600 text-white rounded-lg shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 hero-gradient overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="text-left">
                    <div
                        class="inline-flex items-center gap-2 py-1.5 px-3 rounded-full bg-brand-50 text-brand-700 text-[10px] font-black uppercase tracking-[0.2em] mb-8 border border-brand-100">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                        </span>
                        Next-Gen Education
                    </div>
                    <h1 class="text-6xl md:text-8xl font-black tracking-tight text-gray-900 mb-8 leading-[0.9]">
                        Elevate Your <br>
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 via-indigo-600 to-cyan-500">Learning
                            Hub.</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-600 max-w-xl mb-12 leading-relaxed font-medium">
                        Smart administration meets cinematic experience. EduConnect bridges the gap between technology
                        and human potential.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('login') }}"
                            class="px-8 py-4 bg-gray-900 text-white font-bold rounded-2xl hover:bg-gray-800 transition-all shadow-2xl shadow-gray-900/30 transform hover:-translate-y-1 flex items-center gap-2 group">
                            Access Portal
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="#features"
                            class="px-8 py-4 bg-white/50 backdrop-blur-md text-gray-700 border border-white/50 font-bold rounded-2xl hover:bg-white transition-all shadow-xl shadow-gray-200/20">Explore
                            Features</a>
                    </div>
                </div>

                <div class="relative hidden lg:block">
                    <div
                        class="relative z-10 glass p-4 rounded-[2.5rem] shadow-2xl rotate-2 transform hover:rotate-0 transition-transform duration-700">
                        <div
                            class="bg-gray-900 rounded-[2rem] overflow-hidden aspect-[4/3] flex items-center justify-center relative">
                            <div class="absolute inset-0 bg-gradient-to-br from-brand-600/20 to-transparent opacity-50">
                            </div>
                            <div class="text-center px-8">
                                <div
                                    class="w-20 h-20 bg-brand-500 rounded-2xl mx-auto mb-6 flex items-center justify-center shadow-2xl shadow-brand-500/50">
                                    <x-application-logo class="w-12 h-12 fill-white" />
                                </div>
                                <h3 class="text-2xl font-black text-white mb-2">EduConnect v2.0</h3>
                                <p class="text-gray-400 text-sm font-medium">The most intuitive campus management system
                                    ever built.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Features Section -->
    <section id="features" class="py-32 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span
                    class="text-brand-600 text-xs font-black uppercase tracking-[0.3em] mb-4 block">Capabilities</span>
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 tracking-tight leading-none mb-6">Designed for
                    Every <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-cyan-500">Stakeholder.</span>
                </h2>
                <p class="text-gray-500 font-medium">Our platform offers a cohesive ecosystem that empowers
                    administrators, inspires teachers, engages students, and informs parents.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature Cards -->
                @php
                    $features = [
                        ['title' => 'Identity Suite', 'desc' => 'Centralized biometric and profile management with instant role assignment.', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'color' => 'blue'],
                        ['title' => 'Academic Engine', 'desc' => 'Sophisticated timetable scheduling and dynamic gradebook automation.', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z', 'color' => 'emerald'],
                        ['title' => 'Live Pulse', 'desc' => 'Real-time attendance tracking with AI-driven insights for student performance.', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'indigo'],
                        ['title' => 'Financial Core', 'desc' => 'Seamless fee structures with automated invoicing and parent portal gateways.', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'color' => 'amber'],
                        ['title' => 'Resource Hub', 'desc' => 'Digital library management with circulation and inventory control.', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'color' => 'orange'],
                        ['title' => 'Active Connect', 'desc' => 'Omni-channel notifications keep everyone synchronized with real-time updates.', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'color' => 'rose'],
                    ];
                @endphp
                @foreach($features as $f)
                    <div
                        class="group p-10 rounded-[2.5rem] bg-gray-50 border border-gray-100 hover:bg-white hover:shadow-2xl hover:shadow-brand-500/10 transition-all duration-500">
                        <div
                            class="w-16 h-16 bg-{{ $f['color'] }}-100 rounded-3xl flex items-center justify-center mb-8 group-hover:bg-brand-600 group-hover:scale-110 transition-all duration-500">
                            <svg class="w-8 h-8 text-{{ $f['color'] }}-600 group-hover:text-white transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $f['icon'] }}">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-gray-900 mb-4 tracking-tight">{{ $f['title'] }}</h3>
                        <p class="text-gray-600 font-medium leading-relaxed">{{ $f['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Live Schedule Section -->
    <section id="schedule" class="py-32 bg-[#f8fafc] relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between mb-20 gap-8">
                <div>
                    <span
                        class="inline-flex items-center gap-2 py-1.5 px-3 rounded-full bg-brand-50 text-brand-700 text-[10px] font-black uppercase tracking-[0.2em] mb-4 border border-brand-100">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                        </span>
                        Campus Operations
                    </span>
                    <h2 class="text-5xl md:text-6xl font-black text-gray-900 tracking-tighter leading-none mb-4">Today's
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 via-indigo-600 to-cyan-500">Live
                            Pulse.</span></h2>
                    <p class="text-gray-500 font-medium max-w-xl">Real-time visibility into current sessions and
                        academic flow across all departments.</p>
                </div>
                <div class="flex flex-col items-start lg:items-end">
                    <div class="text-5xl font-black text-gray-900 tracking-tighter" id="current-time-display">
                        {{ now()->format('h:i') }} <span class="text-2xl font-medium text-gray-400"
                            id="current-period-display">{{ now()->format('A') }}</span></div>
                    <div class="text-xs font-black text-brand-600 uppercase tracking-[0.3em] mt-2">{{ $dayToday }} /
                        CAMPUS ONLINE</div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($sections as $section)
                    @php
                        $activePeriod = $section->timetables->first(function ($p) {
                            $now = now()->format('H:i:s');
                            return $now >= $p->start_time && $now <= $p->end_time;
                        });
                    @endphp
                    <div class="bg-white border border-gray-200 rounded-3xl p-8 shadow-sm hover:shadow-md transition-all flex flex-col h-full">
                        <!-- Header -->
                        <div class="flex justify-between items-start mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $section->school_class->name }}</h3>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-widest mt-1">Section {{ $section->name }}</p>
                            </div>
                            @if($activePeriod)
                                <div class="px-3 py-1 bg-brand-50 text-brand-700 text-[10px] font-bold rounded-full border border-brand-100 flex items-center gap-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-brand-600"></span>
                                    LIVE NOW
                                </div>
                            @endif
                        </div>

                        <!-- Mentor -->
                        <div class="flex items-center gap-3 mb-8 pb-6 border-b border-gray-100">
                            <div class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center text-brand-700 font-bold text-sm border border-gray-100">
                                {{ substr($section->class_teacher->user->name ?? '?', 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest leading-none mb-1">Class Mentor</p>
                                <p class="text-sm font-bold text-gray-900 truncate">{{ $section->class_teacher->user->name ?? 'Not Assigned' }}</p>
                            </div>
                        </div>

                        <!-- Periods -->
                        <div class="space-y-1 flex-1">
                            @forelse($section->timetables as $period)
                                @php $isCurrent = $activePeriod && $activePeriod->id === $period->id; @endphp
                                <div class="group/period p-3 rounded-xl transition-colors {{ $isCurrent ? 'bg-brand-50/50 border border-brand-100' : 'hover:bg-gray-50' }}">
                                    <div class="flex items-center justify-between gap-4">
                                        <div class="flex items-center gap-3 min-w-0">
                                            <span class="text-[10px] font-bold {{ $isCurrent ? 'text-brand-700' : 'text-gray-400' }} w-5">P{{ $period->period_number }}</span>
                                            <div class="min-w-0">
                                                <p class="text-sm font-bold {{ $isCurrent ? 'text-gray-900' : 'text-gray-700' }} truncate leading-tight">{{ $period->subject->name }}</p>
                                                <p class="text-[10px] font-medium {{ $isCurrent ? 'text-brand-600' : 'text-gray-400' }}">{{ $period->teacher->user->name }}</p>
                                            </div>
                                        </div>
                                        <div class="text-right flex-shrink-0">
                                            <p class="text-xs font-bold text-gray-900 leading-none mb-0.5">{{ \Carbon\Carbon::parse($period->start_time)->format('h:i') }}</p>
                                            <p class="text-[9px] font-bold text-gray-400 uppercase tracking-tighter">{{ \Carbon\Carbon::parse($period->start_time)->format('A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="py-12 flex flex-col items-center justify-center border-2 border-dashed border-gray-100 rounded-2xl">
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest italic">No periods scheduled</p>
                                </div>
                            @endforelse
                        </div>

                        <a href="{{ route('login') }}" class="mt-8 w-full py-4 bg-gray-900 hover:bg-brand-600 text-white text-[10px] font-black uppercase tracking-widest rounded-xl transition-all text-center">
                            Portal Access
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 border-t border-gray-800 relative z-10 pt-20 pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-20">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-12 h-12 bg-brand-600 rounded-xl flex items-center justify-center">
                            <x-application-logo class="w-8 h-8 fill-white" />
                        </div>
                        <span class="font-black text-2xl tracking-tighter text-white">Edu<span
                                class="text-brand-500">Connect</span></span>
                    </div>
                    <p class="text-gray-400 font-medium max-w-sm mb-8 leading-relaxed">The pinnacle of education
                        management. Orchestrating thousands of academic interactions every single day.</p>
                </div>
                <div>
                    <h4 class="text-sm font-black text-white uppercase tracking-[0.3em] mb-8">Platform</h4>
                    <ul class="space-y-4">
                        <li><a href="#"
                                class="text-sm font-medium text-gray-400 hover:text-white transition-colors">Features</a>
                        </li>
                        <li><a href="#"
                                class="text-sm font-medium text-gray-400 hover:text-white transition-colors">Portals</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-sm font-black text-white uppercase tracking-[0.3em] mb-8">Resources</h4>
                    <ul class="space-y-4">
                        <li><a href="#"
                                class="text-sm font-medium text-gray-400 hover:text-white transition-colors">Support
                                Center</a></li>
                        <li><a href="#"
                                class="text-sm font-medium text-gray-400 hover:text-white transition-colors">Legal</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="pt-10 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-xs font-bold text-gray-500 tracking-widest uppercase">© {{ date('Y') }} EduConnect
                    Systems / All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function updateClock() {
            const now = new Date();
            let hours = now.getHours();
            let minutes = now.getMinutes();
            let ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12;
            minutes = minutes < 10 ? '0' + minutes : minutes;
            let strTime = hours + ':' + minutes;

            const timeEl = document.getElementById('current-time-display');
            if (timeEl) {
                timeEl.childNodes[0].nodeValue = strTime + ' ';
                document.getElementById('current-period-display').innerText = ampm;
            }
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>

</html>