@extends('admin.layouts.app')

@section('page_title', 'Sponsors & partners')
@section('page_subtitle', 'Organisations supporting the club')

@section('content')
<div class="page-head">
    <div>
        <h1>Sponsors &amp; partners</h1>
        <div class="sub">{{ $sponsors->total() }} partner{{ $sponsors->total() === 1 ? '' : 's' }} listed</div>
    </div>
    <a href="{{ route('admin.sponsors.create') }}" class="btn btn-admin-forest"><i class="bi bi-plus-lg me-1"></i>Add sponsor</a>
</div>

<div class="card-panel">
    <div class="table-responsive">
        <table class="table table-admin align-middle">
            <thead>
                <tr>
                    <th>Partner</th>
                    <th>Tier</th>
                    <th>Website</th>
                    <th>Order</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sponsors as $sponsor)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <span class="border rounded bg-white d-grid p-1" style="width:72px;height:48px;place-items:center;">
                                    <img src="{{ media_url($sponsor->logo_path, 'images/placeholder.svg') }}" alt="" style="max-width:64px;max-height:38px;object-fit:contain;">
                                </span>
                                <div>
                                    <div class="fw-semibold">{{ $sponsor->name ?: 'Unnamed partner' }}</div>
                                    <div class="text-muted small">{{ \Illuminate\Support\Str::limit(strip_tags($sponsor->description), 60) }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge-soft">{{ $sponsor->tier ?: 'Partner' }}</span></td>
                        <td class="small">
                            @if($sponsor->website)
                                <a href="{{ $sponsor->website }}" target="_blank" rel="noopener" class="text-truncate d-inline-block" style="max-width:220px;">{{ $sponsor->website }}</a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-muted">{{ $sponsor->sort_order }}</td>
                        <td>{!! $sponsor->is_active ? '<span class="badge-soft">Active</span>' : '<span class="badge-muted">Hidden</span>' !!}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="btn btn-admin-outline btn-sm"><i class="bi bi-pencil"></i></a>
                            <form action="{{ route('admin.sponsors.destroy', $sponsor) }}" method="POST" class="d-inline" data-confirm="Remove this sponsor?">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm" type="submit"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">No sponsors yet. <a href="{{ route('admin.sponsors.create') }}">Add the first partner</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">{{ $sponsors->links() }}</div>
@endsection
