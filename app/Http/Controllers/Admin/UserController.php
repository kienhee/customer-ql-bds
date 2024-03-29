<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function index(Request $request)
    {
        return view('admin.user.index');
    }

    public function list(Request $request)
    {
        $userGroupId = Auth::user()->group_id;
        // admin -> list all,
        $users = User::select(['id', 'full_name', 'avatar', 'group_id', 'region_id', 'province_id', 'district_id', 'deleted_at', 'email', 'phone', 'created_at']);
        // Phân luồng
        if ($userGroupId == 2) {
            // Quản lý miền -> list tất cả tài khoản nằm trong miền đó. và không lấy tài khoản admin
            $users->where('region_id', Auth::user()->region_id)->where('group_id', '<>', 1);
        } elseif ($userGroupId == 3) {
            // Quản lý tỉnh-> list tất cả tài khoản nằm trong tỉnh, và không lấy tài khoản miền và admin
            $users->where('province_id', Auth::user()->province_id)->whereNotIn('group_id', range(1, 2));
        } elseif ($userGroupId == 4) {
            // Quản lý huyện-> list tất cả tài khoản nằm trong huyện, không lấy admin, miền, tỉnh.
            $users->where('district_id', Auth::user()->district_id)->whereNotIn('group_id', range(1, 3));
        } elseif ($userGroupId == 5) {
            // Trưởng phòng -> list tất cả tài khoản có ma giới thiệu của nó. và không lấy cấp trên của chúng
            $users->where('referralCode_parent', Auth::user()->referralCode)->whereNotIn('group_id', range(1, 4));
        }

        // filter
        if ($request->has('search_email') && $request->search_email != null) {
            $email = $request->input('search_email');
            $users->where('email', 'like', "%$email%");
        }

        // Xử lý tìm kiếm theo số điện thoại
        if ($request->has('search_phone') && $request->search_phone != null) {
            $phone = $request->input('search_phone');
            $users->where('phone', 'like', "%$phone%");
        }
        if ($request->has('search_order_id') && $request->search_order_id != null) {
            $order_id = $request->input('search_order_id');
            $users->where('order_id', 'like', "%$order_id%");
        }
        if ($request->has('search_role') && $request->search_role != null) {
            $role = $request->input('search_role');
            $users->where('group_id', $role);
        }

        // Xử lý tìm kiếm theo trạng thái đơn hàng
        if ($request->has('search_status') && $request->search_status != null) {
            $status = $request->input('search_status');
            if ($status == 'active') {
                $users->where('deleted_at', '=', null);
            } else {
                $users->where('deleted_at', '<>', null);
            }
        }
        $users->where('id', '<>', Auth::id())->withTrashed();
        return DataTables::of($users)
            ->editColumn('full_name', function ($user) {
                return '
            <div class="d-flex justify-content-start align-items-center user-name">
                <div class="avatar-wrapper">
                    <div class="avatar avatar-sm me-3">
                        <img src="' . ($user->avatar ? getThumb($user->avatar) : asset('admin-frontend/assets/img/avatar.png')) . '" alt="Avatar" class="w-px-30 h-px-30  rounded-circle object-fit-cover">
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <a href="' . route('dashboard.users.edit', $user->id) . '" class="text-body text-truncate">
                        <span class="fw-medium">' . $user->full_name . '</span>
                    </a>
                    <small class="text-muted">' . $user->email . '</small>
                    <small class="text-muted">' . $user->phone . '</small>
                </div>
            </div>';
            })
            ->editColumn('role', function ($user) {
                return '<span class="text-truncate d-flex align-items-center"><span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2"><i class="bx bx-user bx-xs"></i></span>' . $user->group->name . '</span>';
            })
            ->editColumn('region_id', function ($user) {
                return  $user->region->name;
            })
            ->editColumn('province_id', function ($user) {
                return $user->province->name;
            })
            ->editColumn('district_id', function ($user) {
                return $user->district->name;
            })
            ->editColumn('status', function ($user) {
                return '<span class="badge me-1 ' . ($user->deleted_at == null ? 'bg-label-success' : 'bg-label-danger') . '">' . ($user->deleted_at == null ? 'Hoạt động' : 'Đình chỉ') . '</span>';
            })
            ->addColumn('actions', function ($user) {
                return '
        <div class="d-inline-block text-nowrap">
            <a href="' . route('dashboard.users.edit', $user->id) . '" class="btn btn-sm btn-icon "><i class="bx bx-edit"></i></a>

            <button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded me-2"></i></button>
            <div class="dropdown-menu dropdown-menu-end m-0">
                <a href="' . route('dashboard.users.edit', $user->id) . '" class="dropdown-item">Xem thêm</a>
                ' . (Auth::user()->id != $user->id ? '
                    <form action="' . ($user->trashed() == 1 ? route('dashboard.users.restore', $user->id) : route('dashboard.users.soft-delete', $user->id)) . '" class="dropdown-item" method="POST">
                        ' . csrf_field() . '
                        <button type="submit" class="btn p-0 w-100 justify-content-start" >' . ($user->trashed() == 1 ? "Hoạt động" : "Đình chỉ") . ' </button>
                    </form>
                    ' . ($user->trashed() == 1 ? '
                        <form action="' . route('dashboard.users.force-delete', $user->id) . '" class="dropdown-item" method="POST" onsubmit="return confirm(\'Bạn có chắc chắn muốn xóa vĩnh viễn không?\')">
                            ' . csrf_field() . '
                            <button type="submit" class="btn p-0 w-100 justify-content-start" >Xóa vĩnh viễn </button>
                        </form>
                    ' : '')
                    : '') . '
            </div>
        </div>';
            })

            ->editColumn('created_at', function ($user) {
                return '<p class="m-0">' . $user->created_at->format('d/m/Y') . '</p>
                <small>' . $user->created_at->format('h:i A') . '</small>';
            })
            ->rawColumns(['full_name', 'role', 'region_id', 'province_id', 'district_id', 'status', 'actions', 'created_at'])
            ->make();
    }

    public function add()
    {
        return view('admin.user.add');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'full_name' => 'required|max:50',
            'group_id' => 'required|numeric',
            'phone' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'date_of_birth' => "required",
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
            'region_id' => 'required|numeric',
            'province_id' => 'required|numeric',
            'district_id' => 'required|numeric',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
        ], [
            'full_name.required' => 'Vui lòng nhập Họ và Tên.',
            'full_name.max' => 'Họ và Tên không được vượt quá 50 ký tự.',
            'group_id.required' => 'Vui lòng chọn Vai trò Người dùng.',
            'group_id.numeric' => 'Vai trò Người dùng phải là một số.',
            'phone.required' => 'Vui lòng nhập Số điện thoại.',
            'phone.numeric' => 'Số điện thoại phải là một số.',
            'email.required' => 'Vui lòng nhập Địa chỉ Email.',
            'email.email' => 'Địa chỉ Email không hợp lệ.',
            'email.unique' => 'Địa chỉ Email đã được sử dụng.',
            'date_of_birth.required' => 'Vui lòng nhập sinh nhật.',
            'CCCD.required' => 'Vui lòng nhập CCCD/CMND.',
            'CCCD.numeric' => 'CCCD/CMND bắt buộc là số.',
            'password.required' => 'Vui lòng nhập Mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.confirmed' => 'Xác nhận Mật khẩu không khớp.',
            'password_confirmation.required' => 'Vui lòng nhập Xác nhận Mật khẩu.',
            'password_confirmation.min' => 'Xác nhận Mật khẩu phải có ít nhất :min ký tự.',
            'facebook.url' => 'Liên kết Facebook không hợp lệ.',
            'instagram.url' => 'Liên kết Instagram không hợp lệ.',
            'linkedin.url' => 'Liên kết LinkedIn không hợp lệ.',
            'referralCode.required' => 'Mã giới thiệu là bắt buộc.',
            'region_id.required' => 'Vui lòng chọn miền.',
            'region_id.numeric' => 'Miền phải là một số.',
            'province_id.required' => 'Vui lòng chọn tỉnh thành.',
            'province_id.numeric' => 'Tỉnh thành phải là một số.',
            'district_id.required' => 'Vui lòng chọn quận/huyện.',
            'district_id.numeric' => 'Quận/huyện phải là một số.',
        ]);



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
        unset($validate['password_confirmation']);
        $check = User::insert($validate);

        if ($check) {
            return back()->with('msgSuccess', 'Tạo mới thành công');
        }
        return back()->with('msgError', 'Tạo mới thất bại');
    }

    public function edit(Request $request, $id)
    {
        $user = User::withTrashed()->find($id);

        if (!$user) {
            abort(404);
        }
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'full_name' => 'required|max:50',
            'group_id' => 'required|numeric',
            'phone' => 'required|numeric',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'date_of_birth' => "required",
            'CCCD' => "required|numeric",
            'region_id' => 'required|numeric',
            'province_id' => 'required|numeric'
        ], [
            'full_name.required' => 'Vui lòng nhập Họ và Tên.',
            'full_name.max' => 'Họ và Tên không được vượt quá 50 ký tự.',
            'group_id.required' => 'Vui lòng chọn Vai trò Người dùng.',
            'group_id.numeric' => 'Vai trò Người dùng phải là một số.',
            'phone.required' => 'Vui lòng nhập Số điện thoại.',
            'phone.numeric' => 'Số điện thoại phải là một số.',
            'date_of_birth.required' => 'Vui lòng nhập sinh nhật.',
            'CCCD.required' => 'Vui lòng nhập CCCD/CMND.',
            'CCCD.numeric' => 'CCCD/CMND bắt buộc là số.',
            'facebook.url' => 'Liên kết Facebook không hợp lệ.',
            'instagram.url' => 'Liên kết Instagram không hợp lệ.',
            'linkedin.url' => 'Liên kết LinkedIn không hợp lệ.',
            'region_id.required' => 'Vui lòng chọn miền.',
            'region_id.numeric' => 'Miền phải là một số.',
            'province_id.required' => 'Vui lòng chọn tỉnh thành.',
            'province_id.numeric' => 'Tỉnh thành phải là một số.',
        ]);


        $check = User::withTrashed()->where('id', $id)->update($validate);

        if ($check) {
            return back()->with('msgSuccess', 'Cập nhật thành công');
        }
        return back()->with('msgError', 'Cập nhật thất bại');
    }

    public function softDelete($id)
    {

        $check = User::destroy($id);

        if ($check) {
            return back()->with('msgSuccess', 'Tạm dừng thành công');
        }
        return back()->with('msgError', 'Tạm dừng thất bại');
    }

    public function restore($id)
    {
        $check = User::onlyTrashed()->where('id', $id)->restore();

        if ($check) {
            return back()->with('msgSuccess', 'Khôi phục thành công');
        }
        return back()->with('msgError', 'Khôi phục thất bại');
    }

    public function forceDelete($id)
    {

        $check = User::onlyTrashed()->where('id', $id)->forceDelete();

        if ($check) {
            return back()->with('msgSuccess', 'Xóa thành công');
        }
        return back()->with('msgError', 'Xóa thất bại');
    }
}
