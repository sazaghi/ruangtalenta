<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Forum and Comunity - {{ $post->title }}</title>
  <link rel="icon" type="image/png" href="{{ asset('images/page_logo.png') }}">
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
      <a href="{{ route('post.index') }}" class="text-decoration-none text-primary small d-inline-block mb-3">
        &larr; Back to Community
      </a>

      <div class="card shadow-sm border-0 mb-4">
        @php
                            $user = Auth::user();
                            $avatar = $user->avatar 
                                ? $user->avatar  // langsung URL Supabase
                                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0D8ABC&color=fff&size=32';
                        @endphp
        <div class="card-body">
          <h1 class="h5 fw-bold mb-3">{{ $post->title }}</h1>

          <div class="d-flex align-items-center text-muted small mb-3">
            <img src="{{ $avatar }}" 
                alt="Foto Profil" class="rounded-circle me-2" style="width: 24px; height: 24px;">
            <span class="fw-semibold text-dark">{{ $post->user->name ?? 'Unknown' }}</span>
            <span class="mx-2">•</span>
            <span>{{ $post->created_at->diffForHumans() }}</span>
          </div>

          <div class="text-dark mb-3">
            {!! nl2br(e($post->content)) !!}
          </div>

          <button onclick="toggleReplyModal()" class="btn btn-outline-primary btn-sm">Reply to this Post</button>
        </div>
      </div>

      <h2 class="h6 fw-semibold mb-3 text-dark">{{ $post->replies->count() }} Comment</h2>

      <div class="d-flex flex-column gap-3">
        @foreach ($post->replies as $reply)
          @include('forum.partials._reply', ['reply' => $reply])
        @endforeach
      </div>
    </div>
    <aside class="col-md-4">
      <h5 class="card-title mb-3 text-dark">Popular Discussions</h5>
      <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
          <ul class="list-unstyled">
            @foreach ($popularPosts as $p)
            <li class="mb-3">
              @php
                  $user = $p->user ?? null;
                  $avatar = $user?->avatar 
                      ? $user->avatar 
                      : 'https://ui-avatars.com/api/?name=' . urlencode($user?->name ?? 'User') . '&background=0D8ABC&color=fff&size=32';
              @endphp
              <div class="d-flex align-items-center mb-1">
                  <img src="{{ $avatar }}" 
                      alt="Foto Profil" 
                      class="rounded-circle me-2" 
                      style="width: 16px; height: 16px;"
                      onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=User&background=0D8ABC&color=fff&size=32';">

                  <small class="fw-semibold text-dark">{{ $user?->name ?? 'Unknown' }}</small>
              </div>
              <a href="{{ route('post.show', $p->id) }}" class="text-decoration-none d-block fw-medium text-primary">
                {{ \Illuminate\Support\Str::limit($p->title, 60) }}
              </a>
              <small class="text-muted">{{ $p->replies_count }}x Reply</small>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
      <h5 class="card-title mb-3 text-dark">Unanswered Discussions</h5>
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <ul class="list-unstyled">
            @foreach ($unansweredPosts as $p)
            <li class="mb-3">
              <div class="d-flex align-items-center mb-1">
                <img src="{{ $avatar }}" 
                      alt="Foto Profil" 
                      class="rounded-circle me-2" 
                      style="width: 16px; height: 16px;"
                      onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name=User&background=0D8ABC&color=fff&size=32';">

                <small class="fw-semibold text-dark">{{ $user?->name ?? 'Unknown' }}</small>
              </div>
              <a href="{{ route('post.show', $p->id) }}" class="text-decoration-none d-block fw-medium text-primary">
                {{ \Illuminate\Support\Str::limit($p->title, 60) }}
              </a>
              <small class="text-muted">0 comment</small>
            </li>
            @endforeach
          </ul>
        </div>
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
