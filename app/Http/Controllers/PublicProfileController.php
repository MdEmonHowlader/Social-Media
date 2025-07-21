<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PublicProfileController extends Controller
{
    public function show(Request $request, $username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $posts = $user->posts()->latest()->paginate();

        return view('profile.show', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }
}
