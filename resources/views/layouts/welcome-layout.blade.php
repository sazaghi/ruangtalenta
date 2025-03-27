<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareerHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Gunakan navbar dari navigation.blade.php -->
    <x-navigation />

    <div class="container mx-auto">
        {{ $slot }}
    </div>
</body>
</html>
