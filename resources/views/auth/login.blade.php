<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-10">
        <h2 class="text-3xl font-black text-gray-900 tracking-tighter mb-2">Welcome Back</h2>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">Secure Access Portal</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-1">Email
                Address</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400 group-focus-within:text-brand-600 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206">
                        </path>
                    </svg>
                </div>
                <input id="email"
                    class="block w-full pl-11 pr-4 py-4 bg-white/50 border border-gray-100 rounded-2xl text-sm font-semibold text-gray-900 focus:ring-brand-500 focus:border-brand-500 transition-all placeholder:text-gray-300"
                    type="email" name="email" :value="old('email')" required autofocus placeholder="name@domain.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <div class="flex justify-between items-center px-1">
                <label for="password"
                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-[10px] font-black text-brand-600 uppercase tracking-widest hover:text-brand-700 transition-colors"
                        href="{{ route('password.request') }}">
                        Forgot?
                    </a>
                @endif
            </div>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400 group-focus-within:text-brand-600 transition-colors" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                </div>
                <input id="password"
                    class="block w-full pl-11 pr-4 py-4 bg-white/50 border border-gray-100 rounded-2xl text-sm font-semibold text-gray-900 focus:ring-brand-500 focus:border-brand-500 transition-all placeholder:text-gray-300"
                    type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between px-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="w-4 h-4 rounded-lg border-gray-200 text-brand-600 shadow-sm focus:ring-brand-500"
                    name="remember">
                <span
                    class="ms-2 text-xs font-bold text-gray-500 uppercase tracking-widest select-none">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit"
                class="w-full flex justify-center py-4 px-6 bg-gray-900 hover:bg-brand-600 text-white font-black text-xs uppercase tracking-[0.3em] rounded-2xl transition-all shadow-xl shadow-gray-200/50 hover:shadow-brand-500/30 transform hover:-translate-y-1">
                {{ __('Secure Sign In') }}
            </button>
        </div>
    </form>
</x-guest-layout>