@php
    $active = (bool) ($active ?? false);
    $route = $route ?? '#';
    $onLabel = $onLabel ?? 'Active';
    $offLabel = $offLabel ?? 'Inactive';
@endphp
<form method="POST" action="{{ $route }}" class="status-toggle-form">
    @csrf
    @method('PATCH')
    <button
        type="submit"
        class="status-toggle {{ $active ? 'is-active' : 'is-inactive' }}"
        title="{{ $active ? 'Click to turn off' : 'Click to turn on' }}"
    >
        <span class="status-toggle__dot" aria-hidden="true"></span>
        <span class="status-toggle__label">{{ $active ? $onLabel : $offLabel }}</span>
    </button>
</form>
