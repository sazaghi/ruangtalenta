<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Forum;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create(Forum $forum)
    {
        return view('posts.create', compact('forum'));
    }

    public function store(Request $request, Forum $forum)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $forum->posts()->create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('forums.show', $forum)->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
}
