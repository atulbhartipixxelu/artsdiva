@extends('layouts.app')

@section('title', 'Create account — ArtsDiva')
@section('body_class', 'auth-lock')
@section('hide_footer', '1')

@section('content')
<section class="auth-stage">
    <div class="auth-stage__visual" aria-hidden="true">
        <img src="{{ asset('images/catalogue/client-self-portrait-with-monkey.png') }}" alt="" loading="eager">
        <div class="auth-stage__veil"></div>
        <div class="auth-stage__caption">
            <p class="auth-stage__kicker">Join ArtsDiva</p>
            <p class="auth-stage__quote">Save works, request acquisitions, and manage your collector profile.</p>
        </div>
    </div>

    <div class="auth-stage__panel">
        <div class="auth-stage__panel-inner">
            <p class="auth-card__eyebrow">Collectors</p>
            <h1 class="auth-card__title">Create account</h1>
            <p class="auth-card__lede">One account for wishlist, purchases, and profile.</p>

            @if($errors->any())
                <div class="account-flash account-flash--err">
                    <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form method="POST" action="{{ route('account.register.store') }}" class="auth-form">
                @csrf
                <label class="auth-field">
                    <span>Full name</span>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Your name">
                </label>
                <label class="auth-field">
                    <span>Email</span>
                    <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="you@email.com">
                </label>
                <label class="auth-field">
                    <span>Phone <em>(optional)</em></span>
                    <input type="text" name="phone" value="{{ old('phone') }}" autocomplete="tel" placeholder="+91 …">
                </label>
                <div class="auth-form__pair">
                    <label class="auth-field">
                        <span>Password</span>
                        <input type="password" name="password" required autocomplete="new-password" placeholder="••••••••">
                    </label>
                    <label class="auth-field">
                        <span>Confirm</span>
                        <input type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                    </label>
                </div>
                <button type="submit" class="auth-submit">Create account</button>
            </form>

            <p class="auth-card__footer">
                Already have an account?
                <a href="{{ route('account.login') }}">Sign in</a>
            </p>
        </div>
    </div>
</section>
@endsection
