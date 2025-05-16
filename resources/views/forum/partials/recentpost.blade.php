@php
    $user = $post->user;
    $avatar = $user->avatar 
        ? Storage::url($user->avatar)
        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff&size=32';
@endphp
<h2 class="text-lg font-semibold mb-2">
    <a href="{{ route('post.show', ['id' => $post->id]) }}" class=" no-underline nohover:no-underline text-blue-700">
        {{ $post->title }}
    </a>
</h2>
<p class="text-gray-600 text-sm mb-3">{{ Str::limit($post->content, 200) }}</p>
<div class="text-sm text-gray-500 flex justify-between items-center">
    <span>{{ $post->replies_count ?? $post->replies->count() }} {{ Str::plural('Reply', $post->replies->count()) }}</span>
    <span class="flex items-center gap-2">
        <img src="{{ $avatar }}" alt="Avatar" class="w-6 h-6 rounded-full object-cover">
        {{ $user->name ?? 'Unknown' }} • {{ $post->created_at->diffForHumans() }}
    </span>

</div>
<i class="bi bi-star-fill text-yellow-500 text-xl absolute top-4 right-4"></i>