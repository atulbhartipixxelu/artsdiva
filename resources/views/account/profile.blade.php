@extends('account.layout', ['heading' => 'Profile', 'title' => 'Edit profile — ArtsDiva'])

@section('account')
<section class="account-panel">
    @if($errors->any())
        <div class="account-flash account-flash--err">
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('account.profile.update') }}" class="account-form">
        @csrf
        @method('PUT')
        <div class="account-form__grid">
            <label class="auth-field">
                <span>Full name</span>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            </label>
            <label class="auth-field">
                <span>Email</span>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
            </label>
            <label class="auth-field">
                <span>Phone</span>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}">
            </label>
            <label class="auth-field">
                <span>City</span>
                <input type="text" name="city" value="{{ old('city', $user->city) }}">
            </label>
            <label class="auth-field">
                <span>Country</span>
                <input type="text" name="country" value="{{ old('country', $user->country) }}">
            </label>
            <label class="auth-field auth-field--full">
                <span>Address</span>
                <textarea name="address" rows="3">{{ old('address', $user->address) }}</textarea>
            </label>
        </div>

        <h3 class="account-form__subhead">Change password</h3>
        <p class="account-form__hint">Leave blank to keep your current password.</p>
        <div class="account-form__grid">
            <label class="auth-field">
                <span>New password</span>
                <input type="password" name="password">
            </label>
            <label class="auth-field">
                <span>Confirm new password</span>
                <input type="password" name="password_confirmation">
            </label>
        </div>

        <button type="submit" class="btn btn--dark">Save profile</button>
    </form>
</section>
@endsection
