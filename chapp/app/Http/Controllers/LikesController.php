<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('likes.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->toggle($request);
    }

    /**
     * Toggle like for a post
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'post_id' => 'required|exists:posts,id',
        ]);

        $userId = auth()->id();
        $postId = $request->post_id;

        // Check if user already liked this post
        $existingLike = Likes::where('user_id', $userId)
                            ->where('post_id', $postId)
                            ->first();

        if ($existingLike) {
            // Unlike: remove the like
            $existingLike->delete();
            $liked = false;
        } else {
            // Like: create new like
            Likes::create([
                'user_id' => $userId,
                'post_id' => $postId,
            ]);
            $liked = true;
        }

        // Return JSON response for AJAX requests
        if ($request->ajax()) {
            $likeCount = Likes::where('post_id', $postId)->count();
            return response()->json([
                'liked' => $liked,
                'like_count' => $likeCount
            ]);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Likes $likes)
    {
        return view('likes.show', compact('likes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Likes $likes)
    {
        return view('likes.edit', compact('likes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Likes $likes)
    {
        // For likes, we typically don't update, just toggle
        return $this->toggle($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Likes $likes)
    {
        $likes->delete();
        return redirect()->route('likes.index');
    }
}
