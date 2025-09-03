<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comments::with('user')->with('post')->latest()->paginate(10);
        return view('comments.index',compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('comments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'body' => 'required|string',
            'post_id' => 'required|exists:posts,id',
        ]);
        $comment = new Comments($validated);
        $comment->user_id = auth()->id();
        $comment->save();
        return redirect()->route('posts.show', $comment->post_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comments $comment)
    {
        return view('comments.show', ['comments' => $comment]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comments $comment)
    {
        return view('comments.edit', ['comments' => $comment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comments $comment)
    {
        $validated = $request->validate([
            'body' => 'required|string',
            'post_id' => 'required|exists:posts,id',
        ]);
        $comment->update($validated);
        return redirect()->route('comments.show', $comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comments $comment)
    {
        $comment->delete();
        return redirect()->route('comments.index');
    }
}
