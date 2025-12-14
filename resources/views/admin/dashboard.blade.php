<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">

    <h1>DASHBOARD QUẢN TRỊ</h1>
    <p>Chào mừng trở lại trang quản lý.</p>
    <hr>

    <table border="1" cellpadding="15" cellspacing="0" width="100%" style="text-align: center;">
        <tr style="background-color: #f0f0f0;">
            <td>
                <h3>Doanh Thu (Hoàn thành)</h3>
                <h2 style="color: red;">{{ number_format($totalRevenue) }} VNĐ</h2>
            </td>

            <td>
                <h3>Tổng Đơn Hàng</h3>
                <h2>{{ $totalOrders }}</h2>
            </td>

            <td>
                <h3>Tổng Sản Phẩm</h3>
                <h2>{{ $totalProducts }}</h2>
            </td>

            <td>
                <h3>Khách Hàng (User)</h3>
                <h2>{{ $totalUsers }}</h2>
            </td>
        </tr>
    </table>

    <br><br>

    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h2>Đơn Hàng Mới Nhất</h2>
        <a href="{{ route('admin.orders.index') }}" style="text-decoration: none; font-weight: bold;">Xem tất cả đơn hàng >></a>
    </div>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
            <tr style="background-color: #ddd;">
                <th>ID</th>
                <th>Khách Hàng</th>
                <th>Tổng Tiền</th>
                <th>Trạng Thái</th>
                <th>Thanh Toán</th>
                <th>Ngày Đặt</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentOrders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                
                <td>
                    <b>{{ $order->user->name ?? 'Khách vãng lai' }}</b><br>
                    <small>{{ $order->user->email ?? '' }}</small>
                </td>
                
                <td style="color: #d63031; font-weight: bold;">
                    {{ number_format($order->total_price) }} đ
                </td>
                
                <td>
                    @if($order->status_order == 'completed')
                        <span style="color: green;">Hoàn thành</span>
                    @elseif($order->status_order == 'pending')
                        <span style="color: orange;">Chờ xử lý</span>
                    @elseif($order->status_order == 'cancelled')
                        <span style="color: red;">Đã hủy</span>
                    @else
                        {{ $order->status_order }}
                    @endif
                </td>

                <td>
                    {{ $order->status_payment }}
                </td>
                
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                
                <td>
                    <a href="{{ route('admin.orders.detail', $order->id) }}">Chi tiết</a>
                </td>
            </tr>
            @endforeach

            @if($recentOrders->isEmpty())
            <tr>
                <td colspan="7" align="center">Chưa có đơn hàng nào!</td>
            </tr>
            @endif
        </tbody>
    </table>

</body>
</html>