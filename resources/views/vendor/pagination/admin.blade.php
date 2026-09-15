@if ($paginator->hasPages())
    <nav class="admin-pagination" role="navigation" aria-label="Pagination">
        <p class="admin-pagination__info">
            Showing
            <strong>{{ $paginator->firstItem() }}</strong>
            to
            <strong>{{ $paginator->lastItem() }}</strong>
            of
            <strong>{{ $paginator->total() }}</strong>
            results
        </p>

        <ul class="admin-pagination__list">
            @if ($paginator->onFirstPage())
                <li><span class="admin-pagination__btn is-disabled" aria-disabled="true">‹ Prev</span></li>
            @else
                <li><a class="admin-pagination__btn" href="{{ site_page_url($paginator->previousPageUrl()) }}" rel="prev">‹ Prev</a></li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li><span class="admin-pagination__btn is-disabled">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li><span class="admin-pagination__btn is-active" aria-current="page">{{ $page }}</span></li>
                        @else
                            <li><a class="admin-pagination__btn" href="{{ site_page_url($url) }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li><a class="admin-pagination__btn" href="{{ site_page_url($paginator->nextPageUrl()) }}" rel="next">Next ›</a></li>
            @else
                <li><span class="admin-pagination__btn is-disabled" aria-disabled="true">Next ›</span></li>
            @endif
        </ul>
    </nav>
@endif
