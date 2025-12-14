@extends('admin.admin')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800 fw-bold">Quản lý Danh mục</h1>
            <p class="text-muted mb-0">Quản lý các nhóm sản phẩm trên hệ thống</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-modern">
            <i class="fas fa-plus me-2"></i>Thêm danh mục
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="p-4 border-bottom bg-light">
                <form action="{{ route('admin.categories.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" name="keyword" class="form-control border-start-0 ps-0" 
                                       placeholder="Tìm kiếm danh mục..." value="{{ request('keyword') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">Lọc dữ liệu</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="py-3 px-4 text-muted fw-semibold" style="width: 50px;">ID</th>
                            <th class="py-3 text-muted fw-semibold">Tên danh mục</th>
                            <th class="py-3 text-muted fw-semibold">Slug</th>
                            <th class="py-3 text-muted fw-semibold text-center">Trạng thái</th>
                            <th class="py-3 text-muted fw-semibold text-center" style="width: 150px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                        <tr class="border-bottom">
                            <td class="px-4">
                                <span class="badge badge-light text-dark border">{{ $category->id }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="category-icon me-3 bg-primary text-white rounded p-2">
                                        <i class="fas fa-folder"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $category->name }}</div>
                                        <small class="text-muted">
                                            Tạo: {{ $category->created_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <code class="text-muted bg-light px-2 py-1 rounded">{{ $category->slug }}</code>
                            </td>
                            <td class="text-center">
                                @if($category->is_active)
                                    <span class="badge badge-success px-3 py-2">Hiển thị</span>
                                @else
                                    <span class="badge badge-secondary px-3 py-2">Đang ẩn</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.categories.edit', $category->id) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục: {{ $category->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger" 
                                                title="Xóa">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-folder-open fa-3x mb-3 opacity-50"></i>
                                    <p>Chưa có danh mục nào.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-top">
                <div class="d-flex justify-content-end">
                    {{ $categories->appends(request()->all())->links() }} 
                    </div>
            </div>
        </div>
    </div>
</div>

<style>
/* CSS bổ trợ để giao diện đẹp hơn */
.btn-modern {
    padding: 0.5rem 1.2rem;
    font-weight: 500;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.category-icon {
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
}
</style>
@endsection