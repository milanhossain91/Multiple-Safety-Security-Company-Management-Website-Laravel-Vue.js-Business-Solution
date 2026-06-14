@extends('frontend.layout')
@section('meta_title', ($post->meta_title ?: $post->title) . ' | ' . ($cms['site_name'] ?? 'ATSL'))
@section('meta_description', $post->meta_description ?: $post->summary)

@section('styles')
<style>
    .single-wrap { padding: 56px 0; }
    .single-grid { display: grid; grid-template-columns: 2.4fr 1fr; gap: 40px; align-items: start; }
    .single-featured { width: 100%; max-height: 440px; object-fit: cover; border-radius: 18px; margin-bottom: 26px; }
    .single-meta { display: flex; gap: 18px; flex-wrap: wrap; color: var(--cms-muted); font-size: 14px; margin-bottom: 18px; }
    .single-meta .cat { color: var(--cms-primary); font-weight: 600; }
    .single-body { font-size: 17px; color: #334155; line-height: 1.8; }
    .single-body h1,.single-body h2,.single-body h3 { margin-top: 1.4em; }
    .single-body img { border-radius: 12px; margin: 18px 0; max-width: 100%; }
    .single-body p { margin: 0 0 1.1em; }
    .single-tags { margin-top: 30px; display: flex; gap: 8px; flex-wrap: wrap; align-items: center; }
    .single-tags .tag { background: var(--cms-bg); border-radius: 20px; padding: 5px 14px; font-size: 13px; color: var(--cms-muted); }
    .single-tags .tag:hover { background: var(--cms-primary); color: #fff; }

    .blog-sidebar .widget { background: #fff; border: 1px solid var(--cms-border); border-radius: 16px; padding: 22px; margin-bottom: 26px; }
    .blog-sidebar h4 { font-size: 17px; margin-bottom: 16px; padding-bottom: 12px; border-bottom: 2px solid var(--cms-bg); }
    .cat-list { list-style: none; padding: 0; margin: 0; }
    .cat-list li a { display: flex; justify-content: space-between; padding: 9px 0; color: var(--cms-dark); border-bottom: 1px solid var(--cms-bg); }
    .cat-list li a:hover { color: var(--cms-primary); }
    .cat-list .count { background: var(--cms-bg); border-radius: 20px; padding: 1px 10px; font-size: 12px; color: var(--cms-muted); }
    .recent-item { display: flex; gap: 12px; margin-bottom: 14px; }
    .recent-item img { width: 64px; height: 56px; object-fit: cover; border-radius: 8px; }
    .recent-item a { font-weight: 600; font-size: 14px; color: var(--cms-dark); line-height: 1.35; }
    .recent-item a:hover { color: var(--cms-primary); }
    .recent-item .d { font-size: 12px; color: var(--cms-muted); }

    .related { margin-top: 56px; }
    .related h2 { font-size: 26px; margin-bottom: 24px; }
    .related-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 24px; }
    .related-card { background:#fff; border:1px solid var(--cms-border); border-radius:14px; overflow:hidden; }
    .related-card .thumb { height: 150px; background:#e2e8f0 center/cover no-repeat; display:block; }
    .related-card .b { padding: 16px; }
    .related-card h3 { font-size: 16px; margin: 0; }
    .related-card h3 a { color: var(--cms-dark); }
    .related-card h3 a:hover { color: var(--cms-primary); }

    @media (max-width: 900px) { .single-grid { grid-template-columns: 1fr; } .related-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<section class="cms-page-banner">
    <div class="cms-container">
        <h1>{{ $post->title }}</h1>
        <div class="cms-breadcrumb"><a href="{{ url('/') }}">Home</a> &nbsp;/&nbsp; <a href="{{ url('/blog') }}">Blog</a> &nbsp;/&nbsp; {{ \Illuminate\Support\Str::limit($post->title, 40) }}</div>
    </div>
</section>

<div class="single-wrap">
    <div class="cms-container">
        <div class="single-grid">
            {{-- Article --}}
            <article>
                @if ($post->image_url)
                    <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="single-featured">
                @endif
                <div class="single-meta">
                    @if ($post->category)<span class="cat"><i class="fas fa-folder"></i> {{ $post->category->name }}</span>@endif
                    <span><i class="far fa-calendar"></i> {{ optional($post->published_at)->format('d M Y') }}</span>
                    @if ($post->author)<span><i class="far fa-user"></i> {{ $post->author }}</span>@endif
                </div>

                <div class="single-body">
                    {!! $post->content !!}
                </div>

                @if ($post->tagList->count())
                    <div class="single-tags">
                        <i class="fas fa-tags"></i>
                        @foreach ($post->tagList as $tag)
                            <a href="{{ url('/blog?tag=' . urlencode($tag)) }}" class="tag">{{ $tag }}</a>
                        @endforeach
                    </div>
                @endif

                {{-- Related --}}
                @if ($related->count())
                <div class="related">
                    <h2>Related Posts</h2>
                    <div class="related-grid">
                        @foreach ($related as $r)
                            <div class="related-card">
                                <a href="{{ url('/blog/' . $r->slug) }}" class="thumb" style="{{ $r->image_url ? 'background-image:url(\''.$r->image_url.'\')' : '' }}"></a>
                                <div class="b"><h3><a href="{{ url('/blog/' . $r->slug) }}">{{ \Illuminate\Support\Str::limit($r->title, 50) }}</a></h3></div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </article>

            {{-- Sidebar --}}
            <aside class="blog-sidebar">
                @if ($categories->count())
                <div class="widget">
                    <h4>Categories</h4>
                    <ul class="cat-list">
                        @foreach ($categories as $cat)
                            <li><a href="{{ url('/blog?category=' . $cat->slug) }}">{{ $cat->name }} <span class="count">{{ $cat->published_posts_count }}</span></a></li>
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
