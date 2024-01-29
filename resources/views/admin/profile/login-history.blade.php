@extends('admin.layout.index')
@section('title', 'Lịch sử đăng nhập')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Bảng điều khiển</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Lịch sử đăng nhập</a>
            </li>
            <li class="breadcrumb-item active">{{ Auth::user()->full_name }}</li>
        </ol>
    </nav>
    <!-- Header -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="user-profile-header-banner">
                    <img src="{{ asset('admin-frontend') }}/assets/img/pages/profile-banner.png" alt="Banner image"
                        class="rounded-top" />
                </div>
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-4">
                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img src="{{ Auth::user()->avatar ? Auth::user()->avatar : asset('admin-frontend/assets/img/upload.png') }}"
                            alt="user image" class="d-block  ms-0 ms-sm-4 rounded user-profile-img object-fit-cover "
                            width="120" height="120" id="preview" />

                    </div>
                    <div class="flex-grow-1 mt-3 mt-sm-5">
                        <div
                            class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-4 flex-md-row flex-column gap-4">
                            <div class="user-profile-info">
                                <h4>{{ Auth::user()->full_name }}</h4>
                                <ul
                                    class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-2">
                                    <li class="list-inline-item fw-medium"><i class="bx bx-pen"></i> Vai trò:
                                        {{ Auth::user()->group->name }}</li>
                                    <li class="list-inline-item fw-medium">
                                        <i class="bx bx-calendar-alt"></i> Tham gia
                                        {{ Auth::user()->created_at->format('m Y') }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Header -->
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link " href="{{ route('dashboard.profile.index') }}"><i class="bx bx-user me-1"></i>
                        Tài khoản</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href=" {{ route('dashboard.profile.change-password') }}"><i
                            class="bx bx-lock-alt me-1"></i>
                        Đổi mật khẩu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  active" href=" {{ route('dashboard.profile.login-history') }}"><i
                            class='bx bx-history me-1'></i>
                        Lịch sử đăng nhập</a>
                </li>

            </ul>
        </div>
    </div>
    <section class="card">
        <div class="card-body">
            <div class="card-datatable table-responsive">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Ngày đăng nhâp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($histories as $index => $item)
                            <tr>
                                <td>
                                    {{ $index + 1 }}
                                </td>
                                <td>
                                    <p class="m-0 badge bg-label-success">
                                        {{ $item->created_at->format('d M Y') }} -
                                        {{ $item->created_at->format('h:i A') }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $histories->links() }}
        </div>
    </section>
@endsection
