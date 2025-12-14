@extends('admin.admin')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thêm Danh Mục Mới</h1>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        
        <div class="row">

            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Thông tin chung</h6>
                    </div>
                    <div class="card-body">
                        
                        <div class="form-group">
                            <label for="name">Tên Danh mục <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Nhập tên danh mục..." 
                                   required>
                            
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả chi tiết</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="5" 
                                      placeholder="Mô tả về danh mục này...">{{ old('description') }}</textarea>
                            
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
                            <label for="is_active">Trạng thái hiển thị</label>
                            <select name="is_active" id="is_active" class="form-control">
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Hiển thị (Public)</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Ẩn (Draft)</option>
                            </select>
                        </div>

                        <hr>

                        <div class="d-flex flex-column">
                            <button type="submit" class="btn btn-primary btn-block mb-2">
                                <i class="fas fa-save"></i> Lưu Danh Mục
                            </button>
                            
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>

</div>
@endsection