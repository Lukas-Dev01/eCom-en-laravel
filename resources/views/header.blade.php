<?php
use App\Http\Controllers\ProductController;

$total = ProductController::cartItem();
$wishlistTotal = ProductController::wishlistItem();
$categoryOptions = ProductController::categoryOptions();

$query = request('query', '');
$currentUser = Session::get('user');
$userInitial = $currentUser ? strtoupper(substr($currentUser['name'], 0, 1)) : '';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shop-navbar">
  <div class="container-fluid px-lg-4">
    <a class="navbar-brand" href="/">
      <span class="brand-mark" aria-hidden="true">CF</span>
      <span>CartFuse</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#shopNavbar" aria-controls="shopNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="shopNavbar">
      <form class="shop-search" action="/search" method="GET" data-search-form>
        <input class="form-control" type="search" name="query" value="{{ $query }}" placeholder="Search products" aria-label="Search products" minlength="2" autocomplete="off" data-search-input>
        <button class="shop-search-button" type="submit" aria-label="Search" data-search-button {{ strlen(trim($query)) >= 2 ? '' : 'disabled' }}>
          <svg class="shop-search-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <path d="M10.75 4a6.75 6.75 0 0 1 5.39 10.81l3.27 3.28a1 1 0 0 1-1.42 1.41l-3.27-3.27A6.75 6.75 0 1 1 10.75 4Zm0 2a4.75 4.75 0 1 0 0 9.5 4.75 4.75 0 0 0 0-9.5Z"/>
          </svg>
        </button>
        <div class="search-suggestions" data-search-suggestions></div>
      </form>

      <ul class="navbar-nav navbar-main mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('deals') ? 'active' : '' }}" href="/deals">Deals</a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ request()->is('new-arrivals') ? 'active' : '' }}" href="/new-arrivals">New Arrivals</a>
        </li>
        <li class="nav-item dropdown" data-hover-dropdown>
          <a class="nav-link dropdown-toggle {{ request()->is('search') ? 'active' : '' }}" href="/search" id="categoryMenu" role="button" aria-expanded="false">
            Categories
          </a>
          <ul class="dropdown-menu" aria-labelledby="categoryMenu">
            @foreach($categoryOptions as $categoryValue => $categoryLabel)
            <li><a class="dropdown-item" href="/search?category={{ urlencode($categoryValue) }}">{{ $categoryLabel }}</a></li>
            @endforeach
          </ul>
        </li>

      </ul>

      <div class="navbar-right-group">
      <ul class="navbar-nav navbar-actions mb-2 mb-lg-0 align-items-lg-center">
        @if(Session::has('user'))
        <li class="nav-item">
          <a class="nav-link nav-link-with-icon {{ request()->is('myorders') ? 'active' : '' }}" href="/myorders">
            <svg class="nav-action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
              <path d="M7 3h10a2 2 0 0 1 2 2v15.2a.8.8 0 0 1-1.22.68L16 19.75l-1.78 1.13a.8.8 0 0 1-.86 0L12 20.02l-1.36.86a.8.8 0 0 1-.86 0L8 19.75l-1.78 1.13A.8.8 0 0 1 5 20.2V5a2 2 0 0 1 2-2Zm0 2v12.98l.57-.36a.8.8 0 0 1 .86 0l1.78 1.13 1.36-.86a.8.8 0 0 1 .86 0l1.36.86 1.78-1.13a.8.8 0 0 1 .86 0l.57.36V5H7Zm2 3h6a1 1 0 1 1 0 2H9a1 1 0 1 1 0-2Zm0 4h4a1 1 0 1 1 0 2H9a1 1 0 1 1 0-2Z"/>
            </svg>
            <span>Orders</span>
          </a>
        </li>
        @endif

        <li class="nav-item">
          <a class="nav-link nav-link-with-icon wishlist-link {{ request()->is('wishlist') ? 'active' : '' }}" href="/wishlist" aria-label="Open wishlist with {{ $wishlistTotal }} items">
            <svg class="nav-action-icon wishlist-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
              <path d="M12 21a1 1 0 0 1-.63-.22C6.5 16.84 3 13.62 3 9.4A5.35 5.35 0 0 1 8.35 4 5.72 5.72 0 0 1 12 5.38 5.72 5.72 0 0 1 15.65 4 5.35 5.35 0 0 1 21 9.4c0 4.22-3.5 7.44-8.37 11.38A1 1 0 0 1 12 21ZM8.35 6A3.35 3.35 0 0 0 5 9.4c0 3.1 2.71 5.82 7 9.31 4.29-3.49 7-6.21 7-9.31A3.35 3.35 0 0 0 15.65 6a3.81 3.81 0 0 0-2.86 1.5 1 1 0 0 1-1.58 0A3.81 3.81 0 0 0 8.35 6Z"/>
            </svg>
            <span>Wishlist</span>
            @if($wishlistTotal > 0)
            <span class="wishlist-count">{{ $wishlistTotal }}</span>
            @endif
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link cart-link {{ request()->is('cartlist') ? 'active' : '' }}" href="/cartlist" aria-label="Open cart with {{ $total }} items">
            <svg class="cart-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
              <path d="M7 18a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm10 0a2 2 0 1 0 .01 0H17ZM3 3a1 1 0 0 0 0 2h1.1l2.2 9.35A3 3 0 0 0 9.22 16H17a3 3 0 0 0 2.83-2.02l1.08-3.13A3 3 0 0 0 18.08 7H7.05l-.65-2.76A1.6 1.6 0 0 0 4.84 3H3Zm4.52 6h10.56a1 1 0 0 1 .94 1.33l-1.08 3.13a1 1 0 0 1-.94.67H9.22a1 1 0 0 1-.97-.77L7.52 9Z"/>
            </svg>
            <span class="visually-hidden">Cart</span>
            @if($total > 0)
            <span class="cart-count">{{ $total }}</span>
            @endif
          </a>
        </li>
      </ul>

      <ul class="navbar-nav navbar-auth ms-lg-auto mb-2 mb-lg-0 align-items-lg-center">
        @if(Session::has('user'))
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle account-link nav-link-with-icon" href="#" id="accountMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <svg class="nav-action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
              <path d="M12 12a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Zm0-7a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5Zm0 9c-4.42 0-8 2.2-8 4.9A2.1 2.1 0 0 0 6.1 21h11.8a2.1 2.1 0 0 0 2.1-2.1c0-2.7-3.58-4.9-8-4.9Zm-5.9 5c.1-1.24 2.56-3 5.9-3s5.8 1.76 5.9 3H6.1Z"/>
            </svg>
            <span>Account</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end account-menu" aria-labelledby="accountMenu">
            <li>
              <div class="account-menu-profile" aria-label="Signed in as {{ $currentUser['name'] }}">
                <span class="account-menu-avatar" aria-hidden="true">{{ $userInitial }}</span>
                <span class="account-menu-copy">
                  <strong>{{ $currentUser['name'] }}</strong>
                </span>
              </div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/profile">Profile</a></li>
            <li><a class="dropdown-item" href="/myorders">My Orders</a></li>
            <li><a class="dropdown-item" href="/wishlist">My Wishlist</a></li>
            <li><a class="dropdown-item" href="/addresses">Saved Addresses</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/logout">Logout</a></li>
          </ul>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link nav-link-with-icon {{ request()->is('login') ? 'active' : '' }}" href="/login">
            <svg class="nav-action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
              <path d="M10 4a1 1 0 0 1 1-1h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7a1 1 0 1 1 0-2h7V5h-7a1 1 0 0 1-1-1Zm2.3 4.3a1 1 0 0 1 1.4 0l3 3a1 1 0 0 1 0 1.4l-3 3a1 1 0 1 1-1.4-1.4l1.3-1.3H5a1 1 0 1 1 0-2h8.6l-1.3-1.3a1 1 0 0 1 0-1.4Z"/>
            </svg>
            <span>Login</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="btn btn-success navbar-action nav-link-with-icon" href="/register">
            <svg class="nav-action-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
              <path d="M12 12a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Zm0-7a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5Zm-6 15a1 1 0 0 1-1-1c0-2.76 3.13-5 7-5 1.06 0 2.08.17 2.99.48a1 1 0 1 1-.64 1.9A7.31 7.31 0 0 0 12 16c-2.58 0-4.52 1.22-4.91 2h6.16a1 1 0 1 1 0 2H6Zm12-4a1 1 0 0 1 1 1v1h1a1 1 0 1 1 0 2h-1v1a1 1 0 1 1-2 0v-1h-1a1 1 0 1 1 0-2h1v-1a1 1 0 0 1 1-1Z"/>
            </svg>
            <span>Register</span>
          </a>
        </li>
        @endif
      </ul>
      </div>
    </div>
  </div>
</nav>
