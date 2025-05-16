<section>
    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="mb-3">
            <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                   id="update_password_current_password" name="current_password" autocomplete="current-password" placeholder="Current Password">
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                   id="update_password_password" name="password" autocomplete="new-password" placeholder="New Password">
            @error('password', 'updatePassword')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-4">
            <input type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                   id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password" placeholder="Re-New Password">
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <span class="text-success">{{ __('Saved.') }}</span>
            @endif
        </div>
    </form>
</section>
