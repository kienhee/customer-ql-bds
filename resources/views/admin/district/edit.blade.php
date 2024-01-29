@extends('admin.layout.index')
@section('title', 'Cập nhật')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Bảng điều khiển</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Quản lý Quận/Huyện</a>
            </li>
            <li class="breadcrumb-item active">{{ $district->name }}</li>
        </ol>
    </nav>
    <form class="card" action="{{ route('dashboard.districts.update', $district->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('put')

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
                    <input type="text" class="form-control @error('name') invalid @enderror"
                        value="{{ old('name') ?? $district->name }}" name="name" id="name"
                        placeholder="Vui lòng nhập tên quận/huyện">
                    @error('name')
                        <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                    @enderror
                </div>


                <div class="mb-3 col-md-6">
                    <label class="form-label" for="province_id">Tỉnh thành: <span class="text-danger">*</span></label>
                    <select id="province_id" class="form-select @error('province_id') is-invalid @enderror"
                        name="province_id">
                        @foreach (provices() as $provice)
                            <option value="{{ $provice->id }}"
                                @if (old('provice_id') == $provice->id || $district->province_id == $provice->id) @selected(true) @endif>
                                {{ $provice->name }}</option>
                        @endforeach
                    </select>
                    @error('province_id')
                        <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary ms-auto ">Lưu thay đổi</button>
            </div>
        </div>
    </form>
@endsection
