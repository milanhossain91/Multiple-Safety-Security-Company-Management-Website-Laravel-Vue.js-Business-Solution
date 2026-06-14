@php $img = $m['image'] ?? ''; $img = $img ? (\Illuminate\Support\Str::startsWith($img,['http','/']) ? $img : asset($img)) : ''; @endphp
<div class="cmsb">
    <section class="cmsb-hero">
        <div class="cmsb-wrap">
            <div class="grid">
                <div>
                    @if(!empty($m['badge']))<span class="badge">{{ $m['badge'] }}</span>@endif
                    <h1>{{ $m['title'] ?? '' }} @if(!empty($m['highlight']))<span class="hl">{{ $m['highlight'] }}</span>@endif</h1>
                    @if(!empty($m['subtitle']))<p class="sub">{{ $m['subtitle'] }}</p>@endif
                    <div class="btns">
                        @if(!empty($m['primary_text']))<a href="{{ $m['primary_url'] ?? '#' }}" class="b-btn">{{ $m['primary_text'] }} <i class="fas fa-arrow-right"></i></a>@endif
                        @if(!empty($m['secondary_text']))<a href="{{ $m['secondary_url'] ?? '#' }}" class="b-btn ghost">{{ $m['secondary_text'] }}</a>@endif
                    </div>
                    @if(!empty($m['trust_items']))
                        <div class="trust">
                            @foreach($m['trust_items'] as $t)
                                <span><i class="fas {{ $t['icon'] ?? 'fa-check' }}"></i> {{ $t['text'] ?? '' }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="media">
                    @if($img)<img src="{{ $img }}" alt="{{ $m['title'] ?? '' }}">@else<span class="ph"><i class="fas fa-image"></i></span>@endif
                </div>
            </div>
        </div>
    </section>
</div>
