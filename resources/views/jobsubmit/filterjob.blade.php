<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
@include('layouts.navigation')
<div class="container mt-4">
        {{-- Carousel / Banner --}}
        <div class="mb-4">
            <div class="p-5 bg-light rounded shadow-sm text-center">
                <h2 class="fw-bold">Temukan Pekerjaan Impianmu di Sini!</h2>
                <p class="text-muted">Cari pekerjaan sesuai keahlian dan minatmu di berbagai industri</p>
                <img src="{{ asset('img/robot.png') }}" alt="banner" class="img-fluid" style="max-height: 200px;">
            </div>
        </div>

        <div class="row">
            {{-- Sidebar Filter --}}
            <div class="col-md-3">
                <h5 class="mb-3">Filter & Sorting</h5>

                {{-- Lokasi --}}
                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <select class="form-select" id="lokasi" name="lokasi">
                        <option selected>Kota/Provinsi</option>
                        <option>Jakarta</option>
                        <option>Bandung</option>
                        <option>Surabaya</option>
                        <!-- ... -->
                    </select>
                </div>

                {{-- Industri --}}
                <div class="mb-3">
                    <label class="form-label">Industri</label>
                    <div class="form-check"><input class="form-check-input" type="checkbox"> <label class="form-check-label">IT & Software</label></div>
                    <div class="form-check"><input class="form-check-input" type="checkbox"> <label class="form-check-label">Manajemen & Bisnis</label></div>
                    <div class="form-check"><input class="form-check-input" type="checkbox"> <label class="form-check-label">Keuangan</label></div>
                    <!-- ... -->
                </div>

                {{-- Gaji --}}
                <div class="mb-3">
                    <label class="form-label">Gaji</label>
                    <input type="range" class="form-range" min="1" max="10">
                </div>
            </div>

            {{-- Job Listing --}}
            <div class="col-md-9">
                {{-- Search & Sort --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="input-group" style="max-width: 400px;">
                        <input type="text" class="form-control" placeholder="Masukkan kota, posisi...">
                        <button class="btn btn-danger">Cari</button>
                    </div>
                    <div>
                        <select class="form-select" style="max-width: 200px;">
                            <option selected>Newest Post</option>
                            <option>Oldest Post</option>
                            <option>Highest Salary</option>
                        </select>
                    </div>
                </div>

                {{-- Job Cards --}}
                <div class="row row-cols-1 row-cols-md-2 g-4">
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