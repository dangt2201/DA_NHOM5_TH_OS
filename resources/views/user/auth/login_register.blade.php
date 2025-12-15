@extends('user.layouts.app')

@section('title', 'Đăng Nhập')

@section('body')
<div style="max-width: 500px; margin: 50px auto; padding: 30px; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9;">
    
    <h2 style="text-align: center; margin-top: 0;">Đăng Nhập</h2>

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

    <!-- Login Form -->
    <form action="{{ route('auth.login.post') }}" method="POST">
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

    <!-- Links -->
    <div style="text-align: center; margin-top: 20px;">
        {{-- <p>Chưa có tài khoản? <a href="{{ route('register') }}" style="color: #007bff; text-decoration: none;">Đăng ký ngay</a></p> --}}
        {{-- <p><a href="{{ route('forgot.password') }}" style="color: #007bff; text-decoration: none;">Quên mật khẩu?</a></p> --}}
        <p><a href="{{ route('home') }}" style="color: #007bff; text-decoration: none;">Quay lại trang chủ</a></p>
    </div>

</div>
@endsection