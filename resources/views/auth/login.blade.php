<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Google SSO -->
    <div class="mt-6 flex flex-col items-center">
        <div class="w-full flex items-center justify-between mb-4">
            <span class="border-b dark:border-gray-700 w-1/5 lg:w-1/4"></span>
            <span class="text-xs text-center text-gray-500 uppercase dark:text-gray-400">atau</span>
            <span class="border-b dark:border-gray-700 w-1/5 lg:w-1/4"></span>
        </div>

        <a href="{{ route('auth.google') }}" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-gray-800 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
            <svg class="w-5 h-5 me-2" viewBox="0 0 24 24" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                <g transform="matrix(1, 0, 0, 1, 0, 0)">
                    <path d="M21.35,11.1H12v2.7h5.38c-0.24,1.28 -0.96,2.37 -2.04,3.1v2.57h3.3c1.93,-1.78 3.04,-4.4 3.04,-7.48C21.68,11.83 21.56,11.4 21.35,11.1z" fill="#4285F4" />
                    <path d="M12,20.73c2.63,0 4.84,-0.87 6.45,-2.37l-3.3,-2.57c-0.9,0.6 -2.08,0.97 -3.15,0.97 -2.42,0 -4.48,-1.63 -5.22,-3.82H3.38v2.66C5,18.8 8.28,20.73 12,20.73z" fill="#34A853" />
                    <path d="M6.78,12.94c-0.18,-0.54 -0.29,-1.11 -0.29,-1.7s0.11,-1.16 0.29,-1.7V6.88H3.38c-0.62,1.25 -0.97,2.67 -0.97,4.18s0.35,2.93 0.97,4.18L6.78,12.94z" fill="#FBBC05" />
                    <path d="M12,5.26c1.43,0 2.72,0.49 3.73,1.45l2.79,-2.79C16.83,2.31 14.62,1.27 12,1.27c-3.72,0 -7,1.93 -8.62,4.85l3.4,2.66c0.74,-2.19 2.8,-3.82 5.22,-3.82z" fill="#EA4335" />
                </g>
            </svg>
            <span>Login dengan Google</span>
        </a>
    </div>
</x-guest-layout>
