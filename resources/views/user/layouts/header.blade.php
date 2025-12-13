<nav style="background: #f0f0f0; padding: 15px; border-bottom: 1px solid #ccc;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <!-- Branding + Navigation -->
        <div style="display: flex; justify-content: space-between; align-items: center;">
            
            <!-- Logo/Brand -->
            <h2 style="margin: 0;">
                <a href="/" style="text-decoration: none; color: black;">SOLID TECH</a>
            </h2>

            <!-- Links -->
            <div style="display: flex; gap: 20px; align-items: center;">
                <a href="/" style="text-decoration: none; color: black;">Trang chủ</a>
                <a href="{{ route('shop.index') }}" style="text-decoration: none; color: black;">Sản phẩm</a>
                <a href="{{ route('brands.index') }}" style="text-decoration: none; color: black;">Thương hiệu</a>
                
                <!-- User Info -->
                @guest
                    <a href="{{ route('login') }}" style="text-decoration: none; color: blue;">Đăng nhập</a>
                @else
                    <span>{{ Auth::user()->name }}</span>
                    <a href="{{ route('user.profile') }}" style="text-decoration: none; color: blue;">Profile</a>
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; color: red; cursor: pointer;">Đăng xuất</button>
                    </form>
                @endguest

                <!-- Cart -->
                <a href="{{ route('cart.index') }}" style="text-decoration: none; color: black;">
                    🛒 Giỏ hàng
                </a>
            </div>
        </div>
    </div>
</nav>