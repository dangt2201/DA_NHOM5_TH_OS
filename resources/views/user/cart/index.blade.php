@extends('user.layouts.app')

@section('body')
<div style="padding: 20px;">
    <h1>🛒 Giỏ hàng của bạn</h1>

    @if($cartItems && count($cartItems) > 0)
        <table border="1" style="width: 100%; margin: 20px 0;">
            <tr>
                <th>ID</th>
                <th>Sản phẩm</th>
                <th>Size</th>
                <th>Màu</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th>Hành động</th>
            </tr>
            @foreach($cartItems as $item)
                @php
                    $product = $item->variant->product;
                    $price = $product->price_sale ?? $product->price;
                    $itemTotal = $price * $item->quantity;
                @endphp
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $item->variant->size }}</td>
                    <td>{{ $item->variant->color }}</td>
                    <td>{{ number_format($price) }}đ</td>
                    <td>
                        <form action="{{ route('cart.update', $item->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->variant->quantity }}" style="width: 50px; padding: 5px;">
                            <button type="submit" style="padding: 5px 10px; cursor: pointer;">Cập nhật</button>
                        </form>
                    </td>
                    <td style="font-weight: bold; color: red;">{{ number_format($itemTotal) }}đ</td>
                    <td>
                        <a href="#" onclick="return confirm('Bạn chắc chắn muốn xóa?')">Xóa</a>
                    </td>
                </tr>
            @endforeach
        </table>

        <!-- Tổng tiền -->
        <div style="text-align: right; margin: 20px 0; font-size: 18px;">
            <strong>Tổng cộng: </strong>
            <span style="color: red; font-weight: bold;">{{ number_format($totalPrice) }}đ</span>
        </div>

        <!-- Buttons -->
        <div style="margin: 20px 0;">
            <a href="{{ route('shop.index') }}" style="padding: 10px 20px; background: #ccc; text-decoration: none; color: black; border-radius: 5px;">← Tiếp tục mua</a>
            <a href="{{-- route('payment.checkout') --}}" style="padding: 10px 20px; background: #000; color: white; text-decoration: none; border-radius: 5px; margin-left: 10px;">Thanh toán →</a>
        </div>

    @else
        <p style="font-size: 18px; color: #999;">Giỏ hàng trống</p>
        <a href="{{ route('shop.index') }}">Tiếp tục mua sắm</a>
    @endif
</div>
@endsection