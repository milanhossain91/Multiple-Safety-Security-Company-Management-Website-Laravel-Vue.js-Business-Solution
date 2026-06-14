@php $img = $m['image'] ?? ''; $img = $img ? (\Illuminate\Support\Str::startsWith($img,['http','/']) ? $img : asset($img)) : ''; @endphp
<div class="cmsb">
    <section class="cmsb-fwi">
        <div class="cmsb-wrap">
            <div class="grid">
                <div>
                    @if(!empty($m['subtitle']))<div class="sub">{{ $m['subtitle'] }}</div>@endif
                    @if(!empty($m['title']))<h2>{{ $m['title'] }}</h2>@endif
                    <div style="margin-top:18px">
                        @foreach(($m['items'] ?? []) as $it)
                            <div style="display:flex; gap:14px; margin-bottom:18px;">
                                <div class="ic" style="flex:0 0 auto; width:46px; height:46px; border-radius:10px; background:#eff6ff; color:var(--b-primary); display:flex; align-items:center; justify-content:center;"><i class="fas {{ $it['icon'] ?? 'fa-check' }}"></i></div>
                                <div>
                                    <h3 style="font-size:17px; margin:0 0 4px;">{{ $it['title'] ?? '' }}</h3>
                                    <p style="margin:0; color:var(--b-muted);">{{ $it['text'] ?? '' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="media" @if($img) style="background-image:url('{{ $img }}')" @endif></div>
            </div>
        </div>
    </section>
</div>
