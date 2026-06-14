<div class="cmsb">
    <section class="cmsb-text">
        <div class="cmsb-wrap">
            @if(!empty($m['title']) || !empty($m['subtitle']))
                <div class="b-head">
                    @if(!empty($m['title']))<h2>{{ $m['title'] }}</h2>@endif
                    @if(!empty($m['subtitle']))<p>{{ $m['subtitle'] }}</p>@endif
                </div>
            @endif
            <div class="prose {{ ($m['align'] ?? 'left') === 'center' ? 'center' : '' }}">
                {!! $m['content'] ?? '' !!}
            </div>
        </div>
    </section>
</div>
