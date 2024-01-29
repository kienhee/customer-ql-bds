@extends('admin.layout.error')
@section('content')
    <div class="misc-wrapper">
        <h2 class="mb-2 mx-2">Không tìm thấy trang :(</h2>
        <p class="mb-4 mx-2">Oops! 😖 URL yêu cầu không được tìm thấy trên máy chủ này.</p>
        <a href="/" class="btn btn-primary">Quay lại trang chủ</a>
        <div class="mt-3">
            <img src="{{ asset('admin-frontend') }}/assets/img/illustrations/page-misc-error-light.png"
                alt="page-misc-error-light" width="500" class="img-fluid"
                data-app-dark-img="illustrations/page-misc-error-dark.png"
                data-app-light-img="illustrations/page-misc-error-light.png" />
        </div>
    </div>
@endsection
