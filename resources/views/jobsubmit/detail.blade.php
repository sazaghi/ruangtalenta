<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Pekerjaan - {{ $job->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .hero-section {
        background-color: #D3D8EB;
        padding: 30px;
        border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body class="bg-light">
@include('layouts.navigation')
<section class="hero-section py-4 rounded shadow-sm position-relative">
  <div class="container my-4 position-relative">

    <div class="row g-3 align-items-start">

      <!-- Logo -->
      <div class="col-md-auto text-center">
        <img src="{{ $job->company->profile->avatar ? asset('storage/' . $job->company->profile->avatar) : 'https://via.placeholder.com/60' }}" alt="Logo Perusahaan" class="rounded-circle border" width="80" height="80">
      </div>

      <!-- Informasi utama -->
      <div class="col">
        <div class="d-flex justify-content-between flex-wrap">

          <!-- Kiri: Info lowongan -->
          <div>
            <h5 class="fw-bold mb-1">{{ $job->title }}</h5>
            <div class="mb-2">
              <i class="bi bi-buildings me-1"></i>
              <a href="#" class="text-primary fw-semibold text-decoration-none">{{ $job->company->profile->full_name ?? 'Unknown' }}</a>
            </div>

            <ul class="list-unstyled small text-muted mb-0">
              <li><i class="bi bi-geo-alt me-2"></i>{{ $job->location }}</li>
              <li><i class="bi bi-cash-stack me-2"></i>IDR {{ number_format($job->salary_min) }} – {{ number_format($job->salary_max) }} / Bulan</li>
              <li><i class="bi bi-briefcase me-2"></i>{{ $job->experience }} Tahun</li>
            </ul>
          </div>

          <!-- Kanan: Status, waktu, tombol -->
          <div class="text-end">

                <!-- Tombol Tandai & Bagikan -->
                <div class="d-flex justify-content-end gap-2 mb-3">
                    <button class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-bookmark me-1"></i> Tandai
                    </button>
                    <button class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-share me-1"></i> Bagikan
                    </button>
                </div>

                <!-- Badge dan Tanggal -->
                <span class="badge bg-primary mb-2">Aktif Merekrut</span>
                <div class="small text-muted mb-4">
                    Tayang {{ $job->created_at->diffForHumans() }} —
                    Diperbarui {{ $job->updated_at->diffForHumans() }}
                </div>

                @if (auth()->check() && auth()->user()->hasRole('pencarikerja'))
                  <form action="{{ route('job.apply', $job->id) }}" method="POST" class="mb-0">
                    @csrf
                    <button class="btn btn-primary btn-sm px-5 py-2 w-100" >
                        Apply
                    </button>
                  </form>
                @endif
            </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="container my-4">
        <div class="row g-4">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header fs-4 fw-bold">
                        Description
                    </div>
                    <div class="card-body d-flex justify-content-between align-items-center">
                        {{ $job->description }}
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header fs-4 fw-bold">
                        Requirement
                    </div>
                    <div class="card-body">
                        Example Requirement
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <!-- Header: Logo & Nama Perusahaan -->
                        <div class="d-flex align-items-start mb-3">
                            <img src="{{ $job->company->profile->avatar ? asset('storage/' . $job->company->profile->avatar) : 'https://via.placeholder.com/60' }}"
                                class="me-3 rounded" alt="Logo Perusahaan" width="60" height="60">
                            <div>
                                <h5 class="mb-1">{{ $job->company->profile->full_name ?? 'Nama Perusahaan Tidak Tersedia' }}</h5>
                                <p class="text-muted mb-1">
                                    📍 {{ $job->location ?? $job->company->profile->city ?? 'Kota Jakarta (Dummy)' }}
                                </p>
                            </div>
                        </div>

                        <!-- Informasi Singkat -->
                        <div class="row small mb-3">
                            <div class="col-12 col-md-6">
                                <p class="mb-2"><strong>Head Office:</strong><br> {{ $job->company->profile->city ?? 'Belum dilampirkan' }}</p>
                            </div>
                            <div class="col-12 col-md-6">
                                <p class="mb-2"><strong>Website</strong><br> {{ $job->company->profile->website  ?? 'Belum dilampikan' }}</p>
                            </div>
                        </div>
                        @if (auth()->check() && auth()->user()->hasRole('pencarikerja'))
                        <form action="{{ route('job.apply', $job->id) }}" method="POST" class="mb-0">
                            @csrf
                            <button class="btn btn-primary w-100" >
                                Lamar Lowongan ini
                            </button>
                        </form>
                        @endif
                    </div>
                </div>


            </div>
        </div>
    </div>
<div class="container my-5">
    <h2 class="h4 mb-4">Rekomendasi Kursus</h2>

    <div id="courseCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @if ($rekomendasi && count($rekomendasi) > 0)
                @foreach ($rekomendasi as $index => $course)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="d-flex flex-column flex-md-row align-items-center justify-content-between text-dark rounded p-4" style="min-height: 300px; background-color: #D3D8EB;">
                            <!-- Text Kiri -->
                            <div class="col-md-6 text-center text-md-start">
                                <h3 class="fw-bold display-6">{{ $course['title'] }}</h3>
                                <p class="mt-3">{{ $course['description'] }}</p>
                                <a href="{{ $course['link'] }}" target="_blank" class="btn btn-dark mt-3">Lihat Kursus</a>
                            </div>
                            
                            <!-- Gambar Kanan -->
                            <div class="col-md-5 text-center mt-4 mt-md-0">
                                <img src="{{ asset('images/examplecouse.jpg') }}" alt="Ilustrasi" class="img-fluid" style="max-height: 250px;">
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="carousel-item active">
                    <div class="d-flex flex-column flex-md-row align-items-center justify-content-between bg-light text-dark rounded p-4" style="min-height: 300px;">
                        <div class="col-md-6 text-center text-md-start">
                            <h3 class="fw-bold">Tidak ada kursus yang direkomendasikan</h3>
                            <p class="mt-3">Silakan cek kembali nanti.</p>
                        </div>
                        <div class="col-md-5 text-center mt-4 mt-md-0">
                            <img src="{{ asset('images/empty.png') }}" alt="Kosong" class="img-fluid" style="max-height: 250px;">
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#courseCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#courseCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
