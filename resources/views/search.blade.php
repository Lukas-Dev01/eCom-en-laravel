@extends('master')
@section('content')
@php
  $category = request('category');
  $query = trim((string) request('query'));

  if($category) {
    $pageTitle = \App\Http\Controllers\ProductController::categoryLabel($category);
  }
  elseif($query !== '') {
    $pageTitle = 'Search results for "'.$query.'"';
  }
  else {
    $pageTitle = 'Browse categories';
  }
@endphp
<div class="custom-product">
  <div class="trending-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="mb-0">{{ $pageTitle }}</h3>
      <a class="btn btn-outline-secondary" href="/">Back to shop</a>
    </div>

    @if(count($products) > 0)
    <div class="row g-4">
      @foreach($products as $item)
      @php
        $discountPercent = (int) ($item['deal_discount_percent'] ?? 0);
        $dealPrice = (float) ($item['unit_price'] ?? $item['price']);
      @endphp
      <div class="col-sm-6 col-lg-3">
        <div class="product-card">
          @if($discountPercent > 0)
          <span class="product-badge">{{$discountPercent}}% off</span>
          @endif
          <div class="product-card-actions">
            <form action="/add_to_wishlist" method="POST">
              @csrf
              <input type="hidden" name="product_id" value="{{$item['id']}}">
              <button class="wishlist-button {{ in_array($item['id'], $wishlistedProducts ?? []) ? 'is-liked' : '' }}" type="submit" aria-label="Add {{$item['name']}} to wishlist">
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                  <path d="M12 21a1 1 0 0 1-.63-.22C6.5 16.84 3 13.62 3 9.4A5.35 5.35 0 0 1 8.35 4 5.72 5.72 0 0 1 12 5.38 5.72 5.72 0 0 1 15.65 4 5.35 5.35 0 0 1 21 9.4c0 4.22-3.5 7.44-8.37 11.38A1 1 0 0 1 12 21Z"/>
                </svg>
              </button>
            </form>
          </div>
          <a href="/detail/{{$item['id']}}?back={{ urlencode(request()->fullUrl()) }}">
            <img class="trending-image" src="{{ \App\Models\Product::imageUrl($item['gallery']) }}" alt="{{$item['name']}}">
            <h4>{{$item['name']}}</h4>
            <p>{{$item['description']}}</p>
            <strong>
              @if($discountPercent > 0)
              <span class="price-old">${{number_format((float) $item['price'], 0)}}</span>
              <span class="price-deal">${{number_format($dealPrice, 0)}}</span>
              @else
              ${{$item['price']}}
              @endif
            </strong>
          </a>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div class="empty-state">
      <h4>No products found</h4>
      <p>Try searching for a product name or choosing a category from the menu.</p>
    </div>
    @endif
  </div>
</div>
@endsection
