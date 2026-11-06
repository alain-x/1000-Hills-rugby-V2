@extends('admin.layouts.app')

@section('page_title', 'Message')
@section('page_subtitle', $message->subject ?: 'Website enquiry')

@section('content')
<div class="page-head">
    <div><h1>{{ $message->subject ?: 'Website enquiry' }}</h1><div class="sub">Received {{ $message->created_at->format('d M Y \a\t H:i') }}</div></div>
    <a href="{{ route('admin.messages.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back to inbox</a>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card-panel">
            <div class="card-panel-header">
                <div>
                    <h5 class="mb-0">Message from {{ $message->name }}</h5>
                    <span class="text-muted small">{{ $message->email }}</span>
                </div>
                {!! $message->is_read ? '<span class="badge-muted">Read</span>' : '<span class="badge-warn">Unread</span>' !!}
            </div>
            <div class="card-panel-body">
                <div class="article-body" style="white-space:pre-line;">{{ $message->message }}</div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card-panel mb-4">
            <div class="card-panel-header"><h5 class="mb-0">Contact details</h5></div>
            <div class="card-panel-body">
                <dl class="row mb-0 small">
                    <dt class="col-4 text-muted">Name</dt><dd class="col-8">{{ $message->name }}</dd>
                    <dt class="col-4 text-muted">Email</dt><dd class="col-8 text-break"><a href="mailto:{{ $message->email }}">{{ $message->email }}</a></dd>
                    <dt class="col-4 text-muted">Phone</dt><dd class="col-8">{{ $message->phone ?: '—' }}</dd>
                    <dt class="col-4 text-muted">Subject</dt><dd class="col-8">{{ $message->subject ?: '—' }}</dd>
                    <dt class="col-4 text-muted">IP address</dt><dd class="col-8">{{ $message->ip_address ?: '—' }}</dd>
                    <dt class="col-4 text-muted">Received</dt><dd class="col-8">{{ $message->created_at->format('d M Y H:i') }}</dd>
                </dl>
            </div>
        </div>
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Actions</h5></div>
            <div class="card-panel-body">
                <div class="d-grid gap-2">
                    <a href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: '.($message->subject ?: 'Your enquiry to 1000 Hills Rugby')) }}" class="btn btn-admin-forest"><i class="bi bi-reply me-1"></i>Reply by email</a>
                    <form action="{{ route('admin.messages.read', $message) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="btn btn-admin-outline w-100" type="submit"><i class="bi bi-{{ $message->is_read ? 'envelope' : 'check2' }} me-1"></i>Mark as {{ $message->is_read ? 'unread' : 'read' }}</button>
                    </form>
                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" data-confirm="Delete this message?">
                        @csrf @method('DELETE')
                        <button class="btn btn-outline-danger w-100" type="submit"><i class="bi bi-trash me-1"></i>Delete message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
