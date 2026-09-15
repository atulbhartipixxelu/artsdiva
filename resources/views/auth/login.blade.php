<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.developer-signature')
    <title>Admin Login — ArtsDiva</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="login-wrap">
    <div class="login-stage">
        <div class="login-stage__visual" aria-hidden="true">
            <img src="{{ asset('images/catalogue/client-the-two-fridas.png') }}" alt="">
            <div class="login-stage__veil"></div>
            <div class="login-stage__caption">
                <p class="login-stage__kicker">ArtsDiva control</p>
                <p class="login-stage__quote">Curate exhibitions, catalogue, and content from one desk.</p>
            </div>
        </div>

        <div class="login-stage__panel">
            <div class="login-card">
                <p class="login-card__eyebrow">Staff access</p>
                <h1>ArtsDiva Admin</h1>
                <p class="login-card__lede">Sign in to manage dynamic website content.</p>

                @if($errors->any())
                    <div class="flash err">
                        <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" class="login-form">
                    @csrf
                    <label class="login-field" for="email">
                        <span>Email</span>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="admin@artsdiva.com">
                    </label>
                    <label class="login-field" for="password">
                        <span>Password</span>
                        <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••">
                    </label>
                    <label class="login-check">
                        <input type="checkbox" name="remember" value="1">
                        <span>Remember me</span>
                    </label>
                    <button class="login-submit" type="submit">Sign in</button>
                </form>
            </div>
        </div>
    </div>
@include('partials.developer-signature-foot')
</body>
</html>
