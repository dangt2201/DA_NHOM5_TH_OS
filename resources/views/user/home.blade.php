@extends('user.layouts.app')

@section('body')
<div style="padding: 20px;">
    <h1>Trang chủ SOLID TECH</h1>
    
    <p>Chào mừng đến với cửa hàng giày online</p>

    <hr>

    <!-- Sản phẩm đang sale -->
    <h2>Sản phẩm đang sale</h2>

    @if($hotProducts->count() > 0)
        <table border="1" style="width: 100%; margin: 20px 0;">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Giá Sale</th>
                <th>Giảm %</th>
                <th>Hành động</th>
            </tr>
            @foreach($hotProducts as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->price) }}đ</td>
                    <td><strong style="color: red;">{{ number_format($product->price_sale) }}đ</strong></td>
                    <td>
                        @php
                            $percent = round((($product->price - $product->price_sale) / $product->price) * 100);
                        @endphp
                        -{{ $percent }}%
                    </td>
                    <td>
                        <a href="{{ route('shop.detail', $product->slug) }}">Chi tiết</a>
                    </td>
                </tr>
            @endforeach
        </table>

        <p><a href="{{ route('shop.hotSale') }}">→ Xem tất cả sale</a></p>
    @else
        <p>Hiện chưa có sản phẩm sale</p>
    @endif

    <hr>

    <!-- Danh mục sản phẩm -->
    <h2>Danh mục sản phẩm</h2>
    
    @if($categories->count() > 0)
        <table border="1" style="width: 100%; margin: 20px 0;">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Hành động</th>
            </tr>
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <a href="{{ route('shop.category', $category->slug) }}">Xem sản phẩm</a>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <p>Không có danh mục nào</p>
    @endif

    <hr>

    <!-- Thương hiệu -->
    <h2>Thương hiệu</h2>
    
    @if($brands->count() > 0)
        <table border="1" style="width: 100%; margin: 20px 0;">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Hành động</th>
            </tr>
            @foreach($brands as $brand)
                <tr>
                    <td>{{ $brand->id }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>
                        <a href="{{ route('brands.show', $brand->slug) }}">Xem sản phẩm</a>
                    </td>
                </tr>
            @endforeach
        </table>

        <p><a href="{{ route('brands.index') }}">→ Xem tất cả thương hiệu</a></p>
    @else
        <p>Không có thương hiệu nào</p>
    @endif

    <hr>

    <!-- Quick Links -->
    <h2>Quick Links</h2>
    <ul>
        <li><a href="{{ route('shop.index') }}">Tất cả sản phẩm</a></li>
        <li><a href="{{ route('shop.hotSale') }}">Sản phẩm sale</a></li>
        <li><a href="{{ route('brands.index') }}">Danh sách thương hiệu</a></li>
        <li><a href="{{-- route('login') --}}">Đăng nhập</a></li>
    </ul>
</div>
@endsection