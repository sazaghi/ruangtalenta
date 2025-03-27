<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Submit Job') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">Submit Job</h2>
                <form action="{{ url('/job') }}" method="POST" class="flex flex-col space-y-4">
                    @csrf
                    <label class="text-gray-700 dark:text-gray-300 font-medium">Judul Pekerjaan</label>
                    <input type="text" name="title" placeholder="Judul Pekerjaan" required 
                        class="w-full p-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white">
                    
                    <label class="text-gray-700 dark:text-gray-300 font-medium">Deskripsi Pekerjaan</label>
                    <textarea name="description" placeholder="Deskripsi Pekerjaan" required 
                        class="w-full p-2 h-32 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white"></textarea>
                    
                    <label class="text-gray-700 dark:text-gray-300 font-medium">Gaji (Opsional)</label>
                    <input type="number" name="salary" placeholder="Gaji (Opsional)" 
                        class="w-full p-2 border border-gray-300 rounded-md dark:bg-gray-700 dark:text-white">

                    <button type="submit" 
                        class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700">
                        Posting Pekerjaan
                    </button>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
