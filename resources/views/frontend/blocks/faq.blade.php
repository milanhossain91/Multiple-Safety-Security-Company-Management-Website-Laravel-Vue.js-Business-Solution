<div class="cmsb">
    <section class="cmsb-faq b-alt">
        <div class="cmsb-wrap">
            <div class="b-head">
                @if(!empty($m['title']))<h2>{{ $m['title'] }}</h2>@endif
                @if(!empty($m['subtitle']))<p>{{ $m['subtitle'] }}</p>@endif
            </div>
            <div class="list">
                @foreach(($m['items'] ?? []) as $it)
                    <details @if($loop->first) open @endif>
                        <summary>{{ $it['question'] ?? '' }}</summary>
                        <div class="ans">{{ $it['answer'] ?? '' }}</div>
                    </details>
                @endforeach
            </div>
        </div>
    </section>
</div>
