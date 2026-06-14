@php $img = $m['image'] ?? ''; $img = $img ? (\Illuminate\Support\Str::startsWith($img,['http','/']) ? $img : asset($img)) : ''; @endphp
<div class="cmsb">
    <section class="cmsb-pageheader {{ ($m['align'] ?? 'center') === 'left' ? 'left' : '' }} {{ $img ? 'has-img' : '' }}"
        @if($img) style="background-image:url('{{ $img }}')" @endif>
        <div class="cmsb-wrap">
            <h1>{{ $m['title'] ?? '' }}</h1>
            @if(!empty($m['subtitle']))<p>{{ $m['subtitle'] }}</p>@endif
        </div>
    </section>
</div>
