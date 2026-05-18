@extends('master')
@section('content')
<main class="collection-page">
  <section class="collection-hero">
    <span class="home-kicker">{{ $pageKicker }}</span>
    <h1>{{ $pageTitle }}</h1>
    <p>{{ $pageSubtitle }}</p>
  </section>

  <section class="products-section collection-products">
    @if(count($products) > 0)
    <div class="product-grid store-product-grid">
      @foreach($products as $item)
      @php
        $isWishlisted = in_array($item['id'], $wishlistedProducts ?? []);
        $discountPercent = (int) ($item['deal_discount_percent'] ?? 0);
        $dealPrice = (float) ($item['unit_price'] ?? $item['price']);
      @endphp
      <article class="product-card store-product-card">
        @if(($pageMode ?? '') === 'deals' && $discountPercent > 0)
        <span class="product-badge">{{$discountPercent}}% off</span>
        @elseif(($pageMode ?? '') === 'new')
        <span class="product-badge product-badge-soft">New</span>
        @endif

        <div class="product-card-actions">
          <form action="{{ $isWishlisted ? '/remove_from_wishlist' : '/add_to_wishlist' }}" method="POST" data-ajax-wishlist data-add-url="/add_to_wishlist" data-remove-url="/remove_from_wishlist">
            @csrf
            <input type="hidden" name="product_id" value="{{$item['id']}}">
            <button class="wishlist-button {{ $isWishlisted ? 'is-liked' : '' }}" type="submit" aria-label="{{ $isWishlisted ? 'Remove '.$item['name'].' from wishlist' : 'Add '.$item['name'].' to wishlist' }}">
              <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path d="M12 21a1 1 0 0 1-.63-.22C6.5 16.84 3 13.62 3 9.4A5.35 5.35 0 0 1 8.35 4 5.72 5.72 0 0 1 12 5.38 5.72 5.72 0 0 1 15.65 4 5.35 5.35 0 0 1 21 9.4c0 4.22-3.5 7.44-8.37 11.38A1 1 0 0 1 12 21Z"/>
              </svg>
            </button>
          </form>
        </div>

        <a class="product-card-main" href="/detail/{{$item['id']}}?back={{ urlencode(request()->fullUrl()) }}">
          <div class="product-image-wrap">
            <img class="trending-image" src="{{ \App\Models\Product::imageUrl($item['gallery']) }}" alt="{{$item['name']}}">
          </div>
          <h3>{{$item['name']}}</h3>
          <p>{{$item['description']}}</p>
        </a>

        <div class="product-card-footer">
          <strong>
            @if(($pageMode ?? '') === 'deals')
            <span class="price-old">${{number_format((float) $item['price'], 0)}}</span>
            <span class="price-deal">${{number_format($dealPrice, 0)}}</span>
            @else
            ${{$item['price']}}
            @endif
          </strong>
          <form action="/add_to_cart" method="POST" data-ajax-cart>
            @csrf
            <input type="hidden" name="product_id" value="{{$item['id']}}">
            <button class="btn btn-success btn-sm" type="submit">Add to cart</button>
          </form>
        </div>
      </article>
      @endforeach
    </div>
    @else
    <div class="empty-state">
      <h4>No products found</h4>
      <p>There are no products to show here yet.</p>
    </div>
    @endif
  </section>
</main>
@endsection
