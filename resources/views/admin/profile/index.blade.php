@extends('admin.layout.index')
@section('title', Auth::user()->full_name)
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Bảng điều khiển</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Hồ sơ người dùng</a>
            </li>
            <li class="breadcrumb-item active">{{ Auth::user()->full_name }}</li>
        </ol>
    </nav>
    <form class="row pt-0" action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
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
                                        <li class="list-inline-item fw-medium"><i class="bx bx-pen"></i> Cấp bậc:
                                            {{ Auth::user()->group->name }}</li>
                                        <li class="list-inline-item fw-medium">
                                            <i class="bx bx-calendar-alt"></i> Tham gia
                                            {{ Auth::user()->created_at->format('m Y') }}
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <label for="upload" class="btn btn-outline-primary" tabindex="0">
                                        <span class="d-none d-sm-block"><i class='bx bx-cloud-upload'></i>&nbsp;Tải lên ảnh
                                            đại diện</span>
                                        <input type="file" id="upload" class="account-file-input" hidden
                                            name="avatar" accept="image/png, image/jpeg" />
                                        <input type="hidden" name="avatar" value="{{ Auth::user()->avatar }}">
                                    </label>

                                </div>

                            </div>
                        </div>
                    </div>
                    @error('avatar')
                        <p class="text-danger mx-3 mt-1 fs-6">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <!--/ Header -->
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('dashboard.profile.index') }}"><i
                                class="bx bx-user me-1"></i>
                            Tài khoản</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href=" {{ route('dashboard.profile.change-password') }}"><i
                                class="bx bx-lock-alt me-1"></i>
                            Đổi mật khẩu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href=" {{ route('dashboard.profile.login-history') }}"><i
                                class='bx bx-history me-1'></i>
                            Lịch sử đăng nhập</a>
                    </li>

                </ul>
            </div>
        </div>

        <div class="row">
            <!-- User Sidebar -->
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                <!-- User Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h6 class="pb-2 border-bottom mb-4"><i class='bx bx-link'></i> Social </h6>
                        <div class="row g-3">
                            <div class="col-sm-12">
                                <label class="form-label" for="facebook">Facebook</label>
                                <input type="text" id="facebook" name="facebook"
                                    value="{{ old('facebook') ?? Auth::user()->facebook }}"
                                    class="form-control form-control-sm @error('facebook') invalid @enderror"
                                    placeholder="https://facebook.com/abc">
                                @error('facebook')
                                    <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label" for="instagram">instagram</label>
                                <input type="text" id="instagram" name="instagram"
                                    value="{{ old('instagram') ?? Auth::user()->instagram }}"
                                    class="form-control form-control-sm @error('instagram') invalid @enderror"
                                    placeholder="https://instagram.com/abc">
                                @error('instagram')
                                    <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-sm-12">
                                <label class="form-label" for="linkedin">LinkedIn</label>
                                <input type="text" id="linkedin" name="linkedin"
                                    value="{{ old('linkedin') ?? Auth::user()->linkedin }}"
                                    class="form-control form-control-sm @error('linkedin') invalid @enderror"
                                    placeholder="https://linkedin.com/abc">
                                @error('linkedin')
                                    <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /User Card -->
            </div>
            <!--/ User Sidebar -->
            <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">

                <div class="card">

                    <div class="card-body">
                        <x-notice />

                        <div class="mb-3">
                            <label class="form-label" for="full_name">Họ và tên: <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('full_name') invalid @enderror"
                                value="{{ old('full_name') ?? Auth::user()->full_name }}" name="full_name"
                                id="full_name" placeholder="John Doe">
                            @error('full_name')
                                <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">Email: <span class="text-danger">*</span></label>
                            <input type="email"
                                class="form-control @error('email')
                                invalid
                            @enderror"
                                value="{{ old('email') ?? Auth::user()->email }}" id="email" name="email"
                                placeholder="john.doe@example.com" readonly disabled>
                            @error('email')
                                <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="phone">SDT: <span class="text-danger">*</span></label>
                            <input type="phone"
                                class="form-control @error('phone')
                                invalid
                            @enderror"
                                value="{{ old('phone') ?? Auth::user()->phone }}" id="phone" name="phone"
                                placeholder="+1 (609) 988-44-11">
                            @error('phone')
                                <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="email">Cấp bậc: </label>
                            <input type="text" class="form-control " value="{{ Auth::user()->group->name }}" readonly
                                disabled>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary ms-auto ">Save change</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </form>
@endsection
@section('script')
    <script>
        let imgInp = document.getElementById('upload');
        let preview = document.getElementById('preview');
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                preview.src = URL.createObjectURL(file)
            }
        }
    </script>
@endsection
