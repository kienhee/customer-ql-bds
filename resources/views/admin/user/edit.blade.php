@extends('admin.layout.index')
@section('title', 'Chỉnh sửa Người dùng')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Bảng điều khiển</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Quản lý Người dùng</a>
            </li>
            <li class="breadcrumb-item active">{{ $user->full_name }}</li>
        </ol>
    </nav>
    <form class="row pt-0" action="{{ route('dashboard.users.update', $user->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="col-xl-8 col-lg-7 col-md-7 ">

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
                            value="{{ old('full_name') ?? $user->full_name }}" name="full_name" id="full_name"
                            placeholder="Nguyen Van A">
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
                            value="{{ old('email') ?? $user->email }}" id="email" name="email"
                            placeholder="nguyenvana@example.com" readonly disabled>
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
                            value="{{ old('phone') ?? $user->phone }}" id="phone" name="phone"
                            placeholder="Vui lòng nhập số điện thoại">
                        @error('phone')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="group_id">Vai trò Người dùng: <span
                                class="text-danger">*</span></label>
                        <select id="group_id" class="form-select @error('group_id') is-invalid @enderror" name="group_id">
                            <option value="">Vui lòng chọn Vai trò</option>
                            @foreach (groups() as $role)
                                <option value="{{ $role->id }}"
                                    @if (old('group_id') == $role->id || $user->group_id == $role->id) @selected(true) @endif>
                                    {{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('group_id')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="date_of_birth">Sinh nhật: <span class="text-danger">*</span></label>
                        <input type="text" id="date_of_birth" name="date_of_birth"
                            class="form-control dob-picker  @error('date_of_birth')
                                invalid
                            @enderror"
                            placeholder="Vui lòng chọn ngày sinh"
                            value="{{ old('date_of_birth') ?? $user->date_of_birth }}" />
                        @error('date_of_birth')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="CCCD">CCCD/CMND: <span class="text-danger">*</span></label>
                        <input type="text"
                            class="form-control @error('CCCD')
                                invalid
                            @enderror"
                            value="{{ old('CCCD') ?? $user->CCCD }}" id="CCCD" name="CCCD"
                            placeholder="Vui lòng nhập CCCD/CMND">
                        @error('CCCD')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class=" mb-3">
                        <label for="region_id" class="form-label">Miền: <span class="text-danger">*</span></label>
                        <select id="region_id"
                            class="select2 form-select form-select-lg @error('region_id') is-invalid @enderror"
                            data-allow-clear="true" name="region_id">
                            <option value="">Vui lòng chọn</option>
                            @foreach (regions() as $region)
                                <option value="{{ $region->id }}"
                                    @if (old('region_id') == $region->id || $user->region_id == $region->id) @selected(true) @endif>
                                    {{ $region->name }}</option>
                            @endforeach
                        </select>
                        @error('region_id')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class=" mb-3">
                        <label for="province_id" class="form-label">Tỉnh thành: <span class="text-danger">*</span></label>
                        <select id="province_id"
                            class="select2 form-select form-select-lg @error('province_id') is-invalid @enderror"
                            data-allow-clear="true" name="province_id">
                            <option value="">Vui lòng chọn</option>
                            @foreach (provinces() as $province)
                                <option value="{{ $province->id }}"
                                    @if (old('province_id') == $province->id || $user->province_id == $province->id) @selected(true) @endif>
                                    {{ $province->name }}</option>
                            @endforeach
                        </select>
                        @error('province_id')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="district_id" class="form-label">Quận/Huyện: <span
                                class="text-danger">*</span></label>
                        <select id="district_id"
                            class="select2 form-select form-select-lg @error('district_id') is-invalid @enderror"
                            data-allow-clear="true" name="district_id" data-placeholder="Vui lòng chọn quận/huyện">
                            <option value="">Vui lòng chọn quận/huyện</option>
                            @foreach (districtByProvince() as $district)
                                <option value="{{ $district->id }}"
                                    @if (old('district_id') == $district->id || $user->district_id == $district->id) @selected(true) @endif>
                                    {{ $district->name }}</option>
                            @endforeach
                        </select>
                        @error('district_id')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary ms-auto ">Lưu thay đổi</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Thanh bên Người dùng -->
        <div class="col-xl-4 col-lg-5 col-md-5 ">
            <!-- Thẻ Người dùng -->
            <div class="card mb-4">
                <div class="card-body">


                    <h6 class="pb-2 border-bottom mb-4"><i class='bx bx-link'></i> Mạng xã hội <span
                            class="text-muted">(tùy
                            chọn)</span></h6>
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label class="form-label" for="facebook">Facebook</label>
                            <input type="text" id="facebook" name="facebook"
                                value="{{ old('facebook') ?? $user->facebook }}"
                                class="form-control form-control-sm @error('facebook') invalid @enderror"
                                placeholder="https://facebook.com/abc">
                            @error('facebook')
                                <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- <div class="col-sm-12">
                            <label class="form-label" for="instagram">Instagram</label>
                            <input type="text" id="instagram" name="instagram"
                                value="{{ old('instagram') ?? $user->instagram }}"
                                class="form-control form-control-sm @error('instagram') invalid @enderror"
                                placeholder="https://instagram.com/abc">
                            @error('instagram')
                                <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-12">
                            <label class="form-label" for="linkedin">LinkedIn</label>
                            <input type="text" id="linkedin" name="linkedin"
                                value="{{ old('linkedin') ?? $user->linkedin }}"
                                class="form-control form-control-sm @error('linkedin') invalid @enderror"
                                placeholder="https://linkedin.com/abc">
                            @error('linkedin')
                                <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                            @enderror
                        </div> --}}
                    </div>
                </div>
            </div>
            <!-- /Thẻ Người dùng -->

        </div>
        <!--/ Thanh bên Người dùng -->
    </form>
@endsection
@section('script')
    <script>
        let datepickerList = document.querySelectorAll('.dob-picker');
        if (datepickerList) {
            datepickerList.forEach(function(datepicker) {
                datepicker.flatpickr({
                    monthSelectorType: 'static',
                    dateFormat: "d-m-Y",
                });
            });
        }
    </script>
@endsection
