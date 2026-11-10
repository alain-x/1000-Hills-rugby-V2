@extends('admin.layouts.app')

@section('page_title', 'Site settings')
@section('page_subtitle', 'Branding, contact details and website defaults')

@section('content')
<div class="page-head">
    <div><h1>Site settings</h1><div class="sub">Changes apply across the public website immediately.</div></div>
</div>

@include('admin.partials.errors')

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="form-admin">
    @csrf
    @method('PUT')

    <div class="card-panel mb-4">
        <div class="card-panel-header">
            <h5 class="mb-0">Website settings</h5>
            <button class="btn btn-admin-forest" type="submit"><i class="bi bi-check2 me-1"></i>Save all settings</button>
        </div>
        <div class="card-panel-body">
            <ul class="nav nav-pills flex-wrap gap-2 mb-4" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-general" type="button" role="tab">General</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-branding" type="button" role="tab">Branding</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-home" type="button" role="tab">Homepage</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-contact" type="button" role="tab">Contact</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-social" type="button" role="tab">Social</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-donations" type="button" role="tab">Donations</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-seo" type="button" role="tab">SEO &amp; footer</button></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-general" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="site_name">Site name <span class="text-danger">*</span></label>
                            <input type="text" id="site_name" name="site_name" value="{{ old('site_name', setting('site_name', '1000 Hills Rugby')) }}" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="tagline">Tagline</label>
                            <input type="text" id="tagline" name="tagline" value="{{ old('tagline', setting('tagline')) }}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="founded_year">Founded year</label>
                            <input type="number" id="founded_year" name="founded_year" value="{{ old('founded_year', setting('founded_year', 2014)) }}" min="1900" max="2100" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="site_email">General email</label>
                            <input type="email" id="site_email" name="site_email" value="{{ old('site_email', setting('site_email')) }}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="contact_email">Enquiries email</label>
                            <input type="email" id="contact_email" name="contact_email" value="{{ old('contact_email', setting('contact_email')) }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="site_phone">Primary phone</label>
                            <input type="text" id="site_phone" name="site_phone" value="{{ old('site_phone', setting('site_phone')) }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="site_phone_alt">Secondary phone</label>
                            <input type="text" id="site_phone_alt" name="site_phone_alt" value="{{ old('site_phone_alt', setting('site_phone_alt')) }}" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-branding" role="tabpanel">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <label class="form-label" for="site_logo">Site logo</label>
                            @if(setting('site_logo'))
                                <img src="{{ media_url(setting('site_logo')) }}" alt="" class="w-100 rounded bg-light p-2 mb-2" style="height:100px;object-fit:contain;">
                            @endif
                            <input type="file" id="site_logo" name="site_logo" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="hero_image">Default hero image</label>
                            @if(setting('hero_image'))
                                <img src="{{ media_url(setting('hero_image')) }}" alt="" class="w-100 rounded mb-2" style="height:100px;object-fit:cover;">
                            @endif
                            <input type="file" id="hero_image" name="hero_image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="og_image">Social share image</label>
                            @if(setting('og_image'))
                                <img src="{{ media_url(setting('og_image')) }}" alt="" class="w-100 rounded mb-2" style="height:100px;object-fit:cover;">
                            @endif
                            <input type="file" id="og_image" name="og_image" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-home" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" for="hero_title">Hero headline</label>
                            <input type="text" id="hero_title" name="hero_title" value="{{ old('hero_title', setting('hero_title')) }}" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="hero_subtitle">Hero subtitle</label>
                            <textarea id="hero_subtitle" name="hero_subtitle" rows="2" class="form-control">{{ old('hero_subtitle', setting('hero_subtitle')) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="hero_cta_label">Hero button label</label>
                            <input type="text" id="hero_cta_label" name="hero_cta_label" value="{{ old('hero_cta_label', setting('hero_cta_label')) }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="hero_cta_url">Hero button URL</label>
                            <input type="text" id="hero_cta_url" name="hero_cta_url" value="{{ old('hero_cta_url', setting('hero_cta_url')) }}" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="about_short">Short about text</label>
                            <textarea id="about_short" name="about_short" rows="3" class="form-control">{{ old('about_short', setting('about_short')) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-contact" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" for="site_address">Address</label>
                            <input type="text" id="site_address" name="site_address" value="{{ old('site_address', setting('site_address')) }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="contact_image">Contact page image</label>
                            @if(setting('contact_image'))
                                <img src="{{ media_url(setting('contact_image')) }}" alt="" class="w-100 rounded mb-2" style="height:140px;object-fit:cover;">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="remove_contact_image" name="remove_contact_image" value="1">
                                    <label class="form-check-label" for="remove_contact_image">Remove this image</label>
                                </div>
                            @endif
                            <input type="file" id="contact_image" name="contact_image" class="form-control" accept="image/*">
                            <div class="form-text">Shown across the top of the public contact page. Remove it to use a plain green banner.</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="map_embed">Map embed code</label>
                            <textarea id="map_embed" name="map_embed" rows="4" class="form-control" placeholder="Paste the Google Maps iframe embed code">{{ old('map_embed', setting('map_embed')) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-social" role="tabpanel">
                    <div class="row g-3">
                        @foreach(['facebook_url' => 'Facebook', 'twitter_url' => 'X / Twitter', 'instagram_url' => 'Instagram', 'youtube_url' => 'YouTube', 'linkedin_url' => 'LinkedIn', 'tiktok_url' => 'TikTok'] as $key => $label)
                            <div class="col-md-6">
                                <label class="form-label" for="{{ $key }}">{{ $label }}</label>
                                <input type="url" id="{{ $key }}" name="{{ $key }}" value="{{ old($key, setting($key)) }}" class="form-control" placeholder="https://...">
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-donations" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" for="donation_intro">Donation introduction</label>
                            <textarea id="donation_intro" name="donation_intro" rows="3" class="form-control">{{ old('donation_intro', setting('donation_intro')) }}</textarea>
                            <div class="form-text">Shown at the top of the public donation page.</div>
                        </div>

                        <div class="col-12"><hr class="my-1"><h6 class="mb-0"><i class="bi bi-phone me-1"></i>Mobile Money</h6></div>
                        <div class="col-md-4">
                            <label class="form-label" for="donation_mobile_money_provider">Provider</label>
                            <input type="text" id="donation_mobile_money_provider" name="donation_mobile_money_provider" value="{{ old('donation_mobile_money_provider', setting('donation_mobile_money_provider')) }}" class="form-control" placeholder="e.g. MTN Mobile Money">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="donation_mobile_money_name">Account name</label>
                            <input type="text" id="donation_mobile_money_name" name="donation_mobile_money_name" value="{{ old('donation_mobile_money_name', setting('donation_mobile_money_name')) }}" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label" for="donation_mobile_money">Mobile money number</label>
                            <input type="text" id="donation_mobile_money" name="donation_mobile_money" value="{{ old('donation_mobile_money', setting('donation_mobile_money')) }}" class="form-control" placeholder="+250 ...">
                        </div>

                        <div class="col-12"><hr class="my-1"><h6 class="mb-0"><i class="bi bi-bank2 me-1"></i>Bank account</h6></div>
                        <div class="col-md-6">
                            <label class="form-label" for="donation_bank_name">Bank name</label>
                            <input type="text" id="donation_bank_name" name="donation_bank_name" value="{{ old('donation_bank_name', setting('donation_bank_name')) }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="donation_account_name">Account name</label>
                            <input type="text" id="donation_account_name" name="donation_account_name" value="{{ old('donation_account_name', setting('donation_account_name')) }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="donation_usd_account">USD account number</label>
                            <input type="text" id="donation_usd_account" name="donation_usd_account" value="{{ old('donation_usd_account', setting('donation_usd_account')) }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="donation_rwf_account">RWF account number</label>
                            <input type="text" id="donation_rwf_account" name="donation_rwf_account" value="{{ old('donation_rwf_account', setting('donation_rwf_account')) }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="donation_bank_swift">SWIFT / BIC</label>
                            <input type="text" id="donation_bank_swift" name="donation_bank_swift" value="{{ old('donation_bank_swift', setting('donation_bank_swift')) }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="donation_bank_branch">Branch / bank address</label>
                            <input type="text" id="donation_bank_branch" name="donation_bank_branch" value="{{ old('donation_bank_branch', setting('donation_bank_branch')) }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="donation_account_number">Other account number <span class="text-muted">(optional)</span></label>
                            <input type="text" id="donation_account_number" name="donation_account_number" value="{{ old('donation_account_number', setting('donation_account_number')) }}" class="form-control">
                            <div class="form-text">Only shown when no USD or RWF account is set.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="donation_reference">Payment reference</label>
                            <input type="text" id="donation_reference" name="donation_reference" value="{{ old('donation_reference', setting('donation_reference')) }}" class="form-control" placeholder="Donation">
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="tab-seo" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label" for="meta_title">Default meta title</label>
                            <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', setting('meta_title')) }}" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="meta_description">Default meta description</label>
                            <textarea id="meta_description" name="meta_description" rows="3" class="form-control">{{ old('meta_description', setting('meta_description')) }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="google_analytics_id">Google Analytics ID</label>
                            <input type="text" id="google_analytics_id" name="google_analytics_id" value="{{ old('google_analytics_id', setting('google_analytics_id')) }}" class="form-control" placeholder="G-XXXXXXXXXX">
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="footer_text">Footer text</label>
                            <textarea id="footer_text" name="footer_text" rows="3" class="form-control">{{ old('footer_text', setting('footer_text')) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mb-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-admin-outline">Cancel</a>
        <button class="btn btn-admin-forest" type="submit"><i class="bi bi-check2 me-1"></i>Save all settings</button>
    </div>
</form>
@endsection
