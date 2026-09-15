<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Publication extends Model
{
    protected $fillable = [
        'artist_name', 'title', 'slug', 'excerpt', 'image',
        'link_url', 'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }

    protected static function booted(): void
    {
        static::saving(function (Publication $item) {
            if (blank($item->slug)) {
                $item->slug = Str::slug($item->title);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function imageUrl(): string
    {
        if (! $this->image) {
            return asset('images/photo-1579783901586-d88db74b4fe4.jpg');
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        return asset($this->image);
    }
}
