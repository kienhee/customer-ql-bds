<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class ProvinceController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.province.index');
    }

    public function list()
    {
        $provinces = Province::select(['id', 'name', 'region_id', 'deleted_at', 'created_at'])->withTrashed();
        return DataTables::of($provinces)
            ->editColumn('name', function ($province) {
                return '
                <div class="d-flex flex-column">
                    <a href="' . route('dashboard.provinces.edit', $province->id) . '" class="text-body text-truncate">
                        <span class="fw-medium">' . $province->name . '</span>
                    </a>
                    <small class="text-muted">Miền: ' . ($province->region ?  $province->region->name : "Không xác định") . '</small>
                </div>';
            })
            ->editColumn('status', function ($province) {
                return '<span class="badge me-1 ' . ($province->deleted_at == null ? 'bg-label-success' : 'bg-label-danger') . '">' . ($province->deleted_at == null ? 'Hoạt động' : 'Ẩn') . '</span>';
            })
            ->addColumn('actions', function ($province) {
                return '
        <div class="d-inline-block text-nowrap">
            <a href="' . route('dashboard.provinces.edit', $province->id) . '" class="btn btn-sm btn-icon "><i class="bx bx-edit"></i></a>

            <button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded me-2"></i></button>
            <div class="dropdown-menu dropdown-menu-end m-0">
                <a href="' . route('dashboard.provinces.edit', $province->id) . '" class="dropdown-item">Xem thêm</a>
                
                    <form action="' . ($province->trashed() == 1 ? route('dashboard.provinces.restore', $province->id) : route('dashboard.provinces.soft-delete', $province->id)) . '" class="dropdown-item" method="POST">
                        ' . csrf_field() . '
                        <button type="submit" class="btn p-0 w-100 justify-content-start" >' . ($province->trashed() == 1 ? "Hoạt động" : "Ẩn") . ' </button>
                    </form>
                    ' . ($province->trashed() == 1 ? '
                        <form action="' . route('dashboard.provinces.force-delete', $province->id) . '" class="dropdown-item" method="POST" onsubmit="return confirm(\'Bạn có chắc chắn muốn xóa vĩnh viễn không?\')">
                            ' . csrf_field() . '
                            <button type="submit" class="btn p-0 w-100 justify-content-start" >Xóa vĩnh viễn </button>
                        </form>
                    '
                    : '') . '
            </div>
        </div>';
            })

            ->editColumn('created_at', function ($province) {
                return '<p class="m-0">' . $province->created_at->format('d M Y') . '</p>
                <small>' . $province->created_at->format('h:i A') . '</small>';
            })
            ->rawColumns(['name', 'status', 'actions', 'created_at'])
            ->make();
    }

    public function add()
    {
        return view('admin.province.add');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:255|unique:provices,name,',
            'region_id' => 'required|numeric',
        ], [
            'name.required' => 'Vui lòng nhập tỉnh thành.',
            'name.max' => 'Tỉnh thành không được vượt quá :max ký tự.',
            'region_id.required' => 'Vui lòng chọn miền cho tỉnh.',
            'region_id.numeric' => 'Miền phải phải là một số.',
        ]);

        $check = Province::insert($validate);

        if ($check) {
            return back()->with('msgSuccess', 'Tạo mới thành công');
        }
        return back()->with('msgError', 'Tạo mới thất bại');
    }

    public function edit(Request $request, $id)
    {
        $province = Province::withTrashed()->find($id);

        if (!$province) {
            abort(404);
        }
        return view('admin.province.edit', compact('province'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required|max:255|unique:provices,name,' . $id,
            'region_id' => 'required|numeric',
        ], [
            'name.required' => 'Vui lòng nhập tỉnh thành.',
            'name.max' => 'Tỉnh thành không được vượt quá :max ký tự.',
            'region_id.required' => 'Vui lòng chọn miền cho tỉnh.',
            'region_id.numeric' => 'Miền phải phải là một số.',
        ]);


        $check = Province::withTrashed()->where('id', $id)->update($validate);

        if ($check) {
            return back()->with('msgSuccess', 'Cập nhật thành công');
        }
        return back()->with('msgError', 'Cập nhật thất bại');
    }

    public function softDelete($id)
    {

        $check = Province::destroy($id);

        if ($check) {
            return back()->with('msgSuccess', 'Tạm dừng thành công');
        }
        return back()->with('msgError', 'Tạm dừng thất bại');
    }

    public function restore($id)
    {
        $check = Province::onlyTrashed()->where('id', $id)->restore();

        if ($check) {
            return back()->with('msgSuccess', 'Khôi phục thành công');
        }
        return back()->with('msgError', 'Khôi phục thất bại');
    }

    public function forceDelete($id)
    {

        $check = Province::onlyTrashed()->where('id', $id)->forceDelete();

        if ($check) {
            return back()->with('msgSuccess', 'Xóa thành công');
        }
        return back()->with('msgError', 'Xóa thất bại');
    }
}
