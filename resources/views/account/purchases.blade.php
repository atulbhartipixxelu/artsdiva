@extends('account.layout', ['heading' => 'Purchases', 'title' => 'Purchases — ArtsDiva'])

@section('account')
<section class="account-panel account-panel--clean">
    <div class="acct-stack">
        @forelse($orders as $order)
            @include('account.partials.order-card', ['order' => $order, 'currency' => $currency, 'showTotal' => true])
        @empty
            <div class="account-empty">
                <p>You have no purchase requests yet.</p>
                <a href="{{ route('catalogue.index') }}" class="auth-submit account-empty__btn">Browse catalogue</a>
            </div>
        @endforelse
    </div>

    @if($orders->hasPages())
        <div class="account-pager">{{ $orders->links() }}</div>
    @endif
</section>
@endsection
