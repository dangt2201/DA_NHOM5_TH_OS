@extends('admin.admin')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h3>Danh sách Sản phẩm</h3>
    <a href="{{ route('admin.products.create') }}" class="btn btn-success">Thêm mới</a>
</div>

<form action="" method="GET" class="form-inline mb-3">
    <input type="text" name="keyword" class="form-control mr-2" placeholder="Tìm tên..." value="{{ request('keyword') }}">
    <button class="btn btn-primary">Tìm</button>
</form>

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Ảnh</th>
            <th>Tên sản phẩm</th>
            <th>Giá bán</th>
            <th>Tổng Kho</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td><img src="{{ asset($product->img_thumbnail) }}" width="50"></td>
            <td>
                <b>{{ $product->name }}</b><br>
                <small>SKU: {{ $product->sku }} | {{ $product->category->name }}</small>
            </td>
            <td>{{ number_format($product->price) }} đ</td>
            <td>
                <span class="badge badge-info">{{ $product->variants->sum('quantity') }}</span>
            </td>
            <td>
                {{ $product->is_active ? 'Hiển thị' : 'Ẩn' }}
            </td>
            <td>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-info btn-sm">Sửa</a>
                
                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Xóa sẽ mất hết biến thể. Chắc chưa?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Xóa</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $products->links() }}

@endsection