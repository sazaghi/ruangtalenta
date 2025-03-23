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
        <div @click.away="open = false" :class="open ? 'w-64' : 'w-20'" class="bg-gray-200 text-white h-screen fixed p-5 transition-all duration-300 flex flex-col">
            <button @click="open = !open" class="mb-5 p-2 rounded text-center">
                <span x-show="!open" x-transition class="text-black">☰</span>
            </button>
            
            <!-- Profile Section -->
            <div class="mt-10 text-center">
                <img src="https://cdn.discordapp.com/attachments/1039930696933843039/1353374542344491109/Screenshot_2025-03-23_204104.png?ex=67e16bc3&is=67e01a43&hm=5297112655e704855cea3a6fc2b1bf03c9d185ef1e10a9b18cda7897c4179e84&" class="rounded-full border-2 border-gray-300 mx-auto" :class="open ? 'w-20 h-20' : 'w-10 h-10'">
                <template x-if="open" x-transition>
                    <div>
                        <h2 class="mt-2 font-semibold text-black">Dwi Jullian Daffa</h2>
                        <span class="text-xs text-green-400">● Online</span>
                    </div>
                </template>
            </div>

            <ul class="space-y-2 flex-1 mt-4">
                <li class="flex items-center p-3 rounded-lg hover:bg-gray-400 cursor-pointer">
                    <svg class="w-6 h-6 mr-3 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3m5 18v-9m4 4v-5" />
                    </svg>
                    <span x-show="open" x-transition class="text-black">Dashboard</span>
                </li>
                <li class="flex items-center p-3 rounded-lg hover:bg-gray-700 cursor-pointer">
                    <svg class="w-6 h-6 mr-3 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span x-show="open" x-transition class="text-black">My Profile</span>
                </li>
                <li class="flex items-center p-3 rounded-lg hover:bg-gray-700 cursor-pointer">
                    <svg class="w-6 h-6 mr-3 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m4 4H9m8-8H9" />
                    </svg>
                    <span x-show="open" x-transition class="text-black">Setting</span>
                </li>
                <li class="flex items-center p-3 rounded-lg hover:bg-gray-700 cursor-pointer">
                    <svg class="w-6 h-6 mr-3 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m4 4H9m8-8H9" />
                    </svg>
                    <span x-show="open" x-transition class="text-black">logout</span>
                </li>
            </ul>
        </div>

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
