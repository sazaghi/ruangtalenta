<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursus Tersedia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4 text-center fw-bold">Kursus Tersedia</h2>

    @php
        $courses = [
            [
                'title' => 'Belajar Data Science dari Nol',
                'instructor' => 'Andi Nugraha',
                'description' => 'Pelajari dasar-dasar data science menggunakan Python, Pandas, dan Machine Learning.',
                'price' => 'Gratis',
                'image' => 'https://via.placeholder.com/300x180?text=Data+Science',
            ],
            [
                'title' => 'Dasar Pemrograman Web',
                'instructor' => 'Rina Puspita',
                'description' => 'Kuasai HTML, CSS, dan JavaScript untuk menjadi web developer handal.',
                'price' => 'Rp 120.000',
                'image' => 'https://via.placeholder.com/300x180?text=Web+Dev',
            ],
            [
                'title' => 'Machine Learning untuk Pemula',
                'instructor' => 'Budi Setiawan',
                'description' => 'Memahami supervised dan unsupervised learning serta penerapannya.',
                'price' => 'Rp 150.000',
                'image' => 'https://via.placeholder.com/300x180?text=Machine+Learning',
            ],
        ];
    @endphp

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($courses as $course)
        <div class="col">
            <div class="card h-100 shadow-sm border-0 rounded-4">
                <img src="{{ $course['image'] }}" class="card-img-top rounded-top-4" alt="Gambar Kursus">
                <div class="card-body">
                    <h5 class="card-title">{{ $course['title'] }}</h5>
                    <p class="card-text text-muted">{{ $course['instructor'] }}</p>
                    <p class="card-text small">{{ \Illuminate\Support\Str::limit($course['description'], 100) }}</p>
                </div>
                <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center">
                    <span class="fw-semibold text-primary">{{ $course['price'] }}</span>
                    <a href="#" class="btn btn-sm btn-outline-primary rounded-pill">Lihat Detail</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

</body>
</html>
