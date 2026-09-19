<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Artwork extends Model
{
    protected $fillable = [
        'artist_id', 'title', 'slug', 'serial_number', 'city', 'category', 'price_eur',
        'dimensions', 'weight', 'year', 'medium', 'description',
        'thumbnail', 'gallery', 'is_featured', 'is_published', 'is_visible', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price_eur' => 'float',
            'gallery' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'is_visible' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Artwork $artwork) {
            if (blank($artwork->slug)) {
                $artwork->slug = Str::slug($artwork->title);
            }
            if ($artwork->is_visible === null) {
                $artwork->is_visible = false;
            }
        });
    }

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /** Public catalogue: published AND manually switched visible. */
    public function scopeListed($query)
    {
        return $query->published()->visible();
    }

    public function imageUrl(?string $path = null): string
    {
        $path ??= $this->thumbnail;
        if (! $path) {
            return asset('images/photo-1541961017774-22349e4a1262.jpg');
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset($path);
    }

    public function galleryUrls(): array
    {
        $items = $this->gallery ?: array_filter([$this->thumbnail]);

        return array_map(fn ($p) => $this->imageUrl($p), $items);
    }
}
