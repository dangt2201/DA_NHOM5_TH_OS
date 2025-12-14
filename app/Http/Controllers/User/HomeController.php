<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ
     */
    public function index()
    {
        // Lấy sản phẩm có giá sale (hot sale)
        $hotProducts = Product::where('is_active', true)
                              ->whereNotNull('price_sale')
                              ->limit(8)
                              ->get();

        // Lấy tất cả categories active
        $categories = Category::where('is_active', true)->get();

        // Lấy tất cả brands active
        $brands = Brand::where('is_active', true)->get();

        return view('user.home', compact('hotProducts', 'categories', 'brands'));
    }
}