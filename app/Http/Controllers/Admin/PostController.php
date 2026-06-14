<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->orderByDesc('id')->get();

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $post       = new Post();
        $categories = PostCategory::orderBy('name')->get();
        $action     = url('/admin/posts');

        return view('admin.posts.create', compact('post', 'categories', 'action'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['slug'] = $this->uniqueSlug($request->slug ?: $request->title);
        $data['image'] = $this->upload($request) ?? null;

        Post::create($data);

        return redirect('/admin/posts')->with('success', 'Post created.');
    }

    public function edit($id)
    {
        $post       = Post::findOrFail($id);
        $categories = PostCategory::orderBy('name')->get();
        $action     = url('/admin/posts/' . $post->id);

        return view('admin.posts.edit', compact('post', 'categories', 'action'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $data = $this->validateData($request, $post->id);
        $data['slug'] = $this->uniqueSlug($request->slug ?: $request->title, $post->id);

        if ($img = $this->upload($request)) {
            $data['image'] = $img;
        }

        $post->update($data);

        return redirect('/admin/posts')->with('success', 'Post updated.');
    }

    public function destroy($id)
    {
        Post::findOrFail($id)->delete();

        return redirect('/admin/posts')->with('success', 'Post deleted.');
    }

    /* ---------------- helpers ---------------- */

    private function validateData(Request $request, $ignoreId = null)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'category_id' => 'nullable|exists:tbl_post_category,id',
            'content'     => 'nullable|string',
        ]);

        return [
            'category_id'      => $request->category_id ?: null,
            'title'            => $request->title,
            'author'           => $request->author,
            'excerpt'          => $request->excerpt,
            'content'          => $request->content,
            'tags'             => $request->tags,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status'           => $request->boolean('status'),
            'published_at'     => $request->published_at ?: now(),
        ];
    }

    private function uniqueSlug($value, $ignoreId = null)
    {
        $base = Str::slug($value) ?: 'post';
        $slug = $base;
        $i = 1;

        while (Post::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    private function upload(Request $request)
    {
        if (!$request->hasFile('image')) {
            return null;
        }

        return \App\Support\ImageUploader::store($request->file('image'), 'image/posts');
    }
}
