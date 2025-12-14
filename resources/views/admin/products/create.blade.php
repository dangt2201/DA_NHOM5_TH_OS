@extends('admin.admin')

@section('content')

<h3>Thêm Sản Phẩm Mới</h3>
<hr>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label>Tên sản phẩm:</label>
                <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label>Danh mục:</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Chọn --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label>Thương hiệu:</label>
                    <select name="brand_id" class="form-control" required>
                        <option value="">-- Chọn --</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <label>Giá bán:</label>
                    <input type="number" name="price" class="form-control" required min="0">
                </div>
                <div class="col-md-6">
                    <label>Giá khuyến mãi (nếu có):</label>
                    <input type="number" name="price_sale" class="form-control" min="0">
                </div>
            </div>

            <div class="form-group mt-3">
                <label>Mô tả:</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <h5 class="mt-4">Nhập Biến thể (Size/Màu)</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Size</th>
                        <th>Màu</th>
                        <th>Số lượng</th>
                        <th><button type="button" class="btn btn-sm btn-success" onclick="addVariant()">+</button></th>
                    </tr>
                </thead>
                <tbody id="variant-body">
                    </tbody>
            </table>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>Ảnh đại diện:</label>
                <input type="file" name="img_thumbnail" class="form-control-file">
            </div>

            <div class="form-group mt-3">
                <label>Mã SKU:</label>
                <input type="text" name="sku" class="form-control" placeholder="Để trống tự sinh">
            </div>

            <div class="form-group mt-3">
                <label>Trạng thái:</label>
                <select name="is_active" class="form-control">
                    <option value="1">Hiển thị</option>
                    <option value="0">Ẩn</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-block mt-4">Lưu Sản Phẩm</button>
        </div>
    </div>
</form>

<script>
    let idx = 0;
    function addVariant() {
        let html = `
            <tr id="row-${idx}">
                <td><input type="text" name="variants[${idx}][size]" class="form-control form-control-sm" placeholder="Size" required></td>
                <td><input type="text" name="variants[${idx}][color]" class="form-control form-control-sm" placeholder="Màu" required></td>
                <td><input type="number" name="variants[${idx}][quantity]" class="form-control form-control-sm" value="0" min="0" required></td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="document.getElementById('row-${idx}').remove()">X</button></td>
            </tr>
        `;
        document.getElementById('variant-body').insertAdjacentHTML('beforeend', html);
        idx++;
    }
    // Tự thêm 1 dòng khi mở trang
    window.onload = function() { addVariant(); };
</script>
@endsection