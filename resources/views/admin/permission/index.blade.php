@extends('admin.layout.index')
@section('title', 'Quyền hạn')
@section('content')
    <x-notice />
    <h4 class="py-3 mb-2">Danh sách vai trò</h4>
    <p>
        Một vai trò cung cấp quyền truy cập vào các menu và tính năng được xác định trước, để tùy thuộc vào <br />
        vai trò được chỉ định, một quản trị viên có thể truy cập vào những gì người dùng cần.
    </p>
    <!-- Các thẻ vai trò -->
    <div class="row g-4 align-items-center mb-3">
        @foreach ($roleList as $item)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <h6 class="fw-normal">Tổng số {{ $item['length'] }} người dùng</h6>
                            @if (count($item['users']) > 0)
                                <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                    @foreach ($item['users'] as $user)
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                            title="{{ $user->full_name }}" class="avatar avatar-sm pull-up">
                                            <img class="rounded-circle object-fit-cover"
                                                src="{{ $user->avatar ? getThumb($user->avatar) : asset('admin-frontend/assets/img/avatar.png') }}"
                                                alt="Avatar" />
                                        </li>
                                    @endforeach


                                </ul>
                            @endif

                        </div>
                        <div class="d-flex justify-content-between align-items-end">
                            <div class="role-heading">
                                <h4 class="mb-1">{{ $item['group']->name }}</h4>
                                @can('update', App\Models\Group::class)
                                    <a href="{{ route('dashboard.permission.edit-role', $item['group']->id) }}"><small>Chỉnh
                                            sửa vai trò</small></a>
                                @endcan
                            </div>
                            @can('delete', App\Models\Group::class)
                                <form action="{{ route('dashboard.permission.delete-role', $item['group']->id) }}"
                                    method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn?')">
                                    @csrf
                                    @method('delete')
                                    <button class="btn text-muted p-0"><i class="bx bx-trash me-1"></i></button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @can('create', App\Models\Group::class)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card h-100">
                    <div class="row h-100">
                        <div class="col-sm-5">
                            <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                                <img src="{{ asset('admin-frontend') }}/assets/img/illustrations/sitting-girl-with-laptop-light.png"
                                    class="img-fluid" alt="Image" width="120"
                                    data-app-light-img="illustrations/sitting-girl-with-laptop-light.png"
                                    data-app-dark-img="illustrations/sitting-girl-with-laptop-dark.png" />
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="card-body text-sm-end text-center ps-sm-0">

                                <a class="btn btn-primary mb-3 text-nowrap add-new-role"
                                    href="{{ route('dashboard.permission.add-role') }}"><i class="fa-solid fa-plus"></i>
                                    &nbsp;Thêm Vai trò Mới</a>
                                <p class="mb-0">Thêm vai trò nếu nó chưa tồn tại</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
    </div>
    <!--/ Các thẻ vai trò -->



    @if (Auth::user()->group_id == 0)
        <h4 class="py-3 mb-2">Danh sách quyền hạn</h4>
        <p>
            Chỉ sử dụng trong quá trình phát triển và chỉ bởi các tài khoản của nhà phát triển.
        </p>
        <!-- Bảng quyền hạn -->
        <div class="card">

            <div class="card-header border-bottom d-flex align-items-center justify-content-end">
                <button class="dt-button add-new btn btn-primary mb-3 mb-md-0" tabindex="0"
                    aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal"
                    data-bs-target="#addPermissionModal"><span><i class="fa-solid fa-plus"></i> &nbsp; Thêm
                        Quyền Hạn</span></button>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-permissions table border-top" id="permission-table">
                    <thead>
                        <tr>
                            <th>tên</th>
                            <th>đường dẫn</th>
                            <th>mô tả</th>
                            <th>đã tạo lúc</th>
                            <th>hành động</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!--/ Bảng quyền hạn -->

        <!-- Modal -->
        <!-- Modal Thêm Quyền Hạn -->
        <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-simple">
                <div class="modal-content p-3 p-md-5">
                    <div class="modal-body">
                        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                        <div class="text-center mb-4">
                            <h3>Thêm Quyền Hạn Mới</h3>
                            <p>Những quyền bạn có thể sử dụng và gán cho người dùng của bạn.</p>
                        </div>

                        <div class="alert alert-danger d-none" id="alert-error">
                            <ul id="list-error" class="mb-0">
                            </ul>
                        </div>
                        <div class="alert alert-success d-none" id="alert-success"></div>
                        <form id="addPermissionForm" class="row" onsubmit="return false">
                            <div class="col-12 mb-3">
                                <label class="form-label" for="title">Tên Quyền Hạn</label>
                                <input type="text" id="title" name="title" class="form-control"
                                    placeholder="Tên Quyền Hạn" name="title" autofocus />
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="route">Đường Dẫn</label>
                                <input type="text" id="route" name="route" class="form-control"
                                    placeholder="Đường Dẫn" name="route" />
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label" for="description">Mô Tả</label>
                                <textarea class="form-control" id="description" placeholder="Mô Tả" name="description" rows="3"></textarea>
                            </div>
                            <div class="col-12 text-center demo-vertical-spacing">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">Tạo Quyền Hạn</button>
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    Hủy Bỏ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
@section('script')
    <script>
        $(function() {
            let table = $('#permission-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('dashboard.permission.list-permission') !!}',
                columns: [{
                        data: 'title',
                        name: 'title',
                        orderable: false,
                    },
                    {
                        data: 'route',
                        name: 'route',
                        orderable: false,
                    },
                    {
                        data: 'description',
                        name: 'description',
                        orderable: false,
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
                    ] // 4 corresponds to the index of the 'created_at' column in the 'columns' array
                ],
                initComplete: function() {
                    // Customize the search input placeholder
                    $('#users-table_filter input').attr('placeholder', 'Tìm kiếm');
                },
            });


            FormValidation.formValidation(document.getElementById('addPermissionForm'), {
                fields: {
                    title: {
                        validators: {
                            notEmpty: {
                                message: 'Vui lòng nhập tên quyền hạn'
                            }
                        }
                    },
                    route: {
                        validators: {
                            notEmpty: {
                                message: 'Vui lòng nhập đường dẫn'
                            }
                        }
                    },

                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        // Use this for enabling/changing valid/invalid class
                        // eleInvalidClass: '',
                        eleValidClass: '',
                        rowSelector: '.col-12'
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    // Submit the form when all fields are valid
                    // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    autoFocus: new FormValidation.plugins.AutoFocus()
                }

            }).on('core.form.valid', function() {

                FormValidation.utils.fetch('{{ route('dashboard.permission.add-permission') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    params: {
                        title: $('#title').val(),
                        route: $('#route').val(),
                        description: $('#description').val(),
                    },
                }).then(function(response) {

                    if (response.errors) {
                        $('#alert-success').addClass('d-none')
                        $('#alert-error').removeClass('d-none');
                        let html = '';
                        let errorArr = parseServerError(response);
                        errorArr.forEach(error => {
                            html += `<li>${error}</li>`
                        });
                        $('#list-error').html(html)
                    } else {
                        $('#alert-error').addClass('d-none')
                        let result = $('#alert-success')
                        result.removeClass('d-none');
                        result.text(response.message);
                        table.ajax.reload();
                        $('#addPermissionForm')[0].reset();
                    }

                })
            });


        });

        function parseServerError(errorData) {
            let errors = errorData.errors || {};
            let errorArray = [];

            // Lặp qua từng trường trong đối tượng lỗi
            for (let field in errors) {
                if (errors.hasOwnProperty(field)) {
                    // Thêm mỗi thông báo lỗi vào mảng lỗi
                    errors[field].forEach(function(errorMessage) {
                        errorArray.push(errorMessage);
                    });
                }
            }

            return errorArray;
        }
    </script>
@endsection
