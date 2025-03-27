<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareerHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-md p-4 flex justify-between items-center fixed top-0 left-0 w-full z-50">
        <div class="text-lg font-bold">Job Search</div>
        <div class="flex space-x-4">
            <a href="{{ route('forums.index') }}" class="px-4 py-2 text-blue-600">Forum</a>
            @auth
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="px-4 py-2 text-blue-600">Register</a>
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Login</a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative w-full h-screen bg-cover bg-center" style="background-image: url('https://images-ext-1.discordapp.net/external/1saoSJ-XeHslgoTnTECpy59lZ_1XjzFRVBlk_FfmtnI/https/media.tenor.com/pqgfsPUQ-REAAAPo/panosso.mp4'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 flex flex-col justify-center items-center text-center text-white bg-black bg-opacity-50 px-6">
            <h1 class="text-3xl font-bold">Bangun Karier Impianmu di Ruang Talenta</h1>
            <p class="text-gray-300 mt-2">Jelajahi ribuan lowongan kerja yang sesuai dengan keahlian dan passionmu</p>
            <div class="mt-4 flex justify-center">
                <input type="text" class="w-1/2 px-4 py-2 border rounded-l" placeholder="Posisi atau perusahaan">
                <button class="px-6 py-2 bg-red-500 text-white rounded-r">Cari</button>
            </div>            
            <div class="mt-4 flex justify-center space-x-4">
                <select class="px-4 py-2 border rounded text-black">
                    <option>Lokasi</option>
                </select>
                <select class="px-4 py-2 border rounded text-black">
                    <option>Gaji</option>
                </select>
                <select class="px-4 py-2 border rounded text-black">
                    <option>Industri</option>
                </select>
                <select class="px-4 py-2 border rounded text-black">
                    <option>Pengalaman</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Job Categories -->
    <div class="max-w-6xl mx-auto py-12">
        <h2 class="text-2xl font-bold text-center mb-6">Cari Berdasarkan Kategori</h2>
        <div class="flex justify-center space-x-4">
            <button class="px-4 py-2 border rounded">Teknologi & IT</button>
            <button class="px-4 py-2 border rounded">Keuangan & Perbankan</button>
            <button class="px-4 py-2 border rounded">Manufaktur & Teknik</button>
            <button class="px-4 py-2 border rounded">Industri Kreatif & Desain</button>
        </div>
    </div>
    
    <div class="max-w-6xl mx-auto py-12">
        <h2 class="text-3xl font-bold text-center mb-6">Featured Jobs</h2>
        <div class="flex justify-center">
            <button class="px-6 py-3 bg-black text-white rounded-lg">View All Jobs</button>
        </div>
        
        <div class="grid grid-cols-3 gap-6 mt-8">
            @foreach ($jobs as $job)
                <div class="bg-white p-6 rounded-lg shadow border">
                    <!-- Header -->
                    <div class="flex items-center space-x-3">
                        <img src="https://via.placeholder.com/50" alt="Company Logo" class="w-12 h-12 rounded">
                        <div>
                            <h3 class="font-bold">{{ $job->company_name }}</h3>
                            <p class="text-sm text-gray-600">{{ $job->location }}</p>
                        </div>
                    </div>

                    <!-- Posisi dan Usia Posting -->
                    <div class="mt-3">
                        <p class="font-semibold">{{ $job->title }}</p>
                        <p class="text-xs text-gray-500">{{ $job->created_at->diffForHumans() }}</p>
                    </div>

                    <!-- Skill Tags -->
                    <div class="flex gap-2 mt-2">
                        <span class="bg-gray-200 text-gray-700 px-2 py-1 text-xs rounded">#PHP</span>
                        <span class="bg-gray-200 text-gray-700 px-2 py-1 text-xs rounded">#Laravel</span>
                    </div>

                    <!-- Gaji -->
                    <p class="font-bold text-lg mt-3">Rp {{ number_format($job->salary, 0, ',', '.') }}</p>

                    <!-- Tombol Apply -->
                    @if (auth()->check() && auth()->user()->hasRole('pencarikerja'))
                        <form action="{{ route('job.apply', $job->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="mt-4 block w-full text-center bg-blue-600 text-white py-2 px-4 rounded">
                                Apply
                            </button>
                        </form>
                    @endif

                </div>
            @endforeach
            @if ($jobs->isEmpty())
                <p class="text-gray-500 col-span-3 text-center">No job postings available.</p>
            @endif
        </div>
    </div>
</body>
</html>
