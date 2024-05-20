<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();
        $data = $request->all();

        if ($request->hasFile('company_logo')) {
            $image = $request->file('company_logo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $name);
    
            // Set the company_logo_path in the data array
            $data['company_logo_path'] = $name;
        }

        // Check if setting is empty
        if (blank($setting)) {
            Setting::create($data);
        } else {
            $setting->update($data);
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

}
