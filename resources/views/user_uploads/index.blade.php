<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Upload File Pendukung</h2>
    </x-slot>

    <x-slot name="sidebar">
        <!-- Tambahkan link ke sidebar -->
        <ul class="space-y-2">
            <li><a href="{{ route('dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a></li>
            <li><a href="{{ route('user_uploads.index') }}" class="block px-4 py-2 bg-blue-100 font-semibold rounded">Upload File</a></li>
            <!-- Tambah menu lainnya di sini -->
        </ul>
    </x-slot>

    <div class="max-w-3xl mx-auto py-6">
        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Upload --}}
        <form action="{{ route('user_uploads.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow mb-6">
            @csrf
            <div class="mb-4">
                <label class="block font-semibold mb-1">Nama File</label>
                <input type="text" name="file_name" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1">Pilih File</label>
                <input type="file" name="file" class="w-full border rounded px-3 py-2" required>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Upload
            </button>
        </form>

        {{-- Daftar File --}}
        <h3 class="text-lg font-bold mb-3">Daftar File</h3>

        @if ($uploads->count())
            <ul class="space-y-3">
                @foreach ($uploads as $upload)
                    <li class="border p-4 rounded flex justify-between items-center bg-white shadow-sm">
                        <div>
                            <p class="font-medium">{{ $upload->file_name }}</p>
                            <a href="{{ asset('storage/user_uploads/' . $upload->file_path) }}" target="_blank">
                                Lihat file
                            </a>

                        </div>
                        <form action="{{ route('user_uploads.destroy', $upload) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:text-red-800" onclick="return confirm('Hapus file ini?')">Hapus</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Belum ada file yang diupload.</p>
        @endif
    </div>
</x-app-layout>