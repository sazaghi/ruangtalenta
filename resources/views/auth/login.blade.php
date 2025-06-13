<x-guest-layout>
    <!-- Session Status -->

    <x-auth-session-status class="mb-4" :status="session('status')" />

    
    <div class="form-box p-4 text-center">
            <h4 class="fw-bold mb-0 fs-4">Welcome to</h4>
            <h2 class="fw-bold text-primary fs-3 mb-3">Ruang Talenta</h2>

            <p class="text-muted small mb-4">Login now and lets your journey begins!</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3 text-start">
                    <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3 text-start">
                    <input type="password" class="form-control" name="password" id="password" required>
                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3 text-end">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-decoration-none">
                            Forgot your password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary w-100">Login</button>
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
