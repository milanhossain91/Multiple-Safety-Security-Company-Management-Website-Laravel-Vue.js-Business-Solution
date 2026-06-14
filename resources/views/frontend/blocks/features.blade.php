@php $cols = (int)($m['columns'] ?? 3); $cols = in_array($cols,[2,3,4]) ? $cols : 3; @endphp
<div class="cmsb">
    <section class="cmsb-features">
        <div class="cmsb-wrap">
            <div class="b-head">
                @if(!empty($m['title']))<h2>{{ $m['title'] }}</h2>@endif
                @if(!empty($m['subtitle']))<p>{{ $m['subtitle'] }}</p>@endif
            </div>
            <div class="cmsb-grid c{{ $cols }}">
                @foreach(($m['items'] ?? []) as $it)
                    <div class="cmsb-card">
                        <div class="ic"><i class="fas {{ $it['icon'] ?? 'fa-star' }}"></i></div>
                        <h3>{{ $it['title'] ?? '' }}</h3>
                        <p>{{ $it['text'] ?? '' }}</p>
                        @if(!empty($it['link']))<a class="more" href="{{ $it['link'] }}">Learn more <i class="fas fa-arrow-right"></i></a>@endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
