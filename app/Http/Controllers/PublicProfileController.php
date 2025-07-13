<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            abort(403, 'You must be logged in.');
        }
        $posts = $user->posts()->latest()->paginate();
        return view('profile.show', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }
}
