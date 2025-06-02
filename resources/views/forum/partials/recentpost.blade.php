@php
    $user = $post->user;
    $avatar = $user->avatar 
        ? Storage::url($user->avatar)
        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff&size=32';
@endphp

<h2 class="h5 fw-semibold mb-2">
    <a href="{{ route('post.show', ['id' => $post->id]) }}" class="text-decoration-none text-primary">
        {{ $post->title }}
    </a>
</h2>

<p class="text-muted small mb-3">
    {{ Str::limit($post->content, 200) }}
</p>

<div class="d-flex justify-content-between align-items-center small text-muted">
    <span>
        {{ $post->replies_count ?? $post->replies->count() }} 
        {{ Str::plural('Reply', $post->replies->count()) }}
    </span>
    <span class="d-flex align-items-center">
        <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle me-2" style="width: 24px; height: 24px; object-fit: cover;">
        {{ $user->name ?? 'Unknown' }} • {{ $post->created_at->diffForHumans() }}
    </span>
</div>

@if (in_array($post->id, $topPosts))
    <i class="bi bi-star-fill text-warning position-absolute top-0 end-0 m-3 fs-5" title="Top 3 Popular Post"></i>
@endif
