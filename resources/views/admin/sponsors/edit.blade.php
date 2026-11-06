@extends('admin.layouts.app')

@section('page_title', 'Edit sponsor')
@section('page_subtitle', $sponsor->name ?: 'Partner')

@section('content')
<div class="page-head">
    <div><h1>Edit sponsor</h1><div class="sub">Last updated {{ $sponsor->updated_at->diffForHumans() }}</div></div>
    <a href="{{ route('admin.sponsors.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.sponsors.update', $sponsor) }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @method('PUT')
    @include('admin.sponsors._form')
</form>
@endsection
