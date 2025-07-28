<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Post;
use App\Models\AdminImage;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
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
            'total_contacts' => Contact::count(),
            'new_contacts' => Contact::where('status', 'new')->count(),
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

    /**
     * Display contacts management page
     */
    public function contacts(Request $request)
    {
        $query = Contact::with('repliedBy')->orderBy('created_at', 'desc');

        // Filter by status if provided
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Search by name, email, or subject
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $contacts = $query->paginate(15);

        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Show a specific contact message
     */
    public function showContact(Contact $contact)
    {
        // Mark as read if it's new
        if ($contact->isNew()) {
            $contact->markAsRead();
        }

        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Update contact status
     */
    public function updateContactStatus(Request $request, Contact $contact)
    {
        $request->validate([
            'status' => 'required|in:new,read,replied,closed',
        ]);

        $contact->update(['status' => $request->status]);

        return back()->with('success', 'Contact status updated successfully!');
    }

    /**
     * Reply to a contact message
     */
    public function replyToContact(Request $request, Contact $contact)
    {
        $request->validate([
            'reply_subject' => 'required|string|max:255',
            'reply_message' => 'required|string|max:5000',
        ]);

        // Send the reply email
        try {
            Mail::send('emails.contact-reply', [
                'contact' => $contact,
                'reply_subject' => $request->reply_subject,
                'reply_message' => $request->reply_message,
                'admin_name' => Auth::user()->name,
            ], function ($message) use ($contact, $request) {
                $message->to($contact->email, $contact->name)
                    ->subject($request->reply_subject)
                    ->replyTo(config('mail.from.address'), config('mail.from.name'));
            });

            // Mark as replied
            $contact->markAsReplied(Auth::id(), $request->reply_subject, $request->reply_message);

            return back()->with('success', 'Reply sent successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send reply. Please try again.');
        }
    }

    /**
     * Delete a contact message
     */
    public function deleteContact(Contact $contact)
    {
        $contact->delete();
        return back()->with('success', 'Contact message deleted successfully!');
    }
}
