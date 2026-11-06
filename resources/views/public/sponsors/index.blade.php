@extends('public.layout')

@section('title', 'Partners & sponsors | 1000 Hills Rugby')
@section('meta_description', 'The partners and sponsors who support 1000 Hills Rugby and our community programmes.')

@section('content')
    <section class="page-hero" style="background-image: url('{{ media_url('uploads/1740072895_fans.JPG') }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Partners</li></ol>
            </nav>
            <h1>Our partners</h1>
            <p>Thank you to the organisations and individuals who stand with our players and community.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            @php($grouped = $sponsors->groupBy(fn ($s) => $s->tier ?: 'Our partners'))
            @forelse($grouped as $tier => $group)
                <div class="mb-5">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <h2 class="section-title fs-3 mb-0">{{ $tier }}</h2>
                        <span class="title-rule mb-0"></span>
                    </div>
                    <div class="row g-3">
                        @foreach($group as $sponsor)
                            <div class="col-6 col-md-4 col-lg-3 reveal">
                                <div class="card-clean h-100 p-4 text-center d-flex flex-column align-items-center justify-content-center">
                                    @if($sponsor->logo_path)
                                        <img src="{{ media_url($sponsor->logo_path) }}" alt="{{ $sponsor->name ?: 'Partner' }}" style="max-height:78px; max-width:100%; object-fit:contain;" loading="lazy">
                                    @else
                                        <div class="display-font fs-5 text-forest">{{ $sponsor->name ?: 'Partner' }}</div>
                                    @endif
                                    @if($sponsor->name && $sponsor->logo_path)<div class="fw-semibold mt-3">{{ $sponsor->name }}</div>@endif
                                    @if($sponsor->description)<p class="text-muted-2 small mt-2 mb-0">{{ $sponsor->description }}</p>@endif
                                    @if($sponsor->website)
                                        <a href="{{ $sponsor->website }}" target="_blank" rel="noopener" class="small mt-3">Visit website <i class="bi bi-box-arrow-up-right ms-1"></i></a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="empty-state card-clean"><i class="bi bi-hand-thumbs-up"></i>Our partner profiles will be published soon.</div>
            @endforelse

            <div class="newsletter-box mt-4">
                <div class="row align-items-center g-4 position-relative" style="z-index:1;">
                    <div class="col-lg-8">
                        <span class="eyebrow">Partner with us</span>
                        <h3 class="mb-2">Your brand can help change a young person's story.</h3>
                        <p class="mb-0">From kit and equipment to education support, there are meaningful ways to partner with 1000 Hills Rugby.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ route('contact.create') }}" class="btn btn-gold">Start a conversation</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
