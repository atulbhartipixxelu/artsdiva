<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Wishlist;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class DashboardController extends Controller
{
    public function index(CurrencyService $currency)
    {
        $user = Auth::user();

        $orders = Order::with('items')
            ->where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        $wishlistCount = Wishlist::where('user_id', $user->id)->count();
        $orderCount = Order::where('user_id', $user->id)->count();

        return view('account.dashboard', [
            'user' => $user,
            'orders' => $orders,
            'wishlistCount' => $wishlistCount,
            'orderCount' => $orderCount,
            'currency' => $currency,
        ]);
    }

    public function purchases(CurrencyService $currency)
    {
        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('account.purchases', [
            'orders' => $orders,
            'currency' => $currency,
        ]);
    }

    public function wishlist(CurrencyService $currency)
    {
        $items = Wishlist::with(['artwork.artist'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('account.wishlist', [
            'items' => $items,
            'currency' => $currency,
        ]);
    }

    public function editProfile()
    {
        return view('account.profile', [
            'user' => Auth::user(),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:190', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:40'],
            'city' => ['nullable', 'string', 'max:120'],
            'country' => ['nullable', 'string', 'max:120'],
            'address' => ['nullable', 'string', 'max:1000'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'] ?? null;
        $user->city = $data['city'] ?? null;
        $user->country = $data['country'] ?? null;
        $user->address = $data['address'] ?? null;

        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}
