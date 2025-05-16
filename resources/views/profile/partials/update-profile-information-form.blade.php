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
                @if($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="rounded-circle" width="96" height="96">
                @else
                    <div class="bg-secondary rounded-circle" style="width:96px; height:96px;"></div>
                @endif
            </div>
            <div>
                <label for="avatar" class="form-label">Upload Avatar</label>
                <input type="file" class="form-control" name="avatar" id="avatar" accept="image/*">
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

</section>
