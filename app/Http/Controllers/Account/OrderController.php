<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'artwork_id' => ['required', 'integer', 'exists:artworks,id'],
            'type' => ['required', Rule::in([Order::TYPE_ACQUISITION, Order::TYPE_LEASE])],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $artwork = Artwork::with('artist')->published()->findOrFail($data['artwork_id']);

        $order = DB::transaction(function () use ($artwork, $data) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => Order::STATUS_PENDING,
                'type' => $data['type'],
                'total_eur' => (float) $artwork->price_eur,
                'notes' => $data['notes'] ?? null,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'artwork_id' => $artwork->id,
                'title' => $artwork->title,
                'artist_name' => $artwork->artist?->name,
                'slug' => $artwork->slug,
                'thumbnail' => $artwork->thumbnail,
                'price_eur' => (float) $artwork->price_eur,
            ]);

            return $order;
        });

        return redirect()
            ->route('account.purchases')
            ->with('success', 'Purchase request '.$order->order_number.' submitted. Our team will contact you shortly.');
    }
}
