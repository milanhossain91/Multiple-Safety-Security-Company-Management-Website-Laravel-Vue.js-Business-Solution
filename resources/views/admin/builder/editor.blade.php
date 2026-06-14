@extends('admin.layout')
@section('title', 'Page Builder')
@section('page_title', 'Page Builder — ' . $page->title)
@section('page_subtitle', 'Drag blocks onto the canvas, edit on the right, drag to reorder')
@section('page_actions')
    <a href="{{ url('/admin/pages') }}" class="btn btn-light btn-sm"><i class="fas fa-arrow-left mr-1"></i> Pages</a>
    <a href="{{ url('/page/' . $page->slug) }}" target="_blank" class="btn btn-light btn-sm"><i class="fas fa-eye mr-1"></i> View</a>
    <button id="pbSave" class="btn btn-success btn-sm"><i class="fas fa-floppy-disk mr-1"></i> Save</button>
@endsection

@section('admin_content')
<div class="pb-app">
    {{-- LEFT: catalog --}}
    <aside class="pb-panel pb-catalog">
        <div class="pb-panel-head"><i class="fas fa-cubes mr-1"></i> Blocks</div>
        <div class="pb-search"><input type="text" id="pbSearch" placeholder="Search blocks..."></div>
        <div class="pb-catalog-body" id="pbCatalog">
            @foreach ($catalog as $group)
                <div class="pb-cat-group" data-group>
                    <div class="pb-cat-title">{{ $group['name'] }}</div>
                    <div class="pb-cat-items">
                        @foreach ($group['items'] as $item)
                            <button type="button" class="pb-block-btn" data-add="{{ $item['id'] }}" title="{{ $item['name'] }}">
                                <i class="fas {{ $item['icon'] }}"></i>
                                <span>{{ $item['name'] }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </aside>

    {{-- CENTER: live canvas --}}
    <main class="pb-canvas-wrap">
        <div class="pb-canvas" id="pbCanvas">
            <div class="pb-empty" id="pbEmpty">
                <i class="fas fa-hand-pointer fa-2x mb-2"></i>
                <p>Click a block on the left to add it here.</p>
            </div>
        </div>
    </main>

    {{-- RIGHT: properties --}}
    <aside class="pb-panel pb-props">
        <div class="pb-panel-head"><i class="fas fa-sliders mr-1"></i> Properties <span id="pbPropName" class="text-muted small"></span></div>
        <div class="pb-props-body" id="pbProps">
            <div class="pb-noselect text-muted small p-3">Select a block on the canvas to edit its content.</div>
        </div>
    </aside>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/cms-blocks.css') }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
<style>
    /* hide admin scroll chrome conflicts */
    .pb-app { display: grid; grid-template-columns: 250px 1fr 340px; gap: 14px; height: calc(100vh - 190px); min-height: 540px; }
    .pb-panel { background: #fff; border: 1px solid #e3e6f0; border-radius: 12px; display: flex; flex-direction: column; overflow: hidden; }
    .pb-panel-head { padding: 12px 14px; font-weight: 700; border-bottom: 1px solid #eef0f5; font-size: 14px; }
    .pb-search { padding: 10px; border-bottom: 1px solid #eef0f5; }
    .pb-search input { width: 100%; border: 1px solid #e3e6f0; border-radius: 8px; padding: 8px 10px; font-size: 13px; outline: none; }
    .pb-catalog-body { overflow-y: auto; padding: 8px; }
    .pb-cat-title { font-size: 11px; text-transform: uppercase; letter-spacing: .5px; color: #98a2b3; margin: 10px 6px 6px; font-weight: 700; }
    .pb-block-btn { width: 100%; display: flex; align-items: center; gap: 10px; background: #f8f9fc; border: 1px solid #eef0f5; border-radius: 8px;
        padding: 9px 11px; margin-bottom: 6px; cursor: pointer; font-size: 13px; font-weight: 600; color: #3a3b45; text-align: left; transition: .15s; }
    .pb-block-btn:hover { background: #eef2ff; border-color: #c7d2fe; color: #4e73df; }
    .pb-block-btn i { width: 18px; color: #4e73df; }

    .pb-canvas-wrap { overflow-y: auto; background: #f1f3f9; border-radius: 12px; padding: 14px; }
    .pb-canvas { min-height: 100%; }
    .pb-empty { text-align: center; color: #98a2b3; padding: 80px 20px; border: 2px dashed #d6dbe7; border-radius: 12px; background: #fff; }

    .pb-item { position: relative; background: #fff; border: 2px solid transparent; border-radius: 10px; margin-bottom: 14px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.06); }
    .pb-item.selected { border-color: #4e73df; box-shadow: 0 6px 20px rgba(78,115,223,.18); }
    .pb-item-bar { display: flex; align-items: center; justify-content: space-between; background: #2e3650; color: #fff; padding: 6px 10px; font-size: 12px; font-weight: 600; }
    .pb-item-bar .l { display: flex; align-items: center; gap: 8px; }
    .pb-item-bar .pb-handle { cursor: move; opacity: .8; }
    .pb-item-bar .pb-actions i { cursor: pointer; margin-left: 12px; opacity: .85; }
    .pb-item-bar .pb-actions i:hover { opacity: 1; }
    .pb-item-render { pointer-events: none; max-height: 460px; overflow: hidden; position: relative; }
    .pb-item-render::after { content: ''; position: absolute; inset: 0; }
    .pb-render-loading { padding: 30px; text-align: center; color: #98a2b3; }

    .pb-props-body { overflow-y: auto; padding: 12px; }
    .pb-field { margin-bottom: 14px; }
    .pb-field > label { display: block; font-size: 12px; font-weight: 700; color: #5a5c69; margin-bottom: 5px; }
    .pb-field input[type=text], .pb-field input[type=url], .pb-field input[type=number], .pb-field textarea, .pb-field select {
        width: 100%; border: 1px solid #d8dbe6; border-radius: 8px; padding: 8px 10px; font-size: 13px; outline: none; }
    .pb-field textarea { resize: vertical; min-height: 70px; }
    .pb-field input:focus, .pb-field textarea:focus, .pb-field select:focus { border-color: #4e73df; }
    .pb-img-row { display: flex; gap: 6px; }
    .pb-img-row input { flex: 1; }
    .pb-img-row .pb-upload { background: #4e73df; color: #fff; border: 0; border-radius: 8px; padding: 0 12px; cursor: pointer; font-size: 12px; }
    .pb-img-prev { margin-top: 6px; }
    .pb-img-prev img { max-height: 60px; border-radius: 6px; border: 1px solid #eee; }

    .pb-list { border: 1px dashed #d8dbe6; border-radius: 10px; padding: 8px; }
    .pb-list-item { background: #f8f9fc; border: 1px solid #eef0f5; border-radius: 8px; padding: 10px; margin-bottom: 8px; position: relative; }
    .pb-list-item .pb-li-del { position: absolute; top: 6px; right: 8px; color: #e74a3b; cursor: pointer; font-size: 12px; }
    .pb-li-handle { cursor: move; color: #b0b6c3; font-size: 12px; margin-bottom: 4px; }
    .pb-add-item { width: 100%; background: #eef2ff; color: #4e73df; border: 1px dashed #c7d2fe; border-radius: 8px; padding: 7px; cursor: pointer; font-size: 12px; font-weight: 600; }
    .pb-unknown, .pb-render-loading { font-size: 13px; }

    @media (max-width: 1100px) { .pb-app { grid-template-columns: 200px 1fr 300px; } }
</style>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>
<script>
(function () {
    var CATALOG = @json($catalog);
    var SAVED   = @json($blocks);
    var PREVIEW_URL = '{{ route('admin.builder.preview') }}';
    var UPLOAD_URL  = '{{ route('admin.builder.upload') }}';
    var SAVE_URL    = '{{ route('admin.pages.builder.save', $page->id) }}';
    var CSRF = '{{ csrf_token() }}';

    // index block schemas by id
    var SCHEMA = {};
    CATALOG.forEach(function (g) { g.items.forEach(function (it) { SCHEMA[it.id] = it; }); });

    var canvas = document.getElementById('pbCanvas');
    var empty  = document.getElementById('pbEmpty');
    var props  = document.getElementById('pbProps');
    var propName = document.getElementById('pbPropName');

    var state = [];          // [{id,type,model}]
    var selectedId = null;
    var uid = 0;
    function nextId() { return 'b' + (Date.now().toString(36)) + (uid++); }
    function clone(o) { return JSON.parse(JSON.stringify(o)); }

    /* ---------- rendering canvas ---------- */
    function refreshEmpty() { empty.style.display = state.length ? 'none' : 'block'; }

    function renderItemShell(block) {
        var schema = SCHEMA[block.type] || {name: block.type, icon: 'fa-cube'};
        var el = document.createElement('div');
        el.className = 'pb-item' + (block.id === selectedId ? ' selected' : '');
        el.dataset.id = block.id;
        el.innerHTML =
            '<div class="pb-item-bar">' +
                '<span class="l"><i class="fas fa-grip-vertical pb-handle"></i> <i class="fas ' + schema.icon + '"></i> ' + escapeHtml(schema.name) + '</span>' +
                '<span class="pb-actions"><i class="fas fa-pen" data-edit title="Edit"></i><i class="fas fa-copy" data-dup title="Duplicate"></i><i class="fas fa-trash" data-del title="Delete"></i></span>' +
            '</div>' +
            '<div class="pb-item-render"><div class="pb-render-loading">Loading preview…</div></div>';
        return el;
    }

    function renderCanvas() {
        canvas.querySelectorAll('.pb-item').forEach(function (n) { n.remove(); });
        state.forEach(function (block) {
            var el = renderItemShell(block);
            canvas.appendChild(el);
            loadPreview(block, el.querySelector('.pb-item-render'));
        });
        refreshEmpty();
    }

    function loadPreview(block, target) {
        var fd = new FormData();
        fd.append('_token', CSRF);
        fd.append('type', block.type);
        fd.append('model', JSON.stringify(block.model));
        fetch(PREVIEW_URL, {method: 'POST', body: fd})
            .then(function (r) { return r.text(); })
            .then(function (html) { target.innerHTML = html; })
            .catch(function () { target.innerHTML = '<div class="pb-render-loading">Preview failed</div>'; });
    }

    function updateOnePreview(id) {
        var el = canvas.querySelector('.pb-item[data-id="' + id + '"] .pb-item-render');
        var block = state.find(function (b) { return b.id === id; });
        if (el && block) loadPreview(block, el);
    }

    /* ---------- selection + props form ---------- */
    function select(id) {
        selectedId = id;
        canvas.querySelectorAll('.pb-item').forEach(function (n) { n.classList.toggle('selected', n.dataset.id === id); });
        buildProps();
    }

    function buildProps() {
        var block = state.find(function (b) { return b.id === selectedId; });
        if (!block) { props.innerHTML = '<div class="pb-noselect text-muted small p-3">Select a block to edit.</div>'; propName.textContent = ''; return; }
        var schema = SCHEMA[block.type];
        propName.textContent = '· ' + schema.name;
        props.innerHTML = '';
        schema.settings.forEach(function (field) {
            props.appendChild(buildField(field, block.model, function () { updateOnePreview(block.id); }));
        });
    }

    function buildField(field, model, onChange) {
        var wrap = document.createElement('div');
        wrap.className = 'pb-field';
        if (field.type === 'listItem') {
            wrap.appendChild(labelEl(field.label));
            wrap.appendChild(buildList(field, model, onChange));
            return wrap;
        }
        wrap.appendChild(labelEl(field.label));
        wrap.appendChild(buildInput(field, model, field.id, onChange));
        return wrap;
    }

    function labelEl(t) { var l = document.createElement('label'); l.textContent = t || ''; return l; }

    function buildInput(field, obj, key, onChange) {
        var val = (obj[key] !== undefined && obj[key] !== null) ? obj[key] : (field.std || '');
        var input;
        if (field.type === 'textarea' || field.type === 'richtext') {
            input = document.createElement('textarea');
            input.value = val;
        } else if (field.type === 'select') {
            input = document.createElement('select');
            Object.keys(field.options || {}).forEach(function (k) {
                var o = document.createElement('option'); o.value = k; o.textContent = field.options[k];
                if (String(val) === String(k)) o.selected = true; input.appendChild(o);
            });
        } else if (field.type === 'image') {
            return buildImage(obj, key, val, onChange);
        } else {
            input = document.createElement('input');
            input.type = (field.type === 'number') ? 'number' : (field.type === 'url' ? 'url' : 'text');
            input.value = val;
            if (field.type === 'icon') input.placeholder = 'e.g. fa-star (Font Awesome)';
        }
        obj[key] = val;
        input.addEventListener('input', function () { obj[key] = input.value; debounce(onChange); });
        input.addEventListener('change', function () { obj[key] = input.value; onChange(); });
        return input;
    }

    function buildImage(obj, key, val, onChange) {
        obj[key] = val;
        var box = document.createElement('div');
        var row = document.createElement('div'); row.className = 'pb-img-row';
        var input = document.createElement('input'); input.type = 'text'; input.value = val; input.placeholder = 'image path or URL';
        var btn = document.createElement('button'); btn.type = 'button'; btn.className = 'pb-upload'; btn.innerHTML = '<i class="fas fa-upload"></i>';
        var file = document.createElement('input'); file.type = 'file'; file.accept = 'image/*'; file.style.display = 'none';
        var prev = document.createElement('div'); prev.className = 'pb-img-prev';
        function showPrev(v) { prev.innerHTML = v ? '<img src="' + (v.match(/^https?:|^\//) ? v : '/' + v) + '">' : ''; }
        showPrev(val);
        input.addEventListener('input', function () { obj[key] = input.value; showPrev(input.value); debounce(onChange); });
        btn.addEventListener('click', function () { file.click(); });
        file.addEventListener('change', function () {
            if (!file.files[0]) return;
            var fd = new FormData(); fd.append('_token', CSRF); fd.append('file', file.files[0]);
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            fetch(UPLOAD_URL, {method: 'POST', body: fd}).then(function (r) { return r.json(); }).then(function (d) {
                input.value = d.path; obj[key] = d.path; showPrev(d.path); onChange();
                btn.innerHTML = '<i class="fas fa-upload"></i>';
            }).catch(function () { btn.innerHTML = '<i class="fas fa-upload"></i>'; });
        });
        row.appendChild(input); row.appendChild(btn);
        box.appendChild(row); box.appendChild(file); box.appendChild(prev);
        return box;
    }

    function buildList(field, model, onChange) {
        if (!Array.isArray(model[field.id])) model[field.id] = [];
        var list = model[field.id];
        var holder = document.createElement('div'); holder.className = 'pb-list';
        var itemsWrap = document.createElement('div');

        function renderRow(row, idx) {
            var box = document.createElement('div'); box.className = 'pb-list-item';
            box.innerHTML = '<div class="pb-li-handle"><i class="fas fa-grip-lines"></i> Item ' + (idx + 1) + '</div><i class="fas fa-times pb-li-del"></i>';
            field.settings.forEach(function (sub) {
                var f = document.createElement('div'); f.className = 'pb-field';
                f.appendChild(labelEl(sub.label));
                f.appendChild(buildInput(sub, row, sub.id, onChange));
                box.appendChild(f);
            });
            box.querySelector('.pb-li-del').addEventListener('click', function () {
                var i = list.indexOf(row); if (i > -1) list.splice(i, 1); rebuild(); onChange();
            });
            return box;
        }
        function rebuild() {
            itemsWrap.innerHTML = '';
            list.forEach(function (row, i) { itemsWrap.appendChild(renderRow(row, i)); });
        }
        rebuild();
        var add = document.createElement('button'); add.type = 'button'; add.className = 'pb-add-item'; add.innerHTML = '<i class="fas fa-plus mr-1"></i> Add Item';
        add.addEventListener('click', function () {
            var blank = {}; field.settings.forEach(function (sub) { blank[sub.id] = sub.std || ''; });
            list.push(blank); rebuild(); onChange();
        });
        holder.appendChild(itemsWrap); holder.appendChild(add);

        // sortable rows
        new Sortable(itemsWrap, { handle: '.pb-li-handle', animation: 150, onEnd: function (e) {
            var moved = list.splice(e.oldIndex, 1)[0]; list.splice(e.newIndex, 0, moved); onChange();
        }});
        return holder;
    }

    /* ---------- actions ---------- */
    function addBlock(type) {
        var schema = SCHEMA[type]; if (!schema) return;
        var block = { id: nextId(), type: type, model: clone(schema.model || {}) };
        state.push(block);
        renderCanvas(); select(block.id);
        canvas.querySelector('.pb-item[data-id="' + block.id + '"]').scrollIntoView({behavior: 'smooth', block: 'center'});
    }

    canvas.addEventListener('click', function (e) {
        var item = e.target.closest('.pb-item'); if (!item) return;
        var id = item.dataset.id;
        if (e.target.closest('[data-del]')) {
            state = state.filter(function (b) { return b.id !== id; });
            if (selectedId === id) selectedId = null;
            renderCanvas(); buildProps(); return;
        }
        if (e.target.closest('[data-dup]')) {
            var src = state.find(function (b) { return b.id === id; });
            var copy = { id: nextId(), type: src.type, model: clone(src.model) };
            var i = state.indexOf(src); state.splice(i + 1, 0, copy); renderCanvas(); select(copy.id); return;
        }
        select(id);
    });

    document.querySelectorAll('[data-add]').forEach(function (btn) {
        btn.addEventListener('click', function () { addBlock(btn.dataset.add); });
    });

    // catalog search
    document.getElementById('pbSearch').addEventListener('input', function () {
        var q = this.value.toLowerCase();
        document.querySelectorAll('#pbCatalog .pb-block-btn').forEach(function (b) {
            b.style.display = b.textContent.toLowerCase().indexOf(q) > -1 ? '' : 'none';
        });
    });

    // canvas sortable (reorder blocks)
    new Sortable(canvas, { handle: '.pb-handle', animation: 150, draggable: '.pb-item', onEnd: function (e) {
        var moved = state.splice(e.oldIndex, 1)[0]; state.splice(e.newIndex, 0, moved);
    }});

    // save
    document.getElementById('pbSave').addEventListener('click', function () {
        var btn = this; btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Saving...';
        var fd = new FormData(); fd.append('_token', CSRF); fd.append('template', JSON.stringify(state));
        fetch(SAVE_URL, {method: 'POST', headers: {'X-Requested-With': 'XMLHttpRequest'}, body: fd})
            .then(function (r) { return r.json(); })
            .then(function () { btn.innerHTML = '<i class="fas fa-check mr-1"></i> Saved'; setTimeout(function () { btn.innerHTML = '<i class="fas fa-floppy-disk mr-1"></i> Save'; }, 1800); })
            .catch(function () { btn.innerHTML = '<i class="fas fa-triangle-exclamation mr-1"></i> Error'; });
    });

    // debounce helper for live preview
    var dbT; function debounce(fn) { clearTimeout(dbT); dbT = setTimeout(fn, 450); }
    function escapeHtml(s) { return String(s).replace(/[&<>"]/g, function (c) { return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]; }); }

    /* ---------- init ---------- */
    state = (SAVED || []).map(function (b) { return { id: b.id || nextId(), type: b.type, model: b.model || {} }; });
    renderCanvas();
})();
</script>
@endsection
