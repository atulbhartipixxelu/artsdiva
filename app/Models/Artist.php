<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Artist extends Model
{
    protected $fillable = [
        'name', 'slug', 'city', 'country', 'image', 'bio',
        'is_featured', 'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Artist $artist) {
            if (blank($artist->slug)) {
                $artist->slug = Str::slug($artist->name);
            }
        });
    }

    public function artworks(): HasMany
    {
        return $this->hasMany(Artwork::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
