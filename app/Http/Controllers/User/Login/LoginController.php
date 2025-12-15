<?php

namespace App\Http\Controllers\User\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /**
     * Hiển thị trang đăng nhập/đăng ký
     */
    public function showLoginRegister()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        session()->forget(['success', 'error', 'warning', 'info']);
        
        return view('user.auth.login_register');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        $request->validate([
            'mail' => 'required|email',
            'password' => 'required',
        ], [
            'mail.required' => 'Vui lòng nhập email',
            'mail.email' => 'Email không đúng định dạng',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);

        $credentials = [
            'email' => $request->mail,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            // ===== KIỂM TRA EMAIL ĐÃ XÁC THỰC CHƯA =====
            $requireVerification = env('VERIFY_EMAIL_REQUIRED', true);
            
            if ($requireVerification && $user->role != 1 && !$user->hasVerifiedEmail()) {
                Auth::logout();
                return back()
                    ->withErrors(['mail' => 'Vui lòng xác thực email trước khi đăng nhập. Kiểm tra hộp thư của bạn.'])
                    ->withInput($request->only('mail'))
                    ->with('show_resend', true)
                    ->with('email_to_verify', $request->mail);
            }
            
            $request->session()->regenerate();
            session()->forget(['error', 'warning']);
            
            Log::info('User logged in', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
            ]);

            if ($user->role == 1) {
                return redirect('admin/dashboard')
                    ->with('success', "Chào mừng quản trị viên {$user->name}!");
            }

            return redirect('/')
                ->with('success', "Đăng nhập thành công! Chào {$user->name}");
        }

        return back()
            ->withErrors(['mail' => 'Email hoặc mật khẩu không đúng.'])
            ->withInput($request->only('mail'));
    }

    /**
     * Xử lý đăng ký
     */
    public function register(Request $request)
    {
        $request->validate([
            'register_username' => 'required|string|max:255|min:3',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15|regex:/^([0-9\s\-\+\(\)]*)$/|unique:users,phone',
            'password' => [
                'required',
                'confirmed',
                PasswordRule::min(6)
            ],
            'password_confirmation' => 'required',
        ], [
            'register_username.required' => 'Vui lòng nhập tên đăng nhập',
            'register_username.min' => 'Tên đăng nhập phải có ít nhất 3 ký tự',
            'register_username.max' => 'Tên đăng nhập không được quá 255 ký tự',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email này đã được đăng ký',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'phone.regex' => 'Số điện thoại không đúng định dạng',
            'phone.unique' => 'Số điện thoại này đã được đăng ký',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
            'password_confirmation.required' => 'Vui lòng xác nhận mật khẩu',
        ]);

        try {
            $user = User::create([
                'name' => $request->register_username,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => 0,
            ]);

            Log::info('New user registered', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);

            // $requireVerification = env('VERIFY_EMAIL_REQUIRED', true);
            
           // Tự động verify email
                $user->email_verified_at = now();
                $user->save();

                // Auto login
                Auth::login($user);

                // Redirect home
                return redirect('/')
                    ->with('success', "Đăng ký thành công! Chào mừng {$user->name} đến với SOLID TECH!");

        } catch (\Exception $e) {
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Đăng ký thất bại! Vui lòng thử lại.');
        }
    }

    /**
     * Gửi lại email xác thực (không cần đăng nhập)
     */
    public function resendVerificationEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.exists' => 'Email này chưa được đăng ký',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'Email này đã được xác thực rồi. Bạn có thể đăng nhập.');
        }

        $user->sendEmailVerificationNotification();

        Log::info('Resend verification email', [
            'user_id' => $user->id,
            'email' => $user->email,
        ]);

        return back()->with('success', 'Email xác thực đã được gửi lại! Vui lòng kiểm tra hộp thư.');
    }

    /**
     * Xử lý đăng xuất
     */
    public function logout(Request $request) 
    {
        $userName = Auth::user() ? Auth::user()->name : 'bạn';
        
        Log::info('User logged out', [
            'user_id' => Auth::id(),
        ]);
        
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->forget(['success', 'error', 'warning', 'info']);
        
        return redirect('/')
            ->with('info', "Đã đăng xuất. Hẹn gặp lại {$userName}!");
    }
}