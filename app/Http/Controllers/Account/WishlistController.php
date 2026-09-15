<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggle(Request $request, Artwork $artwork)
    {
        $userId = Auth::id();

        $existing = Wishlist::where('user_id', $userId)
            ->where('artwork_id', $artwork->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $active = false;
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'artwork_id' => $artwork->id,
            ]);
            $active = true;
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'active' => $active,
                'count' => Wishlist::where('user_id', $userId)->count(),
            ]);
        }

        return back()->with('success', $active ? 'Added to wishlist.' : 'Removed from wishlist.');
    }

    public function destroy(Artwork $artwork)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('artwork_id', $artwork->id)
            ->delete();

        return back()->with('success', 'Removed from wishlist.');
    }
}
