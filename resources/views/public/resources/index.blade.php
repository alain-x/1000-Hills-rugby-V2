@extends('public.layout')

@section('title', 'Resources & downloads | 1000 Hills Rugby')
@section('meta_description', 'Club documents, calendars, forms and useful downloads from 1000 Hills Rugby.')

@section('content')
    <section class="page-hero" style="background-image: url('{{ asset('images/study.jpg') }}');">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Resources</li></ol>
            </nav>
            <h1>Resources</h1>
            <p>Club documents, season calendars, forms and information for players, families and partners.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <form action="{{ route('resources.index') }}" method="GET" class="filter-bar mb-4">
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-select">
                            <option value="">All categories</option>
                            @foreach($categories as $item)
                                <option value="{{ $item }}" @selected($category === $item)>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Year</label>
                        <select name="year" class="form-select">
                            <option value="">All years</option>
                            @foreach($years as $item)
                                <option value="{{ $item }}" @selected((string) $year === (string) $item)>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button class="btn btn-forest w-100" type="submit">Filter</button>
                        <a href="{{ route('resources.index') }}" class="btn btn-outline-forest" aria-label="Reset filters"><i class="bi bi-arrow-counterclockwise"></i></a>
                    </div>
                </div>
            </form>

            <div class="row g-3">
                @forelse($resources as $resource)
                    <div class="col-md-6 col-lg-4 reveal">
                        <article class="card-clean p-4 h-100 d-flex flex-column">
                            <div class="d-flex align-items-start justify-content-between mb-3">
                                <div class="rounded-3 d-grid" style="width:46px; height:46px; place-items:center; background:var(--hr-green-100); color:var(--hr-green-800);"><i class="bi bi-file-earmark-arrow-down fs-5"></i></div>
                                @if($resource->year)<span class="badge-category">{{ $resource->year }}</span>@endif
                            </div>
                            <h2 class="fs-5">{{ $resource->title }}</h2>
                            @if($resource->category)<div class="text-muted-2 small mb-2">{{ $resource->category }}</div>@endif
                            <p class="text-muted-2 small flex-grow-1">{{ $resource->description ?: 'Download this club resource.' }}</p>
                            <div class="d-flex align-items-center justify-content-between border-top pt-3 mt-2">
                                <span class="text-muted-2" style="font-size:.74rem;"><i class="bi bi-download me-1"></i>{{ number_format($resource->downloads) }} downloads</span>
                                <a href="{{ route('resources.download', $resource) }}" class="btn btn-forest btn-sm" @if($resource->is_external) target="_blank" rel="noopener" @endif>
                                    {{ $resource->is_external ? 'Open link' : 'Download' }} <i class="bi bi-arrow-down-right ms-1"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12"><div class="empty-state card-clean"><i class="bi bi-folder2-open"></i>No resources are available in this category yet.</div></div>
                @endforelse
            </div>

            <div class="mt-4 d-flex justify-content-center">{{ $resources->links() }}</div>
        </div>
    </section>
@endsection
