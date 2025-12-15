<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAdmin;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// ============= USER CONTROLLERS =============
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\BrandController as UserBrandController;
use App\Http\Controllers\User\Auth\ForgotPasswordController;
use App\Http\Controllers\User\Auth\GoogleController;
use App\Http\Controllers\User\Login\LoginController;
use App\Http\Controllers\User\Product\CartController;
use App\Http\Controllers\User\Product\ProductController as UserProductController;
use App\Http\Controllers\User\Payment\MoMoController;

// ============= ADMIN CONTROLLERS =============
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductVariantController;

/*
|--------------------------------------------------------------------------
| HOME PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginRegister'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Google OAuth
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])
    ->middleware('guest')
    ->name('google.login');

Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])
    ->middleware('throttle:10,1');

/*
|--------------------------------------------------------------------------
| USER PROFILE & ORDERS (Cần verify email)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('user')->name('user.')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/orders', [UserController::class, 'orders'])->name('orders');
    Route::get('/orders/{id}', [UserController::class, 'orderDetail'])->name('order.detail');
});

/*
|--------------------------------------------------------------------------
| CART (Cần verify email)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::post('/count', [CartController::class, 'count'])->name('count');
});

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
| PAYMENT - COD ONLY
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('payment')->name('payment.')->group(function () {
    Route::get('/checkout', [MoMoController::class, 'showCheckout'])->name('checkout');
    Route::post('/process', [MoMoController::class, 'processPayment'])->name('process');
    Route::get('/success/{orderId}', [MoMoController::class, 'success'])->name('success');
});
/*
|--------------------------------------------------------------------------
| OTHER PAGES
|--------------------------------------------------------------------------
*/
Route::view('/return-policy', 'user.return_policy')->name('return.policy');
Route::view('/about', 'user.about')->name('about');
Route::view('/contact', 'user.contact')->name('contact');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', CheckAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
        // ========== DASHBOARD ==========
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // ========== PRODUCTS ==========
        Route::resource('products', AdminProductController::class);
        
        // ========== CATEGORIES ==========
        Route::resource('categories', CategoryController::class);
        
        // ========== BRANDS ==========
        Route::resource('brands', AdminBrandController::class);
        
        // ========== PRODUCT VARIANTS ==========
        Route::post('products/{product}/variants', [ProductVariantController::class, 'store'])
            ->name('product_variants.store');
        
        Route::delete('variants/{variant}', [ProductVariantController::class, 'destroy'])
            ->name('product_variants.destroy');
        
        // ========== ORDERS ==========
        Route::prefix('orders')->name('orders.')->group(function () {
            Route::get('/', [DashboardController::class, 'orders'])->name('index');
            Route::get('/{orderId}', [DashboardController::class, 'orderDetail'])->name('detail');
            Route::post('/{orderId}/update-status', [DashboardController::class, 'updateOrderStatus'])
                ->name('update_status');
        });
    });

    /**
     * lỗi chưa hiện hết danh mục sản phẩm ở header
     */