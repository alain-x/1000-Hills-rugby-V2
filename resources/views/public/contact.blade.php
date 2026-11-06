@extends('public.layout')

@section('title', 'Contact us | 1000 Hills Rugby')
@section('meta_description', 'Get in touch with 1000 Hills Rugby in Kigali, Rwanda. Enquire about joining, partnerships, media or volunteering.')

@section('content')
    <section class="page-hero" style="background-image: url('{{ media_url('images/contact-home-page.jpg') }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Contact</li></ol>
            </nav>
            <h1>Let's talk rugby</h1>
            <p>Whether you want to play, volunteer, partner with us or simply say hello, we would love to hear from you.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5">
                    <span class="eyebrow">Get in touch</span>
                    <h2 class="section-title">We're part of the community</h2>
                    <p class="section-lead">Find us at our home ground in Kicukiro, or reach out by phone or email. We respond to every message.</p>

                    <ul class="list-clean mt-4">
                        <li class="d-flex gap-3 py-3 border-bottom">
                            <div class="rounded-3 d-grid flex-shrink-0" style="width:46px;height:46px;place-items:center;background:var(--hr-green-100);color:var(--hr-green-800);"><i class="bi bi-geo-alt-fill"></i></div>
                            <div><div class="text-muted-2 small text-uppercase" style="letter-spacing:.1em;">Visit us</div><div class="fw-semibold">{{ setting('site_address', 'KK 591 St, Kicukiro, Kigali, Rwanda') }}</div></div>
                        </li>
                        <li class="d-flex gap-3 py-3 border-bottom">
                            <div class="rounded-3 d-grid flex-shrink-0" style="width:46px;height:46px;place-items:center;background:var(--hr-green-100);color:var(--hr-green-800);"><i class="bi bi-telephone-fill"></i></div>
                            <div><div class="text-muted-2 small text-uppercase" style="letter-spacing:.1em;">Call us</div><div class="fw-semibold">{{ setting('site_phone', '+250 788 261 386') }}</div>@if(setting('site_phone_alt'))<div class="text-muted-2 small">{{ setting('site_phone_alt') }}</div>@endif</div>
                        </li>
                        <li class="d-flex gap-3 py-3">
                            <div class="rounded-3 d-grid flex-shrink-0" style="width:46px;height:46px;place-items:center;background:var(--hr-green-100);color:var(--hr-green-800);"><i class="bi bi-envelope-fill"></i></div>
                            <div><div class="text-muted-2 small text-uppercase" style="letter-spacing:.1em;">Email us</div><a href="mailto:{{ setting('site_email', 'info@1000hillsrugby.rw') }}" class="fw-semibold">{{ setting('site_email', 'info@1000hillsrugby.rw') }}</a></div>
                        </li>
                    </ul>

                    @if(setting('map_embed'))
                        <div class="mt-3 rounded-xl overflow-hidden">{!! setting('map_embed') !!}</div>
                    @endif
                </div>

                <div class="col-lg-7">
                    <div class="card-clean p-4 p-md-5">
                        <h2 class="fs-4 mb-1">Send us a message</h2>
                        <p class="text-muted-2 small mb-4">Fill in the form below and a member of the club team will get back to you.</p>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <div class="fw-semibold mb-1">Please check the form:</div>
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST" class="form-admin">
                            @csrf
                            <input type="text" name="website" value="" class="d-none" tabindex="-1" autocomplete="off" aria-hidden="true">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full name <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email address <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone number</label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}" class="form-control" placeholder="e.g. Joining the academy">
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                    <textarea id="message" name="message" rows="6" class="form-control" required>{{ old('message') }}</textarea>
                                </div>
                                <div class="col-12 d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <span class="text-muted-2 small"><i class="bi bi-shield-check me-1"></i>Your details are kept private.</span>
                                    <button type="submit" class="btn btn-forest px-4">Send message <i class="bi bi-send ms-1"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
