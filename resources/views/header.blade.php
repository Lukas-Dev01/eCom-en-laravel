<?php
use App\Http\Controllers\ProductController;

$total = 0;
if (Session::has('user')) {
  $total = ProductController::cartItem();
}

$query = request('query', '');
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shop-navbar">
  <div class="container">
    <a class="navbar-brand" href="/">
      <span class="brand-mark" aria-hidden="true">CF</span>
      <span>CommerceFlow</span>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#shopNavbar" aria-controls="shopNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="shopNavbar">
      <ul class="navbar-nav navbar-main me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Shop</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle {{ request()->is('search') ? 'active' : '' }}" href="#" id="categoryMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Categories
          </a>
          <ul class="dropdown-menu" aria-labelledby="categoryMenu">
            <li><a class="dropdown-item" href="/search?query=mobile">Mobiles</a></li>
            <li><a class="dropdown-item" href="/search?query=tv">TVs</a></li>
            <li><a class="dropdown-item" href="/search?query=fridge">Fridges</a></li>
          </ul>
        </li>

      </ul>

      <form class="shop-search" action="/search" method="GET">
        <input class="form-control" type="search" name="query" value="{{ $query }}" placeholder="Search products" aria-label="Search products">
        <button class="shop-search-button" type="submit" aria-label="Search">
          <svg class="shop-search-icon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <path d="M10.75 4a6.75 6.75 0 0 1 5.39 10.81l3.27 3.28a1 1 0 0 1-1.42 1.41l-3.27-3.27A6.75 6.75 0 1 1 10.75 4Zm0 2a4.75 4.75 0 1 0 0 9.5 4.75 4.75 0 0 0 0-9.5Z"/>
          </svg>
        </button>
      </form>

      <ul class="navbar-nav navbar-actions ms-lg-3 mb-2 mb-lg-0 align-items-lg-center">
        @if(Session::has('user'))
        <li class="nav-item">
          <a class="nav-link {{ request()->is('myorders') ? 'active' : '' }}" href="/myorders">Orders</a>
        </li>

        <li class="nav-item">
          <a class="nav-link cart-link {{ request()->is('cartlist') ? 'active' : '' }}" href="/cartlist" aria-label="Cart with {{ $total }} items">
            <span>Cart</span>
            <span class="cart-count">{{ $total }}</span>
          </a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle account-link" href="#" id="accountMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Account
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountMenu">
            <li><h6 class="dropdown-header">{{ Session::get('user')['name'] }}</h6></li>
            <li><a class="dropdown-item" href="/myorders">My Orders</a></li>
            <li><a class="dropdown-item" href="/cartlist">Cart</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/logout">Logout</a></li>
          </ul>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="/login">Login</a>
        </li>
        <li class="nav-item">
          <a class="btn btn-success navbar-action" href="/register">Register</a>
        </li>
        @endif
      </ul>
    </div>
  </div>
</nav>
