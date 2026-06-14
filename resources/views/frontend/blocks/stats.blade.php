<div class="cmsb">
    <section class="cmsb-stats b-alt">
        <div class="cmsb-wrap">
            @if(!empty($m['title']))<div class="b-head"><h2>{{ $m['title'] }}</h2></div>@endif
            <div class="grid">
                @foreach(($m['items'] ?? []) as $it)
                    <div class="stat">
                        <div class="num">{{ $it['value'] ?? '' }}{{ $it['suffix'] ?? '' }}</div>
                        <div class="lbl">{{ $it['label'] ?? '' }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
