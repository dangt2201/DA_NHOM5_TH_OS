<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách đơn hàng</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .badge-success { color: green; font-weight: bold; }
        .badge-pending { color: orange; font-weight: bold; }
        .badge-cancelled { color: red; font-weight: bold; }
        .btn-detail { text-decoration: none; background: #007bff; color: white; padding: 5px 10px; border-radius: 4px; }
        .pagination { display: flex; list-style: none; gap: 10px; padding: 0; }
        .pagination li a, .pagination li span { border: 1px solid #ddd; padding: 5px 10px; text-decoration: none; }
    </style>
</head>
<body>

    <a href="/admin/dashboard" style="text-decoration: none;">&larr; Quay lại Dashboard</a>
    
    <h2>DANH SÁCH ĐƠN HÀNG</h2>

    <table>
        <thead>
            <tr>
                <th>Mã ĐH</th>
                <th>Khách hàng</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                
                <td>
                    <b>{{ $order->user->name ?? 'Khách Ẩn Danh' }}</b><br>
                    <small>{{ $order->user->email ?? '' }}</small>
                </td>

                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>

                <td style="color: #d63031; font-weight: bold;">
                    {{ number_format($order->total_price) }} đ
                </td>

                <td>
                    @if($order->status_order == 'completed')
                        <span class="badge-success">Hoàn thành</span>
                    @elseif($order->status_order == 'pending')
                        <span class="badge-pending">Chờ xử lý</span>
                    @elseif($order->status_order == 'cancelled')
                        <span class="badge-cancelled">Đã hủy</span>
                    @else
                        {{ $order->status_order }}
                    @endif
                </td>

                <td>
                    <a href="{{ route('orders.detail', $order->id) }}" class="btn-detail">Xem chi tiết</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Chưa có đơn hàng nào!</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $orders->links() }}
    </div>

</body>
</html>