<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                continue;
            }
            Setting::set($key, $value);
        }

        if ($request->hasFile('logo_path')) {
            $path = $request->file('logo_path')->store('settings', 'public');
            Setting::set('logo_path', $path);
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
