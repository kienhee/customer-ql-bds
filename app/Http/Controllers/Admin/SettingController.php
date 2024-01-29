<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::where('id', 1)->first();
        return view('admin.setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->isCalendar == 'on' ? $request['isCalendar'] = 1 : $request['isCalendar'] = 0;
        $request->isKanban == 'on' ? $request['isKanban'] = 1 : $request['isKanban'] = 0;

        $data = $request->validate([
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'isCalendar' => 'nullable|boolean',
            'isKanban' => 'nullable|boolean',
        ], [
            'email.email' => 'Định dạng Email không hợp lệ.',
            'phone.string' => 'Số điện thoại phải là chuỗi.',
            'address.string' => 'Địa chỉ phải là chuỗi.',
            'facebook.url' => 'Định dạng URL Facebook không hợp lệ.',
            'twitter.url' => 'Định dạng URL Twitter không hợp lệ.',
            'instagram.url' => 'Định dạng URL Instagram không hợp lệ.',
            'linkedin.url' => 'Định dạng URL LinkedIn không hợp lệ.',
            'isCalendar.boolean' => 'Trường Calendar phải là kiểu boolean.',
            'isKanban.boolean' => 'Trường Kanban phải là kiểu boolean.',
        ]);

        $check = Setting::where('id', 1)->update($data);

        if ($check) {
            return back()->with('msgSuccess', 'Cập nhật thành công');
        }

        return back()->with('msgError', 'Cập nhật thất bại!');
    }
}
