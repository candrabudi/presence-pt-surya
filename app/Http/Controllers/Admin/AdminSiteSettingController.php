<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\SiteSetting;

class AdminSiteSettingController extends Controller
{
    public function edit()
    {
        $setting = SiteSetting::firstOrNew(); 
        return view('_admin.site_settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|max:2048',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'default_check_in' => 'required',
            'default_check_out' => 'required',
            'footer_text' => 'nullable|string',
        ]);

        $setting = SiteSetting::firstOrNew();

        if ($request->hasFile('company_logo')) {
            if ($setting->company_logo) {
                Storage::delete($setting->company_logo);
            }
            $data['company_logo'] = $request->file('company_logo')->store('logos', 'public');
        }

        $setting->fill($data)->save();

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
