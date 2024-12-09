<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
        // Fetch the first record from the system_settings table
        $settings = SystemSetting::first();
        return view('settings.index', compact('settings'));
    }

    // Update the system settings
    public function update(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'pharmacy_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'currency' => 'required|string|max:10',
        ]);

        // Find the first setting record and update it
        $settings = SystemSetting::first();
        $settings->update([
            'pharmacy_name' => $request->pharmacy_name,
            'address' => $request->address,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'tax_rate' => $request->tax_rate,
            'currency' => $request->currency,
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'System settings updated successfully.');
    }
}
