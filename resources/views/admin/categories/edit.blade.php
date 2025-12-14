@extends('admin.admin')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cập nhật Danh mục</h1>
    </div>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT') <div class="row">
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Thông tin: {{ $category->name }}</h6>
                    </div>
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label for="name">Tên Danh mục <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $category->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="5">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Hành động</h6>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="is_active">Trạng thái</label>
                            <select name="is_active" id="is_active" class="form-control">
                                <option value="1" {{ old('is_active', $category->is_active) == 1 ? 'selected' : '' }}>Hiển thị</option>
                                <option value="0" {{ old('is_active', $category->is_active) == 0 ? 'selected' : '' }}>Ẩn</option>
                            </select>
                        </div>

                        <div class="mt-3 mb-3">
                            <small class="text-muted d-block">Ngày tạo: {{ $category->created_at->format('d/m/Y H:i') }}</small>
                            <small class="text-muted d-block">Cập nhật lần cuối: {{ $category->updated_at->format('d/m/Y H:i') }}</small>
                        </div>

                        <hr>

                        <div class="d-flex flex-column">
                            <button type="submit" class="btn btn-primary btn-block mb-2">
                                <i class="fas fa-save"></i> Lưu Thay Đổi
                            </button>
                            
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-arrow-left"></i> Hủy bỏ
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection