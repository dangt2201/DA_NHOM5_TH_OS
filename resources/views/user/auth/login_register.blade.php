@extends('user.layouts.app')

@section('title', 'Đăng Nhập / Đăng Ký')

@section('body')
<div style="max-width: 500px; margin: 50px auto; padding: 30px; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9;">
    
    <!-- Tab Navigation -->
    <div style="display: flex; margin-bottom: 30px; border-bottom: 2px solid #ddd;">
        <button id="loginTab" type="button" onclick="switchTab('login')" style="flex: 1; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; font-weight: bold;">Đăng Nhập</button>
        <button id="registerTab" type="button" onclick="switchTab('register')" style="flex: 1; padding: 10px; background: #f0f0f0; color: #333; border: none; cursor: pointer; font-weight: bold;">Đăng Ký</button>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
            <strong>Lỗi:</strong>
            <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Success Messages -->
    @if (session('success'))
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
            {{ session('success') }}
        </div>
    @endif

    <!-- LOGIN FORM -->
    <form id="loginForm" action="{{ route('auth.login.post') }}" method="POST">
        @csrf

        <!-- Email -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Nhập email của bạn" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;">
            @error('email')
                <p style="color: red; margin: 5px 0 0 0; font-size: 14px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Mật Khẩu</label>
            <input type="password" name="password" placeholder="Nhập mật khẩu" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;">
            @error('password')
                <p style="color: red; margin: 5px 0 0 0; font-size: 14px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" style="width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">Đăng Nhập</button>
    </form>

    <!-- REGISTER FORM -->
    <form id="registerForm" action="{{ route('auth.register.post') }}" method="POST" style="display: none;">
        @csrf

        <!-- Name -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Tên Đầy Đủ</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nhập tên của bạn" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;">
            @error('name')
                <p style="color: red; margin: 5px 0 0 0; font-size: 14px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Nhập email của bạn" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;">
            @error('email')
                <p style="color: red; margin: 5px 0 0 0; font-size: 14px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Mật Khẩu</label>
            <input type="password" name="password" placeholder="Nhập mật khẩu (ít nhất 6 ký tự)" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;">
            @error('password')
                <p style="color: red; margin: 5px 0 0 0; font-size: 14px;">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 5px; font-weight: bold;">Xác Nhận Mật Khẩu</label>
            <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box;">
        </div>

        <!-- Submit Button -->
        <button type="submit" style="width: 100%; padding: 12px; background: #28a745; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">Đăng Ký</button>
    </form>

    <!-- Links -->
    <div style="text-align: center; margin-top: 20px;">
        <p id="loginLinks">
            Chưa có tài khoản? <a href="#" onclick="switchTab('register'); return false;" style="color: #007bff; text-decoration: none;">Đăng ký ngay</a><br>
            <a href="{{ route('forgot.password') }}" style="color: #007bff; text-decoration: none;">Quên mật khẩu?</a><br>
            <a href="{{ route('home') }}" style="color: #007bff; text-decoration: none;">Quay lại trang chủ</a>
        </p>
        <p id="registerLinks" style="display: none;">
            Đã có tài khoản? <a href="#" onclick="switchTab('login'); return false;" style="color: #007bff; text-decoration: none;">Đăng nhập ngay</a><br>
            <a href="{{ route('home') }}" style="color: #007bff; text-decoration: none;">Quay lại trang chủ</a>
        </p>
    </div>

</div>

<script>
function switchTab(tab) {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const loginTab = document.getElementById('loginTab');
    const registerTab = document.getElementById('registerTab');
    const loginLinks = document.getElementById('loginLinks');
    const registerLinks = document.getElementById('registerLinks');

    if (tab === 'login') {
        loginForm.style.display = 'block';
        registerForm.style.display = 'none';
        loginTab.style.background = '#007bff';
        loginTab.style.color = 'white';
        registerTab.style.background = '#f0f0f0';
        registerTab.style.color = '#333';
        loginLinks.style.display = 'block';
        registerLinks.style.display = 'none';
    } else {
        loginForm.style.display = 'none';
        registerForm.style.display = 'block';
        loginTab.style.background = '#f0f0f0';
        loginTab.style.color = '#333';
        registerTab.style.background = '#28a745';
        registerTab.style.color = 'white';
        loginLinks.style.display = 'none';
        registerLinks.style.display = 'block';
    }
}
</script>
@endsection