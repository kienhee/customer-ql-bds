@extends('admin.layout.index')
@section('title', $post->title)
@section('content')
    <div class="card g-3 ">
        <div class="card-body row g-3">
            <div class="col-lg-8">
                <div class="card shadow-none border position-relative overflow-hidden">
                    <div class="p-2">
                        <div class="cursor-pointer">
                            <img src="{{ $post->cover }}" class="w-100" alt="">
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="mb-2">{{ $post->title }}</h4>
                        <hr class="my-4" />
                        <h5>Mô tả</h5>
                        <div class="my-3">
                            {!! $post->content !!}
                        </div>
                    </div>
                    @if ($post->status != 1)
                        <div
                            class="position-absolute top-0 bottom-0 left-0 right-0 p-2 p-md-5 d-flex justify-content-center align-items-center">
                            <img src="{{ $post->status == 2 ? asset('admin-frontend/assets/img/stop_sell.png') : asset('admin-frontend/assets/img/self_sold.png') }}"
                                class="img-fluid z-3" alt="">
                        </div>
                    @endif

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
                                <span>{{ $post->room_number }} đ</span>
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
                                <img class="object-fit-cover rounded my-4" src="{{ $post->user->avatar }}" height="100"
                                    width="100" alt="User avatar">
                                <div class="user-info text-center">
                                    <h4 class="mb-2">{{ $post->user->full_name }}</h4>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <ul class="list-unstyled mb-4 mt-3">
                            <li class="d-flex align-items-center mb-3">
                                <i class='bx bx-calendar'></i><span class="fw-medium mx-2">Năm sinh:</span>
                                <span>{{ explode('-', $post->user->date_of_birth)[2] }}</span>
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
    </div>
@endsection
