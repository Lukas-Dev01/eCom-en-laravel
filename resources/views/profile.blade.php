@extends('master')
@section('content')
<main class="account-page">
  <section class="account-shell">
    <div class="account-hero">
      <span class="home-kicker">Account</span>
      <h1>Your CartFuse profile.</h1>
      <p>View your account details, saved addresses, orders, and other account options.</p>
    </div>

    <div class="account-grid">
      <article class="account-panel account-profile-card">
        <div class="account-avatar" aria-hidden="true">{{ strtoupper(substr($user['name'], 0, 1)) }}</div>
        <div>
          <span>Signed in as</span>
          <h2>{{ $user['name'] }}</h2>
          <p>{{ $user['email'] }}</p>
        </div>
      </article>

      <article class="account-panel">
        <h3>Account Details</h3>
        <div class="account-list">
          <div>
            <span>Customer ID</span>
            <strong>#{{ $user['id'] }}</strong>
          </div>
          <div>
            <span>Status</span>
            <strong>Active</strong>
          </div>
          <div>
            <span>Total orders</span>
            <strong>{{ $orderCount }}</strong>
          </div>
        </div>
      </article>

      <article class="account-panel">
        <h3>Quick Actions</h3>
        <div class="account-actions">
          <a class="btn btn-dark" href="/myorders">View orders</a>
          <a class="btn btn-outline-secondary" href="/addresses">Saved addresses</a>
          <a class="btn btn-outline-secondary" href="/wishlist">Wishlist</a>
        </div>
      </article>
    </div>
  </section>
</main>
@endsection
