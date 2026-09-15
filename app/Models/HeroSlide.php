<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'eyebrow', 'title', 'subtitle', 'image',
        'button_one_label', 'button_one_url',
        'button_two_label', 'button_two_url',
        'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function imageUrl(): string
    {
        if (! $this->image) {
            return asset('images/photo-1578301978693-85fa9c0320b9.jpg');
        }
        if (str_starts_with($this->image, 'http')) {
            return $this->image;
        }

        return asset($this->image);
    }
}
