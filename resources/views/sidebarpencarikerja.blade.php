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
            margin-left: 205px;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar" class="bg-light vh-100 position-fixed p-3 d-flex flex-column align-items-center">
        <!-- Toggle Button -->
        <button id="toggleSidebar" class="btn btn-outline-secondary w-100 mb-4">☰</button>

        <!-- Profile -->
        <div class="text-center w-100">
            <img src="{{ auth()->user()->profile && auth()->user()->profile->avatar 
                ? Storage::url(auth()->user()->profile->avatar) 
                : asset('images/default-avatar.png') }}" 
                id="profileImage"
                class="rounded-circle border border-secondary d-block mx-auto"
                style="width: 40px; height: 40px; transition: all 0.3s;">

            <div id="profileDetails" class="mt-2 text-center d-none">
                <h6 class="mb-0 fs-6">{{ Auth::user()->name }}</h6>
                <span class="text-success small">● Online</span>
            </div>
        </div>

        <!-- Menu -->
        <ul class="nav flex-column mt-4 w-100">
            <li class="nav-item mb-2">
                <a href="{{ route('dashboard') }}" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-house-door me-2"></i>
                    <span class="menu-label d-none">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('profile.edit') }}" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-person me-2"></i>
                    <span class="menu-label d-none">My Profile</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('user_uploads.index') }}" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-upload me-2"></i>
                    <span class="menu-label d-none">upload Summary</span>
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('calendar.user') }}" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-calendar me-2"></i>
                    <span class="menu-label d-none">Calendar</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('job.tracking') }}" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-binoculars me-2"></i>
                    <span class="menu-label d-none">Tracking Lamaran</span>
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('job.tracking') }}" class="nav-link text-dark d-flex align-items-center">
                    <i class="bi bi-door-closed me-2"></i>
                    <span class="menu-label d-none">Logout</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div id="main-content" class="p-4 flex-grow-1">
        <!-- Kosongin aja, nanti diisi dari blade pakai slot -->
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

            // Hide labels & profile
            document.querySelectorAll(".menu-label, #profileDetails").forEach(el => {
                el.classList.add("d-none");
            });
        } else {
            sidebar.classList.add("expanded");
            mainContent.classList.add("expanded");

            // Show labels & profile
            document.querySelectorAll(".menu-label, #profileDetails").forEach(el => {
                el.classList.remove("d-none");
            });
        }
    }

    toggleBtn.addEventListener("click", toggleSidebar);
    
    document.addEventListener("click", (e) => {
        const clickedInsideSidebar = sidebar.contains(e.target);
        const clickedToggle = toggleBtn.contains(e.target);

        if (!clickedInsideSidebar && !clickedToggle && sidebar.classList.contains("expanded")) {
            toggleSidebar(true); // Force close
        }
    });
</script>

</body>
</html>
