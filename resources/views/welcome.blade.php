<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareerHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-md p-4 flex justify-between items-center">
        <div class="text-lg font-bold">Job Search</div>
        <div>
            @auth
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="px-4 py-2 text-blue-600">Register</a>
                <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Login</a>
            @endauth
        </div>
    </nav>

    <div class="flex justify-center items-center h-screen">
        <div class="w-2/3 flex items-center">
            <!-- Kiri: Teks dan Search -->
            <div class="w-1/2 p-6">
                <h1 class="text-3xl font-bold">Welcome to CareerHub</h1>
                <p class="text-gray-600 mt-2">Find your dream job here</p>
                <div class="mt-4">
                    <input type="text" class="w-full px-4 py-2 border rounded" placeholder="Search for jobs">
                </div>
            </div>

            <!-- Kanan: Gambar Placeholder -->
            <div class="w-1/2 p-6">
                <div class="bg-gray-300 w-full h-48"></div>
            </div>
        </div>
    </div>
</body>
</html>
