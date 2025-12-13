<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Product\ProductController as UserProductController;

/*
|--------------------------------------------------------------------------
| PRODUCTS (Public)
|--------------------------------------------------------------------------
*/
Route::get('/san-pham', [UserProductController::class, 'index'])->name('shop.index');
Route::get('/san-pham/{slug}.html', [UserProductController::class, 'detail'])->name('shop.detail');
Route::get('/danh-muc/{slug}', [UserProductController::class, 'getByCategory'])->name('shop.category');
// Thêm dòng trên ↑
