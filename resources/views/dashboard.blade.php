@extends('admin.layout')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('page_subtitle', 'Overview of your website content')

@section('admin_content')
@php
    $cards = [
        ['label' => 'Pages', 'value' => $stats['pages'] ?? 0, 'icon' => 'fa-file-lines', 'color' => 'primary', 'url' => url('/admin/pages')],
        ['label' => 'Blog Posts', 'value' => $stats['posts'] ?? 0, 'icon' => 'fa-newspaper', 'color' => 'success', 'url' => url('/admin/posts')],
        ['label' => 'Menus', 'value' => $stats['menus'] ?? 0, 'icon' => 'fa-bars-staggered', 'color' => 'info', 'url' => url('/admin/menus')],
        ['label' => 'Users', 'value' => $stats['users'] ?? 0, 'icon' => 'fa-users', 'color' => 'warning', 'url' => url('/admin/users')],
    ];
@endphp

<div class="row">
    @foreach ($cards as $c)
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ $c['url'] }}" class="text-decoration-none">
                <div class="card border-left-{{ $c['color'] }} shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-{{ $c['color'] }} text-uppercase mb-1">{{ $c['label'] }}</div>
                                <div class="h4 mb-0 font-weight-bold text-gray-800">{{ $c['value'] }}</div>
                            </div>
                            <div class="col-auto"><i class="fas {{ $c['icon'] }} fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="font-weight-bold"><i class="fas fa-newspaper mr-1"></i> Recent Posts</span>
                <a href="{{ url('/admin/posts/create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i></a>
            </div>
            <div class="card-body p-0">
                @forelse ($recentPosts as $post)
                    <a href="{{ url('/admin/posts/' . $post->id . '/edit') }}" class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom text-decoration-none text-gray-800">
                        <span>{{ $post->title }}</span>
                        <span class="badge badge-{{ $post->status ? 'success' : 'warning' }}">{{ $post->status ? 'Published' : 'Draft' }}</span>
                    </a>
                @empty
                    <div class="p-4 text-center text-muted">No posts yet.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-4">
        <div class="card shadow h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="font-weight-bold"><i class="fas fa-file-lines mr-1"></i> Recent Pages</span>
                <a href="{{ url('/admin/pages/create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i></a>
            </div>
            <div class="card-body p-0">
                @forelse ($recentPages as $page)
                    <div class="d-flex justify-content-between align-items-center px-3 py-2 border-bottom">
                        <span>{{ $page->title }}</span>
                        <span>
                            <a href="{{ url('/admin/pages/' . $page->id . '/builder') }}" class="btn btn-sm btn-light" title="Builder"><i class="fas fa-cubes"></i></a>
                            <a href="{{ url('/admin/pages/' . $page->id . '/edit') }}" class="btn btn-sm btn-light" title="Settings"><i class="fas fa-pen"></i></a>
                        </span>
                    </div>
                @empty
                    <div class="p-4 text-center text-muted">No pages yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
