@extends('admin.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Quản lý Tồn kho (Biến thể)</h3>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại DS Sản phẩm</a>
</div>

<div class="alert alert-info">
    <strong>Thống kê:</strong> 
    Tổng: {{ $variants->total() }} | 
    Còn hàng: {{ $variants->where('quantity', '>', 0)->count() }} | 
    Hết hàng: {{ $variants->where('quantity', 0)->count() }}
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Ảnh</th>
                    <th>Tên Sản Phẩm</th>
                    <th>Size</th>
                    <th>Màu</th>
                    <th>Số lượng</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($variants as $variant)
                <tr>
                    <td style="width: 60px; text-align: center;">
                        @if($variant->product->img_thumbnail ?? false)
                            <img src="{{ asset($variant->product->img_thumbnail) }}" width="50">
                        @else
                            <span>No img</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('admin.products.edit', $variant->product_id) }}">
                            <b>{{ $variant->product->name ?? 'SP Lỗi' }}</b>
                        </a>
                        <br>
                        <small>SKU: {{ $variant->product->sku ?? '---' }}</small>
                    </td>

                    <td>{{ $variant->size }}</td>

                    <td>{{ $variant->color }}</td>

                    <td>
                        <b>{{ $variant->quantity }}</b>
                    </td>

                    <td>
                        @if($variant->quantity == 0)
                            <span class="text-danger font-weight-bold">Hết hàng</span>
                        @elseif($variant->quantity < 10)
                            <span class="text-warning font-weight-bold">Sắp hết</span>
                        @else
                            <span class="text-success">Còn hàng</span>
                        @endif
                    </td>

                    <td>
                        <form action="{{ route('admin.product_variants.destroy', $variant->id) }}" method="POST" onsubmit="return confirm('Xóa biến thể này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Kho hàng chưa có dữ liệu nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $variants->links() }}
        </div>
    </div>
</div>

@endsection