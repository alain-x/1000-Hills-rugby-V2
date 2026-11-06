@extends('admin.layouts.app')

@section('page_title', 'Edit admin user')
@section('page_subtitle', $user->name)

@section('content')
<div class="page-head">
    <div><h1>Edit admin user</h1><div class="sub">Last login {{ optional($user->last_login_at)->diffForHumans() ?: 'never' }}</div></div>
    <a href="{{ route('admin.users.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.users.update', $user) }}" method="POST" class="form-admin">
    @csrf
    @method('PUT')
    @include('admin.users._form')
</form>
@endsection
