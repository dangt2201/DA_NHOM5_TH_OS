@extends('user.layouts.app')

@section('title', 'SOLID TECH - Trang chủ')

@section('body')
<!-- Hero Banner -->
<section class="hero-banner position-relative mb-5">
    <div class="position-relative overflow-hidden">
        <img src="https://images.unsplash.com/photo-1556906781-9a412961c28c?w=1920&h=600&fit=crop" 
             class="w-100" 
             style="height: 500px; object-fit: cover; filter: brightness(0.7);" 
             alt="Banner">
        
        <div class="position-absolute top-50 start-50 translate-middle text-center text-white w-100 px-3">
            <h1 class="display-3 fw-bold text-uppercase mb-3 animate__animated animate__fadeInDown">
                SOLID <span class="text-danger">X</span> TECH
            </h1>
            <p class="fs-4 mb-4 animate__animated animate__fadeInUp">
                Bộ sưu tập giày chính hãng mới nhất 2025
            </p>
            <a href="{{ route('shop.index') }}" 
               class="btn btn-white btn-lg px-5 animate__animated animate__fadeInUp animate__delay-1s">
                Khám phá ngay
                DANG THANH  
            </a>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="featured-products py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-uppercase mb-2">Sản phẩm nổi bật</h2>
            <div class="bg-danger mx-auto" style="width: 80px; height: 4px;"></div>
            <p class="text-muted mt-3">Những đôi giày được yêu thích nhất</p>
        </div>
        
        <div class="row g-4">
            @foreach($hotProducts->take(8) as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    @include('user.partials.product_card', ['product' => $product])
                </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('shop.hotSale') }}" class="btn btn-outline-dark btn-lg px-5 rounded-pill">
                Xem tất cả <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
<!-- Categories -->
<section class="categories py-5 bg-white"> <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-uppercase text-dark mb-2" style="letter-spacing: 1px;">Danh mục nổi bật</h2>
            <div class="bg-primary mx-auto sep-line" style="opacity: 0.8;"></div> </div>
        
        <div class="row g-4">
            @forelse($categories as $category)
                <div class="col-md-4 col-sm-6">
                    <div class="cat-card h-100 position-relative overflow-hidden">
                        <img src="{{ $category->image_url ?? 'https://source.unsplash.com/random/600x500/?shoe,fashion&sig=' . $loop->index }}" 
                             class="cat-img w-100" 
                             alt="{{ $category->name }}"
                             onerror="this.onerror=null;this.src='https://via.placeholder.com/600x500/e0e0e0/999?text=No+Image';">
                        
                        <div class="cat-overlay position-absolute bottom-0 start-0 w-100 text-center d-flex flex-column justify-content-end">
                            <div class="cat-content p-4">
                                <h3 class="text-white fw-bold mb-2 text-uppercase cat-title">
                                    {{ $category->name }}
                                </h3>
                                
                                @if(isset($category->products_count) || $category->products->isNotEmpty())
                                    <div class="mb-3">
                                        <span class="cat-count text-white">
                                            {{ $category->products_count ?? $category->products->count() }} sản phẩm
                                        </span>
                                    </div>
                                @endif
                                
                                <a href="{{ route('shop.category', $category->slug) }}" class="btn btn-custom-outline rounded-pill px-4 py-2 btn-sm">
                                    <span>Khám phá</span> <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" width="100" alt="Empty" class="mb-3 opacity-50">
                    <p class="text-muted fs-5">Chưa có danh mục nào được tạo.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Features -->
<section class="features py-5">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-md-3 col-6">
                <div class="p-4">
                    <i class="bi bi-truck fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Giao hàng nhanh</h5>
                    <p class="text-muted small">Miễn phí ship toàn quốc</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-4">
                    <i class="bi bi-shield-check fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Chính hãng 100%</h5>
                    <p class="text-muted small">Cam kết hàng chính hãng</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-4">
                    <i class="bi bi-arrow-repeat fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Đổi trả dễ dàng</h5>
                    <p class="text-muted small">Đổi trả trong 7 ngày</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="p-4">
                    <i class="bi bi-headset fs-1 text-danger mb-3"></i>
                    <h5 class="fw-bold">Hỗ trợ 24/7</h5>
                    <p class="text-muted small">Tư vấn nhiệt tình</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<style>
  /* Đường gạch dưới tiêu đề */
.sep-line {
    width: 60px; 
    height: 3px;
    border-radius: 10px;
}

/* Card chính */
.cat-card {
    /* Đổi nền đen thành màu sáng để khi ảnh lỗi trông đỡ ghê */
    background-color: #f8f9fa; 
    border-radius: 16px; /* Bo tròn nhiều hơn */
    box-shadow: 0 4px 15px rgba(0,0,0,0.05); /* Shadow nhẹ nhàng, hiện đại */
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Hiệu ứng nảy nhẹ */
}

.cat-card:hover {
    box-shadow: 0 15px 30px rgba(37, 99, 235, 0.15); /* Shadow màu xanh nhẹ khi hover */
    transform: translateY(-8px);
}

/* Ảnh category */
.cat-img {
    height: 420px; /* Tăng chiều cao xíu */
    object-fit: cover;
    transition: all 0.5s ease;
    /* BỎ opacity: 0.9 để ảnh sáng nhất có thể */
}

.cat-card:hover .cat-img {
    transform: scale(1.08);
    /* Khi hover mới làm tối ảnh đi một chút để nổi chữ */
    filter: brightness(0.85);
}

/* Lớp phủ (Overlay) - CHÌA KHÓA GIẢI QUYẾT VẤN ĐỀ */
.cat-overlay {
    height: 100%;
    /* Gradient từ trong suốt xuống Xanh Đen đậm (thay vì đen tuyền) */
    /* Giúp màu sắc sang trọng và có chiều sâu hơn */
    background: linear-gradient(
        to top,
        rgba(15, 23, 42, 0.9) 0%,   /* Màu đáy đậm đà */
        rgba(15, 23, 42, 0.5) 40%, /* Nhạt dần ở giữa */
        transparent 100%
    );
    opacity: 0.9;
    transition: all 0.3s ease;
}

.cat-card:hover .cat-overlay {
    opacity: 1;
    /* Khi hover, gradient đậm hơn một chút */
    background: linear-gradient(
        to top,
        rgba(15, 23, 42, 1) 0%,
        rgba(15, 23, 42, 0.6) 50%,
        transparent 100%
    );
}

/* Nội dung chữ */
.cat-title {
    font-size: 1.6rem;
    letter-spacing: 1px;
    /* Thêm bóng cho chữ để dễ đọc trên mọi nền */
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

/* Badge số lượng sản phẩm */
.cat-count {
    display: inline-block;
    font-size: 0.9rem;
    font-weight: 500;
    background: rgba(255, 255, 255, 0.2); /* Nền mờ sang trọng */
    padding: 6px 14px;
    border-radius: 30px;
    backdrop-filter: blur(5px); /* Hiệu ứng kính mờ */
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

/* Nút bấm mới (Outline Style) */
.btn-custom-outline {
    /* Nền trong suốt, viền trắng */
    background: transparent;
    border: 2px solid rgba(255, 255, 255, 0.8);
    color: #fff;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-custom-outline i {
    transition: transform 0.3s ease;
}

.btn-custom-outline:hover {
    background: #fff;
    border-color: #fff;
    color: #0f172a; /* Màu chữ khi hover trùng màu nền overlay */
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
}

.btn-custom-outline:hover i {
    transform: translateX(5px); /* Mũi tên di chuyển khi hover */
}

/* Responsive */
@media (max-width: 768px) {
    .cat-img {
        height: 320px;
    }
    .cat-title {
        font-size: 1.3rem;
    }
}
</style>
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
@endpush