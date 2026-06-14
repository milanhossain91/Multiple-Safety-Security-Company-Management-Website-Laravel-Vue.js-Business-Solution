<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'tbl_setting';
    protected $primaryKey = 'id';
    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
    ];

    /**
     * Helper: read a single setting value by key.
     */
    public static function get($key, $default = null)
    {
        $row = static::where('key', $key)->first();

        return $row ? $row->value : $default;
    }

    /**
     * Helper: create or update a setting by key.
     */
    public static function set($key, $value, $group = 'general', $type = 'text')
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'group' => $group, 'type' => $type]
        );
    }
}
