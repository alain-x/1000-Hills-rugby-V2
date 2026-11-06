@extends('admin.layouts.app')

@section('page_title', 'Edit player')
@section('page_subtitle', $player->name)

@section('content')
<div class="page-head">
    <div><h1>Edit player</h1><div class="sub">Last updated {{ $player->updated_at->diffForHumans() }}</div></div>
    <div class="d-flex gap-2">
        @if($player->is_published)
            <a href="{{ route('players.show', $player) }}" target="_blank" rel="noopener" class="btn btn-admin-outline"><i class="bi bi-eye me-1"></i>View</a>
        @endif
        <a href="{{ route('admin.players.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back</a>
    </div>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.players.update', $player) }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @method('PUT')
    @include('admin.players._form')
</form>
@endsection
