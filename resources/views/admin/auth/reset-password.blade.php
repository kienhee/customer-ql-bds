@extends('admin.layout.index')
@section('title', 'Đặt lại Mật khẩu')
@section('content')
    <div class="authentication-inner row m-0">
        <!-- /Văn bản bên trái -->
        <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
            <div class="w-100 d-flex justify-content-center">
                <img src="../../assets/img/illustrations/boy-with-laptop-light.png" class="img-fluid" alt="Hình ảnh đăng nhập"
                    width="600" data-app-dark-img="illustrations/boy-with-laptop-dark.png"
                    data-app-light-img="illustrations/boy-with-laptop-light.png" />
            </div>
        </div>
        <!-- /Văn bản bên trái -->

        <!-- Đặt lại Mật khẩu -->
        <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-4 p-sm-5">
            <div class="w-px-400 mx-auto">
              
                <h4 class="mb-2">Đặt lại Mật khẩu 🔒</h4>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <p class="mb-4">cho <span class="fw-medium">{{ request()->email }}</span></p>
                <form id="formAuthentication" class="mb-3" action="{{ route('auth.PostResetPassword') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ request()->email }}">
                    <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="password">Mật khẩu mới</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                        @error('password')
                            <p class="text-danger my-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="password_confirmation">Xác nhận Mật khẩu</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                name="password_confirmation"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                        @error('password_confirmation')
                            <p class="text-danger my-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button class="btn btn-primary d-grid w-100 mb-3">Đặt mật khẩu mới</button>
                    <div class="text-center">
                        <a href="{{route('auth.login')}}">
                            <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                            Quay lại đăng nhập
                        </a>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Đặt lại Mật khẩu -->
    </div>
@endsection
