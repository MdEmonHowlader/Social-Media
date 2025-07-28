<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Post;
use App\Models\AdminImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'total_images' => AdminImage::count(),
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

    /**
     * Display images management page
     */
    public function images(Request $request)
    {
        $query = AdminImage::with('uploader')->orderBy('created_at', 'desc');

        // Filter by category if provided
        if ($request->has('category') && $request->category) {
            $query->byCategory($request->category);
        }

        // Search by title or description
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('original_name', 'like', "%{$search}%");
            });
        }

        $images = $query->paginate(12);
        $categories = AdminImage::getCategories();

        return view('admin.images.index', compact('images', 'categories'));
    }

    /**
     * Store a new image
     */
    public function storeImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240', // 10MB max
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'alt_text' => 'nullable|string|max:255',
            'category' => 'required|string|in:' . implode(',', array_keys(AdminImage::getCategories())),
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $originalName = $file->getClientOriginalName();
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('admin-images', $filename, 'public');

            AdminImage::create([
                'title' => $request->title,
                'description' => $request->description,
                'filename' => $filename,
                'original_name' => $originalName,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'path' => $path,
                'alt_text' => $request->alt_text,
                'category' => $request->category,
                'uploaded_by' => Auth::id(),
            ]);

            return back()->with('success', 'Image uploaded successfully!');
        }

        return back()->with('error', 'Failed to upload image.');
    }

    /**
     * Update an image
     */
    public function updateImage(Request $request, AdminImage $image)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'alt_text' => 'nullable|string|max:255',
            'category' => 'required|string|in:' . implode(',', array_keys(AdminImage::getCategories())),
        ]);

        $image->update([
            'title' => $request->title,
            'description' => $request->description,
            'alt_text' => $request->alt_text,
            'category' => $request->category,
        ]);

        return back()->with('success', 'Image updated successfully!');
    }

    /**
     * Delete an image
     */
    public function deleteImage(AdminImage $image)
    {
        // Delete the file from storage
        if (Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        // Delete the database record
        $image->delete();

        return back()->with('success', 'Image deleted successfully!');
    }

    /**
     * Get image details (for AJAX)
     */
    public function getImage(AdminImage $image)
    {
        return response()->json([
            'id' => $image->id,
            'title' => $image->title,
            'description' => $image->description,
            'alt_text' => $image->alt_text,
            'category' => $image->category,
            'url' => $image->url(),
            'size' => $image->humanFileSize(),
            'uploader' => $image->uploader->name,
            'created_at' => $image->created_at->format('M d, Y'),
        ]);
    }
}
