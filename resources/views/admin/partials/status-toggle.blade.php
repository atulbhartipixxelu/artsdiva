@php
    $active = (bool) ($active ?? false);
    $route = $route ?? '#';
@endphp
<form method="POST" action="{{ $route }}" class="status-toggle-form">
    @csrf
    @method('PATCH')
    <button
        type="submit"
        class="status-toggle {{ $active ? 'is-active' : 'is-inactive' }}"
        title="{{ $active ? 'Click to deactivate' : 'Click to activate' }}"
    >
        <span class="status-toggle__dot" aria-hidden="true"></span>
        <span class="status-toggle__label">{{ $active ? 'Active' : 'Inactive' }}</span>
    </button>
</form>
