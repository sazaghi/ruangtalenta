@php
    $user = $reply->user;
    $avatar = $user->avatar 
        ? Storage::url($user->avatar)
        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name ?? 'User') . '&background=0D8ABC&color=fff&size=32';
@endphp

<div class="card shadow-sm border-0">
    <div class="card-body pb-2">
        <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center">
                <img src="{{ $avatar }}" alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                <div>
                    <strong class="small text-dark d-block">{{ $user->name ?? 'Unknown' }}</strong>
                    <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>

        <div class="text-dark small mb-3">
            {!! nl2br(e($reply->content)) !!}
        </div>

        <button class="btn btn-sm btn-link text-primary px-0" onclick="document.getElementById('reply-form-{{ $reply->id }}').classList.toggle('d-none')">
            Reply
        </button>

        <form action="{{ route('post.reply', ['parent_id' => $reply->id]) }}" method="POST" class="d-none mt-3" id="reply-form-{{ $reply->id }}">
            @csrf
            <textarea name="content" class="form-control form-control-sm mb-2" rows="2" required></textarea>
            <div class="text-end">
                <button class="btn btn-sm btn-primary">Send</button>
            </div>
        </form>

        @if ($reply->replies->count() > 0)
        <div class="mt-3">
            <button class="btn btn-sm btn-link text-secondary px-0" onclick="document.getElementById('child-replies-{{ $reply->id }}').classList.toggle('d-none')">
                See {{ $reply->replies->count() }} replies
            </button>

            <div id="child-replies-{{ $reply->id }}" class="d-none mt-3 ms-3 border-start ps-3">
                @foreach ($reply->replies as $child)
                    @include('forum.partials._reply', ['reply' => $child])
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
