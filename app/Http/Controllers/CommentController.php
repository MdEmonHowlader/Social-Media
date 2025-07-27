<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Get comments for a post.
     */
    public function index(Post $post)
    {
        $comments = $post->comments()->with('user')->latest()->get()->map(function ($comment) {
            return [
                'id' => $comment->id,
                'content' => $comment->content,
                'user' => [
                    'name' => $comment->user->name,
                    'username' => $comment->user->username,
                ],
                'created_at' => $comment->created_at->diffForHumans(),
                'can_delete' => Auth::id() === $comment->user_id,
            ];
        });

        return response()->json([
            'comments' => $comments,
        ]);
    }

    /**
     * Store a newly created comment.
     */
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        $comment->load('user');

        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'content' => $comment->content,
                'user' => [
                    'name' => $comment->user->name,
                    'username' => $comment->user->username,
                ],
                'created_at' => $comment->created_at->diffForHumans(),
                'can_delete' => Auth::id() === $comment->user_id,
            ],
            'total_comments' => $post->comments()->count(),
        ]);
    }

    /**
     * Remove the specified comment.
     */
    public function destroy(Comment $comment)
    {
        // Check if user can delete this comment
        if (Auth::id() !== $comment->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $postId = $comment->post_id;
        $comment->delete();

        return response()->json([
            'success' => true,
            'total_comments' => Comment::where('post_id', $postId)->count(),
        ]);
    }
}
