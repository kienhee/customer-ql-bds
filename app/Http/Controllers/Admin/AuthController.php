<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\LoginHistory;
use App\Models\PasswordRessetTokens;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->back();
        } else {
            $layout = "auth";
            return view('admin.auth.login', compact('layout'));
        }
    }

    public function handleLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);
        $checkSuspend = User::where('email', $request->email)->withTrashed()->first();
        if ($checkSuspend && $checkSuspend->deleted_at != null) {
            return back()->withErrors([
                'password' => 'Tài khoản đang bị đình chỉ, vui lòng liên hệ quản trị viên!',
            ])->onlyInput('password');
        }
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            LoginHistory::insert(['user_id' => Auth::id()]);
            return redirect()->route('dashboard.index');
        }

        return back()->withErrors([
            'password' => 'Tài khoản hoặc mật khẩu không chính xác!',
        ])->onlyInput('password');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login', ['status' => "successfully"]);
    }

    public function ForgotPassword()
    {
        if (Auth::check()) {
            return redirect()->back();
        } else {
            $layout = "auth";
            return view('admin.auth.forgot-password', compact('layout'));
        }
    }

    public function SendMailForgotPassword(Request $request)
    {
        $request->validate([
            "email" => "required|email"
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $name = $user->full_name;
            $email = $user->email;
            $token = Str::random(64);
            // expired = 5m
            $expired = now()->addMinutes(5);
            $checkEmailExist = PasswordRessetTokens::where('email', $email)->first();

            if ($checkEmailExist) {
                PasswordRessetTokens::where('email', $email)->delete();
            }

            $checkInsertTokenToDB = PasswordRessetTokens::insert(["email" => $email, "token" => $token, 'expired' => $expired]);

            if (!$checkInsertTokenToDB) {
                return back()->withErrors([
                    'email' => 'Lỗi hệ thống, vui lòng thử lại!',
                ])->onlyInput('email');
            }

            $url = route('auth.resetPassword', ['email' => $email, 'token' => $token]);
            Mail::to($user->email)->send(new ResetPassword($name, $url));

            session()->flash(
                'success',
                'Chúng tôi đã gửi một email đến ' . substr($email, 0, 1) . '*******' . substr($email, strpos($email, '@'))
            );

            return redirect()->back();
        }

        return back()->withErrors([
            'email' => 'Tài khoản không tồn tại trong hệ thống!',
        ])->onlyInput('email');
    }

    public function resetPassword(Request $request)
    {
        if ($request->has('email') && $request->has('token')) {
            $checkToken = PasswordRessetTokens::where('email', $request->email)->first();

            if ($checkToken && $checkToken->token == $request->token && now()->lt($checkToken->expired)) {
                $layout = 'auth';
                return view('admin.auth.reset-password', compact('layout'));
            }
        }

        return abort(404);
    }

    public function PostResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu ít nhất phải có :min ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'password_confirmation.required' => 'Vui lòng xác nhận mật khẩu mới.',
            'password_confirmation.min' => 'Mật khẩu xác nhận ít nhất phải có :min ký tự.',
        ]);

        $changePw = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        if ($changePw) {
            PasswordRessetTokens::where('email', $request->email)->delete();

            session()->flash(
                'success',
                'Đặt lại mật khẩu thành công, vui lòng đăng nhập lại'
            );

            return redirect()->route('auth.login');
        } else {
            return abort(500);
        }
    }
}
