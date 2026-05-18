@extends('master')
@section('content')
<main class="returns-page">
  <section class="returns-shell">
    <div class="returns-hero">
      <span class="home-kicker">Returns</span>
      <h1>Need to send something back?</h1>
      <p>Email our support team and we will help you start the return without making it a big production.</p>
      <a class="btn btn-success" href="mailto:support@cartfuse.com?subject=Return%20request">Email support</a>
    </div>

    <section class="returns-faq" aria-label="Returns FAQ">
      <details class="returns-faq-item">
        <summary>How do I request a return?</summary>
        <p>Email <a href="mailto:support@cartfuse.com?subject=Return%20request">support@cartfuse.com</a> with your order number, the item name, and a short reason for the return.</p>
      </details>

      <details class="returns-faq-item">
        <summary>When should I email?</summary>
        <p>Please contact us within 14 days of receiving your order so we can review it and send the next steps.</p>
      </details>

      <details class="returns-faq-item">
        <summary>What should I include?</summary>
        <p>Add a photo if the item arrived damaged or different from expected. Keep the product and packaging until support replies.</p>
      </details>
    </section>
  </section>
</main>
@endsection
