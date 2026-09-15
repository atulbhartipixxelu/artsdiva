<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    protected $fillable = [
        'title', 'slug', 'tags', 'date_label', 'time_label', 'location',
        'image', 'description', 'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Event $item) {
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
            return asset('images/photo-1460661419201-fd4cecdf8a8b.jpg');
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        return asset($this->image);
    }
}
