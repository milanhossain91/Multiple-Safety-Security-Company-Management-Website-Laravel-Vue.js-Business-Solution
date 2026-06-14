@extends('admin.layout')
@section('title', 'Pages')
@section('page_title', 'Dynamic Pages')
@section('page_subtitle', 'Create and manage website pages with the page builder')
@section('page_actions')
    <a href="{{ url('/admin/pages/create') }}" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i> New Page
    </a>
@endsection

@section('admin_content')
<div class="card">
    <div class="card-body">
        @if ($pages->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-file-circle-plus fa-3x text-gray-300 mb-3"></i>
                <p class="text-muted">No pages yet. Click <strong>New Page</strong> to build your first one.</p>
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Template</th>
                        <th>Blocks</th>
                        <th>In Menu</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pages as $page)
                    <tr>
                        <td class="font-weight-bold">{{ $page->title }}</td>
                        <td><code>/page/{{ $page->slug }}</code></td>
                        <td><span class="text-capitalize">{{ $page->template }}</span></td>
                        <td><span class="badge badge-info">{{ $page->blocks_count }}</span></td>
                        <td>
                            @if ($page->show_in_menu)
                                <span class="badge badge-success">Yes</span>
                            @else
                                <span class="badge badge-secondary">No</span>
                            @endif
                        </td>
                        <td>
                            @if ($page->status)
                                <span class="badge badge-success">Published</span>
                            @else
                                <span class="badge badge-warning">Draft</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ url('/page/' . $page->slug) }}" target="_blank" class="btn btn-sm btn-light" title="View"><i class="fas fa-eye"></i></a>
                            <a href="{{ url('/admin/pages/' . $page->id . '/builder') }}" class="btn btn-sm btn-success" title="Page Builder"><i class="fas fa-cubes"></i> Build</a>
                            <a href="{{ url('/admin/pages/' . $page->id . '/edit') }}" class="btn btn-sm btn-primary" title="Settings"><i class="fas fa-pen"></i></a>
                            <a href="{{ url('/admin/pages/' . $page->id . '/delete') }}" onclick="return confirm('Delete this page?')" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection
