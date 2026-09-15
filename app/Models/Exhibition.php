<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Exhibition extends Model
{
    protected $fillable = [
        'title', 'slug', 'subtitle', 'dates', 'location', 'image',
        'description', 'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }

    protected static function booted(): void
    {
        static::saving(function (Exhibition $item) {
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
            return asset('images/photo-1541961017774-22349e4a1262.jpg');
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        return asset($this->image);
    }
}
