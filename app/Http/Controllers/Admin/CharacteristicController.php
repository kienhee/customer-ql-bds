<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Characteristic;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CharacteristicController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.characteristic.index');
    }

    public function list()
    {
        $characteristics = Characteristic::select(['id', 'name', 'deleted_at', 'created_at'])->withTrashed();
        return DataTables::of($characteristics)
            ->editColumn('name', function ($characteristic) {
                return '
                <div class="d-flex flex-column">
                    <a href="' . route('dashboard.characteristics.edit', $characteristic->id) . '" class="text-body text-truncate">
                        <span class="fw-medium">' . $characteristic->name . '</span>
                    </a>
                </div>';
            })
            ->editColumn('status', function ($characteristic) {
                return '<span class="badge me-1 ' . ($characteristic->deleted_at == null ? 'bg-label-success' : 'bg-label-danger') . '">' . ($characteristic->deleted_at == null ? 'Hoạt động' : 'Ẩn') . '</span>';
            })
            ->addColumn('actions', function ($characteristic) {
                return '
        <div class="d-inline-block text-nowrap">
            <a href="' . route('dashboard.characteristics.edit', $characteristic->id) . '" class="btn btn-sm btn-icon "><i class="bx bx-edit"></i></a>

            <button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded me-2"></i></button>
            <div class="dropdown-menu dropdown-menu-end m-0">
                <a href="' . route('dashboard.characteristics.edit', $characteristic->id) . '" class="dropdown-item">Xem thêm</a>
                
                    <form action="' . ($characteristic->trashed() == 1 ? route('dashboard.characteristics.restore', $characteristic->id) : route('dashboard.characteristics.soft-delete', $characteristic->id)) . '" class="dropdown-item" method="POST">
                        ' . csrf_field() . '
                        <button type="submit" class="btn p-0 w-100 justify-content-start" >' . ($characteristic->trashed() == 1 ? "Hoạt động" : "Ẩn") . ' </button>
                    </form>
                    ' . ($characteristic->trashed() == 1 ? '
                        <form action="' . route('dashboard.characteristics.force-delete', $characteristic->id) . '" class="dropdown-item" method="POST" onsubmit="return confirm(\'Bạn có chắc chắn muốn xóa vĩnh viễn không?\')">
                            ' . csrf_field() . '
                            <button type="submit" class="btn p-0 w-100 justify-content-start" >Xóa vĩnh viễn </button>
                        </form>
                    '
                : '') . '
            </div>
        </div>';
            })

            ->editColumn('created_at', function ($characteristic) {
                return '<p class="m-0">' . $characteristic->created_at->format('d M Y') . '</p>
                <small>' . $characteristic->created_at->format('h:i A') . '</small>';
            })
            ->rawColumns(['name', 'status', 'actions', 'created_at'])
            ->make();
    }

    public function add()
    {
        return view('admin.characteristic.add');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|max:255|unique:characteristics,name,',
        ], [
            'name.required' => 'Vui lòng nhập Đặc điểm.',
            'name.max' => 'Đặc điểm không được vượt quá :max ký tự.',
        ]);

        $check = Characteristic::insert($validate);

        if ($check) {
            return back()->with('msgSuccess', 'Tạo mới thành công');
        }
        return back()->with('msgError', 'Tạo mới thất bại');
    }

    public function edit(Request $request, $id)
    {
        $characteristic = Characteristic::withTrashed()->find($id);

        if (!$characteristic) {
            abort(404);
        }
        return view('admin.characteristic.edit', compact('characteristic'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'name' => 'required|max:255|unique:characteristics,name,' . $id,
        ], [
            'name.required' => 'Vui lòng nhập Đặc điểm.',
            'name.max' => 'Đặc điểm không được vượt quá :max ký tự.',
        ]);


        $check = Characteristic::withTrashed()->where('id', $id)->update($validate);

        if ($check) {
            return back()->with('msgSuccess', 'Cập nhật thành công');
        }
        return back()->with('msgError', 'Cập nhật thất bại');
    }

    public function softDelete($id)
    {

        $check = Characteristic::destroy($id);

        if ($check) {
            return back()->with('msgSuccess', 'Tạm ẩn thành công');
        }
        return back()->with('msgError', 'Tạm ẩn thất bại');
    }

    public function restore($id)
    {
        $check = Characteristic::onlyTrashed()->where('id', $id)->restore();

        if ($check) {
            return back()->with('msgSuccess', 'Khôi phục thành công');
        }
        return back()->with('msgError', 'Khôi phục thất bại');
    }

    public function forceDelete($id)
    {

        $check = Characteristic::onlyTrashed()->where('id', $id)->forceDelete();

        if ($check) {
            return back()->with('msgSuccess', 'Xóa thành công');
        }
        return back()->with('msgError', 'Xóa thất bại');
    }
}
