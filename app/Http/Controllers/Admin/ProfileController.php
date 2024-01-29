<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index');
    }

    public function update(Request $request)
    {
        $validate = $request->validate([
            'full_name' => 'required|max:50',
            'phone' => 'required|numeric',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
        ], [
            'full_name.required' => 'Vui lòng nhập họ và tên.',
            'full_name.max' => 'Họ và tên không được vượt quá 50 ký tự.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'avatar.image' => 'Ảnh đại diện phải là hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng jpeg, png, jpg.',
            'avatar.max' => 'Ảnh đại diện không được vượt quá 2048 KB.',
            'facebook.url' => 'Định dạng URL Facebook không hợp lệ.',
            'instagram.url' => 'Định dạng URL Instagram không hợp lệ.',
            'linkedin.url' => 'Định dạng URL LinkedIn không hợp lệ.',
        ]);

        $validate['group_id'] = Auth::user()->group_id;

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $validate['avatar'] = $this->uploadImage($file, 'users');
        }

        $check = User::where('id', Auth::id())->update($validate);

        if ($check) {
            return back()->with('msgSuccess', 'Cập nhật thành công');
        }

        return back()->with('msgError', 'Cập nhật thất bại');
    }

    public function changePassword()
    {
        return view('admin.profile.change-password');
    }

    public function handleChangePassword(Request $request, $email)
    {
        if (Auth::user()->email != $email) {
            return abort(401);
        }

        $request->validate([
            'currentPassword' => 'required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ], [
            'currentPassword.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'password_confirmation.required' => 'Vui lòng nhập lại mật khẩu mới.',
            'password_confirmation.min' => 'Xác nhận mật khẩu phải có ít nhất 6 ký tự.',
        ]);

        $user = User::where('email', $email)->first();

        if (Hash::check($request->currentPassword, $user->password)) {
            $check = User::where('email', $email)->update(['password' => Hash::make($request->password)]);

            if ($check) {
                return back()->with('msgSuccess', 'Thay đổi mật khẩu thành công');
            }

            return back()->with('msgError', 'Thay đổi mật khẩu thất bại!');
        } else {
            return back()->with('msgError', 'Mật khẩu hiện tại không chính xác!');
        }
    }

    public function loginHistory()
    {
        $histories = LoginHistory::where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.profile.login-history', compact('histories'));
    }
}
