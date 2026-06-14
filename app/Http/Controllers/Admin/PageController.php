<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * List all dynamic pages.
     */
    public function index()
    {
        $pages = Page::withCount('blocks')->orderBy('sort_order')->orderByDesc('id')->get();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the "create page" form (page builder).
     */
    public function create()
    {
        $page = new Page();
        $page->status = 1;

        return view('admin.pages.create', compact('page'));
    }

    /**
     * Store a new page and its builder blocks.
     */
    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $page = new Page();
        $this->fillPage($page, $request, $data);
        $page->save();

        $this->syncBlocks($page, $request);

        return redirect('/admin/pages')->with('success', 'Page created successfully.');
    }

    /**
     * Edit an existing page with its blocks.
     */
    public function edit($id)
    {
        $page = Page::with('blocks')->findOrFail($id);

        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the page and rebuild its blocks.
     */
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $data = $this->validateData($request, $page->id);

        $this->fillPage($page, $request, $data);
        $page->save();

        $this->syncBlocks($page, $request);

        return redirect('/admin/pages')->with('success', 'Page updated successfully.');
    }

    /**
     * Delete a page (blocks cascade via FK).
     */
    public function destroy($id)
    {
        Page::findOrFail($id)->delete();

        return redirect('/admin/pages')->with('success', 'Page deleted.');
    }

    /* ------------------------------------------------------------------ */

    private function validateData(Request $request, $ignoreId = null)
    {
        return $request->validate([
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255',
            'subtitle'         => 'nullable|string|max:255',
            'template'         => 'nullable|string|max:50',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string|max:255',
            'sort_order'       => 'nullable|integer',
        ]);
    }

    private function fillPage(Page $page, Request $request, array $data)
    {
        $slug = $data['slug'] ?? null;
        $slug = $slug ? Str::slug($slug) : Str::slug($data['title']);

        // guarantee a unique slug
        $base = $slug;
        $i = 1;
        while (Page::where('slug', $slug)->where('id', '!=', $page->id ?? 0)->exists()) {
            $slug = $base . '-' . $i++;
        }

        $page->title            = $data['title'];
        $page->slug             = $slug;
        $page->subtitle         = $data['subtitle'] ?? null;
        $page->template         = $data['template'] ?? 'default';
        $page->meta_title       = $data['meta_title'] ?? null;
        $page->meta_description = $data['meta_description'] ?? null;
        $page->meta_keywords    = $data['meta_keywords'] ?? null;
        $page->sort_order       = $data['sort_order'] ?? 0;
        $page->show_in_menu     = $request->boolean('show_in_menu');
        $page->status           = $request->boolean('status');

        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $name = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('image/pages'), $name);
            $page->banner_image = $name;
        }
    }

    /**
     * Rebuild the page-builder blocks from the submitted repeater.
     */
    private function syncBlocks(Page $page, Request $request)
    {
        $page->blocks()->delete();

        $blocks = $request->input('blocks', []);
        $order  = 0;

        foreach ($blocks as $index => $b) {
            if (empty($b['block_type']) && empty($b['title']) && empty($b['content'])) {
                continue; // skip empty rows
            }

            $settings = null;
            if (!empty($b['settings'])) {
                $decoded  = json_decode($b['settings'], true);
                $settings = json_last_error() === JSON_ERROR_NONE ? $decoded : null;
            }

            $block = new PageBlock([
                'block_type' => $b['block_type'] ?? 'text',
                'title'      => $b['title'] ?? null,
                'subtitle'   => $b['subtitle'] ?? null,
                'content'    => $b['content'] ?? null,
                'image'      => $b['image'] ?? null,
                'settings'   => $settings,
                'sort_order' => $order++,
                'status'     => 1,
            ]);
            $page->blocks()->save($block);
        }
    }
}
