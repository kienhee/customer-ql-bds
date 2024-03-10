@extends('admin.layout.index')
@section('title', 'Bảng điều khiển')
@section('content')
    <div class="card">
        <div class="d-flex align-items-end row">
            <div class="col-sm-7">
                <div class="card-body">
                    <h5 class="card-title text-primary">Good morning, {{ Auth::user()->full_name }}! 🎉</h5>
                    <p class="mb-4">
                        Start your day by selecting the items next to you 💯
                    </p>

                </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
                <div class="card-body pb-0 px-0 px-md-4">
                    <img src="{{ asset('admin-frontend') }}/assets/img/illustrations/man-with-laptop-light.png" height="140"
                        alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                        data-app-light-img="illustrations/man-with-laptop-light.png" />
                </div>
            </div>
        </div>
    </div>
@endsection
