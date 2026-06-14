@php
    $blockTypes = ['hero' => 'Hero / Banner', 'text' => 'Text', 'image' => 'Image', 'cards' => 'Cards', 'gallery' => 'Gallery', 'video' => 'Video', 'cta' => 'Call To Action', 'html' => 'Raw HTML'];
    $existingBlocks = old('blocks', isset($page) && $page->exists ? $page->blocks->map(function ($b) {
        return [
            'block_type' => $b->block_type, 'title' => $b->title, 'subtitle' => $b->subtitle,
            'content' => $b->content, 'image' => $b->image,
            'settings' => $b->settings ? json_encode($b->settings, JSON_PRETTY_PRINT) : '',
        ];
    })->toArray() : []);
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        {{-- ============ Main column: builder ============ --}}
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-pen-ruler mr-1"></i> Page Content</span>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Page Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $page->title) }}" placeholder="e.g. About Us" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Slug (URL)</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug', $page->slug) }}" placeholder="auto-generated if blank">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Subtitle</label>
                            <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $page->subtitle) }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ===== Page builder blocks ===== --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-cubes mr-1"></i> Page Builder Blocks</span>
                    <button type="button" class="btn btn-sm btn-primary" id="addBlockBtn"><i class="fas fa-plus mr-1"></i> Add Block</button>
                </div>
                <div class="card-body">
                    <div id="blocksWrapper"></div>
                    <p class="text-muted small mb-0" id="noBlocksMsg">No blocks yet — click <strong>Add Block</strong> to compose this page.</p>
                </div>
            </div>
        </div>

        {{-- ============ Sidebar: settings ============ --}}
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-sliders mr-1"></i> Publish</div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', $page->status) ? 'selected' : '' }}>Published</option>
                            <option value="0" {{ old('status', $page->status) ? '' : 'selected' }}>Draft</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Template</label>
                        <select name="template" class="form-control">
                            @foreach (['default' => 'Default', 'fullwidth' => 'Full Width', 'landing' => 'Landing'] as $k => $v)
                                <option value="{{ $k }}" {{ old('template', $page->template) == $k ? 'selected' : '' }}>{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Sort Order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $page->sort_order ?? 0) }}">
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="showInMenu" name="show_in_menu" value="1" {{ old('show_in_menu', $page->show_in_menu) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="showInMenu">Show in menu</label>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-image mr-1"></i> Banner Image</div>
                <div class="card-body">
                    @if (!empty($page->banner_image))
                        <img src="{{ asset('image/pages/' . $page->banner_image) }}" class="img-fluid rounded mb-2" alt="banner">
                    @endif
                    <input type="file" name="banner_image" class="form-control-file">
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-magnifying-glass mr-1"></i> SEO</div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $page->meta_title) }}">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $page->meta_description) }}</textarea>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Meta Keywords</label>
                        <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $page->meta_keywords) }}">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg">
                <i class="fas fa-floppy-disk mr-1"></i> Save Page
            </button>
            <a href="{{ url('/admin/pages') }}" class="btn btn-light btn-block">Cancel</a>
        </div>
    </div>
</form>

{{-- Block template (cloned by JS) --}}
<template id="blockTemplate">
    <div class="builder-block" data-block>
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="block-type-badge">Block</span>
            <div>
                <i class="fas fa-grip-vertical block-handle mr-2"></i>
                <button type="button" class="btn btn-sm btn-link text-danger p-0" data-remove><i class="fas fa-trash"></i></button>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-5">
                <label class="small font-weight-bold mb-1">Type</label>
                <select class="form-control form-control-sm" data-name="block_type">
                    @foreach ($blockTypes as $k => $v)<option value="{{ $k }}">{{ $v }}</option>@endforeach
                </select>
            </div>
            <div class="form-group col-md-7">
                <label class="small font-weight-bold mb-1">Title</label>
                <input type="text" class="form-control form-control-sm" data-name="title">
            </div>
        </div>
        <div class="form-group">
            <label class="small font-weight-bold mb-1">Subtitle</label>
            <input type="text" class="form-control form-control-sm" data-name="subtitle">
        </div>
        <div class="form-group">
            <label class="small font-weight-bold mb-1">Content (HTML allowed)</label>
            <textarea class="form-control form-control-sm" rows="3" data-name="content"></textarea>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="small font-weight-bold mb-1">Image path (optional)</label>
                <input type="text" class="form-control form-control-sm" data-name="image" placeholder="image/pages/photo.jpg">
            </div>
            <div class="form-group col-md-6">
                <label class="small font-weight-bold mb-1">Settings (JSON, optional)</label>
                <input type="text" class="form-control form-control-sm" data-name="settings" placeholder='{"columns":3}'>
            </div>
        </div>
    </div>
</template>

<script>
(function () {
    var wrapper  = document.getElementById('blocksWrapper');
    var tpl      = document.getElementById('blockTemplate');
    var noMsg    = document.getElementById('noBlocksMsg');
    var existing = @json($existingBlocks);
    var counter  = 0;

    function refreshMsg() { noMsg.style.display = wrapper.children.length ? 'none' : 'block'; }

    function addBlock(data) {
        data = data || {};
        var node = tpl.content.cloneNode(true);
        var i = counter++;
        node.querySelectorAll('[data-name]').forEach(function (el) {
            var key = el.getAttribute('data-name');
            el.name = 'blocks[' + i + '][' + key + ']';
            if (data[key] != null) el.value = data[key];
            if (key === 'block_type') {
                el.addEventListener('change', function () { updateBadge(el); });
            }
        });
        wrapper.appendChild(node);
        var block = wrapper.lastElementChild;
        block.querySelector('[data-remove]').addEventListener('click', function () {
            block.remove(); refreshMsg();
        });
        updateBadge(block.querySelector('[data-name="block_type"]'));
        refreshMsg();
    }

    function updateBadge(select) {
        var badge = select.closest('[data-block]').querySelector('.block-type-badge');
        badge.textContent = select.options[select.selectedIndex].text;
    }

    document.getElementById('addBlockBtn').addEventListener('click', function () { addBlock(); });

    if (existing.length) { existing.forEach(addBlock); } else { refreshMsg(); }
})();
</script>
