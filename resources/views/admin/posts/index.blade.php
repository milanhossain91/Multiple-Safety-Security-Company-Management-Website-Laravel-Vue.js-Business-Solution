@extends('admin.layout')
@section('title', 'Blog Posts')
@section('page_title', 'Blog Posts')
@section('page_subtitle', 'Write and manage blog posts shown dynamically on the frontend')
@section('page_actions')
    <a href="{{ url('/admin/post-categories') }}" class="btn btn-light"><i class="fas fa-folder-tree mr-1"></i> Categories</a>
    <a href="{{ url('/admin/posts/create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> New Post</a>
@endsection

@section('admin_content')
<div class="card">
    <div class="card-body">
        @if ($posts->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-gray-300 mb-3"></i>
                <p class="text-muted">No posts yet. Click <strong>New Post</strong> to publish your first article.</p>
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:60px"></th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Published</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($posts as $post)
                    <tr>
                        <td>
                            @if ($post->image_url)
                                <img src="{{ $post->image_url }}" style="width:48px;height:40px;object-fit:cover" class="rounded" alt="">
                            @else
                                <span class="text-gray-300"><i class="fas fa-image"></i></span>
                            @endif
                        </td>
                        <td class="font-weight-bold">{{ $post->title }}<br><code class="small">/blog/{{ $post->slug }}</code></td>
                        <td>{{ $post->category->name ?? '—' }}</td>
                        <td>{{ optional($post->published_at)->format('d M Y') ?? '—' }}</td>
                        <td>
                            @if ($post->status)
                                <span class="badge badge-success">Published</span>
                            @else
                                <span class="badge badge-warning">Draft</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ url('/blog/' . $post->slug) }}" target="_blank" class="btn btn-sm btn-light" title="View"><i class="fas fa-eye"></i></a>
                            <a href="{{ url('/admin/posts/' . $post->id . '/edit') }}" class="btn btn-sm btn-primary" title="Edit"><i class="fas fa-pen"></i></a>
                            <a href="{{ url('/admin/posts/' . $post->id . '/delete') }}" onclick="return confirm('Delete this post?')" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></a>
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
