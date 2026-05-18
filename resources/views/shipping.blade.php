@extends('master')
@section('content')
<main class="shipping-page">
  <section class="shipping-shell">
    <header class="shipping-header">
      <div>
        <span class="home-kicker">Shipping info</span>
        <h1>Everything after checkout, in one place.</h1>
        <p>Track the order, check the address, and know what to do before delivery gets messy.</p>
      </div>
      <a class="btn btn-success" href="/myorders">Track orders</a>
    </header>

    <section class="shipping-status-grid" aria-label="Shipping status">
      <article class="shipping-status-card">
        <span>01</span>
        <h2>Confirmed</h2>
        <p>Your order is saved and ready for processing.</p>
      </article>

      <article class="shipping-status-card">
        <span>02</span>
        <h2>Packing</h2>
        <p>Check your saved address while edits are still easiest.</p>
      </article>

      <article class="shipping-status-card">
        <span>03</span>
        <h2>On the way</h2>
        <p>Watch "My orders" for delivery updates and arrival notes.</p>
      </article>
    </section>

    <section class="shipping-action-layout" aria-label="Shipping actions">
      <article class="shipping-primary-panel">
        <h2>Before it ships</h2>
        <p>Make sure your address, phone number, and apartment details are correct. Small fixes are much easier before the order leaves.</p>
        <a class="btn btn-outline-dark" href="/addresses">Manage addresses</a>
      </article>

      <div class="shipping-side-list">
        <article>
          <h3>Missing tracking?</h3>
          <p>Tracking details will appear in "My Orders" once your order has been packed.</p>
        </article>

        <article>
          <h3>Wrong address?</h3>
          <p>Email support with your order number and the correct delivery address.</p>
        </article>

        <article>
          <h3>Late delivery?</h3>
          <p>Give it one extra business day, then contact us so we can check it.</p>
        </article>
      </div>
    </section>

    <section class="shipping-contact-strip">
      <div>
        <h2>Need a real person?</h2>
        <p>Send the order number and what changed. We will help from there.</p>
      </div>
      <a class="btn btn-success" href="mailto:support@cartfuse.com?subject=Shipping%20help">Email support</a>
    </section>
  </section>
</main>
@endsection
