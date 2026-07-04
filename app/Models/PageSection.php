<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'content',
        'extra',
        'is_active',
    ];

    protected $casts = [
        'extra' => 'array',
        'is_active' => 'boolean',
    ];

    public static function getBySlug(string $slug): ?static
    {
        return static::where('slug', $slug)->where('is_active', true)->first();
    }

    public function getExtra(string $key, $default = null)
    {
        return data_get($this->extra, $key, $default);
    }
}
