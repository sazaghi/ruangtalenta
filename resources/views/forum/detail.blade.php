<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Forum Detail | Ruang Talenta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

@include('layouts.navigation')

<div class="container px-3 px-md-5 py-5">
  <div class="row g-4">

    <!-- Main Post -->
    <div class="col-md-8">
      <a href="{{ route('post.index') }}" class="text-decoration-none text-primary small d-inline-block mb-2">&larr; Back to Community</a>

      <h1 class="h4 fw-semibold mb-2 text-start">{{ $post->title }}</h1>

      <div class="d-flex align-items-center text-muted small mb-3">
        <img src="{{ $reply->user->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name ?? 'User') . '&background=0D8ABC&color=fff&size=32' }}" 
             alt="Foto Profil" 
             class="rounded-circle me-2" 
             style="width: 24px; height: 24px;">
        <span class="fw-semibold small text-dark">{{ $reply->user->name ?? 'Unknown' }}</span>
        <span class="mx-2">•</span>
        <span>{{ $post->created_at->diffForHumans() }}</span>
      </div>

      <div class="bg-white rounded p-4 text-dark shadow-sm mb-4 text-start">
        {!! nl2br(e($post->content)) !!}
      </div>

      <button onclick="toggleReplyModal()" class="btn btn-outline-secondary btn-sm mb-4">Reply To the Post</button>

      <h2 class="h6 fw-semibold mb-3 text-dark text-start">{{ $post->replies->count() }} Comment</h2>

      <!-- Comment Thread -->
      <div class="d-flex flex-column gap-3">
        @foreach ($post->replies as $reply)
          @include('forum.partials._reply', ['reply' => $reply])
        @endforeach
      </div>
    </div>

    <!-- Sidebar -->
    <aside class="col-md-4">
      <div class="mb-5">
        <h3 class="h6 fw-semibold mb-3 text-dark">Popular Discussion</h3>
        <ul class="list-unstyled small text-dark">
          @foreach ($popularPosts as $p)
          <li class="mb-3">
            <div class="fw-bold">
              <img src="{{ $p->user->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($p->user->name ?? 'User') . '&background=0D8ABC&color=fff&size=32' }}" 
                   alt="Foto Profil" 
                   class="rounded-circle me-2" 
                   style="width: 16px; height: 16px;">
              <span class="fw-semibold small text-dark">{{ $p->user->name ?? 'Unknown' }}</span>
            </div>
            <a href="{{ route('post.show', $p->id) }}" class="text-decoration-none">{{ \Illuminate\Support\Str::limit($p->title, 60) }}</a><br>
            <span class="text-muted small">{{ $p->replies_count }}x Reply</span>
          </li>
          @endforeach
        </ul>
      </div>

      <div>
        <h3 class="h6 fw-semibold mb-3 text-dark">Unanswered Discussion</h3>
        <ul class="list-unstyled small text-dark">
          @foreach ($unansweredPosts as $p)
          <li class="mb-3">
            <div class="fw-bold">
              <img src="{{ $p->user->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($p->user->name ?? 'User') . '&background=0D8ABC&color=fff&size=32' }}" 
                   alt="Foto Profil" 
                   class="rounded-circle me-2" 
                   style="width: 16px; height: 16px;">
              <span class="fw-semibold small text-dark">{{ $p->user->name ?? 'Unknown' }}</span>
            </div>
            <a href="{{ route('post.show', $p->id) }}" class="text-decoration-none">{{ \Illuminate\Support\Str::limit($p->title, 60) }}</a><br>
            <span class="text-muted small">0 comment</span>
          </li>
          @endforeach
        </ul>
      </div>
    </aside>
  </div>
</div>

<!-- Modal Reply -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ route('post.reply', $post->id) }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Balas Postingan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <textarea name="content" rows="4" class="form-control" placeholder="Tulis balasan kamu di sini..." required></textarea>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function toggleReplyModal() {
    const modal = new bootstrap.Modal(document.getElementById('replyModal'));
    modal.toggle();
  }
</script>

</body>
</html>
