@extends('user.layouts.app')

@section('body')
<div style="padding: 20px; text-align: center;">
    <h1 style="color: green;">✅ Đặt hàng thành công!</h1>

    <p style="font-size: 18px; margin: 20px 0;">Cảm ơn bạn đã đặt hàng</p>

    <div style="background: #f0f0f0; padding: 20px; margin: 20px 0; border-radius: 5px;">
        <p><strong>Mã đơn hàng:</strong> #{{ $order->id }}</p>
        <p><strong>Tổng tiền:</strong> {{ number_format($order->total_price) }}đ</p>
        <p><strong>Trạng thái:</strong> <span style="background: orange; color: white; padding: 5px 10px;">Chờ xử lý</span></p>
        <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
    </div>

    <div style="background: #e3f2fd; padding: 20px; margin: 20px 0; border-radius: 5px;">
        <p><strong>Thông tin giao hàng:</strong></p>
        <p>{{ $order->user_name }}</p>
        <p>{{ $order->user_phone }}</p>
        <p>{{ $order->user_address }}</p>
    </div>

    <h3>Sản phẩm đã đặt</h3>
    <table border="1" style="width: 100%; margin: 20px 0;">
        <tr>
            <th>Sản phẩm</th>
            <th>Size</th>
            <th>Màu</th>
            <th>Số lượng</th>
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
                <td>{{ number_format($item->item_total) }}đ</td>
            </tr>
        @endforeach
    </table>

    <p style="color: #666; margin: 30px 0;">
        Chúng tôi sẽ liên hệ với bạn để xác nhận đơn hàng trong vòng 24 giờ.
    </p>

    <div style="margin: 30px 0;">
        <a href="{{ route('shop.index') }}" style="padding: 10px 20px; background: #000; color: white; text-decoration: none; border-radius: 5px; display: inline-block;">
            ← Tiếp tục mua sắm
        </a>
    </div>
</div>
@endsection