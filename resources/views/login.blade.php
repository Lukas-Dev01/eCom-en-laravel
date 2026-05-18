@extends('master')
@section('content')

<main class="login-page">
  <section class="login-shell" aria-label="Account login">
    <div class="login-intro">
      <a class="login-brand" href="/">
        <span class="brand-mark">CF</span>
        <span>CartFuse</span>
      </a>

      <div class="login-copy">
        <span class="login-kicker">Welcome back</span>
        <h1>Sign in to manage your shopping.</h1>
        <p>Access your cart, wishlist, orders, and checkout details from one secure account.</p>
      </div>

      <div class="login-highlights" aria-label="Account benefits">
        <div class="login-highlight">
          <span class="login-highlight-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" focusable="false">
              <path d="M12 21a1 1 0 0 1-.63-.22C6.5 16.84 3 13.62 3 9.4A5.35 5.35 0 0 1 8.35 4 5.72 5.72 0 0 1 12 5.38 5.72 5.72 0 0 1 15.65 4 5.35 5.35 0 0 1 21 9.4c0 4.22-3.5 7.44-8.37 11.38A1 1 0 0 1 12 21Z"/>
            </svg>
          </span>
          <span>Keep wishlist items saved</span>
        </div>
        <div class="login-highlight">
          <span class="login-highlight-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" focusable="false">
              <path d="M7 18a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm10 0a2 2 0 1 0 .01 0H17ZM3 3a1 1 0 0 0 0 2h1.1l2.2 9.35A3 3 0 0 0 9.22 16H17a3 3 0 0 0 2.83-2.02l1.08-3.13A3 3 0 0 0 18.08 7H7.05l-.65-2.76A1.6 1.6 0 0 0 4.84 3H3Zm4.52 6h10.56a1 1 0 0 1 .94 1.33l-1.08 3.13a1 1 0 0 1-.94.67H9.22a1 1 0 0 1-.97-.77L7.52 9Z"/>
            </svg>
          </span>
          <span>Continue checkout faster</span>
        </div>
        <div class="login-highlight">
          <span class="login-highlight-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" focusable="false">
              <path d="M12 2 4 5.5V11c0 5 3.4 9.65 8 11 4.6-1.35 8-6 8-11V5.5L12 2Zm0 2.2 6 2.62V11c0 3.92-2.48 7.62-6 8.86C8.48 18.62 6 14.92 6 11V6.82l6-2.62Zm3.7 5.5-4.45 4.45-1.95-1.95-1.4 1.4 3.35 3.35 5.85-5.85-1.4-1.4Z"/>
            </svg>
          </span>
          <span>Track your orders safely</span>
        </div>
      </div>
    </div>

    <div class="login-panel">
      <div class="login-panel-header">
        <h2>Login</h2>
        <p>Enter your account details below.</p>
      </div>

      @if ($errors->any())
        <div class="login-alert" role="alert">
          {{ $errors->first() }}
        </div>
      @endif

      <form action="/login" method="POST" class="login-form">
        @csrf

        <div class="login-field">
          <label for="email">Email address</label>
          <div class="login-input-wrap">
            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
              <path d="M4 5h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Zm0 2v.35l8 5.34 8-5.34V7H4Zm0 2.76V17h16V9.76l-8 5.33-8-5.33Z"/>
            </svg>
            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required>
          </div>
        </div>

        <div class="login-field">
          <label for="password">Password</label>
          <div class="login-input-wrap">
            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
              <path d="M17 9h1a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-9a2 2 0 0 1 2-2h1V7a5 5 0 0 1 10 0v2Zm-8 0h6V7a3 3 0 0 0-6 0v2Zm-3 2v9h12v-9H6Zm7 3v3h-2v-3h2Z"/>
            </svg>
            <input type="password" name="password" class="form-control" id="password" placeholder="Your password" autocomplete="current-password" required>
            <button class="password-toggle" type="button" data-password-toggle="#password" aria-label="Show password" aria-pressed="false">
              <svg class="password-toggle-show" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path d="M12 5c5.2 0 8.54 4.58 9.72 6.55a.9.9 0 0 1 0 .9C20.54 14.42 17.2 19 12 19s-8.54-4.58-9.72-6.55a.9.9 0 0 1 0-.9C3.46 9.58 6.8 5 12 5Zm0 2c-3.76 0-6.42 3.05-7.67 5 1.25 1.95 3.91 5 7.67 5s6.42-3.05 7.67-5C18.42 10.05 15.76 7 12 7Zm0 2a3 3 0 1 1 0 6 3 3 0 0 1 0-6Z"/>
              </svg>
              <svg class="password-toggle-hide" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path d="M4.7 3.3a1 1 0 0 0-1.4 1.4l2 2C3.86 7.88 2.86 9.25 2.28 10.24a.9.9 0 0 0 0 .9C3.46 13.11 6.8 17.7 12 17.7c1.5 0 2.84-.39 4.01-.98l3.29 3.29a1 1 0 0 0 1.4-1.42l-16-15.3ZM12 6.3c5.2 0 8.54 4.58 9.72 6.55a.9.9 0 0 1 0 .9 14.38 14.38 0 0 1-2.28 2.85l-2.01-2.01A3 3 0 0 0 13.4 10.57L10.98 8.15c.33-.04.67-.06 1.02-.06Z"/>
              </svg>
            </button>
          </div>
        </div>

        <div class="login-options">
          <label class="login-check" for="remember">
            <input type="checkbox" id="remember" name="remember">
            <span>Remember me</span>
          </label>
        </div>

        <button type="submit" class="btn login-submit">Sign in</button>
      </form>

      <p class="login-register">
        New to CartFuse?
        <a href="/register">Create an account</a>
      </p>
    </div>
  </section>
</main>

@endsection
