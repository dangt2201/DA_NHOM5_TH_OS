<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator; 
use Illuminate\Support\Facades\Schema; // Thư viện sửa lỗi string length
use Illuminate\Support\Facades\View;   // Thư viện để chia sẻ biến cho View
use App\Models\Category;               // Import Model Category của bạn (Kiểm tra lại tên Model nếu khác)

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // THÊM: Cấu hình cho Laravel Pagination để sử dụng Bootstrap 5
        // Điều này khắc phục lỗi phân trang bị "un-styled" hoặc quá khổ.
        Paginator::useBootstrapFive();
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);
        // 2. KHẮC PHỤC LỖI HEADER: Chia sẻ danh sách danh mục cho tất cả các trang
        // Kiểm tra xem bảng categories có tồn tại chưa để tránh lỗi khi chạy migrate fresh
        if (Schema::hasTable('categories')) {
            $categories = Category::all(); // Lấy tất cả danh mục
            View::share('categories', $categories); // Biến này tên là $categories
        }
        // Force HTTPS khi sử dụng dev tunnel
        if (str_starts_with(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }
}
