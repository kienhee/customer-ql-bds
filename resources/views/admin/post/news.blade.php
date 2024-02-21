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
                <p class="text-muted mb-0">Hãy chọn bộ lọc ở dưới đây</p>
            </div>
            <div class="d-flex justify-content-md-end align-items-center gap-3 flex-wrap">
                @can('create', App\Models\Post::class)
                    <a href="{{ route('dashboard.posts.add') }}" class="btn btn-outline-primary">
                        <i class="fa-solid fa-plus"></i> &nbsp;Bài viết mới
                    </a>
                @endcan
            </div>
        </div>

        <div class="card-body">
            <form method="GET" class=" mb-4">
                <div class="row g-3 mb-4">
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label class="form-label" for="title">Bài viết:</label>
                        <input type="text" class="form-control  @error('title') invalid @enderror" id="title"
                            placeholder="Tìm kiếm theo tên bài viết" name="title" value="{{ Request()->title }}" />
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="province_id" class="form-label">Tỉnh thành: <span class="text-danger">*</span></label>
                        <select id="province_id"
                            class="select2 form-select form-select-lg @error('province_id') is-invalid @enderror"
                            data-allow-clear="true" name="province_id" data-placeholder="Vui lòng chọn tỉnh">
                            <option value="">Vui lòng tỉnh thành</option>
                            @foreach (provinces() as $province)
                                <option value="{{ $province->id }}"
                                    @if (Request()->province_id == $province->id) @selected(true) @endif>
                                    {{ $province->name }}</option>
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
                                    @if (Request()->district_id == $district->id) @selected(true) @endif>
                                    {{ $district->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label class="form-label">Địa chỉ:</label>
                        <input type="text" class="form-control  @error('address') invalid @enderror" id="address"
                            placeholder="Địa chỉ" name="address" value="{{ Request()->address }}" />
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label class="form-label">Số phòng:</label>
                        <input type="text" class="form-control  @error('room_number') invalid @enderror" id="room_number"
                            placeholder="Số phòng" name="room_number" value="{{ Request()->room_number }}" />
                    </div>
                    <div class="col-12 col-sm-6 col-lg-4">
                        <label for="direction_id" class="form-label">Hướng: <span class="text-danger">*</span></label>
                        <select id="direction_id"
                            class="select2 form-select form-select-lg @error('direction_id') is-invalid @enderror"
                            data-allow-clear="true" name="direction_id" data-placeholder="Vui lòng chọn hướng">
                            <option value="">Vui lòng chọn hướng</option>
                            @foreach (directions() as $direction)
                                <option value="{{ $direction->id }}"
                                    @if (Request()->direction_id == $direction->id) @selected(true) @endif>
                                    {{ $direction->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('dashboard.news.index') }}" class="btn btn-secondary">Đặt lại</a>
                    <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                </div>
            </form>
            <hr class="mb-5">
            <div class="row gy-4 mb-4">
                @foreach ($news as $post)
                    <div class="col-sm-6 col-lg-4">

                        <div class="card p-2 h-100 shadow-none border">

                            <div class="rounded-2 text-center mb-3">
                                <a href="{{ route('dashboard.news.detail', $post->id) }}">
                                    <img class="object-fit-cover " src="{{ $post->cover }}" alt="{{ $post->title }}"
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
                                    <a href="{{ route('dashboard.news.detail', $post->id) }}"
                                        class="h5 d-block mb-0 ">{{ $post->title }}</a>
                                </div>

                                <div class="truncate-3 mb-3 fw-lighter text-break" style="font-size: 14px">
                                    {!! $post->content !!}
                                </div>


                                <div class="d-flex justify-content-between align-items-center ">

                                    @if ($post->user)
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="avatar-wrapper">
                                                <div class="avatar avatar-sm me-3">
                                                    <img src="{{ $post->user->avatar ? getThumb($post->user->avatar) : asset('admin-frontend/assets/img/avatar.png') }}"
                                                        alt="Avatar" class="rounded-circle">
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="javascript:void(0)" class="text-body text-truncate"><span
                                                        class="fw-medium">{{ $post->user->full_name }}</span></a>
                                                <small class="text-truncate text-muted">{{ $post->user->email }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="avatar-wrapper">
                                                <div class="avatar avatar-sm me-3">
                                                    <img src="{{ asset('admin-frontend/assets/img/avatar.png') }}"
                                                        alt="Avatar" class="rounded-circle">
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="javascript:void(0)" class="text-body text-truncate"><span
                                                        class="fw-medium">Đang đình chỉ</span></a>
                                                <small class="text-truncate text-muted">Không xác định</small>
                                            </div>
                                        </div>
                                    @endif



                                    <a href="javascript:void(0)" onclick="savePost({{ $post->id }})"
                                        class="text-secondary text-nowrap d-inline-block"><i
                                            class=' tf-icons bx bx-bookmark fs-4'></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
            {{ $news->withQueryString()->links() }}

        </div>
    </div>


@endsection
<script>
    function savePost(id) {
        $.ajax({
            type: 'POST',
            url: '{!! route('dashboard.save-post.savePost') !!}',
            data: {
                post_id: id,
                _token: $('meta[name="csrf-token"]').attr('content')
            }, // Dữ liệu gửi đi (có thể là ID của bài viết)
            success: function(response) {
                Swal.fire({
                    title: 'Bài viết đã được lưu!',
                    icon: 'success',
                    timer: 2000,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false,
                })
            },
            error: function(error) {
                Swal.fire({
                    title: 'Bài viết chưa được lưu!',
                    icon: 'error',
                    timer: 2000,
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false,
                })
            }
        });

    }
</script>
