{{-- Recursive menu renderer: supports menu -> sub menu -> sub-sub menu (unlimited depth) --}}
@foreach ($items as $item)
    @php $children = $item->children; @endphp
    <li class="cms-nav-item {{ $children->count() ? 'has-children' : '' }}">
        <a href="{{ $item->link }}" target="{{ $item->target ?? '_self' }}">
            @if ($item->icon)<i class="{{ $item->icon }}"></i> @endif
            {{ $item->title }}
            @if ($children->count())<i class="fas fa-chevron-down cms-caret"></i>@endif
        </a>
        @if ($children->count())
            <ul class="cms-submenu">
                @include('frontend.partials.menu-items', ['items' => $children])
            </ul>
        @endif
    </li>
@endforeach
