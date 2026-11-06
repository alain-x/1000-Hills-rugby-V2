@extends('admin.layouts.app')

@section('page_title', 'Staff & coaches')
@section('page_subtitle', 'Club leadership and technical team')

@section('content')
<div class="page-head">
    <div>
        <h1>Staff &amp; coaches</h1>
        <div class="sub">{{ $staff->total() }} member{{ $staff->total() === 1 ? '' : 's' }} listed</div>
    </div>
    <a href="{{ route('admin.staff.create') }}" class="btn btn-admin-forest"><i class="bi bi-person-plus me-1"></i>Add staff member</a>
</div>

<div class="card-panel">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Role</th>
                    <th>Contact</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staff as $member)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ media_url($member->image, 'images/placeholder.svg') }}" alt="" class="rounded-circle" style="width:44px;height:44px;object-fit:cover;">
                                <div>
                                    <div class="fw-semibold">{{ $member->name }}</div>
                                    <div class="text-muted small text-truncate" style="max-width:320px;">{{ \Illuminate\Support\Str::limit(strip_tags($member->bio), 60) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $member->role ?: '—' }}</td>
                        <td class="text-muted small">{{ $member->email ?: $member->phone ?: '—' }}</td>
                        <td class="text-muted">{{ $member->sort_order }}</td>
                        <td>{!! $member->is_active ? '<span class="badge-soft">Active</span>' : '<span class="badge-muted">Hidden</span>' !!}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.staff.edit', $member) }}" class="btn btn-admin-outline btn-sm"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.staff.destroy', $member) }}" method="POST" class="d-inline" data-confirm="Remove this staff member?">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">No staff members yet. <a href="{{ route('admin.staff.create') }}">Add the first member</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">{{ $staff->links() }}</div>
@endsection
