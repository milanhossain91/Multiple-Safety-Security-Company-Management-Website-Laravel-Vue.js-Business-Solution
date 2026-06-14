@php $cols = (int)($m['columns'] ?? 3); $cols = in_array($cols,[2,3,4]) ? $cols : 3; @endphp
<div class="cmsb">
    <section class="cmsb-gallery">
        <div class="cmsb-wrap">
            @if(!empty($m['title']))<div class="b-head"><h2>{{ $m['title'] }}</h2></div>@endif
            <div class="cmsb-grid c{{ $cols }}">
                @foreach(($m['images'] ?? []) as $im)
                    @php $img = $im['image'] ?? ''; $img = $img ? (\Illuminate\Support\Str::startsWith($img,['http','/']) ? $img : asset($img)) : ''; @endphp
                    <figure>
                        <div class="ph" @if($img) style="background-image:url('{{ $img }}')" @endif></div>
                        @if(!empty($im['caption']))<figcaption>{{ $im['caption'] }}</figcaption>@endif
                    </figure>
                @endforeach
            </div>
        </div>
    </section>
</div>
