@extends('admin.admin')

@section('content')

<h1>Thêm Thương Hiệu</h1>

<form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div>
        <label>Tên thương hiệu:</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required>
        @error('name') <span style="color:red">{{ $message }}</span> @enderror
    </div>
    <br>

    <div>
        <label>Mô tả:</label><br>
        <textarea name="description" rows="5">{{ old('description') }}</textarea>
    </div>
    <br>

    <div>
        <label>Logo:</label><br>
        <input type="file" name="logo">
        @error('logo') <span style="color:red">{{ $message }}</span> @enderror
    </div>
    <br>

    <div>
        <label>Trạng thái:</label><br>
        <select name="is_active">
            <option value="1">Hiển thị</option>
            <option value="0">Ẩn</option>
        </select>
    </div>
    <br>

    <button type="submit">Lưu dữ liệu</button>
    <a href="{{ route('admin.brands.index') }}">Quay lại</a>
</form>

@endsection