@extends('admin.layouts.app')

@section('page_title', 'New event')
@section('page_subtitle', 'Add an event to the club calendar')

@section('content')
<div class="page-head">
    <div><h1>New event</h1><div class="sub">Create a tournament, community day or club gathering</div></div>
    <a href="{{ route('admin.events.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @include('admin.events._form')
</form>
@endsection
