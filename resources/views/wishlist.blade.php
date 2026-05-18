@extends('master')
@section("content")
<div class="custom-product">
  <div class="trending-wrapper">
    <div class="cart-header">
      <div>
        <span class="product-category">Wishlist</span>
        <h3>Saved products</h3>
      </div>
      @if(count($products) > 0)
      <a class="btn btn-outline-secondary cart-continue-button" href="/">Continue shopping</a>
      @endif
    </div>

    @if(count($products) > 0)
    <div class="row g-4" data-wishlist-grid>
      @foreach($products as $item)
      @php
        $discountPercent = (int) ($item->deal_discount_percent ?? 0);
        $dealPrice = (float) ($item->unit_price ?? $item->price);
      @endphp
      <div class="col-sm-6 col-lg-3" data-wishlist-item>
        <div class="product-card">
          @if($discountPercent > 0)
          <span class="product-badge">{{$discountPercent}}% off</span>
          @endif
          <div class="product-card-actions">
            <form action="/remove_from_wishlist" method="POST" data-ajax-wishlist data-remove-card data-add-url="/add_to_wishlist" data-remove-url="/remove_from_wishlist">
              @csrf
              <input type="hidden" name="product_id" value="{{$item->id}}">
              <button class="wishlist-button is-liked" type="submit" aria-label="Remove {{$item->name}} from wishlist">
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                  <path d="M12 21a1 1 0 0 1-.63-.22C6.5 16.84 3 13.62 3 9.4A5.35 5.35 0 0 1 8.35 4 5.72 5.72 0 0 1 12 5.38 5.72 5.72 0 0 1 15.65 4 5.35 5.35 0 0 1 21 9.4c0 4.22-3.5 7.44-8.37 11.38A1 1 0 0 1 12 21Z"/>
                </svg>
              </button>
            </form>
          </div>
          <a href="/detail/{{$item->id}}?back={{ urlencode(request()->fullUrl()) }}">
            <img class="trending-image" src="{{ \App\Models\Product::imageUrl($item->gallery) }}" alt="{{$item->name}}">
            <h4>{{$item->name}}</h4>
            <p>{{$item->description}}</p>
            <strong>
              @if($discountPercent > 0)
              <span class="price-old">${{number_format((float) $item->price, 0)}}</span>
              <span class="price-deal">${{number_format($dealPrice, 0)}}</span>
              @else
              ${{$item->price}}
              @endif
            </strong>
          </a>
          <div class="wishlist-card-actions">
            <form action="/buy_wishlist" method="POST" data-ajax-cart>
              @csrf
              <input type="hidden" name="product_id" value="{{$item->id}}">
              <button class="btn btn-success btn-sm" type="submit">Add to Cart</button>
            </form>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <div class="empty-state d-none" data-wishlist-empty>
      <span class="wishlist-empty-icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" focusable="false">
          <path d="M12 21a1 1 0 0 1-.63-.22C6.5 16.84 3 13.62 3 9.4A5.35 5.35 0 0 1 8.35 4 5.72 5.72 0 0 1 12 5.38 5.72 5.72 0 0 1 15.65 4 5.35 5.35 0 0 1 21 9.4c0 4.22-3.5 7.44-8.37 11.38A1 1 0 0 1 12 21Z"/>
        </svg>
      </span>
      <h4>Wishlist</h4>
      <p>Your wishlist is empty. Start adding items by clicking the heart icon on products you like.</p>
      <a class="btn btn-success" href="/">Browse products</a>
    </div>
    @else
    <div class="empty-state" data-wishlist-empty>
      <span class="wishlist-empty-icon" aria-hidden="true">
        <svg viewBox="0 0 24 24" focusable="false">
          <path d="M12 21a1 1 0 0 1-.63-.22C6.5 16.84 3 13.62 3 9.4A5.35 5.35 0 0 1 8.35 4 5.72 5.72 0 0 1 12 5.38 5.72 5.72 0 0 1 15.65 4 5.35 5.35 0 0 1 21 9.4c0 4.22-3.5 7.44-8.37 11.38A1 1 0 0 1 12 21Z"/>
        </svg>
      </span>
      <h4>Wishlist</h4>
      <p>Your wishlist is empty. Start adding items by clicking the heart icon on products you like.</p>
      <a class="btn btn-success" href="/">Browse products</a>
    </div>
    @endif
  </div>
</div>
@endsection
