<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Blog list with optional category / tag filter + search.
     */
    public function index(Request $request)
    {
        $query = Post::published()->with('category')->latest('published_at');

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('tag')) {
            $query->where('tags', 'like', '%' . $request->tag . '%');
        }

        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->q . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->q . '%');
            });
        }

        $posts = $query->paginate(9)->withQueryString();

        return view('frontend.blog.index', [
            'posts'      => $posts,
            'categories' => $this->sidebarCategories(),
            'recent'     => Post::published()->latest('published_at')->limit(4)->get(),
            'activeCat'  => $request->category,
            'search'     => $request->q,
        ]);
    }

    /**
     * Single blog post + related posts from the same category.
     */
    public function show($slug)
    {
        $post = Post::published()->with('category')->where('slug', $slug)->firstOrFail();

        $related = Post::published()
            ->where('id', '!=', $post->id)
            ->when($post->category_id, fn ($q) => $q->where('category_id', $post->category_id))
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('frontend.blog.show', [
            'post'       => $post,
            'related'    => $related,
            'categories' => $this->sidebarCategories(),
            'recent'     => Post::published()->where('id', '!=', $post->id)->latest('published_at')->limit(4)->get(),
        ]);
    }

    private function sidebarCategories()
    {
        return PostCategory::where('status', 1)
            ->withCount('publishedPosts')
            ->orderBy('name')
            ->get();
    }
}
