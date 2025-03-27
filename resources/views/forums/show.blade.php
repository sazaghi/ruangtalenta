@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
    <h1 class="text-2xl font-bold">{{ $forum->title }}</h1>
    <p class="text-gray-600">{{ $forum->description }}</p>
    <p class="text-sm text-gray-500">Dibuat oleh {{ $forum->user->name }}</p>

    <a href="{{ route('posts.create', $forum) }}" class="mt-4 px-4 py-2 bg-green-500 text-white rounded">Buat Postingan</a>

    <div class="mt-6 space-y-4">
        @foreach ($forum->posts as $post)
            <div class="p-4 bg-white shadow rounded">
                <h2 class="text-lg font-bold">
                    <a href="{{ route('posts.show', $post) }}" class="text-blue-600">{{ $post->title }}</a>
                </h2>
                <p class="text-gray-600">{{ Str::limit($post->content, 100) }}</p>
                <p class="text-sm text-gray-500">Dibuat oleh {{ $post->user->name }}</p>
            </div>
        @endforeach
    </div>
</div>
@endsection
