@extends('admin.layouts.app')

@section('page_title', 'Subscribers')
@section('page_subtitle', 'Newsletter audience')

@section('content')
<div class="page-head">
    <div>
        <h1>Subscribers</h1>
        <div class="sub">{{ $subscribers->total() }} subscriber{{ $subscribers->total() === 1 ? '' : 's' }}</div>
    </div>
    <a href="{{ route('admin.subscribers.export') }}" class="btn btn-admin-forest"><i class="bi bi-download me-1"></i>Export CSV</a>
</div>

<div class="card-panel">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead><tr><th>Email</th><th>Status</th><th>Subscribed</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($subscribers as $subscriber)
                    <tr>
                        <td class="fw-semibold">{{ $subscriber->email }}</td>
                        <td>{!! $subscriber->is_active ? '<span class="badge-soft">Active</span>' : '<span class="badge-muted">Unsubscribed</span>' !!}</td>
                        <td class="text-muted small">{{ $subscriber->created_at->format('d M Y H:i') }}</td>
                        <td class="text-end">
                            <form action="{{ route('admin.subscribers.destroy', $subscriber) }}" method="POST" data-confirm="Remove this subscriber?">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-5">No subscribers yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">{{ $subscribers->links() }}</div>
@endsection
