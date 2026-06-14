@php $img = $m['image'] ?? ''; $img = $img ? (\Illuminate\Support\Str::startsWith($img,['http','/']) ? $img : asset($img)) : ''; @endphp
<div class="cmsb">
    <section class="cmsb-fwi {{ ($m['image_side'] ?? 'right') === 'left' ? 'left' : '' }}">
        <div class="cmsb-wrap">
            <div class="grid">
                <div>
                    @if(!empty($m['subtitle']))<div class="sub">{{ $m['subtitle'] }}</div>@endif
                    @if(!empty($m['title']))<h2>{{ $m['title'] }}</h2>@endif
                    @if(!empty($m['content']))<div class="prose">{!! $m['content'] !!}</div>@endif
                    @if(!empty($m['points']))
                        <ul class="points">
                            @foreach($m['points'] as $p)<li>{{ $p['text'] ?? '' }}</li>@endforeach
                        </ul>
                    @endif
                    @if(!empty($m['button_text']))<a href="{{ $m['button_url'] ?? '#' }}" class="b-btn">{{ $m['button_text'] }} <i class="fas fa-arrow-right"></i></a>@endif
                </div>
                <div class="media" @if($img) style="background-image:url('{{ $img }}')" @endif></div>
            </div>
        </div>
    </section>
</div>
