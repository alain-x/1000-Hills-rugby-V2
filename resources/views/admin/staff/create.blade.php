@extends('admin.layouts.app')

@section('page_title', 'Add staff member')
@section('page_subtitle', 'Club leadership and technical team')

@section('content')
<div class="page-head">
    <div><h1>Add staff member</h1><div class="sub">Profile, role and contact details</div></div>
    <a href="{{ route('admin.staff.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back to staff</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.staff.store') }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @include('admin.staff._form')
</form>
@endsection
