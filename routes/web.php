<?php

use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\CartController;
Use App\Http\Controllers\HomeController;
Use App\Http\Controllers\AboutController;
Use App\Http\Controllers\ShopController;
Use App\Http\Controllers\ShopdetailsController;
Use App\Http\Controllers\CheckoutController;
Use App\Http\Controllers\PortfolioController;
Use App\Http\Controllers\ContactUsController;

Route::get('/', function () {
    return view('frontend.index');
});

/// web routes
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/contact', [ContactUsController::class, 'index'])->name('contact');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/shopDetail', [ShopdetailsController::class, 'index'])->name('shop-details');
//Route::get('/profile', [PortfolioController::class, 'index'])->name('profile');
Route::get('/singleportfolio', [singleprotfolioController::class, 'index'])->name('portfolio');