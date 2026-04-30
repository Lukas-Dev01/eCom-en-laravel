<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Jquery link -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <title>CommerceFlow</title>

</head> 
<body>

{{View::make('header')}}
    @yield('content')
{{View::make('footer')}}
</body>

<style>
    a {
        text-decoration: none;
    }

    .shop-navbar {
        padding: 0.8rem 0;
        background: #1f2421 !important;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.12);
    }

    .shop-navbar .container {
        gap: 1rem;
    }

    .shop-navbar .navbar-brand {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        font-weight: 700;
        letter-spacing: 0;
        transition: color 0.2s ease, transform 0.2s ease;
    }

    .brand-mark {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        color: #ffffff;
        background: #198754;
        font-size: 0.82rem;
        font-weight: 800;
        box-shadow: 0 8px 18px rgba(25, 135, 84, 0.22);
    }

    .shop-navbar .navbar-brand:hover,
    .shop-navbar .navbar-brand:focus {
        color: #20c997;
        transform: translateY(-1px);
    }

    .navbar-main,
    .navbar-actions {
        gap: 0.25rem;
    }

    .shop-navbar .navbar-collapse {
        gap: 1rem;
    }

    .shop-navbar .nav-link {
        position: relative;
        border-radius: 6px;
        padding: 0.55rem 0.8rem;
        color: rgba(255, 255, 255, 0.78);
        font-size: 0.95rem;
        font-weight: 600;
        transition: color 0.2s ease, background-color 0.2s ease, transform 0.2s ease;
    }

    .shop-navbar .nav-link.active,
    .shop-navbar .nav-link:hover {
        background: rgba(255, 255, 255, 0.12);
    }

    .shop-navbar .nav-link:hover,
    .shop-navbar .nav-link:focus {
        color: #ffffff;
        transform: translateY(-1px);
    }

    .shop-navbar .nav-link::before {
        position: absolute;
        right: 0.75rem;
        bottom: 0.25rem;
        left: 0.75rem;
        height: 2px;
        border-radius: 999px;
        background: #20c997;
        content: "";
        opacity: 0;
        transform: scaleX(0.6);
        transition: opacity 0.2s ease, transform 0.2s ease;
    }

    .shop-navbar .nav-link:hover::before,
    .shop-navbar .nav-link:focus::before,
    .shop-navbar .nav-link.active::before {
        opacity: 1;
        transform: scaleX(1);
    }

    .shop-navbar .dropdown-toggle::after {
        margin-left: 0.35rem;
        border-top-color: currentColor;
        transition: transform 0.2s ease;
    }

    .shop-navbar .dropdown:hover .dropdown-toggle::after,
    .shop-navbar .dropdown-toggle:focus::after {
        transform: rotate(180deg);
    }

    .shop-navbar .dropdown-menu {
        min-width: 190px;
        padding: 0.45rem;
        border: 0;
        border-radius: 8px;
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.16);
    }

    .shop-navbar .dropdown-header {
        padding: 0.5rem 0.75rem;
        color: #6c757d;
        font-size: 0.78rem;
        font-weight: 700;
    }

    .shop-navbar .dropdown-item {
        border-radius: 6px;
        padding: 0.5rem 0.75rem;
        transition: color 0.2s ease, background-color 0.2s ease, padding-left 0.2s ease;
    }

    .shop-navbar .dropdown-item:hover,
    .shop-navbar .dropdown-item:focus {
        color: #146c43;
        background: rgba(25, 135, 84, 0.12);
        padding-left: 1.25rem;
    }

    .shop-search {
        position: relative;
        width: min(380px, 100%);
        min-width: min(360px, 100%);
    }

    .shop-search .form-control {
        height: 44px;
        padding: 0.55rem 3rem 0.55rem 1.1rem;
        border: 1px solid rgba(255, 255, 255, 0.32);
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.96);
        box-shadow: none;
    }

    .shop-search .form-control:focus {
        border-color: #198754;
        box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
    }

    .shop-search-button {
        position: absolute;
        top: 50%;
        right: 5px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        padding: 0;
        border: 0;
        border-radius: 50%;
        color: #ffffff;
        background: #198754;
        transform: translateY(-50%);
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .shop-search-button:hover,
    .shop-search-button:focus {
        background: #157347;
        transform: translateY(-50%) scale(1.04);
    }

    .shop-search-button:focus {
        outline: 2px solid rgba(255, 255, 255, 0.85);
        outline-offset: 2px;
    }

    .shop-search-icon {
        width: 18px;
        height: 18px;
        fill: currentColor;
    }

    .navbar-action {
        margin-left: 0.5rem;
        padding: 0.45rem 0.9rem;
        transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .navbar-action:hover,
    .navbar-action:focus {
        box-shadow: 0 8px 18px rgba(25, 135, 84, 0.28);
        transform: translateY(-1px);
    }

    .cart-link .badge {
        margin-left: 0.25rem;
    }

    .cart-link {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
    }

    .cart-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 24px;
        height: 24px;
        padding: 0 0.4rem;
        border-radius: 999px;
        color: #ffffff;
        background: #198754;
        font-size: 0.78rem;
        font-weight: 800;
    }

    .custom-login {
        height: 500px;
        padding-top: 100px;
    }
    
    img.slider-img {
        height: 100px !important
    }

    .custom-product {
        min-height: 600px;
    }

    .slider-text {
        background-color: #35443585 !important;
    }

    .trending-image {
        height: 100px; 
    }

    .product-card {
        display: block;
        height: 100%;
        padding: 1rem;
        color: #212529;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #ffffff;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
    }

    .product-card:hover {
        color: #212529;
        border-color: #198754;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }

    .product-card .trending-image {
        display: block;
        width: 100%;
        object-fit: contain;
        margin-bottom: 1rem;
    }

    .product-card h4 {
        font-size: 1.1rem;
        margin: 0.35rem 0;
    }

    .product-card p {
        color: #6c757d;
        min-height: 3rem;
    }

    .product-category {
        display: inline-block;
        color: #198754;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #f8f9fa;
    }

    .trending-item {
        float: left;
        width: 20%;
    }

    .trending-wrapper {
        margin: 30px;
    }

    .detail-img {
        height: 200px;
    }

    .cart-list-divider {
        border-bottom: 1px solid #cccccc;
        margin-bottom: 20px;
        padding-bottom: 20px;
    }

    /* Large desktops and laptops */
        @media (min-width: 1200px) {

    }

    /* Landscape tablets and medium desktops */
        @media (min-width: 992px) and (max-width: 1199px) {

    }

    /* Portrait tablets and small desktops */
        @media (min-width: 768px) and (max-width: 991px) {

    }

    /* Tablets and smaller */
        @media (max-width: 991px) {
        .shop-search {
            margin: 0.75rem 0;
            width: 100%;
            min-width: 100%;
        }

        .navbar-main,
        .navbar-actions {
            gap: 0.15rem;
        }

        .shop-navbar .nav-link {
            padding: 0.65rem 0.75rem;
        }

        .navbar-action {
            display: inline-block;
            margin: 0.5rem 0 0;
        }

    }   

    /* Portrait phones and smaller */
        @media (max-width: 480px) {

    }
</style>
</html>
