<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Forum | Ruang Talenta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .modal-custom {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body class="bg-light">

    @include('layouts.navigation')

    <!-- Header Section -->
    <section class="text-white py-5" style="background-color: #fcb045;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Chat about careers in my career community!</h1>
                    <p class="lead">Join now and get insights from over millions of people</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Forum Controls -->
    <div class="container my-5">
        <div class="row mb-4 align-items-center">
            <div class="col-md-8 mb-2 mb-md-0">
                <button class="btn btn-outline-secondary w-100 text-start" onclick="toggleModal()">Wanna ask something..?</button>
            </div>
            <div class="col-md-4">
                <form method="GET" id="sortForm">
                    <select class="form-select" name="sort" onchange="document.getElementById('sortForm').submit()">
                        <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Sort by Default</option>
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Populer</option>
                        <option value="me" {{ request('sort') == 'me' ? 'selected' : '' }}>Posted by Me</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Forum Posts -->
        @foreach ($posts as $post)
            @if (!empty($post->title))
                <div class="card mb-3 shadow-sm ">
                    <div class="card-body">
                        @include('forum.partials.recentpost')
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Modal -->
    <div id="createPostModal" class="modal fade" tabindex="-1" aria-labelledby="createPostModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Postingan</h5>
                    <button type="button" class="btn-close" onclick="toggleModal()" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('post.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Forum</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Judul Forum" required>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">Deskripsi forum (opsional)</label>
                            <textarea name="content" id="content" rows="4" class="form-control" placeholder="Deskripsi forum (opsional)"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="toggleModal()">Batal</button>
                        <button type="submit" class="btn btn-primary">Buat Forum</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let modalInstance;

        function toggleModal() {
            const modalElement = document.getElementById('createPostModal');
            if (!modalInstance) {
                modalInstance = new bootstrap.Modal(modalElement);
            }
            modalInstance.toggle();
        }
    </script>

</body>
</html>
