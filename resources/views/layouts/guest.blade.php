<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        body {
            background-color: #d5d9ed;
            font-family: 'Segoe UI', sans-serif;
            position: relative;
            overflow: hidden;
        }

        .background-element {
            position: absolute;
            z-index: 0;
        }

        .logo {
            top: 20px;
            left: 20px;
            width: 200px;
        }

        .cube-top-right {
            top: 100px;
            right: 20px;
            width: 250px;
        }

        .cube-bottom-left {
            bottom: 20px;
            left: 20px;
            width: 250px;
        }

        .content {
            position: relative;
            z-index: 1;
        }

        .form-box {
            width: 420px;
            background-color: transparent;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #3F6DF6;
            border-color: #3F6DF6;
        }

        .btn-primary:hover {
            background-color: #335bd0;
        }
    </style>
</head>
<body>
    <!-- Background Elements -->
    <img src="{{ asset('images/ruang-talenta-img-1.png') }}" alt="Logo Ruang Talenta" class="background-element logo" />
    <img src="{{ asset('images/rubiks-cube.png') }}" alt="Kubus Kanan Atas" class="background-element cube-top-right" />
    <img src="{{ asset('images/cube-of-square-blocks.png') }}" alt="Kubus Kiri Bawah" class="background-element cube-bottom-left" />

    <!-- Page Content -->
    <div class="d-flex justify-content-center align-items-center vh-100 content">
        <div class="form-box p-4 text-center">
            <h4 class="fw-bold mb-0 fs-4">Welcome to</h4>
            <h2 class="fw-bold text-primary fs-3 mb-3">Ruang Talenta</h2>

            <p class="text-muted small mb-4">Daftar sekarang dan mulai perjalananmu bersama kami!</p>

            {{ $slot }}
            
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
                Sudah punya akun? <a href="#" class="text-decoration-none text-primary fw-semibold">Masuk</a>
            </p>
        </div>
    </div>
</body>
</html>
