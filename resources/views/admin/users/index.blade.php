@extends('admin.layouts.app')

@section('page_title', 'Admin users')
@section('page_subtitle', 'People with access to the admin panel')

@section('content')
<div class="page-head">
    <div><h1>Admin users</h1><div class="sub">{{ $users->total() }} account{{ $users->total() === 1 ? '' : 's' }}</div></div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-admin-forest"><i class="bi bi-person-plus me-1"></i>New user</a>
</div>

<div class="card-panel mb-4">
    <div class="card-panel-body">
        <form action="{{ route('admin.users.index') }}" method="GET" class="row g-2 align-items-end">
            <div class="col-md-9">
                <label class="form-label">Search</label>
                <input type="search" name="q" value="{{ request('q') }}" class="form-control" placeholder="Name, email or username">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button class="btn btn-admin-forest w-100" type="submit">Search</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-admin-outline" aria-label="Reset"><i class="bi bi-arrow-counterclockwise"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card-panel">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead><tr><th>User</th><th>Username</th><th>Role</th><th>Status</th><th>Last login</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <span class="rounded-circle bg-success text-white d-grid" style="width:40px;height:40px;place-items:center;font-size:.75rem;font-weight:700;">{{ $user->initials() }}</span>
                                <div>
                                    <div class="fw-semibold">{{ $user->name }} @if($user->id === auth()->id())<span class="badge-soft ms-1">You</span>@endif</div>
                                    <div class="text-muted small">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td><code>{{ $user->username ?: '—' }}</code></td>
                        <td><span class="badge-soft">{{ ucfirst($user->role) }}</span>@if($user->team)<div class="text-muted small">{{ $user->team->name }}</div>@endif</td>
                        <td>{!! $user->is_active ? '<span class="badge-soft">Active</span>' : '<span class="badge-muted">Disabled</span>' !!}</td>
                        <td class="text-muted small">{{ optional($user->last_login_at)->diffForHumans() ?: 'Never' }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-admin-outline btn-sm"><i class="bi bi-pencil"></i></a>
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" data-confirm="Delete this user account?">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-trash"></i></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">{{ $users->links() }}</div>
@endsection
