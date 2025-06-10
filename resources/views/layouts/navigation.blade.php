<nav id="navbar" class="navbar navbar-expand-lg navbar-light shadow-sm px-3 sticky-top" style="background-color: #222D65; font-family: 'Poppins', sans-serif; font-size: 16px;">
  <div class="container-fluid">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-1" href="{{ route('home') }}">
            <img src="https://figmage.com/images/MxRP4yFlcG5FSL9xhYLr8.png" alt="Logo" style="height: 40px;">
        </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
          <ul class="navbar-nav">
              <li class="nav-item">
                  <a class="nav-link text-white {{ request()->is('/') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link text-white" href="{{ route('job.show') }}">Find Job</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link text-white" href="{{ route('post.index') }}">Forum</a>
              </li>
          </ul>

          <ul class="navbar-nav ms-auto">
              @auth
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle text-white d-flex align-items-center gap-2" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        @php
                            $user = Auth::user();
                            $avatar = $user->avatar 
                                ? $user->avatar  // langsung URL Supabase
                                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff&size=32';
                        @endphp

                        <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle" width="32" height="32">
                        <span>{{ $user->name }}</span>
                      </a>

                      <ul class="dropdown-menu dropdown-menu-end">
                          <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
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
                        <a class="btn btn-outline-light btn-sm" href="{{ route('register.perusahaan') }}">For the Company</a>
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
