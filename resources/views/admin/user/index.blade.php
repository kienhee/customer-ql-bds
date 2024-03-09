@extends('admin.layout.index')
@section('title', 'Người dùng')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Bảng điều khiển</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Quản lý Người dùng</a>
            </li>
            <li class="breadcrumb-item active">Danh sách</li>
        </ol>
    </nav>
    <!-- Bảng Danh sách Người dùng -->
    <div class="card">
        <div class="px-3 pt-2">
            <x-notice />
        </div>
        <div class="card-header border-bottom d-flex align-items-center justify-content-between">
            <h5 class="card-title mb-0">Quản lý Người dùng</h5>
            @can('create', App\Models\User::class)
                <a href="{{ route('dashboard.users.add') }}" class="btn btn-outline-primary">
                    <i class="fa-solid fa-plus"></i> &nbsp;Người dùng mới
                </a>
            @endcan
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table border-top" id="users-table">
                <thead>
                    <tr>
                        <th style="width: 10px">ID</th>
                        <th>Người dùng</th>
                        <th>Vai trò</th>
                        <th>Miền</th>
                        <th>Tỉnh</th>
                        <th>Quận/Huyện</th>
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
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('dashboard.users.list') !!}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'full_name',
                        name: 'full_name'
                    },
                    {
                        data: 'role',
                        name: 'role',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'region_id',
                        name: 'region_id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'province_id',
                        name: 'province_id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'district_id',
                        name: 'district_id',
                        orderable: false,
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
                    [4,
                        'desc'
                    ] // 4 tương ứng với chỉ số của cột 'created_at' trong mảng 'columns'
                ],
                initComplete: function() {
                    // Tùy chỉnh vị trí placeholder cho ô tìm kiếm
                    $('#users-table_filter input').attr('placeholder', 'Nhập tên để tìm kiếm');
                },
            });
        });
    </script>
@endsection
