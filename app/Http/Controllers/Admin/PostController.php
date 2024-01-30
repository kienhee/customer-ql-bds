<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.post.index');
    }

    public function list()
    {
        $users = Post::select(['id', 'full_name', 'avatar', 'group_id', 'deleted_at', 'email', 'created_at'])->where('group_id', '<>', 0)->withTrashed();

        return DataTables::of($users)
            ->editColumn('full_name', function ($user) {
                return '
            <div class="d-flex justify-content-start align-items-center user-name">
                <div class="avatar-wrapper">
                    <div class="avatar avatar-sm me-3">
                        <img src="' . ($user->avatar ? $user->avatar : asset('admin-frontend/assets/img/avatar.png')) . '" alt="Avatar" class="w-px-30 h-px-30  rounded-circle object-fit-cover">
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <a href="' . route('dashboard.users.edit', $user->id) . '" class="text-body text-truncate">
                        <span class="fw-medium">' . $user->full_name . '</span>
                    </a>
                    <small class="text-muted">' . $user->email . '</small>
                </div>
            </div>';
            })
            ->editColumn('role', function ($user) {
                return '<span class="text-truncate d-flex align-items-center"><span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2"><i class="bx bx-user bx-xs"></i></span>' . $user->group->name . '</span>';
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
                return '<p class="m-0">' . $user->created_at->format('d M Y') . '</p>
                <small>' . $user->created_at->format('h:i A') . '</small>';
            })
            ->rawColumns(['full_name', 'role', 'status', 'actions', 'created_at'])
            ->make();
    }

    public function add()
    {
        return view('admin.post.add');
    }

    public function store(Request $request)
    {
        // dd($request->all());/
        $data =   $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'province_id' => 'required|integer',
            'district_id' => 'required|integer',
            'address' => 'required|string|max:255',
            'acreage' => 'required|string|max:255',
            'price' => 'required|integer',
            'views' => 'required|integer',
            'map' => 'nullable|string',
            'status' => 'integer',
            'characteristics' => 'nullable|string',
            'room_number' => 'integer',
            'direction_id' => 'integer',
            'format' => 'required|string',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'title.string' => 'Tiêu đề phải là chuỗi ký tự.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'content.required' => 'Nội dung là trường bắt buộc.',
            'content.string' => 'Nội dung phải là chuỗi ký tự.',
            'province_id.required' => ' Tỉnh/thành phố là trường bắt buộc.',
            'province_id.integer' => ' Tỉnh/thành phố phải là số nguyên.',
            'district_id.required' => ' Quận/huyện là trường bắt buộc.',
            'district_id.integer' => ' Quận/huyện phải là số nguyên.',
            'address.required' => 'Địa chỉ là trường bắt buộc.',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'acreage.required' => 'Diện tích là trường bắt buộc.',
            'acreage.string' => 'Diện tích phải là chuỗi ký tự.',
            'acreage.max' => 'Diện tích không được vượt quá 255 ký tự.',
            'price.required' => 'Giá là trường bắt buộc.',
            'price.integer' => 'Giá phải là số.',
            'views.required' => 'Lượt xem là trường bắt buộc.',
            'views.integer' => 'Lượt xem phải là số nguyên.',
            'map.string' => 'Dữ liệu bản đồ phải là chuỗi ký tự.',
            'status.integer' => 'Trạng thái phải là số nguyên.',
            'characteristics.string' => 'Đặc điểm phải là chuỗi ký tự.',
            'room_number.integer' => 'Số phòng phải là số nguyên.',
            'direction_id.integer' => ' hướng nhà phải là số nguyên.',
            'format.required' => 'Định dạng là trường bắt buộc.',
            'format.string' => 'Định dạng phải là chuỗi ký tự.',
        ]);

        $check = Post::insert($data);

        if ($check) {
            return back()->with('msgSuccess', 'Tạo mới thành công');
        }
        return back()->with('msgError', 'Tạo mới thất bại');
    }

    public function edit(Request $request, $id)
    {
        $user = Post::withTrashed()->find($id);

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
            'avatar' => 'required',
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
            'avatar.required' => 'Vui lòng tải lên Ảnh đại diện.',
            'facebook.url' => 'Liên kết Facebook không hợp lệ.',
            'instagram.url' => 'Liên kết Instagram không hợp lệ.',
            'linkedin.url' => 'Liên kết LinkedIn không hợp lệ.',
        ]);


        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $validate['avatar'] = $this->uploadImage($file, 'users');
        }

        $check = Post::withTrashed()->where('id', $id)->update($validate);

        if ($check) {
            return back()->with('msgSuccess', 'Cập nhật thành công');
        }
        return back()->with('msgError', 'Cập nhật thất bại');
    }

    public function softDelete($id)
    {

        $check = Post::destroy($id);

        if ($check) {
            return back()->with('msgSuccess', 'Tạm dừng thành công');
        }
        return back()->with('msgError', 'Tạm dừng thất bại');
    }

    public function restore($id)
    {
        $check = Post::onlyTrashed()->where('id', $id)->restore();

        if ($check) {
            return back()->with('msgSuccess', 'Khôi phục thành công');
        }
        return back()->with('msgError', 'Khôi phục thất bại');
    }

    public function forceDelete($id)
    {

        $check = Post::onlyTrashed()->where('id', $id)->forceDelete();

        if ($check) {
            return back()->with('msgSuccess', 'Xóa thành công');
        }
        return back()->with('msgError', 'Xóa thất bại');
    }
}
