@extends('admin.layouts.app')

@section('page_title', 'Add sponsor')
@section('page_subtitle', 'Add a club partner')

@section('content')
<div class="page-head">
    <div><h1>Add sponsor</h1><div class="sub">Partner logo and links</div></div>
    <a href="{{ route('admin.sponsors.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back to sponsors</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.sponsors.store') }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @include('admin.sponsors._form')
</form>
@endsection
