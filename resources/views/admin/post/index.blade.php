@extends('admin.layout.index')
@section('title', 'Quản lý Bài viết')
@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Bảng điều khiển</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Quản lý Bài viết</a>
            </li>
            <li class="breadcrumb-item active">Danh sách</li>
        </ol>
    </nav>
    <!-- Bảng Danh sách Bài viết -->
    <div class="card">
        <div class="px-3 pt-2">
            <x-notice />
        </div>
        <div class="card-header border-bottom d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">Quản lý Bài viết</h5>
            @can('create', App\Models\Post::class)
                <a href="{{ route('dashboard.posts.add') }}" class="btn btn-outline-primary">
                    <i class="fa-solid fa-plus"></i> &nbsp;Bài viết mới
                </a>
            @endcan
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-posts table border-top" id="posts-table">
                <thead>
                    <tr>
                        <th style="width: 10px">ID</th>
                        <th style="width: 300px">Bài viết</th>
                        <th>Người đăng</th>
                        <th>Tình trạng</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th style="width: 50px">Thao tác</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            $('#posts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('dashboard.posts.list') !!}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'author',
                        name: 'author',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status_1',
                        name: 'status',
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'deleted_at',
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [5,
                        'desc'
                    ] // 4 tương ứng với chỉ số của cột 'created_at' trong mảng 'columns'
                ],
                initComplete: function() {
                    // Tùy chỉnh vị trí placeholder cho ô tìm kiếm
                    $('#posts-table_filter input').attr('placeholder', 'Tìm kiếm');
                },
            });
        });
    </script>
@endsection
