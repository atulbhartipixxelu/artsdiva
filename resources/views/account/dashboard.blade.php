@extends('account.layout', ['heading' => 'Overview', 'title' => 'Dashboard — ArtsDiva'])

@section('account')
<div class="account-welcome">
    <p class="account-welcome__hello">Hello, <em>{{ $user->name }}</em></p>
    <p class="account-welcome__sub">Your collector desk — purchases, saved works, and profile in one place.</p>
</div>

<div class="account-stats">
    <a href="{{ route('account.purchases') }}" class="account-stat">
        <span class="account-stat__label">Purchases</span>
        <span class="account-stat__num">{{ str_pad((string) $orderCount, 2, '0', STR_PAD_LEFT) }}</span>
        <span class="account-stat__cta">View history →</span>
    </a>
    <a href="{{ route('account.wishlist') }}" class="account-stat account-stat--mid">
        <span class="account-stat__label">Wishlist</span>
        <span class="account-stat__num">{{ str_pad((string) $wishlistCount, 2, '0', STR_PAD_LEFT) }}</span>
        <span class="account-stat__cta">Open list →</span>
    </a>
    <a href="{{ route('account.profile') }}" class="account-stat account-stat--soft">
        <span class="account-stat__label">Profile</span>
        <span class="account-stat__num account-stat__num--text">Edit</span>
        <span class="account-stat__cta">Update details →</span>
    </a>
</div>

<section class="account-panel account-panel--clean">
    <div class="account-panel__head">
        <div>
            <p class="account-panel__eyebrow">Activity</p>
            <h2>Recent purchases</h2>
        </div>
        <a class="account-panel__link" href="{{ route('account.purchases') }}">View all</a>
    </div>

    <div class="acct-stack">
        @forelse($orders as $order)
            @include('account.partials.order-card', ['order' => $order, 'currency' => $currency])
        @empty
            <div class="account-empty">
                <p>No purchases yet.</p>
                <a href="{{ route('catalogue.index') }}" class="auth-submit account-empty__btn">Browse catalogue</a>
            </div>
        @endforelse
    </div>
</section>
@endsection
