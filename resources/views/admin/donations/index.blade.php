@extends('admin.layouts.app')

@section('page_title', 'Donations')
@section('page_subtitle', 'Track online and offline gifts to the club')

@section('content')
<div class="page-head">
    <div>
        <h1>Donations</h1>
        <div class="sub">{{ format_rwf($total) }} completed · {{ $donations->total() }} record{{ $donations->total() === 1 ? '' : 's' }}</div>
    </div>
</div>

<div class="card-panel mb-4">
    <div class="card-panel-body">
        <form action="{{ route('admin.donations.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Search</label>
                <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Reference, name or email">
            </div>
            <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All</option>
                    @foreach(['PENDING', 'COMPLETED', 'FAILED', 'CANCELLED'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst(strtolower($status)) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">From</label>
                <input type="date" name="from" value="{{ request('from') }}" class="form-control">
            </div>
            <div class="col-md-2">
                <label class="form-label">To</label>
                <input type="date" name="to" value="{{ request('to') }}" class="form-control">
            </div>
            <div class="col-md-2 d-flex gap-2">
                <button class="btn btn-admin-forest w-100" type="submit">Filter</button>
                <a href="{{ route('admin.donations.index') }}" class="btn btn-admin-outline" aria-label="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card-panel">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead><tr><th>Reference</th><th>Donor</th><th>Amount</th><th>Purpose</th><th>Status</th><th>Date</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($donations as $donation)
                    <tr>
                        <td><code class="small">{{ $donation->reference }}</code></td>
                        <td>
                            <div class="fw-semibold">{{ $donation->name }}</div>
                            <div class="text-muted small">{{ $donation->email }}</div>
                        </td>
                        <td class="fw-semibold text-nowrap">{{ format_rwf($donation->amount) }}</td>
                        <td class="small">{{ $donation->purpose ?: 'General fund' }}</td>
                        <td>
                            @php($status = strtoupper((string) $donation->status))
                            @if(in_array($status, ['COMPLETED', 'SUCCESS', 'PAID']))
                                <span class="badge-soft">Completed</span>
                            @elseif($status === 'PENDING')
                                <span class="badge-soft badge-warn">Pending</span>
                            @else
                                <span class="badge-muted">{{ ucfirst(strtolower($status)) }}</span>
                            @endif
                        </td>
                        <td class="text-muted small text-nowrap">{{ $donation->created_at->format('d M Y') }}</td>
                        <td class="text-end"><a href="{{ route('admin.donations.show', $donation) }}" class="btn btn-admin-outline btn-sm"><i class="bi bi-eye"></i></a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-5">No donations found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">{{ $donations->links() }}</div>
@endsection
