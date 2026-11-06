@extends('public.layout')

@section('title', 'Thank you for your support | 1000 Hills Rugby')
@section('meta_description', 'Thank you for supporting 1000 Hills Rugby.')

@section('content')
    <section class="page-hero" style="background-image: url('{{ asset('uploads/1740072895_fans.JPG') }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('donate') }}">Donate</a></li><li class="breadcrumb-item active">Thank you</li></ol>
            </nav>
            <h1>{{ $donation->is_completed ? 'Thank you for your generosity' : 'Thank you for standing with us' }}</h1>
            <p>Your support helps a young person stay in the game, stay in school and keep growing.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card-clean p-4 p-md-5">
                        <div class="d-flex align-items-start gap-3 mb-4">
                            <div class="rounded-circle d-grid flex-shrink-0" style="width:56px;height:56px;place-items:center;background:var(--hr-green-100);color:var(--hr-green-800);"><i class="bi bi-heart-fill fs-4"></i></div>
                            <div>
                                <h2 class="fs-4 mb-1">{{ $donation->is_completed ? 'Your donation is confirmed' : 'Your donation has been recorded' }}</h2>
                                <p class="text-muted-2 mb-0">
                                    @if($donation->is_completed)
                                        A confirmation has been recorded against reference <strong>{{ $donation->reference }}</strong>.
                                    @else
                                        We have saved your details under reference <strong>{{ $donation->reference }}</strong>. If you have completed payment, the club will confirm it shortly. Online card payments are being finalised.
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-borderless align-middle mb-0">
                                <tbody>
                                    <tr><td class="text-muted-2 ps-0">Reference</td><td class="text-end fw-semibold">{{ $donation->reference }}</td></tr>
                                    <tr><td class="text-muted-2 ps-0">Amount</td><td class="text-end fw-semibold">{{ format_rwf($donation->amount) }}@if($donation->original_currency && $donation->original_currency !== 'RWF') <span class="text-muted-2 fw-normal">({{ number_format((float) $donation->original_amount, 2) }} {{ $donation->original_currency }})</span>@endif</td></tr>
                                    <tr><td class="text-muted-2 ps-0">Purpose</td><td class="text-end fw-semibold">{{ $donation->purpose ?: 'General fund' }}</td></tr>
                                    <tr><td class="text-muted-2 ps-0">Status</td><td class="text-end"><span class="fixture-status {{ $donation->is_completed ? '' : 'completed' }}">{{ strtoupper($donation->status) }}</span></td></tr>
                                    <tr><td class="text-muted-2 ps-0">Date</td><td class="text-end fw-semibold">{{ $donation->created_at->format('d F Y, H:i') }}</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <a href="{{ route('home') }}" class="btn btn-forest">Back to home</a>
                            <a href="{{ route('news.index') }}" class="btn btn-outline-forest">Read our news</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
