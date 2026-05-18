@extends('master')
@section('content')

<main class="register-page">
  <section class="register-workspace" aria-label="Create account">
    <div class="register-topbar">
      <a class="register-brand" href="/">
        <span class="brand-mark">CF</span>
        <span>CartFuse</span>
      </a>
      <a class="register-signin" href="/login">Sign in</a>
    </div>

    <div class="register-layout">
      <section class="register-card" aria-labelledby="register-title">
        <div class="register-card-header">
          <span class="register-kicker">New account</span>
          <h1 id="register-title">Create your CartFuse profile.</h1>
          <p>Use one account to save products, keep your cart ready, and follow every order after checkout.</p>
        </div>

        @if ($errors->any())
          <div class="login-alert" role="alert">
            {{ $errors->first() }}
          </div>
        @endif

        <form action="/register" method="POST" class="register-form">
          @csrf

          <div class="register-field">
            <label for="name">Full name</label>
            <div class="register-input">
              <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path d="M12 12a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Zm0-7a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5Zm0 9c-4.42 0-8 2.2-8 4.9A2.1 2.1 0 0 0 6.1 21h11.8a2.1 2.1 0 0 0 2.1-2.1c0-2.7-3.58-4.9-8-4.9Zm-5.9 5c.1-1.24 2.56-3 5.9-3s5.8 1.76 5.9 3H6.1Z"/>
              </svg>
              <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}" placeholder="Your name" autocomplete="name" required>
            </div>
          </div>

          <div class="register-field">
            <label for="email">Email address</label>
            <div class="register-input">
              <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path d="M4 5h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Zm0 2v.35l8 5.34 8-5.34V7H4Zm0 2.76V17h16V9.76l-8 5.33-8-5.33Z"/>
              </svg>
              <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required>
            </div>
          </div>

          <div class="register-field">
            <label for="password">Password</label>
            <div class="register-input">
              <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path d="M17 9h1a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-9a2 2 0 0 1 2-2h1V7a5 5 0 0 1 10 0v2Zm-8 0h6V7a3 3 0 0 0-6 0v2Zm-3 2v9h12v-9H6Zm7 3v3h-2v-3h2Z"/>
              </svg>
              <input type="password" name="password" class="form-control" id="password" placeholder="Create a password" autocomplete="new-password" required>
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

          <div class="register-field">
            <label for="password_confirmation">Confirm password</label>
            <div class="register-input">
              <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path d="M17 9h1a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-9a2 2 0 0 1 2-2h1V7a5 5 0 0 1 10 0v2Zm-8 0h6V7a3 3 0 0 0-6 0v2Zm-3 2v9h12v-9H6Zm7 3v3h-2v-3h2Z"/>
              </svg>
              <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm your password" autocomplete="new-password" required>
              <button class="password-toggle" type="button" data-password-toggle="#password_confirmation" aria-label="Show confirm password" aria-pressed="false">
                <svg class="password-toggle-show" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                  <path d="M12 5c5.2 0 8.54 4.58 9.72 6.55a.9.9 0 0 1 0 .9C20.54 14.42 17.2 19 12 19s-8.54-4.58-9.72-6.55a.9.9 0 0 1 0-.9C3.46 9.58 6.8 5 12 5Zm0 2c-3.76 0-6.42 3.05-7.67 5 1.25 1.95 3.91 5 7.67 5s6.42-3.05 7.67-5C18.42 10.05 15.76 7 12 7Zm0 2a3 3 0 1 1 0 6 3 3 0 0 1 0-6Z"/>
                </svg>
                <svg class="password-toggle-hide" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                  <path d="M4.7 3.3a1 1 0 0 0-1.4 1.4l2 2C3.86 7.88 2.86 9.25 2.28 10.24a.9.9 0 0 0 0 .9C3.46 13.11 6.8 17.7 12 17.7c1.5 0 2.84-.39 4.01-.98l3.29 3.29a1 1 0 0 0 1.4-1.42l-16-15.3ZM12 6.3c5.2 0 8.54 4.58 9.72 6.55a.9.9 0 0 1 0 .9 14.38 14.38 0 0 1-2.28 2.85l-2.01-2.01A3 3 0 0 0 13.4 10.57L10.98 8.15c.33-.04.67-.06 1.02-.06Z"/>
                </svg>
              </button>
            </div>
          </div>

          <label class="register-check" for="updates">
            <input type="checkbox" id="updates" name="updates">
            <span>Send me product updates and saved-cart reminders.</span>
          </label>

          <button type="submit" class="btn register-submit">Create account</button>
        </form>
      </section>

      <aside class="register-preview" aria-label="CartFuse account preview">
        <div class="register-preview-copy">
          <span>What unlocks</span>
          <h2>A cleaner way to keep shopping organized.</h2>
        </div>

        <div class="register-feature-grid">
          <div class="register-feature">
            <span class="register-feature-icon">
              <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path d="M12 21a1 1 0 0 1-.63-.22C6.5 16.84 3 13.62 3 9.4A5.35 5.35 0 0 1 8.35 4 5.72 5.72 0 0 1 12 5.38 5.72 5.72 0 0 1 15.65 4 5.35 5.35 0 0 1 21 9.4c0 4.22-3.5 7.44-8.37 11.38A1 1 0 0 1 12 21Z"/>
              </svg>
            </span>
            <h3>Wishlist</h3>
            <p>Keep products ready for later.</p>
          </div>
          <div class="register-feature">
            <span class="register-feature-icon">
              <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path d="M7 18a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm10 0a2 2 0 1 0 .01 0H17ZM3 3a1 1 0 0 0 0 2h1.1l2.2 9.35A3 3 0 0 0 9.22 16H17a3 3 0 0 0 2.83-2.02l1.08-3.13A3 3 0 0 0 18.08 7H7.05l-.65-2.76A1.6 1.6 0 0 0 4.84 3H3Z"/>
              </svg>
            </span>
            <h3>Cart</h3>
            <p>Come back without rebuilding it.</p>
          </div>
          <div class="register-feature register-feature-wide">
            <span class="register-feature-icon">
              <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path d="M7 3h10a2 2 0 0 1 2 2v15.2a.8.8 0 0 1-1.22.68L16 19.75l-1.78 1.13a.8.8 0 0 1-.86 0L12 20.02l-1.36.86a.8.8 0 0 1-.86 0L8 19.75l-1.78 1.13A.8.8 0 0 1 5 20.2V5a2 2 0 0 1 2-2Zm2 5a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Zm0 4a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2H9Z"/>
              </svg>
            </span>
            <h3>Order history</h3>
            <p>Review purchases and checkout details from your account.</p>
          </div>
        </div>
      </aside>
    </div>
  </section>
</main>

@endsection
