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


// Route::get('/', function () {
//     return view('welcome');
// });

/// web routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::get('/contact', [ContactUsController::class, 'index'])->name('contact');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/shopDetail', [ShopdetailsController::class, 'index'])->name('shop-details');
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

Route::get('/showEditPage/{id}', [CategoryController::class, 'showCategoryPage'])->name('showEditPage');
Route::put('editCategory',[CategoryController::class, 'editCategory'])->name('categories.update');
Route::get('/deleteCategory/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

