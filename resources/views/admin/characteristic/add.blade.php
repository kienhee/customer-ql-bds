@extends('admin.layout.index')
@section('title', 'Thêm Đặc điểm mới')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Bảng điều khiển</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Đặc điểm</a>
            </li>
            <li class="breadcrumb-item active">Thêm mới</li>
        </ol>
    </nav>
    <form class="card" action="{{ route('dashboard.characteristics.store') }}" method="POST" enctype="multipart/form-data">
        @csrf


        <div class="card-body">
            <x-notice />

            <div class=" d-flex align-items-center justify-content-end">
                <a href="{{ route('dashboard.characteristics.index') }}" class="btn btn-outline-primary">
                    <i class='bx bx-list-ul'></i> &nbsp;Quản lý Đặc điểm
                </a>
            </div>
            <div class="row">
                <div class="mb-3 ">
                    <label class="form-label" for="name">Tên Đặc điểm: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') invalid @enderror" value="{{ old('name') }}"
                        name="name" id="name" placeholder=" Mặt phố, ô tô,  kinh doanh, chung cư, dòng tiền, thang máy,...v.v" autofocus>
                    @error('name')
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
