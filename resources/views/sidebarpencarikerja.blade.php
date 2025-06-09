<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
        }

        #sidebar {
            width: 80px;
            transition: width 0.3s ease;
            overflow: hidden;
        }

        #sidebar.expanded {
            width: 250px;
        }

        #main-content {
            margin-left: 33px;
            transition: margin-left 0.3s ease;
        }

        #main-content.expanded {
            margin-left: 200px;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            transition: all 0.3s ease;
        }

        #sidebar.expanded .profile-img {
            width: 80px;
            height: 80px;
        }

        #sidebar .nav-link {
            transition: background-color 0.2s ease;
        }

        #sidebar .nav-link:hover {
            background-color: #e2e6ea;
            border-radius: 0.375rem;
        }

        #sidebar .nav-link.active {
            background-color: #ced4da;
            font-weight: 500;
            border-radius: 0.375rem;
        }

        #sidebarLogo img {
            transition: transform 0.3s ease;
        }

        #sidebar.expanded #sidebarLogo img {
            transform: scale(1.1);
        }

        .sidebar-hidden {
            display: none !important;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar" class="bg-light vh-100 position-fixed p-3 d-flex flex-column align-items-center">
        <!-- Toggle Button -->
        <button id="toggleSidebar" class="btn w-100 mb-4">☰</button>

        <!-- Logo -->
        <div id="sidebarLogo" class="mb-4 sidebar-hidden w-100 text-center">
            <img src="{{ asset('images/ruang-talenta-img-1.png') }}" alt="Logo" style="max-width: 100px;">
        </div>

        <!-- Profile -->
        <div class="text-center w-100">
            @php
                $user = Auth::user();
                $avatar = optional($user->profile)?->avatar
                    ?: 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff&size=32';
            @endphp

            <img src="{{ $avatar }}" 
                id="profileImage"
                class="rounded-circle border border-secondary d-block mx-auto profile-img">
            <div id="profileDetails" class="mt-2 text-center sidebar-hidden">
                <h6 class="mb-0 fs-6">{{ Auth::user()->name }}</h6>
            </div>
        </div>

        <!-- Menu -->
        <ul class="nav flex-column mt-4 w-100" id="menuItems">
            <li class="nav-item mb-2">
                <a href="{{ route('dashboard') }}" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-house-door me-2"></i>
                    <span class="menu-label sidebar-hidden">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('profile.edit') }}" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-person me-2"></i>
                    <span class="menu-label sidebar-hidden">My Profile</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('user_uploads.index') }}" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-upload me-2"></i>
                    <span class="menu-label sidebar-hidden">Upload Summary</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('calendar.user') }}" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-calendar me-2"></i>
                    <span class="menu-label sidebar-hidden">Calendar</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('job.tracking') }}" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-binoculars me-2"></i>
                    <span class="menu-label sidebar-hidden">Tracking Lamaran</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('logout') }}" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-door-closed me-2"></i>
                    <span class="menu-label sidebar-hidden">Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div id="main-content" class="p-4 flex-grow-1">
        <!-- Konten dinamis -->
    </div>
</div>

<!-- Script -->
<script>
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.getElementById("toggleSidebar");
    const mainContent = document.getElementById("main-content");

    function toggleSidebar() {
        const isExpanded = sidebar.classList.contains("expanded");

        if (isExpanded) {
            sidebar.classList.remove("expanded");
            mainContent.classList.remove("expanded");

            document.querySelectorAll(".menu-label, #profileDetails, #sidebarLogo").forEach(el => {
                el.classList.add("sidebar-hidden");
            });

            toggleBtn.classList.remove("d-none");
        } else {
            sidebar.classList.add("expanded");
            mainContent.classList.add("expanded");

            document.querySelectorAll(".menu-label, #profileDetails, #sidebarLogo").forEach(el => {
                el.classList.remove("sidebar-hidden");
            });

            toggleBtn.classList.add("d-none");
        }
    }

    toggleBtn.addEventListener("click", toggleSidebar);

    document.addEventListener("click", (e) => {
        const clickedInsideSidebar = sidebar.contains(e.target);
        const clickedToggle = toggleBtn.contains(e.target);

        if (!clickedInsideSidebar && !clickedToggle && sidebar.classList.contains("expanded")) {
            toggleSidebar();
        }
    });

    // Tambahkan efek aktif saat diklik
    const menuItems = document.querySelectorAll("#menuItems .nav-link");
    menuItems.forEach(link => {
        link.addEventListener("click", () => {
            menuItems.forEach(l => l.classList.remove("active"));
            link.classList.add("active");
        });
    });
</script>

</body>
</html>
