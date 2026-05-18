@extends('master')
@section("content")
@php
  $subtotal = (float) ($subtotal ?? $total ?? 0);
  $tax = (float) ($tax ?? 0);
  $fee = (float) ($fee ?? $delivery ?? ($subtotal > 0 ? 10 : 0));
  $grandTotal = (float) ($grandTotal ?? ($subtotal + $tax + $fee));
  $countries = [
    'United States' => '+1',
    'Canada' => '+1',
    'United Kingdom' => '+44',
    'Ireland' => '+353',
    'Lithuania' => '+370',
    'Latvia' => '+371',
    'Estonia' => '+372',
    'Ukraine' => '+380',
    'Poland' => '+48',
    'Germany' => '+49',
    'France' => '+33',
    'Spain' => '+34',
    'Italy' => '+39',
    'Netherlands' => '+31',
    'Belgium' => '+32',
    'Sweden' => '+46',
    'Norway' => '+47',
    'Denmark' => '+45',
    'Finland' => '+358',
    'Portugal' => '+351',
    'Greece' => '+30',
    'Czech Republic' => '+420',
    'Slovakia' => '+421',
    'Hungary' => '+36',
    'Romania' => '+40',
    'Bulgaria' => '+359',
    'Austria' => '+43',
    'Switzerland' => '+41',
    'Australia' => '+61',
    'New Zealand' => '+64',
    'Japan' => '+81',
    'South Korea' => '+82',
    'China' => '+86',
    'India' => '+91',
    'Singapore' => '+65',
    'United Arab Emirates' => '+971',
    'Turkey' => '+90',
    'Brazil' => '+55',
    'Mexico' => '+52',
    'South Africa' => '+27',
  ];
  $selectedCountry = old('country', 'United States');
@endphp

<main class="checkout-page">
  <div class="checkout-shell">
    <div class="checkout-header">
      <a class="checkout-back-link" href="/cartlist">
        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
          <path d="M15.7 5.3a1 1 0 0 1 0 1.4L11.42 11H20a1 1 0 1 1 0 2h-8.58l4.28 4.3a1 1 0 1 1-1.4 1.4l-6-6a1 1 0 0 1 0-1.4l6-6a1 1 0 0 1 1.4 0Z"/>
        </svg>
        Back to cart
      </a>
      <div>
        <span class="checkout-kicker">Checkout</span>
        <h1>Place your order</h1>
        <p>Review your delivery and payment details before placing the order.</p>
      </div>
    </div>

    <div class="checkout-layout">
      <section class="checkout-panel">
        @if($errors->any())
        <div class="page-alert page-alert-danger" role="alert">{{ $errors->first() }}</div>
        @endif

        @if($subtotal <= 0)
        <div class="empty-state checkout-empty">
          <span class="empty-state-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" focusable="false">
              <path d="M7 18a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm10 0a2 2 0 1 0 .01 0H17ZM3 3a1 1 0 0 0 0 2h1.1l2.2 9.35A3 3 0 0 0 9.22 16H17a3 3 0 0 0 2.83-2.02l1.08-3.13A3 3 0 0 0 18.08 7H7.05l-.65-2.76A1.6 1.6 0 0 0 4.84 3H3Z"/>
            </svg>
          </span>
          <h4>Your cart is empty</h4>
          <p>Add something to your cart before placing an order.</p>
          <a class="btn btn-success" href="/">Start shopping</a>
        </div>
        @else
        <form action="/orderplace" method="POST" class="checkout-form" data-checkout-confirmation data-order-total="${{ number_format($grandTotal, 2) }}">
          @csrf
          <div class="checkout-address-section address-form">
            <div class="address-form-header">
              <h3>Delivery address</h3>
            </div>

            <div class="address-form-grid">
              <label>
                Address label
                <input class="form-control" name="label" value="{{ old('label', 'Home') }}" placeholder="Home, Work, Parents" required>
                @error('label')<small>{{ $message }}</small>@enderror
              </label>

              <label>
                Street address
                <input class="form-control" name="street" value="{{ old('street') }}" placeholder="123 Main Street" required>
                @error('street')<small>{{ $message }}</small>@enderror
              </label>

              <label>
                Apartment
                <input class="form-control" name="apartment" value="{{ old('apartment') }}" placeholder="Apt 4B">
                @error('apartment')<small>{{ $message }}</small>@enderror
              </label>

              <label>
                City
                <input class="form-control" name="city" value="{{ old('city') }}" placeholder="New York" required>
                @error('city')<small>{{ $message }}</small>@enderror
              </label>

              <label>
                Postal code
                <input class="form-control" name="postal_code" value="{{ old('postal_code') }}" placeholder="10001" required>
                @error('postal_code')<small>{{ $message }}</small>@enderror
              </label>

              <label>
                Country
                <select class="form-control" name="country" data-country-select required>
                  @foreach($countries as $country => $phoneCode)
                  <option value="{{ $country }}" data-phone-code="{{ $phoneCode }}" {{ $selectedCountry === $country ? 'selected' : '' }}>
                    {{ $country }} ({{ $phoneCode }})
                  </option>
                  @endforeach
                </select>
                @error('country')<small>{{ $message }}</small>@enderror
              </label>

              <label class="address-form-wide">
                Phone
                <input class="form-control" name="phone" value="{{ old('phone', $countries[$selectedCountry] ?? '+1') }}" placeholder="+1 555 123 4567" data-phone-input>
                @error('phone')<small>{{ $message }}</small>@enderror
              </label>
            </div>
          </div>

          <fieldset class="checkout-payment">
            <legend>Payment method</legend>
            <label class="payment-option">
              <input type="radio" value="online" name="payment" required>
              <span>
                <strong>Online payment</strong>
                <small>Secure payment by card or digital wallet.</small>
              </span>
            </label>
            <label class="payment-option">
              <input type="radio" value="emi" name="payment">
              <span>
                <strong>EMI payment</strong>
                <small>Split the amount into installments.</small>
              </span>
            </label>
            <label class="payment-option">
              <input type="radio" value="cash" name="payment" checked>
              <span>
                <strong>Payment on delivery</strong>
                <small>Pay when the order arrives.</small>
              </span>
            </label>
            @error('payment')<small class="field-error">{{ $message }}</small>@enderror
          </fieldset>

          <button type="submit" class="btn checkout-submit">
            Place order
          </button>
        </form>
        @endif
      </section>

      <aside class="checkout-summary" aria-label="Order summary">
        <h2>Order summary</h2>
        @if(!empty($checkoutItems) && count($checkoutItems) > 0)
        <div class="checkout-summary-items">
          @foreach($checkoutItems as $item)
          <div class="checkout-summary-item">
            <img src="{{ \App\Models\Product::imageUrl($item->gallery) }}" alt="{{ $item->name }}">
            <div>
              <strong>{{ $item->name }}</strong>
              <span>
                {{ $item->quantity }} x
                @if(!empty($item->is_deal))
                <span class="price-old">${{ number_format((float) $item->original_price, 0) }}</span>
                @endif
                <span class="{{ !empty($item->is_deal) ? 'price-deal' : '' }}">${{ number_format((float) ($item->unit_price ?? $item->price), 0) }}</span>
              </span>
            </div>
            <em>$ {{ number_format($item->subtotal, 0) }}</em>
          </div>
          @endforeach
        </div>
        @endif
        <div class="checkout-summary-row">
          <span>Amount</span>
          <strong>$ {{ number_format($subtotal, 0) }}</strong>
        </div>
        <div class="checkout-summary-row">
          <span>Tax</span>
          <strong>$ {{ number_format($tax, 0) }}</strong>
        </div>
        <div class="checkout-summary-row">
          <span>Fee</span>
          <strong>$ {{ number_format($fee, 0) }}</strong>
        </div>
        <div class="checkout-summary-row checkout-summary-total">
          <span>Total Amount</span>
          <strong>$ {{ number_format($grandTotal, 0) }}</strong>
        </div>
        <p class="checkout-summary-note">After confirmation, your order appears in My orders and your cart is cleared.</p>
      </aside>
    </div>
  </div>
</main>

<div class="modal fade" id="checkoutConfirmModal" tabindex="-1" aria-labelledby="checkoutConfirmModalLabel" aria-hidden="true" data-checkout-confirmation-modal>
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content order-confirm-modal">
      <div class="modal-header">
        <h5 class="modal-title" id="checkoutConfirmModalLabel">Confirm order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to place this order?</p>
        <div class="order-confirm-total">
          <span>Total</span>
          <strong data-checkout-confirmation-total>${{ number_format($grandTotal, 2) }}</strong>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-success" data-checkout-confirmation-yes>Yes</button>
      </div>
    </div>
  </div>
</div>
@endsection
