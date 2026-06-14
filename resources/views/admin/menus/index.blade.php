@extends('admin.layout')
@section('title', 'Menus')
@section('page_title', 'Dynamic Menus')
@section('page_subtitle', 'Manage navigation menus with unlimited nested sub-menus')
@section('page_actions')
    <a href="{{ url('/admin/menus/create') }}" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i> New Menu
    </a>
@endsection

@section('admin_content')
<div class="card">
    <div class="card-body">
        @if ($menus->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-bars-staggered fa-3x text-gray-300 mb-3"></i>
                <p class="text-muted">No menus yet. Click <strong>New Menu</strong> to create one (e.g. Header, Footer).</p>
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Items</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menus as $menu)
                    <tr>
                        <td class="font-weight-bold">{{ $menu->name }}</td>
                        <td><span class="badge badge-info text-capitalize">{{ $menu->location }}</span></td>
                        <td><span class="badge badge-secondary">{{ $menu->items_count }}</span></td>
                        <td>
                            @if ($menu->status)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-warning">Inactive</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ url('/admin/menus/' . $menu->id . '/edit') }}" class="btn btn-sm btn-primary" title="Manage items"><i class="fas fa-pen mr-1"></i> Build</a>
                            <a href="{{ url('/admin/menus/' . $menu->id . '/delete') }}" onclick="return confirm('Delete this menu and all its items?')" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></a>
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
