{{-- Shared menu-item fields. Expects: $prefix ('add'|'edit'), $pages --}}
<div class="form-group">
    <label class="small font-weight-bold">Title <span class="text-danger">*</span></label>
    <input type="text" name="title" id="{{ $prefix }}_title" class="form-control" required>
</div>

<div class="form-row">
    <div class="form-group col-6">
        <label class="small font-weight-bold">Link Type</label>
        <select name="link_type" id="{{ $prefix }}_link_type" class="form-control">
            <option value="custom">Custom URL</option>
            <option value="page">Dynamic Page</option>
        </select>
    </div>
    <div class="form-group col-6">
        <label class="small font-weight-bold">Open In</label>
        <select name="target" id="{{ $prefix }}_target" class="form-control">
            <option value="_self">Same tab</option>
            <option value="_blank">New tab</option>
        </select>
    </div>
</div>

<div class="form-group" id="{{ $prefix }}_url_wrap">
    <label class="small font-weight-bold">Custom URL</label>
    <input type="text" name="url" id="{{ $prefix }}_url" class="form-control" placeholder="/contact or https://...">
</div>

<div class="form-group" id="{{ $prefix }}_page_wrap" style="display:none">
    <label class="small font-weight-bold">Select Page</label>
    <select name="page_id" id="{{ $prefix }}_page_id" class="form-control">
        <option value="">— choose a page —</option>
        @foreach ($pages as $p)
            <option value="{{ $p->id }}">{{ $p->title }}</option>
        @endforeach
    </select>
</div>

<div class="form-row align-items-end">
    <div class="form-group col-7">
        <label class="small font-weight-bold">Icon class (optional)</label>
        <input type="text" name="icon" id="{{ $prefix }}_icon" class="form-control" placeholder="fas fa-house">
    </div>
    <div class="form-group col-5">
        <div class="custom-control custom-switch">
            <input type="checkbox" class="custom-control-input" id="{{ $prefix }}_status" name="status" value="1" checked>
            <label class="custom-control-label" for="{{ $prefix }}_status">Visible</label>
        </div>
    </div>
</div>
