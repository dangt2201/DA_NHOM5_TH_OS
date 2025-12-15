<?php

namespace App\Http\Controllers\User\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('user.auth.login_register');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Validate
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'password.required' => 'Mật khẩu là bắt buộc',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        ]);

        // Attempt login
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Kiểm tra email verified
            if (!$user->email_verified_at) {
                Auth::logout();
                return redirect()->route('verify.email')->with('error', 'Vui lòng xác thực email trước');
            }

            return redirect()->intended(route('home'))->with('success', 'Đăng nhập thành công');
        }

        // Failed login
        throw ValidationException::withMessages([
            'email' => 'Email hoặc mật khẩu không chính xác',
        ]);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Đăng xuất thành công');
    }
}