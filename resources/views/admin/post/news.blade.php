@extends('admin.layout.index')
@section('title', 'Bản tin')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Bảng điều khiển</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Bản tin</a>
            </li>
            <li class="breadcrumb-item active">Tất cả</li>
        </ol>
    </nav>
    <div class="card mb-4">
        <div class="card-header d-flex flex-wrap justify-content-between gap-3">
            <div class="card-title mb-0 me-1">
                <h5 class="mb-1">Bản tin</h5>
                <p class="text-muted mb-0">Total 6 course you have purchased</p>
            </div>
            <div class="d-flex justify-content-md-end align-items-center gap-3 flex-wrap">

                <a href="{{ route('dashboard.posts.add') }}" class="btn btn-outline-primary">
                    <i class="fa-solid fa-plus"></i> &nbsp;Bài viết mới
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class=" mb-4">
                <div class="row g-3">
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label class="form-label">Bài viết:</label>
                        <input type="text" class="form-control  @error('title') invalid @enderror" id="title"
                            placeholder="Tìm kiếm theo tên bài viết" name="title" value="{{ old('title') }}" />
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="province_id" class="form-label">Tỉnh thành: <span class="text-danger">*</span></label>
                        <select id="province_id"
                            class="select2 form-select form-select-lg @error('province_id') is-invalid @enderror"
                            data-allow-clear="true" name="province_id" data-placeholder="Vui lòng chọn tỉnh">
                            <option value="">Vui lòng tỉnh thành</option>
                            @foreach (provices() as $provice)
                                <option value="{{ $provice->id }}"
                                    @if (old('province_id') == $provice->id) @selected(true) @endif>
                                    {{ $provice->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="district_id" class="form-label">Quận/Huyện: <span class="text-danger">*</span></label>
                        <select id="district_id"
                            class="select2 form-select form-select-lg @error('district_id') is-invalid @enderror"
                            data-allow-clear="true" name="district_id" data-placeholder="Vui lòng chọn quận/huyện">
                            <option value="">Vui lòng chọn quận/huyện</option>
                            @foreach (districts() as $district)
                                <option value="{{ $district->id }}"
                                    @if (old('district_id') == $district->id) @selected(true) @endif>
                                    {{ $district->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label class="form-label">Địa chỉ:</label>
                        <input type="text" class="form-control  @error('title') invalid @enderror" id="title"
                            placeholder="Địa chỉ" name="title" value="{{ old('title') }}" />
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label class="form-label">Số phòng:</label>
                        <input type="text" class="form-control  @error('title') invalid @enderror" id="title"
                            placeholder="Số phòng" name="title" value="{{ old('title') }}" />
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="direction_id" class="form-label">Hướng: <span class="text-danger">*</span></label>
                        <select id="direction_id"
                            class="select2 form-select form-select-lg @error('direction_id') is-invalid @enderror"
                            data-allow-clear="true" name="direction_id" data-placeholder="Vui lòng chọn hướng">
                            <option value="">Vui lòng chọn hướng</option>
                            @foreach (directions() as $direction)
                                <option value="{{ $direction->id }}"
                                    @if (old('direction_id') == $direction->id) @selected(true) @endif>
                                    {{ $direction->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
            <hr class="mb-5">
            <div class="row gy-4 mb-4">
                @foreach ($news as $post)
                    <div class="col-sm-6 col-lg-4">

                        <div class="card p-2 h-100 shadow-none border">

                            <div class="rounded-2 text-center mb-3">
                                <a href="{{ route('dashboard.posts.detail', $post->id) }}">
                                    <img class="object-fit-cover" src="{{ $post->cover }}" alt="{{ $post->title }}"
                                        height="250" width="100%" /></a>
                            </div>
                            <div class="card-body p-3 pt-2">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <p class="d-flex align-items-center mb-0">
                                        <i
                                            class='bx bx-calendar me-1'></i><small>{{ $post->created_at->format('d/m/y - h:m') }}&nbsp;</small>
                                        @if (now()->startOfDay()->eq($post->created_at->startOfDay()))
                                            - &nbsp;<span class="badge bg-label-success"> Mới nhất</span>
                                        @else
                                            - <small>&nbsp;{{ $post->created_at->diffForHumans() }}</small>
                                        @endif

                                    </p>
                                    @if ($post->status == '1')
                                        <span class="badge bg-label-success">Bán mạnh</span>
                                    @endif
                                    @if ($post->status == '2')
                                        <span class="badge bg-label-danger">Đã bán</span>
                                    @endif
                                    @if ($post->status == '3')
                                        <span class="badge bg-label-danger">Chủ tự bán</span>
                                    @endif
                                </div>

                                <div class="truncate-3 mb-3  text-break">
                                    <a href="{{ route('dashboard.posts.detail', $post->id) }}"
                                        class="h5 d-block ">{{ $post->title }}</a>
                                </div>

                                <div class="truncate-3 mb-3 fw-lighter text-break" style="font-size: 14px">
                                    {!! $post->content !!}
                                </div>


                                <div class="d-flex justify-content-between align-items-center ">

                                    <div class="d-flex justify-content-start align-items-center">
                                        <div class="avatar-wrapper">
                                            <div class="avatar avatar-sm me-3"><img
                                                    src="{{ getThumb($post->user->avatar) }}" alt="Avatar"
                                                    class="rounded-circle"></div>
                                        </div>
                                        <div class="d-flex flex-column"><a href="javascript:void(0)"
                                                class="text-body text-truncate"><span
                                                    class="fw-medium">{{ $post->user->full_name }}</span></a>
                                            <small class="text-truncate text-muted">{{ $post->user->email }}</small>
                                        </div>
                                    </div>


                                    <a href="javascript:void(0)" class="text-secondary text-nowrap d-inline-block"><i
                                            class=' tf-icons bx bx-bookmark fs-4'></i>
                                        <span class="badge rounded-pill bg-info text-white badge-notifications">10</span>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
            <nav aria-label="Page navigation" class="d-flex align-items-center justify-content-center">
                <ul class="pagination">
                    <li class="page-post prev">
                        <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevron-left"></i></a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="javascript:void(0);">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);">4</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0);">5</a>
                    </li>
                    <li class="page-item next">
                        <a class="page-link" href="javascript:void(0);"><i class="tf-icon bx bx-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>


@endsection
