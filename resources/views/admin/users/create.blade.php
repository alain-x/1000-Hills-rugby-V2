@extends('admin.layouts.app')

@section('page_title', 'New admin user')
@section('page_subtitle', 'Create a staff account')

@section('content')
<div class="page-head">
    <div><h1>New admin user</h1><div class="sub">Grant access to the admin panel</div></div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back to users</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.users.store') }}" method="POST" class="form-admin">
    @csrf
    @include('admin.users._form')
</form>
@endsection
