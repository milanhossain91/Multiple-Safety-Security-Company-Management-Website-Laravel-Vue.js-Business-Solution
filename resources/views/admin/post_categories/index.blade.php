@extends('admin.layout')
@section('title', 'Blog Categories')
@section('page_title', 'Blog Categories')
@section('page_subtitle', 'Organize blog posts into categories')
@section('page_actions')
    <a href="{{ url('/admin/posts') }}" class="btn btn-light"><i class="fas fa-arrow-left mr-1"></i> Back to Posts</a>
@endsection

@section('admin_content')
<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-body">
                @if ($categories->isEmpty())
                    <div class="text-center py-4 text-muted">No categories yet — add one using the form.</div>
                @else
                <table class="table table-hover mb-0">
                    <thead><tr><th>Name</th><th>Slug</th><th>Posts</th><th>Status</th><th class="text-right">Actions</th></tr></thead>
                    <tbody>
                        @foreach ($categories as $cat)
                        <tr>
                            <td class="font-weight-bold">{{ $cat->name }}</td>
                            <td><code>{{ $cat->slug }}</code></td>
                            <td><span class="badge badge-info">{{ $cat->posts_count }}</span></td>
                            <td>
                                @if ($cat->status)<span class="badge badge-success">Active</span>
                                @else<span class="badge badge-warning">Hidden</span>@endif
                            </td>
                            <td class="text-right">
                                <button class="btn btn-sm btn-primary edit-cat"
                                    data-id="{{ $cat->id }}" data-name="{{ $cat->name }}" data-status="{{ $cat->status }}"><i class="fas fa-pen"></i></button>
                                <a href="{{ url('/admin/post-categories/' . $cat->id . '/delete') }}" onclick="return confirm('Delete this category?')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card">
            <div class="card-header"><i class="fas fa-plus mr-1"></i> <span id="catFormTitle">Add Category</span></div>
            <div class="card-body">
                <form id="catForm" action="{{ url('/admin/post-categories') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-bold">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="catName" class="form-control" required>
                    </div>
                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input" id="catStatus" name="status" value="1" checked>
                        <label class="custom-control-label" for="catStatus">Active</label>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-floppy-disk mr-1"></i> Save</button>
                    <button type="button" id="catReset" class="btn btn-light" style="display:none">Cancel edit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var form = document.getElementById('catForm'),
        name = document.getElementById('catName'),
        status = document.getElementById('catStatus'),
        title = document.getElementById('catFormTitle'),
        reset = document.getElementById('catReset'),
        addAction = '{{ url('/admin/post-categories') }}';

    document.querySelectorAll('.edit-cat').forEach(function (btn) {
        btn.addEventListener('click', function () {
            form.action = addAction + '/' + btn.dataset.id;
            name.value = btn.dataset.name;
            status.checked = btn.dataset.status == '1';
            title.textContent = 'Edit Category';
            reset.style.display = 'inline-block';
            name.focus();
        });
    });
    reset.addEventListener('click', function () {
        form.action = addAction; name.value = ''; status.checked = true;
        title.textContent = 'Add Category'; reset.style.display = 'none';
    });
})();
</script>
@endsection
