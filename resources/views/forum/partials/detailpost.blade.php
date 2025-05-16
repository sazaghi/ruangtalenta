<main class="w-3/4 space-y-6">

    <div class="bg-white p-6 rounded-md shadow border">
        <div class="text-sm text-gray-500 mb-1 flex items-center justify-between">
            <span>{{ $post->user->name ?? 'Unknown' }}</span>
            <span>{{ $post->created_at->diffForHumans() }}</span>
        </div>

        <h1 class="text-xl font-bold text-gray-800 mb-3">{{ $post->title }}</h1>

        <p class="text-gray-700 whitespace-pre-line">
            {{ $post->content }}
        </p>

        <div class="mt-4 text-sm">
            <span class="bg-gray-200 text-gray-700 px-2 py-1 rounded">Unanswered</span>
        </div>
    </div>
</main>
