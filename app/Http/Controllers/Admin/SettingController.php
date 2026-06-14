<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Show all settings grouped by their "group" column.
     */
    public function index()
    {
        $settings = Setting::orderBy('group')->get()->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Save every submitted setting value. Field names are setting keys.
     */
    public function update(Request $request)
    {
        $values = $request->input('settings', []);

        foreach ($values as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }

        // handle uploaded image settings (logo / favicon etc.) — stored as WebP
        if ($request->hasFile('uploads')) {
            foreach ($request->file('uploads') as $key => $file) {
                $path = \App\Support\ImageUploader::store($file, 'image/settings');
                Setting::where('key', $key)->update(['value' => $path]);
            }
        }

        return back()->with('success', 'Settings saved.');
    }
}
