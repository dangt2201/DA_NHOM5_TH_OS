<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Product\ProductController as UserProductController;
use App\Http\Controllers\User\BrandController as UserBrandController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\Product\CartController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\User\Payment\MoMoController;

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
Route::get('/hot-sale', [UserProductController::class, 'hotSale'])->name('shop.hotSale');
/*
|--------------------------------------------------------------------------
| BRANDS (Public)
|--------------------------------------------------------------------------
*/
Route::get('/thuong-hieu', [UserBrandController::class, 'index'])->name('brands.index');
Route::get('/thuong-hieu/{slug}', [UserBrandController::class, 'show'])->name('brands.show');
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
   Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::post('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
     Route::post('/count', [CartController::class, 'count'])->name('count');  
});
/*
|--------------------------------------------------------------------------
| PAYMENT (Tạm thời bỏ middleware để test)
|--------------------------------------------------------------------------
*/
Route::prefix('payment')->name('payment.')->group(function () {
    Route::get('/checkout', [MoMoController::class, 'showCheckout'])->name('checkout');
    Route::post('/process', [MoMoController::class, 'processPayment'])->name('process');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
// ========== ORDERS ==========
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [DashboardController::class, 'orders'])->name('index');
            Route::get('/{orderId}', [DashboardController::class, 'orderDetail'])->name('detail');
            Route::post('/{orderId}/update-status', [DashboardController::class, 'updateOrderStatus'])
                ->name('update_status');
        });
// ========== CATEGORIES ==========
        Route::resource('categories', CategoryController::class);
// ========== BRANDS ==========
        Route::resource('brands', AdminBrandController::class);



