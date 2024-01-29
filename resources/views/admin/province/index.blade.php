@extends('admin.layout.index')
@section('title', 'Người dùng')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Bảng điều khiển</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Quản lý Tỉnh thành</a>
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
            <h5 class="card-title mb-0">Quản lý Tỉnh thành</h5>
            @can('create', App\Models\Province::class)
                <a href="{{ route('dashboard.provinces.add') }}" class="btn btn-outline-primary">
                    <i class="fa-solid fa-plus"></i> &nbsp;Thêm Tỉnh thành
                </a>
            @endcan
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-provinces table border-top" id="provinces-table">
                <thead>
                    <tr>
                        <th style="width: 10px">ID</th>
                        <th>Tên tỉnh thành</th>
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
            $('#provinces-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('dashboard.provinces.list') !!}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    }, {
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
                    [3,
                        'desc'
                    ] 
                ],
                initComplete: function() {
                    // Tùy chỉnh vị trí placeholder cho ô tìm kiếm
                    $('#provinces-table_filter input').attr('placeholder', 'Tìm kiếm tên tỉnh');
                },
            });
        });
    </script>
@endsection
