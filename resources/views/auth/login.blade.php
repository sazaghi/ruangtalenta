<x-guest-layout>
    <!-- Session Status -->

    <x-auth-session-status class="mb-4" :status="session('status')" />

    
    <div class="form-box p-4 text-center">
            <h4 class="fw-bold mb-0 fs-4">Welcome to</h4>
            <h2 class="fw-bold text-primary fs-3 mb-3">Ruang Talenta</h2>

            <p class="text-muted small mb-4">Login now and lets your journey begins!</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="E-mail"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

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
            
            <div class="text-muted my-3">Or</div>

            <div class="d-flex justify-content-center gap-3 mb-3">
                <a href="#" class="btn btn-outline-secondary d-flex align-items-center gap-2 px-3">
                    <img src="{{ asset('images/devicon_google.png') }}" alt="Google" width="20"> Google
                </a>
                <a href="#" class="btn btn-outline-secondary d-flex align-items-center gap-2 px-3">
                    <img src="{{ asset('images/skill-icons_linkedin.png') }}" alt="LinkedIn" width="20"> LinkedIn
                </a>
            </div>

            <p class="small text-muted">
                Do not have an account? <a href="{{ route('register') }}" class="text-decoration-none text-primary fw-semibold">Sign up</a>
            </p>
        </div>
</x-guest-layout>
