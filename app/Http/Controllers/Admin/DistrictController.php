<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DistrictController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.district.index');
    }

    public function list()
    {
        $districts = District::select(['id', 'name', 'province_id', 'deleted_at', 'created_at'])->withTrashed();
        return DataTables::of($districts)
            ->editColumn('name', function ($district) {
                return '
                <div class="d-flex flex-column">
                    <a href="' . route('dashboard.districts.edit', $district->id) . '" class="text-body text-truncate">
                        <span class="fw-medium">' . $district->name . '</span>
                    </a>
                    <small class="text-muted">Tỉnh: ' . ($district->province ?  $district->province->name : "Không xác định") . '</small>
                </div>';
            })
            ->editColumn('status', function ($district) {
                return '<span class="badge me-1 ' . ($district->deleted_at == null ? 'bg-label-success' : 'bg-label-danger') . '">' . ($district->deleted_at == null ? 'Hoạt động' : 'Ẩn') . '</span>';
            })
            ->addColumn('actions', function ($district) {
                return '
        <div class="d-inline-block text-nowrap">
            <a href="' . route('dashboard.districts.edit', $district->id) . '" class="btn btn-sm btn-icon "><i class="bx bx-edit"></i></a>

            <button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded me-2"></i></button>
            <div class="dropdown-menu dropdown-menu-end m-0">
                <a href="' . route('dashboard.districts.edit', $district->id) . '" class="dropdown-item">Xem thêm</a>
                
                    <form action="' . ($district->trashed() == 1 ? route('dashboard.districts.restore', $district->id) : route('dashboard.districts.soft-delete', $district->id)) . '" class="dropdown-item" method="POST">
                        ' . csrf_field() . '
                        <button type="submit" class="btn p-0 w-100 justify-content-start" >' . ($district->trashed() == 1 ? "Hoạt động" : "Ẩn") . ' </button>
                    </form>
                    ' . ($district->trashed() == 1 ? '
                        <form action="' . route('dashboard.districts.force-delete', $district->id) . '" class="dropdown-item" method="POST" onsubmit="return confirm(\'Bạn có chắc chắn muốn xóa vĩnh viễn không?\')">
                            ' . csrf_field() . '
                            <button type="submit" class="btn p-0 w-100 justify-content-start" >Xóa vĩnh viễn </button>
                        </form>
                    '
                    : '') . '
            </div>
        </div>';
            })

            ->editColumn('created_at', function ($district) {
                return '<p class="m-0">' . $district->created_at->format('d/m/Y') . '</p>
                <small>' . $district->created_at->format('h:i A') . '</small>';
            })
            ->rawColumns(['name', 'status', 'actions', 'created_at'])
            ->make();
    }

    public function add()
    {
        return view('admin.district.add');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:255|unique:districts,name,',
            'province_id' => 'required|numeric',
        ], [
            'name.required' => 'Vui lòng nhập Quận/huyện.',
            'name.max' => 'Quận/huyện không được vượt quá :max ký tự.',
            'province_id.required' => 'Vui lòng chọn tỉnh.',
            'province_id.numeric' => 'Tỉnh phải là một số.',
        ]);

        $check = District::insert($validate);

        if ($check) {
            return back()->with('msgSuccess', 'Tạo mới thành công');
        }
        return back()->with('msgError', 'Tạo mới thất bại');
    }

    public function edit(Request $request, $id)
    {
        $district = District::withTrashed()->find($id);

        if (!$district) {
            abort(404);
        }
        return view('admin.district.edit', compact('district'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required|max:255|unique:districts,name,' . $id,
            'province_id' => 'required|numeric',
        ], [
            'name.required' => 'Vui lòng nhập Quận/huyện.',
            'name.max' => 'Quận/huyện không được vượt quá :max ký tự.',
            'province_id.required' => 'Vui lòng chọn tỉnh.',
            'province_id.numeric' => 'Tỉnh phải là một số.',
        ]);


        $check = District::withTrashed()->where('id', $id)->update($validate);

        if ($check) {
            return back()->with('msgSuccess', 'Cập nhật thành công');
        }
        return back()->with('msgError', 'Cập nhật thất bại');
    }

    public function softDelete($id)
    {

        $check = District::destroy($id);

        if ($check) {
            return back()->with('msgSuccess', 'Tạm dừng thành công');
        }
        return back()->with('msgError', 'Tạm dừng thất bại');
    }

    public function restore($id)
    {
        $check = District::onlyTrashed()->where('id', $id)->restore();

        if ($check) {
            return back()->with('msgSuccess', 'Khôi phục thành công');
        }
        return back()->with('msgError', 'Khôi phục thất bại');
    }

    public function forceDelete($id)
    {

        $check = District::onlyTrashed()->where('id', $id)->forceDelete();

        if ($check) {
            return back()->with('msgSuccess', 'Xóa thành công');
        }
        return back()->with('msgError', 'Xóa thất bại');
    }

    public function getDistrictsByProvinceID(Request $request)
    {
        $user = Auth::user();
        if ($user->group_id == 4 || $user->group_id == 5) {
            return District::where('id', $user->district_id)->get();
        }
        return District::where('province_id', $request->province_id)->get();
    }
}
