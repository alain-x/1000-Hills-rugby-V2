@extends('public.layout')

@section('title', 'Donate | Support 1000 Hills Rugby')
@section('meta_description', 'Your donation helps 1000 Hills Rugby provide kit, training, education support and safe spaces for young people in Kigali.')

@section('content')
    <section class="page-hero" style="background-image: url('{{ media_url('uploads/1740072895_fans.JPG') }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Donate</li></ol>
            </nav>
            <h1>Give a young person a chance to play</h1>
            <p>{{ setting('donation_intro', 'Every gift keeps a player in the game. Your support funds kit, transport, coaching, education and safe training spaces.') }}</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="card-clean p-4 p-md-5">
                        <span class="eyebrow">Make a donation</span>
                        <h2 class="fs-3 mb-1">Choose an amount</h2>
                        <p class="text-muted-2 small mb-4">All online card payments are processed securely. You will receive a confirmation with your reference.</p>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <div class="fw-semibold mb-1">Please check the form:</div>
                                <ul class="mb-0 ps-3">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                            </div>
                        @endif

                        <div class="d-flex flex-wrap gap-2 mb-4">
                            @foreach([5000, 10000, 25000, 50000, 100000] as $preset)
                                <button type="button" class="btn btn-outline-forest btn-sm" data-amount="{{ $preset }}">{{ number_format($preset) }} RWF</button>
                            @endforeach
                        </div>

                        <form action="{{ route('donate.store') }}" method="POST" class="form-admin">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="donation-name" class="form-label">Full name <span class="text-danger">*</span></label>
                                    <input type="text" id="donation-name" name="name" value="{{ old('name') }}" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="donation-email" class="form-label">Email address <span class="text-danger">*</span></label>
                                    <input type="email" id="donation-email" name="email" value="{{ old('email') }}" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="donation-phone" class="form-label">Phone number</label>
                                    <input type="text" id="donation-phone" name="phone" value="{{ old('phone') }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="donation-purpose" class="form-label">Direct my gift to</label>
                                    <select id="donation-purpose" name="purpose" class="form-select">
                                        @foreach(['General fund', 'Academy scholarships', 'Kit and equipment', 'Education support', 'Girls in rugby', 'Facilities'] as $purpose)
                                            <option value="{{ $purpose }}" @selected(old('purpose') === $purpose)>{{ $purpose }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <label for="donation-amount" class="form-label">Amount <span class="text-danger">*</span></label>
                                    <input type="number" id="donation-amount" name="amount" value="{{ old('amount') }}" min="100" step="1" class="form-control" placeholder="10000" required>
                                </div>
                                <div class="col-md-5">
                                    <label for="donation-currency" class="form-label">Currency <span class="text-danger">*</span></label>
                                    <select id="donation-currency" name="currency" class="form-select" required>
                                        @foreach($currencies as $code => $label)
                                            <option value="{{ $code }}" @selected(old('currency', 'RWF') === $code)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="donation-message" class="form-label">Message (optional)</label>
                                    <textarea id="donation-message" name="message" rows="3" class="form-control" placeholder="Add a note of encouragement...">{{ old('message') }}</textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-forest btn-lg w-100">Donate securely <i class="bi bi-arrow-right ms-1"></i></button>
                                    <p class="text-muted-2 small text-center mt-2 mb-0"><i class="bi bi-lock-fill me-1"></i>Card and mobile money payments are handled by Pesapal.</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <aside class="col-lg-5">
                    <div class="match-card mb-4">
                        <div class="match-label">Your impact</div>
                        <h2 class="text-white fs-4 mt-2">What your gift makes possible</h2>
                        <ul class="list-clean mt-3">
                            <li class="d-flex gap-2 py-2 text-white-50"><i class="bi bi-check-circle-fill text-gold mt-1"></i><span>A place in a safe, structured training session.</span></li>
                            <li class="d-flex gap-2 py-2 text-white-50"><i class="bi bi-check-circle-fill text-gold mt-1"></i><span>Boots, kit and protective equipment for a young player.</span></li>
                            <li class="d-flex gap-2 py-2 text-white-50"><i class="bi bi-check-circle-fill text-gold mt-1"></i><span>Transport and school support to keep players learning.</span></li>
                            <li class="d-flex gap-2 py-2 text-white-50"><i class="bi bi-check-circle-fill text-gold mt-1"></i><span>Coaching and safeguarding training for our volunteers.</span></li>
                        </ul>
                    </div>

                    <div class="card-clean p-4">
                        <h3 class="fs-5 mb-3"><i class="bi bi-bank2 text-gold me-2"></i>Other ways to give</h3>
                        @if(setting('donation_bank_name') || setting('donation_account_number'))
                            <div class="mb-3">
                                <div class="text-muted-2 small text-uppercase" style="letter-spacing:.1em;">Bank transfer</div>
                                @if(setting('donation_bank_name'))<div><strong>Bank:</strong> {{ setting('donation_bank_name') }}</div>@endif
                                @if(setting('donation_account_name'))<div><strong>Account name:</strong> {{ setting('donation_account_name') }}</div>@endif
                                @if(setting('donation_account_number'))<div><strong>Account number:</strong> {{ setting('donation_account_number') }}</div>@endif
                            </div>
                        @endif
                        @if(setting('donation_mobile_money'))
                            <div>
                                <div class="text-muted-2 small text-uppercase" style="letter-spacing:.1em;">Mobile money</div>
                                <div class="fw-semibold">{{ setting('donation_mobile_money') }}</div>
                            </div>
                        @endif
                        <p class="text-muted-2 small mt-3 mb-0">Please email <a href="mailto:{{ setting('site_email', 'info@1000hillsrugby.rw') }}">{{ setting('site_email', 'info@1000hillsrugby.rw') }}</a> after a bank transfer so we can thank you and issue a receipt.</p>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-amount]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const input = document.getElementById('donation-amount');
            if (input) {
                input.value = btn.getAttribute('data-amount');
                input.focus();
            }
        });
    });
</script>
@endpush
