{{-- Recursive Nestable tree node. Expects: $items (siblings), $grouped (all items keyed by parent_id) --}}
<ol class="dd-list">
    @foreach ($items as $item)
        @php $children = $grouped->get($item->id, collect()); @endphp
        <li class="dd-item" data-id="{{ $item->id }}">
            <div class="dd-handle">
                <i class="fas fa-grip-vertical text-muted mr-1"></i>
                @if ($item->icon)<i class="{{ $item->icon }} mr-1"></i>@endif
                {{ $item->title }}
            </div>
            <div class="dd-meta dd-nodrag">
                <span class="badge {{ $item->link_type === 'page' ? 'badge-info' : 'badge-light' }}">
                    {{ $item->link_type === 'page' ? ($item->page->title ?? 'page') : ($item->url ?: '#') }}
                </span>
                @unless ($item->status)<span class="badge badge-warning">hidden</span>@endunless
                <button type="button" class="btn btn-xs btn-link text-primary p-0 ml-2 edit-item"
                    data-id="{{ $item->id }}"
                    data-title="{{ $item->title }}"
                    data-link_type="{{ $item->link_type }}"
                    data-url="{{ $item->url }}"
                    data-page_id="{{ $item->page_id }}"
                    data-icon="{{ $item->icon }}"
                    data-target="{{ $item->target }}"
                    data-status="{{ $item->status }}"><i class="fas fa-pen"></i></button>
                <a href="{{ url('/admin/menu-items/' . $item->id . '/delete') }}" onclick="return confirm('Delete this item (and its sub-items)?')" class="text-danger ml-2"><i class="fas fa-trash"></i></a>
            </div>
            @if ($children->count())
                @include('admin.menus._items', ['items' => $children, 'grouped' => $grouped])
            @endif
        </li>
    @endforeach
</ol>
