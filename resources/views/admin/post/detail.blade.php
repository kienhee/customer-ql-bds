@extends('admin.layout.index')
@section('title', $post->title)
@section('content')
    <div class=" row g-3">
        <div class="col-lg-8">
            <div class="card shadow-none border position-relative overflow-hidden">
                <div class="p-2">
                    <div class="cursor-pointer ">
                        <a href="{{ explode(',', $post->images)[0] }}" class="popup-link"> <img
                                src="{{ explode(',', $post->images)[0] }}" class="img-fluid w-100"
                                style="height: 500px;object-fit:cover" alt=""></a>

                    </div>
                </div>
                <div class="card-body p-3 p-md-4 ">
                    <h4 class="mb-3">{{ $post->title }}</h4>
                    <div class="d-flex gap-3 align-items-center mb-3">
                        <p class="d-flex align-items-center mb-0">
                            <i
                                class='bx bx-calendar me-1'></i><small>{{ $post->created_at->format('d/m/y - h:m') }}&nbsp;</small>
                            @if (now()->startOfDay()->eq($post->created_at->startOfDay()))
                                - &nbsp;<span class="badge bg-label-success"> Mới nhất</span>
                            @else
                                - <small>&nbsp;{{ $post->created_at->diffForHumans() }}</small>
                            @endif
                        </p>
                        <p class="mb-0"><i class='bx bx-show-alt fs-3'></i> <small>{{ $post->views }} lượt
                                xem</small></p>
                    </div>
                    <hr class="my-4" />
                    <h5>Mô tả</h5>
                    <div class="my-3 ">
                        {!! $post->content !!}
                    </div>
                    <div class="slider">
                        @if (count(explode(',', $post->images)) > 1)
                            @foreach (explode(',', $post->images) as $image)
                                <div><a class="popup-link" href="{{ $image }}" title="click để phóng to"><img
                                            class="img-fluid" src="{{ $image }}"></a></div>
                            @endforeach
                        @endif
                    </div>
                    <hr>

                    @if (Auth::user()->group_id != 7 && $post->papers)
                        <p class="h5">Giấy tờ liên quan</p>
                        <div class="slider">
                            @if (count(explode(',', $post->papers)) > 1)
                                @foreach (explode(',', $post->papers) as $image)
                                    <div><a class="popup-link" href="{{ $image }}" title="click để phóng to"><img
                                                class="img-fluid" src="{{ $image }}"></a></div>
                                @endforeach
                            @endif
                        </div>
                    @endif
                </div>
                @if ($post->status != 1)
                    <div
                        class="position-absolute top-0 bottom-0 left-0 right-0 p-2 p-md-5 d-flex justify-content-center align-items-center">
                        <img src="{{ $post->status == 2 ? asset('admin-frontend/assets/img/stop_sell.png') : asset('admin-frontend/assets/img/self_sold.png') }}"
                            class="img-fluid z-3" alt="">
                    </div>
                @endif
                <hr>
                <section>
                    <div class="container py-5 text-dark">
                        <div class="row">
                            @if ($comments->count() > 0)
                                @foreach ($comments as $comment)
                                    <div class="col-12">
                                        <div class="d-flex flex-column gap-3 flex-md-row gap-md-0 flex-start mb-4">
                                            <img class="rounded-circle shadow-1-strong me-3"
                                                src="{{ $comment->user->avatar ? getThumb($comment->user->avatar) : asset('admin-frontend/assets/img/avatar.png') }}"
                                                alt="avatar" width="65" height="65" />
                                            <div class="card w-100">
                                                <div class="card-body p-4">
                                                    <div class="">
                                                        <h5 class="mb-2">{{ $comment->user->full_name }}</h5>
                                                        <i
                                                            class='bx bx-calendar me-1'></i><small>{{ $comment->created_at->format('d/m/y - h:m') }}&nbsp;</small>
                                                        @if (now()->startOfDay()->eq($comment->created_at->startOfDay()))
                                                            - &nbsp;<span class="badge bg-label-success"> Mới
                                                                nhất</span>
                                                        @else
                                                            -
                                                            <small>&nbsp;{{ $comment->created_at->diffForHumans() }}</small>
                                                        @endif
                                                        <p class="mt-2">
                                                            {{ $comment->content }}
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                @endforeach
                            @else
                                <div class="col-12 mb-5">
                                    <p class="h5 text-center text-muted">Chưa có lời nhắn nào!</p>
                                </div>
                            @endif


                            <hr class="pb-3">
                            <h5 class="text-center">Để lại Lời nhắn 📝</h5>
                            <form action="{{ route('dashboard.news.comment', $post->id) }}" method="POST"
                                class="card-footer border-0">
                                @csrf
                                <div class="d-flex flex-start w-100">
                                    <img class="rounded-circle shadow-1-strong me-3 d-none d-md-block"
                                        src="{{ Auth::user()->avatar ? getThumb(Auth::user()->avatar) : asset('admin-frontend/assets/img/avatar.png') }}"
                                        alt="avatar" width="40" height="40" />
                                    <div class="form-outline w-100">
                                        <textarea class="form-control @error('content') invalid @enderror" rows="4" name="content"
                                            placeholder="Vui lòng để lại Lời nhắn"></textarea>
                                        @error('content')
                                            <p class="text-danger mt-1 fs-6">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="float-end mt-2 pt-1">
                                    <button type="submit" class="btn btn-primary btn-sm">Gửi Lời nhắn</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body">
                    <small class="text-muted text-uppercase">Thông tin</small>
                    <ul class="list-unstyled mb-4 mt-3">
                        <li class="d-flex align-items-center flex-wrap mb-3">
                            <i class="bx bx-buildings"></i><span class="fw-medium mx-2">Tỉnh:</span>
                            <span>{{ $post->province->name }}</span>
                        </li>
                        <li class="d-flex align-items-center flex-wrap mb-3">
                            <i class="bx bx-buildings"></i><span class="fw-medium mx-2">Quận/huyện:</span>
                            <span>{{ $post->district->name }}</span>
                        </li>
                        <li class="d-flex align-items-center flex-wrap mb-3">
                            <i class='bx bx-map'></i><span class="fw-medium mx-2">Địa chỉ:</span>
                            <span class="mt-1">{{ $post->address }}</span>
                        </li>
                        <li class="d-flex align-items-center flex-wrap mb-3">
                            <i class='bx bx-arch'></i><span class="fw-medium mx-2">Diện tích:</span>
                            <span>{{ $post->acreage }}</span>
                        </li>
                        <li class="d-flex align-items-center flex-wrap mb-3">
                            <i class='bx bx-money'></i><span class="fw-medium mx-2">Giá:</span>
                            <span class="badge bg-label-success">{{ number_format($post->price) }} đ</span>
                        </li>

                        <li class="d-flex align-items-center  flex-wrap mb-3">
                            <i class="bx bx-check"></i><span class="fw-medium mx-2">Trạng thái:</span>
                            @if ($post->status == '1')
                                <span class="badge bg-label-success">Bán mạnh</span>
                            @endif
                            @if ($post->status == '2')
                                <span class="badge bg-label-danger">Đã bán</span>
                            @endif
                            @if ($post->status == '3')
                                <span class="badge bg-label-danger">Chủ tự bán</span>
                            @endif
                        </li>
                        <li class="d-flex align-items-center flex-wrap mb-3">
                            <i class="bx bx-star"></i><span class="fw-medium mx-2">Đặc điểm:</span>
                            <div class="mt-1">
                                @foreach (json_decode($post->characteristics, true) as $item)
                                    <span class="badge rounded-pill bg-label-secondary me-2">{{ $item['value'] }}</span>
                                @endforeach
                            </div>
                        </li>
                        <li class="d-flex align-items-center flex-wrap mb-3">
                            <i class='bx bx-bed'></i><span class="fw-medium mx-2">Số phòng:</span>
                            <span>{{ $post->room_number }}</span>
                        </li>
                        <li class="d-flex align-items-center flex-wrap mb-3">
                            <i class='bx bx-directions'></i><span class="fw-medium mx-2">Huớng:</span>
                            <span>{{ $post->direction->name }}</span>
                        </li>
                        @if ($post->map)
                            <li class="d-flex align-items-center flex-wrap mb-3">
                                <i class='bx bx-map-alt'></i><span class="fw-medium mx-2">Map:</span>
                                <a href="{{ $post->map }}" target="_blank" title="Xem bản đồ">Xem bản đồ</a>
                            </li>
                        @endif

                    </ul>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <small class="text-muted text-uppercase">Liên hệ</small>
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                            <img class="object-fit-cover rounded my-4"
                                src="{{ $post->user->avatar ? getThumb($post->user->avatar) : asset('admin-frontend/assets/img/avatar.png') }}"
                                height="100" width="100" alt="User avatar">
                            <div class="user-info text-center">
                                <h4 class="mb-2">{{ $post->user->full_name }}</h4>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <ul class="list-unstyled mb-4 mt-3">
                        <li class="d-flex align-items-center mb-3">
                            <i class='bx bx-calendar'></i><span class="fw-medium mx-2">Năm sinh:</span>
                            <span>{{ $post->user->date_of_birth ? explode('-', $post->user->date_of_birth)[2] : 'Chưa xác định' }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <i class="bx bx-phone"></i><span class="fw-medium mx-2">SDT:</span>
                            <span>{{ $post->user->phone }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                            <i class="bx bx-envelope"></i><span class="fw-medium mx-2">Email:</span>
                            <span>{{ $post->user->email }}</span>
                        </li>
                    </ul>
                    <small class="text-muted text-uppercase">Socials</small>
                    <ul class="list-unstyled mt-3 mb-0">
                        @if ($post->user->facebook)
                            <li class="d-flex align-items-center mb-3">
                                <i class='bx bxl-facebook-circle text-primary me-2'></i>
                                <div class="d-flex flex-wrap">
                                    <a href="{{ $post->user->facebook }}" class="fw-medium me-2">Facebook</a>
                                </div>
                            </li>
                        @endif
                        <li class="d-flex align-items-center">
                            <img src="{{ asset('admin-frontend/assets/img/zalo-icon.png') }}" class="me-2"
                                alt="">
                            <div class="d-flex flex-wrap">
                                <a href="https://zalo.me/{{ $post->user->phone }}" target="_blank"
                                    class="fw-medium me-2">Zalo</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {

            $('.slider').slick({
                autoplay: true,
                dots: true,
                arrows: true,
            });
            // Kích hoạt Magnific Popup cho hình ảnh cụ thể
            $('.popup-link').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        });
    </script>

@endsection
