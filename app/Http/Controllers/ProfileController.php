<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Show settings page
    public function edit()
    {
        $user = Auth::user();
        $company = $user->company;

        return view('profile.edit', compact('user', 'company'));
    }

    // Update user basic profile
    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:50',
            "address" => "required|string"
        ]);

        $user->update($data);
        $user->company->update([
            'address' => $data['address'],
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Update company Paystack keys
     */
    public function updatePaystackKeys(Request $request)
    {
        $request->validate([
            'paystack_public_key' => 'required|string',
            'paystack_secret_key' => 'required|string',
        ]);

        $company = auth()->user()->company;

        $company->update([
            'paystack_public_key' => encrypt($request->paystack_public_key),
            'paystack_secret_key' => encrypt($request->paystack_secret_key),
        ]);

        return back()->with('success', 'Paystack API keys saved successfully!');
    }

    /**
     * Upload Company Logo
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ]);

        $company = auth()->user()->company;

        // Delete old logo if exists
        if ($company->logo_path && Storage::exists('public/' . $company->logo_path)) {
            Storage::delete('public/' . $company->logo_path);
        }

        // Store new file
        $path = $request->file('logo')->store('logos', 'public');

        // Save new path
        $company->update([
            'logo_path' => $path
        ]);

        return back()->with('success', 'Company logo updated successfully!');
    }
}
