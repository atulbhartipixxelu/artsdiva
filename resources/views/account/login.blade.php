@extends('layouts.app')

@section('title', 'Sign in — ArtsDiva')
@section('body_class', 'auth-lock')
@section('hide_footer', '1')

@section('content')
<section class="auth-stage">
    <div class="auth-stage__visual" aria-hidden="true">
        <img src="{{ asset('images/catalogue/client-the-two-fridas.png') }}" alt="" loading="eager">
        <div class="auth-stage__veil"></div>
        <div class="auth-stage__caption">
            <p class="auth-stage__kicker">Private collection access</p>
            <p class="auth-stage__quote">Acquire and lease works curated for collectors and spaces.</p>
        </div>
    </div>

    <div class="auth-stage__panel">
        <div class="auth-stage__panel-inner">
            <p class="auth-card__eyebrow">Collectors</p>
            <h1 class="auth-card__title">Welcome back</h1>
            <p class="auth-card__lede">Sign in to view purchases, wishlist, and your profile.</p>

            @if($errors->any())
                <div class="account-flash account-flash--err">
                    <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form method="POST" action="{{ route('account.login.store') }}" class="auth-form">
                @csrf
                <label class="auth-field">
                    <span>Email</span>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="you@email.com">
                </label>
                <label class="auth-field">
                    <span>Password</span>
                    <input type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                </label>
                <div class="auth-form__row">
                    <label class="auth-check">
                        <input type="checkbox" name="remember" value="1">
                        <span>Remember me</span>
                    </label>
                </div>
                <button type="submit" class="auth-submit">Sign in</button>
            </form>

            <p class="auth-card__footer">
                New here?
                <a href="{{ route('account.register') }}">Create an account</a>
            </p>
        </div>
    </div>
</section>
@endsection
