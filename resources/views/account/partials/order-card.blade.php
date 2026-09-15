<article class="acct-item">
    <div class="acct-item__bar">
        <div class="acct-item__ref">
            <span class="acct-item__code">{{ $order->order_number }}</span>
            <span class="acct-item__meta">
                {{ $order->created_at->format('d M Y') }}
                <i aria-hidden="true"></i>
                {{ ucfirst($order->type) }}
                @isset($showTotal)
                    <i aria-hidden="true"></i>
                    {{ $currency->format($order->total_eur) }}
                @endisset
            </span>
        </div>
        <span class="account-badge account-badge--{{ $order->status }}">{{ ucfirst($order->status) }}</span>
    </div>

    <div class="acct-item__works">
        @foreach($order->items as $item)
            <div class="acct-work">
                <a
                    href="{{ $item->slug ? route('catalogue.show', $item->slug) : '#' }}"
                    class="acct-work__media {{ $item->slug ? '' : 'is-static' }}"
                    @if(! $item->slug) tabindex="-1" aria-disabled="true" @endif
                >
                    <img src="{{ $item->imageUrl() }}" alt="{{ $item->title }}" loading="lazy">
                </a>
                <div class="acct-work__copy">
                    <p class="acct-work__title">
                        @if($item->slug)
                            <a href="{{ route('catalogue.show', $item->slug) }}">{{ $item->title }}</a>
                        @else
                            {{ $item->title }}
                        @endif
                    </p>
                    <p class="acct-work__by">{{ $item->artist_name ?: 'Artist' }}</p>
                    <p class="acct-work__price">{{ $currency->format($item->price_eur) }}</p>
                </div>
            </div>
        @endforeach
    </div>

    @if(! empty($order->notes))
        <p class="acct-item__note">{{ $order->notes }}</p>
    @endif
</article>
