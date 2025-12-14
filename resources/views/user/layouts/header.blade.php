<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container-fluid px-4">
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route('home') }}">
            SOLID <span class="brand-highlight">TECH</span>
        </a>
        
        <!-- Mobile Toggle -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="mainNavbar">
            <!-- Navigation Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-danger" href="{{ route('shop.hotSale') }}">
                        <i class="bi bi-fire"></i> HOT SALE
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('brands.index') }}">Thương hiệu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop.category', 'giay-nam') }}">Giày Nam</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop.category', 'giay-nu') }}">Giày Nữ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop.category', 'phu-kien') }}">Phụ kiện</a>
                </li>
                <li class="nav-item">
                    {{-- <a class="nav-link" href="{{ route('return.policy') }}">Chính sách</a> --}}
                </li>
            </ul>
            
            <!-- Right Side: Search & User -->
            <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                <!-- Search Form -->
                <form action="{{ route('shop.index') }}" method="GET" class="d-flex">
                    <div class="input-group">
                        <input class="form-control search-input" 
                               type="search" 
                               name="search" 
                               placeholder="Tìm kiếm sản phẩm..."
                               value="{{ request('search') }}">
                        <button class="btn search-btn" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
                
                <!-- User Dropdown -->
                @guest
                    {{-- <a href="{{ route('login') }}" class="btn btn-outline-dark rounded-pill px-3"> --}}
                        <i class="bi bi-person"></i> Đăng nhập
                    </a>
                @else
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" 
                           data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-4 me-2"></i>
                            <span class="d-none d-lg-inline">{{ Str::limit(Auth::user()->name, 15) }}</span>
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end shadow">
                            @if(Auth::user()->role == 1)
                                <li>
                                    <a class="dropdown-item text-danger fw-bold" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2"></i>Trang Admin
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif
                            
                            <li>
                                <a class="dropdown-item" href="{{ route('user.profile') }}">
                                    <i class="bi bi-person me-2"></i>Tài khoản
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('user.orders') }}">
                                    <i class="bi bi-bag me-2"></i>Đơn hàng
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" 
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @endguest
                
                <!-- Cart -->
                {{-- <a href="{{ route('cart.index') }}" class="position-relative">
                    <i class="bi bi-cart3 fs-4"></i>
                    @php
                        $cartCount = Auth::check() ? Auth::user()->cartItems->sum('quantity') : 0;
                    @endphp
                    @if($cartCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill cart-badge">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a> --}}
                <!--test hiển thị số lượng sản phẩm trong Giỏ hàng -->
                <div style="position: relative;">
                    <a href="{{ route('cart.index') }}" style="text-decoration: none; color: black; font-size: 20px;">
                        🛒
                        <span id="cart-count-badge" style="
                            position: absolute;
                            top: -8px;
                            right: -10px;
                            background: red;
                            color: white;
                            border-radius: 50%;
                            width: 20px;
                            height: 20px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 12px;
                            font-weight: bold;
                        ">0</span>
                    </a>
                </div>

                <script>
                // Hàm cập nhật số lượng giỏ hàng
                function updateCartCount() {
                    fetch('{{ route('cart.count') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        const badge = document.getElementById('cart-count-badge');
                        badge.textContent = data.count;
                        
                        // Ẩn badge nếu count = 0
                        if (data.count === 0) {
                            badge.style.display = 'none';
                        } else {
                            badge.style.display = 'flex';
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }

                // Cập nhật khi page load
                document.addEventListener('DOMContentLoaded', updateCartCount);
                </script>
            </div>
        </div>
    </div>
</nav>