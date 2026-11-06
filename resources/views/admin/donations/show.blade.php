@extends('admin.layouts.app')

@section('page_title', 'Donation')
@section('page_subtitle', $donation->reference)

@section('content')
<div class="page-head">
    <div><h1>Donation {{ $donation->reference }}</h1><div class="sub">Received {{ $donation->created_at->format('d M Y \a\t H:i') }}</div></div>
    <a href="{{ route('admin.donations.index') }}" class="btn btn-admin-outline"><i class="bi bi-arrow-left me-1"></i>Back to donations</a>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card-panel mb-4">
            <div class="card-panel-header"><h5 class="mb-0">Donation details</h5></div>
            <div class="card-panel-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4 text-muted">Reference</dt><dd class="col-sm-8"><code>{{ $donation->reference }}</code></dd>
                    <dt class="col-sm-4 text-muted">Donor</dt><dd class="col-sm-8">{{ $donation->name }}</dd>
                    <dt class="col-sm-4 text-muted">Email</dt><dd class="col-sm-8"><a href="mailto:{{ $donation->email }}">{{ $donation->email }}</a></dd>
                    <dt class="col-sm-4 text-muted">Phone</dt><dd class="col-sm-8">{{ $donation->phone ?: '—' }}</dd>
                    <dt class="col-sm-4 text-muted">Amount</dt><dd class="col-sm-8 fw-semibold">{{ format_rwf($donation->amount) }}</dd>
                    @if($donation->original_currency && $donation->original_currency !== 'RWF')
                        <dt class="col-sm-4 text-muted">Original amount</dt><dd class="col-sm-8">{{ number_format((float) $donation->original_amount, 2) }} {{ $donation->original_currency }} @ {{ number_format((float) $donation->fx_rate_to_rwf, 2) }} RWF</dd>
                    @endif
                    <dt class="col-sm-4 text-muted">Purpose</dt><dd class="col-sm-8">{{ $donation->purpose ?: 'General fund' }}</dd>
                    <dt class="col-sm-4 text-muted">Status</dt><dd class="col-sm-8">{{ $donation->status }}</dd>
                    <dt class="col-sm-4 text-muted">Payment status</dt><dd class="col-sm-8">{{ $donation->payment_status ?: '—' }}</dd>
                    <dt class="col-sm-4 text-muted">Payment method</dt><dd class="col-sm-8">{{ $donation->payment_method ?: '—' }}</dd>
                    <dt class="col-sm-4 text-muted">Confirmation code</dt><dd class="col-sm-8">{{ $donation->confirmation_code ?: '—' }}</dd>
                    <dt class="col-sm-4 text-muted">Order tracking ID</dt><dd class="col-sm-8 text-break">{{ $donation->order_tracking_id ?: '—' }}</dd>
                    <dt class="col-sm-4 text-muted">Paid at</dt><dd class="col-sm-8">{{ optional($donation->paid_at)->format('d M Y H:i') ?: '—' }}</dd>
                </dl>
                @if($donation->message)
                    <hr>
                    <h6 class="text-muted">Donor message</h6>
                    <p class="mb-0" style="white-space:pre-line;">{{ $donation->message }}</p>
                @endif
            </div>
        </div>

        @if($donation->gateway_response)
            <div class="card-panel">
                <div class="card-panel-header"><h5 class="mb-0">Gateway response</h5></div>
                <div class="card-panel-body">
                    <pre class="mb-0 small bg-light p-3 rounded" style="max-height:420px;overflow:auto;">{{ json_encode($donation->gateway_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                </div>
            </div>
        @endif
    </div>
    <div class="col-xl-4">
        <div class="card-panel">
            <div class="card-panel-header"><h5 class="mb-0">Timeline</h5></div>
            <div class="card-panel-body">
                <div class="d-flex justify-content-between border-bottom py-2"><span class="text-muted small">Created</span><span class="small">{{ $donation->created_at->format('d M Y H:i') }}</span></div>
                <div class="d-flex justify-content-between border-bottom py-2"><span class="text-muted small">Last updated</span><span class="small">{{ $donation->updated_at->format('d M Y H:i') }}</span></div>
                <div class="d-flex justify-content-between py-2"><span class="text-muted small">Completed</span><span class="small">{{ $donation->is_completed ? 'Yes' : 'No' }}</span></div>
            </div>
        </div>
    </div>
</div>
@endsection
