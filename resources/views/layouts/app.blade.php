<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
        <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    @stack('styles')
    </head>
    <body>
        <div class="d-flex">
            @include('layouts.sidebar')

            <div class="flex-grow-1">
                @include('layouts.navigation')

                @isset($header)
                    <div class="container mt-4">
                        <h2>{{ $header }}</h2>
                    </div>
                @endisset

                <main class="container mt-4">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
