<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Product\ProductController as UserProductController;
use App\Http\Controllers\User\BrandController as UserBrandController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\Product\CartController;


// ============= HOME PAGE =============
Route::get('/', [HomeController::class, 'index'])->name('home');
/*
|--------------------------------------------------------------------------
| PRODUCTS (Public)
|--------------------------------------------------------------------------
*/
Route::get('/san-pham', [UserProductController::class, 'index'])->name('shop.index');
Route::get('/san-pham/{slug}.html', [UserProductController::class, 'detail'])->name('shop.detail');
Route::get('/danh-muc/{slug}', [UserProductController::class, 'getByCategory'])->name('shop.category');
/*
|--------------------------------------------------------------------------
| BRANDS (Public)
|--------------------------------------------------------------------------
*/
Route::get('/thuong-hieu', [UserBrandController::class, 'index'])->name('brands.index');
Route::get('/thuong-hieu/{slug}', [UserBrandController::class, 'show'])->name('brands.show');
/*
|--------------------------------------------------------------------------
| PRODUCTS (Public)
|--------------------------------------------------------------------------
*/
Route::get('/san-pham', [UserProductController::class, 'index'])->name('shop.index');
Route::get('/san-pham/{slug}.html', [UserProductController::class, 'detail'])->name('shop.detail');
Route::get('/danh-muc/{slug}', [UserProductController::class, 'getByCategory'])->name('shop.category');
Route::get('/hot-sale', [UserProductController::class, 'hotSale'])->name('shop.hotSale');
/*
|--------------------------------------------------------------------------
| CART (chưa xác thực người dùng)
|--------------------------------------------------------------------------
*/
Route::prefix('cart')->name('cart.')->group(function () {
    Route::post('/add', [CartController::class, 'add'])->name('add');
});