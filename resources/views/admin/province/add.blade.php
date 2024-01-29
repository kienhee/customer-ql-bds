@extends('admin.layout.index')
@section('title', 'Thêm tỉnh mới')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Bảng điều khiển</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Quản lý Tỉnh thành</a>
            </li>
            <li class="breadcrumb-item active">Thêm mới</li>
        </ol>
    </nav>
    <form class="card" action="{{ route('dashboard.provinces.store') }}" method="POST" enctype="multipart/form-data">
        @csrf


        <div class="card-body">
            <x-notice />

            <div class=" d-flex align-items-center justify-content-end">
                <a href="{{ route('dashboard.provinces.index') }}" class="btn btn-outline-primary">
                    <i class='bx bx-list-ul'></i> &nbsp;Quản lý Tỉnh thành
                </a>
            </div>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="name">Tên tỉnh thành: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') invalid @enderror" value="{{ old('name') }}"
                        name="name" id="name" placeholder="Hà Nội, Hồ Chí Minh,...v.v">
                    @error('name')
                        <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                    @enderror
                </div>


                <div class="mb-3 col-md-6">
                    <label class="form-label" for="region_id">Miền: <span class="text-danger">*</span></label>
                    <select id="region_id" class="form-select @error('region_id') is-invalid @enderror" name="region_id">
                        @foreach (regions() as $region)
                            <option value="{{ $region->id }}"
                                @if (old('region_id') == $region->id) @selected(true) @endif>
                                {{ $region->name }}</option>
                        @endforeach
                    </select>
                    @error('region_id')
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
