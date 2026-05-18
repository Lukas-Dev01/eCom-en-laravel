<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductControllers;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () { // Login Route
    return view('login');
});

Route::post("/login", [UserController::class,'login']);  // Login page #2

Route::get('/logout', function () { // Logout Route
    Session::forget('user');
        return redirect('login');
});

Route::get("/", [ProductController::class,'index']); // The main site?

Route::get("deals", [ProductController::class,'deals']);

Route::get("new-arrivals", [ProductController::class,'newArrivals']);

Route::get("detail/{id}", [ProductController::class,'detail']);

Route::get("search/suggestions", [ProductController::class,'searchSuggestions']);

Route::get("search", [ProductController::class,'search']);

Route::post("add_to_cart",[ProductController::class,'addToCart']); // Add to Cart web route

Route::post("add_to_wishlist",[ProductController::class,'addToWishlist']); // Add to Wishlist web route

Route::post("remove_from_wishlist",[ProductController::class,'removeFromWishlist']); // Remove from Wishlist web route

Route::get("wishlist",[ProductController::class,'wishlist']); // Wishlist list

Route::post("buy_wishlist",[ProductController::class,'buyWishlist']); // Buy from Wishlist

Route::get("removewishlist/{id}",[ProductController::class,'removeWishlist']); // Wishlist remove

Route::get("cartlist",[ProductController::class,'cartlist']); // Cart list

Route::get("removecart/{id}",[ProductController::class,'removeCart']); // Cart remove

Route::post("increasecart",[ProductController::class,'increaseCart']); // Cart quantity plus

Route::post("decreasecart",[ProductController::class,'decreaseCart']); // Cart quantity minus

Route::post("updatecart",[ProductController::class,'updateCart']); // Cart typed quantity

Route::get("ordernow",[ProductController::class,'OrderNow']);

Route::post("orderplace",[ProductController::class,'orderPlace']);

Route::get("myorders",[ProductController::class,'myOrders']); // Orders list path

Route::get("profile",[UserController::class,'profile']); // Account profile

Route::get("addresses",[UserController::class,'addresses']); // Saved addresses

Route::post("addresses",[UserController::class,'saveAddress']); // Save address

Route::post("addresses/update",[UserController::class,'updateAddress']); // Update address

Route::post("addresses/delete",[UserController::class,'deleteAddress']); // Delete address

Route::view('/returns','returns'); // Returns help page

Route::view('/shipping','shipping'); // Shipping help page

Route::post("cancelorder",[ProductController::class,'cancelOrder']); // Cancel pending order

Route::post("deleteorder",[ProductController::class,'deleteOrder']); // Delete cancelled order from history

Route::view('/register','Register'); // Register web path

Route::post("/register", [UserController::class,'register']);  // Login page #2

