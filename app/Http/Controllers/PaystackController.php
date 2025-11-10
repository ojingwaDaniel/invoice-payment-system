<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaystackController extends Controller
{
    /**
     * Show the page for companies to connect Paystack
     */
    public function showConnectForm()
    {
        return view('paystack.connect', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Save the Paystack keys for this company
     */
    public function saveKeys(Request $request)
    {
        $request->validate([
            'paystack_public_key' => 'required|string',
            'paystack_secret_key' => 'required|string',
        ]);

        $user = Auth::user();
        $user->update([
            'paystack_public_key' => $request->paystack_public_key,
            'paystack_secret_key' => $request->paystack_secret_key,
        ]);

        return redirect()->route('dashboard')->with('success', '✅ Paystack keys saved successfully!');
    }
}
