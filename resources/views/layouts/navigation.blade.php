<nav id="navbar" class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3">
  <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">Logo</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
          <ul class="navbar-nav">
              <li class="nav-item">
                  <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('job.show') }}">Find Job</a>
              </li>
          </ul>

          <ul class="navbar-nav ms-auto">
              @auth
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                          {{ Auth::user()->name }}
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                          <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li>
                          <li><form method="POST" action="{{ route('logout') }}">@csrf <button class="dropdown-item">Logout</button></form></li>
                      </ul>
                  </li>
              @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
              @endauth
          </ul>
      </div>
  </div>
</nav>
