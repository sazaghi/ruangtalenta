<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareerHub</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <style>
        .hero-section {
            position: relative;
            height: 100vh;
            background: url('https://images-ext-1.discordapp.net/external/1saoSJ-XeHslgoTnTECpy59lZ_1XjzFRVBlk_FfmtnI/https/media.tenor.com/pqgfsPUQ-REAAAPo/panosso.mp4') center center / cover no-repeat;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            color: white;
        }
    </style>
    
</head>
<body class="bg-light">
    @include('layouts.navigation')

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-overlay d-flex flex-column justify-content-center align-items-center text-center px-3">
            <h1 class="display-5 fw-bold">Bangun Karier Impianmu di Ruang Talenta</h1>
            <p class="text-light mt-2">Jelajahi ribuan lowongan kerja yang sesuai dengan keahlian dan passionmu</p>
            
            <div class="mt-4 d-flex w-75">
                <input type="text" class="form-control rounded-start" placeholder="Posisi atau perusahaan">
                <button class="btn btn-danger rounded-end px-4">Cari</button>
            </div>

            <div class="mt-4 d-flex flex-wrap justify-content-center gap-2">
                <select class="form-select w-auto">
                    <option>Lokasi</option>
                </select>
                <select class="form-select w-auto">
                    <option>Gaji</option>
                </select>
                <select class="form-select w-auto">
                    <option>Industri</option>
                </select>
                <select class="form-select w-auto">
                    <option>Pengalaman</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Job Categories -->
    <div class="container py-5">
        <h2 class="h4 fw-bold text-center mb-4">Cari Berdasarkan Kategori</h2>
        <div class="d-flex justify-content-center flex-wrap gap-3">
            <button class="btn btn-outline-secondary">Teknologi & IT</button>
            <button class="btn btn-outline-secondary">Keuangan & Perbankan</button>
            <button class="btn btn-outline-secondary">Manufaktur & Teknik</button>
            <button class="btn btn-outline-secondary">Industri Kreatif & Desain</button>
        </div>
    </div>

    <!-- Featured Jobs -->
    <div class="container py-5">
        <h2 class="h3 fw-bold text-center mb-4">Featured Jobs</h2>
        <div class="text-center mb-4">
            <button class="btn btn-dark px-4 py-2" href="{{ route('job.show') }}" >View All Jobs</button>
        </div>

        <div class="row g-4">
            @foreach ($jobs as $job)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm border">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <img src="https://via.placeholder.com/50" alt="Company Logo" class="rounded me-3">
                                <div>
                                    <h5 class="mb-0">{{ $job->company_name }}</h5>
                                    <small class="text-muted">{{ $job->location }}</small>
                                </div>
                            </div>

                            <p class="fw-semibold mb-1">{{ $job->title }}</p>
                            <small class="text-muted">{{ $job->created_at->diffForHumans() }}</small>

                            <div class="mt-2 d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-dark">#PHP</span>
                                <span class="badge bg-light text-dark">#Laravel</span>
                            </div>

                            <p class="fw-bold fs-5 mt-3">Rp {{ number_format($job->salary, 0, ',', '.') }}</p>

                            @if (auth()->check() && auth()->user()->hasRole('pencarikerja'))
                                <form action="{{ route('job.apply', $job->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary w-100 mt-3">Apply</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            @if ($jobs->isEmpty())
                <p class="text-muted text-center">No job postings available.</p>
            @endif
        </div>
    </div>
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
</body>
</html>
