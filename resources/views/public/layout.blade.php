<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $metaTitle = trim($__env->yieldContent('title')) ?: (setting('meta_title') ?: setting('site_name', '1000 Hills Rugby'));
        $metaDescription = trim($__env->yieldContent('meta_description')) ?: (setting('meta_description') ?: 'Official home of 1000 Hills Rugby, a community rugby club in Kigali, Rwanda, developing players on and off the field.');
        $shareImage = trim($__env->yieldContent('og_image')) ?: media_url(setting('og_image'), 'uploads/1740072895_fans.JPG');
    @endphp

    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="theme-color" content="#063a2b">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ setting('site_name', '1000 Hills Rugby') }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:image" content="{{ $shareImage }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" type="image/png" href="{{ media_url('images/favicon-32x32.png') }}">
    <link rel="apple-touch-icon" href="{{ media_url('images/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('images/site.webmanifest') }}">

    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v={{ filemtime(public_path('css/site.css')) }}">

    @if(setting('google_analytics_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ setting('google_analytics_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', @json(setting('google_analytics_id')));
        </script>
    @endif

    @stack('head')
</head>
<body>

<div class="topbar d-none d-md-block">
    <div class="container d-flex align-items-center justify-content-between">
        <div>
            <i class="bi bi-geo-alt-fill me-1"></i> {{ setting('site_address', 'Kicukiro, Kigali, Rwanda') }}
            <span class="divider">|</span>
            <a href="mailto:{{ setting('site_email', 'info@1000hillsrugby.rw') }}"><i class="bi bi-envelope me-1"></i>{{ setting('site_email', 'info@1000hillsrugby.rw') }}</a>
        </div>
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('donate') }}"><i class="bi bi-heart-fill me-1"></i>Support the club</a>
            <span class="divider">|</span>
            <a href="{{ route('admin.login') }}"><i class="bi bi-shield-lock me-1"></i>Staff login</a>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg site-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ site_logo() }}" alt="{{ setting('site_name', '1000 Hills Rugby') }} logo">
            <span class="brand-text">
                <span class="brand-name">1000 Hills Rugby</span>
                <span class="brand-tag">Rugby for life</span>
            </span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list fs-1 text-dark"></i>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}" href="{{ route('news.index') }}">News</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('fixtures.*') ? 'active' : '' }}" href="{{ route('fixtures.index') }}">Fixtures</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('tables.*') ? 'active' : '' }}" href="{{ route('tables.index') }}">Tables</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('teams.*', 'players.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Teams</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('teams.index') }}">All squads</a></li>
                        <li><hr class="dropdown-divider"></li>
                        @foreach(\App\Models\Team::active()->take(6)->get() as $navTeam)
                            <li><a class="dropdown-item" href="{{ route('teams.show', $navTeam) }}">{{ $navTeam->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}" href="{{ route('events.index') }}">Events</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('pages.*', 'staff.*', 'sponsors.*', 'resources.*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Club</a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('pages.show', 'about') }}">Our story</a></li>
                        <li><a class="dropdown-item" href="{{ route('pages.show', 'academy') }}">Academy</a></li>
                        <li><a class="dropdown-item" href="{{ route('pages.show', 'foundation') }}">Foundation</a></li>
                        <li><a class="dropdown-item" href="{{ route('pages.show', 'community') }}">Community</a></li>
                        <li><a class="dropdown-item" href="{{ route('pages.show', 'education') }}">Education</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('staff.index') }}">Staff &amp; coaches</a></li>
                        <li><a class="dropdown-item" href="{{ route('sponsors.index') }}">Partners</a></li>
                        <li><a class="dropdown-item" href="{{ route('resources.index') }}">Resources</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact.*') ? 'active' : '' }}" href="{{ route('contact.create') }}">Contact</a></li>
                <li class="nav-item"><a class="btn btn-gold btn-sm nav-donate px-3" href="{{ route('donate') }}"><i class="bi bi-heart-fill me-1"></i>Donate</a></li>
            </ul>
        </div>
    </div>
</nav>

@if(session('success') || session('status') || session('info'))
    <div class="container mt-3">
        @foreach(['success' => 'success', 'status' => 'info', 'info' => 'info'] as $key => $type)
            @if(session($key))
                <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert" data-autohide>
                    {{ session($key) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        @endforeach
    </div>
@endif

<main>
    @yield('content')
</main>

<footer class="site-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="footer-brand">
                    <img src="{{ site_logo() }}" alt="{{ setting('site_name', '1000 Hills Rugby') }}">
                    <p>{{ setting('footer_text', '1000 Hills Rugby is a community rugby club in Kigali, Rwanda. We use rugby to build discipline, confidence and opportunity for young people.') }}</p>
                    <div class="social-icons">
                        @foreach(['facebook_url' => 'facebook', 'twitter_url' => 'twitter-x', 'instagram_url' => 'instagram', 'youtube_url' => 'youtube', 'linkedin_url' => 'linkedin', 'tiktok_url' => 'tiktok'] as $key => $icon)
                            @if(setting($key))
                                <a href="{{ setting($key) }}" target="_blank" rel="noopener" aria-label="{{ ucfirst(str_replace('_url', '', $key)) }}"><i class="bi bi-{{ $icon }}"></i></a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-2">
                <h5>Explore</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('news.index') }}">News</a></li>
                    <li><a href="{{ route('fixtures.index') }}">Fixtures</a></li>
                    <li><a href="{{ route('tables.index') }}">League tables</a></li>
                    <li><a href="{{ route('teams.index') }}">Teams</a></li>
                    <li><a href="{{ route('events.index') }}">Events</a></li>
                </ul>
            </div>
            <div class="col-6 col-lg-2">
                <h5>The club</h5>
                <ul class="footer-links">
                    <li><a href="{{ route('pages.show', 'about') }}">About us</a></li>
                    <li><a href="{{ route('pages.show', 'academy') }}">Academy</a></li>
                    <li><a href="{{ route('pages.show', 'foundation') }}">Foundation</a></li>
                    <li><a href="{{ route('staff.index') }}">Our people</a></li>
                    <li><a href="{{ route('sponsors.index') }}">Partners</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h5>Get in touch</h5>
                <ul class="footer-contact">
                    <li><i class="bi bi-geo-alt-fill"></i><span>{{ setting('site_address', 'KK 591 St, Kicukiro, Kigali, Rwanda') }}</span></li>
                    <li><i class="bi bi-telephone-fill"></i><span>{{ setting('site_phone', '+250 788 261 386') }}@if(setting('site_phone_alt')) &nbsp;·&nbsp; {{ setting('site_phone_alt') }}@endif</span></li>
                    <li><i class="bi bi-envelope-fill"></i><a href="mailto:{{ setting('site_email', 'info@1000hillsrugby.rw') }}">{{ setting('site_email', 'info@1000hillsrugby.rw') }}</a></li>
                </ul>
                <a href="{{ route('contact.create') }}" class="btn btn-outline-light btn-sm mt-1">Send us a message <i class="bi bi-arrow-right ms-1"></i></a>
            </div>
        </div>
        <div class="footer-bottom d-flex flex-wrap justify-content-between gap-2">
            <span>&copy; {{ date('Y') }} {{ setting('site_name', '1000 Hills Rugby') }}. All rights reserved.</span>
            <span>
                <a href="{{ route('pages.show', 'privacy') }}">Privacy policy</a>
                <span class="mx-2 opacity-50">|</span>
                <a href="{{ route('sitemap') }}">Sitemap</a>
            </span>
        </div>
    </div>
</footer>

<button type="button" class="btn btn-gold position-fixed bottom-0 end-0 m-3 rounded-circle shadow" id="backToTop" style="display:none; width:46px; height:46px; z-index:1030;" aria-label="Back to top">
    <i class="bi bi-arrow-up"></i>
</button>

<script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/site.js') }}"></script>
<script>
    (function () {
        const btn = document.getElementById('backToTop');
        if (!btn) return;
        window.addEventListener('scroll', function () {
            btn.style.display = window.scrollY > 500 ? 'inline-flex' : 'none';
            btn.classList.toggle('align-items-center', true);
            btn.classList.toggle('justify-content-center', true);
        }, { passive: true });
        btn.addEventListener('click', function () { window.scrollTo({ top: 0, behavior: 'smooth' }); });
    })();
</script>
@stack('scripts')
</body>
</html>
