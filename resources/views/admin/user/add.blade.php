@extends('admin.layout.index')
@section('title', 'Thêm Người Dùng Mới')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Bảng điều khiển</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Quản lý Người dùng</a>
            </li>
            <li class="breadcrumb-item active">Thêm mới</li>
        </ol>
    </nav>
    <form class="row pt-0" action="{{ route('dashboard.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Thanh bên Người dùng -->
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <!-- Thẻ Người dùng -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column mb-5">
                            <img class="img-fluid rounded my-4"
                                src="{{ asset('admin-frontend') }}/assets/img/upload.png" height="110" width="110"
                                alt="Avatar Người dùng" id="preview" />
                            <label for="upload" class="btn btn-outline-primary" tabindex="0">
                                <span class="d-none d-sm-block"><i class='bx bx-cloud-upload'></i>&nbsp;Tải lên Avatar</span>
                                <input type="file" id="upload" class="account-file-input" hidden name="avatar"
                                    accept="image/png, image/jpeg" />
                            </label>
                            @error('avatar')
                                <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <h6 class="pb-2 border-bottom mb-4"><i class='bx bx-link'></i> Mạng xã hội <span
                            class="text-muted">(tùy chọn)</span></h6>
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label class="form-label" for="facebook">Facebook</label>
                            <input type="text" id="facebook" name="facebook" value="{{ old('facebook') }}"
                                class="form-control form-control-sm @error('facebook') invalid @enderror"
                                placeholder="https://facebook.com/abc">
                            @error('facebook')
                                <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label" for="instagram">Instagram</label>
                            <input type="text" id="instagram" name="instagram" value="{{ old('instagram') }}"
                                class="form-control form-control-sm @error('instagram') invalid @enderror"
                                placeholder="https://instagram.com/abc">
                            @error('instagram')
                                <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label" for="linkedin">LinkedIn</label>
                            <input type="text" id="linkedin" name="linkedin" value="{{ old('linkedin') }}"
                                class="form-control form-control-sm @error('linkedin') invalid @enderror"
                                placeholder="https://linkedin.com/abc">
                            @error('linkedin')
                                <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Thẻ Người dùng -->

        </div>
        <!--/ Thanh bên Người dùng -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">

            <div class="card">

                <div class="card-body">
                    <x-notice />
                    <div class=" d-flex align-items-center justify-content-end">
                        <a href="{{ route('dashboard.users.index') }}" class="btn btn-outline-primary">
                            <i class='bx bx-list-ul'></i> &nbsp;Quản lý Người dùng
                        </a>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="full_name">Họ và Tên: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('full_name') invalid @enderror"
                            value="{{ old('full_name') }}" name="full_name" id="full_name" placeholder="John Doe">
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
                            value="{{ old('email') }}" id="email" name="email" placeholder="john.doe@example.com">
                        @error('email')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="phone">Số Điện Thoại: <span class="text-danger">*</span></label>
                        <input type="phone"
                            class="form-control @error('phone')
                                invalid
                            @enderror"
                            value="{{ old('phone') }}" id="phone" name="phone" placeholder="+1 (609) 988-44-11">
                        @error('phone')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="group_id">Vai trò Người dùng: <span class="text-danger">*</span></label>
                        <select id="group_id" class="form-select @error('group_id') is-invalid @enderror"
                            name="group_id">
                            <option value="">Vui lòng chọn Vai trò</option>
                            @foreach (groups() as $role)
                                <option value="{{ $role->id }}"
                                    @if (old('group_id') == $role->id) @selected(true) @endif>
                                    {{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('group_id')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-password-toggle mb-3 ">
                        <label class="form-label" for="password">Mật khẩu: <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                            <span id="basic-default-password2" class="input-group-text cursor-pointer"><i
                                    class="bx bx-hide"></i></span>
                        </div>
                        @error('password')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-password-toggle mb-3 ">
                        <label class="form-label" for="password_confirmation">Xác nhận Mật khẩu: <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" name="password_confirmation"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                            <span id="basic-default-password2" class="input-group-text cursor-pointer"><i
                                    class="bx bx-hide"></i></span>
                        </div>
                        @error('password_confirmation')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary ms-auto ">Thêm Mới</button>
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
