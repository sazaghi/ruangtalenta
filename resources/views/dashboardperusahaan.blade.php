<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">
            {{ __('Dashboard') }}
        </h1>
        <div class="flex items-center gap-3 bg-white p-2 rounded-md shadow">
            <input type="text" placeholder="Search.." class="outline-none border-none bg-transparent px-2">
            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.5-5.65a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405M16 3.6a9 9 0 11-3.9 3.9"/>
            </svg>
        </div>
    </x-slot>
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 rounded-lg shadow flex items-center gap-3">
            <div class="bg-yellow-200 p-3 rounded-full">
                <svg class="w-6 h-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold">10</h3>
                <p class="text-gray-500">Posted Job</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow flex items-center gap-3">
            <div class="bg-yellow-200 p-3 rounded-full">
                <svg class="w-6 h-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l4-4 4 4m0-4l-4-4-4 4"/>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold">80</h3>
                <p class="text-gray-500">Interview Schedule</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow flex items-center gap-3">
            <div class="bg-yellow-200 p-3 rounded-full">
                <svg class="w-6 h-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3m5 18v-9m4 4v-5"/>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold">1.9k</h3>
                <p class="text-gray-500">Applications</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow flex items-center gap-3">
            <div class="bg-yellow-200 p-3 rounded-full">
                <svg class="w-6 h-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold">05</h3>
                <p class="text-gray-500">Saved Candidates</p>
            </div>
        </div>
    </div>

    <!-- Job Views & Posted Jobs -->
    <div class="grid grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Job Views</h2>
            <div class="border rounded-md p-2">
                <select class="w-full border-none outline-none">
                    <option>Web & Mobile Prototype Designer</option>
                </select>
            </div>
            <img src="https://via.placeholder.com/300x150" alt="Graph" class="w-full mt-4">
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Posted Jobs</h2>
            <ul class="space-y-3">
                <li class="flex justify-between items-center border-b pb-2">
                    <span>Web & Mobile Prototype</span>
                    <span class="text-gray-500 text-sm">Full-time, Spain</span>
                </li>
                <li class="flex justify-between items-center border-b pb-2">
                    <span>Document Writer</span>
                    <span class="text-gray-500 text-sm">Part-time, Bangkok</span>
                </li>
                <li class="flex justify-between items-center border-b pb-2">
                    <span>Product Designer</span>
                    <span class="text-gray-500 text-sm">Part-time, Korea</span>
                </li>
                <li class="flex justify-between items-center border-b pb-2">
                    <span>Marketing Specialist</span>
                    <span class="text-gray-500 text-sm">Part-time, USA</span>
                </li>
                <li class="flex justify-between items-center">
                    <span>Outbound Call Service</span>
                    <span class="text-gray-500 text-sm">Full-time, UAE</span>
                </li>
            </ul>
        </div>
    </div>
    
</x-app-layout>
