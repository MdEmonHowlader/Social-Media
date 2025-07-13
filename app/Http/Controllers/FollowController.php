<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function store(User $user)
    {
        $currentUser = auth()->guard()->user();

        if (!$currentUser) {
            abort(403);
        }

        // Avoid duplicate entries
        if (!$currentUser->following()->where('user_id', $user->id)->exists()) {
            $currentUser->following()->attach($user->id);
        }

        return back();
    }

    public function destroy(User $user)
    {
        $currentUser = auth()->guard()->user();

        if (!$currentUser) {
            abort(403);
        }

        $currentUser->following()->detach($user->id);

        return back();
    }
}
