<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;
    protected $table = 'tbl_post_category';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'slug', 'status'];

    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id', 'id');
    }

    // Count of published posts in this category (for the blog sidebar).
    public function publishedPosts()
    {
        return $this->hasMany(Post::class, 'category_id', 'id')->where('status', 1);
    }
}
