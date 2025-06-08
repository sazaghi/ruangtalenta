<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
        <link rel="icon" type="image/png" href="{{ asset('images/page_logo.png') }}">
        
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    
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
                                    <li class="nav-item dropdown me-3">
                                        <a class="nav-link text-white position-relative" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-bell fs-5"></i>
                                            @if(count($notifications ?? []) > 0)
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                    {{ count($notifications) }}
                                                </span>
                                            @endif
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end shadow p-2" aria-labelledby="notifDropdown" style="width: 320px; max-height: 350px; overflow-y: auto;">
                                            <li class="dropdown-header fw-semibold text-dark">Notifikasi</li>
                                            <li><hr class="dropdown-divider"></li>
                                            @forelse($notifications as $notif)
                                                @php 
                                                    $post = $notif->post ?? $notif->postKerja; 
                                                    $status = strtolower($notif->status);
                                                    $statusColor = match($status) {
                                                        'pending' => 'warning',
                                                        'on_screening' => 'primary',
                                                        'rejected' => 'danger',
                                                        'scheduled' => 'success',
                                                        default => 'secondary',
                                                    };
                                                @endphp
                                                <li>
                                                    <a class="dropdown-item d-flex justify-content-between align-items-start gap-2 py-2" href="#">
                                                        <div>
                                                            <i class="bi bi-bell-fill text-{{ $statusColor }}"></i>
                                                            <span class="text-dark">Lamaran ke <strong>{{ $post->title ?? $post->judul }}</strong></span>
                                                            <div>
                                                                <span class="badge bg-{{ $statusColor }} mt-1 text-uppercase small">{{ $notif->status }}</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                            @empty
                                                <li><span class="dropdown-item text-muted">Tidak ada notifikasi</span></li>
                                            @endforelse
                                        </ul>
                                    </li>

                                    <!-- Dropdown User -->
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                            @php
                                                $user = Auth::user();
                                                $avatar = $user->avatar 
                                                    ? Storage::url($user->avatar)
                                                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff&size=32';
                                            @endphp
                                            <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle" width="32" height="32">
                                            <span class="fw-semibold">{{ $user->name }}</span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end shadow">
                                            <li><a class="dropdown-item" href="{{ route('home') }}"><i class="bi bi-house-door me-2"></i>Home</a></li>
                                            <li><a class="dropdown-item" href="{{ route('setting.edit') }}"><i class="bi bi-gear me-2"></i>Setting</a></li>
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf 
                                                    <button class="dropdown-item"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </li>

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
