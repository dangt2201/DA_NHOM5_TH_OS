<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng #{{ $order->id }}</title>
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 1000px; margin: 0 auto; }
        .header-box { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        .info-box { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px; }
        .box { border: 1px solid #ddd; padding: 15px; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        .total-row { font-weight: bold; background-color: #f9f9f9; text-align: right; }
        .status-form { background-color: #f0f8ff; padding: 15px; margin-top: 20px; border: 1px solid #b6d4fe; }
        button { cursor: pointer; padding: 8px 15px; background: #0d6efd; color: white; border: none; border-radius: 4px; }
    </style>
</head>
<body>

    <div class="header-box">
        <h1>Chi tiết đơn hàng: #{{ $order->id }}</h1>
        <a href="{{ route('orders.index') }}" style="text-decoration: none;">&larr; Quay lại danh sách</a>
    </div>

    @if(session('success'))
        <div style="color: green; margin: 10px 0; padding: 10px; border: 1px solid green;">
            {{ session('success') }}
        </div>
    @endif

    <div class="info-box">
        <div class="box">
            <h3>Thông tin khách hàng</h3>
            <p><strong>Họ tên:</strong> {{ $order->user->name ?? 'Không xác định' }}</p>
            <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
            <p><strong>Số điện thoại:</strong> {{ $order->phone ?? $order->user->phone ?? '...' }}</p>
            <p><strong>Địa chỉ giao:</strong> {{ $order->address ?? '...' }}</p>
        </div>
        <div class="box">
            <h3>Thông tin đơn hàng</h3>
            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
            <p><strong>Phương thức TT:</strong> {{ $order->payment_method ?? 'COD' }}</p>
            <p><strong>Trạng thái ĐH:</strong> <b>{{ $order->status_order }}</b></p>
            <p><strong>Thanh toán:</strong> <b>{{ $order->status_payment }}</b></p>
        </div>
    </div>

    <h3 style="margin-top: 30px;">Sản phẩm đã mua</h3>
    <table>
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Giá đơn vị</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>
                    {{ $item->product->name ?? 'Sản phẩm đã bị xóa' }}
                    @if(isset($item->variant)) <br><small>({{ $item->variant }})</small> @endif
                </td>
                <td>{{ number_format($item->price) }} đ</td>
                <td>x {{ $item->quantity }}</td>
                <td>{{ number_format($item->price * $item->quantity) }} đ</td>
            </tr>
            @endforeach
            
            <tr class="total-row">
                <td colspan="3">Tổng cộng:</td>
                <td style="color: red; font-size: 1.2em;">{{ number_format($order->total_price) }} đ</td>
            </tr>
        </tbody>
    </table>

    <div class="status-form">
        <h3>Cập nhật trạng thái đơn hàng</h3>
        <form action="{{ route('orders.update_status', $order->id) }}" method="POST">
            @csrf <div style="display: flex; gap: 20px; align-items: center;">
                <div>
                    <label>Trạng thái đơn hàng:</label><br>
                    <select name="status_order" style="padding: 5px;">
                        <option value="pending" {{ $order->status_order == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                        <option value="completed" {{ $order->status_order == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                        <option value="failed" {{ $order->status_order == 'failed' ? 'selected' : '' }}>Thất bại</option>
                        <option value="cancelled" {{ $order->status_order == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>

                <div>
                    <label>Trạng thái thanh toán:</label><br>
                    <select name="status_payment" style="padding: 5px;">
                        <option value="unpaid" {{ $order->status_payment == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                        <option value="paid" {{ $order->status_payment == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                    </select>
                </div>

                <div style="margin-top: 20px;">
                    <button type="submit">Cập nhật ngay</button>
                </div>
            </div>
        </form>
    </div>

</body>
</html>