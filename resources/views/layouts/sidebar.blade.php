<div :class="open ? 'w-64' : 'w-20'" class="bg-gray-900 text-white h-screen fixed p-5 transition-all duration-300 flex flex-col">
            <button @click="open = !open" class="mb-5 p-2 bg-gray-700 rounded text-center">
                <span x-show="open" x-transition>Collapse</span>
                <span x-show="!open" x-transition>=</span>
            </button>

            <ul class="space-y-2 flex-1">
                <li class="flex items-center p-3 rounded-lg hover:bg-gray-700 cursor-pointer">
                    <svg class="w-6 h-6 mr-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21V3m5 18v-9m4 4v-5" />
                    </svg>
                    <span x-show="open" x-transition>Dashboard</span>
                </li>
                <li class="flex items-center p-3 rounded-lg hover:bg-gray-700 cursor-pointer">
                    <svg class="w-6 h-6 mr-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span x-show="open" x-transition>Job Listings</span>
                </li>
                <li class="flex items-center p-3 rounded-lg hover:bg-gray-700 cursor-pointer">
                    <svg class="w-6 h-6 mr-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m4 4H9m8-8H9" />
                    </svg>
                    <span x-show="open" x-transition>Applications</span>
                </li>
            </ul>
        </div>