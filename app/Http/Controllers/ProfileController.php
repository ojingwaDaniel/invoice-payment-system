<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Show profile settings page
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    // Update profile info (optional, for future use)
    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'paystack_secret_key' => 'nullable|string|max:255',
        ]);

        $user->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }
    /**
     * Save Paystack Public & Secret Keys for the logged-in user.
     */
    public function updatePaystackKeys(Request $request)
    {
        $request->validate([
            'paystack_public_key' => 'required|string',
            'paystack_secret_key' => 'required|string',
        ]);

        $user = auth()->user();

        $user->update([
            'paystack_public_key' => encrypt($request->paystack_public_key),
            'paystack_secret_key' => encrypt($request->paystack_secret_key),
        ]);


        return back()->with('success', '✅ Paystack API keys saved successfully!');
    }

    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
        ]);

        $user = auth()->user();

        // Delete old logo if exists
        if ($user->logo_path && \Storage::exists('public/' . $user->logo_path)) {
            \Storage::delete('public/' . $user->logo_path);
        }

        // Store new file
        $path = $request->file('logo')->store('logos', 'public');

        

       
        $user->logo_path = $path;
        $saved = $user->save();

        
        


        return back()->with('success', 'Logo updated successfully!');
    }
}
