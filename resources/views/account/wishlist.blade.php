@extends('account.layout', ['heading' => 'Wishlist', 'title' => 'Wishlist — ArtsDiva'])

@section('account')
<section class="account-panel account-panel--clean">
    @if($items->isEmpty())
        <div class="account-empty">
            <p>Your wishlist is empty.</p>
            <a href="{{ route('catalogue.index') }}" class="auth-submit account-empty__btn">Save works from catalogue</a>
        </div>
    @else
        <div class="acct-folio">
            @foreach($items as $i => $row)
                @php $art = $row->artwork; @endphp
                @if($art)
                    <article class="acct-folio__card">
                        <a href="{{ route('catalogue.show', $art->slug) }}" class="acct-folio__media">
                            <img src="{{ $art->imageUrl() }}" alt="{{ $art->title }}" loading="lazy">
                            <span class="acct-folio__idx" aria-hidden="true">{{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}</span>
                        </a>
                        <div class="acct-folio__body">
                            <p class="acct-folio__artist">{{ $art->artist?->name }}</p>
                            <h2 class="acct-folio__title">
                                <a href="{{ route('catalogue.show', $art->slug) }}">{{ $art->title }}</a>
                            </h2>
                            <p class="acct-folio__price">{{ $currency->format((float) $art->price_eur) }}</p>
                            <div class="acct-folio__actions">
                                <form method="POST" action="{{ route('account.orders.store') }}">
                                    @csrf
                                    <input type="hidden" name="artwork_id" value="{{ $art->id }}">
                                    <input type="hidden" name="type" value="acquisition">
                                    <button type="submit" class="acct-btn acct-btn--solid">Request</button>
                                </form>
                                <form method="POST" action="{{ route('account.wishlist.destroy', $art) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="acct-btn">Remove</button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endif
            @endforeach
        </div>
    @endif
</section>
@endsection
