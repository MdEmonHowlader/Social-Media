<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\AssignOp\Pow;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::orderBy('created_at', 'DESC');

        // If category filter is provided
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        $posts = $query->simplePaginate(5);
        $posts->appends($request->query());

        return view('post.index', [
            'posts' => $posts,
            'selectedCategory' => $request->category,
        ]);
    }

    /**
     * Display posts by category.
     */
    public function category(Category $category)
    {
        $posts = Post::where('category_id', $category->id)
            ->orderBy('created_at', 'DESC')
            ->simplePaginate(5);

        return view('post.index', [
            'posts' => $posts,
            'selectedCategory' => $category->id,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('post.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        $data = $request->validated();
        $image = $data['image'];
        // unset($data['image']);
        $data['slug'] = Str::slug($data['title']);
        $data['user_id'] = Auth::id();

        $imagePath = $image->store('posts', 'public');
        $data['image'] = $imagePath;

        Post::create($data);
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified post.
     *
     * @param  string  $postId
     * @return \Illuminate\View\View
     */
    public function show(string $username, Post $post)
    {
        return view('post.show', [
            'post' => $post,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
