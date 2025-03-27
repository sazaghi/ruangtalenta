<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidebar Alpine.js</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#D9D9D9] overflow-x-hidden">

    <div x-data="{ open: true }" class="flex h-screen">
        <div 
            x-show="open" 
            @click="open = false"
            class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"
            x-transition.opacity
        ></div>
        <!-- Sidebar -->
        @if(auth()->user()->hasRole('perusahaan'))
            @include('sidebarperusahaan')
        @elseif(auth()->user()->hasRole('pencarikerja'))
            @include('sidebarpencarikerja')
        @endif


        <!-- Kontainer utama -->
        <div class="flex-1 min-h-screen transition-all duration-300" :class="open ? 'ml-64' : 'ml-20'">
            <!-- Navbar -->
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header>
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>

</body>
</html>
