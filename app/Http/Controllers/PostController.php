<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Tampilkan semua postingan utama + balasannya
    public function index(Request $request)
    {
        // Ambil 3 post dengan jumlah reply terbanyak
        $topPosts = Post::withCount('replies')
            ->orderBy('replies_count', 'desc')
            ->take(3)
            ->pluck('id')
            ->toArray();

        // Query dasar
        $query = Post::with('user')->withCount('replies');

        // Sorting berdasarkan dropdown filter
        switch ($request->input('sort')) {
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;

            case 'popular':
                $query->orderBy('replies_count', 'desc');
                break;

            case 'me':
                $query->where('user_id', auth()->id());
                break;

            // default: tidak sort/filter apa pun
        }

        // Ambil hasilnya (pakai paginate jika perlu)
        $posts = $query->get();

        return view('forum.index', compact('posts', 'topPosts'));
    }


    // Simpan postingan baru atau balasan
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'parent_id' => 'nullable|exists:posts,id',
        ]);

        Post::create([
            'user_id' => Auth::id(),
            'title' => $request->parent_id ? null : $request->title, 
            'content' => $request->content,
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'Postingan berhasil dikirim.');
    }
    public function show($id)
    {
        $post = Post::with(['user', 'replies.user', 'replies.replies.user'])->findOrFail($id);
        
        $popularPosts = \App\Models\Post::withCount('replies')
        ->whereNotNull('title')
        ->orderBy('replies_count', 'desc')
        ->take(3)
        ->get();

        // Unanswered: belum ada reply dan hanya yang memiliki title
        $unansweredPosts = \App\Models\Post::whereNotNull('title')
        ->doesntHave('replies')
        ->latest()
        ->take(3)
        ->get();


        // Mengembalikan view dengan data postingan
        return view('forum.detail', compact('post', 'popularPosts', 'unansweredPosts'));
    }
    public function reply(Request $request, $parent_id)
    {
        $request->validate([
            'content' => 'required'
        ]);

        Post::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'parent_id' => $parent_id
        ]);

        return back()->with('success', 'Balasan berhasil dikirim.');
    }
}
