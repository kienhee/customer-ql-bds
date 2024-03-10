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
            <div class="row mb-3 mx-2 g-3 mt-3">
                <div class="col-sm-3">
                    <label for="search_email" class="form-label">Tìm kiếm email:</label>
                    <input type="search" class="form-control" id="search_email" placeholder="Nhập email để tìm kiếm">
                </div>
                <div class="col-sm-3">
                    <label for="search_phone" class="form-label">Tìm kiếm số điện thoại:</label>
                    <input type="search" class="form-control" id="search_phone"
                        placeholder="Nhập số điện thoại để tìm kiếm">
                </div>
                <div class="col-sm-3">
                    <label for="search_role" class="form-label">Vai trò:</label>
                    <select class="form-select" id="search_role">
                        <option value="">Chọn vai trò</option>
                        @foreach (groups() as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach

                    </select>
                </div>
                {{-- <div class="col-sm-3">
                    <label for="search_region" class="form-label">Miền:</label>
                    <select class="form-select" id="search_region">
                        <option value="">Chọn trạng thái</option>
                        @foreach (regions() as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="search_province" class="form-label">Tỉnh thành:</label>
                    <select class="form-select" id="search_province">
                        <option value="">Chọn trạng thái</option>
                        @foreach (provinces() as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <label for="search_district" class="form-label">quận/huyện:</label>
                    <select class="form-select" id="search_district">
                        <option value="">Chọn trạng thái</option>
                        @foreach (districts() as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="col-sm-3">
                    <label for="search_status" class="form-label">Trạng thái:</label>
                    <select class="form-select" id="search_status">
                        <option value="">Chọn trạng thái</option>
                        <option value="active">Hoạt động</option>
                        <option value="suspended">Đình chỉ</option>
                    </select>
                </div>
            </div>
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
                ajax: {
                    url: '{!! route('dashboard.users.list') !!}',
                    data: function(d) {
                        d.search_email = $('#search_email').val();
                        d.search_phone = $('#search_phone').val();
                        d.search_status = $('#search_status').val();
                        d.search_role = $('#search_role').val();
                    }
                },
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
                    $('#users-table_filter input').attr('placeholder', 'Tìm kiếm theo tên');

                    $('#search_status').on('change', function() {
                        // Gửi dữ liệu tìm kiếm trạng thái đơn hàng tới controller qua Ajax
                        $('#users-table').DataTable().draw();
                    });
                    $('#search_role').on('change', function() {
                        // Gửi dữ liệu tìm kiếm trạng thái đơn hàng tới controller qua Ajax
                        $('#users-table').DataTable().draw();
                    });

                    // Lắng nghe sự kiện khi nhập liệu vào ô tìm kiếm email
                    $('#search_email').on('keyup', function() {
                        // Gửi dữ liệu tìm kiếm email tới controller qua Ajax
                        $('#users-table').DataTable().draw();
                    });
                    // Lắng nghe sự kiện khi nhập liệu vào ô tìm kiếm số điện thoại
                    $('#search_phone').on('keyup', function() {
                        // Gửi dữ liệu tìm kiếm số điện thoại tới controller qua Ajax
                        $('#users-table').DataTable().draw();
                    });
                },
            });
        });
    </script>
@endsection
