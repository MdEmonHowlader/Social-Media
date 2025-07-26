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

    public function following(Request $request, $username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $following = $user->following()->paginate(20);

        return view('profile.following', [
            'user' => $user,
            'following' => $following,
        ]);
    }
    public function followers(Request $request, $username)
    {
        $user = User::where('username', $username)->firstOrFail();

        $followers = $user->followers()->paginate(20);

        return view('profile.followers', [
            'user' => $user,
            'followers' => $followers,
        ]);
    }
}
