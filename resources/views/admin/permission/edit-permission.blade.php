    @extends('admin.layout.index')
@section('title', 'Chỉnh sửa Quyền hạn')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Bảng điều khiển</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Quyền hạn</a>
            </li>
            <li class="breadcrumb-item active">{{ $module->title }}</li>
        </ol>
    </nav>
    <form action="{{ route('dashboard.permission.update-permission', $module->id) }}" method="POST">
        @csrf
        @method('put')
        <div class="card">
            <div class="card-body">
                <x-notice />
                <div class=" d-flex align-items-center justify-content-end">
                    <a href="{{ route('dashboard.permission.index') }}" class="btn btn-outline-primary">
                        <i class='bx bx-list-ul'></i> &nbsp;Danh sách Quyền hạn
                    </a>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="title">Tên: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') invalid @enderror"
                        value="{{ old('title') ?? $module->title }}" name="title" id="title">
                    @error('title')
                        <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="route">Route: <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('route') invalid @enderror"
                        value="{{ old('route') ?? $module->route }}" name="route" id="route">
                    @error('route')
                        <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="description">Mô tả: </label>

                    <textarea class="form-control @error('description') invalid @enderror" id="description" name="description"
                        rows="3">{{ old('description') ?? $module->description }}</textarea>
                    @error('description')
                        <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary ms-auto ">Lưu thay đổi</button>
                </div>
            </div>

        </div>
    </form>
@endsection
