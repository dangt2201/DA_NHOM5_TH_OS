@extends('user.layouts.app')

@section('body')
<div style="padding: 20px;">
    <h1>Trang chủ SOLID TECH</h1>
    
    <p>Chào mừng đến với cửa hàng giày online</p>

    <hr>

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
                        <a href="{{ route('shop.detail', $product->slug) }}">Xem chi tiết</a>
                    </td>
                </tr>
            @endforeach
        </table>

        {{-- <a href="{{ route('shop.hotSale') }}">Xem tất cả sale →</a> --}}
    @else
        <p>Hiện chưa có sản phẩm sale</p>
    @endif

    <hr>

    <h3>Danh mục sản phẩm</h3>
    <ul>
        <li><a href="{{ route('shop.category', 'giay-nam') }}">Giày Nam</a></li>
        <li><a href="{{ route('shop.category', 'giay-nu') }}">Giày Nữ</a></li>
        <li><a href="{{ route('shop.category', 'phu-kien') }}">Phụ kiện</a></li>
    </ul>

    <hr>

    <h3>Thương hiệu</h3>
    <p>
        <a href="{{ route('brands.index') }}">Xem tất cả thương hiệu →</a>
    </p>
</div>
@endsection