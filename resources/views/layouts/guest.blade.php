<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Welcome</title>
    <link rel="icon" type="image/png" href="{{ asset('images/page_logo.png') }}">
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
            top: 40px;
            left: 40px;
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
    <img src="{{ asset('images/logo-light.png') }}" alt="Ruang Talenta Logo" class="background-element logo" />
    <img src="{{ asset('images/rubiks-cube.png') }}" alt="Top Right Cube" class="background-element cube-top-right" />
    <img src="{{ asset('images/cube-of-square-blocks.png') }}" alt="Bottom Left Cube" class="background-element cube-bottom-left" />

    <!-- Page Content -->
    <div class="d-flex justify-content-center align-items-center vh-100 content">
        {{ $slot }}
    </div>
</body>
</html>
