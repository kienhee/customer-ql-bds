@extends('admin.layout.index')
@section('title', 'Cập nhật')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Bảng điều khiển</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Quản lý bài viết</a>
            </li>
            <li class="breadcrumb-item active">Cập hật bài viết</li>
        </ol>
    </nav>

    <form class="row" action="{{ route('dashboard.posts.update',$post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div class="col-12 col-lg-8">
            <div class="card mb-4">

                <div class="px-3 pt-2">
                    <x-notice />
                </div>

                <div class="card-header">
                    <h5 class="card-tile mb-0">Thông tin bài viết</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div id="holder" class="mb-3">
                            <img src="{{ $post->cover }}" class="w-100" alt="">
                        </div>
                        <div class="input-group d-flex justify-content-center flex-column align-items-center">
                            <span class="input-group-btn">
                                <a id="cover" data-input="thumbnail" data-preview="holder"
                                    class="btn btn-outline-primary">
                                    <i class='bx bx-cloud-upload'></i>&nbsp;Tải lên ảnh bìa
                                </a>
                            </span>
                            <input id="thumbnail" class="form-control" type="hidden" value="{{ $post->cover }}" name="cover">
                            @error('cover')
                                <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>


                    <div class="mb-3">
                        <label class="form-label" for="title">Tiêu đề bài đăng: <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control  @error('title') invalid @enderror" id="title"
                            placeholder="Tiêu đề bài đăng" name="title" value="{{ old('title') ?? $post->title }}"
                            aria-label="Tiêu đề bài đăng" autofocus />
                        @error('title')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="content">Nội dung bài đăng: <span
                                class="text-danger">*</span></label>
                        <textarea name="content" id="content" class="my-editor @error('content') is-invalid @enderror" cols="30"
                            rows="20">{{ old('content') ?? $post->content }}</textarea>
                        @error('content')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="map">Google map: <span
                                class="text-muted">(option)</span></label>
                        <input type="text" class="form-control @error('map') invalid @enderror"
                            value="{{ old('map') ?? $post->map }}" name="map" id="map"
                            placeholder="https://maps.app.goo.gl/">
                        @error('map')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>


        </div>

        <div class="col-12 col-lg-4">
            <div class="card mb-4">

                <div class=" card-header d-flex align-items-center justify-content-between ">
                    <h5 class="card-title mb-0">Thông tin</h5>
                    <a href="{{ route('dashboard.posts.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class='bx bx-list-ul'></i> &nbsp;Danh sách bài viết
                    </a>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="province_id" class="form-label">Tỉnh thành: <span class="text-danger">*</span></label>
                        <select id="province_id"
                            class="select2 form-select form-select-lg @error('province_id') is-invalid @enderror"
                            data-allow-clear="true" name="province_id" data-placeholder="Vui lòng chọn tỉnh">
                            <option value="">Vui lòng tỉnh thành</option>
                            @foreach (provices() as $provice)
                                <option value="{{ $provice->id }}"
                                    @if (old('province_id') == $provice->id || $post->province_id == $provice->id) @selected(true) @endif>
                                    {{ $provice->name }}</option>
                            @endforeach
                        </select>
                        @error('province_id')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="district_id" class="form-label">Quận/Huyện: <span class="text-danger">*</span></label>
                        <select id="district_id"
                            class="select2 form-select form-select-lg @error('district_id') is-invalid @enderror"
                            data-allow-clear="true" name="district_id" data-placeholder="Vui lòng chọn quận/huyện">
                            <option value="">Vui lòng chọn quận/huyện</option>
                            @foreach (districts() as $district)
                                <option value="{{ $district->id }}"
                                    @if (old('district_id') == $district->id || $post->district_id == $district->id) @selected(true) @endif>
                                    {{ $district->name }}</option>
                            @endforeach
                        </select>
                        @error('district_id')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="address">Địa chỉ chi tiết: <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('address') invalid @enderror"
                            value="{{ old('address') ?? $post->address }}" name="address" id="address"
                            placeholder="Vui lòng nhập địa chỉ cụ thể">
                        @error('address')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="acreage">Diện tích: <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('acreage') invalid @enderror"
                            value="{{ old('acreage') ?? $post->acreage }}" name="acreage" id="acreage"
                            placeholder="Vui lòng nhập diện tích">
                        @error('acreage')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="price">Giá : <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('price') invalid @enderror"
                            value="{{ old('price') ?? $post->price }}" min="0" name="price" id="price"
                            placeholder="Vui lòng nhập giá ">
                        @error('price')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3 col ">
                        <label class="form-label mb-1" for="status">Trạng thái: <span class="text-danger">*</span>
                        </label>
                        <select id="status" class="select2 form-select @error('status') is-invalid @enderror"
                            name="status" data-placeholder="Vui lòng chọn">
                            <option value="1" @if ($post->status == '1') @selected(true) @endif>
                                Bán mạnh</option>
                            <option value="2" @if ($post->status == '2') @selected(true) @endif>
                                Đã bán</option>
                            <option value="3" @if ($post->status == '3') @selected(true) @endif>
                                Chủ tự bán</option>
                        </select>
                        @error('status')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class=" mb-4">
                        <label for="characteristics" class="form-label">Đặc điểm: <span
                                class="text-danger">*</span></label>
                        <input id="characteristics" name="characteristics"
                            class="form-control  @error('characteristics') is-invalid @enderror"
                            placeholder="Mặt phố, ô tô,  kinh doanh,..v.v" value="{{$post->characteristics}}" />
                        @error('characteristics')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                        <input type="hidden" value="{{ characteristics() }}" id="characteristicsData">

                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="room_number">Số phòng: </label>
                        <input type="number" min="1"
                            class="form-control @error('room_number') invalid @enderror"
                            value="{{ old('room_number') ?? $post->room_number }}" name="room_number" id="room_number"
                            placeholder="Vui lòng nhập số phòng">
                        @error('room_number')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="direction_id" class="form-label">Hướng: <span class="text-danger">*</span></label>
                        <select id="direction_id"
                            class="select2 form-select form-select-lg @error('direction_id') is-invalid @enderror"
                            data-allow-clear="true" name="direction_id" data-placeholder="Vui lòng chọn hướng">
                            <option value="">Vui lòng chọn hướng</option>
                            @foreach (directions() as $direction)
                                <option value="{{ $direction->id }}"
                                    @if (old('direction_id') == $direction->id || $post->direction_id == $direction->id) @selected(true) @endif>
                                    {{ $direction->name }}</option>
                            @endforeach
                        </select>
                        @error('direction_id')
                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                        @enderror
                    </div>
                    <button class="btn btn-primary w-100">Lưu thay đổi</button>
                </div>
            </div>


        </div>

    </form>
@endsection
@section('script')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script>
        $('#cover').filemanager('image');
        const characteristics = document.querySelector('#characteristics');
        const whitelist = JSON.parse($('#characteristicsData').val())
        // Inline
        new Tagify(characteristics, {
            whitelist: whitelist,
            maxTags: 10,
            dropdown: {
                maxItems: 20,
                classname: 'tags-inline',
                enabled: 0,
                closeOnSelect: false
            }
        });
    </script>
@endsection
