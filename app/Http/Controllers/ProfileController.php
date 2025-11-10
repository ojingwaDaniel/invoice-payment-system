<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        // Save to your users table (make sure columns exist)
        $user->update([
            'paystack_public_key' => Hash::make($request->paystack_public_key) ,
            'paystack_secret_key' => Hash::make($request->paystack_secret_key) ,
        ]);

        return back()->with('success', '✅ Paystack API keys saved successfully!');
    }
}
