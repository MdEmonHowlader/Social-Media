<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'content',
        'slug',
        'category_id',
        'image',
        'user_id',
        'published_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function claps()
    {
        return $this->hasMany(Clap::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function readTime($wordsPerMinute = 100)
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / $wordsPerMinute);

        return max(1, $minutes);
    }

    public function imageUrl()
    {
        if ($this->image) {
            // Check if the image file exists
            if (Storage::disk('public')->exists($this->image)) {
                return Storage::url($this->image);
            } else {
                // Log missing file
                \Illuminate\Support\Facades\Log::warning('Post image file not found: ' . $this->image . ' for post ID: ' . $this->id);
                return null;
            }
        }
        return null;
    }

    /**
     * Scope for searching posts by title and content
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('content', 'LIKE', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('username', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('category', function ($categoryQuery) use ($search) {
                        $categoryQuery->where('name', 'LIKE', "%{$search}%");
                    });
            });
        }
        return $query;
    }

    /**
     * Scope for filtering posts by category
     */
    public function scopeFilterByCategory($query, $categoryId)
    {
        if ($categoryId) {
            return $query->where('category_id', $categoryId);
        }
        return $query;
    }

    /**
     * Scope for filtering posts by author
     */
    public function scopeFilterByAuthor($query, $authorId)
    {
        if ($authorId) {
            return $query->where('user_id', $authorId);
        }
        return $query;
    }

    /**
     * Scope for filtering posts by date range
     */
    public function scopeFilterByDateRange($query, $startDate = null, $endDate = null)
    {
        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->where('created_at', '<=', $endDate . ' 23:59:59');
        }
        return $query;
    }

    /**
     * Scope for sorting posts
     */
    public function scopeSortBy($query, $sort = 'latest')
    {
        switch ($sort) {
            case 'oldest':
                return $query->orderBy('created_at', 'ASC');
            case 'popular':
                return $query->withCount('claps')->orderBy('claps_count', 'DESC');
            case 'title':
                return $query->orderBy('title', 'ASC');
            case 'latest':
            default:
                return $query->orderBy('created_at', 'DESC');
        }
    }
}
