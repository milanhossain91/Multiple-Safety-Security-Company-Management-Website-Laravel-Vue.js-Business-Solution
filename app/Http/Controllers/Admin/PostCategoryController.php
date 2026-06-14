<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    public function index()
    {
        $categories = PostCategory::withCount('posts')->orderBy('name')->get();

        return view('admin.post_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);

        PostCategory::create([
            'name'   => $request->name,
            'slug'   => $this->uniqueSlug($request->name),
            'status' => $request->boolean('status', true),
        ]);

        return back()->with('success', 'Category created.');
    }

    public function update(Request $request, $id)
    {
        $category = PostCategory::findOrFail($id);
        $request->validate(['name' => 'required|string|max:255']);

        $category->update([
            'name'   => $request->name,
            'slug'   => $this->uniqueSlug($request->name, $category->id),
            'status' => $request->boolean('status'),
        ]);

        return back()->with('success', 'Category updated.');
    }

    public function destroy($id)
    {
        PostCategory::findOrFail($id)->delete();

        return back()->with('success', 'Category deleted.');
    }

    private function uniqueSlug($value, $ignoreId = null)
    {
        $base = Str::slug($value) ?: 'category';
        $slug = $base;
        $i = 1;

        while (PostCategory::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
