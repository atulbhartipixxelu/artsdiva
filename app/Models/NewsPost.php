<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsPost extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'body', 'image',
        'published_at', 'is_published',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (NewsPost $item) {
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
            return asset('images/photo-1579783902614-a3fb3927b6a5.jpg');
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        return asset($this->image);
    }
}
