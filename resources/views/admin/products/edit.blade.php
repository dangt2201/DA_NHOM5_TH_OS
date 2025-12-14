@extends('admin.admin')

@section('content')

<h3>Cập nhật: {{ $product->name }}</h3>
<hr>

<div class="row">
    <div class="col-md-8">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Tên sản phẩm:</label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label>Danh mục:</label>
                    <select name="category_id" class="form-control">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Thương hiệu:</label>
                    <select name="brand_id" class="form-control">
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label>Giá bán:</label>
                    <input type="number" name="price" class="form-control" value="{{ $product->price }}">
                </div>
                <div class="col-md-6">
                    <label>Giá khuyến mãi:</label>
                    <input type="number" name="price_sale" class="form-control" value="{{ $product->price_sale }}">
                </div>
            </div>

            <div class="form-group mt-3">
                <label>Ảnh hiện tại:</label><br>
                <img src="{{ asset($product->img_thumbnail) }}" width="100" class="mb-2">
                <input type="file" name="img_thumbnail" class="form-control-file">
            </div>

            <div class="form-group">
                <label>Trạng thái:</label>
                <select name="is_active" class="form-control">
                    <option value="1" {{ $product->is_active ? 'selected' : '' }}>Hiển thị</option>
                    <option value="0" {{ !$product->is_active ? 'selected' : '' }}>Ẩn</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Cập nhật thông tin</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary mt-3">Hủy</a>
        </form>
    </div>

    <div class="col-md-4">
        <div class="card p-3 bg-light">
            <h5>Quản lý Biến thể</h5>
            
            <ul class="list-group mb-3">
                @foreach($product->variants as $variant)
                <li class="list-group-item d-flex justify-content-between align-items-center p-2">
                    <span>
                        <b>{{ $variant->size }}</b> - {{ $variant->color }} 
                        (SL: {{ $variant->quantity }})
                    </span>
                    <form action="{{ route('admin.product_variants.destroy', $variant->id) }}" method="POST" onsubmit="return confirm('Xóa?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </li>
                @endforeach
            </ul>

            <h6>+ Thêm mới:</h6>
            <form action="{{ route('admin.product_variants.store', $product->id) }}" method="POST">
                @csrf
                <input type="text" name="size" class="form-control mb-2 form-control-sm" placeholder="Size" required>
                <input type="text" name="color" class="form-control mb-2 form-control-sm" placeholder="Màu" required>
                <input type="number" name="quantity" class="form-control mb-2 form-control-sm" placeholder="Số lượng" required>
                <button class="btn btn-success btn-sm btn-block">Thêm ngay</button>
            </form>
        </div>
    </div>
</div>

@endsection