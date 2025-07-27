<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Post;

class AdminController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_posts' => Post::count(),
            'total_categories' => Category::count(),
            'total_admins' => User::where('role', 'admin')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Display categories management page
     */
    public function categories()
    {
        $categories = Category::withCount('posts')->orderBy('name')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Store a new category
     */
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Category created successfully!');
    }

    /**
     * Update a category
     */
    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Category updated successfully!');
    }

    /**
     * Delete a category
     */
    public function deleteCategory(Category $category)
    {
        // Check if category has posts
        if ($category->posts()->count() > 0) {
            return back()->with('error', 'Cannot delete category that has posts. Please move or delete the posts first.');
        }

        $category->delete();
        return back()->with('success', 'Category deleted successfully!');
    }
}
