<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'tbl_menu';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'location',
        'status',
    ];

    /**
     * Relationships
     */

    // All items belonging to this menu.
    public function items()
    {
        return $this->hasMany(MenuItem::class, 'menu_id', 'id')->orderBy('sort_order');
    }

    // Only top-level items, with their nested children eager-loaded
    // (sub menu -> sub sub menu) for frontend rendering.
    public function rootItems()
    {
        return $this->hasMany(MenuItem::class, 'menu_id', 'id')
            ->whereNull('parent_id')
            ->where('status', 1)
            ->orderBy('sort_order')
            ->with('children');
    }
}
