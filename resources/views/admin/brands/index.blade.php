@extends('admin.admin')

@section('content')

<h1>Danh sách Thương Hiệu</h1>

<a href="{{ route('admin.brands.create') }}">[+ Thêm mới]</a>
<br><br>

<form action="{{ route('admin.brands.index') }}" method="GET">
    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm tên...">
    <button type="submit">Tìm kiếm</button>
</form>
<br>

@if(session('success'))
    <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>ID</th>
            <th>Logo</th>
            <th>Tên</th>
            <th>Slug</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @forelse($brands as $brand)
        <tr>
            <td>{{ $brand->id }}</td>
            <td>
                @if($brand->logo)
                    <img src="{{ asset($brand->logo) }}" width="50">
                @else
                    Không có ảnh
                @endif
            </td>
            <td>{{ $brand->name }}</td>
            <td>{{ $brand->slug }}</td>
            <td>
                {{ $brand->is_active ? 'Hiển thị' : 'Ẩn' }}
            </td>
            <td>
                <a href="{{ route('admin.brands.edit', $brand->id) }}">Sửa</a>
                |
                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Xóa nhé?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Xóa</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" align="center">Chưa có dữ liệu</td>
        </tr>
        @endforelse
    </tbody>
</table>

<br>
<div>
    {{ $brands->appends(request()->all())->links() }}
</div>

@endsection