@extends('admin.layout.error')
@section('content')
    <div class="misc-wrapper">
        <h2 class="mb-2 mx-2">Bạn không được phép truy cập!</h2>
        <p class="mb-4 mx-2">
            Bạn không có quyền xem trang này với thông tin đăng nhập bạn đã cung cấp. <br />
            Vui lòng liên hệ với quản trị viên trang web.
        </p>
        <a href="/" class="btn btn-primary">Quay lại trang chủ</a>
        <div class="mt-5">
            <img src="{{ asset('admin-frontend') }}/assets/img/illustrations/girl-with-laptop-light.png"
                alt="page-misc-not-authorized-light" width="450" class="img-fluid"
                data-app-light-img="illustrations/girl-with-laptop-light.png"
                data-app-dark-img="illustrations/girl-with-laptop-dark.png" />
        </div>
    </div>
@endsection
