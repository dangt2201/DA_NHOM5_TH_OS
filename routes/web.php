<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Product\ProductController as UserProductController;
use App\Http\Controllers\User\BrandController as UserBrandController;
use App\Http\Controllers\User\HomeController;



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


