<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EduConnect') }}</title>

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

        .bg-mesh {
            background: radial-gradient(circle at top right, rgba(79, 70, 229, 0.1), transparent),
                radial-gradient(circle at bottom left, rgba(6, 182, 212, 0.1), transparent);
        }
    </style>
</head>

<body class="antialiased text-gray-900 bg-[#f8fafc] bg-mesh min-h-screen selection:bg-brand-500 selection:text-white">
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

    <div class="relative z-10 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 p-4">
        <div class="mb-8">
            <a href="/" class="flex flex-col items-center gap-4 group">
                <div
                    class="w-16 h-16 bg-brand-600 rounded-2xl flex items-center justify-center shadow-2xl shadow-brand-600/30 group-hover:scale-110 transition-transform">
                    <x-application-logo class="w-10 h-10 fill-white" />
                </div>
                <span class="font-black text-3xl tracking-tighter text-gray-900">Edu<span
                        class="text-brand-600">Connect</span></span>
            </a>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-10 py-10 glass shadow-2xl shadow-brand-500/10 sm:rounded-[2.5rem] border border-white/50">
            {{ $slot }}
        </div>

        <div class="mt-12">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">© {{ date('Y') }} EduConnect
                Systems / All Rights Reserved.</p>
        </div>
    </div>
</body>

</html>