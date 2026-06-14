<div class="cmsb">
    <section class="cmsb-testi">
        <div class="cmsb-wrap">
            <div class="b-head">
                @if(!empty($m['title']))<h2>{{ $m['title'] }}</h2>@endif
                @if(!empty($m['subtitle']))<p>{{ $m['subtitle'] }}</p>@endif
            </div>
            <div class="cmsb-grid c2">
                @foreach(($m['items'] ?? []) as $it)
                    @php $img = $it['image'] ?? ''; $img = $img ? (\Illuminate\Support\Str::startsWith($img,['http','/']) ? $img : asset($img)) : ''; @endphp
                    <div class="cmsb-card">
                        <div class="quote"><i class="fas fa-quote-left" style="color:var(--b-primary); margin-right:6px;"></i>{{ $it['quote'] ?? '' }}</div>
                        <div class="who">
                            <div class="av" @if($img) style="background-image:url('{{ $img }}')" @endif></div>
                            <div>
                                <div class="nm">{{ $it['name'] ?? '' }}</div>
                                <div class="rl">{{ $it['role'] ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>
