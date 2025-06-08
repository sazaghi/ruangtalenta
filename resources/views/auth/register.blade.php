<x-guest-layout>
    <div class="form-box p-4 text-center">
        <h4 class="fw-bold mb-0 fs-4">Welcome to</h4>
        <h2 class="fw-bold text-primary fs-3 mb-3">Ruang Talenta</h2>

        <p class="text-muted small mb-4">Register now and start your journey with us!</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3 text-start">
                <label for="name" class="form-label">Name</label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Name">
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3 text-start">
                <label for="email" class="form-label">E-mail</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="E-mail">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3 text-start">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control" name="password" required placeholder="Password">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3 text-start">
                <label for="password_confirmation" class="form-label">Re-password</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required placeholder="Re-password">
                @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="mb-3">
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
            Already have an account?
            <a href="{{ route('login') }}" class="text-decoration-none text-primary fw-semibold">Sign in</a>
        </p>
    </div>
</x-guest-layout>
