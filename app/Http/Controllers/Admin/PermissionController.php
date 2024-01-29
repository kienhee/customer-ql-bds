<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Module;
use App\Models\Modules;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index()
    {
        if (Auth::user()->group_id == 0) {
            $groups = Group::orderBy('created_at', 'desc')->get();
        } else {
            $groups = Group::orderBy('created_at', 'desc')->where('id', '<>', 0)->get();
        }
        $roleList = [];
        foreach ($groups as $group) {
            $length =  User::where('group_id', $group->id)->count();
            $users =  User::where('group_id', $group->id)->latest()->take(5)->get();
            $roleList[] = ["length" => $length, "users" => $users, "group" => $group];
        }
        return view('admin.permission.index', compact('roleList'));
    }

    public function addRole()
    {
        $roleArr = [
            'view' => 'Xem',
            'add' => 'Thêm',
            'edit' => 'Sửa',
            'delete' => 'Xóa',
        ];
        $modules = Module::all();
        return view('admin.permission.add-role', compact('modules', 'roleArr'));
    }

    public function storeRole(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:255|unique:groups,name,',
        ], [
            'name.required' => 'Vui lòng nhập tên nhóm.',
            'name.max' => 'Tên nhóm không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên nhóm đã tồn tại.',
        ]);

        if (!empty($request->roles)) {
            $roleJson = json_encode($request->roles);
        } else {
            $roleJson = [];
        }

        $validate['permissions'] = $roleJson;
        $check = Group::insert($validate);

        if ($check) {
            return back()->with('msgSuccess', 'Tạo mới thành công');
        }

        return back()->with('msgError', 'Tạo mới thất bại');
    }

    public function editRole(Group $group)
    {
        $roleArr = [
            'view' => 'Xem',
            'add' => 'Thêm',
            'edit' => 'Sửa',
            'delete' => 'Xóa',
        ];

        $modules = Module::all();
        $roleJson = json_decode($group->permissions, true);

        if (!empty($roleJson)) {
            $roleData = $roleJson;
        } else {
            $roleData = [];
        }

        return view('admin.permission.edit-role', compact('group', 'roleArr', 'modules', 'roleData'));
    }

    public function updateRole(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required|max:255|unique:groups,name,' . $id,
        ], [
            'name.required' => 'Vui lòng nhập tên nhóm.',
            'name.max' => 'Tên nhóm không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên nhóm đã tồn tại.',
        ]);

        if (!empty($request->roles)) {
            $roleJson = json_encode($request->roles);
        } else {
            $roleJson = [];
        }

        $validate['permissions'] = $roleJson;
        $check = Group::where('id', $id)->update($validate);

        if ($check) {
            return back()->with('msgSuccess', 'Cập nhật thành công');
        }

        return back()->with('msgError', 'Cập nhật thất bại!');
    }

    public function deleteRole($id)
    {
        $checkUserExists = User::where('group_id', $id)->get();

        if ($checkUserExists->count() > 0) {
            return back()->with('msgError', 'Có ' . $checkUserExists->count() . ' người dùng trong nhóm, không thể xóa');
        }

        $check = Group::destroy($id);

        if ($check) {
            return back()->with('msgSuccess', 'Xóa thành công');
        }

        return back()->with('msgError', 'Xóa thất bại');
    }

    public function listPermission()
    {
        $modules = Module::select(['id', 'title', 'route', 'description', 'created_at']);

        return DataTables::of($modules)
            ->editColumn('title', function ($module) {
                return '<strong><a href="' . route('dashboard.permission.edit-permission', $module->id) . '">' . $module->title . '</a></strong>';
            })
            ->addColumn('actions', function ($module) {
                return '
        <div class="d-inline-block text-nowrap">
            <button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded me-2"></i></button>
            <div class="dropdown-menu dropdown-menu-end m-0">
                <a href="' . route('dashboard.permission.edit-permission', $module->id) . '" class="dropdown-item">Chỉnh sửa</a>
                  <form action="' . route('dashboard.permission.delete-permission', $module->id) . '" class="dropdown-item" method="POST" onsubmit="return confirm(\'Bạn có chắc chắn muốn xóa vĩnh viễn không?\')">
                            ' . csrf_field() . '
                            <button type="submit" class="btn p-0 w-100 justify-content-start" >Xóa vĩnh viễn </button>
                        </form>
            </div>
        </div>';
            })
            ->editColumn('created_at', function ($module) {
                return '<p class="m-0">' . $module->created_at->format('d M Y') . '</p>
                <small>' . $module->created_at->format('h:i A') . '</small>';
            })
            ->rawColumns(['title', 'actions', 'created_at'])
            ->make();
    }

    public function addPermission(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|max:255|unique:modules,title',
            'route' => 'required|max:255|unique:modules,route',
            'description' => 'nullable|max:255',
        ], [
            'title.required' => 'Vui lòng nhập tên quyền hạn.',
            'title.max' => 'Tên quyền hạn không được vượt quá 255 ký tự.',
            'title.unique' => 'Tên quyền hạn đã tồn tại.',
            'route.required' => 'Vui lòng nhập đường dẫn.',
            'route.max' => 'Đường dẫn không được vượt quá 255 ký tự.',
            'route.unique' => 'Đường dẫn đã tồn tại.',
        ]);

        $check = Module::insert($validate);

        if ($check) {
            return  ['errors' => false, 'message' => "Tạo mới thành công"];
        }

        return "Tạo mới thất bại";
    }

    public function editPermission(Module $module)
    {
        return view('admin.permission.edit-permission', compact('module'));
    }

    public function updatePermission(Request $request, $id)
    {
        $validate = $request->validate([
            'title' => 'required|max:255|unique:modules,title,' . $id,
            'route' => 'required|max:255|unique:modules,route,' . $id,
            'description' => 'nullable|max:255',
        ], [
            'title.required' => 'Vui lòng nhập tên quyền hạn.',
            'title.max' => 'Tên quyền hạn không được vượt quá 255 ký tự.',
            'title.unique' => 'Tên quyền hạn đã tồn tại.',
            'route.required' => 'Vui lòng nhập đường dẫn.',
            'route.max' => 'Đường dẫn không được vượt quá 255 ký tự.',
            'route.unique' => 'Đường dẫn đã tồn tại.',
        ]);

        $check = Module::where('id', $id)->update($validate);

        if ($check) {
            return back()->with('msgSuccess', 'Cập nhật thành công');
        }

        return back()->with('msgError', 'Cập nhật thất bại');
    }

    public function deletePermission($id)
    {
        $check = Module::destroy($id);

        if ($check) {
            return back()->with('msgSuccess', 'Xóa thành công');
        }

        return back()->with('msgError', 'Xóa thất bại');
    }
}
