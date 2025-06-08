<x-guest-layout>
    <div class="form-box p-4 text-center">
            <h4 class="fw-bold mb-0 fs-4">Welcome to</h4>
            <h2 class="fw-bold text-primary fs-3 mb-3">Ruang Talenta</h2>

            <p class="text-muted small mb-4">Register now and start your journey with us!</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Name"/>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mb-3">
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="E-mail"/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-3">

                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="new-password" placeholder="Password"/>

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mb-3">
                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                    type="password"
                                    name="password_confirmation" required autocomplete="new-password" placeholder="Re-password"/>

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center mb-3">
                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>
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
                Already have an account? <a href="{{ route('login') }}" class="text-decoration-none text-primary fw-semibold">Sign in</a>
            </p>
        </div>
</x-guest-layout>