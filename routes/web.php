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
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ProductVariantController;
use App\Http\Controllers\User\Login\LoginController;



/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->name('auth.')->controller(LoginController::class)->group(function () {
    // Guest only
    Route::middleware('guest')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login')->name('login.post');
    });

    // Auth only
    Route::middleware('auth')->group(function () {
        Route::post('/logout', 'logout')->name('logout');
    });
});

// Alias routes for convenience
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');
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
| CART (đã thêm middleware để test)
|--------------------------------------------------------------------------
*/
Route::prefix('cart')->name('cart.')->middleware('auth')->controller(CartController::class)->group(function () {
   Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::post('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
     Route::post('/count', [CartController::class, 'count'])->name('count');  
});
/*
|--------------------------------------------------------------------------
| PAYMENT (đã thêm middleware để test)
|--------------------------------------------------------------------------
*/
Route::prefix('payment')->name('payment.')->middleware('auth')->controller(MoMoController::class)->group(function () {
    Route::get('/checkout', [MoMoController::class, 'showCheckout'])->name('checkout');
    Route::post('/process', [MoMoController::class, 'processPayment'])->name('process');
    Route::get('/success/{orderId}', [MoMoController::class, 'success'])->name('success');
    Route::get('/failed/{orderId}', [MoMoController::class, 'failed'])->name('failed');
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
   // ========== PRODUCTS ==========
        Route::resource('products', AdminProductController::class);
// ========== PRODUCT VARIANTS ==========
        Route::post('products/{product}/variants', [ProductVariantController::class, 'store'])
            ->name('product_variants.store');
        
        Route::delete('variants/{variant}', [ProductVariantController::class, 'destroy'])
            ->name('product_variants.destroy');



