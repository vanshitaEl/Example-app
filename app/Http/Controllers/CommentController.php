<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required',
        ]);
        $input = $request->only('body','post_id');
        // $input['user_id'] = auth()->user()->id;
        Comment::create($input);
        return back();
    }
}
