<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        {{-- Main column --}}
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg" value="{{ old('title', $post->title) }}" placeholder="Post title" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Slug (URL)</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug', $post->slug) }}" placeholder="auto-generated if blank">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-bold">Author</label>
                            <input type="text" name="author" class="form-control" value="{{ old('author', $post->author) }}" placeholder="e.g. Admin">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Excerpt (short summary)</label>
                        <textarea name="excerpt" class="form-control" rows="2" placeholder="Short summary shown on the blog list">{{ old('excerpt', $post->excerpt) }}</textarea>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Content</label>
                        <textarea name="content" id="summernote" class="form-control" rows="10">{{ old('content', $post->content) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-sliders mr-1"></i> Publish</div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Status</label>
                        <select name="status" class="form-control">
                            <option value="1" {{ old('status', $post->status ?? 1) ? 'selected' : '' }}>Published</option>
                            <option value="0" {{ old('status', $post->status ?? 1) ? '' : 'selected' }}>Draft</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Category</label>
                        <select name="category_id" class="form-control">
                            <option value="">— none —</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @if ($categories->isEmpty())
                            <small class="text-muted">No categories yet — <a href="{{ url('/admin/post-categories') }}">create one</a>.</small>
                        @endif
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Publish Date</label>
                        <input type="datetime-local" name="published_at" class="form-control"
                               value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-image mr-1"></i> Featured Image</div>
                <div class="card-body">
                    @if (!empty($post->image_url))
                        <img src="{{ $post->image_url }}" class="img-fluid rounded mb-2" alt="featured">
                    @endif
                    <input type="file" name="image" class="form-control-file">
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-tags mr-1"></i> Tags &amp; SEO</div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="font-weight-bold">Tags (comma separated)</label>
                        <input type="text" name="tags" class="form-control" value="{{ old('tags', $post->tags) }}" placeholder="news, security, tips">
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Meta Title</label>
                        <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $post->meta_title) }}">
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Meta Description</label>
                        <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description', $post->meta_description) }}</textarea>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg"><i class="fas fa-floppy-disk mr-1"></i> Save Post</button>
            <a href="{{ url('/admin/posts') }}" class="btn btn-light btn-block">Cancel</a>
        </div>
    </div>
</form>
{{-- The root layout auto-initializes the #summernote editor on the content field. --}}
