<?php

namespace App\Http\Controllers;

use App\Models\Clap;
use App\Models\Post;
use Illuminate\Http\Request;

class PostClapController extends Controller
{
    public function clap(Post $post)
    {
        $userId = auth()->id();

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
        }

        return response()->json([
            'count' => $post->claps()->count(),
            'hasClapped' => $hasClapped,
        ]);
    }
}
