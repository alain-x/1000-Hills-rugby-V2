@extends('admin.layouts.app')

@section('page_title', 'Performance report')
@section('page_subtitle', $report->player->name.' · '.$report->team->name)

@section('content')
<div class="page-head">
    <div>
        <h1>{{ $report->player->name }}</h1>
        <div class="sub">{{ $report->team->name }} · {{ $report->report_date->format('d M Y') }} · Coach {{ $report->coach->name }}</div>
    </div>
    <div class="d-flex gap-2">
        @if(auth()->id() === $report->coach_id)
            <a href="{{ route('admin.reports.edit', $report) }}" class="btn btn-admin-forest">Edit</a>
            <form action="{{ route('admin.reports.destroy', $report) }}" method="POST" data-confirm="Delete this report?">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger" type="submit">Delete</button>
            </form>
        @endif
        <a href="{{ route('admin.reports.index') }}" class="btn btn-admin-outline">Back</a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Rating {{ number_format($report->rating, 1) }} / 5</h5></div>
            <div class="card-panel-body">
                @foreach(\App\Models\PlayerReport::SCORES as $field => $label)
                    <div class="d-flex justify-content-between py-2 {{ $loop->last ? '' : 'border-bottom' }}">
                        <span>{{ $label }}</span>
                        <strong>{{ $report->{$field} }} / 5</strong>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Coach report</h5></div>
            <div class="card-panel-body" style="white-space:pre-wrap;">{{ $report->report }}</div>
        </div>
    </div>
</div>
@endsection
