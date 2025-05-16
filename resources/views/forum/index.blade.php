    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Forum | Ruang Talenta</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    </head>
    <body class="bg-gray-100">

        @include('layouts.navigation')

        <section class="text-white py-5 position-relative overflow-hidden" style="background-color: #fcb045; ">
            <div class="container position-relative z-2">
                <div class="row">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">
                    Chat about careers in my career community!
                    </h1>
                    <p class="lead">
                    Join now and get insights from over millions of people
                    </p>
                </div>
                </div>
            </div>
        </section>
        
        <div class="max-w-6xl mx-auto px-4 mt-10 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                <button onclick="toggleModal()" class="flex-1 text-left border border-gray-300 rounded px-4 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white text-gray-500 hover:bg-gray-100">
                    Wanna ask something..?
                </button>          
            <select class="border border-gray-300 rounded px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option>Sort by Default</option>
                <option>Terbaru</option>
                <option>Populer</option>
            </select>
            </div>

            @foreach ($posts as $post)
                @if (!empty($post->title))
                    <div class="bg-white rounded-lg shadow px-6 py-4 relative">
                        @include('forum.partials.recentpost')
                    </div>
                @endif
            @endforeach

        </div>


            <div id="createPostModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden z-50">
                <div class="bg-white w-full max-w-lg rounded-lg p-6 shadow-lg relative">
                    <button onclick="toggleModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">&times;</button>
                    <h2 class="text-xl font-bold mb-4">Buat Postingan</h2>
                    <form method="POST" action="{{ route('post.store') }}">
                        @csrf
                        <input type="text" name="title" class="w-full border rounded p-2 mb-2" placeholder="Judul Forum" required>
                        <textarea name="content" rows="4" class="w-full border rounded p-2 mb-4" placeholder="Deskripsi forum (opsional)"></textarea>
                        
                        <div class="text-right">
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Buat Forum</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </body>
    <script>
        function toggleModal() {
            const modal = document.getElementById('createPostModal');
            modal.classList.toggle('hidden');
        }
    </script>

</html>
