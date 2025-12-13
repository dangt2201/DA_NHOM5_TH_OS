<?php

namespace App\Http\Controllers\User\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * 1. Trang danh sách tất cả sản phẩm
     */
   

    /**
     * 2. Lọc sản phẩm theo danh mục
     */
    public function getByCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)
                           ->where('is_active', true)
                           ->paginate(9);

        return view('user.products.index', [
            'products' => $products,
            'categoryName' => $category->name
        ]);
    }

    /**
     * 3. CHI TIẾT SẢN PHẨM
     */
     public function detail($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'brand', 'variants'])
            ->firstOrFail();

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('user.products.detail', compact('product', 'relatedProducts'));
    }

    /**
     * 4. Trang Hot Sale
     */
   

    /**
     * Helper: Lấy URL hình ảnh
     */
   
}