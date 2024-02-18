@extends('admin.layout.index')
@section('title', 'Đăng nhập')

@section('content')
    <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
            <div class="w-100 d-flex justify-content-center">
                <img src="../../assets/img/illustrations/boy-with-rocket-light.png" class="img-fluid" alt="Login image"
                    width="700" data-app-dark-img="illustrations/boy-with-rocket-dark.png"
                    data-app-light-img="illustrations/boy-with-rocket-light.png" />
            </div>
        </div>
        <!-- /Left Text -->

        <!-- Đăng nhập -->
        <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
            <div class="w-px-400 mx-auto">

                <h4 class="mb-2">Chào mừng trở lại! 👋</h4>
                <p class="mb-4">Vui lòng đăng nhập vào tài khoản của bạn để bắt đầu công việc.</p>

                <form id="formAuthentication" class="mb-3" action="{{ route('auth.handleLogin') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text"
                            class="form-control @error('email')
              is-invalid
          @enderror "
                            id="email" name="email" value="{{ old('email') }}" placeholder="Nhập email của bạn"
                            autofocus />
                        @error('email')
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                <div data-field="email" data-validator="notEmpty">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3 form-password-toggle">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password">Mật khẩu</label>
                            <a href="{{ route('auth.forgot-password') }}">
                                <small>Quên mật khẩu?</small>
                            </a>
                        </div>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password"
                                class="form-control @error('password')
              is-invalid
          @enderror"
                                name="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                        @error('password')
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                <div data-field="password" data-validator="notEmpty">{{ $message }}</div>
                            </div>
                        @enderror
                        @if (session('success'))
                            <p class="text-success my-2">{{ session('success') }}</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
                            <label class="form-check-label" for="remember-me"> Ghi nhớ tôi </label>
                        </div>
                    </div>
                    <button class="btn btn-primary d-grid w-100">Đăng nhập</button>
                </form>
                <p class="text-center">
                    <span>Bạn chưa có tài khoản?</span>
                    <a href="{{route('auth.register')}}">
                        <span>Tạo tài khoản</span>
                    </a>
                </p>



            </div>
        </div>
        <!-- /Đăng nhập -->
    </div>
@endsection
