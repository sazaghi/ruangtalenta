<section>
    <!-- Verification Form -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('setting.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Avatar -->
        <div class="mb-4 d-flex align-items-center">
            <div class="me-3">
                @if($user && $user->avatar)
                    <img id="avatarPreview" src="{{ asset($user->avatar) }}" alt="Avatar" style="width: 100px; height: 100px; border-radius: 8px; object-fit: cover;">
                @else
                    <img id="avatarPreview" src="https://via.placeholder.com/100x100?text=Preview" alt="Avatar Preview" style="width: 100px; height: 100px; border-radius: 8px; object-fit: cover;">
                @endif
            </div>
            <div>
                <label for="imgInp" class="form-label">Upload Avatar</label>
                <input type="file" class="form-control" name="avatar" id="imgInp" accept="image/*">
                @error('avatar')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Form Grid -->
        <div class="row">
            <!-- Full Name -->
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control bg-light" id="email" name="email" readonly value="{{ old('email', $user->email) }}">
                @error('email')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Submit -->
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary">Save</button>
            @if (session('status') === 'profile-updated')
                <span class="text-success">Saved.</span>
            @endif
        </div>
    </form>

    <!-- Avatar Preview Script -->
    <script>
        const imgInp = document.getElementById('imgInp');
        const avatarPreview = document.getElementById('avatarPreview');

        imgInp.onchange = evt => {
            const [file] = imgInp.files;
            if (file) {
                avatarPreview.src = URL.createObjectURL(file);
            }
        };
    </script>
</section>
