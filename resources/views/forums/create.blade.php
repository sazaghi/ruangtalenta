@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-4">Buat Forum Baru</h1>

    <form action="{{ route('forums.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Judul Forum</label>
            <input type="text" name="title" class="w-full border rounded px-4 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Deskripsi</label>
            <textarea name="description" class="w-full border rounded px-4 py-2"></textarea>
        </div>

        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Buat</button>
    </form>
</div>
@endsection
