<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NewFollowerNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    public function store(User $user)
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser) {
            abort(403);
        }

        // Avoid duplicate entries
        if (!$currentUser->following()->where('user_id', $user->id)->exists()) {
            $currentUser->following()->attach($user->id);

            // Send notification to the user being followed
            $user->notify(new NewFollowerNotification($currentUser));
        }

        // Return JSON for AJAX requests
        if (request()->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully followed ' . $user->name,
                'following' => true,
                'followers_count' => $user->followers()->count()
            ]);
        }

        return back();
    }

    public function destroy(User $user)
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        if (!$currentUser) {
            abort(403);
        }

        $currentUser->following()->detach($user->id);

        // Return JSON for AJAX requests
        if (request()->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully unfollowed ' . $user->name,
                'following' => false,
                'followers_count' => $user->followers()->count()
            ]);
        }

        return back();
    }
}
