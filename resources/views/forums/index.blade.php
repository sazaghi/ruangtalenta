@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-4">Forum Diskusi</h1>

    <a href="{{ route('forums.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Buat Forum</a>

    <div class="mt-6 space-y-4">
        @foreach ($forums as $forum)
            <div class="p-4 bg-white shadow rounded">
                <h2 class="text-lg font-bold">
                    <a href="{{ route('forums.show', $forum) }}" class="text-blue-600">{{ $forum->title }}</a>
                </h2>
                <p class="text-gray-600 text-sm">Dibuat oleh {{ $forum->user->name }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
