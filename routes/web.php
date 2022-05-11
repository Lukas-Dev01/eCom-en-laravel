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

Route::get("detail/{id}", [ProductController::class,'detail']);

Route::post("add_to_cart",[ProductController::class,'addToCart']); // Add to Cart web route

Route::get("cartlist",[ProductController::class,'cartlist']); // Cart list

Route::get("removecart/{id}",[ProductController::class,'removeCart']); // Cart remove

Route::get("ordernow",[ProductController::class,'OrderNow']);

Route::post("orderplace",[ProductController::class,'orderPlace']);

Route::get("myorders",[ProductController::class,'myOrders']); // Orders list path

