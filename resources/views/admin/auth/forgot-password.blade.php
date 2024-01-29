@extends('admin.layout.index')
@section('title', 'Quên mật khẩu')

@section('content')
    <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
            <div class="w-100 d-flex justify-content-center">
                <img src="{{ asset('admin-frontend') }}/assets/img/illustrations/girl-unlock-password-light.png"
                    class="img-fluid" alt="Login image" width="600"
                    data-app-dark-img="illustrations/girl-unlock-password-dark.png"
                    data-app-light-img="illustrations/girl-unlock-password-light.png" />
            </div>
        </div>
        <!-- /Left Text -->

        <!-- Forgot Password -->
        <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
            <div class="w-px-400 mx-auto">
                <h4 class="mb-2">Quên mật khẩu? 🔒</h4>
                <p class="mb-4">Nhập email của bạn và chúng tôi sẽ gửi cho bạn hướng dẫn để đặt lại mật khẩu của bạn</p>
                <form id="formAuthentication" class="mb-3" action="{{ route('auth.SendMailForgotPassword') }}"
                    method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" placeholder="Nhập email của bạn" value="{{ old('email') }}" autofocus />
                        @error('email')
                            <p class="text-danger my-2">{{ $message }}</p>
                        @enderror
                        @if (session('success'))
                            <p class="text-success my-2">{{ session('success') }}</p>
                        @endif
                    </div>
                    <button id="submitBtn"
                        class="btn btn-primary d-grid w-100 d-flex justify-content-center gap-2 align-items-center"
                        type="submit">
                        <span>Xác nhận</span>
                        <div id="btn_spinner" class="spinner-border spinner-border-sm text-secondary d-none" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </button>
                </form>
                <div class="text-center">
                    <a href="{{ route('auth.login') }}" class="d-flex align-items-center justify-content-center">
                        <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i>
                        Quay lại
                    </a>
                </div>
            </div>
        </div>
        <!-- /Forgot Password -->
    </div>
@endsection
