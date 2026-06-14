<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    protected $table = 'tbl_post';
    protected $primaryKey = 'id';
    protected $fillable = [
        'category_id', 'title', 'slug', 'author', 'excerpt', 'content',
        'image', 'tags', 'meta_title', 'meta_description', 'status', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'category_id', 'id');
    }

    /* ---------------- Query scopes ---------------- */

    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }

    /* ---------------- Helpers ---------------- */

    // Tags as an array, parsed from the comma separated column.
    public function getTagListAttribute()
    {
        return collect(explode(',', (string) $this->tags))
            ->map(fn ($t) => trim($t))
            ->filter()
            ->values();
    }

    // Resolved featured-image URL (supports full URLs and stored paths).
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        return Str::startsWith($this->image, ['http://', 'https://', '/'])
            ? $this->image
            : asset($this->image);
    }

    // Short summary for cards: excerpt, or trimmed content.
    public function getSummaryAttribute()
    {
        return $this->excerpt ?: Str::limit(strip_tags((string) $this->content), 140);
    }
}
