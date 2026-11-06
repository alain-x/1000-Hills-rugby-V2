@extends('admin.layouts.app')

@section('page_title', 'Edit event')
@section('page_subtitle', $event->title)

@section('content')
<div class="page-head">
    <div><h1>Edit event</h1><div class="sub">Last updated {{ $event->updated_at->diffForHumans() }}</div></div>
    <a href="{{ route('admin.events.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back</a>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @method('PUT')
    @include('admin.events._form')
</form>
@endsection
