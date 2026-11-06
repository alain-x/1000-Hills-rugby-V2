@extends('admin.layouts.app')

@section('page_title', 'Messages')
@section('page_subtitle', 'Website enquiries and contact form submissions')

@section('content')
<div class="page-head">
    <div><h1>Messages</h1><div class="sub">{{ $messages->total() }} message{{ $messages->total() === 1 ? '' : 's' }} in the inbox</div></div>
</div>

<div class="card-panel mb-4">
    <div class="card-panel-body">
        <form action="{{ route('admin.messages.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <label class="form-label">Search</label>
                <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Name, email or subject">
            </div>
            <div class="col-md-4">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All messages</option>
                    <option value="unread" @selected(request('status') === 'unread')>Unread</option>
                    <option value="read" @selected(request('status') === 'read')>Read</option>
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-admin-forest w-100" type="submit">Filter</button>
                <a href="{{ route('admin.messages.index') }}" class="btn btn-admin-outline" aria-label="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card-panel">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead><tr><th>From</th><th>Subject</th><th>Received</th><th>Status</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($messages as $message)
                    <tr class="{{ $message->is_read ? '' : 'fw-semibold' }}">
                        <td>
                            <div>{{ $message->name }}</div>
                            <div class="text-muted small fw-normal">{{ $message->email }}@if($message->phone) · {{ $message->phone }}@endif</div>
                        </td>
                        <td>
                            <a href="{{ route('admin.messages.show', $message) }}" class="text-dark text-decoration-none">{{ $message->subject ?: 'Website enquiry' }}</a>
                            <div class="text-muted small fw-normal text-truncate" style="max-width:360px;">{{ \Illuminate\Support\Str::limit($message->message, 80) }}</div>
                        </td>
                        <td class="text-muted small text-nowrap">{{ $message->created_at->format('d M Y H:i') }}</td>
                        <td>{!! $message->is_read ? '<span class="badge-muted">Read</span>' : '<span class="badge-warn">New</span>' !!}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-admin-outline btn-sm" title="Open"><i class="bi bi-envelope-open"></i></a>
                            <form action="{{ route('admin.messages.read', $message) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-admin-outline btn-sm" type="submit" title="{{ $message->is_read ? 'Mark unread' : 'Mark read' }}"><i class="bi bi-{{ $message->is_read ? 'envelope' : 'check2' }}"></i></button>
                            </form>
                            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="d-inline" data-confirm="Delete this message?">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-5">The inbox is empty.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">{{ $messages->links() }}</div>
@endsection
