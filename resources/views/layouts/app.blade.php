<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
        <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    
    </head>
    <body style="background-color: #F5F7FC;">
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
