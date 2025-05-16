@php
    $user = $reply->user;
    $avatar = $user->avatar 
        ? Storage::url($user->avatar)
        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff&size=32';
@endphp
<div class="ms-3 border-start ps-3">
    <div class="d-flex align-items-center justify-content-between mb-1">
        <div class="d-flex align-items-center gap-2">
            <img src="{{ $avatar }}" 
                 alt="Foto Profil" 
                 class="rounded-circle me-2" 
                 style="width: 32px; height: 32px;">
            <span class="fw-semibold small text-dark">{{ $reply->user->name ?? 'Unknown' }}</span>
        </div>
        <span class="small text-muted">{{ $reply->created_at->diffForHumans() }}</span>
    </div>

    <p class="text-dark small mb-2">{{ $reply->content }}</p>

    <button onclick="document.getElementById('reply-form-{{ $reply->id }}').classList.toggle('d-none')" class="btn btn-link btn-sm p-0 text-decoration-none text-primary">
        Balas
    </button>

    <form action="{{ route('post.reply', ['parent_id' => $reply->id]) }}" method="POST" class="d-none mt-2" id="reply-form-{{ $reply->id }}">
        @csrf
        <div class="mb-2">
            <textarea name="content" class="form-control form-control-sm" rows="2" required></textarea>
        </div>
        <div class="text-end">
            <button class="btn btn-primary btn-sm">Kirim</button>
        </div>
    </form>

    @if ($reply->replies->count() > 0)
        <button onclick="document.getElementById('child-replies-{{ $reply->id }}').classList.toggle('d-none')" class="btn btn-link btn-sm p-0 text-decoration-none text-secondary mt-2">
            Lihat {{ $reply->replies->count() }} balasan
        </button>

        <div id="child-replies-{{ $reply->id }}" class="d-none mt-3">
            @foreach ($reply->replies as $child)
                @include('forum.partials._reply', ['reply' => $child])
            @endforeach
        </div>
    @endif
</div>
