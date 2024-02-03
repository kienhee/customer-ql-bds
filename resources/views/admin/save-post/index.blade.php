@extends('admin.layout.index')
@section('title', 'Bản tin')

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard.index') }}">Bảng điều khiển</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Bài viết đã lưu</a>
            </li>
            <li class="breadcrumb-item active">Tất cả</li>
        </ol>
    </nav>
    <div class="card mb-4">
        <div class="card-header d-flex flex-wrap justify-content-between gap-3">
            <div class="card-title mb-0 me-1">
                <h5 class="mb-1">Bài viết đã lưu</h5>
            </div>

        </div>

        <div class="card-body">

            <div class="row gy-4 mb-4">
                @if ($news)
                    @foreach ($news as $post)
                        <div class="col-sm-6 col-lg-4">

                            <div class="card p-2 h-100 shadow-none border">

                                <div class="rounded-2 text-center mb-3">
                                    <a href="{{ route('dashboard.posts.detail', $post->id) }}">
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
                                        <a href="{{ route('dashboard.posts.detail', $post->id) }}"
                                            class="h5 d-block mb-0 ">{{ $post->title }}</a>
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


                                        <a href="javascript:void(0)" onclick="savePost({{ $post->id }})"
                                            class="text-secondary text-nowrap d-inline-block"><i
                                                class='bx bx-trash fs-4'></i>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="h2 text-center text-muted">Bạn chưa lưu bài viết nào!</p>
                @endif

            </div>

        </div>
    </div>


@endsection
<script>
    function savePost(id) {
        if (confirm('Bạn có chắc chắn muốn xóa không?')) {
            $.ajax({
                type: 'delete',
                url: '{!! route('dashboard.save-post.removePost') !!}',
                data: {
                    post_id: id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                }, // Dữ liệu gửi đi (có thể là ID của bài viết)
                success: function(response) {
                    Swal.fire({
                        title: 'Bài viết đã được xoá!',
                        icon: 'success',
                        timer: 2000,
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false,
                    })
                    window.location.reload();
                },
                error: function(error) {
                    Swal.fire({
                        title: 'Bài viết chưa được xoá!',
                        icon: 'error',
                        timer: 2000,
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false,
                    })
                    window.location.reload();
                }
            });
        }

    }
</script>
