@extends('admin.layout.index')
@section('title', 'Library')
@section('content')
    <a href="/laravel-filemanager?type=Images" target="_blank" class="btn btn-primary me-2"><i class='bx bx-images'></i>
        &nbsp;Hình ảnh</a>
    <a href="/laravel-filemanager?type=Files" target="_blank" class="btn btn-primary"><i class='bx bxs-file'></i> &nbsp;Tệp</a>
@endsection
