<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

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

            <!-- Delete Account -->
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Delete Account</span>
                </div>
                <div class="card-body" id="education-section">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</body>
</html>
