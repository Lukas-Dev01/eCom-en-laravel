@extends('master')
@section("content")
<div class="custom-product">
  <div class="cart-page">
    <div class="cart-header">
      <div>
        <span class="product-category">Shopping cart</span>
        <h3>Your cart</h3>
      </div>
      @if(count($products) > 0)
      <a class="btn btn-outline-secondary cart-continue-button" href="/">Continue shopping</a>
      @endif
    </div>

    @if(session('error'))
    <div class="page-alert page-alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    @if(session('success'))
    <div class="page-alert page-alert-success" role="status">{{ session('success') }}</div>
    @endif

    @if(count($products) > 0)
    <div class="cart-layout">
      <div class="cart-items">
        @foreach($products as $item)
        <div class="cart-item" data-cart-item>
          <a class="cart-item-image" href="/detail/{{$item->id}}?back={{ urlencode(request()->fullUrl()) }}">
            <img src="{{ \App\Models\Product::imageUrl($item->gallery) }}" alt="{{$item->name}}">
          </a>

          <div class="cart-item-info">
            <a href="/detail/{{$item->id}}?back={{ urlencode(request()->fullUrl()) }}">
              <h4>{{$item->name}}</h4>
            </a>
          </div>

          <div class="cart-unit-price">
            <span>Price per item</span>
            <strong title="${{number_format((float) ($item->unit_price ?? $item->price), 0)}} Price per item">
              @if(!empty($item->is_deal))
              <span class="price-old">${{number_format((float) $item->original_price, 0)}}</span>
              @endif
              <span class="{{ !empty($item->is_deal) ? 'price-deal' : '' }}">${{number_format((float) ($item->unit_price ?? $item->price), 0)}}</span>
            </strong>
            @if(!empty($item->is_deal))
            <small>{{$item->deal_discount_percent}}% deal applied</small>
            @endif
          </div>

          <div class="cart-quantity" aria-label="Quantity controls for {{$item->name}}">
            <span class="cart-quantity-title">
              Quantity
            </span>
            <div class="cart-quantity-controls">
              <form action="/decreasecart" method="POST" data-cart-control-form>
                @csrf
                <input type="hidden" name="product_id" value="{{$item->id}}">
                <button class="quantity-button" type="submit" aria-label="Decrease {{$item->name}} quantity">-</button>
              </form>
              <form class="quantity-value-form" action="/updatecart" method="POST" data-cart-quantity-form>
                @csrf
                <input type="hidden" name="product_id" value="{{$item->id}}">
                <input class="quantity-value" name="quantity" value="{{min($item->quantity, 3)}}" min="1" max="3" inputmode="numeric" aria-label="Set {{$item->name}} quantity" data-original-value="{{min($item->quantity, 3)}}">
              </form>
              <form action="/increasecart" method="POST" data-cart-control-form>
                @csrf
                <input type="hidden" name="product_id" value="{{$item->id}}">
                <button class="quantity-button" type="submit" aria-label="Increase {{$item->name}} quantity" @if($item->quantity >= 3) disabled @endif>+</button>
              </form>
            </div>
          </div>

          <div class="cart-subtotal">
            <span>Subtotal</span>
            <strong data-cart-row-subtotal>${{number_format($item->subtotal, 2)}}</strong>
          </div>

          <a class="cart-remove-button" href="/removecart/{{$item->cart_id}}" aria-label="Remove {{$item->name}} from cart">
            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
              <path d="M6.3 5.3a1 1 0 0 1 1.4 0L12 9.59l4.3-4.3a1 1 0 1 1 1.4 1.42L13.41 11l4.3 4.3a1 1 0 0 1-1.42 1.4L12 12.41l-4.3 4.3a1 1 0 0 1-1.4-1.42L10.59 11l-4.3-4.3a1 1 0 0 1 0-1.4Z"/>
            </svg>
          </a>
        </div>
        @endforeach
      </div>

      <aside class="cart-summary">
        <h4>Order summary</h4>
        <div class="cart-summary-row">
          <span>Items</span>
          <strong data-cart-summary-items>{{ $products->sum('quantity') }}</strong>
        </div>
        <div class="cart-summary-row">
          <span>Total</span>
          <strong data-cart-summary-total>${{number_format($cartTotal, 2)}}</strong>
        </div>
        <a class="btn btn-success cart-checkout-button" href="ordernow" data-order-confirm data-cart-total="${{number_format($cartTotal, 2)}}">Order Now</a>
      </aside>
    </div>

    <div class="modal fade" id="orderConfirmModal" tabindex="-1" aria-labelledby="orderConfirmModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content order-confirm-modal">
          <div class="modal-header">
            <h5 class="modal-title" id="orderConfirmModalLabel">Confirm order</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to place this order?</p>
            <div class="order-confirm-total">
              <span>Total</span>
              <strong data-order-confirm-total>${{number_format($cartTotal, 2)}}</strong>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">No</button>
            <a class="btn btn-success" href="ordernow" data-order-confirm-yes>Yes</a>
          </div>
        </div>
      </div>
    </div>
    @else
    <div class="empty-state">
      <span class="empty-state-icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" focusable="false">
          <path d="M7 18a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm10 0a2 2 0 1 0 .01 0H17ZM3 3a1 1 0 0 0 0 2h1.1l2.2 9.35A3 3 0 0 0 9.22 16H17a3 3 0 0 0 2.83-2.02l1.08-3.13A3 3 0 0 0 18.08 7H7.05l-.65-2.76A1.6 1.6 0 0 0 4.84 3H3Z"/>
        </svg>
      </span>
      <h4>Your cart is empty</h4>
      <p>Add a product to your cart and checkout will be ready when you come back.</p>
      <a class="btn btn-success" href="/">Start shopping</a>
    </div>
    @endif
  </div>
</div>
@endsection
