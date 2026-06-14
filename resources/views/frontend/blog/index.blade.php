@extends('frontend.layout')
@section('meta_title', 'Blog | ' . ($cms['site_name'] ?? 'ATSL'))
@section('meta_description', 'Latest news, articles and insights from ' . ($cms['site_name'] ?? 'ATSL') . '.')

@section('styles')
<style>
    .blog-wrap { padding: 56px 0; }
    .blog-grid { display: grid; grid-template-columns: 2.4fr 1fr; gap: 40px; align-items: start; }
    .post-cards { display: grid; grid-template-columns: repeat(2, 1fr); gap: 26px; }
    .post-card { background: #fff; border: 1px solid var(--cms-border); border-radius: 16px; overflow: hidden; transition: .2s; display: flex; flex-direction: column; }
    .post-card:hover { transform: translateY(-4px); box-shadow: 0 18px 40px rgba(15,23,42,.10); }
    .post-card .thumb { height: 200px; background: #e2e8f0 center/cover no-repeat; display: block; }
    .post-card .body { padding: 20px; flex: 1; display: flex; flex-direction: column; }
    .post-meta { font-size: 13px; color: var(--cms-muted); margin-bottom: 8px; display: flex; gap: 14px; flex-wrap: wrap; }
    .post-meta .cat { color: var(--cms-primary); font-weight: 600; }
    .post-card h3 { font-size: 19px; margin-bottom: 8px; }
    .post-card h3 a { color: var(--cms-dark); }
    .post-card h3 a:hover { color: var(--cms-primary); }
    .post-card p { color: var(--cms-muted); font-size: 14.5px; margin: 0 0 16px; }
    .post-card .read { margin-top: auto; font-weight: 600; font-size: 14px; }

    .blog-sidebar .widget { background: #fff; border: 1px solid var(--cms-border); border-radius: 16px; padding: 22px; margin-bottom: 26px; }
    .blog-sidebar h4 { font-size: 17px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 2px solid var(--cms-bg); }
    .search-box { display: flex; }
    .search-box input { flex: 1; border: 1px solid var(--cms-border); border-radius: 10px 0 0 10px; padding: 10px 12px; outline: none; }
    .search-box button { background: var(--cms-primary); color: #fff; border: 0; border-radius: 0 10px 10px 0; padding: 0 16px; cursor: pointer; }
    .cat-list { list-style: none; padding: 0; margin: 0; }
    .cat-list li a { display: flex; justify-content: space-between; padding: 9px 0; color: var(--cms-dark); border-bottom: 1px solid var(--cms-bg); }
    .cat-list li a:hover, .cat-list li a.active { color: var(--cms-primary); }
    .cat-list .count { background: var(--cms-bg); border-radius: 20px; padding: 1px 10px; font-size: 12px; color: var(--cms-muted); }
    .recent-item { display: flex; gap: 12px; margin-bottom: 14px; }
    .recent-item img { width: 64px; height: 56px; object-fit: cover; border-radius: 8px; }
    .recent-item a { font-weight: 600; font-size: 14px; color: var(--cms-dark); line-height: 1.35; }
    .recent-item a:hover { color: var(--cms-primary); }
    .recent-item .d { font-size: 12px; color: var(--cms-muted); }

    .pagination { display: flex; gap: 6px; list-style: none; padding: 0; margin: 36px 0 0; flex-wrap: wrap; }
    .pagination .page-item .page-link { border: 1px solid var(--cms-border); border-radius: 10px; padding: 9px 15px; color: var(--cms-dark); }
    .pagination .page-item.active .page-link { background: var(--cms-primary); border-color: var(--cms-primary); color: #fff; }
    .pagination .page-item.disabled .page-link { color: #cbd5e1; }

    .empty-state { background: #fff; border: 1px dashed var(--cms-border); border-radius: 16px; padding: 60px 20px; text-align: center; color: var(--cms-muted); }

    @media (max-width: 900px) { .blog-grid { grid-template-columns: 1fr; } .post-cards { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<section class="cms-page-banner">
    <div class="cms-container">
        <h1>Our Blog</h1>
        <p>News, insights and updates</p>
        <div class="cms-breadcrumb"><a href="{{ url('/') }}">Home</a> &nbsp;/&nbsp; Blog</div>
    </div>
</section>

<div class="blog-wrap">
    <div class="cms-container">
        <div class="blog-grid">
            {{-- Posts --}}
            <div>
                @if ($posts->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-newspaper fa-2x mb-3"></i>
                        <p>No posts found{{ $search ? ' for “' . $search . '”' : '' }}.</p>
                    </div>
                @else
                    <div class="post-cards">
                        @foreach ($posts as $post)
                            <article class="post-card">
                                <a href="{{ url('/blog/' . $post->slug) }}" class="thumb"
                                   style="{{ $post->image_url ? 'background-image:url(\''.$post->image_url.'\')' : '' }}"></a>
                                <div class="body">
                                    <div class="post-meta">
                                        @if ($post->category)<span class="cat">{{ $post->category->name }}</span>@endif
                                        <span><i class="far fa-calendar"></i> {{ optional($post->published_at)->format('d M Y') }}</span>
                                    </div>
                                    <h3><a href="{{ url('/blog/' . $post->slug) }}">{{ $post->title }}</a></h3>
                                    <p>{{ $post->summary }}</p>
                                    <a href="{{ url('/blog/' . $post->slug) }}" class="read">Read More <i class="fas fa-arrow-right"></i></a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    {{ $posts->links('pagination::bootstrap-4') }}
                @endif
            </div>

            {{-- Sidebar --}}
            <aside class="blog-sidebar">
                <div class="widget">
                    <h4>Search</h4>
                    <form action="{{ url('/blog') }}" method="GET" class="search-box">
                        <input type="text" name="q" value="{{ $search }}" placeholder="Search posts...">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>

                @if ($categories->count())
                <div class="widget">
                    <h4>Categories</h4>
                    <ul class="cat-list">
                        <li><a href="{{ url('/blog') }}" class="{{ !$activeCat ? 'active' : '' }}">All</a></li>
                        @foreach ($categories as $cat)
                            <li><a href="{{ url('/blog?category=' . $cat->slug) }}" class="{{ $activeCat == $cat->slug ? 'active' : '' }}">
                                {{ $cat->name }} <span class="count">{{ $cat->published_posts_count }}</span>
                            </a></li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if ($recent->count())
                <div class="widget">
                    <h4>Recent Posts</h4>
                    @foreach ($recent as $r)
                        <div class="recent-item">
                            @if ($r->image_url)<img src="{{ $r->image_url }}" alt="">@endif
                            <div>
                                <a href="{{ url('/blog/' . $r->slug) }}">{{ \Illuminate\Support\Str::limit($r->title, 45) }}</a>
                                <div class="d">{{ optional($r->published_at)->format('d M Y') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
            </aside>
        </div>
    </div>
</div>
@endsection
