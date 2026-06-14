@php $cols = (int)($m['columns'] ?? 3); $cols = in_array($cols,[2,3,4]) ? $cols : 3; @endphp
<div class="cmsb">
    <section class="cmsb-services b-alt">
        <div class="cmsb-wrap">
            <div class="b-head">
                @if(!empty($m['title']))<h2>{{ $m['title'] }}</h2>@endif
                @if(!empty($m['subtitle']))<p>{{ $m['subtitle'] }}</p>@endif
            </div>
            <div class="cmsb-grid c{{ $cols }}">
                @foreach(($m['items'] ?? []) as $it)
                    @php $img = $it['image'] ?? ''; $img = $img ? (\Illuminate\Support\Str::startsWith($img,['http','/']) ? $img : asset($img)) : ''; @endphp
                    <div class="cmsb-card">
                        @if($img)
                            <div class="img" style="background-image:url('{{ $img }}')"></div>
                        @else
                            <div class="ic"><i class="fas {{ $it['icon'] ?? 'fa-gear' }}"></i></div>
                        @endif
                        <h3>{{ $it['title'] ?? '' }}</h3>
                        <p>{{ $it['text'] ?? '' }}</p>
                        @if(!empty($it['url']))<a class="more" href="{{ $it['url'] }}">Read more <i class="fas fa-arrow-right"></i></a>@endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
