@extends('admin.layouts.app')

@section('page_title', 'Activity log')
@section('page_subtitle', 'Audit trail of changes made in the admin panel')

@section('content')
<div class="page-head">
    <div><h1>Activity log</h1><div class="sub">{{ $logs->total() }} recorded action{{ $logs->total() === 1 ? '' : 's' }}</div></div>
</div>

<div class="card-panel">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead><tr><th>User</th><th>Action</th><th>Description</th><th>Subject</th><th>IP</th><th>When</th></tr></thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $log->user?->name ?: 'System' }}</div>
                            <div class="text-muted small">{{ $log->user?->email }}</div>
                        </td>
                        <td><span class="badge-soft">{{ ucfirst($log->action) }}</span></td>
                        <td>{{ $log->description ?: '—' }}</td>
                        <td class="text-muted small">
                            @if($log->subject_type)
                                {{ class_basename($log->subject_type) }}@if($log->subject_id) #{{ $log->subject_id }}@endif
                            @else
                                —
                            @endif
                        </td>
                        <td class="text-muted small">{{ $log->ip_address ?: '—' }}</td>
                        <td class="text-muted small text-nowrap">{{ $log->created_at->format('d M Y H:i') }}<div class="text-muted">{{ $log->created_at->diffForHumans() }}</div></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">No activity recorded yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">{{ $logs->links() }}</div>
@endsection
