<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PublicProfileController extends Controller
{
    public function show(User $user){
        // $post= $user->posts()->lstat()->with('user')->paginate(10);
        // return view('profile.show', [
        //     'user' => $user,
            
           
        // ]);
          $users = User::all();
          $posts = Post::all();
           
    return view('profile.show', compact('users', 'user', 'posts'));
    }
}
