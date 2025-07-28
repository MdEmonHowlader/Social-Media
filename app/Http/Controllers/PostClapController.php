<?php

namespace App\Http\Controllers;

use App\Models\Clap;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostLikedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostClapController extends Controller
{
    public function clap(Post $post)
    {
        $userId = Auth::id();
        /** @var User $user */
        $user = Auth::user();

        // Check if user has already clapped this post
        $existingClap = $post->claps()->where('user_id', $userId)->first();

        if ($existingClap) {
            // User has already clapped, so remove the clap
            $existingClap->delete();
            $hasClapped = false;
        } else {
            // User hasn't clapped, so add a clap
            $post->claps()->create([
                'user_id' => $userId,
            ]);
            $hasClapped = true;

            // Send notification to post author (but not if they clapped their own post)
            if ($post->user_id !== $userId) {
                $post->load('user');
                $post->user->notify(new PostLikedNotification($post, $user));
            }
        }

        return response()->json([
            'count' => $post->claps()->count(),
            'hasClapped' => $hasClapped,
        ]);
    }
}
