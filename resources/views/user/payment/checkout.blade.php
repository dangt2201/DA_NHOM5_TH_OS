@extends('user.layouts.app')

@section('body')
<div style="padding: 20px;">
    <h1>🛒 Thanh toán đơn hàng</h1>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
        
        <!-- Form thông tin -->
        <div style="border: 1px solid #ccc; padding: 20px;">
            <h2>Thông tin người nhận</h2>

            <form action="{{ route('payment.process') }}" method="POST">
                @csrf

                <div style="margin-bottom: 15px;">
                    <label style="font-weight: bold;">Họ và tên <span style="color: red;">*</span></label><br>
                    <input type="text" name="user_name" value="{{ old('user_name', Auth::check() ? Auth::user()->name : '') }}" 
                           style="width: 100%; padding: 10px; border: 1px solid #ccc;" required>
                    @error('user_name')<span style="color: red;">{{ $message }}</span>@enderror
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="font-weight: bold;">Email <span style="color: red;">*</span></label><br>
                    <input type="email" name="user_email" value="{{ old('user_email', Auth::check() ? Auth::user()->email : '') }}" 
                           style="width: 100%; padding: 10px; border: 1px solid #ccc;" required>
                    @error('user_email')<span style="color: red;">{{ $message }}</span>@enderror
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="font-weight: bold;">Số điện thoại <span style="color: red;">*</span></label><br>
                    <input type="text" name="user_phone" value="{{ old('user_phone', Auth::check() ? Auth::user()->phone : '') }}" 
                           style="width: 100%; padding: 10px; border: 1px solid #ccc;" required>
                    @error('user_phone')<span style="color: red;">{{ $message }}</span>@enderror
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="font-weight: bold;">Địa chỉ giao hàng <span style="color: red;">*</span></label><br>
                    <textarea name="user_address" style="width: 100%; padding: 10px; border: 1px solid #ccc; height: 80px;" required></textarea>
                    @error('user_address')<span style="color: red;">{{ $message }}</span>@enderror
                </div>

                <div style="margin-bottom: 15px;">
                    <label style="font-weight: bold;">Ghi chú (tùy chọn)</label><br>
                    <textarea name="user_note" style="width: 100%; padding: 10px; border: 1px solid #ccc; height: 60px;"></textarea>
                </div>

                <hr>

                <h2>Phương thức thanh toán</h2>

                <div style="margin-bottom: 15px; padding: 10px; border: 1px solid #ccc;">
                    <label>
                        <input type="radio" name="payment_method" value="cod" checked> 💵 Thanh toán khi nhận hàng (COD)
                    </label>
                </div>

                <div style="margin-bottom: 15px; padding: 10px; border: 1px solid #ccc;">
                    <label>
                        <input type="radio" name="payment_method" value="momo"> 💳 Ví MoMo
                    </label>
                </div>

                <button type="submit" style="width: 100%; padding: 12px; background: #000; color: white; border: none; cursor: pointer; font-weight: bold; font-size: 16px;">
                    ✅ Xác nhận thanh toán
                </button>
            </form>
        </div>

        <!-- Tóm tắt đơn hàng -->
        <div style="border: 1px solid #ccc; padding: 20px;">
            <h2>Tóm tắt đơn hàng</h2>

            @if($cartItems && count($cartItems) > 0)
                <table border="1" style="width: 100%; margin-bottom: 20px; font-size: 14px;">
                    <tr>
                        <th>Sản phẩm</th>
                        <th>SL</th>
                        <th>Giá</th>
                    </tr>
                    @foreach($cartItems as $item)
                        @php
                            $product = $item->variant->product;
                            $price = $product->price_sale ?? $product->price;
                            $itemTotal = $price * $item->quantity;
                        @endphp
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($itemTotal) }}đ</td>
                        </tr>
                    @endforeach
                </table>

                <div style="border-top: 1px solid #ccc; padding-top: 10px;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($totalPrice) }}đ</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span>Phí vận chuyển:</span>
                        <span style="color: green;">Miễn phí</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: bold; border-top: 1px solid #ccc; padding-top: 10px;">
                        <span>Tổng cộng:</span>
                        <span style="color: red;">{{ number_format($totalPrice) }}đ</span>
                    </div>
                </div>
            @else
                <p>Giỏ hàng trống</p>
            @endif
        </div>
    </div>
</div>
@endsection