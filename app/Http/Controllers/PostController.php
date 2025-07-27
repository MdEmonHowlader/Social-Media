<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\AssignOp\Pow;
use App\Models\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Post::with(['user', 'category'])
            ->withCount(['claps', 'comments'])
            ->orderBy('created_at', 'DESC');

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
        $posts = Post::with(['user', 'category'])
            ->withCount(['claps', 'comments'])
            ->where('category_id', $category->id)
            ->orderBy('created_at', 'DESC')
            ->simplePaginate(5);

        return view('post.index', [
            'posts' => $posts,
            'selectedCategory' => $category->id,
        ]);
    }

    /**
     * Display categories page with filtering options.
     */
    public function categoriesPage(Request $request)
    {
        $categories = Category::withCount('posts')->orderBy('name')->get();
        $totalPosts = Post::count(); // Get total count of all posts

        $query = Post::with(['user', 'category'])
            ->withCount(['claps', 'comments'])
            ->orderBy('created_at', 'DESC');

        // If category filter is provided
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
            $selectedCategory = $request->category;
        } else {
            $selectedCategory = null;
        }

        $posts = $query->simplePaginate(10);
        $posts->appends($request->query());

        return view('categories.index', [
            'categories' => $categories,
            'posts' => $posts,
            'selectedCategory' => $selectedCategory,
            'totalPosts' => $totalPosts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        }

        Post::create($validated);

        return redirect()->route('dashboard')->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($username, $post = null)
    {
        // Debug what we're receiving
        \Illuminate\Support\Facades\Log::info('PostController::show received:', [
            'username_type' => gettype($username),
            'username_value' => $username,
            'post_type' => gettype($post),
            'post_value' => $post,
            'request_url' => request()->url(),
            'route_params' => request()->route()->parameters()
        ]);
        
        // If we only got one parameter, it means the route matched incorrectly
        if ($post === null) {
            \Illuminate\Support\Facades\Log::error('PostController::show called with only username parameter - route mismatch!');
            abort(404, 'Post not found - route mismatch');
        }
        
        // If post is a string (slug), try to find the post by slug
        if (is_string($post)) {
            $postModel = Post::where('slug', $post)->firstOrFail();
        } else {
            $postModel = $post;
        }
        
        // Verify the post belongs to the user
        $user = User::where('username', $username)->firstOrFail();
        if ($postModel->user_id !== $user->id) {
            abort(404, 'Post not found for this user');
        }
        
        $postModel->load(['user', 'category']);
        $postModel->loadCount(['claps', 'comments']);

        return view('post.show', [
            'post' => $postModel,
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
