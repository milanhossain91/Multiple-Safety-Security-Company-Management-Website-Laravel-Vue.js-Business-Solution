<div class="cmsb">
    <section class="cmsb-cta {{ $m['style'] ?? 'gradient' }}">
        <div class="cmsb-wrap">
            <div class="box">
                @if(!empty($m['title']))<h2>{{ $m['title'] }}</h2>@endif
                @if(!empty($m['text']))<p>{{ $m['text'] }}</p>@endif
                @if(!empty($m['button_text']))<a href="{{ $m['button_url'] ?? '#' }}" class="b-btn">{{ $m['button_text'] }} <i class="fas fa-arrow-right"></i></a>@endif
            </div>
        </div>
    </section>
</div>
