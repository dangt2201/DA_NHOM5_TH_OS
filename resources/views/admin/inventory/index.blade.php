@extends('admin.admin')

@section('content')

<h3>Quản lý Tồn Kho (Theo Biến thể)</h3>
<hr>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tên Sản phẩm</th>
            <th>Size</th>
            <th>Màu</th>
            <th>Tồn kho</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>
        @foreach($variants as $variant)
        <tr>
            <td>
                <b>{{ $variant->product->name ?? 'SP Đã xóa' }}</b>
                <br><small>SKU: {{ $variant->product->sku }}</small>
            </td>
            <td>{{ $variant->size }}</td>
            <td>{{ $variant->color }}</td>
            <td>
                <b style="font-size: 1.2em">{{ $variant->quantity }}</b>
            </td>
            <td>
                @if($variant->quantity == 0)
                    <span class="text-danger font-weight-bold">HẾT HÀNG</span>
                @elseif($variant->quantity < 10)
                    <span class="text-warning font-weight-bold">SẮP HẾT</span>
                @else
                    <span class="text-success">Còn hàng</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $variants->links() }}

@endsection