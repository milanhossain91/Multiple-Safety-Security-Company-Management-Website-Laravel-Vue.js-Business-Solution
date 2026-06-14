@php
    $slides = $m['slides'] ?? [];
    $sid = 'sld' . substr(md5(json_encode($slides) . uniqid('', true)), 0, 8);
@endphp
<div class="cmsb">
    <section class="cmsb-slider" id="{{ $sid }}">
        <div class="cmsb-slider-track">
            @foreach ($slides as $i => $s)
                @php $img = $s['image'] ?? ''; $img = $img ? (\Illuminate\Support\Str::startsWith($img,['http','/']) ? $img : asset($img)) : ''; @endphp
                <div class="cmsb-slide {{ $i === 0 ? 'is-active' : '' }}" @if($img) style="background-image:url('{{ $img }}')" @endif>
                    <div class="cmsb-slide-overlay"></div>
                    <div class="cmsb-wrap">
                        <div class="cmsb-slide-inner">
                            @if(!empty($s['title']))<h2>{{ $s['title'] }}</h2>@endif
                            @if(!empty($s['subtitle']))<p>{{ $s['subtitle'] }}</p>@endif
                            @if(!empty($s['button_text']))
                                <a href="{{ $s['button_url'] ?? '#' }}" class="b-btn">{{ $s['button_text'] }} <i class="fas fa-arrow-right"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if(count($slides) > 1)
            {{-- Vertical numbered pagination (01 / 02 / 03) --}}
            <div class="cmsb-slider-nums">
                @foreach ($slides as $i => $s)
                    <button class="{{ $i === 0 ? 'on' : '' }}" data-go="{{ $i }}" aria-label="Slide {{ $i + 1 }}">
                        <span class="n">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    </button>
                @endforeach
            </div>
            <div class="cmsb-slider-arrows">
                <button class="cmsb-slider-nav" data-dir="-1" aria-label="Previous"><i class="fas fa-arrow-up"></i></button>
                <button class="cmsb-slider-nav" data-dir="1" aria-label="Next"><i class="fas fa-arrow-down"></i></button>
            </div>
        @endif
    </section>
</div>

@if(count($slides) > 1)
<script>
(function () {
    var root = document.getElementById('{{ $sid }}');
    if (!root || root.dataset.init) return;
    root.dataset.init = '1';
    var slides = root.querySelectorAll('.cmsb-slide'),
        nums   = root.querySelectorAll('.cmsb-slider-nums button'),
        cur = 0, timer;
    function show(n) {
        cur = (n + slides.length) % slides.length;
        slides.forEach(function (s, i) { s.classList.toggle('is-active', i === cur); });
        nums.forEach(function (d, i) { d.classList.toggle('on', i === cur); });
    }
    function start() { timer = setInterval(function () { show(cur + 1); }, 6000); }
    function reset() { clearInterval(timer); start(); }
    nums.forEach(function (d) { d.addEventListener('click', function () { show(parseInt(d.dataset.go, 10)); reset(); }); });
    root.querySelectorAll('.cmsb-slider-nav').forEach(function (b) {
        b.addEventListener('click', function () { show(cur + parseInt(b.dataset.dir, 10)); reset(); });
    });
    root.addEventListener('mouseenter', function () { clearInterval(timer); });
    root.addEventListener('mouseleave', start);
    start();
})();
</script>
@endif
