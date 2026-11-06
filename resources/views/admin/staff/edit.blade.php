@extends('admin.layouts.app')

@section('page_title', 'Edit staff member')
@section('page_subtitle', $member->name)

@section('content')
<div class="page-head">
    <div><h1>Edit staff member</h1><div class="sub">Last updated {{ $member->updated_at->diffForHumans() }}</div></div>
    <a href="{{ route('admin.staff.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.staff.update', $member) }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @method('PUT')
    @include('admin.staff._form')
</form>
@endsection
