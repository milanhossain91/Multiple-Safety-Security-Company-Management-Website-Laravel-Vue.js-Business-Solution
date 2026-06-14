@extends('frontend.layout')

@section('content')
<style>
    .cms-section { padding: 56px 0; }
    .cms-section.alt { background: var(--cms-bg); }
    .cms-section h2 { font-size: 32px; text-align: center; }
    .cms-section .cms-lead { text-align: center; color: var(--cms-muted); max-width: 680px; margin: 0 auto 36px; font-size: 17px; }
    .cms-prose { max-width: 820px; margin: 0 auto; font-size: 17px; color: #334155; }
    .cms-prose img { border-radius: 12px; margin: 16px 0; }

    /* Hero */
    .cms-hero { padding: 90px 0; text-align: center; background: linear-gradient(135deg,#eff6ff,#fff); }
    .cms-hero h2 { font-size: 44px; margin-bottom: 14px; }
    .cms-hero p { font-size: 19px; color: var(--cms-muted); max-width: 700px; margin: 0 auto 26px; }

    /* Cards */
    .cms-cards { display: grid; gap: 24px; }
    .cms-cards.cols-2 { grid-template-columns: repeat(2,1fr); }
    .cms-cards.cols-3 { grid-template-columns: repeat(3,1fr); }
    .cms-cards.cols-4 { grid-template-columns: repeat(4,1fr); }
    .cms-card { background: #fff; border: 1px solid var(--cms-border); border-radius: 16px; padding: 28px; transition: .2s; }
    .cms-card:hover { transform: translateY(-4px); box-shadow: 0 18px 40px rgba(15,23,42,.10); border-color: transparent; }
    .cms-card .cms-card-icon { width: 54px; height: 54px; border-radius: 12px; background: #eff6ff; color: var(--cms-primary);
        display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 16px; }
    .cms-card h3 { font-size: 19px; margin-bottom: 8px; }
    .cms-card p { color: var(--cms-muted); margin: 0; }

    /* Gallery */
    .cms-gallery { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; }
    .cms-gallery img { width: 100%; height: 240px; object-fit: cover; border-radius: 12px; }

    /* CTA */
    .cms-cta { background: linear-gradient(135deg,var(--cms-primary),var(--cms-primary-dark)); color: #fff;
        border-radius: 20px; padding: 48px; text-align: center; }
    .cms-cta h2 { color: #fff; }
    .cms-cta p { color: #dbeafe; max-width: 600px; margin: 0 auto 24px; font-size: 17px; }
    .cms-cta .cms-btn { background: #fff; color: var(--cms-primary) !important; }

    .cms-video iframe, .cms-video video { width: 100%; aspect-ratio: 16/9; border: 0; border-radius: 16px; }
    .cms-figure { text-align: center; }
    .cms-figure img { border-radius: 16px; }

    @media (max-width: 768px) {
        .cms-cards.cols-2, .cms-cards.cols-3, .cms-cards.cols-4 { grid-template-columns: 1fr; }
        .cms-gallery { grid-template-columns: repeat(2,1fr); }
        .cms-hero h2 { font-size: 32px; }
        .cms-section h2 { font-size: 26px; }
    }
</style>

@php $builderBlocks = $page->template_data ?? []; @endphp

{{-- NEW visual page builder: render the JSON template if the page has one --}}
@if (!empty($builderBlocks))
    @foreach ($builderBlocks as $blk)
        @includeIf('frontend.blocks.' . ($blk['type'] ?? ''), ['m' => $blk['model'] ?? []])
    @endforeach
@else

{{-- Legacy block-rows rendering (pages not yet migrated to the builder) --}}
{{-- Page banner (skipped for landing template) --}}
@if ($page->template !== 'landing')
    <section class="cms-page-banner {{ $page->banner_image ? 'has-img' : '' }}"
        @if ($page->banner_image) style="background-image:url('{{ asset('image/pages/'.$page->banner_image) }}')" @endif>
        <div class="cms-container">
            <h1>{{ $page->title }}</h1>
            @if ($page->subtitle)<p>{{ $page->subtitle }}</p>@endif
            <div class="cms-breadcrumb"><a href="{{ url('/') }}">Home</a> &nbsp;/&nbsp; {{ $page->title }}</div>
        </div>
    </section>
@endif

@php $i = 0; @endphp
@forelse ($page->blocks as $block)
    @php
        $s = $block->settings ?? [];
        $i++;
        $alt = $i % 2 === 0 ? 'alt' : '';
        $cols = (int) ($s['columns'] ?? 3);
        $cols = in_array($cols, [2,3,4]) ? $cols : 3;
    @endphp

    @switch($block->block_type)

        @case('hero')
            <section class="cms-hero">
                <div class="cms-container">
                    @if ($block->title)<h2>{{ $block->title }}</h2>@endif
                    @if ($block->subtitle)<p>{{ $block->subtitle }}</p>@endif
                    @if ($block->content)<div class="cms-prose">{!! $block->content !!}</div>@endif
                    @if (!empty($s['button_text']))
                        <p style="margin-top:24px"><a href="{{ $s['button_url'] ?? '#' }}" class="cms-btn">{{ $s['button_text'] }}</a></p>
                    @endif
                </div>
            </section>
            @break

        @case('text')
            <section class="cms-section {{ $alt }}">
                <div class="cms-container">
                    @if ($block->title)<h2>{{ $block->title }}</h2>@endif
                    @if ($block->subtitle)<p class="cms-lead">{{ $block->subtitle }}</p>@endif
                    <div class="cms-prose">{!! $block->content !!}</div>
                </div>
            </section>
            @break

        @case('image')
            <section class="cms-section {{ $alt }}">
                <div class="cms-container cms-figure">
                    @if ($block->title)<h2>{{ $block->title }}</h2>@endif
                    @if ($block->image)<img src="{{ \Illuminate\Support\Str::startsWith($block->image,['http','/']) ? $block->image : asset($block->image) }}" alt="{{ $block->title }}">@endif
                    @if ($block->content)<div class="cms-prose mt-3">{!! $block->content !!}</div>@endif
                </div>
            </section>
            @break

        @case('cards')
            <section class="cms-section {{ $alt }}">
                <div class="cms-container">
                    @if ($block->title)<h2>{{ $block->title }}</h2>@endif
                    @if ($block->subtitle)<p class="cms-lead">{{ $block->subtitle }}</p>@endif
                    <div class="cms-cards cols-{{ $cols }}">
                        @foreach (($s['cards'] ?? []) as $card)
                            <div class="cms-card">
                                @if (!empty($card['icon']))<div class="cms-card-icon"><i class="{{ $card['icon'] }}"></i></div>@endif
                                <h3>{{ $card['title'] ?? '' }}</h3>
                                <p>{{ $card['text'] ?? '' }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
            @break

        @case('gallery')
            <section class="cms-section {{ $alt }}">
                <div class="cms-container">
                    @if ($block->title)<h2>{{ $block->title }}</h2>@endif
                    <div class="cms-gallery">
                        @foreach (($s['images'] ?? []) as $img)
                            <a href="{{ asset($img) }}" target="_blank"><img src="{{ asset($img) }}" alt="gallery"></a>
                        @endforeach
                    </div>
                </div>
            </section>
            @break

        @case('video')
            <section class="cms-section {{ $alt }}">
                <div class="cms-container">
                    @if ($block->title)<h2>{{ $block->title }}</h2>@endif
                    <div class="cms-video" style="max-width:900px;margin:24px auto 0">{!! $block->content !!}</div>
                </div>
            </section>
            @break

        @case('cta')
            <section class="cms-section">
                <div class="cms-container">
                    <div class="cms-cta">
                        @if ($block->title)<h2>{{ $block->title }}</h2>@endif
                        @if ($block->content)<p>{{ strip_tags($block->content) }}</p>@endif
                        @if (!empty($s['button_text']))
                            <a href="{{ $s['button_url'] ?? '#' }}" class="cms-btn">{{ $s['button_text'] }}</a>
                        @endif
                    </div>
                </div>
            </section>
            @break

        @case('html')
            <section class="cms-section {{ $alt }}">
                <div class="cms-container">{!! $block->content !!}</div>
            </section>
            @break

        @default
            <section class="cms-section {{ $alt }}">
                <div class="cms-container cms-prose">
                    @if ($block->title)<h2>{{ $block->title }}</h2>@endif
                    {!! $block->content !!}
                </div>
            </section>
    @endswitch

@empty
    <section class="cms-section">
        <div class="cms-container cms-prose" style="text-align:center">
            <p>This page has no content blocks yet.</p>
        </div>
    </section>
@endforelse
@endif
@endsection
