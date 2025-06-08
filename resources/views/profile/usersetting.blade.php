<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>User Setting</title>
    <link rel="icon" type="image/png" href="{{ asset('images/page_logo.png') }}">

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Vite (disabled Tailwind for this page) -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>
<body style="font-family: 'Poppins', sans-serif;">
    <div class="min-vh-100 bg-light">
        @include('layouts.navigation')

        <!-- Tambahkan container agar konten tidak mepet -->
        <div class="container py-4">
            <div class="row g-4">
                <div class="col-md-9">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white fw-semibold">
                            Update Profile Information
                        </div>
                        <div class="card-body">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                <!-- Password Update & Delete Account -->
                <div class="col-md-3 d-flex flex-column gap-3">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white fw-semibold">Update Password</div>
                        <div class="card-body p-3">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if (session('status') == 'password-updated')
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Password updated successfully!',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if (session('status') == 'profile-updated')
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Profile updated successfully!',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ session('error') }}',
        });
    @endif
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('update-password-form');
        const newPassword = document.getElementById('update_password_password');
        const confirmPassword = document.getElementById('update_password_password_confirmation');

        form.addEventListener('submit', function (e) {
            if (newPassword.value !== confirmPassword.value) {
                e.preventDefault(); // Mencegah submit

                Swal.fire({
                    icon: 'warning',
                    title: 'Password tidak cocok',
                    text: 'Password baru dan konfirmasi password harus sama.',
                });

                return false;
            }

            // Bisa juga tambahkan validasi panjang password jika perlu:
            if (newPassword.value.length < 8) {
                e.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Password terlalu pendek',
                    text: 'Password minimal harus 8 karakter.',
                });

                return false;
            }
        });
    });
</script>

</html>
