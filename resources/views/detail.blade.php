@extends('master')
@section('content')
@php
    $isWishlisted = in_array((int) $product['id'], $wishlistedProducts ?? []);
    $isDeal = !empty($product['is_deal']);
    $discountPercent = (int) ($product['deal_discount_percent'] ?? 0);
    $unitPrice = (float) ($product['unit_price'] ?? $product['price']);
    $backUrl = '/';
    $requestedBackUrl = request('back');

    if($requestedBackUrl) {
        $backParts = parse_url($requestedBackUrl);
        $currentHost = request()->getHost();

        if(!isset($backParts['host']) || $backParts['host'] === $currentHost) {
            $backUrl = $requestedBackUrl;
        }
    }
@endphp
<main class="product-detail-page">
    <div class="product-detail-shell">
        <a class="product-back-link" href="{{ $backUrl }}">
            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path d="M15.7 5.3a1 1 0 0 1 0 1.4L11.42 11H20a1 1 0 1 1 0 2h-8.58l4.28 4.3a1 1 0 1 1-1.4 1.4l-6-6a1 1 0 0 1 0-1.4l6-6a1 1 0 0 1 1.4 0Z"/>
            </svg>
            Back to store
        </a>

        <section class="product-detail-card">
            <div class="product-detail-media">
                <div class="product-detail-image-frame">
                    <img class="detail-img" src="{{ \App\Models\Product::imageUrl($product['gallery']) }}" alt="{{$product['name']}}">
                </div>
            </div>

            <div class="product-detail-info">
                <h1>{{$product['name']}}</h1>
                <p class="product-detail-description">{{$product['description']}}</p>

                <div class="product-detail-price-row">
                    <div>
                        <span class="product-detail-price-label">Price</span>
                        <strong class="product-detail-price">
                            @if($isDeal)
                            <span class="price-old">${{number_format((float) $product['price'], 0)}}</span>
                            <span class="price-deal">${{number_format($unitPrice, 0)}}</span>
                            @else
                            ${{$product['price']}}
                            @endif
                        </strong>
                        @if($isDeal)
                        <span class="product-detail-deal-note">{{$discountPercent}}% deal applied</span>
                        @endif
                    </div>
                    <span class="product-detail-stock">In stock</span>
                </div>

                <div class="product-detail-actions">
                    <form action="/add_to_cart" method="POST" data-ajax-cart>
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product['id']}}">
                        <button class="btn product-detail-primary-action" type="submit">
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path d="M7 18a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm10 0a2 2 0 1 0 .01 0H17ZM3 3a1 1 0 0 0 0 2h1.1l2.2 9.35A3 3 0 0 0 9.22 16H17a3 3 0 0 0 2.83-2.02l1.08-3.13A3 3 0 0 0 18.08 7H7.05l-.65-2.76A1.6 1.6 0 0 0 4.84 3H3Zm4.52 6h10.56a1 1 0 0 1 .94 1.33l-1.08 3.13a1 1 0 0 1-.94.67H9.22a1 1 0 0 1-.97-.77L7.52 9Z"/>
                            </svg>
                            Add to cart
                        </button>
                    </form>

                    <form action="{{ $isWishlisted ? '/remove_from_wishlist' : '/add_to_wishlist' }}" method="POST" data-ajax-wishlist data-add-url="/add_to_wishlist" data-remove-url="/remove_from_wishlist">
                        @csrf
                        <input type="hidden" name="product_id" value="{{$product['id']}}">
                        <button class="btn product-detail-wishlist-action wishlist-button {{ $isWishlisted ? 'is-liked' : '' }}" type="submit" aria-label="{{ $isWishlisted ? 'Remove '.$product['name'].' from wishlist' : 'Add '.$product['name'].' to wishlist' }}">
                            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                <path d="M12 21a1 1 0 0 1-.63-.22C6.5 16.84 3 13.62 3 9.4A5.35 5.35 0 0 1 8.35 4 5.72 5.72 0 0 1 12 5.38 5.72 5.72 0 0 1 15.65 4 5.35 5.35 0 0 1 21 9.4c0 4.22-3.5 7.44-8.37 11.38A1 1 0 0 1 12 21Z"/>
                            </svg>
                            <span>{{ $isWishlisted ? 'Wishlisted' : 'Wishlist' }}</span>
                        </button>
                    </form>
                </div>

                <a class="product-detail-buy-link" href="/ordernow?product_id={{$product['id']}}">Buy now</a>

                <div class="product-detail-perks" aria-label="Shopping benefits">
                    <div>
                        <span class="product-detail-perk-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" focusable="false">
                                <path d="M3 6a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v2h1.34a2 2 0 0 1 1.66.9l1.66 2.5A2 2 0 0 1 21 12.5V17a2 2 0 0 1-2 2h-.18a3 3 0 0 1-5.64 0H9.82a3 3 0 0 1-5.64 0H4a1 1 0 1 1 0-2V6Zm2 0v9.17A3 3 0 0 1 9.82 17H14V6H5Zm11 4v5.17A3 3 0 0 1 18.82 17H19v-4.5l-1.66-2.5H16ZM7 18a1 1 0 1 0 0 2 1 1 0 0 0 0-2Zm9 1a1 1 0 1 0 2 0 1 1 0 0 0-2 0Z"/>
                            </svg>
                        </span>
                        <strong>Fast delivery</strong>
                        <small>Reliable shipping on every order.</small>
                    </div>
                    <div>
                        <span class="product-detail-perk-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" focusable="false">
                                <path d="M12 2a1 1 0 0 1 .45.11l7 3.5A1 1 0 0 1 20 6.5V12c0 4.48-2.91 8.13-7.58 9.91a1 1 0 0 1-.84 0C6.91 20.13 4 16.48 4 12V6.5a1 1 0 0 1 .55-.89l7-3.5A1 1 0 0 1 12 2Zm0 2.12L6 7.12V12c0 3.39 2.08 6.18 6 7.89 3.92-1.71 6-4.5 6-7.89V7.12l-6-3Zm3.7 5.18a1 1 0 0 1 0 1.4l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 1 1 1.4-1.4l1.3 1.29 3.3-3.29a1 1 0 0 1 1.4 0Z"/>
                            </svg>
                        </span>
                        <strong>Secure checkout</strong>
                        <small>Protected cart and account flow.</small>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection
