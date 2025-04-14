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