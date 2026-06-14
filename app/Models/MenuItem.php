<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;
    protected $table = 'tbl_menu_item';
    protected $primaryKey = 'id';
    protected $fillable = [
        'menu_id',
        'parent_id',
        'title',
        'link_type',
        'url',
        'page_id',
        'icon',
        'target',
        'sort_order',
        'status',
    ];

    /**
     * Relationships
     */

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id', 'id');
    }

    // Recursive children -> supports sub menu, sub sub menu, ... (unlimited depth).
    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id', 'id')
            ->where('status', 1)
            ->orderBy('sort_order')
            ->with('children');
    }

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }

    /**
     * Resolve the final href for this item based on its link type.
     */
    public function getLinkAttribute()
    {
        if ($this->link_type === 'page' && $this->page) {
            return url('/page/' . $this->page->slug);
        }

        return $this->url ?: '#0';
    }
}
