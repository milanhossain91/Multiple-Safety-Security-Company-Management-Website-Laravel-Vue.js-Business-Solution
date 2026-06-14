<?php

namespace App\Http\Controllers;

use App\Models\Page;

class FrontPageController extends Controller
{
    /**
     * Homepage — renders the page with slug "home".
     * Falls back to a simple message if no home page exists yet.
     */
    public function home()
    {
        $page = Page::with(['blocks' => function ($q) {
            $q->where('status', 1)->orderBy('sort_order');
        }])->where('slug', 'home')->where('status', 1)->first();

        if (!$page) {
            // graceful fallback so the site never 500s before a home page is built
            $page = new Page(['title' => config('app.name', 'Welcome'), 'template' => 'fullwidth', 'template_data' => []]);
        }

        return view('frontend.page', compact('page'));
    }

    /**
     * Render any dynamic page by slug (page builder template or legacy blocks).
     * Used by both /page/{slug} and the catch-all /{slug}.
     */
    public function show($slug)
    {
        $page = Page::with(['blocks' => function ($q) {
            $q->where('status', 1)->orderBy('sort_order');
        }])->where('slug', $slug)->where('status', 1)->firstOrFail();

        return view('frontend.page', compact('page'));
    }
}
