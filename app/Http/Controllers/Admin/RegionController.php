<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RegionController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.region.index');
    }

    public function list()
    {
        $regions = Region::select(['id', 'name', 'deleted_at', 'created_at'])->withTrashed();
        return DataTables::of($regions)
            ->editColumn('name', function ($region) {
                return '
                <div class="d-flex flex-column">
                    <a href="' . route('dashboard.regions.edit', $region->id) . '" class="text-body text-truncate">
                        <span class="fw-medium">' . $region->name . '</span>
                    </a>
                </div>';
            })
            ->editColumn('status', function ($region) {
                return '<span class="badge me-1 ' . ($region->deleted_at == null ? 'bg-label-success' : 'bg-label-danger') . '">' . ($region->deleted_at == null ? 'Hoạt động' : 'Ẩn') . '</span>';
            })
            ->addColumn('actions', function ($region) {
                return '
        <div class="d-inline-block text-nowrap">
            <a href="' . route('dashboard.regions.edit', $region->id) . '" class="btn btn-sm btn-icon "><i class="bx bx-edit"></i></a>

            <button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded me-2"></i></button>
            <div class="dropdown-menu dropdown-menu-end m-0">
                <a href="' . route('dashboard.regions.edit', $region->id) . '" class="dropdown-item">Xem thêm</a>
                
                    <form action="' . ($region->trashed() == 1 ? route('dashboard.regions.restore', $region->id) : route('dashboard.regions.soft-delete', $region->id)) . '" class="dropdown-item" method="POST">
                        ' . csrf_field() . '
                        <button type="submit" class="btn p-0 w-100 justify-content-start" >' . ($region->trashed() == 1 ? "Hoạt động" : "Ẩn") . ' </button>
                    </form>
                    ' . ($region->trashed() == 1 ? '
                        <form action="' . route('dashboard.regions.force-delete', $region->id) . '" class="dropdown-item" method="POST" onsubmit="return confirm(\'Bạn có chắc chắn muốn xóa vĩnh viễn không?\')">
                            ' . csrf_field() . '
                            <button type="submit" class="btn p-0 w-100 justify-content-start" >Xóa vĩnh viễn </button>
                        </form>
                    '
                    : '') . '
            </div>
        </div>';
            })

            ->editColumn('created_at', function ($region) {
                return '<p class="m-0">' . $region->created_at->format('d/m/Y') . '</p>
                <small>' . $region->created_at->format('h:i A') . '</small>';
            })
            ->rawColumns(['name', 'status', 'actions', 'created_at'])
            ->make();
    }

    public function add()
    {
        return view('admin.region.add');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:255|unique:regions,name,',
        ], [
            'name.required' => 'Vui lòng nhập Tên miền.',
            'name.max' => 'Tên miền không được vượt quá :max ký tự.',
        ]);

        $check = Region::insert($validate);

        if ($check) {
            return back()->with('msgSuccess', 'Tạo mới thành công');
        }
        return back()->with('msgError', 'Tạo mới thất bại');
    }

    public function edit(Request $request, $id)
    {
        $region = Region::withTrashed()->find($id);

        if (!$region) {
            abort(404);
        }
        return view('admin.region.edit', compact('region'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required|max:255|unique:regions,name,' . $id,
        ], [
            'name.required' => 'Vui lòng nhập Tên miền.',
            'name.max' => 'Tên miền không được vượt quá :max ký tự.',
        ]);


        $check = Region::withTrashed()->where('id', $id)->update($validate);

        if ($check) {
            return back()->with('msgSuccess', 'Cập nhật thành công');
        }
        return back()->with('msgError', 'Cập nhật thất bại');
    }

    public function softDelete($id)
    {

        $check = Region::destroy($id);

        if ($check) {
            return back()->with('msgSuccess', 'Tạm ẩn thành công');
        }
        return back()->with('msgError', 'Tạm ẩn thất bại');
    }

    public function restore($id)
    {
        $check = Region::onlyTrashed()->where('id', $id)->restore();

        if ($check) {
            return back()->with('msgSuccess', 'Khôi phục thành công');
        }
        return back()->with('msgError', 'Khôi phục thất bại');
    }

    public function forceDelete($id)
    {

        $check = Region::onlyTrashed()->where('id', $id)->forceDelete();

        if ($check) {
            return back()->with('msgSuccess', 'Xóa thành công');
        }
        return back()->with('msgError', 'Xóa thất bại');
    }
}
