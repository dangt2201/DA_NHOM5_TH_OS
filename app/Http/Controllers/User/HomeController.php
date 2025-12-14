<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;

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

        return view('user.home', compact('hotProducts'));
    }
}