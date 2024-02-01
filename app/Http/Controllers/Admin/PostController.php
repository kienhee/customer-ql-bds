<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class PostController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.post.index');
    }

    public function list()
    {
        $posts = Post::select(['id', 'title', 'cover', 'province_id', 'user_id', 'deleted_at', 'created_at'])->withTrashed();

        return DataTables::of($posts)
            ->editColumn('title', function ($post) {
                return '
            <div class="d-flex justify-content-start gap-2">
                    <div class=" me-3">
                        <img src="' . (getThumb($post->cover)) . '" alt="image" class="w-px-100 h-px-100  rounded-3 object-fit-cover">
                    </div>
                <div class="d-flex flex-column">
                    <strong title=" ' . $post->title . '"><a href="' . route('dashboard.posts.edit', $post->id) . '" class="text-body truncate-3" >
                         ' . $post->title . '
                    </a></strong>
                </div>
            </div>';
            })
            ->editColumn('author', function ($post) {
                return '
                <div class="d-flex flex-column">
                    <strong class="text-body text-truncate">
                        ' . $post->user->full_name . '
                    </strong>
                    <small class="text-muted">' . $post->user->email . '</small>
                </div>
            ';
            })
            ->editColumn('status', function ($post) {
                return '<span class="badge me-1 ' . ($post->deleted_at == null ? 'bg-label-success' : 'bg-label-danger') . '">' . ($post->deleted_at == null ? 'Hoạt động' : 'Đình chỉ') . '</span>';
            })
            ->addColumn('actions', function ($post) {
                return '
        <div class="d-inline-block text-nowrap">
            <a href="' . route('dashboard.posts.edit', $post->id) . '" class="btn btn-sm btn-icon "><i class="bx bx-edit"></i></a>

            <button class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded me-2"></i></button>
            <div class="dropdown-menu dropdown-menu-end m-0">
                <a href="' . route('dashboard.posts.edit', $post->id) . '" class="dropdown-item">Xem thêm</a>
                    <form action="' . ($post->trashed() == 1 ? route('dashboard.posts.restore', $post->id) : route('dashboard.posts.soft-delete', $post->id)) . '" class="dropdown-item" method="POST">
                        ' . csrf_field() . '
                        <button type="submit" class="btn p-0 w-100 justify-content-start" >' . ($post->trashed() == 1 ? "Hoạt động" : "Đình chỉ") . ' </button>
                    </form>
                    ' . ($post->trashed() == 1 ? '
                        <form action="' . route('dashboard.posts.force-delete', $post->id) . '" class="dropdown-item" method="POST" onsubmit="return confirm(\'Bạn có chắc chắn muốn xóa vĩnh viễn không?\')">
                            ' . csrf_field() . '
                            <button type="submit" class="btn p-0 w-100 justify-content-start" >Xóa vĩnh viễn </button>
                        </form>
                    '
                    : '') . '
            </div>
        </div>';
            })

            ->editColumn('created_at', function ($post) {
                return '<p class="m-0">' . $post->created_at->format('d M Y') . '</p>
                <small>' . $post->created_at->format('h:i A') . '</small>';
            })
            ->rawColumns(['title', 'author', 'status', 'actions', 'created_at'])
            ->make();
    }

    public function add()
    {
        return view('admin.post.add');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255|unique:posts,title',
            'content' => 'required',
            'province_id' => 'required|integer',
            'district_id' => 'required|integer',
            'address' => 'required|max:255',
            'acreage' => 'required|max:255',
            'price' => 'required|integer',
            'map' => 'nullable|url',
            'status' => 'integer',
            'characteristics' => 'required',
            'room_number' => 'required|integer',
            'direction_id' => 'required|integer',
            'cover' => 'required',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề',
            'title.unique' => 'Tiêu đề đã tồn tại',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'content.required' => 'Vui lòng nhập nội dung',
            'province_id.required' => 'Vui lòng chọn tỉnh thành',
            'province_id.integer' => ' Tỉnh/thành phố phải là số nguyên',
            'district_id.required' => 'Vui lòng chọn quận/huyện',
            'district_id.integer' => ' Quận/huyện phải là số nguyên',
            'address.required' => 'Vui lòng thêm địa chỉ',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự',
            'acreage.required' => 'Vui lòng thêm diện tích',
            'acreage.max' => 'Diện tích không được vượt quá 255 ký tự',
            'price.required' => 'Vui lòng nhập giá',
            'price.integer' => 'Giá phải là số',
            'map.url' => 'Bắt buộc phải là URL',
            'status.integer' => 'Trạng thái phải là số nguyên',
            'characteristics.required' => 'Vui lòng chọn đặc điểm',
            'room_number.required' => 'Vui lòng thêm số phòng',
            'room_number.integer' => ' Số phòng là số nguyên',
            'direction_id.required' => 'Vui lòng chọn hướng nhà',
            'direction_id.integer' => ' Hướng nhà phải là số nguyên.',
        ]);

        $data['user_id'] = Auth::id();
        $check = Post::insert($data);

        if ($check) {
            return back()->with('msgSuccess', 'Tạo mới thành công');
        }
        return back()->with('msgError', 'Tạo mới thất bại');
    }

    public function edit(Request $request, $id)
    {
        $post = Post::withTrashed()->find($id);

        if (!$post) {
            abort(404);
        }
        return view('admin.post.edit', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|max:255|unique:posts,title,' . $id,
            'content' => 'required',
            'province_id' => 'required|integer',
            'district_id' => 'required|integer',
            'address' => 'required|max:255',
            'acreage' => 'required|max:255',
            'price' => 'required|integer',
            'map' => 'nullable|url',
            'status' => 'integer',
            'characteristics' => 'required',
            'room_number' => 'required|integer',
            'direction_id' => 'required|integer',
            'cover' => 'required',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề',
            'title.unique' => 'Tiêu đề đã tồn tại',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'content.required' => 'Vui lòng nhập nội dung',
            'province_id.required' => 'Vui lòng chọn tỉnh thành',
            'province_id.integer' => ' Tỉnh/thành phố phải là số nguyên',
            'district_id.required' => 'Vui lòng chọn quận/huyện',
            'district_id.integer' => ' Quận/huyện phải là số nguyên',
            'address.required' => 'Vui lòng thêm địa chỉ',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự',
            'acreage.required' => 'Vui lòng thêm diện tích',
            'acreage.max' => 'Diện tích không được vượt quá 255 ký tự',
            'price.required' => 'Vui lòng nhập giá',
            'price.integer' => 'Giá phải là số',
            'map.url' => 'Bắt buộc phải là URL',
            'status.integer' => 'Trạng thái phải là số nguyên',
            'characteristics.required' => 'Vui lòng chọn đặc điểm',
            'room_number.required' => 'Vui lòng thêm số phòng',
            'room_number.integer' => ' Số phòng là số nguyên',
            'direction_id.required' => 'Vui lòng chọn hướng nhà',
            'direction_id.integer' => ' Hướng nhà phải là số nguyên.',
        ]);

        $data['user_id'] = Auth::id();
        $check = Post::withTrashed()->where('id', $id)->update($data);

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

    public function news()
    {
        $news = Post::all();
        return view('admin.post.news', compact('news'));
    }

    public function detail(Request $request, $id)
    {
        $post = Post::withTrashed()->find($id);

        if (!$post) {
            abort(404);
        }
        return view('admin.post.detail', compact('post'));
    }
}
