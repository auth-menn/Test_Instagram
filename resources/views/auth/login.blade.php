<x-guest-layout>
        <div class="w-full max-w-sm space-y-6">

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Login Box -->
            <div class="bg-white border border-gray-200 px-6 py-8 rounded shadow-sm">
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <x-text-input
                            id="email"
                            class="block w-full bg-gray-100 border-gray-300 focus:border-gray-400 focus:ring-gray-400 text-sm rounded px-3 py-2"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required autofocus
                            placeholder="Phone number, username, or email"
                        />
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-500" />
                    </div>

                    <!-- Password -->
      <!-- Password -->
    <div x-data="{ show: false }" class="relative">
    <x-text-input
        x-bind:type="show ? 'text' : 'password'"
        id="password"
        name="password"
        required
        placeholder="Password"
        class="block w-full bg-gray-100 border-gray-300 focus:border-gray-400 focus:ring-gray-400 text-sm rounded px-3 py-2 pr-10"
    />
    <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-500" />

    <!-- Toggle icon -->
    <button type="button"
        @click="show = !show"
        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none">
        <!-- Eye Icon -->
        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
        <!-- Eye-off Icon -->
        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
            viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.958 9.958 0 012.216-3.592m1.858-1.858A9.958 9.958 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.058 5.034M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 3l18 18" />
        </svg>
    </button>
</div>

                    <!-- Submit -->
                    <div>
                        <x-primary-button class="w-full justify-center bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded text-sm">
                            {{ __('Log in') }}
                        </x-primary-button>
                    </div>

                    <!-- OR divider -->
                    <div class="flex items-center gap-3">
                        <div class="h-px bg-gray-300 flex-grow"></div>
                        <span class="text-xs text-gray-500 font-semibold">OR</span>
                        <div class="h-px bg-gray-300 flex-grow"></div>
                    </div>

                    <!-- Facebook login -->
                    <div class="text-center text-sm text-blue-900 font-medium flex items-center justify-center gap-2 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                            <path
                                d="M22.676 0H1.324C.593 0 0 .593 0 1.324v21.352C0 23.407.593 24 1.324 24h11.49v-9.294H9.847v-3.622h2.967V8.413c0-2.937 1.793-4.542 4.414-4.542 1.254 0 2.331.093 2.645.135v3.07l-1.814.001c-1.423 0-1.698.676-1.698 1.668v2.19h3.396l-.443 3.622h-2.953V24h5.787C23.407 24 24 23.407 24 22.676V1.324C24 .593 23.407 0 22.676 0z" />
                        </svg>
                        <span>Log in with Facebook</span>
                    </div>

                    <!-- Forgot Password -->
                    @if (Route::has('password.request'))
                        <div class="text-center mt-2">
                            <a href="{{ route('password.request') }}" class="text-xs text-blue-900 hover:underline">
                                {{ __('Forgot password?') }}
                            </a>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Sign Up -->
            <div class="bg-white border border-gray-200 py-4 text-center text-sm">
                Don’t have an account?
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="text-blue-500 font-semibold hover:underline ml-1">
                        Sign up
                    </a>
                @endif
            </div>

         
        </div>
</x-guest-layout>
