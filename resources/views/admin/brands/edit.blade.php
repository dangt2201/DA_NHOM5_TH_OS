@extends('admin.admin')

@section('content')

<h1>Sửa Thương Hiệu: {{ $brand->name }}</h1>

<form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div>
        <label>Tên thương hiệu:</label><br>
        <input type="text" name="name" value="{{ old('name', $brand->name) }}" required>
        @error('name') <span style="color:red">{{ $message }}</span> @enderror
    </div>
    <br>

    <div>
        <label>Mô tả:</label><br>
        <textarea name="description" rows="5">{{ old('description', $brand->description) }}</textarea>
    </div>
    <br>

    <div>
        <label>Logo hiện tại:</label><br>
        @if($brand->logo)
            <img src="{{ asset($brand->logo) }}" width="100"><br>
        @else
            <p>Chưa có logo</p>
        @endif
        
        <label>Chọn logo mới (nếu muốn thay):</label><br>
        <input type="file" name="logo">
    </div>
    <br>

    <div>
        <label>Trạng thái:</label><br>
        <select name="is_active">
            <option value="1" {{ $brand->is_active == 1 ? 'selected' : '' }}>Hiển thị</option>
            <option value="0" {{ $brand->is_active == 0 ? 'selected' : '' }}>Ẩn</option>
        </select>
    </div>
    <br>

    <button type="submit">Cập nhật</button>
    <a href="{{ route('admin.brands.index') }}">Quay lại</a>
</form>

@endsection