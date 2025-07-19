<?php

namespace App\Http\Controllers;

use App\Models\Clap;
use Illuminate\Http\Request;
use App\Models\Post;

class PostClapController extends Controller
{
    public function clap(Post $post)
    {
        $post->claps()->create([
            'user_id' => auth()->id(),
        ]);
        return response()->json([
            'clapsCount' => $post->claps()->count(),
        ]);

    }
}
