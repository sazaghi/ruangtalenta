@extends('layouts.app')

@section('title', 'Ajukan Pertanyaan | Ruang Talenta')

@section('content')
<div class="container mx-auto mt-8 max-w-3xl bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Ajukan Pertanyaan</h1>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf

        <!-- Forum -->
        <div class="mb-4">
            <label for="forum_id" class="block text-gray-700 font-medium mb-2">Pilih Forum</label>
            <select name="forum_id" id="forum_id" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="">-- Pilih Forum --</option>
                @foreach ($forums as $forum)
                    <option value="{{ $forum->id }}" {{ old('forum_id') == $forum->id ? 'selected' : '' }}>
                        {{ $forum->title }}
                    </option>
                @endforeach
            </select>
            @error('forum_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Judul -->
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-medium mb-2">Judul</label>
            <input type="text" name="title" id="title" class="w-full border border-gray-300 rounded px-3 py-2" value="{{ old('title') }}">
            @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Isi Konten -->
        <div class="mb-4">
            <label for="content" class="block text-gray-700 font-medium mb-2">Isi Pertanyaan</label>
            <textarea name="content" id="content" rows="5" class="w-full border border-gray-300 rounded px-3 py-2">{{ old('content') }}</textarea>
            @error('content') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Submit -->
        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Kirim Pertanyaan
            </button>
        </div>
    </form>
</div>
@endsection
