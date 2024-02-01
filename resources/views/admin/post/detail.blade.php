@extends('admin.layout.index')
@section('content')
    <div class="card g-3 mt-5">
        <div class="card-body row g-3">
            <div class="col-lg-8">

                <div class="card academy-content shadow-none border">
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
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mb-4">

                <div class="card-body">
                      <small class="text-muted text-uppercase">About</small>
                      <ul class="list-unstyled mb-4 mt-3">
                        <li class="d-flex align-items-center mb-3">
                          <i class="bx bx-user"></i><span class="fw-medium mx-2">Full Name:</span> <span>John Doe</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                          <i class="bx bx-check"></i><span class="fw-medium mx-2">Status:</span> <span>Active</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                          <i class="bx bx-star"></i><span class="fw-medium mx-2">Role:</span> <span>Developer</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                          <i class="bx bx-flag"></i><span class="fw-medium mx-2">Country:</span> <span>USA</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                          <i class="bx bx-detail"></i><span class="fw-medium mx-2">Languages:</span>
                          <span>English</span>
                        </li>
                      </ul>
                      <small class="text-muted text-uppercase">Contacts</small>
                      <ul class="list-unstyled mb-4 mt-3">
                        <li class="d-flex align-items-center mb-3">
                          <i class="bx bx-phone"></i><span class="fw-medium mx-2">Contact:</span>
                          <span>(123) 456-7890</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                          <i class="bx bx-chat"></i><span class="fw-medium mx-2">Skype:</span> <span>john.doe</span>
                        </li>
                        <li class="d-flex align-items-center mb-3">
                          <i class="bx bx-envelope"></i><span class="fw-medium mx-2">Email:</span>
                          <span>john.doe@example.com</span>
                        </li>
                      </ul>
                      <small class="text-muted text-uppercase">Teams</small>
                      <ul class="list-unstyled mt-3 mb-0">
                        <li class="d-flex align-items-center mb-3">
                          <i class="bx bxl-github text-primary me-2"></i>
                          <div class="d-flex flex-wrap">
                            <span class="fw-medium me-2">Backend Developer</span><span>(126 Members)</span>
                          </div>
                        </li>
                        <li class="d-flex align-items-center">
                          <i class="bx bxl-react text-info me-2"></i>
                          <div class="d-flex flex-wrap">
                            <span class="fw-medium me-2">React Developer</span><span>(98 Members)</span>
                          </div>
                        </li>
                      </ul>
                    </div>
            </div>
            </div>
        </div>
    </div>
@endsection
