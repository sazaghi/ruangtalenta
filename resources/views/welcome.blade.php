<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ruang Talenta</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .hero-section {
            position: relative;
            height: 100vh;
            background-image: url("{{ asset('images/Group 427319046 (1).png') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
        }

        .stat-box {
            text-align: center;
            margin: 0 20px;
        }
    </style>
</head>
<body class="bg-light">
@include('layouts.navigation')

<!-- Hero Section -->
<!-- Hero Section -->
<section class="hero-section d-flex align-items-center">
  <div class="hero-overlay d-flex flex-row justify-content-between align-items-center w-100 px-5">
    <div class="text-start" style="max-width: 600px;">
      <h1 class="display-5 fw-bold">Bangun Karier Impianmu di <span style="color: #222D65;">Ruang Talenta</span></h1>
      <p class="lead mt-3">Jelajahi ribuan lowongan kerja yang sesuai dengan keahlian dan passionmu</p>

      <div class="input-group mt-4">
        <input type="text" class="form-control rounded-start" placeholder="Posisi atau perusahaan">
        <button class="btn btn-danger rounded-end px-4">Cari</button>
      </div>

      <div class="d-flex mt-5 gap-5 text-white">
        <div class="stat-box">
          <h3>10K+</h3>
          <p>Lowongan Tersedia</p>
        </div>
        <div class="stat-box">
          <h3>1K+</h3>
          <p>Perusahaan</p>
        </div>
        <div class="stat-box">
          <h3>3K+</h3>
          <p>Blog & Forum</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Categories Section -->
<section class="py-5 bg-white">
  <div class="container">
    <h2 class="fw-bold mb-4">Popular Category</h2>
    <div class="row justify-content-center g-4">
      @foreach($categories as $index => $category)
      <div class="col-md-2 col-6 text-center">
        <img src="{{ $categoryImages[$index] ?? 'https://via.placeholder.com/80' }}" alt="{{ $category->name }}" class="mb-2" width="180" height="250">
        <p>{{ $category->name }}</p>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- Jobs Section -->
<section class="py-3">
  <div class="container">
    <h2 class="fw-bold mb-4">New Job Offer</h2>
    <div class="row g-4">
      @forelse ($jobs as $job)
      <div class="col-md-4">
        <div class="card h-100 shadow-sm rounded-4 p-2">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <div class="d-flex align-items-center">
                <img src="{{ asset('storage/' . $job->company->profile->avatar) }}" onerror="this.src='https://via.placeholder.com/40'" alt="Logo" width="40" class="me-2 rounded-circle">
                <div>
                  <strong class="d-block">{{ $job->company->name }}</strong>
                  <small class="text-muted">{{ $job->location ?? 'Example Location' }}</small>
                </div>
              </div>
              <small class="text-muted">{{ $job->created_at->diffForHumans() }}</small>
            </div>

            <span class="badge bg-warning text-dark mb-2">{{ $job->category->name ?? 'Uncategorized' }}</span>

            <h5 class="fw-bold mb-2">{{ $job->title }}</h5>

            <div class="d-flex flex-wrap gap-2 mb-3">
              @foreach ($job->skills as $skill)
              <span class="badge bg-primary">{{ $skill }}</span>
              @endforeach
            </div>

            <strong class="fs-6 text-dark">
              Rp {{ number_format($job->salary_min, 0, ',', '.') }} - Rp {{ number_format($job->salary_max, 0, ',', '.') }}
            </strong>

            @if (auth()->check() && auth()->user()->hasRole('pencarikerja'))
            <form action="{{ route('job.apply', $job->id) }}" method="POST">
              @csrf
              <button type="submit" class="btn btn-primary w-100 mt-3">Apply</button>
            </form>
            @endif
          </div>
        </div>
      </div>
      @empty
      <p class="text-muted text-center">No job postings available.</p>
      @endforelse
    </div>

    <div class="text-center mt-4">
      <a href="{{ route('job.show') }}" class="btn btn-dark px-4 py-2">View All Jobs</a>
    </div>
  </div>
</section>


@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#3085d6'
    });
</script>
@endif

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
