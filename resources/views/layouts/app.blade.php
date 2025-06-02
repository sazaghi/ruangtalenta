<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
        <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
    </head>
    <body style="background-color: #F5F7FC;">
        <div class="d-flex">
            @include('layouts.sidebar')

            <div class="flex-grow-1">
                <nav id="navbar" class="navbar navbar-expand-lg navbar-light shadow-sm px-3 sticky-top" style="background-color: #222D65; font-family: 'Poppins', sans-serif; font-size: 16px;">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
                            <ul class="navbar-nav ms-auto">
                                @auth
                                    <li class="nav-item dropdown">
                                        <li class="nav-item">
                                            <a href="#" class="nav-link text-white position-relative">
                                                <i class="bi bi-bell-fill fs-5"></i> {{-- Bootstrap Icons --}}
                                            </a>
                                        </li>
                                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                            @php
                                                $user = Auth::user();
                                                $avatar = $user->avatar 
                                                    ? Storage::url($user->avatar)
                                                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff&size=32';
                                            @endphp
                                            <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle" width="32" height="32">
                                            <span>{{ $user->name }}</span>
                                        </a>

                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('home') }}">Home</a></li>
                                            <li><a class="dropdown-item" href="{{ route('setting.edit') }}">Setting</a></li>
                                            
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf 
                                                    <button class="dropdown-item">Logout</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                @else
                                    <ul class="navbar-nav ms-auto d-flex align-items-center gap-2">
                                        <li class="nav-item">
                                            <a class="btn btn-outline-light btn-sm" href="{{ route('register.perusahaan') }}">Untuk Perusahaan</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-white" href="{{ route('register') }}">Register</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
                                        </li>
                                    </ul>
                                @endauth
                            </ul>
                        </div>
                    </div>
                    </nav>


                @isset($header)
                    <div class="container mt-4">
                        <h2>{{ $header }}</h2>
                    </div>
                @endisset

                <main class="container mt-4">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
