<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $table = 'tbl_page';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'template',
        'template_data',
        'banner_image',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'show_in_menu',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'template_data' => 'array',
    ];

    /**
     * Relationships
     */

    // Page builder blocks, ordered for rendering.
    public function blocks()
    {
        return $this->hasMany(PageBlock::class, 'page_id', 'id')->orderBy('sort_order');
    }

    // Menu items that link to this page.
    public function menuItems()
    {
        return $this->hasMany(MenuItem::class, 'page_id', 'id');
    }
}
