@extends('admin.layout')
@section('title', 'Build Menu')
@section('page_title', 'Build: ' . $menu->name)
@section('page_subtitle', 'Drag items to reorder or nest them into sub-menus / sub-sub-menus')
@section('page_actions')
    <a href="{{ url('/admin/menus') }}" class="btn btn-light"><i class="fas fa-arrow-left mr-1"></i> All Menus</a>
@endsection

@php
    // Group every item by its parent_id so the tree can recurse (includes inactive items).
    $grouped = $allItems->groupBy(function ($i) { return $i->parent_id ?? 0; });
    $roots   = $grouped->get(0, collect());
@endphp

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css" rel="stylesheet">
<style>
    .dd { max-width: 100%; }
    .dd-item > .dd-handle {
        background: #fff; border: 1px solid #e3e6f0; border-radius: 8px; padding: 10px 14px;
        font-weight: 600; color: #3a3b45; cursor: move; box-shadow: 0 1px 2px rgba(0,0,0,.04);
    }
    .dd-handle:hover { color: #4e73df; border-color: #bac8f3; background: #f8f9ff; }
    .dd-item { margin: 6px 0; }
    .dd-meta { position: absolute; right: 12px; top: 9px; font-size: 12px; }
    .dd-item > button.dd-handle { width: auto; }
    .dd-empty, .dd-placeholder { border-color: #4e73df; background: #eef2ff; }
    .dd3-content { position: relative; }
    .btn-xs { font-size: 12px; }
    .dd-meta .badge { font-weight: 600; }
</style>
@endsection

@section('admin_content')
<div class="row">
    {{-- ============ Tree builder ============ --}}
    <div class="col-lg-7">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-sitemap mr-1"></i> Menu Structure</span>
                <button type="button" id="saveOrderBtn" class="btn btn-sm btn-success">
                    <i class="fas fa-floppy-disk mr-1"></i> Save Arrangement
                </button>
            </div>
            <div class="card-body">
                @if ($allItems->isEmpty())
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-arrow-right mr-1"></i> No items yet — add your first item using the form on the right.
                    </div>
                @else
                    <p class="text-muted small mb-3"><i class="fas fa-circle-info mr-1"></i> Drag the handle to reorder. Drag an item <strong>onto/under</strong> another to make it a sub-menu. Then click <strong>Save Arrangement</strong>.</p>
                    <div class="dd" id="menuBuilder">
                        @include('admin.menus._items', ['items' => $roots, 'grouped' => $grouped])
                    </div>
                @endif
                <span id="saveStatus" class="small text-success ml-2"></span>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-gear mr-1"></i> Menu Settings</div>
            <div class="card-body">
                <form action="{{ url('/admin/menus/' . $menu->id) }}" method="POST" class="form-row align-items-end">
                    @csrf
                    <div class="form-group col-md-5">
                        <label class="small font-weight-bold">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $menu->name }}">
                    </div>
                    <div class="form-group col-md-3">
                        <label class="small font-weight-bold">Location</label>
                        <select name="location" class="form-control">
                            @foreach (['header','footer','sidebar'] as $loc)
                                <option value="{{ $loc }}" {{ $menu->location == $loc ? 'selected' : '' }}>{{ ucfirst($loc) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <div class="custom-control custom-switch mt-2">
                            <input type="checkbox" class="custom-control-input" id="menuStatus" name="status" value="1" {{ $menu->status ? 'checked' : '' }}>
                            <label class="custom-control-label" for="menuStatus">Active</label>
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <button class="btn btn-primary btn-block">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- ============ Add item ============ --}}
    <div class="col-lg-5">
        <div class="card mb-4">
            <div class="card-header"><i class="fas fa-plus mr-1"></i> Add Menu Item</div>
            <div class="card-body">
                <form action="{{ url('/admin/menus/' . $menu->id . '/items') }}" method="POST">
                    @csrf
                    @include('admin.menus._itemfields', ['prefix' => 'add'])
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-plus mr-1"></i> Add Item</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- ============ Edit item modal ============ --}}
<div class="modal fade" id="editItemModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editItemForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-pen mr-1"></i> Edit Menu Item</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @include('admin.menus._itemfields', ['prefix' => 'edit'])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
<script>
$(function () {
    // ---- Link type toggle (shared by add form + edit modal) ----
    function bindLinkToggle(prefix) {
        var $type = $('#' + prefix + '_link_type');
        function toggle() {
            var isPage = $type.val() === 'page';
            $('#' + prefix + '_url_wrap').toggle(!isPage);
            $('#' + prefix + '_page_wrap').toggle(isPage);
        }
        $type.on('change', toggle);
        toggle();
    }
    bindLinkToggle('add');
    bindLinkToggle('edit');

    // ---- Nestable drag & drop ----
    @if (!$allItems->isEmpty())
    $('#menuBuilder').nestable({ maxDepth: 6 });

    $('#saveOrderBtn').on('click', function () {
        var tree = $('#menuBuilder').nestable('serialize');
        var $status = $('#saveStatus');
        $status.text('Saving...').removeClass('text-danger').addClass('text-success');
        $.ajax({
            url: '{{ url('/admin/menus/' . $menu->id . '/reorder') }}',
            method: 'POST',
            data: { _token: '{{ csrf_token() }}', tree: JSON.stringify(tree) },
            success: function () {
                $status.text('Saved ✓');
                setTimeout(function () { $status.text(''); }, 2500);
            },
            error: function () { $status.text('Error saving order').addClass('text-danger'); }
        });
    });
    @endif

    // ---- Edit modal population ----
    $(document).on('click', '.edit-item', function () {
        var d = $(this).data();
        var $f = $('#editItemForm');
        $f.attr('action', '{{ url('/admin/menu-items') }}/' + d.id);
        $('#edit_title').val(d.title);
        $('#edit_link_type').val(d.link_type).trigger('change');
        $('#edit_url').val(d.url);
        $('#edit_page_id').val(d.page_id);
        $('#edit_icon').val(d.icon);
        $('#edit_target').val(d.target || '_self');
        $('#edit_status').prop('checked', d.status == 1);
        $('#editItemModal').modal('show');
    });
});
</script>
@endsection
