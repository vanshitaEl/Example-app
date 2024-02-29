<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
      
        // $posts = Post::all();
        $posts = Post::latest()->paginate(10);
        return view('comment-like.index1', compact('posts'));
    }

    public function create()
    {
        return view('comment-like.create1');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
        Post::create($request->all());
        return redirect()->route('posts.index1');
    }

    public function show($id)
    {
        $post = Post::find($id);
        return view('comment-like.show1', compact('post'));
    }
}
