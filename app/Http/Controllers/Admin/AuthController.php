<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\LoginHistory;
use App\Models\PasswordRessetTokens;
use App\Models\RefCode;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function register()
    {
        if (Auth::check()) {
            return redirect()->back();
        } else {
            $layout = "auth";
            return view('admin.auth.register', compact('layout'));
        }
    }
    public function handleRegister(Request $request)
    {
        // dd($request->all());
        $validate = $request->validate([
            'full_name' => 'required|max:50',
            'phone' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'CCCD' => "required|numeric",
            'referralCode' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Kiểm tra xem mã giới thiệu có tồn tại trong cơ sở dữ liệu hay không
                    $existingUser = User::where('referralCode', $value)->exists();
                    if (!$existingUser) {
                        $fail('Mã giới thiệu không hợp lệ.');
                    }
                },
            ],
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ], [
            'full_name.required' => 'Vui lòng nhập Họ và Tên.',
            'full_name.max' => 'Họ và Tên không được vượt quá 50 ký tự.',
            'phone.required' => 'Vui lòng nhập Số điện thoại.',
            'phone.numeric' => 'Số điện thoại phải là một số.',
            'email.required' => 'Vui lòng nhập Địa chỉ Email.',
            'email.email' => 'Địa chỉ Email không hợp lệ.',
            'email.unique' => 'Địa chỉ Email đã được sử dụng.',
            'CCCD.required' => 'Vui lòng nhập CCCD/CMND.',
            'CCCD.numeric' => 'CCCD/CMND bắt buộc là số.',
            'referralCode.required' => 'Mã giới thiệu là bắt buộc.',
            'password.required' => 'Vui lòng nhập Mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed' => 'Xác nhận Mật khẩu không khớp.',
            'password_confirmation.required' => 'Vui lòng nhập Xác nhận Mật khẩu.',
            'password_confirmation.min' => 'Xác nhận Mật khẩu phải có ít nhất :min ký tự.',
        ]);


        $validate['group_id'] = 8;
        $validate['password'] = Hash::make($validate['password']);
        $referralCode = strtoupper(Str::random(6));
        // check mã giới thiệu và tạo mã mới cho người dùng.
        $checkReferralCode = User::where('referralCode', $referralCode)->first();
        if ($checkReferralCode) {
            $validate['referralCode'] = $referralCode;
        } else {
            $validate['referralCode'] = strtoupper(Str::random(6));
        }
        $validate['referralCode_parent'] = $request->referralCode;
        $validate['deleted_at'] = date("Y-m-d H:m:s", time());
        unset($validate['password_confirmation']);
        $check = User::insert($validate);

        if ($check) {
            session()->flash(
                'success',
                'Tạo tài khoản thành công, Vui lòng xác nhận email!'
            );
            return redirect()->route('auth.login', ['status' => "successfully"]);
        }
        return back()->with('msgError', 'Tạo mới thất bại');
    }

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
        $findUser = User::where('email', $request->email)->withTrashed()->first();
        // checkSuspend
        if ($findUser && $findUser->deleted_at != null) {
            return back()->withErrors([
                'password' => 'Tài khoản đang không hoạt động, vui lòng liên hệ quản trị viên!',
            ])->onlyInput('password');
        }
        // if ($findUser && $findUser->email_verified_at == null) {
        //     return back()->withErrors([
        //         'password' => 'Vui lòng kiểm tra hộp thư và xác nhận email!',
        //     ])->onlyInput('password');
        // }
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
