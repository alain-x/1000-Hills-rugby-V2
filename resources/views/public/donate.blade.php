@extends('public.layout')

@section('title', 'Donate | Support 1000 Hills Rugby')
@section('meta_description', 'Support 1000 Hills Rugby by Mobile Money or bank transfer. Your gift provides kit, training, education support and safe spaces for young people in Kigali.')

@php
    $email = setting('site_email', 'info@1000hillsrugby.rw');
    $phone = setting('site_phone', '+250 788 261 386');
    $reference = setting('donation_reference', 'Donation');

    $momoNumber = setting('donation_mobile_money');
    $momoName = setting('donation_mobile_money_name');
    $momoProvider = setting('donation_mobile_money_provider');

    $bankName = setting('donation_bank_name');
    $accountName = setting('donation_account_name');
    $usdAccount = setting('donation_usd_account');
    $rwfAccount = setting('donation_rwf_account');
    $singleAccount = setting('donation_account_number');
    $swift = setting('donation_bank_swift');
    $branch = setting('donation_bank_branch');

    $hasMomo = filled($momoNumber);
    $hasBank = filled($usdAccount) || filled($rwfAccount) || filled($singleAccount);
    $cardColumn = $hasMomo && $hasBank ? 'col-lg-6' : 'col-lg-8 mx-auto';
@endphp

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
            @if($hasMomo || $hasBank)
                <div class="row g-4 align-items-stretch">
                    @if($hasMomo)
                        <div class="{{ $cardColumn }}">
                            <div class="card-clean give-card give-card-momo h-100 p-4 p-md-5">
                                <div class="give-icon"><i class="bi bi-phone"></i></div>
                                <span class="eyebrow">Fastest way to give</span>
                                <h2 class="fs-3 mt-2 mb-2">Mobile Money</h2>
                                <p class="text-muted-2 small mb-0">Send your gift straight from your phone using the details below.</p>

                                <div class="give-details mt-4">
                                    @if(filled($momoProvider))
                                        <div class="give-row">
                                            <span class="label">Provider</span>
                                            <span class="value">{{ $momoProvider }}</span>
                                        </div>
                                    @endif
                                    @if(filled($momoName))
                                        <div class="give-row">
                                            <span class="label">Account name</span>
                                            <span class="value">{{ $momoName }}</span>
                                        </div>
                                    @endif
                                    <div class="give-row">
                                        <span class="label">Number</span>
                                        <span class="value">
                                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $momoNumber) }}">{{ $momoNumber }}</a>
                                            <button type="button" class="copy-btn" data-copy="{{ $momoNumber }}" title="Copy number" aria-label="Copy mobile money number"><i class="bi bi-copy"></i></button>
                                        </span>
                                    </div>
                                    @if(filled($reference))
                                        <div class="give-row">
                                            <span class="label">Reference</span>
                                            <span class="value">{{ $reference }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="give-note mt-4">
                                    <i class="bi bi-info-circle me-1"></i>
                                    After sending, email <a href="mailto:{{ $email }}?subject=Mobile%20Money%20donation">{{ $email }}</a> with the transaction reference so we can thank you and issue a receipt.
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($hasBank)
                        <div class="{{ $cardColumn }}">
                            <div class="card-clean give-card give-card-bank h-100 p-4 p-md-5">
                                <div class="give-icon"><i class="bi bi-bank2"></i></div>
                                <span class="eyebrow">Direct transfer</span>
                                <h2 class="fs-3 mt-2 mb-2">Bank account</h2>
                                <p class="text-muted-2 small mb-0">Use your bank app or visit a branch to transfer your gift directly to the club.</p>

                                <div class="give-details mt-4">
                                    @if(filled($accountName))
                                        <div class="give-row">
                                            <span class="label">Account name</span>
                                            <span class="value">{{ $accountName }}</span>
                                        </div>
                                    @endif
                                    @if(filled($bankName))
                                        <div class="give-row">
                                            <span class="label">Bank</span>
                                            <span class="value">{{ $bankName }}</span>
                                        </div>
                                    @endif
                                    @if(filled($usdAccount))
                                        <div class="give-row">
                                            <span class="label">USD account</span>
                                            <span class="value">
                                                {{ $usdAccount }}
                                                <button type="button" class="copy-btn" data-copy="{{ $usdAccount }}" title="Copy USD account number" aria-label="Copy USD account number"><i class="bi bi-copy"></i></button>
                                            </span>
                                        </div>
                                    @endif
                                    @if(filled($rwfAccount))
                                        <div class="give-row">
                                            <span class="label">RWF account</span>
                                            <span class="value">
                                                {{ $rwfAccount }}
                                                <button type="button" class="copy-btn" data-copy="{{ $rwfAccount }}" title="Copy RWF account number" aria-label="Copy RWF account number"><i class="bi bi-copy"></i></button>
                                            </span>
                                        </div>
                                    @endif
                                    @if(filled($singleAccount) && ! filled($usdAccount) && ! filled($rwfAccount))
                                        <div class="give-row">
                                            <span class="label">Account number</span>
                                            <span class="value">
                                                {{ $singleAccount }}
                                                <button type="button" class="copy-btn" data-copy="{{ $singleAccount }}" title="Copy account number" aria-label="Copy account number"><i class="bi bi-copy"></i></button>
                                            </span>
                                        </div>
                                    @endif
                                    @if(filled($swift))
                                        <div class="give-row">
                                            <span class="label">SWIFT / BIC</span>
                                            <span class="value">{{ $swift }}</span>
                                        </div>
                                    @endif
                                    @if(filled($branch))
                                        <div class="give-row">
                                            <span class="label">Branch</span>
                                            <span class="value">{{ $branch }}</span>
                                        </div>
                                    @endif
                                    @if(filled($reference))
                                        <div class="give-row">
                                            <span class="label">Reference</span>
                                            <span class="value">{{ $reference }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="give-note mt-4">
                                    <i class="bi bi-info-circle me-1"></i>
                                    After transferring, email <a href="mailto:{{ $email }}?subject=Bank%20transfer%20donation">{{ $email }}</a> with your proof of payment so we can thank you and issue a receipt.
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="card-clean p-4 p-md-5 text-center">
                    <div class="give-icon mx-auto"><i class="bi bi-heart"></i></div>
                    <h2 class="fs-3 mb-2">Donation details are being updated</h2>
                    <p class="text-muted-2 mb-4">Please contact the club directly and we will share the current Mobile Money and bank details with you.</p>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a href="mailto:{{ $email }}" class="btn btn-forest"><i class="bi bi-envelope me-1"></i>{{ $email }}</a>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="btn btn-outline-forest"><i class="bi bi-telephone me-1"></i>{{ $phone }}</a>
                    </div>
                </div>
            @endif

            <div class="row g-4 mt-4">
                <div class="col-lg-8">
                    <div class="match-card p-4 p-md-5">
                        <div class="match-label">Your impact</div>
                        <h2 class="text-white fs-3 mt-2 mb-3">What your gift makes possible</h2>
                        <ul class="list-clean">
                            <li class="d-flex gap-2 py-2 text-white-50"><i class="bi bi-check-circle-fill text-gold mt-1"></i><span>A place in a safe, structured training session.</span></li>
                            <li class="d-flex gap-2 py-2 text-white-50"><i class="bi bi-check-circle-fill text-gold mt-1"></i><span>Boots, kit and protective equipment for a young player.</span></li>
                            <li class="d-flex gap-2 py-2 text-white-50"><i class="bi bi-check-circle-fill text-gold mt-1"></i><span>Transport and school support to keep players learning.</span></li>
                            <li class="d-flex gap-2 py-2 text-white-50"><i class="bi bi-check-circle-fill text-gold mt-1"></i><span>Coaching and safeguarding training for our volunteers.</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card-clean p-4 h-100">
                        <h3 class="fs-5 mb-2"><i class="bi bi-chat-heart text-gold me-2"></i>Need a hand?</h3>
                        <p class="text-muted-2 small">Questions about giving, corporate partnerships or in-kind support? We would love to hear from you.</p>
                        <div class="d-grid gap-2">
                            <a href="mailto:{{ $email }}" class="btn btn-outline-forest btn-sm"><i class="bi bi-envelope me-1"></i>{{ $email }}</a>
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}" class="btn btn-outline-forest btn-sm"><i class="bi bi-telephone me-1"></i>{{ $phone }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-copy]').forEach(function (button) {
        button.addEventListener('click', function () {
            var value = button.getAttribute('data-copy');
            var icon = button.querySelector('i');
            var originalIcon = icon ? icon.className : '';

            function copied() {
                if (icon) { icon.className = 'bi bi-check2'; }
                button.classList.add('copied');
                window.setTimeout(function () {
                    if (icon) { icon.className = originalIcon; }
                    button.classList.remove('copied');
                }, 1800);
            }

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(value).then(copied).catch(function () {});
                return;
            }

            var input = document.createElement('textarea');
            input.value = value;
            input.setAttribute('readonly', 'readonly');
            input.style.position = 'absolute';
            input.style.left = '-9999px';
            document.body.appendChild(input);
            input.select();
            try { document.execCommand('copy'); copied(); } catch (error) {}
            document.body.removeChild(input);
        });
    });
</script>
@endpush
