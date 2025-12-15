<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'cod_enabled' => Setting::get('cod_enabled', '1'),
            'cod_min_order' => Setting::get('cod_min_order', '0'),
            'cod_max_order' => Setting::get('cod_max_order', ''),
            'free_shipping_min' => Setting::get('free_shipping_min', '499'),
            'shipping_charge' => Setting::get('shipping_charge', '40'),
            'tax_percent' => Setting::get('tax_percent', '18'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'cod_min_order' => 'nullable|numeric|min:0',
            'cod_max_order' => 'nullable|numeric|min:0',
            'free_shipping_min' => 'nullable|numeric|min:0',
            'shipping_charge' => 'nullable|numeric|min:0',
            'tax_percent' => 'nullable|numeric|min:0|max:100',
        ]);

        Setting::set('cod_enabled', $request->has('cod_enabled') ? '1' : '0');
        Setting::set('cod_min_order', $request->cod_min_order ?? '0');
        Setting::set('cod_max_order', $request->cod_max_order ?? '');
        Setting::set('free_shipping_min', $request->free_shipping_min ?? '499');
        Setting::set('shipping_charge', $request->shipping_charge ?? '40');
        Setting::set('tax_percent', $request->tax_percent ?? '18');

        return back()->with('success', 'Settings updated successfully!');
    }
}
