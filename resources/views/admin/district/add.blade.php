@extends('admin.layout.index')
@section('title', 'Thêm quận/huyện mới')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Bảng điều khiển</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Quản lý Quận/Huyện</a>
            </li>
            <li class="breadcrumb-item active">Thêm mới</li>
        </ol>
    </nav>
    <form class="card" action="{{ route('dashboard.districts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf


        <div class="card-body">
            <x-notice />

            <div class=" d-flex align-items-center justify-content-end">
                <a href="{{ route('dashboard.districts.index') }}" class="btn btn-outline-primary">
                    <i class='bx bx-list-ul'></i> &nbsp;Quản lý Quận/Huyện
                </a>
            </div>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="name">Tên Quận/Huyện: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') invalid @enderror" value="{{ old('name') }}"
                        name="name" id="name" placeholder="Vui lòng nhập tên quận/huyện" autofocus>
                    @error('name')
                        <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                    @enderror
                </div>



                <div class="col-md-6 mb-3">
                    <label for="province_id" class="form-label">Tỉnh thành: <span class="text-danger">*</span></label>
                    <select id="province_id"
                        class="select2 form-select form-select-lg @error('province_id') is-invalid @enderror"
                        data-allow-clear="true" name="province_id">
                        @foreach (provinces() as $province)
                            <option value="{{ $province->id }}"
                                @if (old('province_id') == $province->id) @selected(true) @endif>
                                {{ $province->name }}</option>
                        @endforeach
                    </select>
                    @error('province_id')
                        <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary ms-auto ">Thêm Mới</button>
            </div>
        </div>
    </form>
@endsection
