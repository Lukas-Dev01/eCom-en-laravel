@extends('master')
@section('content')
<div class="custom-product">
  <div class="trending-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="mb-0">Search results</h3>
      <a class="btn btn-outline-secondary" href="/">Back to shop</a>
    </div>

    @if(count($products) > 0)
    <div class="row g-4">
      @foreach($products as $item)
      <div class="col-sm-6 col-lg-3">
        <a class="product-card" href="/detail/{{$item['id']}}">
          <img class="trending-image" src="{{$item['gallery']}}" alt="{{$item['name']}}">
          <span class="product-category">{{$item['category']}}</span>
          <h4>{{$item['name']}}</h4>
          <p>{{$item['description']}}</p>
          <strong>${{$item['price']}}</strong>
        </a>
      </div>
      @endforeach
    </div>
    @else
    <div class="empty-state">
      <h4>No products found</h4>
      <p>Try searching for mobile, tv, or fridge.</p>
    </div>
    @endif
  </div>
</div>
@endsection
