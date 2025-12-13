@extends('user.layouts.app')

@section('body')
<div class="container py-5">
    
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $categoryName }}</li>
        </ol>
    </nav>

    <div class="mb-4">
        <h2 class="fw-bold text-uppercase">{{ $categoryName }}</h2>
        <span class="text-muted small">Hiển thị {{ $products->count() }} sản phẩm</span>
    </div>

    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 border-0 shadow-sm">
                    <img src="{{ $product->img_thumbnail ?? 'https://via.placeholder.com/300x300?text=No+Image' }}" 
                         class="card-img-top" 
                         alt="{{ $product->name }}"
                         style="height: 250px; object-fit: cover;">
                    <div class="card-body">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <div class="price-box mb-2">
                            @if($product->price_sale && $product->price_sale < $product->price)
                                <span class="text-danger fw-bold">
                                    {{ number_format($product->price_sale) }}đ
                                </span>
                                <span class="text-muted text-decoration-line-through small">
                                    {{ number_format($product->price) }}đ
                                </span>
                            @else
                                <span class="fw-bold">
                                    {{ number_format($product->price) }}đ
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('shop.detail', $product->slug) }}" class="btn btn-sm btn-outline-dark w-100">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">Chưa có sản phẩm nào</p>
                <a href="/" class="btn btn-dark mt-2">Về trang chủ</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-5">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection