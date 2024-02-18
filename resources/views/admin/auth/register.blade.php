@extends('admin.layout.index')
@section('title', 'Đăng ký')

@section('content')
    <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center p-5">
            <div class="w-100 d-flex justify-content-center">
                <img src="../../assets/img/illustrations/girl-with-laptop-light.png" class="img-fluid" alt="Login image"
                    width="700" data-app-dark-img="illustrations/girl-with-laptop-dark.png"
                    data-app-light-img="illustrations/girl-with-laptop-light.png" />
            </div>
        </div>
        <!-- /Left Text -->

        <!-- Đăng ký -->
        <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4">
            <div class="w-px-400 mx-auto">

                <h4 class="mb-2">Tạo tài khoản! 👋</h4>
                <p class="mb-4">Vui lòng nhập đầy đủ thông tin của bạn.</p>

                <form id="formAuthentication" class="mb-3" action="{{ route('auth.handleRegister') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Họ và tên</label>
                        <input type="text"
                            class="form-control @error('full_name')
              is-invalid
          @enderror "
                            id="full_name" name="full_name" value="{{ old('full_name') }}"
                            placeholder="Nhập họ và tên của bạn" autofocus />
                        @error('full_name')
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                <div data-field="full_name" data-validator="notEmpty">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email"
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
                    <div class="mb-3">
                        <label for="phone" class="form-label">SDT</label>
                        <input type="text"
                            class="form-control @error('phone')
              is-invalid
          @enderror "
                            id="phone" name="phone" value="{{ old('phone') }}" placeholder="Nhập phone của bạn"
                            autofocus />
                        @error('phone')
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                <div data-field="phone" data-validator="notEmpty">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="CCCD" class="form-label">CCCD/CMND</label>
                        <input type="CCCD"
                            class="form-control @error('CCCD')
              is-invalid
          @enderror " id="CCCD"
                            name="CCCD" value="{{ old('CCCD') }}" placeholder="Nhập CCCD/CMND của bạn" autofocus />
                        @error('CCCD')
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                <div data-field="CCCD" data-validator="notEmpty">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="referralCode" class="form-label">Mã giới thiệu</label>
                        <input type="referralCode"
                            class="form-control @error('referralCode')
              is-invalid
          @enderror "
                            id="referralCode" name="referralCode" value="{{ old('referralCode') }}"
                            placeholder="Nhập mã giới thiệu" autofocus />
                        @error('referralCode')
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                <div data-field="referralCode" data-validator="notEmpty">{{ $message }}</div>
                            </div>
                        @enderror
                    </div>
                    <div class="mb-3 form-password-toggle">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password">Mật khẩu</label>
                        </div>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password"
                                class="form-control @error('password') is-invalid  @enderror" name="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                        @error('password')
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                <div data-field="password" data-validator="notEmpty">{{ $message }}</div>
                            </div>
                        @enderror

                    </div>
                    <div class="mb-3 form-password-toggle">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password_confirmation">Mật khẩu</label>
                        </div>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid  @enderror"
                                name="password_confirmation"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password_confirmation" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                        @error('password_confirmation')
                            <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                <div data-field="password_confirmation" data-validator="notEmpty">{{ $message }}</div>
                            </div>
                        @enderror
                        @if (session('success'))
                            <p class="text-success my-2">{{ session('success') }}</p>
                        @endif
                    </div>

                    <button class="btn btn-primary d-grid w-100">Đăng ký</button>
                </form>
                <p class="text-center">
                    <span>Bạn đã có tài khoản?</span>
                    <a href="{{ route('auth.login') }}">
                        <span>Đăng nhập</span>
                    </a>
                </p>



            </div>
        </div>
        <!-- /Đăng ký -->
    </div>
@endsection
