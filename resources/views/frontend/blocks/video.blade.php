<div class="cmsb">
    <section class="cmsb-video">
        <div class="cmsb-wrap">
            <div class="b-head">
                @if(!empty($m['title']))<h2>{{ $m['title'] }}</h2>@endif
                @if(!empty($m['subtitle']))<p>{{ $m['subtitle'] }}</p>@endif
            </div>
            @if(!empty($m['video_url']))
                <div class="frame"><iframe src="{{ $m['video_url'] }}" allowfullscreen loading="lazy"></iframe></div>
            @endif
        </div>
    </section>
</div>
