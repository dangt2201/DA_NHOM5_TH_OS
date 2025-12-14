@extends('user.layouts.app')

@section('body')
<div style="padding: 20px; text-align: center;">
    <div style="max-width: 800px; margin: 0 auto;">
        <h1 style="color: red; font-size: 36px;">❌ Thanh toán thất bại</h1>

        <p style="font-size: 18px; margin: 20px 0; color: #666;">Rất tiếc, giao dịch của bạn không thành công</p>

        <!-- Order Info -->
        <div style="background: #ffebee; padding: 20px; margin: 20px 0; border-radius: 8px; border-left: 5px solid red;">
            <h3>Thông tin đơn hàng</h3>
            <table style="width: 100%; margin: 10px 0;">
                <tr>
                    <td style="text-align: left;"><strong>Mã đơn hàng:</strong></td>
                    <td style="text-align: right;">#{{ $order->id }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;"><strong>Tổng tiền:</strong></td>
                    <td style="text-align: right; font-size: 18px; color: red; font-weight: bold;">{{ number_format($order->total_price) }}đ</td>
                </tr>
                <tr>
                    <td style="text-align: left;"><strong>Trạng thái thanh toán:</strong></td>
                    <td style="text-align: right;">
                        <span style="background: red; color: white; padding: 5px 15px; border-radius: 20px;">
                            Thất bại
                        </span>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;"><strong>Thời gian:</strong></td>
                    <td style="text-align: right;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            </table>
        </div>

        <!-- Possible Reasons -->
        <div style="background: #fff3cd; padding: 20px; margin: 20px 0; border-radius: 8px; border-left: 5px solid #ff9800;">
            <h3 style="color: #ff6f00;">⚠️ Có thể do:</h3>
            <ul style="text-align: left; display: inline-block;">
                <li>Số dư tài khoản không đủ</li>
                <li>Thông tin xác thực không chính xác</li>
                <li>Bạn đã hủy giao dịch</li>
                <li>Lỗi kết nối mạng</li>
                <li>Thời gian hết hạn</li>
            </ul>
        </div>

        <!-- Delivery Info -->
        <div style="background: #f5f5f5; padding: 20px; margin: 20px 0; border-radius: 8px;">
            <h3>Thông tin giao hàng</h3>
            <p><strong>{{ $order->user_name }}</strong></p>
            <p>📞 {{ $order->user_phone }}</p>
            <p>📧 {{ $order->user_email }}</p>
            <p>📍 {{ $order->user_address }}</p>
        </div>

        <!-- Order Items -->
        <h3>Sản phẩm đã đặt</h3>
        <table border="1" style="width: 100%; margin: 20px 0; font-size: 14px;">
            <tr style="background: #f5f5f5;">
                <th>Sản phẩm</th>
                <th>Size</th>
                <th>Màu</th>
                <th>SL</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->variant_size_name }}</td>
                    <td>{{ $item->variant_color_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->product_price) }}đ</td>
                    <td style="font-weight: bold;">{{ number_format($item->item_total) }}đ</td>
                </tr>
            @endforeach
        </table>

        <!-- Support -->
        <div style="background: #e3f2fd; padding: 20px; margin: 20px 0; border-radius: 8px;">
            <h3>Cần hỗ trợ?</h3>
            <p>📞 Hotline: <strong>1900.633.349</strong></p>
            <p>💬 Chat với chúng tôi để được hỗ trợ</p>
        </div>

        <!-- Buttons -->
        <div style="margin: 30px 0; display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('payment.checkout') }}" style="padding: 12px 20px; background: #f44336; color: white; text-decoration: none; border-radius: 5px;">
                🔄 Thử lại thanh toán
            </a>
            <a href="{{ route('user.orders') }}" style="padding: 12px 20px; background: #2196f3; color: white; text-decoration: none; border-radius: 5px;">
                📦 Xem đơn hàng
            </a>
            <a href="{{ route('shop.index') }}" style="padding: 12px 20px; background: #000; color: white; text-decoration: none; border-radius: 5px;">
                ← Trang chủ
            </a>
        </div>
    </div>
</div>
@endsection