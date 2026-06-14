<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::withCount('items')->get();

        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string|max:50|unique:tbl_menu,location',
        ]);

        Menu::create([
            'name'     => $request->name,
            'location' => $request->location,
            'status'   => $request->boolean('status'),
        ]);

        return redirect('/admin/menus')->with('success', 'Menu created.');
    }

    public function edit($id)
    {
        $menu  = Menu::with('rootItems')->findOrFail($id);
        $pages = Page::where('status', 1)->orderBy('title')->get();
        // flat list of items for the "parent" dropdown
        $allItems = $menu->items()->get();

        return view('admin.menus.edit', compact('menu', 'pages', 'allItems'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $request->validate([
            'name'     => 'required|string|max:255',
            'location' => 'required|string|max:50|unique:tbl_menu,location,' . $menu->id,
        ]);

        $menu->update([
            'name'     => $request->name,
            'location' => $request->location,
            'status'   => $request->boolean('status'),
        ]);

        return back()->with('success', 'Menu updated.');
    }

    public function destroy($id)
    {
        Menu::findOrFail($id)->delete();

        return redirect('/admin/menus')->with('success', 'Menu deleted.');
    }

    /* ---------------- Menu items (nested) ---------------- */

    public function storeItem(Request $request, $menuId)
    {
        $menu = Menu::findOrFail($menuId);
        $request->validate([
            'title'     => 'required|string|max:255',
            'link_type' => 'required|in:custom,page',
        ]);

        $menu->items()->create([
            'parent_id'  => $request->parent_id ?: null,
            'title'      => $request->title,
            'link_type'  => $request->link_type,
            'url'        => $request->link_type === 'custom' ? $request->url : null,
            'page_id'    => $request->link_type === 'page' ? $request->page_id : null,
            'icon'       => $request->icon,
            'target'     => $request->target ?: '_self',
            'sort_order' => (int) $request->sort_order,
            'status'     => $request->boolean('status', true),
        ]);

        return back()->with('success', 'Menu item added.');
    }

    public function updateItem(Request $request, $itemId)
    {
        $item = MenuItem::findOrFail($itemId);
        $request->validate(['title' => 'required|string|max:255']);

        $item->update([
            'parent_id'  => ($request->parent_id && $request->parent_id != $item->id) ? $request->parent_id : null,
            'title'      => $request->title,
            'link_type'  => $request->link_type,
            'url'        => $request->link_type === 'custom' ? $request->url : null,
            'page_id'    => $request->link_type === 'page' ? $request->page_id : null,
            'icon'       => $request->icon,
            'target'     => $request->target ?: '_self',
            'sort_order' => (int) $request->sort_order,
            'status'     => $request->boolean('status'),
        ]);

        return back()->with('success', 'Menu item updated.');
    }

    public function destroyItem($itemId)
    {
        MenuItem::findOrFail($itemId)->delete();

        return back()->with('success', 'Menu item removed.');
    }

    /**
     * Persist drag-and-drop ordering / nesting from the menu builder.
     * Receives a JSON tree of { id, children[] } and writes parent_id + sort_order.
     */
    public function reorder(Request $request, $menuId)
    {
        $menu = Menu::findOrFail($menuId);
        $tree = json_decode($request->input('tree', '[]'), true) ?: [];

        $this->saveTree($menu, $tree, null);

        return response()->json(['status' => 'ok']);
    }

    private function saveTree(Menu $menu, array $nodes, $parentId)
    {
        foreach ($nodes as $order => $node) {
            if (empty($node['id'])) {
                continue;
            }

            $item = MenuItem::where('menu_id', $menu->id)->find($node['id']);
            if ($item) {
                $item->update([
                    'parent_id'  => $parentId,
                    'sort_order' => $order + 1,
                ]);
            }

            if (!empty($node['children'])) {
                $this->saveTree($menu, $node['children'], $item ? $item->id : null);
            }
        }
    }
}
