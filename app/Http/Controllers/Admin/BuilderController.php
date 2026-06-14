<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\PageBuilder\Registry;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Visual page builder (expotex-style): a 3-panel editor that edits a
 * JSON `template_data` on the page — an ordered list of schema-driven blocks.
 */
class BuilderController extends Controller
{
    protected Registry $registry;

    public function __construct()
    {
        $this->registry = new Registry();
    }

    /** Render the builder editor for a page. */
    public function editor($id)
    {
        $page    = Page::findOrFail($id);
        $catalog = $this->registry->catalog();
        $blocks  = $this->normalizeBlocks($page->template_data);

        return view('admin.builder.editor', compact('page', 'catalog', 'blocks'));
    }

    /** Persist the template (called via AJAX form post). */
    public function save(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $blocks = json_decode($request->input('template', '[]'), true);
        $blocks = is_array($blocks) ? array_values($blocks) : [];

        // keep only known block types, give every block a stable id
        $clean = [];
        foreach ($blocks as $b) {
            $type = $b['type'] ?? null;
            if (!$type || !$this->registry->get($type)) {
                continue;
            }
            $clean[] = [
                'id'    => $b['id'] ?? (string) Str::uuid(),
                'type'  => $type,
                'model' => is_array($b['model'] ?? null) ? $b['model'] : [],
            ];
        }

        $page->update(['template_data' => $clean]);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'ok', 'count' => count($clean)]);
        }

        return back()->with('success', 'Page layout saved.');
    }

    /** Render a single block to HTML for the live canvas preview (AJAX). */
    public function preview(Request $request)
    {
        $type  = $request->input('type');
        $model = $request->input('model', []);
        $model = is_string($model) ? (json_decode($model, true) ?: []) : $model;

        if (!$this->registry->get($type)) {
            return response('<div class="pb-unknown">Unknown block</div>');
        }

        return response($this->renderBlock($type, $model));
    }

    /** Upload an image from the builder and return its public path (AJAX). */
    public function upload(Request $request)
    {
        $request->validate(['file' => 'required|image|max:8192']);

        $path = \App\Support\ImageUploader::store($request->file('file'), 'image/builder');

        return response()->json(['path' => $path, 'url' => asset($path)]);
    }

    /** Shared: render one block's frontend partial safely. */
    public static function renderBlock(string $type, array $model): string
    {
        $view = 'frontend.blocks.' . $type;
        if (!view()->exists($view)) {
            return '<div class="pb-unknown">No template for block: ' . e($type) . '</div>';
        }

        return view($view, ['m' => $model])->render();
    }

    /** Ensure stored blocks are a clean list with id/type/model. */
    protected function normalizeBlocks($data): array
    {
        $data = is_array($data) ? $data : [];
        $out = [];
        foreach ($data as $b) {
            if (!isset($b['type'])) {
                continue;
            }
            $out[] = [
                'id'    => $b['id'] ?? (string) Str::uuid(),
                'type'  => $b['type'],
                'model' => $b['model'] ?? [],
            ];
        }

        return $out;
    }
}
