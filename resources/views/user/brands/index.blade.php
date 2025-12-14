@extends('user.layouts.app')

@section('body')
<div style="padding: 20px;">
    <h1>Danh sách Thương hiệu</h1>
    
    <p>Tổng: {{ $brands->count() }} thương hiệu</p>

    @if($brands->count() > 0)
        <table border="1" style="width: 100%; margin: 20px 0;">
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Slug</th>
                <th>Hành động</th>
            </tr>
            @foreach($brands as $brand)
                <tr>
                    <td>{{ $brand->id }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->slug }}</td>
                    <td>
                        <a href="{{ route('brands.show', $brand->slug) }}">Xem sản phẩm</a>
                    </td>
                </tr>
            @endforeach
        </table>
    @else
        <p>Không có thương hiệu nào</p>
    @endif
</div>
@endsection