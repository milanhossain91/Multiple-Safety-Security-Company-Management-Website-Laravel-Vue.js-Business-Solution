<?php

namespace App\Http\View\Composers;

use App\Models\Menu;
use App\Models\Setting;
use Illuminate\View\View;

/**
 * Shares the dynamic header/footer menus and global site settings with
 * every frontend view, so the design stays data-driven everywhere.
 */
class CmsComposer
{
    public function compose(View $view)
    {
        $view->with('headerMenu', $this->menu('header'));
        $view->with('footerMenu', $this->menu('footer'));
        $view->with('cms', $this->settings());
    }

    private function menu($location)
    {
        return Menu::where('location', $location)
            ->where('status', 1)
            ->with('rootItems')
            ->first();
    }

    /**
     * Flat key => value bag of all settings for easy access in views,
     * e.g. $cms['site_name'].
     */
    private function settings()
    {
        return Setting::pluck('value', 'key');
    }
}
