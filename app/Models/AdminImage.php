<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AdminImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'filename',
        'original_name',
        'mime_type',
        'size',
        'path',
        'alt_text',
        'category',
        'uploaded_by',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    /**
     * Get the user who uploaded this image
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the full URL for the image
     */
    public function url()
    {
        return Storage::url($this->path);
    }

    /**
     * Get the full path for the image
     */
    public function fullPath()
    {
        return storage_path('app/public/' . $this->path);
    }

    /**
     * Get human readable file size
     */
    public function humanFileSize()
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Scope for filtering by category
     */
    public function scopeByCategory($query, $category)
    {
        if ($category) {
            return $query->where('category', $category);
        }
        return $query;
    }

    /**
     * Get available image categories
     */
    public static function getCategories()
    {
        return [
            'general' => 'General',
            'posts' => 'Post Images',
            'avatars' => 'Avatar Images',
            'banners' => 'Banner Images',
            'icons' => 'Icons',
            'backgrounds' => 'Backgrounds',
        ];
    }
}
