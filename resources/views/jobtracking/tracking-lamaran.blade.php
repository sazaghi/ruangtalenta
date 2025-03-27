<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tracking Lamaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Daftar Lamaran Saya</h3>

                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border border-gray-300 px-4 py-2">Posisi</th>
                            <th class="border border-gray-300 px-4 py-2">Status</th>
                            <th class="border border-gray-300 px-4 py-2">Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lamarans as $app)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">{{ $app->PostKerja->title }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <span class="px-2 py-1 rounded-full text-white text-sm 
                                    {{ $app->status == 'pending' ? 'bg-yellow-500' : 
                                       ($app->status == 'reviewed' ? 'bg-blue-500' : 
                                       ($app->status == 'interview' ? 'bg-green-500' : 
                                       ($app->status == 'accepted' ? 'bg-purple-500' : 'bg-red-500'))) }}">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">{{ $app->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if ($lamarans->isEmpty())
                    <p class="text-gray-500 text-center mt-4">Belum ada lamaran yang diajukan.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
