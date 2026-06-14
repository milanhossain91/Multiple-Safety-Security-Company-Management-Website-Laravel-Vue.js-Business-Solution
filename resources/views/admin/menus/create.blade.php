@extends('admin.layout')
@section('title', 'New Menu')
@section('page_title', 'Create Menu')
@section('page_subtitle', 'Define a navigation menu, then add and arrange its items')

@section('admin_content')
<div class="row">
    <div class="col-lg-6">
        <form action="{{ url('/admin/menus') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Menu Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Main Header Menu" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Location <span class="text-danger">*</span></label>
                        <select name="location" class="form-control" required>
                            <option value="header" {{ old('location') == 'header' ? 'selected' : '' }}>Header</option>
                            <option value="footer" {{ old('location') == 'footer' ? 'selected' : '' }}>Footer</option>
                            <option value="sidebar" {{ old('location') == 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                        </select>
                        <small class="text-muted">Each location can only have one menu.</small>
                    </div>
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" checked>
                        <label class="custom-control-label" for="status">Active</label>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-floppy-disk mr-1"></i> Create &amp; Build Menu</button>
                    <a href="{{ url('/admin/menus') }}" class="btn btn-light">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
