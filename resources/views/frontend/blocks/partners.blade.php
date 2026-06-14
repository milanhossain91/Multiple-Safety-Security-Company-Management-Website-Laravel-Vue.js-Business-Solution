<div class="cmsb">
    <section class="cmsb-partners b-alt">
        <div class="cmsb-wrap">
            @if(!empty($m['title']))<div class="b-head"><h2>{{ $m['title'] }}</h2></div>@endif
            <div class="logos">
                @foreach(($m['logos'] ?? []) as $lg)
                    @php $img = $lg['image'] ?? ''; $img = $img ? (\Illuminate\Support\Str::startsWith($img,['http','/']) ? $img : asset($img)) : ''; @endphp
                    <a href="{{ $lg['url'] ?? '#' }}">
                        @if($img)<img src="{{ $img }}" alt="{{ $lg['name'] ?? '' }}">@else{{ $lg['name'] ?? 'Logo' }}@endif
                    </a>
                @endforeach
            </div>
        </div>
    </section>
</div>
