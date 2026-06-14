<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageBlock extends Model
{
    use HasFactory;
    protected $table = 'tbl_page_block';
    protected $primaryKey = 'id';
    protected $fillable = [
        'page_id',
        'block_type',
        'title',
        'subtitle',
        'content',
        'image',
        'settings',
        'sort_order',
        'status',
    ];

    // Cast the builder config JSON to an array automatically.
    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * Relationships
     */

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id', 'id');
    }
}
