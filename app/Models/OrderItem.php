<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'artwork_id', 'title', 'artist_name', 'slug', 'thumbnail', 'price_eur',
    ];

    protected function casts(): array
    {
        return [
            'price_eur' => 'float',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function artwork(): BelongsTo
    {
        return $this->belongsTo(Artwork::class);
    }

    public function imageUrl(): string
    {
        if (! $this->thumbnail) {
            return asset('images/catalogue/artwork-001.png');
        }
        if (str_starts_with($this->thumbnail, 'http')) {
            return $this->thumbnail;
        }

        return asset($this->thumbnail);
    }
}
