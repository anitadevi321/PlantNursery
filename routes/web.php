<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
Use App\Http\Controllers\CartController;
Use App\Http\Controllers\HomeController;
Use App\Http\Controllers\AboutController;
Use App\Http\Controllers\ShopController;
Use App\Http\Controllers\ShopdetailsController;
Use App\Http\Controllers\CheckoutController;
Use App\Http\Controllers\PortfolioController;
Use App\Http\Controllers\ContactUsController;
Use App\Http\Controllers\RegisteredUserController;
Use App\Http\Controllers\DashboardController;
use App\Http\Middleware\checkValid;
use App\Http\Controllers\Auth\CategoryController;
use App\Http\Controllers\Auth\ProductController;
use App\Http\Controllers\Auth\StripeController;

// Route::get('/', function () {
//     return view('welcome');
// });

/// web routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/shop/{id?}', [ShopController::class, 'index'])->name('shop');
Route::get('/getproduct', [ShopController::class, 'getproduct']);
Route::get('/fetchAllProducts', [ShopController::class, 'index'])->name('fetchAllProducts');
Route::get('/fetchProductWithCategory/{id}', [ShopController::class, 'fetchproduct_with_category']);
Route::get('/shop_sorting/{value}', [ShopController::class, 'fetchWithSorting'])->name('shop_sorting');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
// Route::post('/add_to_cart', [CartController::class, 'store'])->name('addcart');
Route::get('/contact', [ContactUsController::class, 'index'])->name('contact');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
//Route::get('/shopDetail', [ShopdetailsController::class, 'index'])->name('shop-details');
Route::get('/shopDetail/{id}', [ShopdetailsController::class, 'index'])->name('shop_details');
//Route::get('/profile', [PortfolioController::class, 'index'])->name('profile');
Route::get('/singleportfolio', [singleprotfolioController::class, 'index'])->name('portfolio');

Route::get('/admin-dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('admin-dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('add_categories', [CategoryController::class, 'index']);
require __DIR__.'/auth.php';


Route::get('/admin', function(){
    return view('admin.index');
});

Route::get('/addCategory', [CategoryController::class, 'index'])->name('addCategory');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

Route::get('/showCategories', [CategoryController::class, 'showCategories'])->name('showCategories');

Route::get('/editCategory/{id}', [CategoryController::class, 'showCategoryPage'])->name('showEditPage');
Route::put('editCategory',[CategoryController::class, 'editCategory'])->name('categories.update');
Route::get('/deleteCategory/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');


Route::get('/addproduct', [ProductController::class, 'index'])->name('addProduct');
Route::post('add_product',[ProductController::class, 'store'])->name('product.store');
Route::get('/showProducts', [ProductController::class, 'show_products'])->name('showProducts');
Route::get('/editProduct/{id}', [ProductController::class, 'showEditProductapage'])->name('showProductEdit');
Route::put('/editProduct', [ProductController::class, 'editProduct'])->name('EditProduct');

Route::get('/deleteProduct/{productId}', [ProductController::class, 'destroy'])->name('product.destroy');

Route::get('/payment', function(){
    return view('stripe.payment');
});

Route::get('stripe', [StripeController::class, 'index']);
Route::post('stripe/create-charge', [StripeController::class, 'createCharge'])->name('stripe.create-charge');
