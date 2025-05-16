<x-guest-layout>
    <!-- Session Status -->

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="E-mail"/>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="Password"/>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-3 text-xs">
            @if (Route::has('password.request'))
                <a class="underline text-sm hover:text-[#084C9B] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0A66C2]" href="{{ route('password.request') }} style="color: #0A66C2;"">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>
        <!-- Login Button -->
        <div class="mt-3 text-center">
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </div>
    </form>
</x-guest-layout>
