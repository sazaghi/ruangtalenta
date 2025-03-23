<x-guest-layout>
    <!-- Session Status -->

    <h1 class="text-center font-bold mb-4" style="font-size: 24px; font-weight: bold;">
        <a href="/">Login</a>
    </h1>

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

        <div class="flex items-center justify-end mt-4 text-xs">
            @if (Route::has('password.request'))
                <a class="underline text-sm hover:text-[#084C9B] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0A66C2]" href="{{ route('password.request') }} style="color: #0A66C2;"">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>
        <!-- Login Button -->
        <div class="mt-4 text-center">
            <x-primary-button class="w-full">
                {{ __('Log In') }}
            </x-primary-button>
        </div>
    </form>

    <!-- OR Separator -->
    <div class="flex justify-center items-center my-4 mt-4">
        <div class="flex-grow border-t border-gray-400"></div>
            <span class="px-2 text-gray-600 text-xs">Or</span>
        <div class="flex-grow border-t border-gray-400"></div>
    </div>

            <!-- Social Login -->
    <div class="flex justify-center space-x-4 mt-4">
        <a href="#" class="w-12">
            <img src="{{ asset('images/google-icon.png') }}" alt="Google">
        </a>
        <a href="#" class="w-12">
            <img src="{{ asset('images/linkedin-icon.png') }}" alt="LinkedIn">
        </a>
    </div>

    <!-- Sign Up Link -->
    <div class="flex justify-center text-center text-xs mt-4">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-blue-500 hover:underline">Sign Up</a>
    </div>
</x-guest-layout>
