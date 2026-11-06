@extends('public.layout')

@section('title', 'Staff & coaches | 1000 Hills Rugby')
@section('meta_description', 'Meet the coaches, staff and volunteers who make 1000 Hills Rugby possible.')

@section('content')
    <section class="page-hero" style="background-image: url('{{ media_url('images/coaches.jpg') }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Our people</li></ol>
            </nav>
            <h1>Our people</h1>
            <p>The coaches, staff and volunteers who give their time to help our players grow.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4">
                @forelse($staff as $member)
                    <div class="col-sm-6 col-lg-4 reveal">
                        <article class="card-clean h-100 overflow-hidden">
                            <div style="aspect-ratio:4/3.4; background:linear-gradient(160deg, var(--hr-green-800), var(--hr-green-950)); position:relative; overflow:hidden;">
                                @if($member->image)
                                    <img src="{{ media_url($member->image) }}" alt="{{ $member->name }}" class="w-100 h-100" style="object-fit:cover;" loading="lazy">
                                @else
                                    <div class="position-absolute inset-0 d-grid" style="place-items:center; font-family:Georgia,serif; font-size:3rem; color:rgba(255,255,255,.3);">
                                        {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($member->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="position-absolute bottom-0 start-0 m-3 badge-category" style="background:var(--hr-gold); color:var(--hr-green-950);">{{ $member->role ?: 'Club staff' }}</span>
                            </div>
                            <div class="p-4">
                                <h2 class="fs-5 mb-1">{{ $member->name }}</h2>
                                @if($member->bio)<p class="text-muted-2 small mb-3">{{ $member->bio }}</p>@endif
                                <div class="meta">
                                    @if($member->email)<a href="mailto:{{ $member->email }}" class="meta"><i class="bi bi-envelope me-1"></i>{{ $member->email }}</a>@endif
                                    @if($member->phone)<span><i class="bi bi-telephone me-1"></i>{{ $member->phone }}</span>@endif
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12"><div class="empty-state card-clean"><i class="bi bi-people"></i>Staff profiles will be published soon.</div></div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
