@extends('admin.layouts.app')

@section('page_title', 'Dashboard')
@section('page_subtitle', 'Overview of content, enquiries and donations')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-tile">
            <div class="stat-tile-icon"><i class="bi bi-newspaper"></i></div>
            <div>
                <div class="stat-tile-value">{{ number_format($stats['articles']) }}</div>
                <div class="stat-tile-label">Articles</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-tile">
            <div class="stat-tile-icon"><i class="bi bi-people"></i></div>
            <div>
                <div class="stat-tile-value">{{ number_format($stats['players']) }}</div>
                <div class="stat-tile-label">Players</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-tile">
            <div class="stat-tile-icon"><i class="bi bi-calendar2-check"></i></div>
            <div>
                <div class="stat-tile-value">{{ number_format($stats['fixtures']) }}</div>
                <div class="stat-tile-label">Upcoming fixtures</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-tile">
            <div class="stat-tile-icon"><i class="bi bi-heart"></i></div>
            <div>
                <div class="stat-tile-value">{{ format_rwf($stats['donations_total']) }}</div>
                <div class="stat-tile-label">{{ $stats['donations_count'] }} completed donations</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-xl-8">
        <div class="card-panel mb-4">
            <div class="card-panel-header">
                <div>
                    <h5 class="mb-0">Recent articles</h5>
                    <span class="text-muted small">Latest content published or drafted</span>
                </div>
                <a href="{{ route('admin.articles.create') }}" class="btn btn-admin-forest btn-sm"><i class="bi bi-plus-lg me-1"></i>New article</a>
            </div>
            <div class="card-panel-table">
                <div class="table-responsive">
                    <table class="table table-admin">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Published</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentArticles as $article)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $article->title }}</div>
                                        <div class="text-muted small">{{ $article->views }} views</div>
                                    </td>
                                    <td><span class="badge-soft">{{ $article->category }}</span></td>
                                    <td>{!! $article->is_published ? '<span class="badge-soft">Published</span>' : '<span class="badge-muted">Draft</span>' !!}</td>
                                    <td class="text-muted small">{{ optional($article->published_at ?? $article->created_at)->format('d M Y') }}</td>
                                    <td class="text-end"><a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-admin-outline btn-sm"><i class="bi bi-pencil"></i></a></td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center text-muted py-4">No articles yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card-panel">
            <div class="card-panel-header">
                <div>
                    <h5 class="mb-0">Donations over the last 6 months</h5>
                    <span class="text-muted small">Completed donations by month (RWF)</span>
                </div>
                <a href="{{ route('admin.donations.index') }}" class="btn btn-admin-outline btn-sm">View all</a>
            </div>
            <div class="card-panel-body">
                <canvas id="donationsChart" height="110"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card-panel mb-4">
            <div class="card-panel-header">
                <div>
                    <h5 class="mb-0">Unread messages</h5>
                    <span class="text-muted small">{{ $stats['unread'] }} waiting for review</span>
                </div>
                <a href="{{ route('admin.messages.index') }}" class="btn btn-admin-outline btn-sm">Inbox</a>
            </div>
            <div class="list-group list-group-flush">
                @forelse($recentMessages as $message)
                    <a href="{{ route('admin.messages.show', $message) }}" class="list-group-item list-group-item-action px-4 py-3">
                        <div class="d-flex justify-content-between">
                            <div class="fw-semibold">{{ $message->name }}</div>
                            <div class="text-muted small">{{ $message->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="text-muted small">{{ $message->email }}</div>
                        <div class="text-muted small text-truncate mt-1">{{ $message->subject ?: $message->message }}</div>
                    </a>
                @empty
                    <div class="p-4 text-center text-muted small">No messages.</div>
                @endforelse
            </div>
        </div>

        <div class="card-panel mb-4">
            <div class="card-panel-header">
                <div>
                    <h5 class="mb-0">Upcoming fixtures</h5>
                    <span class="text-muted small">Published and scheduled</span>
                </div>
                <a href="{{ route('admin.fixtures.create') }}" class="btn btn-admin-outline btn-sm">Add fixture</a>
            </div>
            <div class="list-group list-group-flush">
                @forelse($upcoming as $fixture)
                    <a href="{{ route('admin.fixtures.edit', $fixture) }}" class="list-group-item list-group-item-action px-4 py-3">
                        <div class="d-flex justify-content-between">
                            <div class="fw-semibold">{{ $fixture->home_team }} v {{ $fixture->away_team }}</div>
                            <div class="text-muted small">{{ optional($fixture->match_date)->format('d M') }}</div>
                        </div>
                        <div class="text-muted small">{{ $fixture->competition ?: 'Friendly' }} · {{ $fixture->stadium ?: 'TBC' }}</div>
                    </a>
                @empty
                    <div class="p-4 text-center text-muted small">No upcoming fixtures.</div>
                @endforelse
            </div>
        </div>

        <div class="card-panel">
            <div class="card-panel-header">
                <div>
                    <h5 class="mb-0">Popular stories</h5>
                    <span class="text-muted small">Most viewed articles</span>
                </div>
            </div>
            <div class="list-group list-group-flush">
                @forelse($popular as $article)
                    <div class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                        <div class="text-truncate pe-3" style="max-width:70%;">
                            <a href="{{ route('admin.articles.edit', $article) }}" class="text-dark text-decoration-none fw-semibold">{{ $article->title }}</a>
                            <div class="text-muted small">{{ $article->category }}</div>
                        </div>
                        <span class="badge-soft">{{ number_format($article->views) }} views</span>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted small">No data yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('vendor/chartjs/chart.umd.min.js') }}"></script>
<script>
    const ctx = document.getElementById('donationsChart');
    if (ctx) {
        const data = @json($monthlyDonations);
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(item => item.label),
                datasets: [{
                    label: 'Donations (RWF)',
                    data: data.map(item => item.total),
                    backgroundColor: 'rgba(15, 92, 67, 0.85)',
                    borderRadius: 8,
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#eef2ee' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }
</script>
@endpush
